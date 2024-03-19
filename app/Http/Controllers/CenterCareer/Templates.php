<?php

namespace App\Http\Controllers\CenterCareer;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class Templates extends Controller
{
    public static function get(Request $request)
  {
    // $group = Group::all();
    // $stream = Stream::all();
    // $profile_b = Profile::where('id', '<>', null)->with('streams_b')->get();
    // $profile_m = Profile::where('id', '<>', null)->with('streams_m')->get();
    // $profile_z = Profile::where('id', '<>', null)->with('streams_z')->get();

    // dump($profile_b);
    // dump($profile_m);
    // dd($profile_z);
    $faculty = Faculty::where('id', '<>', null)->with('profiles.streams_b.groups', 'profiles.streams_m.groups', 'profiles.streams_z.groups')->get();
    // dd($faculty);
    $formEducation = ["Bakalavr" => "Бакалавриат", "Magis" => "Магистратура", "Zaoch" => "Заочное обучение"];




    return view('center.templates', [
      'facultys' => $faculty,
      'formEducation' => $formEducation
    ]);
  }
}
