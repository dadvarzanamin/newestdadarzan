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

        $products       = Product::orderBy('id' , 'DESC')->get();
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();

        return view('site.pages.index')->with(compact('menus', 'thispage', 'submenus' , 'products' , 'emploees'));
    }

    public function contract(Request $request)
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

        $contracts       = Product::where('product_type' , 'contract')->whereStatus(4)->orderBy('id' , 'DESC')->get();

        return view('site.pages.contracts')->with(compact('menus', 'thispage', 'submenus' , 'contracts'));
    }

    public function departmandaavi(Request $request)
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

        $contracts      = content::where('menu_id' , 61)->where('slug' , $thispage->slug)->first();

        return view('site.pages.single-department')->with(compact('menus', 'thispage', 'submenus' , 'contracts'));
    }

    public function departmangharardad(Request $request)
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

        $contracts      = content::where('menu_id' , 62)->where('slug' , $thispage->slug)->first();

        return view('site.pages.single-department')->with(compact('menus', 'thispage', 'submenus' , 'contracts'));
    }

    public function departmanamoozesh(Request $request)
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

        //$contracts      = content::where('menu_id' , 62)->where('slug' , $thispage->slug)->first();

        $workshops       = Product::orderBy('id' , 'DESC')->get();


        return view('site.pages.workshops')->with(compact('menus', 'thispage', 'submenus' , 'workshops'));
    }

    public function service(Request $request)
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

        $services      = content::where('menu_id' , 64)->where('slug' , $thispage->slug)->whereStatus(4)->first();

        return view('site.pages.single-service')->with(compact('menus', 'thispage', 'submenus' , 'services'));
    }

    public function akhbar(Request $request)
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

        $posts      = content::where('menu_id' , 65)->whereStatus(4)->orderBy('id' , 'DESC')->get();


        return view('site.pages.posts')->with(compact('menus', 'thispage', 'submenus' , 'posts'));
    }

    public function about(Request $request)
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

        return view('site.pages.about')->with(compact('menus', 'thispage', 'submenus'));
    }

    public function contact(Request $request)
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

        return view('site.pages.about')->with(compact('menus', 'thispage', 'submenus'));
    }

    public function privacy(Request $request)
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

        return view('site.pages.privacy')->with(compact('menus', 'thispage', 'submenus'));
    }

    public function term(Request $request)
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

        return view('site.pages.term')->with(compact('menus', 'thispage', 'submenus'));
    }

    public function resume(Request $request)
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
        $emploees       = Emploee::whereStatus(4)->orderBy('priority')->get();

        return view('site.pages.team')->with(compact('menus', 'thispage', 'submenus' , 'emploees'));
    }

    public function questionlist(Request $request)
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
        $questionlists  = DB::table('questionlists')->whereStatus(4)->orderBy('id')->get();

        return view('site.pages.faq')->with(compact('menus', 'thispage', 'submenus' , 'questionlists'));
    }





}
