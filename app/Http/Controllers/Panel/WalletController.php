<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Evryn\LaravelToman\Facades\Toman;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت کیف پول',
            'list'    => 'لیست کیف پول',
            'add'     => 'افزودن کیف پول',
            'create'  => 'ایجاد کیف پول',
            'enter'   => 'ورود کیف پول',
            'edit'    => 'ویرایش کیف پول',
            'delete'  => 'حذف کیف پول',
        ];

        if ($request->ajax()) {
            $data = DB::table('wallets')
                ->leftjoin('users'   , 'users.id'   , '=' , 'wallets.user_id')
                ->select('wallets.id' ,'users.name', 'wallets.balance')
                ->get();

            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('name', function ($data) {
                    return ($data->name);
                })
                ->addColumn('balance', function ($data) {
                    return (number_format((int)$data->balance));
                })
                ->make(true);
        }
        return view('panel.wallet')->with(compact(['thispage']));
    }

    public function store(Request $request)
    {

        $amount          = $this->convertPersianToEnglishNumbers($request->input('amount'));
        $amount          = str_replace(',', '', $amount);
        $user           = auth()->user();
        $description = $request->description ?? 'شارژ کیف پول';

        if ((int)$amount <= 1000 || (int)$amount >= 1000000000) {
            return response()->json(
                ['isSuccess'     => false,
                    'message'    => 'مبلغ را صحیح وارد کنید',
                    'errors'     => null,
                    'status_code'=> 401,
                    'result'     => '',
                ], 401);
        }

        $transaction = $user->transactions()->create([
            'wallet_id'     => $user->wallet->id,
            'type'          => 'deposit',
            'amount'        => $amount,
            'description'   => $description,
            'status'        => 'pending',
        ]);

        $requiredFields = [
            'email' => 'آدرس ایمیل خالی می‌باشد',
            'phone' => 'شماره موبایل خالی می‌باشد',
        ];

        foreach ($requiredFields as $field => $message) {
            if (empty($user->$field)) {
                return Response::json([
                    'isSuccess' => null,
                    'message'   => $message,
                    'errors'    => true
                ]);
            }
        }

        $transaction = auth()->user()->transactions()->create([
            'wallet_id'   => auth()->user()->wallet->id,
            'type'        => 'deposit',
            'amount'      => $amount,
            'description' => $description,
            'status'      => 'pending',
        ]);

        $paymentRequest = Toman::amount($amount)
            ->description($description)
            ->callback(route('payment.callback'))
            ->mobile(Auth::user()->phone)
            ->email(Auth::user()->email)
            ->request();

        if ($paymentRequest->successful()) {
            WalletTransaction::whereid($transaction->id)->whereUser_id(Auth::id())->whereStatus('pending')->update([
                'transactionId' => $paymentRequest->transactionId()
            ]);
            return $paymentRequest->pay();
//            return response()->json([
//                "ok" => true,
//                "message" => "لینک پرداخت ایجاد شد.",
//                "response" => [
//                    "url" => "https://www.zarinpal.com/pg/StartPay/" . $paymentRequest->transactionId(),
//                    "authority" => $paymentRequest->transactionId(),
//                ],
//            ]);
        }
    }

    public function callbackpay(Request $request)
    {
        $authority  = $request->query('Authority');
        $status     = $request->query('Status');

        if ($status == "OK") {
            $wallet_transactions = WalletTransaction::
            select('id','amount')
                ->where('transactionId', '=', $authority)
                ->where('user_id', '=', Auth::user()->id)
                ->where('status', '=', 'pending')
                ->first();

            $payment = Toman::amount($wallet_transactions->amount)->transactionId($authority)->verify();

            if ($payment->successful()) {
                WalletTransaction::whereid($wallet_transactions->id)->whereUser_id(Auth::user()->id)->whereStatus('pending')
                    ->update(['status' => 'completed' , 'referenceId' => $payment->referenceId()]);
                $wallet = Wallet::whereUser_id(Auth::user()->id)->first();
                $amount_total = $wallet->balance + $wallet_transactions->amount;
                Wallet::whereUser_id(Auth::user()->id)->update(['balance' => $amount_total]);
                return view('partials.payment-success');
            } else {
                WalletTransaction::whereid($wallet_transactions->id)->whereUser_id(Auth::user()->id)->whereStatus('pending')
                    ->update(['status' => 'failed']);
                return view('partials.payment-failed');
            }
        } else {
            return view('partials.payment-failed');
        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('wallet_transactions')
                ->select('wallet_transactions.id' ,'wallet_transactions.referenceId' , 'wallet_transactions.type','wallet_transactions.amount' , 'wallet_transactions.description', 'wallet_transactions.status')
                ->where('wallet_transactions.user_id' , Auth::user()->id)
                ->get();

            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('referenceId', function ($data) {
                    return ($data->referenceId);
                })
                ->addColumn('type', function ($data) {
                    if ($data->type == 'deposit') {
                        return "واریز";
                    }elseif ($data->type == 'withdraw') {
                        return "برداشت";
                    }
                })
                ->addColumn('amount', function ($data) {
                    return (number_format((int)$data->amount));
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 'completed') {
                        return "تکمیل شده";
                    }elseif ($data->status == 'pending') {
                        return "منتظر مانده";
                    }elseif ($data->status == 'failed') {
                        return "شکست خورده";
                    }
                })
                ->addColumn('description', function ($data) {
                    return ($data->description);
                })
                ->make(true);
        }
    }

    public function withdraw(Request $request)
    {

        $amount     = $request->input('totalFinal');
        $invoiceIds = $request->input('invoice_ids', []);

        if (!is_array($invoiceIds)) {
            $invoiceIds = explode(',', $invoiceIds);
        }

        $user = auth()->user();
        $wallet = $user->wallet;

        if ($wallet->balance < $amount) {
            return response()->json([
                'isSuccess'    => false,
                'message'      => 'موجودی کافی نیست. در حال انتقال به صفحه پرداخت...',
                'redirect_url' => route('pay', ['user' => $user->id, 'amount' => $amount]),
            ]);

        }

        $transaction = $user->transactions()->create([
            'wallet_id'     => $wallet->id,
            'type'          => 'withdraw',
            'amount'        => $amount,
            'description'   => $request->description,
            'status'        => 'completed',
        ]);

        $wallet->decrement('balance', $amount);

        Invoice::whereIn('id', $invoiceIds)
            ->where('user_id', auth()->id())
            ->update(['price_status' => 4]);

        $invoice = Invoice::leftjoin('workshops' ,'workshops.id' , '=' , 'invoices.product_id')
            ->leftjoin('users' , 'users.id' , '=' , 'invoices.user_id')
            ->select('workshops.title' , 'workshops.date' , 'users.phone' , 'users.name' , 'invoices.product_type', 'invoices.type_use')
            ->where('invoices.id', $invoiceIds)
            ->where('invoices.user_id', auth()->id())
            ->first();

        if ($invoice->product_type == 'workshop') {
            if ($invoice->type_use == 1) {
                $type = 'حضوری';
            }elseif ($invoice->type_use == 2) {
                $type = 'آنلاین';
            }

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
                    'param3'    => $type.' در تاریخ '.$invoice->date,
                    'receptor'  => $invoice->phone,
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

                $json_result = json_decode($result);

                return response()->json(
                    ['isSuccess' => true,
                        'message' => 'مبلغ با موفقیت از کیف پول برداشت شد.',
                        'errors' => null,
                        'status_code' => 200,
                        'result' => $wallet->balance,
                        'redirect_url' => route('order'),
                    ], 200);

            } catch (\Throwable $e) {
                Log::error('Exception: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return response()->json(
            ['isSuccess'        => true,
                'message'       => 'مبلغ با موفقیت از کیف پول برداشت شد.',
                'errors'        => null,
                'status_code'   => 200,
                'result'        => $wallet->balance,
                'redirect_url' => route('order'),
            ], 200);
    }

    public function transactions()
    {
        return auth()->user()->wallet->transactions()->latest()->get();
    }

    protected function convertPersianToEnglishNumbers($string) {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        return str_replace($persianNumbers, $englishNumbers, $string);
    }
}
