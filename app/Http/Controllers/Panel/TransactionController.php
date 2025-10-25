<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت تراکنش',
            'list'    => 'لیست تراکنش',
            'add'     => 'افزودن تراکنش',
            'create'  => 'ایجاد تراکنش',
            'enter'   => 'ورود تراکنش',
            'edit'    => 'ویرایش تراکنش',
            'delete'  => 'حذف تراکنش',
        ];

        if ($request->ajax()) {
            $data = DB::table('wallet_transactions')
                ->leftjoin('wallets' , 'wallets.id' , '=' , 'wallet_transactions.wallet_id')
                ->leftjoin('users'   , 'users.id'   , '=' , 'wallet_transactions.user_id')
                ->select('wallet_transactions.id' ,'users.name', 'wallet_transactions.type','wallet_transactions.amount' , 'wallet_transactions.description', 'wallet_transactions.status')
                ->get();

            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('name', function ($data) {
                    return ($data->name);
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
        return view('panel.transaction')->with(compact(['thispage']));
    }
}
