<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    public function edit(string $id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
