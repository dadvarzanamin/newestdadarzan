<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\sendmail;
use App\Models\Akhbar;
use App\Models\Article;
use App\Models\Company;
use App\Models\Consultation;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Questionlist;
use App\Models\Slide;
use App\Models\Emploee;
use App\Models\Invoice;
use App\Models\Media;
use App\Models\mega_menu;
use App\Models\Post;
use App\Models\Workshop;
use App\Models\Menu;
use App\Models\Submenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;

class IndexController extends Controller
{

    public function index(Request $request)
    {

        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->whereType('site')->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->whereType('site')->get();

        $products = Product::orderBy('id' , 'DESC')->get();
//        $companies      = Company::first();
//        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();
//        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
//        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        //$servicelawyers = Submenu::select('title', 'slug', 'menu_id', 'image')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();
        //$serviceclients = Submenu::select('title', 'slug', 'menu_id', 'image')->whereStatus(4)->whereMegamenu_id(5)->whereMenu_id(64)->get();
        //$slides         = Slide::select('id', 'file_link')->whereMenu_id($thispage['id'])->whereStatus(4)->get();
        //$currentws      = Workshop::whereStatus(4)->where('id' , '!=' , 2)->first();
        //$akhbars        = Akhbar::leftjoin('users', 'akhbars.user_id', '=', 'users.id')->
        //select('akhbars.title', 'akhbars.slug', 'akhbars.image', 'akhbars.description', 'users.name as username', 'akhbars.matn as matn', 'akhbars.updated_at')->where('akhbars.status', 4)->where('akhbars.home_show', 1)->get();

        return view('site.pages.index')->with(compact('menus', 'thispage', 'submenus' , 'products' , 'emploees'));
    }

    public function invoice(Request $request)
    {
        if(Auth::check()) {

            $existing = Invoice::where('user_id', Auth::user()->id)
                ->where('product_id', $request->input('id'))
                ->where('product_type', $request->input('type'))
                ->first();

            if ($existing) {
                return Redirect::back();
            }

            $invoice = new Invoice();
            $invoice->user_id           = Auth::user()->id;
            $invoice->product_id        = $request->input('id');
            $invoice->product_type      = $request->input('type');
            $invoice->product_price     = $request->input('price');
            $invoice->offer_discount    = $request->input('discount');
            $invoice->save();
        }else{
            return Redirect::to('login');
        }

        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority', 'mega_menu')->MenuSite()->orderBy('priority')->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug('/')->first();
        }
        $megacounts = mega_menu::selectRaw('COUNT(*) as count, menu_id')
            ->groupBy('menu_id')
            ->get()
            ->toArray();
        $megamenus = mega_menu::all();
        $submenus = Submenu::select('id', 'title', 'slug', 'menu_id', 'megamenu_id')->whereStatus(4)->get();

        $companies      = Company::first();
        $servicelawyers = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();
        $serviceclients = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(5)->whereMenu_id(64)->get();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();

        $invoices = DB::table('invoices')
            ->leftJoin('workshops', function($join) {
            $join->on('invoices.product_id', '=', 'workshops.id')
            ->where('invoices.product_type', '=', 'workshops');
            })
            ->leftJoin('contracts', function($join) {
            $join->on('invoices.product_id', '=', 'contracts.id')
            ->where('invoices.product_type', '=', 'contracts');
            })
            ->where('invoices.user_id', '=', Auth::user()->id)
            ->where('invoices.price_status', '=', null)
            ->select(
                'invoices.*',
                DB::raw("CASE
            WHEN invoices.product_type = 'workshops' THEN workshops.title
            WHEN invoices.product_type = 'contracts' THEN contracts.title
            ELSE null END as product_name")
            )
            ->get();
//dd($invoices);
        return view('Site.pages.cart')->with(compact('menus', 'thispage' , 'companies','invoices', 'customers', 'submenus', 'servicelawyers', 'serviceclients', 'megamenus', 'megacounts', 'emploees'));

    }

    public function showInvoice(Request $request)
    {

        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority', 'mega_menu')->MenuSite()->orderBy('priority')->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug('/')->first();
        }
        $megacounts = mega_menu::selectRaw('COUNT(*) as count, menu_id')
            ->groupBy('menu_id')
            ->get()
            ->toArray();
        $megamenus = mega_menu::all();
        $submenus = Submenu::select('id', 'title', 'slug', 'menu_id', 'megamenu_id')->whereStatus(4)->get();

        $companies      = Company::first();
        $servicelawyers = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();
        $serviceclients = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(5)->whereMenu_id(64)->get();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();
        $invoices = DB::table('invoices')
            ->leftJoin('workshops', function($join) {
                $join->on('invoices.product_id', '=', 'workshops.id')
                    ->where('invoices.product_type', '=', 'workshops');
            })
            ->leftJoin('contracts', function($join) {
                $join->on('invoices.product_id', '=', 'contracts.id')
                    ->where('invoices.product_type', '=', 'contracts');
            })
            ->where('invoices.user_id', '=', Auth::user()->id)
            ->where('invoices.price_status', '=', null)
            ->select(
                'invoices.*',
                DB::raw("CASE
            WHEN invoices.product_type = 'workshops' THEN workshops.title
            WHEN invoices.product_type = 'contracts' THEN contracts.title
            ELSE null END as product_name")
            )
            ->get();
        return view('Site.pages.cart')->with(compact('menus', 'thispage' , 'companies','invoices', 'customers', 'submenus', 'servicelawyers', 'serviceclients', 'megamenus', 'megacounts', 'emploees'));

    }

    public function invoicedestroy(Request $request)
    {
        $invoice = Invoice::find($request->id);

        if ($invoice) {
            $invoice->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'یافت نشد.']);
        }
    }

    public function invoicetotal()
    {
        $totalFinal = Invoice::whereUser_id(Auth::user()->id)
->wherePrice_status(null)
            ->sum(DB::raw('product_price - offer_discount'));
        return response()->json(['total' => $totalFinal]);
    }

    public function order(Request $request)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority', 'mega_menu')->MenuSite()->orderBy('priority')->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug('/')->first();
        }
        $megacounts = mega_menu::selectRaw('COUNT(*) as count, menu_id')
            ->groupBy('menu_id')
            ->get()
            ->toArray();
        $megamenus = mega_menu::all();
        $submenus = Submenu::select('id', 'title', 'slug', 'menu_id', 'megamenu_id')->whereStatus(4)->get();

        $companies      = Company::first();
        $servicelawyers = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();
        $serviceclients = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(5)->whereMenu_id(64)->get();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();
        $orders         = DB::table('invoices')
            ->leftJoin('workshops', function ($join) {
                $join->on('invoices.product_id', '=', 'workshops.id')
                    ->where('invoices.product_type', '=', 'workshops');
            })
            ->leftJoin('contracts', function ($join) {
                $join->on('invoices.product_id', '=', 'contracts.id')
                    ->where('invoices.product_type', '=', 'contracts');
            })
            ->where('invoices.user_id', Auth::user()->id)
            ->where('invoices.price_status', 4)
            ->select('invoices.*',
                DB::raw("CASE
                        WHEN invoices.product_type = 'workshops' THEN workshops.title
                        WHEN invoices.product_type = 'contracts' THEN contracts.title
                        ELSE NULL END AS product_name"),
                DB::raw("CASE
                        WHEN invoices.product_type = 'contracts' THEN contracts.file_path
                        ELSE NULL END AS file_path"),
//                DB::raw("CASE
//                        WHEN invoices.product_type = 'contracts' THEN contracts.start_date
//                        ELSE NULL END AS contract_start_date"),
//                DB::raw("CASE
//                        WHEN invoices.product_type = 'contracts' THEN contracts.end_date
//                        ELSE NULL END AS contract_end_date")
            )->get();

        //dd($orders);
        return view('Site.orders')->with(compact('menus', 'thispage' ,'orders' ,'companies', 'customers', 'submenus', 'servicelawyers', 'serviceclients', 'megamenus', 'megacounts', 'emploees'));

    }

    public function about(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $emploees           = Emploee::whereStatus(4)->orderBy('priority')->get();
        $customers          = Customer::select('name' , 'image')->whereStatus(4)->whereHome_show(1)->get();
        return view('site.pages.about')
            ->with(compact('menus','thispage' , 'companies' ,'emploees' , 'customers' , 'submenus'));
    }

    public function resume(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $emploees           = Emploee::whereStatus(4)->orderBy('priority')->get();
        $customers          = Customer::select('name' , 'image')->whereStatus(4)->whereHome_show(1)->get();
        return view('site.pages.team')
            ->with(compact('menus','thispage' , 'companies' ,'emploees' , 'customers' , 'submenus'));
    }

    public function emploeeresume(Request $request , $name){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $emploees           = Emploee::whereSlug($name)->first();
        return view('Site.pages.single-team')
            ->with(compact('menus','thispage' , 'companies' ,'emploees' , 'submenus'));
    }

    public function questionlist(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $questionlists      = Questionlist::Filter()->paginate(25);

        if ($request->ajax()) {
            return response()->json(['data' => $questionlists]);
        }

        return view('site.pages.faq')
            ->with(compact('menus','thispage' , 'companies' , 'customers' , 'submenus' , 'questionlists'));
    }

    public function akhbar(Request $request)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $akhbars = Akhbar::leftjoin('users', 'akhbars.user_id', '=', 'users.id')->
        select('akhbars.title', 'akhbars.slug', 'akhbars.image', 'akhbars.description', 'users.name as username', 'akhbars.updated_at')->where('akhbars.status', 4)->get();

        return view('site.pages.akhbar')->with(compact('menus', 'thispage', 'companies', 'customers', 'submenus', 'akhbars'));

    }

    public function singleakhbar(Request $request , $slug)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $akhbars = Akhbar::leftjoin('users', 'akhbars.user_id', '=', 'users.id')->
        select('akhbars.title', 'akhbars.image', 'akhbars.description', 'users.name as username', 'akhbars.updated_at', 'akhbars.keyword')->where('akhbars.status', 4)->where('akhbars.slug', $slug)->first();

        return view('Site.singleakhbar')->with(compact('menus', 'thispage', 'companies', 'customers', 'submenus', 'akhbars'));
    }

    public function contact(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $customers          = Customer::select('name' , 'image')->whereStatus(4)->whereHome_show(1)->get();
        return view('site.pages.contact')
            ->with(compact('menus','thispage' , 'companies' , 'customers' , 'submenus'));
    }

    public function customer(){
        $menus              = Menu::select('id' , 'title' , 'slug' , 'submenu' , 'priority')->MenuSite()->orderBy('priority')->get();
        $logos              = Company::select('title' , 'file_link')->first();
        $submenus           = Submenu::select('title' , 'slug' , 'menu_id')->whereStatus(4)->get();
        $slides             = Slide::select('title1' , 'file_link')->whereMenu_id(7)->whereStatus(4)->first();
        $customers          = Customer::whereStatus(4)->orderBy('priority')->get();
        $servicelawyers = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();

        return view('Site.customer')
            ->with(compact('menus'))
            ->with(compact('customers'))
            ->with(compact('logos'))
            ->with(compact('slides'))
            ->with(compact('submenus'))
            ->with(compact('servicelawyers'));
    }

    public function departmandaavi(Request $request){

        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $services           = Submenu::select('id','title' , 'slug' , 'menu_id' , 'keyword', 'description')->whereSlug($url[1])->first();
        $medias             = Media::select('aparat','title' , 'file_link' , 'cover')->whereStatus(4)->whereSubmenu_id($services->id)->get();
        $customers          = Customer::select('name' , 'image')->whereStatus(4)->whereHome_show(1)->get();

        return view('site.pages.single-service')->with(compact('menus','thispage', 'companies','medias' , 'customers' , 'submenus' , 'services'));

    }

    public function departmanamoozesh(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $services           = Submenu::select('id','title' , 'slug' , 'menu_id' , 'keyword', 'description')->whereSlug($url[1])->first();
        $medias             = Media::select('aparat','title' , 'file_link' , 'cover')->whereStatus(4)->whereSubmenu_id($services->id)->get();
        $workshops          = Workshop::where('id' , '!=' , 2)->get();


        return view('site.pages.workshops')->with(compact('menus','thispage','workshops' ,'medias'  , 'submenus' , 'services'));

    }

    public function singleworkshop(Request $request , $slug)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
//      $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $singleworkshops = Workshop::whereSlug($slug)->first();
        $services           = Submenu::select('id','title' , 'slug' , 'menu_id' , 'keyword', 'description')->whereSlug($url[1])->first();
        $medias             = Media::select('aparat','title' , 'file_link' , 'cover')->whereStatus(4)->whereSubmenu_id($services->id)->get();

        return view('site.pages.single-workshop')->with(compact('menus', 'thispage', 'companies','medias' , 'customers', 'submenus', 'singleworkshops'));
    }

    public function departmangharardad(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $services           = Submenu::select('id','title' , 'slug' , 'menu_id' , 'keyword', 'description')->whereSlug($url[1])->first();
        $medias             = Media::select('aparat','title' , 'file_link' , 'cover')->whereStatus(4)->whereSubmenu_id($services->id)->get();

        return view('site.pages.single-service')->with(compact('menus','thispage' , 'medias' ,'companies' , 'submenus' , 'services'));

    }

    public function service(Request $request){

        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $services           = Submenu::select('id','title' , 'slug' , 'menu_id', 'keyword', 'description')->whereSlug($url[1])->first();
        $customers          = Customer::select('name' , 'image')->whereStatus(4)->whereHome_show(1)->get();
        $medias             = Media::select('aparat','title' , 'file_link' , 'cover')->whereStatus(4)->whereSubmenu_id($services->id)->get();

        return view('site.pages.single-service')->with(compact('menus','thispage' ,'medias', 'companies'  , 'customers' , 'submenus' , 'services'));

    }

    public function post(Request $request)
        {
            $url = $request->segments();
            $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
            if (count($url) == 1) {
                $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
            } elseif (count($url) > 1) {
                $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
            }elseif (count($url) == 0) {
                $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
            }
            $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
            $companies      = Company::first();
            $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
            $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $posts          = Post::whereStatus(4)->get();

        return view('site.pages.posts')->with(compact('menus','thispage' , 'companies' , 'customers' ,'posts' ,  'submenus'));

    }

    public function singlepost(Request $request , $slug)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $posts          = Post::leftjoin('users', 'posts.user_id', '=', 'posts.id')->
        select('posts.title', 'posts.image', 'posts.description', 'posts.file' ,'posts.aparat' ,  'users.name as username', 'posts.updated_at', 'posts.keyword')->where('posts.status', 4)->where('posts.slug', $slug)->first();

        return view('site.pages.single-post')->with(compact('menus', 'thispage', 'companies', 'customers', 'submenus', 'posts'));
    }

    public function term(Request $request)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        return view('site.pages.term')->with(compact('menus', 'thispage', 'companies', 'submenus'));
    }

    public function privacy(Request $request)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        return view('site.pages.privacy')->with(compact('menus', 'thispage', 'companies', 'submenus'));
    }

    public function Consultationrequest(Request $request){
        try {
            $request->validate([
                'name'      => 'required',
                'phone'     => 'required',
                'submenu_'  => 'required',
                'captcha'   => 'required|captcha'
            ]);

            $consultations = new Consultation();
            $consultations->name        = $request->input('name');
            $consultations->phone       = $request->input('phone');
            $consultations->submenu     = $request->input('submenu_');
            $consultations->description = $request->input('description');

            $result = $consultations->save();
            if ($result == true) {
                $success = true;
                $flag = 'success';
                $subject = 'ارسال موفق';
                $message = 'پیام شما با موفقیت ثبت شد';
            } else {
                $success = false;
                $flag = 'error';
                $subject = 'عملیات نا موفق';
                $message = 'پیام ثبت نشد، لطفا مجددا تلاش نمایید';
            }
            return response()->json(['success' => $success, 'subject' => $subject, 'flag' => $flag, 'message' => $message]);

        }catch (ValidationException  $e) {
            $success = false;
            $flag = 'error';
            $subject = 'خطا در ارتباط با سرور';
            //$message = strchr($e);
            $message = 'اطلاعات ثبت نشد،لطفا بعدا مجدد تلاش نمایید ';
            return response()->json(['errors' => $e->errors()], 422);

        }

    }

    public function reloadCaptcha(){
        return response()->json(['captcha'=> captcha_img('math')]);
    }

    public function getcategory(Request $request){

            if($request->input('id') == 1) {
                $servicelawyers = Submenu::select('id','title')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();
            }elseif($request->input('id') == 2) {
                $servicelawyers = Submenu::select('id','title')->whereStatus(4)->whereMegamenu_id(5)->whereMenu_id(64)->get();
            }

        $output = [];

        foreach($servicelawyers as $servicelawyer )
        {
            $output[$servicelawyer->id] = $servicelawyer->title;
        }

        return $output;
    }

    public function setclass(){

    }

    public function partnerResume(Request $request)
    {
        $url = $request->segments();
        $menus        = Menu::select('id' , 'title' , 'slug' , 'submenu' , 'priority' , 'mega_menu')->MenuSite()->orderBy('priority')->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug('/')->first();
        }
        $megacounts = mega_menu::selectRaw('COUNT(*) as count, menu_id')
            ->groupBy('menu_id')
            ->get()
            ->toArray();
        $servicelawyers = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();
        $megamenus          = mega_menu::all();
        $submenus           = Submenu::select('title' , 'slug' , 'menu_id' , 'megamenu_id')->whereStatus(4)->get();
        $companies          = Company::first();
//        $services           = Submenu::select('title' , 'slug' , 'menu_id' , 'image', 'keyword', 'description')->whereSlug($url[1])->first();
        $slides             = Slide::select('id', 'file_link')->whereMenu_id($thispage['id'])->whereStatus(4)->first();
        $customers          = Customer::select('name' , 'image')->whereStatus(4)->whereHome_show(1)->get();
        $posts          = Post::whereStatus(4)->get();

        return view('Site.pages.single-team')->with(compact('menus','thispage' , 'companies' , 'slides' , 'customers' ,'posts' ,  'submenus' , 'megacounts' , 'megamenus' , 'servicelawyers'));

    }

    public function contract(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();
        $posts          = Post::whereStatus(4)->whereHome_show(1)->orderBy('id' , 'DESC')->limit(6)->get();
        $workshops      = Workshop::where('status', '<>' ,0)->where('id' , '!=' , 2)->OrderBy('id' , 'DESC')->limit(6)->get();
        $contracts = Contract::all();
        return view('site.pages.contracts')->with(compact('menus' ,'thispage'   , 'submenus' , 'companies' ,'contracts'));

    }

    public function singlecontract(Request $request , $slug)
    {
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority', 'mega_menu')->MenuSite()->orderBy('priority')->get();
        $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword', 'page_description')->MenuSite()->whereSlug($url[0])->first();
        $megacounts = mega_menu::selectRaw('COUNT(*) as count, menu_id')
            ->groupBy('menu_id')
            ->get()
            ->toArray();
        $servicelawyers = Submenu::select('title', 'slug', 'menu_id', 'image', 'megamenu_id')->whereStatus(4)->whereMegamenu_id(4)->whereMenu_id(64)->get();
        $megamenus      = mega_menu::all();
        $submenus       = Submenu::select('title', 'slug', 'menu_id', 'megamenu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $services       = Submenu::select('title', 'slug', 'menu_id', 'image')->whereStatus(4)->whereMenu_id(64)->get();
        $slides         = Slide::select('id', 'file_link')->whereMenu_id($thispage['id'])->whereStatus(4)->first();
        $customers      = Customer::select('name', 'image')->whereStatus(4)->whereHome_show(1)->get();
        $contracts      = Contract::whereSlug($slug)->first();

        return view('Site.pages.single-contract')->with(compact('menus', 'thispage', 'companies', 'slides', 'customers', 'submenus', 'services', 'megacounts', 'megamenus', 'contracts', 'servicelawyers'));
    }

    public function article(Request $request){
        $url = $request->segments();
        $menus = Menu::select('id', 'title', 'slug', 'submenu', 'priority')->orderBy('priority')->whereStatus(4)->get();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug', 'tab_title', 'page_title', 'keyword')->whereStatus(4)->whereSlug('/')->first();
        }
        $submenus       = Submenu::select('id', 'title', 'slug', 'menu_id')->whereStatus(4)->get();
        $companies      = Company::first();
        $articles = Article::all();

        return view('Site.pages.articles')->with(compact('menus' ,'thispage' , 'submenus' , 'companies'  , 'articles'));

    }
}
