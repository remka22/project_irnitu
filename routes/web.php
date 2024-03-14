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
});

Route::get('/bitrix', function (Request $request) {
    return AuthController::campus_auth($request);
});