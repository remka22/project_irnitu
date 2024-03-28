<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentOtchet;
use App\Models\StudentPractic;
use App\Models\Teachers;
use App\Models\TeacherScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherSetudentOtchet extends Controller
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

        $student_practics = StudentPractic::where('status', 1)->whereIn('teacher_id', $arr_id_tscore)->with('company', 'student.group.stream', 'student.otchet')->get();

        // dd($student_practics);


        return view('teacher.teacher_student_otchet', [
            'student_practics' => $student_practics,
            'teacher' => $teacher,
            'work_load' => $work_load
        ]);
    }

    public static function post(Request $request)
    {
        if ($request->input('done')) {
            done_request_otchet($request);
        } elseif ($request->input('remake')) {
            cancel_request_otchet($request);
        }elseif ($request->input('download')) {
            return Storage::download($request->input('download'));
        }
        return redirect('/teacher/stud_otchet');
    }
}

function done_request_otchet($request)
{
    $user = Auth::user();
    $stud_otchet = StudentOtchet::find($request->input('done'));
    $stud_otchet->update(['status' => 1]);
    $stud_otchet->save();
}

function cancel_request_otchet($request)
{
    $user = Auth::user();
    $stud_otchet = StudentOtchet::find($request->input('remake'));
    $stud_otchet->update(['status' => 2]);
    $stud_otchet->save();
}

