<?php

namespace App\Http\Controllers\Direct;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExcelController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Group;
use App\Models\GroupScore;
use App\Models\Stream;
use App\Models\Teachers;
use App\Models\TeacherScore;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DirectController extends Controller
{
    public static function index()
    {
        //////////////////////////////
        $name = 'Ya nichego ne ponimau';
        //////////////////////////////
        // $user = Auth::user();
        $workload = true;
        if (Storage::exists('teacher_workload/teacher_workload.xlsx')) {
            $workload = false;
        }

        $faculties = DB::table('faculty')
            ->where('id', '=', 5)->get();        //после авторизации человека из дирекции последний аргумент должен вставить id дирекции
        $streams = DB::table('streams')
            ->orderBy('streams.name')
            ->get();
        // dump($streams);
        $profiles = DB::table('profiles')->get();
        $student_practic = DB::table('student_practic')->get();

        $formEducation = ["Бакалавриат", "Магистратура"];
        $groups = DB::table('groups')->get();
        $templates = DB::table('templates')->get();
        $students = DB::table('students')->get();
        $teacher_score = DB::table('teacher_score')->get();
        $teachers = DB::table('teachers')->get();
        $companies = DB::table('companies')->get();
        return view('direct.direct', [
            'faculties' => $faculties, 'streams' => $streams, 'profiles' => $profiles, 'formEducation' => $formEducation,
            /*'formRus' => $formRusArr,*/ 'groups' => $groups, 'templates' => $templates, 'student_practic' => $student_practic, 'students' => $students, 'teacher_score' => $teacher_score,
            'teachers' => $teachers, 'companies' => $companies, 'workload' => $workload
        ]);
        //@if ($stream -> profile_id == $profile -> id) @if ($faculty -> id == $profile -> faculty_id)
    }
    public static function post(Request $request)
    {
        if ($request->input("download")) {
            $group_id = $request->input("download");
            $templatesModel = Template::where('group_id', $group_id)->first();
            
            if ($templatesModel) {
                Storage::delete($templatesModel->name);
                create_excel($group_id);
            } else {
                $path = create_excel($group_id);

                $templatesModel = new Template;
                $templatesModel->group_id = $group_id;
                $templatesModel->name = $path;
                $templatesModel->decanat_check = 0;
                $templatesModel->comment = null;
                $templatesModel->date = date("Y-m-d") . " " . date("H:i:s");
                $templatesModel->save();
            }

            self::index();
        }
    }
}


function create_excel($group_id)
{
    
    date_default_timezone_set('Asia/Irkutsk');
    $group = DB::table('groups')->where('id', $group_id)->first();
    $stream = DB::table('streams')->where('id', $group->stream_id)->first();
    $profile = DB::table('profiles')->where('id', $stream->profile_id)->first();
    $faculty = DB::table('faculty')->where('id', $profile->faculty_id)->first();
    $students = DB::table('students')->where('group_id', $group_id)->get();
    $teachers = DB::table('teachers')->where('fac_id', $faculty->id)->get();
    $teacher_score = DB::table('teacher_score')->get();
    $practics = DB::table('student_practic')->get();
    $companies = DB::table('companies')->get();

    $name_group = $stream->name . "-" . $group->group_number;

    $spreadsheet = new Spreadsheet();
    $active = $spreadsheet->getActiveSheet();
    $active->mergeCells('B1:G1');
    $active->setCellValue('B1', 'Шаблон');
    $active->mergeCells('B2:G2');
    $active->setCellValue('B2', 'проекта приказа на практику студентов');
    $active->setCellValue('B3', 'Факультет');
    $active->setCellValue('B4', 'Группа');
    $active->setCellValue('B5', 'Направление');
    $active->setCellValue('B6', 'Профиль');
    $active->setCellValue('B7', 'Поток');
    $active->setCellValue('B8', 'Вид практики');
    $active->setCellValue('B9', 'Тип практики');
    $active->setCellValue('B10', 'Сроки практики');
    $active->setCellValue('C3', $faculty->name);
    $active->setCellValue('C4', $stream->name . "-" . $group->group_number);
    $active->setCellValue('C5', $profile->name);
    $active->setCellValue('C7', $stream->name);
    $active->setCellValue('C8', 'производственной');
    $active->setCellValue('C9', 'технологической (проектно-технологическая)');
    $active->setCellValue('C10', 'с');
    $active->setCellValue('D10', '24.06.2024');
    $active->setCellValue('E10', 'по');
    $active->setCellValue('F10', '21.07.2024');
    $active->setCellValue('F4', 'Всего ' . sizeof($students) . ' чел');
    $active->setCellValue('G4', sizeof($students));
    $active->setCellValue('H4', 'Код');
    $active->setCellValue('H5', 'Курс');
    $active->setCellValue('H7', 'Код');
    $active->setCellValue('H8', 'Код');
    $active->setCellValue('H9', 'Код');
    $active->setCellValue('I3', 46);
    $active->setCellValue('I4', 3);
    $active->setCellValue('I7', 23547);
    $active->setCellValue('I8', 2);
    $active->setCellValue('I9', 517);
    $active->setCellValue('B13', 'Выпускающая кафедра: ');
    $active->setCellValue('A16', '№\n п/п');
    $active->setCellValue('B16', 'Студ.ИД');
    $active->setCellValue('C16', 'ФИО Студента');
    $active->setCellValue('D16', 'Категория');
    $active->setCellValue('E16', 'Наименование предприятия');
    $active->setCellValue('F16', 'Место нахождения предприятия');
    $active->setCellValue('G16', 'Способы проведения практик');
    $active->setCellValue('H16', 'ФИО руководителя полностью в вин. падеже(назначить кого)');
    $active->setCellValue('I16', 'Должность руководителя в вин. падеже (назначить кого)');
    $active->setCellValue('J16', '3-сторон. дог.');
    $active->setCellValue('K16', 'Работа по профилю');
    $count = 1;
    foreach ($students as $student) {
        $active->setCellValue('A' . $count + 16, $count);
        $active->setCellValue('B' . $count + 16, $student->id);
        $active->setCellValue('C' . $count + 16, $student->fio);
        $active->setCellValue('D' . $count + 16, 'Общий');
        foreach($practics as $practic){
            if($practic->student_id == $student->id){
                foreach($companies as $company){
                    if($company->id == $practic->company_id){
                        $active->setCellValue('E' . $count+16, $company->name);
                        break;
                    }
                }
                foreach($teacher_score as $score){
                    if($score->teacher_score == $practic->teacher_id){
                        foreach($teachers as $teacher){
                            if ($teacher->id == $score->teacher_id){
                                $active->setCellValue('H' . $count+16, $teacher->fio);
                                $active->setCellValue('I' . $count+16, $teacher->post);
                                break 2;
                            }
                        }
                    }
                }
                break;
            }
        }
        $count++;
    }
    $writer = new Xlsx($spreadsheet);
    $writer->save('../storage/templates_upload/'.$name_group.'.xlsx');
    return 'templates_upload/'.$name_group.'.xlsx';    
}
