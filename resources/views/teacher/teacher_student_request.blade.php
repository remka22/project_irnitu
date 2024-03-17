@extends('layouts.app')
@section('content')
    <table class="table">
        <tr class="tr">
            <th class="th_1">ФИО</th>
            <th class="th_2">Компания</th>
            <th class="th_3">Тема</th>
            <th class="th_4">Статус</th>
        </tr>
        @foreach ($student_practics as $stud_prac)
            <tr class="tr">
                <td class="td"> {{ $stud_prac->student->fio }} </td>
                <td class="td"> {{ $stud_prac->company->name }} </td>
                <td class="td">
                    <input name="new_theme" type="text" class="theme_text_box" value={{ $stud_prac->theme }}>
                    <button name="student_theme" class="btn_change" value={{ $stud_prac->id }} type="submit">Принять
                        изменения</button>А
                </td>
                <td class="td">
                    <button name="student_id" class="btn" value={{ $stud_prac->id }} type="submit">Принять
                        заявку</button>
                </td>
            </tr>
        @endforeach
    </table>
@endsection


<style>
    .table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 80%;
        border: 0;
        background-color: #eeeeee;
    }

    .td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    .th_1,
    . th_2,
    . th_3,
    th_4 {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        width: 25%;
    }

    .th_1 {
        width: 25%;
    }

    .th_2 {
        width: 25%;
    }

    .th_3 {
        width: 35%;
    }

    .th_4 {
        width: 15%;
    }

    .tr {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;

    }

    .tr:hover {
        background-color: #555;
        color: white;
    }

    .theme_text_box {
        width: 75%;
        font-size: 15px;
        padding: 5px 2px;
        justify-content: left;
    }

    .btn {}

    .btn_change {
        display: inline-block;
        height: 40px;
        width: 20%;
    }
</style>
