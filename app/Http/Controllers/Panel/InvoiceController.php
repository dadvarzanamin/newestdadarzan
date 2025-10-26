<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
