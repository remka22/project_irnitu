<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelController extends Controller
{
    public static function work_load_teacher()
    {
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        $fileName = 'simple1.xlsx'; //Имя файла


        // Филтр для Exel таблицы(убирает все ненужные столбцы)

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();       //создаём объект для чтения данных с Exel
        $reader->setReadFilter(new MyReadFilter());                //загружаем фильтр в reader фильтр
        $spreadsheet = $reader->load($fileName);                    //Загружаем таблицу через филтр

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

                    $teach = explode('. ', explode("Преподаватель", $ns[0])[1]);
                    $filterNeedsStr[$count][] = $teach[0].".";
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

        dd($groupStrTeacher);
        //Запускаем цикл, где переписываем нужные данные в новый массив
        // for ($i = 0, $sizeAll = count($data); $i < $sizeAll; $i++) {
        //     for ($j = 0, $size = count($data[$i]); $j < $size; $j++) {
        //         if (in_array($data[$i][$j], $checkString)) {
        //             continue;
        //         } else {
        //             array_push($resultArray, $data[$i][$j]);
        //         }
        //     }
        // }
        // dd($needsStr);
        $result = [];
        $filterNeedsStr = [];           // отфильрованные данные
        $count = 0;   //Счётчик для деления по массивам
        //Цикл с делением данных по отдельным массивам
        foreach ($needsStr as $ns) {
            $filterNeedsStr[$count][] = $ns;
            if ($ns[0] == "Итого") {
                $count++;
            }
        }
        dd($filterNeedsStr);

        foreach ($filterNeedsStr as $fns) {
            switch ($fns) {
                case (str_contains($fns[0], $cp)):
                    break;
            }
        }



        dd(explode('. ', explode('Преподаватель ', 'Факультет Институт информационных технологий и анализа данных  Институт информационных технологий и анализа данных Преподаватель Гордин А.С. Ассистент,')[1]));
        // dd(preg_split("/[\s,]+/", 'Факультет Институт информационных технологий и анализа данных  Институт информационных технологий и анализа данных Преподаватель Гордин А.С. Ассистент,'));




        $stringArray = [];
        for ($i = 0, $sizeAll = count($result); $i < $sizeAll; $i++) {
            $string = $result[$i][0];
            (string)$string;
            $stringArray =  preg_split("/[\s,]+/", $string);
            for ($j = 0; $j < 1; $j++) {
                $result[$i][0] = $stringArray[16];
                $institut = $stringArray[7] . ' ' . $stringArray[8] . ' ' . $stringArray[9] . ' ' . $stringArray[10] . ' ' . $stringArray[11] . ' ' . $stringArray[12];
                $FIO = $stringArray[14] . ' ' . $stringArray[15];
                array_unshift($result[$i], $institut, $FIO);
            }
        }
        dd($result);
        return print_r($result);
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
