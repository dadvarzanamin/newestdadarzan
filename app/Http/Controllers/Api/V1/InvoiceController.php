<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function invoice(Request $request)
    {
        $invoice = new Invoice();
        $invoice->user_id           = Auth::user()->id;
        $invoice->product_id        = $request->input('id');
        $invoice->product_type      = $request->input('type');
        $invoice->product_price     = $request->input('price');
        $invoice->price             = $request->input('price');
        $invoice->final_price       = $request->input('price');
        $invoice->offer_discount    = $request->input('discount');
        $invoice->save();

        $invoices = DB::table('invoices')
            ->leftJoin('workshops', function ($join) {
                $join->on('invoices.product_id', '=', 'workshops.id')
                    ->where('invoices.product_type', '=', 'workshop');
            })
            ->leftJoin('contracts', function ($join) {
                $join->on('invoices.product_id', '=', 'contracts.id')
                    ->where('invoices.product_type', '=', 'contracts');
            })
            ->leftJoin('estelams', function ($join) {
                $join->on('invoices.product_id', '=', 'estelams.id')
                    ->where('invoices.product_type', '=', 'estelam');
            })
            ->where('invoices.user_id', Auth::id())
            ->where('invoices.price_status', 4)
            ->select(
                'invoices.*',
                DB::raw("CASE
            WHEN invoices.product_type = 'workshop' THEN workshops.title
            WHEN invoices.product_type = 'contracts' THEN contracts.title
            WHEN invoices.product_type = 'estelam' THEN estelams.title_fa
            ELSE NULL END AS product_name"),
                DB::raw("CASE
            WHEN invoices.product_type = 'contracts' THEN contracts.file_path
            ELSE NULL END AS file_path")
            )
            ->get();

        return response()->json(
            ['isSuccess' => true,
                'message' => 'مقادیر رکورد دریافت شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $invoices
            ], 200);
    }

    public function setinvoice(Request $request)
    {
        $invoice = new Invoice();
        $invoice->user_id           = Auth::user()->id;
        $invoice->product_id        = $request->input('id');
        $invoice->product_type      = $request->input('product_type');
        $invoice->product_price     = $request->input('product_price');
        $invoice->save();

        return response()->json(
            ['isSuccess' => true,
                'message' => 'مقادیر رکورد دریافت شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $invoice
            ], 200);
    }

    public function order()
    {
        $orders = Invoice::query()
            ->leftJoin('products', 'products.id', '=', 'invoices.product_id')
            ->select('invoices.id','invoices.product_type','invoices.final_price as price', 'products.title', 'products.item1', 'products.product_use', 'products.start_date as date', 'products.cover','products.file_path')
            ->where('invoices.price_status', 4)
            ->where('invoices.user_id', Auth::id())
            ->get();

        if ($orders) {
            return response()->json(
                ['isSuccess' => true,
                    'message' => 'مقادیر رکورد دریافت شد',
                    'errors' => null,
                    'status_code' => 200,
                    'result' => $orders
                ], 200);
        } else {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'مقداری یافت نشد.',
                    'errors' => true,
                    'status_code' => 500,
                ], 500);
        }
    }

    public function showinvoice()
    {
        $orders = Invoice::query()
            ->leftJoin('products', 'products.id', '=', 'invoices.product_id')
            ->select('invoices.id','invoices.product_type','invoices.final_price as price', 'products.title', 'products.item1', 'products.product_use', 'products.start_date as date', 'products.cover','products.file_path')
            ->where('invoices.price_status', null)
            ->where('invoices.user_id', Auth::id())
            ->get();
        if ($orders) {
            return response()->json(
                ['isSuccess' => true,
                    'message' => 'مقادیر رکورد دریافت شد',
                    'errors' => null,
                    'status_code' => 200,
                    'result' => $orders
                ], 200);
        } else {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'مقداری یافت نشد.',
                    'errors' => true,
                    'status_code' => 500,
                ], 500);
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

    public function invoicetotal()
    {
        $totalFinal = Invoice::whereUser_id(Auth::id())
            ->wherePrice_status(null)
            ->sum(DB::raw('final_price'));

        return response()->json(
            ['isSuccess' => true,
                'message' => 'مقادیر رکورد دریافت شد',
                'errors' => null,
                'status_code' => 200,
                'result' => $totalFinal
            ], 200);
    }

}
