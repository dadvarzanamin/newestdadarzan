<?php

namespace App\Providers;

use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\SiteMenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('panel.*', MenuComposer::class);
        View::composer('site.*', SiteMenuComposer::class);
    }
}
