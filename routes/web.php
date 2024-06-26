<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenterCareer\TemplatesController;
use App\Http\Controllers\Direct\DirectController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\Insertcontroller;
use App\Http\Controllers\Student\StudentReport;
use App\Http\Controllers\Student\ControllerStudentOtchet;
use App\Http\Controllers\Teacher\TeacherSetudentOtchet;
use App\Http\Controllers\Teacher\TeacherSetudentRequest;
use App\Models\GroupScore;
use App\Models\Teachers;
use App\Models\TeacherScore;
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

// Route::get('/test', function (Request $request) {
//     // preg_match('#(\S+)\(\d\)#', 'ИСТб-20-1,ИСТб-20-2,ИСТб-20-3(6)', $arr);
//     // preg_match_all('#(\W+-\d+-\d+)(,|\()#', 'ИСТб-20-1,ИСТб-20-2,ИСТб-20-3(6)', $arr);
//     // preg_match_all('#(\W+-\d+)-(\d+)#', $arr[1][0], $arr1);
//     // dd($arr1);
//     // return view('student.student_report', [
//     //                                         'disabled' => "",
//     //                                         'checked' => "checked",
//     //                                         'displayNone' => 'style="display: none;"', 
//     //                                         'teachers' => [['id' => 1, 'fio' => "Пилипенко", 'work_load' => 1]], 
//     //                                         'companies' => [['id' => 1, 'name' => "Компания"]],
//     //                                         'student_request' => ['theme' => 'Тема_моя'],
//     //                                         'student_practic' => ['theme' => 'Тема_моя']
//     // ]);
//     // return ExcelController::work_load_teacher();
//     // $group = "ИСТб-20-1";
//     // $teacher = " Аршинский В.Л.";
//     // // $teachers = GroupScore::where('group_id', $group)->with('teachers')->get();
//     // $groups = TeacherScore::where('teacher_id', $teacher)->with('groups')->get();
//     // dd($groups);
//     return view('test');
// });
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
//     return ExcelController::work_load_teacher($request);
// });


Route::get('/', function (Request $request) {
    // return AuthController::check_auth();
    return redirect('/out');
});
Route::get('/in', function (Request $request) {
    // return AuthController::check_auth();
    return view('goest');
})->name('login');
Route::get('/bitrix', function (Request $request) {
    return AuthController::campus_auth($request);
});
Route::get('/logout', function () {
    AuthController::logout();
    return redirect('/');
})->name('logout');

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/home', function (Request $request) {
            return view('admin.admin');
        });
    });

    Route::middleware('role:admin')->group(function () {
        Route::post('/insert', function (Request $request) {
            return Insertcontroller::post($request);
        });
    });

    Route::prefix('student')->middleware('role:student,admin')->group(function () {
        Route::get('/', function (Request $request) {
            return redirect('/student/practika');//view('student.student');
        });
        Route::get('/practika', function (Request $request) {
            return StudentReport::get($request);
        });
        Route::post('/practika', function (Request $request) {
            return StudentReport::post($request);
        });
        Route::get('/otchet', function (Request $request) {
            return ControllerStudentOtchet::get($request);
        });
        Route::post('/otchet', function (Request $request) {
            return ControllerStudentOtchet::post($request);
        });
    });

    Route::prefix('teacher')->middleware('role:teacher,rop,admin')->group(function () {
        Route::get('/', function (Request $request) {
            return redirect('/teacher/stud_practika');//view('teacher.teacher');
        });
        Route::get('/stud_practika', function (Request $request) {
            return TeacherSetudentRequest::get($request);
        });
        Route::post('/stud_practika', function (Request $request) {
            return TeacherSetudentRequest::post($request);
        });
        Route::get('/stud_otchet', function (Request $request) {
            return TeacherSetudentOtchet::get($request);
        });
        Route::post('/stud_otchet', function (Request $request) {
            return TeacherSetudentOtchet::post($request);
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

    Route::prefix('direct')->middleware('role:direct,teacher,admin')->group(function () {
        Route::get('/shablon_prikazy', function (Request $request) {
            return DirectController::index();
        });
        Route::post('/shablon_prikazy', function (Request $request) {
            return DirectController::post($request);
        });
        Route::post('/twl', function (Request $request) {
            return ExcelController::work_load_teacher($request);
        });
    });

});

Route::get('/admin', function (Request $request) {
    return view('admin.login');
});
Route::post('/admin', function (Request $request) {
    return AdminController::login($request);
});
