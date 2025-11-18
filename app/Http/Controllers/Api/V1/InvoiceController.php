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

    public function showinvoice(Request $request)
    {
        $orders = DB::table('invoices')
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
            ->whereNull('invoices.price_status')
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
        $invoice = Invoice::find($request->id);

        if ($invoice) {
            $invoice->delete();
            return response()->json(
                ['isSuccess' => true,
                    'message' => 'مقادیر رکورد با موفقیت پاک شد',
                    'errors' => null,
                    'status_code' => 200,
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

    public function invoicetotal()
    {
        $totalFinal = Invoice::whereUser_id(Auth::user()->id)
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

    public function order(Request $request)
    {

        $orders = DB::table('invoices')
            ->leftJoin('workshops', function ($join) {
                $join->on('invoices.product_id', '=', 'workshops.id')
                    ->where('invoices.product_type', '=', 'workshop');
            })
            ->leftJoin('contracts', function ($join) {
                $join->on('invoices.product_id', '=', 'contracts.id')
                    ->where('invoices.product_type', '=', 'contract');
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
            WHEN invoices.product_type = 'contract' THEN contracts.title
            WHEN invoices.product_type = 'estelam' THEN estelams.title_fa
            ELSE NULL END AS product_name"),
                DB::raw("CASE
            WHEN invoices.product_type = 'contract' THEN contracts.file_path
            ELSE NULL END AS file_path")
            )
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
}
