<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Commitment;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\MediaFile;
use App\Models\Minute;
use App\Models\Project;
use App\Models\Project_step;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProfileController extends Controller
{
    public function index()
    {
        $thispage       = [
            'title'   => 'مدیریت حساب کاربری',
            'list'    => 'لیست حساب کاربری',
            'add'     => 'افزودن حساب کاربری',
            'create'  => 'ایجاد حساب کاربری',
            'enter'   => 'ورود حساب کاربری',
            'edit'    => 'ویرایش حساب کاربری',
            'delete'  => 'حذف حساب کاربری',
        ];
        $states         = State::select('id' , 'title')->whereStatus(4)->orderBy('title')->get();
        $cities         = City::select('id' , 'title')->whereStatus(4)->orderBy('title')->get();
        //$company        = Auth::user()->project;
        //$commitments    = Commitment::whereStatus(4)->get();
        //$investsteps    = DB::table('investsteps')->get();
        if(Auth::user()->project) {
            $project        = Auth::user()->project;
            $files          = MediaFile::where('project_id', $project->id)->whereRole(1)->get();
            $minutes        = Minute::where('project_id', $project->id)->get();
        }else{
            $project       = null;
            $investsteps    = null;
            $files          = null;
            $minutes        = null;
    }
        return view('panel.profile')->with(compact('thispage' , 'project'  , 'files' , 'minutes' ,'states' , 'cities'));
    }

    public function userdata(Request $request)
    {
            if ($request->ajax()) {

                $data = User::leftJoin('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.id', Auth::id())
                    ->select(
                        'users.*',
                        'roles.title_fa as role_name'
                    )
                    ->get();

                return DataTables::of($data)
                    ->addColumn('card', function ($row) {
                        return view('profile.user-card', compact('row'))->render();
                    })
                    ->rawColumns(['card'])
                    ->make(true);
            }
    }

    public function companydata(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::where('user_id' , Auth::user()->id)->get();

            return Datatables::of($data)
                ->addColumn('id', function ($data) {
                    return ($data->id);
                })
                ->addColumn('title', function ($data) {
                    return ($data->title ?? '');
                })
                ->addColumn('company_name', function ($data) {
                    return ($data->company_name ?? '');
                })
                ->addColumn('economic_code', function ($data) {
                    return ($data->economic_code ?? '');
                })
                ->addColumn('registration_number', function ($data) {
                    return ($data->registration_number ?? '');
                })
                ->addColumn('registration_date', function ($data) {
                    return ($data->registration_date ?? '');
                })
                ->addColumn('tel', function ($data) {
                    return ($data->tel ?? '');
                })
                ->addColumn('email', function ($data) {
                    return ($data->email ?? '');
                })
                ->addColumn('website', function ($data) {
                    return ($data->website ?? '');
                })
                ->addColumn('address', function ($data) {
                    return ($data->address?? '');
                })
                ->make(true);
        }
    }

    public function discountcheck(Request $request){

        $offer = Invoice::leftJoin('offers', 'offers.product_id', '=', 'invoices.product_id')
            ->select('invoices.id', 'invoices.price', 'offers.discount', 'offers.percentage')
            ->where([
                ['offers.status'         , '=', 4],
                ['invoices.user_id'      , '=', Auth::id()],
                ['invoices.product_type' , '=', $request->input('product_type')],
                ['offers.offercode'      , '=', $request->input('discountcode')],
            ])
            ->where(function ($q) {
                $q->whereNull('offers.user_offer')
                    ->orWhere('offers.user_offer', Auth::id());
            })
            ->first();

        if (!$offer) {
            return response()->json(
                ['isSuccess' => null,
                    'message' => 'کد وارد شده معتبر نمی باشد',
                    'errors' => true,
                    'status_code' => 500,
                    'result' => ''
                ], 500);
        }

        $invoice = Invoice::where('user_id', Auth::id())
            ->where('product_id', $request->input('product_id'))
            ->where('product_type', $request->input('product_type'))
            ->whereNull('price_status')
            ->first();

        if ($offer->percentage <> null){
            $invoice->offer_percentage  = $offer->percentage;
            $invoice->final_price       = $invoice->price - ($invoice->price * (intval(str_replace('%', '', $offer->percentage)))/100);
        }elseif ($offer->discount <> null) {
            $invoice->offer_discount    = $offer->discount;
            $invoice->final_price       = $invoice->price - (int)$offer->discount;
        }else {
            $invoice->final_price       = $invoice->price;
            $invoice->offer_percentage  = 0;
            $invoice->final_price       = 0;
        }
        $invoice->update();

        return response()->json(
            ['isSuccess' => true,
                'message' => 'عملیات با موفقیت انجام شد.',
                'errors' => false,
                'status_code' => 200,
                'result' => $invoice->final_price,
            ], 200);
    }

}
