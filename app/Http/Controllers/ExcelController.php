<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupScore;
use App\Models\Stream;
use App\Models\Teachers;
use App\Models\TeacherScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelController extends Controller
{
    public static function work_load_teacher(Request $request)
    {
        if (Storage::exists('teacher_workload/teacher_workload.xlsx')) {
            return response('Нагрузка уже загружена', 500);
        }
        $path = Storage::putFileAs(
            'teacher_workload',
            $request->file('teacher_workload_file'),
            "teacher_workload.xlsx"
        );

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        // $fileName = 'simple1.xlsx'; //Имя файла


        // Филтр для Exel таблицы(убирает все ненужные столбцы)

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();       //создаём объект для чтения данных с Exel
        $reader->setReadFilter(new MyReadFilter());                //загружаем фильтр в reader фильтр
        $spreadsheet = $reader->load('../storage/app/' . $path);                    //Загружаем таблицу через филтр

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();                                  //Заносим все данные с таблицы в переменную data

        // dd($data);   
        $checkString = [
            NULL, 11, '', "", " Название предмета, группа,кол-во подгрупп", $data[2][0], $data[0][0],
            "Название предмета, группа,кол-во подгрупп", "ПрПр",
            "Директор (декан) _____________                 __________________________________________",
            "Директор _________ А.С.Говорков",
            "Итого по ставке Штатный",
            "Итого по ставке Часовик",
            "Итого по ставке Совместитель",
            "Итого по ставке Совмещение",
        ];
        //Выше представлен массив с элементами, которые нужно игнорировать при записи в итоговый массив данных
        $checkPractic = ["Итого", "практика", "Факультет"];

        $needsStr = [];    //Данный массив нужен, чтобы в него записать все нужные данные из массива data

        foreach ($data as $d) {
            if (!in_array($d[0], $checkString)) {
                foreach ($checkPractic as $cp) {
                    if (str_contains($d[0], $cp)) {
                        array_push($needsStr, $d);
                    }
                }
            }
        }
        // dd($needsStr);

        $filterNeedsStr = [];
        $count = 0;
        foreach ($needsStr as $ns) {
            switch ($ns) {
                case (str_contains($ns[0], "Преподаватель ")):

                    $teach = explode('. ', explode("Преподаватель ", $ns[0])[1]);
                    $filterNeedsStr[$count][] = $teach[0] . ".";
                    $filterNeedsStr[$count][] = "next";
                    break;
                case (str_contains($ns[0], "Производственная")):
                    $groups = explode("Производственная практика ", $ns[0]);
                    $filterNeedsStr[$count][] = $groups[1];
                    $filterNeedsStr[$count][] = $ns[13];
                    break;
            }
            $count++;
        }
        // dd($filterNeedsStr);

        $groupStrTeacher = [];
        $count = -1;
        foreach ($filterNeedsStr as $fns) {
            if ($fns[1] == "next") {
                $count++;
            }
            $groupStrTeacher[$count][] = $fns;
        }

        // dd($groupStrTeacher);
        // $result = [];
        // dd($groupStrTeacher);
        insert_workload($groupStrTeacher);
    }
}

class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    function readCell($columnAddress, $rows, $worksheetName = '')
    {
        if (($columnAddress == 'A' || $columnAddress == 'N')) {
            return true;
        }
        return false;
    }
}

function insert_workload($groupStrTeacher)
{
    $teacher_score = null;
    $fio = '';
    foreach ($groupStrTeacher as $gst) {
        foreach ($gst as $g) {
            if ($g[1] == "next") {
                $fio = $g[0];
            } else {
                $fio_arr = explode(' ', $fio);
                $teacher = null;
                $teachers = Teachers::where('fio', 'like', '%' . $fio_arr[0] . '%')->get();
                if ($teachers->count() == 1) {
                    $teacher = $teachers->first();
                } elseif ($teachers->count() > 1) {
                    $fio_arr_sl = explode('.', $fio_arr[1]);
                    foreach ($teachers as $t) {
                        $t_fio = explode(' ', $t->fio);
                        if (substr($t_fio[1], 0, 1) == $fio_arr_sl[0] && substr($t_fio[2], 0, 1) == $fio_arr_sl[1]) {
                            $teacher = $t;
                        }
                    }
                }

                if ($teacher) {
                    $teacher_score = new TeacherScore();
                    $teacher_score->teacher_id = $teacher->id;
                    $teacher_score->score = $g[1];
                    // $teacher_score->save();
                    preg_match_all('#(\W+-\d+-\d+)(,|\()#', $g[0], $arr);
                    foreach ($arr[1] as $a) {
                        preg_match_all('#(\W+-\d+)-(\d+)#', $a, $arr1);
                        dump($arr1);
                        $stream = Stream::where('name', $arr1[1][0])->get()->first();
                        dump($stream);
                        $group = Group::where([['stream_id', '=', $stream->id], ['group_number', '=', $arr1[2][0]]])->get()->first();
                        dd($group);
                        $group_score = new GroupScore();
                        $group_score->teacher_score_id = $teacher_score->id;
                        $group_score->group_id = $group->id;
                        // $group_score->save();
                        // $result[$count][] = ['stream' => $arr1[1], 'group' => $arr1[2]];
                    }
                }
            }
        }
    }
}
