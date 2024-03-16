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
    public static function get()
    {

        $user = Auth::user();
        $student = Student::where('mira_id', $user->mira_id)->get()->first();
        $group = Group::find($student->group_id);
        $stream = Stream::find($group->stream_id);
        $profile = Profile::find($stream->profile_id);
        $faculty = Faculty::find($profile->faculty_id);

        $student_practic = StudentPractic::where('student_id', $student->id)->get()->first();
        if ($student_practic) {
            $disabled = "disabled";
            $teacher = 'WHERE id = ' . $student['teacher_id'];
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
            'student_practic' => $student_practic
        ]);
    }

    public static function post()
    {
    }
}

