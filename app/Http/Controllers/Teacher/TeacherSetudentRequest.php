<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentPractic;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherSetudentRequest extends Controller
{
    public static function get(Request $request)
    {
        $user = Auth::user();
        $teacher = Teachers::where('mira_id', $user->mira_id)->get()->first();

        $student_practics = StudentPractic::where('teacher_id', '=', $teacher->id)->with('company', 'student')->get();
        return view('teacher.teacher_student_request', [
            'student_practics' => $student_practics,
            'teacher' => $teacher
        ]);
    }

    public static function post(Request $request)
    {
        if ($request->input('done')) {
            done_request_practic($request);
            return redirect('/teacher/stud_practika');
        } elseif ($request->input('remake')) {
            cancel_request_practic($request);
            return redirect('/teacher/stud_practika');
        }
    }
}

function done_request_practic($request)
{
    $user = Auth::user();
    $teacher = Teachers::where('mira_id', $user->mira_id)->get()->first();
    $stud_prac = StudentPractic::find($request->input('done'));
    if($stud_prac->status == 2){
        decriment_work_load($teacher->id);
    }   
    $stud_prac->update(['status' => 1]);
    $stud_prac->save();
}

function cancel_request_practic($request)
{
    $user = Auth::user();
    $teacher = Teachers::where('mira_id', $user->mira_id)->get()->first();
    increase_work_load($teacher->id);
    StudentPractic::find($request->input('done'))->update(['status' => 2]);
}

function increase_work_load($teacher_id)
{
    $teachers = Teachers::find($teacher_id);
    $teachers->update(['work_load' => $teachers->work_load + 1]);
}

function decriment_work_load($teacher_id)
{
    $teachers = Teachers::find($teacher_id);
    $teachers->update(['work_load' => $teachers->work_load - 1]);
}