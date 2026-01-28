<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RequestuserController extends Controller
{
    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت  درخواست ها',
            'list'    => 'لیست  درخواست ها',
            'add'     => 'افزودن  درخواست ها',
            'create'  => 'ایجاد  درخواست ها',
            'enter'   => 'ورود  درخواست ها',
            'edit'    => 'ویرایش  درخواست ها',
            'delete'  => 'حذف  درخواست ها',
        ];

        if ($request->ajax()) {
            $data = Invoice::
            leftJoin('products', function ($join) {
                $join->on('products.product_id', '=', 'invoices.product_id')
                    ->on('products.product_type', '=', 'invoices.product_type');
            })
                ->select('invoices.id','invoices.product_type','invoices.product_price','invoices.final_price','invoices.price_status as status', 'products.title as product_name')
                ->where('invoices.user_id' , Auth::user()->id)
                ->where('invoices.price_status' , 4)
                ->where('invoices.product_type' , 'workshop')
                ->get();
            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('product_name', function ($data) {
                    return ($data->product_name);
                })
                ->addColumn('product_type', function ($data) {
                    return ($data->product_type);
                })
                ->addColumn('product_price', function ($data) {
                    return (number_format((int)$data->product_price));
                })
                ->addColumn('final_price', function ($data) {
                    return (number_format((int)$data->final_price));
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == null) {
                        return "تسویه نشده";
                    } elseif ($data->status == "4") {
                        return "تسویه شده";
                    }
                })
                ->make(true);
        }
        return view('panel.requestuser')->with(compact(['thispage']));
    }
}
