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
        $invoiceIds = Invoice::findOrFail($request->input('invoice_id'));
        $product     = $invoiceIds->product;
        $totalFinal  = $invoiceIds->final_price;
        $description = $product->title;

        $paidInvoices = Invoice::whereIn('id', $invoiceIds->id)
            ->where('user_id', auth()->id())
            ->where('price_status', 4)
            ->exists();

        if ($paidInvoices) {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'شما قبلا فاکتور(ها) رو پرداخت کرده اید',
                    'errors' => true,
                    'status_code' => 500,
                    'result' => $paidInvoices
                ], 500);
        }

        $user   = auth()->user();
        $wallet = $user->wallet;

        $transaction = $user->transactions()->create([
            'wallet_id'   => $wallet->id,
            'type'        => 'withdraw',
            'invoice_id'  => $invoiceIds->id,
            'amount'      => $invoiceIds->final_price,
            'description' => $product->title,
            'status'      => 'pending',
        ]);

        $paymentRequest = Toman::amount($invoiceIds->final_price)
            ->description($product->title)
            ->callback(url('https://dadvarzanamin.ir/api/v1/payment/payback'))
            ->mobile(auth()->user()->phone)
            ->email(auth()->user()->email)
            ->request();

        if ($paymentRequest->successful()) {
            WalletTransaction::whereid($transaction->id)->whereUser_id(Auth::id())->whereStatus('pending')->update([
                'transactionId' => $paymentRequest->transactionId()
            ]);
            return response()->json([
                "ok" => true,
                "message" => "لینک پرداخت ایجاد شد.",
                "response" => [
                    "url" => "https://www.zarinpal.com/pg/StartPay/" . $paymentRequest->transactionId(),
                    "authority" => $paymentRequest->transactionId(),
                ],
            ]);
        }
    }

    public function callbackpay(Request $request)
    {
        $authority  = $request->query('Authority');
        $status     = $request->query('Status');

        if ($status == "OK") {
            $wallet_transactions = WalletTransaction::select('id','amount','user_id' , 'invoice_id')
                ->where('transactionId', '=', $authority)
                ->where('status', '=', 'pending')
                ->first();

            Auth::loginUsingId($wallet_transactions->user_id);

            $payment = Toman::amount($wallet_transactions->amount)->transactionId($authority)->verify();

            if ($payment->successful()) {
                WalletTransaction::whereId($wallet_transactions->id)->whereUser_id(Auth::user()->id)->whereStatus('pending')
                    ->update(['status' => 'completed' , 'referenceId' => $payment->referenceId()]);

                Invoice::whereId($wallet_transactions->invoice_id)
                    ->where('user_id', auth()->id())
                    ->update(['price_status' => 4]);

                $invoice = Invoice::select('product_type')->whereId($wallet_transactions->invoice_id)->first();

                if ($invoice->product_type == 'workshop') {
                    try {
                        $headers = array(
                            'apikey: ilvYYKKVEXlM+BAmel+hepqt8fliIow1g0Br06rP4ko',
                            'Accept: application/json',
                            'Content-Type: application/x-www-form-urlencoded',
                            'charset: utf-8'
                        );

                        $params = http_build_query([
                            'type' => 1,
                            'param1'    => $invoice->name,
                            'param2'    => $invoice->title,
                            'param3'    => $invoice->start_date,
                            'receptor'  => auth()->phone(),
                            'template'  => 'workshop',
                        ]);

                        $url = 'http://api.ghasedaksms.com/v2/send/verify';

                        $method = 'POST';

                        $init = curl_init();
                        curl_setopt($init, CURLOPT_URL, $url);
                        curl_setopt($init, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($init, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($init, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($init, CURLOPT_CUSTOMREQUEST, $method);
                        curl_setopt($init, CURLOPT_POSTFIELDS, $params);

                        $result = curl_exec($init);
                        $code = curl_getinfo($init, CURLINFO_HTTP_CODE);
                        $curl_errno = curl_errno($init);
                        $curl_error = curl_error($init);
                        if ($curl_errno) {
                            throw new HttpException($curl_error, $curl_errno);
                        }

                    } catch (\Throwable $e) {
                        Log::error('Exception: ' . $e->getMessage());
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
                }
                return view('api.payment-success');

            } else {
                WalletTransaction::whereid($wallet_transactions->id)->whereUser_id(Auth::user()->id)->whereStatus('pending')
                    ->update(['status' => 'failed']);
                return view('api.payment-failed');
            }
        } else {
            return view('api.payment-failed');
        }
    }

}
