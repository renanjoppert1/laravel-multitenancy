<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// domínio principal
Route::domain(env('MAIN_DOMAIN', 'master.guiador.digital'))->group(function () {

    Route::apiResource('/empresas', 'Master\CompanyController');
});

// subdomínios
Route::domain('{account}.' . env('APP_URL_BASE'))->group(function () {
    Route::get('/', function ($account){
        echo 'Oi ' . $account;
    });
});
