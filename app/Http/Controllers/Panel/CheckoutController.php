<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\City;
use App\Models\Finance;
use App\Models\Invoice;
use App\Models\MenuPanel;
use App\Models\Product;
use App\Models\SubmenuPanel;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use function Laravel\Prompts\select;

class CheckoutController extends Controller
{
    public function index()
    {
        $thispage       = [
            'list'    => 'سبد خرید',
        ];
        $invoices = Invoice::
        leftJoin('products', function ($join) {
            $join->on('products.id', '=', 'invoices.product_id')
                ->on('products.product_type', '=', 'invoices.product_type');
        })
            ->select('invoices.id','invoices.product_type','invoices.product_price','invoices.final_price','invoices.price_status as status', 'products.title as product_name')
            ->where('invoices.user_id' , Auth::user()->id)
            ->where('invoices.price_status' , null)
            ->get();
        return view('panel.checkout')->with(compact(['thispage' , 'invoices']));
    }

}
