<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\IndexController;

    Route::post('v1/login'              , [App\Http\Controllers\Api\V1\UserController::class    , 'login']);
    Route::post('v1/register'           , [App\Http\Controllers\Api\V1\UserController::class    , 'register']);
    Route::get('v1/register'            , [App\Http\Controllers\Api\V1\UserController::class    , 'getregister']);
    Route::post('v1/token'              , [App\Http\Controllers\Api\V1\UserController::class    , 'token']);
    Route::post('v1/remember'           , [App\Http\Controllers\Api\V1\UserController::class    , 'remember']);
    Route::GET('v1/latest_version'      , [App\Http\Controllers\Api\V1\IndexController::class   , 'version']);
    Route::GET('v1/getstate'            , [App\Http\Controllers\Api\V1\IndexController::class   , 'getState']);
    Route::Post('v1/getcity'            , [App\Http\Controllers\Api\V1\IndexController::class   , 'getCity']);
    Route::GET('v1/wallet/backtoapp'    , [App\Http\Controllers\Api\V1\WalletController::class  , 'callbackpay'])->name('backtoapp');
    Route::GET('v1/getcontract'         , [App\Http\Controllers\Api\V1\ProductController::class , 'getcontract']);
    Route::GET('v1/getarticle'          , [App\Http\Controllers\Api\V1\IndexController::class   , 'getarticle']);
    Route::GET('v1/workshops'           , [App\Http\Controllers\Api\V1\ProductController::class , 'workshops']);

Route::middleware('auth:api')->group(function () {

    Route::get('v1/index'               , [App\Http\Controllers\Api\V1\IndexController::class        , 'index']);
    Route::post('v1/discountcheck'      , [App\Http\Controllers\Api\V1\IndexController::class        , 'discountcheck']);
    Route::GET('v1/courts'              , [App\Http\Controllers\Api\V1\IndexController::class        , 'court']);
    Route::get('v1/getform'             , [App\Http\Controllers\Api\V1\IndexController::class        , 'getform'])              ->name('getform');

    Route::get('v1/profile'             , [App\Http\Controllers\Api\V1\UserController::class         , 'profile']);
    Route::get('v1/demands'             , [App\Http\Controllers\Api\V1\UserController::class         , 'demands']);
    Route::get('v1/laws'                , [App\Http\Controllers\Api\V1\UserController::class         , 'laws']);
    Route::post('v1/addpass'            , [App\Http\Controllers\Api\V1\UserController::class         , 'addpass']);
    Route::post('v1/addmail'            , [App\Http\Controllers\Api\V1\UserController::class         , 'addmail']);
    Route::post('v1/editprofile'        , [App\Http\Controllers\Api\V1\UserController::class         , 'editprofile']);

    Route::GET('v1/wallet/balance'      , [App\Http\Controllers\Api\V1\WalletController::class       , 'balance']);
    Route::GET('v1/wallet/transactions' , [App\Http\Controllers\Api\V1\WalletController::class       , 'transactions']);
    Route::post('v1/wallet/deposit'     , [App\Http\Controllers\Api\V1\WalletController::class       , 'deposit']);
    Route::post('v1/wallet/withdraw'    , [App\Http\Controllers\Api\V1\WalletController::class       , 'withdraw']);

    Route::post('v1/workshopsign'       , [App\Http\Controllers\Api\V1\ProductController::class      , 'workshopsign']);
    Route::post('v1/workshopinvoice'    , [App\Http\Controllers\Api\V1\ProductController::class      , 'workshopinvoice']);
    Route::post('v1/purchase_contract'  , [App\Http\Controllers\Api\V1\ProductController::class      , 'purchase_contract']);
    Route::post('v1/purchase_workshop'  , [App\Http\Controllers\Api\V1\ProductController::class      , 'purchase_workshop']);
    Route::post('v1/purchase_request'  , [App\Http\Controllers\Api\V1\ProductController::class      , 'purchase_request']);
    Route::post('v1/estelam'            , [App\Http\Controllers\Api\V1\ProductController::class      , 'estelam']);
    Route::post('v1/form'               , [App\Http\Controllers\Api\V1\ProductController::class      , 'form']);
    Route::post('v1/stepform'           , [App\Http\Controllers\Api\V1\ProductController::class      , 'stepform']);

    Route::post('v1/invoice'            , [App\Http\Controllers\Api\V1\InvoiceController::class        , 'invoice'])            ->name('invoice');
    Route::delete('v1/invoicedestroy/{id}' , [App\Http\Controllers\Api\V1\InvoiceController::class     , 'invoicedestroy'])     ->name('invoicedestroy');
    Route::get('v1/invoicetotal'        , [App\Http\Controllers\Api\V1\InvoiceController::class        , 'invoicetotal'])       ->name('invoicetotal');
    Route::get('v1/order'               , [App\Http\Controllers\Api\V1\InvoiceController::class        , 'order'])              ->name('order');
    Route::get('v1/showinvoice'         , [App\Http\Controllers\Api\V1\InvoiceController::class        , 'showinvoice'])        ->name('showinvoice');


});


   Route::middleware('auth:api')->group(function (){

    Route::post('/user/store'                       , 'UserController@store');
    Route::post('/user/update'                      , 'UserController@update');

   });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
