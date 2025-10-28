<?php

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Site')->group(function () {

    $sitemenus  = Menu::select('slug', 'class', 'submenu')->whereType('site')->whereStatus(4)->get();
    $submenus   = Submenu::select('id', 'slug', 'class')->whereType('site')->whereStatus(4)->get();

    foreach ($sitemenus as $menu) {
        if ($menu->submenu == 0) {
            Route::get($menu->slug, 'IndexController@' . $menu->class)->name($menu->slug);
        } else {
            foreach ($submenus as $submenu) {
                if ($submenu->menu_id == $menu->id) {
                    Route::get($menu->slug . '/' . $submenu->slug, 'IndexController@' . $submenu->class);
                }
            }
        }
    }

    ///Route::get('/'                    , 'IndexController@index')->name('/');

});

Route::middleware('admin')->namespace('App\Http\Controllers\Panel')->group(function () {
    Route::get('panel/'                    , 'IndexController@index')->name('dashboard');
    Route::get('panel/dashboard'           , 'IndexController@index')->name('dashboard');
    Route::resource('panel/menupanel'    , 'MenupanelController');
    Route::resource('panel/submenupanel' , 'SubmenupanelController');
    Route::resource('panel/paneluser'    , 'PaneluserController');
    Route::resource('panel/roleuser'     , 'RoleuserController');
    Route::resource('panel/file'         , 'FilemanagerController');
    Route::resource('panel/offer'        , 'OfferController');
    Route::resource('panel/content'      , 'ContentController');
    Route::resource('panel/product'      , 'ProductController');
    Route::resource('panel/siteuser'     , 'SiteuserController');
    Route::resource('panel/wallet'       , 'WalletController');
    Route::resource('panel/invoice'      , 'InvoiceController');
    Route::resource('panel/menusite'     , 'MenusiteController');
    Route::resource('panel/submenusite'  , 'SubmenusiteController');
    Route::resource('panel/transaction'  , 'TransactionController');
    Route::resource('panel/wallet'       , 'WalletController');
    Route::resource('panel/content'      , 'ContentController');
    Route::resource('panel/emploee'      , 'EmploeeController');

//    Route::resource('panel/leveluser'    , 'LeveluserController');

    Route::get('panel/profile'            , 'ProfileController@index')->name('profile');

    Route::get('panel/changepassword'      , 'ChangePasswordController@index')->name('password.change.form');
    Route::post('panel/changepassword'     , 'ChangePasswordController@change')->name('password.change.submit');

    Route::post('panel/filestatus'         , 'FilemanagerController@filestatus')->name('filestatus');
    Route::post('panel/store'              , 'FilemanagerController@store')     ->name('storemedia');
    Route::get('panel/selectfile'          , 'FilemanagerController@selectfile')->name('selectfile');
    Route::delete('panel/deletefile'       , 'FilemanagerController@deletefile')->name('deletefile');

});

Auth::routes();

Route::post('panel/fullregister'        , [App\Http\Controllers\Auth\FullRegisterController::class, 'register'])->name('fullregister');
Route::patch('panel/fullregister/{id}'  , [App\Http\Controllers\Auth\FullRegisterController::class, 'update'])->name('fullregister.update');
Route::get('logout'                     , [App\Http\Controllers\Auth\FullRegisterController::class, 'logout'])->name('logout');
Route::post('logout'                    , [App\Http\Controllers\Auth\FullRegisterController::class, 'logout'])->name('logout');
Route::get('login/{provider}'           , [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])   ->name('redirectToProvider');
Route::get('login/{provider}/callback'  , [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback'])->name('handleProviderCallback');
Route::get('otplogin'                   , [App\Http\Controllers\Auth\LoginController::class, 'otplogin'])->name('otplogin');
Route::post('gettoken'                  , [App\Http\Controllers\Auth\LoginController::class, 'gettoken'])->name('gettoken');
Route::get('sendtoken'                  , [App\Http\Controllers\Auth\LoginController::class, 'sendtoken'])->name('sendtoken');
Route::post('checktoken'                , [App\Http\Controllers\Auth\LoginController::class, 'checktoken'])->name('checktoken');


Route::get('/toggle-theme', function () {
    $theme = session('theme') === 'theme-default-dark' ? 'theme-default' : 'theme-default-dark';
    session(['theme' => $theme]);
    return back();
})->name('toggle-theme');
