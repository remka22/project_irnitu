<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenterCareer\TemplatesController;
use App\Http\Controllers\Insertcontroller;
use App\Http\Controllers\Student\StudentReport;
use App\Http\Controllers\Teacher\TeacherSetudentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/test', function (Request $request) {
    // return view('student.student_report', [
    //                                         'disabled' => "",
    //                                         'checked' => "checked",
    //                                         'displayNone' => 'style="display: none;"', 
    //                                         'teachers' => [['id' => 1, 'fio' => "Пилипенко", 'work_load' => 1]], 
    //                                         'companies' => [['id' => 1, 'name' => "Компания"]],
    //                                         'student_request' => ['theme' => 'Тема_моя'],
    //                                         'student_practic' => ['theme' => 'Тема_моя']
    // ]);
    return view('test');
});
// Route::post('/test', function (Request $request) {
//     // // $path = $request->file('company_file')->store('student_doc');
//     // if ($request->input('send')){
//     //     $path = Storage::putFileAs(
//     //         'student_doc', $request->file('company_file'), "ТЕСТ.docx"
//     //     );
//     //     dd($path);
//     // }
//     // elseif ($request->input('cancel')){
//     //     Storage::delete('student_doc/ТЕСТ.docx');
//     // }

// });


Route::get('/', function (Request $request) {
    return AuthController::check_auth();
});
Route::get('/bitrix', function (Request $request) {
    return AuthController::campus_auth($request);
});
Route::get('/logout', function () {
    AuthController::logout();
    return redirect('/');
})->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/home', function (Request $request) {
        return view('admin.admin');
    });

    Route::middleware('role:admin')->group(function () {
        Route::post('/insert', function (Request $request) {
            return Insertcontroller::post($request);
        });
    });

    Route::prefix('student')->middleware('role:student,admin')->group(function () {
        Route::get('/', function (Request $request) {
            return view('student.student');
        });
        Route::get('/practika', function (Request $request) {
            return StudentReport::get($request);
        });
        Route::post('/practika', function (Request $request) {
            return StudentReport::post($request);
        });
    });

    Route::prefix('teacher')->middleware('role:teacher,rop,admin')->group(function () {
        Route::get('/', function (Request $request) {
            return view('teacher.teacher');
        });
        Route::get('/stud_practika', function (Request $request) {
            return TeacherSetudentRequest::get($request);
        });
        Route::post('/stud_practika', function (Request $request) {
            return TeacherSetudentRequest::post($request);
        });
    });

    Route::prefix('center')->middleware('role:center,teacher,admin')->group(function () {
        Route::get('/', function (Request $request) {
            return redirect('/center/shablon_prikazy');
        });
        Route::get('/shablon_prikazy', function (Request $request) {
            return TemplatesController::get($request);
        });
        Route::post('/shablon_prikazy', function (Request $request) {
            return TemplatesController::post($request);
        });
    });

    Route::middleware('role:direct,teacher,admin')->group(function () {
    });
});

Route::get('/admin', function (Request $request) {
    return view('admin.login');
});
Route::post('/admin', function (Request $request) {
    return AdminController::login($request);
});
