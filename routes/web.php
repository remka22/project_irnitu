<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Insertcontroller;
use App\Http\Controllers\Student\StudentReport;
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
    return AuthController::check_auth();
});

Route::get('/test', function (Request $request) {
    return view('student.student_report', [
                                            'disabled' => "",
                                            'checked' => "checked",
                                            'displayNone' => 'style="display: none;"', 
                                            'teachers' => [['id' => 1, 'fio' => "Пилипенко", 'work_load' => 1]], 
                                            'companies' => [['id' => 1, 'name' => "Компания"]],
                                            'student_request' => ['theme' => 'Тема_моя'],
                                            'student_practic' => ['theme' => 'Тема_моя']
    ]);
});

Route::post('/insert', function (Request $request) {
    return Insertcontroller::post($request);
});

Route::get('/bitrix', function (Request $request) {
    return AuthController::campus_auth($request);
});
Route::get('/logout', function () {
    AuthController::logout();
    return redirect('/');
})->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student', function (Request $request) {
        return view('student.student');
    });
    Route::get('/student/practika', function (Request $request) {
        return StudentReport::get($request);
    });
});

Route::get('/admin', function (Request $request) {
    return view('admin.login');
});
Route::post('/admin', function (Request $request) {
    return AdminController::login($request);
});
