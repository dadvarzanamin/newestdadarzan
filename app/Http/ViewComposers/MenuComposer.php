<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Menu;
use Illuminate\Support\Facades\Gate;

class MenuComposer
{
    public function compose(View $view)
    {
        $menupanels = Menu::with(['submenus' => function ($query) {
            $query->where('status', 4)->where('type' , 'panel');
        }])
            ->where('status', 4)
            ->where('type' , 'panel')
            ->get()
            ->map(function ($menu) {
                $accessibleSubs = $menu->submenus->filter(function ($sub) {
                    return Gate::allows('can-access', [$sub->slug, 'view']);
                });

                $isActive = $accessibleSubs->contains(function ($sub) {
                    return request()->segment(2) === $sub->slug;
                });

                $menu->accessible_submenus = $accessibleSubs;
                $menu->has_access = $accessibleSubs->isNotEmpty();
                $menu->is_active = $isActive;

                return $menu;
            });

        $view->with('menupanels', $menupanels);
    }
}
