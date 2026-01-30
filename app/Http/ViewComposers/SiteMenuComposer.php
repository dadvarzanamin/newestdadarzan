<?php

namespace App\Http\ViewComposers;

use App\Models\Invoice;
use App\Models\Submenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Menu;

class SiteMenuComposer
{
    public function compose(View $view)
    {
        $url = request()->segments();

        $menus = Menu::whereStatus(4)->whereType('site')->orderBy('priority')->get();
        $submenus = Submenu::whereStatus(4)->whereType('site')->get();
        $megamenus = DB::table('mega_menus')->get();
        $megacounts = DB::table('mega_menus')
            ->selectRaw('COUNT(*) as count, menu_id')
            ->groupBy('menu_id')->get();

        if (count($url) == 1) {
            $thispage = Menu::whereSlug($url[0])->first();
        } elseif (count($url) > 1) {
            $thispage = Submenu::whereSlug($url[1])->first();
        } else {
            $thispage = Menu::whereSlug('/')->first();
        }

        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = Invoice::where('user_id', Auth::id())
                ->where(function ($q) {
                    $q->whereNull('price_status')
                      ->orWhere('price_status', '!=', 4);
                })
                ->count();
        }

        $view->with([
            'url'        => $url,
            'menus'      => $menus,
            'submenus'   => $submenus,
            'megamenus'  => $megamenus,
            'megacounts' => $megacounts,
            'thispage'   => $thispage,
            'cartCount'  => $cartCount,
        ]);
    }
}
