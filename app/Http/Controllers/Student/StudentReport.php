<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Group;
use App\Models\Profile;
use App\Models\Stream;
use App\Models\Student;
use App\Models\StudentPractic;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReport extends Controller
{
    public static function get(Request $request)
    {

        $user = Auth::user();

        if ($user->type == "admin") {
            $students = Student::all();
            if ($request->get('id')) {
                $student = Student::find($request->get('id'));
            } else {
                $student = Student::all()->first();
            }
        } else {
            $students = [];
            $student = Student::where('mira_id', $user->mira_id)->get()->first();
        }

        $group = Group::find($student->group_id);
        $stream = Stream::find($group->stream_id);
        $profile = Profile::find($stream->profile_id);
        $faculty = Faculty::find($profile->faculty_id);

        $student_practic = StudentPractic::where('student_id', $student->id)->get()->first();
        if ($student_practic) {
            $disabled = "disabled";
            $teachers = Teachers::find($student_practic->teacher_id);
            if (!$student_practic['company_id']) {
                $checked = "checked";
            } else {
                $displayNone = 'style="display: none;"';
            }
        } else {
            $student_practic = ['theme' => ''];
            $disabled = "";
            $checked = "";
            $displayNone = "";
            $companies = Company::all();
            $teachers = Teachers::where('fac_id', $faculty->id)->get();
        }


        return view('student.student_report', [
            'disabled' => $disabled,
            'checked' => $checked,
            'displayNone' => $displayNone,
            'teachers' => $teachers,
            'companies' => $companies,
            'student_practic' => $student_practic,
            // 'students' => $students,
            // 'student' => $student
        ]);
    }

    public static function post(Request $request)
    {
        // dd($request);
        if ($request->input('send')) {
            return add_request_practic($request);
        } elseif ($request->input('cancel')) {
            // cancel_request_practic($connect, $student_id);
        }
    }
}

function add_request_practic($request)
{

    if (work_load_check($request)) {
        //$path = company_file_upload();
        $user = Auth::user();
        $student = Student::where('mira_id', $user->mira_id)->get()->first();
        $stud_prac = new StudentPractic();
        $stud_prac->student_id = $student->id;
        $stud_prac->teacher_id = $request->input('teacher_id');
        $stud_prac->theme = $request->input('theme_field');
        $stud_prac->status = 0;
        $stud_prac->company_path = "No file";

        if ($request->input('cbMyCompany')) {
            $stud_prac->company_id = null;
        } else {
            $stud_prac->company_id = $request->input('company_id');
        }
        $stud_prac->save();

        return redirect('/student/practika');

    } else {
        return response([
            'message' => 'Bad workload teacher, sorry, try again'
        ], 422);
    }
}



function work_load_check($request)
{
    $work_load = Teachers::find($request->input('teacher_id'))->get()->first()->work_load;
    if ($work_load > 0) {
        return True;
    } else {
        return False;
    }
}

// function work_load_decriment($connect)
// {
//     try {
//         $resultset = $connect->query("SELECT work_load FROM Practices.teachers Where id = '" . $_POST['teacher_id'] . "'");
//     } catch (Exception $e) {
//         die("[3] - select_error");
//     }
//     $result = $resultset->Fetch()["work_load"];
//     try {
//         $connect->query("UPDATE Practices.teachers SET work_load = " . --$result . " WHERE id = " . $_POST['teacher_id']);
//     } catch (Exception $e) {
//         die("[4] - update_error");
//     }
// }


// function cancel_request_practic($connect, $student_id)
// {
//     try {
//         $student_request = $connect->query("SELECT * FROM Practices.student_practic WHERE student_id ='" . $student_id . "';")->Fetch();
//         if ($student_request) {
//             // Удаляется файл, если он существует
//             if (file_exists($student_request['company_path'])) {
//                 unlink($student_request['company_path']);
//             }

//             // Увеличиваем рабочую нагрузку учителя, если заявка была отменена
//             increase_work_load($connect, $student_request['teacher_id']);

//             $connect->query("DELETE FROM Practices.student_practic WHERE student_id ='" . $student_id . "';");

//             echo '<script type="text/javascript"> alert("Заявка успешно отменена!"); </script>';
//             header("Refresh: 0");
//         } else {
//             echo '<script type="text/javascript"> alert("Заявка не найдена!"); </script>';
//         }
//     } catch (Exception $e) {
//         die("[6] - delete_error");
//     }
// }
