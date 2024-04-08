<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentPractic;
use App\Models\Teachers;
use App\Models\TeacherScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherSetudentRequest extends Controller
{
    public static function get(Request $request)
    {
        $user = Auth::user();
        $teacher = Teachers::where('mira_id', $user->mira_id)->get()->first();
        $t_score = TeacherScore::where('teacher_id', '=', $teacher->id)->get();

        $arr_id_tscore = [];
        $work_load = 0;
        foreach ($t_score as $ts) {
            $arr_id_tscore[] = $ts->id;
            $work_load += $ts->score;
        }

        if ($request->get('check')) {
            $student_practics = StudentPractic::whereIn('teacher_id', $arr_id_tscore)->with('company', 'student.group.stream')->get();
        } else {
            $student_practics = StudentPractic::where('status', "<>", 2)->whereIn('teacher_id', $arr_id_tscore)->with('company', 'student.group.stream')->get();
        }


        return view('teacher.teacher_student_request', [
            'student_practics' => $student_practics,
            'teacher' => $teacher,
            'work_load' => $work_load,
            'check' => $request->get('check')
        ]);
    }

    public static function post(Request $request)
    {
        if ($request->input('done')) {
            done_request_practic($request);
        } elseif ($request->input('remake')) {
            cancel_request_practic($request);
        } elseif ($request->input('download')) {
            return Storage::download($request->input('download'));
        }
        return redirect('/teacher/stud_practika');
    }
}

function done_request_practic($request)
{
    $user = Auth::user();
    $teacher = Teachers::where('mira_id', $user->mira_id)->get()->first();
    $t_score = TeacherScore::where('teacher_id', $teacher->id)->get();
    $arr_id_tscore = [];
    foreach ($t_score as $ts) {
        $arr_id_tscore[] = $ts->id;
    }
    $stud_prac = StudentPractic::whereIn('teacher_id', $arr_id_tscore)->where('id', '=', $request->input('done'))->get()->first();
    if ($stud_prac) {
        if ($stud_prac->status == 2) {
            decriment_work_load($stud_prac->teacher_id);
        }
        $stud_prac->update(['status' => 1]);
        $stud_prac->save();
    }
}

function cancel_request_practic($request)
{
    $user = Auth::user();
    $teacher = Teachers::where('mira_id', $user->mira_id)->get()->first();
    $t_score = TeacherScore::where('teacher_id', $teacher->id)->get();
    $arr_id_tscore = [];
    foreach ($t_score as $ts) {
        $arr_id_tscore[] = $ts->id;
    }
    $stud_prac = StudentPractic::whereIn('teacher_id', $arr_id_tscore)->where([['id', '=', $request->input('remake')], ['teacher_id', '=', $teacher->id]])->get()->first();
    if ($stud_prac) {
        increase_work_load($stud_prac->teacher_id);
        $stud_prac->update(['status' => 2]);
        $stud_prac->save();
    }
}

function increase_work_load($teacher_id)
{
    $teachers = TeacherScore::find($teacher_id);
    $teachers->update(['score' => $teachers->score + 1]);
}

function decriment_work_load($teacher_id)
{
    $teachers = TeacherScore::find($teacher_id);
    $teachers->update(['score' => $teachers->score - 1]);
}
