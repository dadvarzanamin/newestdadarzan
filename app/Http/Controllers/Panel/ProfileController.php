<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Commitment;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\MediaFile;
use App\Models\Minute;
use App\Models\Offer;
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

        $invoices = Invoice::where('user_id', Auth::id())
            ->whereNull('price_status')
            ->get();

        $result = [];

        foreach ($invoices as $invoice) {

            $offer = Offer::where('product_id', $invoice->product_id)
                ->where('status', 4)
                ->where('offercode', $request->discountcode)
                ->where(function ($q) {
                    $q->whereNull('user_offer')
                        ->orWhere('user_offer', Auth::id());
                })
                ->first();

            $final = $invoice->price;

            if ($offer) {
                if ($offer->percentage) {
                    $final -= ($invoice->price * $offer->percentage) / 100;
                } elseif ($offer->discount) {
                    $final -= $offer->discount;
                }
            }

            $invoice->update([
                'final_price' => max($final, 0)
            ]);

            $result[] = [
                'invoice_id' => $invoice->id,
                'final_price' => (int)$invoice->final_price
            ];
        }

        return response()->json([
            'isSuccess' => true,
            'items' => $result
        ]);

    }

}
