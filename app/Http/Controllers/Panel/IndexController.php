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

class IndexController extends Controller
{
    public function index()
    {
        if(Auth::user()->level != 'admin'){
            return Redirect::route('profile');
        }
        $thispage       = [
            'list'    => 'داشبورد مدیریتی',
        ];

        $users = User::with('lastLogin')
            ->select('id', 'name', 'email', 'gender')
            ->get();

        $wallets = Wallet::leftjoin('users', 'wallets.user_id', '=', 'users.id')
        ->select('users.name', 'wallets.balance', 'users.gender')
        ->orderBy('wallets.balance', 'desc')
        ->get();

        return view('panel.dashboard')->with(compact(['thispage' , 'users' , 'wallets']));
    }
    public function getcities($stateId)
    {
        $cities = City::where('state_id', $stateId)->select('id', 'title')->orderBy('title')->get();

        return response()->json($cities);

    }

}
