<?php

namespace App\Http\Controllers\Direct;

use App\Http\Controllers\Controller;
use App\Models\GroupScore;
use App\Models\TeacherScore;
use Illuminate\Http\Request;

class DirectController extends Controller
{
    public static function get()
    {
        $group = "ИСТб-20-1";
        $teacher = " Аршинский В.Л.";
        $teachers = GroupScore::where('group_id', $group)->with('teachers')->get();
        dump($teachers);
        $groups = TeacherScore::where('teacher_id', $teacher)->with('groups')->get();
        dd($groups);
        return view('direct.direct');
    }
}
