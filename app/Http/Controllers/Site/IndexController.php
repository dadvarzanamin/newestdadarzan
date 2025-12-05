<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\sendmail;
use App\Models\Akhbar;
use App\Models\Article;
use App\Models\Company;
use App\Models\Consultation;
use App\Models\Content;
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

    public function index()
    {

        $products       = Product::orderBy('id' , 'DESC')->get();
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();
        $posts          = Content::whereMenu_id(65)->whereSubmenu_id(74)->whereStatus(4)->orderBy('id' , 'DESC')->limit(6)->get();
        $customers      = Customer::whereStatus(4)->get();

        return view('site.pages.index')->with(compact('products' , 'emploees'  , 'posts' , 'customers'));
    }

    public function contract()
    {
        $contracts       = Product::where('product_type' , 'contract')->whereStatus(4)->orderBy('id' , 'DESC')->get();

        return view('site.pages.contracts')->with(compact('contracts'));
    }

    public function departmandaavi(Request $request)
    {
        $url = $request->segments();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug('/')->first();
        }

        $services      = content::where('menu_id' , 61)->where('slug' , $thispage->slug)->first();

        return view('site.pages.single-service')->with(compact( 'services'));
    }

    public function departmangharardad(Request $request)
    {
        $url = $request->segments();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug('/')->first();
        }

        $services      = content::where('menu_id' , 62)->where('slug' , $thispage->slug)->first();

        return view('site.pages.single-service')->with(compact('services'));
    }

    public function departmanamoozesh()
    {
        $workshops       = Product::orderBy('id' , 'DESC')->whereProduct_type('workshop')->get();

        return view('site.pages.workshops')->with(compact('workshops'));
    }

    public function service(Request $request)
    {
        $url = $request->segments();
        if (count($url) == 1) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug($url[1])->first();
        }elseif (count($url) == 0) {
            $thispage = Menu::select('id', 'title', 'slug')->whereStatus(4)->whereType('site')->whereSlug('/')->first();
        }

        $services      = content::where('menu_id' , 64)->where('slug' , $thispage->slug)->whereStatus(4)->first();

        return view('site.pages.single-service')->with(compact('services'));
    }

    public function akhbar()
    {
        $posts      = content::where('menu_id' , 65)->whereSubmenu_id(48)->whereStatus(4)->orderBy('id' , 'DESC')->paginate(10);

        return view('site.pages.posts')->with(compact('posts'));
    }

    public function about()
    {
        return view('site.pages.about');
    }

    public function contact()
    {
        return view('site.pages.contact');
    }

    public function privacy()
    {
        return view('site.pages.privacy');
    }

    public function term()
    {
        return view('site.pages.term');
    }

    public function resume()
    {
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();

        return view('site.pages.team')->with(compact('emploees'));
    }

    public function questionlist()
    {
        $questionlists  = DB::table('questionlists')->whereStatus(4)->orderBy('id')->get();

        return view('site.pages.faq')->with(compact('questionlists'));
    }

    public function post()
    {
        $posts      = content::where('menu_id' , 65)->whereSubmenu_id(74)->whereStatus(4)->orderBy('id' , 'DESC')->paginate(10);

        return view('site.pages.posts')->with(compact('posts'));
    }

    public function singlepost($slug)
    {
        $posts = Content::leftjoin('users', 'contents.user_id', '=', 'users.id')
            ->where('contents.slug', $slug)->first();

        return view('site.pages.single-post')->with(compact( 'posts'));
    }

    public function singleworkshop($slug)
    {
        $singleworkshops = Product::where('slug', $slug)->first();

        return view('site.pages.single-workshop')->with(compact('singleworkshops'));
    }

    public function emploeeresume($slug)
    {
        $emploees       = Emploee::whereSlug($slug)->first();

        return view('site.pages.single-team')->with(compact('emploees'));
    }

    public function singlecontract($slug)
    {
        $contract = Product::where('slug', $slug)->first();

        return view('site.pages.single-contract')->with(compact('contract'));
    }



}
