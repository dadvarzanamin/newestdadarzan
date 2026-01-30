<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $thispage       = [
            'title'   => 'مدیریت سفارشات',
            'list'    => 'لیست سفارشات',
            'add'     => 'افزودن سفارشات',
            'create'  => 'ایجاد سفارشات',
            'enter'   => 'ورود سفارشات',
            'edit'    => 'ویرایش سفارشات',
            'delete'  => 'حذف سفارشات',
        ];

        if ($request->ajax()) {
            $data = Invoice::
                leftjoin('users', 'users.id', '=', 'invoices.user_id')
                ->leftjoin('products', 'products.product_id', '=', 'invoices.product_id')
                ->select('invoices.id','invoices.product_type','invoices.product_price','invoices.final_price','invoices.price_status as status', 'users.name', 'products.title as product_name')
                ->get();

            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('name', function ($data) {
                    return ($data->name);
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
                        return "خالی";
                    } elseif ($data->status == "4") {
                        return "تسویه شده";
                    }
                })
                ->make(true);
        }
        return view('panel.invoice')->with(compact(['thispage']));
    }

    public function setinvoice(Request $request)
    {
        $product = Product::whereId($request->input('product_id'))->whereStatus(4)->exists();

        if ($product) {

            $invoice = new Invoice();
            $invoice->user_id = Auth::user()->id;
            $invoice->product_id = $request->input('product_id');
            $invoice->product_type = $request->input('product_type');
            $invoice->product_price = $request->input('product_price');
            $invoice->price = $request->input('product_price');
            $invoice->final_price = $request->input('product_price');
            $invoice->save();

            return response()->json(
                ['isSuccess' => true,
                    'message' => 'مقادیر رکورد دریافت شد',
                    'errors' => null,
                    'status_code' => 200,
                    'result' => $invoice
                ], 200);
        }else{
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'درخواست ناموفق خدمات غیر فعال شده است',
                    'errors' => true,
                    'status_code' => 500,
                ], 500);
        }
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::
                leftJoin('products', function ($join) {
                    $join->on('products.product_id', '=', 'invoices.product_id')
                         ->on('products.product_type', '=', 'invoices.product_type');
                })
                ->select('invoices.id','invoices.product_type','invoices.product_price','invoices.final_price','invoices.price_status as status', 'products.title as product_name')
                ->where('invoices.user_id' , Auth::user()->id)
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
    }

    public function edit(Request $request)
    {
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
    }

    public function invoicedestroy(Request $request)
    {
        $invoice = Invoice::where('id', $request->id)
            ->whereNull('price_status')
            ->first();

        if (!$invoice) {
            return response()->json([
                'isSuccess'   => false,
                'message'     => 'رکوردی یافت نشد یا قابل حذف نیست.',
                'errors'      => true,
                'status_code' => 404,
            ], 404);
        }

        $invoice->delete();

        return response()->json([
            'isSuccess'   => true,
            'message'     => 'رکورد با موفقیت حذف شد.',
            'errors'      => null,
            'status_code' => 200,
        ], 200);
    }

}
