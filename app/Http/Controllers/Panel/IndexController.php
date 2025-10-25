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

        return view('dashboard')->with(compact(['thispage' , 'users']));
    }
    public function getcities($stateId)
    {
        $cities = City::where('state_id', $stateId)->select('id', 'title')->orderBy('title')->get();

        return response()->json($cities);

    }

}
