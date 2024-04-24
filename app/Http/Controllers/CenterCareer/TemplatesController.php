<?php

namespace App\Http\Controllers\CenterCareer;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\StudentPractic;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplatesController extends Controller
{
  public static function get(Request $request)
  {
    $faculty = Faculty::where('id', '<>', null)->with(
      'profiles.streams_b.groups.templates',
      'profiles.streams_m.groups.templates',
      'profiles.streams_z.groups.templates'
    )->get();

    $formEducation = ["Bakalavr" => "Бакалавриат", "Magis" => "Магистратура", "Zaoch" => "Заочное обучение"];


    return view('center.templates', [
      'facultys' => $faculty,
      'formEducation' => $formEducation
    ]);
  }

  public static function post(Request $request)
  {
    if ($request->input('download')) {
      $template = Template::find($request->input('download'));
      return Storage::download($template->name);
    }
    if ($request->input('done')) {
      Template::find($request->input('done'))->update(['decanat_check' => 1]);
      return redirect('/center/shablon_prikazy');
      // $connect->query("UPDATE Practices.templates SET decanat_check = 1, comment = '' WHERE id =". $_GET['done'] .";");
    }
    if ($request->input('noShow')) {
      Template::find($request->input('noShow'))->update(['decanat_check' => 0]);
      return redirect('/center/shablon_prikazy');
      // $connect->query("UPDATE Practices.templates SET decanat_check = 0, comment = '' WHERE id =". $_GET['noShow'] .";");
    }
    if ($request->input('remake')) {
      Template::find($request->input('remake'))->update(['decanat_check' => 2, 'comment' => $request->input('comment')]);
      return redirect('/center/shablon_prikazy');
      // $connect->query("UPDATE Practices.templates SET decanat_check = 2, comment = '". $_GET['comment'] ."' WHERE id =". $_GET['remake'] .";");
    }
  }
}
