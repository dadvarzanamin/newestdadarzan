<?php

namespace App\Http\Controllers\Site;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Routing\Controller;

class CourseController extends Controller
{
    public function index(){

        $menus = Menu::all();
        $submenus = Submenu::all();

        return view('Site.course')->with(compact(['menus' , 'submenus']));
    }
}
