<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Insertcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('goest');
    //return Insertcontroller::get();
    // return AuthController::campus_auth();
    // $APP = [
    //     'ID' => 'local.65e57544bd23d6.71638042',
    //     'CODE' => 'RtRYlevERpBl4jC4AjeOO8U8sivYstMpzwGsA954fId8OCtdWR'
    // ];
    // return header('Location: https://int.istu.edu/oauth/authorize/?client_id=' . $APP['ID']);
    //return header('Location: https://job.istu.edu/bitrix');
});

Route::get('/bitrix', function (Request $request) {
    return AuthController::campus_auth($request);
});