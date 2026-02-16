<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Evryn\LaravelToman\Facades\Toman;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{
    public function product_payment(Request $request)
    {
        $invoice = Invoice::with('product')->findOrFail($request->input('invoice_id'));

        abort_if(
            $invoice->user_id !== auth()->id() || $invoice->price_status === 4,
            500,
            'شما قبلا فاکتور را پرداخت کرده‌اید'
        );

        $user   = auth()->user();
        $wallet = $user->wallet;

        $transaction = $user->transactions()->create([
            'wallet_id'   => $wallet->id,
            'type'        => 'withdraw',
            'invoice_id'  => $invoice->id,
            'amount'      => $invoice->final_price,
            'description' => $invoice->product->title,
            'status'      => 'pending',
        ]);

        $paymentRequest = Toman::amount($invoice->final_price)
            ->description($invoice->product->title)
            ->callback(url('https://dadvarzanamin.ir/api/v1/wallet/backtoapp'))
            ->mobile($user->phone)
            ->email($user->email)
            ->request();

        if (! $paymentRequest->successful()) {

            return response()->json(
                ['isSuccess' => null,
                    'message' => 'خطا',
                    'errors' => true,
                    'status_code' => 500,
                    'result' => ''
                ], 500);
        }

        $transaction->update([
            'transactionId' => $paymentRequest->transactionId(),
        ]);

        return response()->json([
            'ok'      => true,
            'message' => 'لینک پرداخت ایجاد شد.',
            'response'=> [
                'url'       => 'https://www.zarinpal.com/pg/StartPay/' . $paymentRequest->transactionId(),
                'authority' => $paymentRequest->transactionId(),
            ],
        ]);
    }

    public function callbackpay(Request $request)
    {
        if ($request->query('Status') !== 'OK') {
            return view('api.payment-failed');
        }

        $authority = $request->query('Authority');

        $transaction = WalletTransaction::where('transactionId', $authority)
            ->where('status', 'pending')
            ->firstOrFail();

        Auth::loginUsingId($transaction->user_id);

        $payment = Toman::amount($transaction->amount)
            ->transactionId($authority)
            ->verify();

        if (! $payment->successful()) {
            $transaction->update(['status' => 'failed']);
            return view('api.payment-failed');
        }

        $transaction->update([
            'status'      => 'completed',
            'referenceId'=> $payment->referenceId(),
        ]);

        $invoice = Invoice::where('id', $transaction->invoice_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $invoice->update(['price_status' => 4]);

        if ($invoice->product_type === 'workshop') {
            try {
                Http::withHeaders([
                    'apikey' => 'ilvYYKKVEXlM+BAmel+hepqt8fliIow1g0Br06rP4ko',
                    'Accept' => 'application/json',
                ])->asForm()->post('http://api.ghasedaksms.com/v2/send/verify', [
                    'type'     => 1,
                    'param1'   => $invoice->name,
                    'param2'   => $invoice->title,
                    'param3'   => $invoice->start_date,
                    'receptor' => auth()->user()->phone,
                    'template' => 'workshop',
                ]);
            } catch (\Throwable $e) {
                Log::error($e->getMessage());
            }
        }

        return view('api.payment-success');
    }

}
