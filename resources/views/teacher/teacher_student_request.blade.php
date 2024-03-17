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
    
</style>
