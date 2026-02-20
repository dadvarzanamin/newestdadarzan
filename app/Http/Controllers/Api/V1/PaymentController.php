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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{
    public function product_payment(Request $request)
    {
        $invoice = Invoice::with('product')->findOrFail($request->input('invoice_id'));

        if($invoice->user_id != auth()->id() || $invoice->price_status == 4) {

            return response()->json(
                ['isSuccess' => false,
                    'message' => 'شما قبلا این فاکتور را پرداخت کرده اید',
                    'errors' => true,
                    'status_code' => 401,
                    'result' => '',
                ], 401
            );
        }

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
            ->callback(url('https://dadvarzanamin.ir/api/v1/payment/payback'))
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
                'result_url' => route('payment_result', ['authority' => $paymentRequest->transactionId()]),
            ],
        ]);
    }

    public function callbackpay(Request $request)
    {
        $status = strtoupper((string) $request->query('Status'));
        $authority = $request->query('Authority');

        $transaction = WalletTransaction::where('transactionId', $authority)
            ->where('status', 'pending')
            ->first();

        if (! $transaction) {
            $completedTransaction = WalletTransaction::where('transactionId', $authority)
                ->where('status', 'completed')
                ->latest('id')
                ->first();

            if ($completedTransaction) {
                return view('api.payment-success', [
                    'message' => 'این پرداخت قبلا تایید شده است.',
                    'paymentDetails' => $this->buildPaymentDetails($completedTransaction, $status, 'gateway'),
                ]);
            }

            return view('api.payment-failed', [
                'message' => 'تراکنش معتبر یافت نشد یا قبلا پردازش شده است.',
                'paymentDetails' => $this->buildPaymentDetails(null, $status, 'gateway', [
                    'authority' => $authority,
                    'error' => 'تراکنش یافت نشد یا قبلا پردازش شده است',
                ]),
            ]);
        }

        if ($status !== 'OK') {
            $transaction->update(['status' => 'failed']);
            return view('api.payment-failed', [
                'message' => 'پرداخت در درگاه ناموفق یا توسط کاربر لغو شد.',
                'paymentDetails' => $this->buildPaymentDetails($transaction->fresh(), $status, 'gateway'),
            ]);
        }

        Auth::loginUsingId($transaction->user_id);

        try {
            $verifyAmount = (int) $transaction->amount;

            if ($transaction->type === 'order_payment') {
                $gatewayPay = (int) data_get($transaction->meta, 'gateway_pay', 0);
                if ($gatewayPay > 0) {
                    $verifyAmount = $gatewayPay;
                }
            }

            $payment = Toman::amount($verifyAmount)
                ->transactionId($authority)
                ->verify();

            if (! $payment->successful()) {
                $transaction->update(['status' => 'failed']);
                return view('api.payment-failed', [
                    'message' => 'تایید پرداخت از سمت درگاه انجام نشد.',
                    'paymentDetails' => $this->buildPaymentDetails($transaction->fresh(), $status, 'gateway'),
                ]);
            }
        } catch (\Throwable $e) {
            $transaction->update(['status' => 'failed']);
            Log::error('payment callback verify failed: ' . $e->getMessage());
            return view('api.payment-failed', [
                'message' => 'خطا در بررسی نتیجه پرداخت.',
                'paymentDetails' => $this->buildPaymentDetails($transaction->fresh(), $status, 'gateway', [
                    'error' => $e->getMessage(),
                ]),
            ]);
        }

        $transaction->update([
            'status'      => 'completed',
            'referenceId'=> $payment->referenceId(),
        ]);

        if (!empty($transaction->invoice_id)) {
            $invoice = Invoice::where('id', $transaction->invoice_id)
                ->where('user_id', auth()->id())
                ->first();

            if ($invoice) {
                $invoice->update(['price_status' => 4]);
            }
        }

        if (isset($invoice) && $invoice && $invoice->product_type === 'workshop') {
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

        return view('api.payment-success', [
            'message' => 'پرداخت با موفقیت انجام شد.',
            'paymentDetails' => $this->buildPaymentDetails($transaction->fresh(), $status, 'gateway'),
        ]);
    }

    public function paymentResult(Request $request)
    {
        $request->validate([
            'authority' => 'required|string',
        ]);

        $authority = $request->query('authority');

        $transaction = WalletTransaction::where('user_id', auth()->id())
            ->where('transactionId', $authority)
            ->latest('id')
            ->first();

        if (!$transaction) {
            return response()->json([
                'isSuccess' => false,
                'message' => 'تراکنشی با این شناسه یافت نشد.',
                'errors' => true,
                'status_code' => 404,
                'result' => null,
            ], 404);
        }

        return response()->json([
            'isSuccess' => true,
            'message' => 'جزئیات پرداخت دریافت شد.',
            'errors' => null,
            'status_code' => 200,
            'result' => [
                'raw' => [
                    'id' => $transaction->id,
                    'authority' => $transaction->transactionId,
                    'reference_id' => $transaction->referenceId,
                    'status' => $transaction->status,
                    'type' => $transaction->type,
                    'amount' => (int) $transaction->amount,
                    'description' => $transaction->description,
                    'created_at' => optional($transaction->created_at)->format('Y-m-d H:i:s'),
                ],
                'localized' => [
                    'authority' => $this->toFaDigits((string) $transaction->transactionId),
                    'reference_id' => $this->toFaDigits((string) $transaction->referenceId),
                    'status' => $this->mapStatusFa($transaction->status),
                    'type' => $this->mapTypeFa($transaction->type),
                    'amount' => $this->toFaDigits(number_format((int) $transaction->amount)),
                    'amount_label' => $this->toFaDigits(number_format((int) $transaction->amount)) . ' تومان',
                    'description' => $transaction->description,
                    'created_at' => $this->formatJalali($transaction->created_at),
                ],
            ],
        ]);
    }

    protected function mapStatusFa(?string $status): string
    {
        return match ($status) {
            'completed' => 'تکمیل شده',
            'pending' => 'در انتظار',
            'failed' => 'ناموفق',
            default => (string) $status,
        };
    }

    protected function mapTypeFa(?string $type): string
    {
        return match ($type) {
            'deposit' => 'واریز',
            'withdraw' => 'برداشت',
            'order_payment' => 'پرداخت سفارش',
            'wallet_usage' => 'استفاده از کیف پول',
            default => (string) $type,
        };
    }

    protected function toFaDigits(?string $value): string
    {
        return strtr((string) $value, [
            '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
            '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹',
        ]);
    }

    protected function formatJalali($date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            return $this->toFaDigits(jdate($date)->format('Y/m/d - H:i:s'));
        } catch (\Throwable $e) {
            return $this->toFaDigits((string) optional($date)->format('Y-m-d H:i:s'));
        }
    }

    protected function buildPaymentDetails(
        ?WalletTransaction $transaction,
        ?string $gatewayStatus = null,
        string $channel = 'gateway',
        array $extra = []
    ): array {
        $details = [
            'channel' => $channel,
            'gateway_status' => $gatewayStatus ?: '-',
            'amount' => $transaction?->amount,
            'status' => $transaction?->status,
            'type' => $transaction?->type,
            'description' => $transaction?->description,
            'transaction_id' => $transaction?->transactionId,
            'reference_id' => $transaction?->referenceId,
            'authority' => $transaction?->transactionId,
            'created_at' => optional($transaction?->created_at)->format('Y-m-d H:i:s'),
        ];

        return array_merge($details, $extra);
    }

}
