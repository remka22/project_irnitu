@extends('layouts.app')
@section('content')
    <table class="table">
        <div class="remote">

            <div class="remote-left">
                <p class="mar-off">Осталось мест: {{ $teacher->work_load }}</p>
            </div>

            <div class="remote-rigth">
                <p class="mar-off">Показать отмененные</p>
                <form method="post">
                    <label class="label-check">
                        Тут будет чекбокс просмотреть уже принятых
                    </label>
                </form>
            </div>
        </div>
        <thead class="thead">
            <tr class="tr">
                <th class="th">ФИО студента</th>
                <th class="th">Компания</th>
                <th class="th">Тема практики</th>
                <th class="th">Договор</th>
                <th class="th">Статус</th>
                <th class="th">Действие</th>
            </tr>
        </thead>
        <tbody class="tbody">
            @foreach ($student_practics as $stud_prac)
                <tr class="tr">

                    <td class="td">
                        <div class="block-div">
                            <strong class="strong">{{ $stud_prac->student->fio }} </strong>
                        </div>
                    </td>

                    @if ($stud_prac->company->name)
                        <td class="td">
                            <div class="block-div"> {{ $stud_prac->company->name }} </div>
                        </td>
                    @else
                        <td class="td">
                            <div class="block-div">
                                <p class="mar-off">Своя компания</p>
                            </div>
                        </td>
                    @endif


                    <td class="td">
                        <div class="block-div"> {{ $stud_prac->theme }} </div">
                    </td>

                    <td class="td">
                        <button name="download" value={{ $stud_prac->student->id }} class="btn">Файл</button>
                    </td>

                    @if ($stud_prac->status)
                        <td class="td td-status">
                            <div class="block-status_ok">
                                <span class="status-check_ok">Принят</span>
                            </div>
                        </td>
                    @else
                        <td class="td td-status">
                            <div class="block-status_fail">
                                <span class="status-check_fail">Не принят</span>
                            </div>
                        </td>
                    @endif

                    <td class="td">
                        <ul class="action" aria-labelledby="btnGroupDrop1">
                            <form>
                                <li><button type="sumbit" name="done" value={{ $stud_prac->id }}
                                        class="btn dropdown-item1" href="#"></button></li>
                            </form>
                            <form>
                                <li><button type="sumbit" name="remake" value={{ $stud_prac->id }}
                                        class="btn dropdown-item2" href="#"></button></li>
                            </form>
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


<style>

    /*========================= ОСНОВА =========================*/
    /*========================= ОСНОВА =========================*/

    .table {
        background: #ffffff !important;
        border-collapse: collapse;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        font-size: 14px;
        text-align: left;
        max-width: 1450px;
        min-width: 800px;
        width: 100%;
        margin: 0 auto;
        color: #1E8EC2;
        font-family: Helvetica Neue OTS, sans-serif;
    }

    .thead {
        border-bottom: 1px solid black;
    }

    .th {
        text-align: center;
        font-family: inherit;
    }

    .td {
        text-align: center;
        font-family: inherit;
        text-align: center;
        vertical-align: middle;
    }

    .td-status{
        width: 150px;
    }

    .block-div{
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    /*========================= КНОПКИ =========================*/
    /*========================= КНОПКИ =========================*/

    .btn {
        background: none;
        color: inherit;
        border: none;
        padding: 0;
        font: inherit;
        cursor: pointer;
        outline: inherit;
        color: #1E8EC2;
    }

    .btn:hover{
        text-decoration: underline;
        color: #1E8EC2;
    }

    /*======================== ДЕЙСТВИЕ ========================*/
    /*======================== ДЕЙСТВИЕ ========================*/

    .action {
        list-style-type: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 0;
        margin: 0;
    }

    .dropdown-item1 {
        background: url(https://cdn-icons-png.flaticon.com/512/5629/5629189.png) 50% 50% no-repeat; /*(https://cdn-icons-png.flaticon.com/512/8832/8832098.png)*/
        background-size: contain;
        border-radius: 100%;
        width: 30px;
        height: 30px;
    }

    .dropdown-item1:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .dropdown-item2 {
        background: url(https://cdn-icons-png.flaticon.com/512/10727/10727988.png) 50% 50% no-repeat; /*(https://cdn-icons-png.flaticon.com/512/179/179386.png)*/
        background-size: contain;
        border-radius: 100%;
        width: 30px;
        height: 30px;
    }

    .dropdown-item2:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    /*========================= СТАТУС =========================*/
    /*========================= СТАТУС =========================*/

    .block-status_ok {
        display: inline-block; 
        background-color: #b1f0ad; 
        padding: 7px; 
        border-radius: 15px;
        text-align: center;
    }

    .block-status_fail {
        display: inline-block; 
        background-color: #fadadd; 
        padding: 7px; 
        border-radius: 15px;
        text-align: center;
    }

    .status-check_fail {
        color: #f23a11;
    }

    .status-check_ok {
        color: #1F9254;
    }

    /*======================= НАД ТАБЛИЦЕЙ =======================*/
    /*======================= НАД ТАБЛИЦЕЙ =======================*/

    .remote {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        font-size: 14px;
        flex-basis: 100px;
    }

    .remote-rigth {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .mar-off {
        margin: 0;
    }

    .checkbox {
        margin: 2px 0 0 3px;
    }

    .label-check{
        display: flex;
        align-items: center;
        justify-content: center;
    }

</style>
