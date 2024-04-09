<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Profile;
use App\Models\Stream;
use App\Models\Student;
use App\Models\StudentPractic;
use App\Models\student_Otchet;
use App\Models\StudentOtchet as ModelsStudentOtchet;
use App\Models\Teachers;
use Illuminate\Database\Events\ModelsPruned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class StudentOtchet extends Controller
{


    public static function get(Request $request)
    {


        // $user = (object) [
        //     'mira_id' => '3'
        // ];


        $user = Auth::user();

        // if ($user->type == "admin") {
        //     $students = Student::all();
        //     if ($request->get('id')) {
        //         $student = Student::find($request->get('id'));
        //     } else {
        //         $student = Student::all()->first();
        //     }
        // } else {
        $students = [];
        $student = Student::where('mira_id', $user->mira_id)->get()->first();


        // }
        $student_request = StudentPractic::where('student_id', $student->id)->first();
        if (!$student_request){
            return view('student.student_otchet_ban');
        }

        $teacher_practic = Teachers::find($student_request->teacher_id);
        $company_practic = Company::find($student_request->company_id);

        $name = $student->fio;
        $teacher = $teacher_practic->fio;
        $company = $company_practic->name;
        $theme = $student_request->theme;
        $group = Group::find($student->group_id);
        $stream = Stream::find($group->stream_id);
        $profile = Profile::find($stream->profile_id);
        $faculty = Faculty::find($profile->faculty_id);

        $student_otchet = ModelsStudentOtchet::where('student_id', $student->id)->get()->first();

        if ($student_otchet) {
            $disabled = "disabled";
            switch ($student_otchet->status) {
                case 0:
                    $status = 'Не проверен';
                    break;
                case 1:
                    $status = 'Принят';
                    break;
                case 2:
                    $status = 'Не принят';
                    break;
            }
        } else {

            $disabled = "";
            $status = 'Не отправлено';

        }
        $status_message = "";
        $status_color = "";
        if ($student_otchet) {

            switch ($student_otchet->status) {
                case 0:
                    $status_message = 'Ждите уведомление о проверки вашего отчета руководителем практики!';
                    $status_color = 'primary';
                    break;
                case 1:
                    $status_message = 'Руководитель принял вашу заявку!';
                    $status_color = 'success';
                    break;
                case 2:
                    $status_message = 'Преподаватель отклонил вашу заявку, для получения большей информации свяжитесь с ним.';
                    $status_color = 'danger';
                    break;

            }
        }

        return view('student.student_otchet', [
            'disabled' => $disabled,
            'teacher' => $teacher,
            'name' => $name,
            'company' => $company,
            'theme' => $theme,
            'student_otchet' => $student_otchet,
            'status' => $status,
            'status_message' => $status_message,
            'status_color' => $status_color,
            'student_practic' => $student_request,
        ]);
    }


    public static function post(Request $request)
    {
        if ($request->input('SubmitYaUrl')) {
            return add_student_otchet($request);
        } elseif ($request->input('fallSubmitYaUrl')) {
            return delete_student_otchet($request);
            // }elseif ($request->input('download')) {
            //     $student_practic = StudentPractic::where('student_id', $request->input('download'))->get()->first();
            //     return Storage::download($student_practic->company_path);
            // }
        } elseif ($request->input('download')) {
            $user = (object) [
                'mira_id' => '3'
              ];
              // $user = Auth::user();
            $student = Student::where('mira_id', $user->mira_id)->get()->first();
            $student_otchet = ModelsStudentOtchet::where('student_id', $student -> stud_id)->first();
            if ($student_otchet) {
                return Storage::download($student_otchet->link_ya);
            } else {
                return redirect()->back()->with('error', 'Отчет не найден.');
            }
        } elseif ($request->hasFile('link_ya')) {
            return add_student_otchet($request);
        } else {
            return redirect()->back()->with('error', 'Файл не был загружен.');
        }

    }
    public function uploadStudentReport(Request $request)
    {
        if ($request->hasFile('report')) { // 'report' — это имя поля в форме загрузки
            $file = $request->file('report');
            $filePath = $file->store('student_reports', 'student_reports'); 
            
        }
    }
}

function add_student_otchet($request)
{
    $user = Auth::user();
    $student = Student::where('mira_id', $user->mira_id)->get()->find();
    $directory = 'student_otchet';
    if (!Storage::exists($directory)) {
        Storage::makeDirectory($directory);
    }
    // $file = $request->file('link_ya');
    // $fileName = $file->getClientOriginalName();
    // $filePath = Storage::putFileAs($directory, $file, $fileName);
    $path = Storage::putFileAs(
        'student_otchet',
        $request->file('link_ya'),
        "отчет".$student->fio.".docx"
    );

    $student_otchet = new ModelsStudentOtchet();
    $student_otchet->student_id = $request->input('SubmitYaUrl');
    $student_otchet->link_ya = $request->input('YaUrl');
    // $student_otchet->link_ya = Storage::putFileAs(
    //     'student_doc',
    //     $request->file('company_file'),
    //     $student->fio." ".$stream->name."-".$group->group_number.".docx");
    $student_otchet->link_ya = $path;
    $student_otchet->status = 0;
    $student_otchet->save();
    return redirect('/student/otchet');

    // succesfull_insert();
}

function delete_student_otchet($request)
{

    ModelsStudentOtchet::where('id', $request->input('fallSubmitYaUrl'))->delete();
    return redirect('/student/otchet');
    // succesfull_delete();

}

// function succesfull_insert() {
// 	echo '<script type="text/javascript"> alert("Отчет отправлен!"); </script>';
// 	header("Refresh: 0");
//    }
// function succesfull_delete() {
//   	echo '<script type="text/javascript"> alert("Отправка отчета отменена!"); </script>';
// 	header("Refresh: 0");
//  }
