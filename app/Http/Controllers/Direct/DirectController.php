<?php

namespace App\Http\Controllers\Direct;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupScore;
use App\Models\Stream;
use App\Models\Teachers;
use App\Models\TeacherScore;
use Illuminate\Http\Request;

class DirectController extends Controller
{
    public static function get()
    {
        $stream = Stream::where('name', "ИСТб-20")->get()->first();
        $group = Group::where([['stream_id', '=', $stream->id], ['group_number', '=', 1]])->get()->first();
        $teacher = Teachers::where('fio','like', "%Аршинский%")->get()->first();
        $teachers = GroupScore::where('group_id', $group->id)->with('teachers')->get();
        dump($teachers);
        $groups = TeacherScore::where('teacher_id', $teacher->id)->with('groups')->get();
        dd($groups);
        return view('direct.direct');
    }
}
