<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\City;
use App\Models\Finance;
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
            'list'    => 'داشبورد مدیریتی',
        ];

        return view('panel.checkout')->with(compact(['thispage']));
    }

}
