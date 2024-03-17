<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\StudentPractic;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherSetudentRequest extends Controller
{
    public static function get(Request $request){
        $user = Auth::user();
        $teacher = Teachers::where('mira_id', $user->mira_id)->get()->first();

        $student_practics = StudentPractic::where('teacher_id', $teacher->id)->with('company', 'student')->get();
        return view('teacher.teacher_student_request', [
            'student_practics' => $student_practics
        ]);
    }

    public static function post(){
        // 26281
    }
}
