<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Insertcontroller;
use App\Models\User;
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


Route::get('/', function (Request $request) {
    return view('goest');
});

Route::get('/test', function (Request $request) {
    return view('test');
});

Route::get('/insert', function (Request $request) {
    return Insertcontroller::post($request);
});

Route::get('/bitrix', function (Request $request) {
    return AuthController::campus_auth($request);
});
Route::get('/logout', function(){
    AuthController::logout();
    return redirect('/');
})->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student', function (Request $request) {
        return view('student.student');
    });
});

Route::get('/admin', function (Request $request) {
    return view('admin.login');
});
Route::post('/admin', function (Request $request) {
    return AdminController::login($request);
});