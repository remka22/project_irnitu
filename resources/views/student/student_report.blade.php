@extends('layouts.app')
@section('content')
    <script>
        function init() {
            change_company_format();
        }


        function change_company_format() {
            let cbMyCompany = document.getElementById("cbMyCompany");
            let inputFile = document.getElementById("company_file");
            // let selectTheme = document.getElementById("theme");
            let selectCompany = document.getElementById("company");
            if (cbMyCompany.checked == true) {
                // selectTheme.options[0].defaultSelected = true;
                // selectTheme.style.display = 'none';
                selectCompany.style.display = 'none';
                // selectCompany.value = 'custom';
                selectCompany.required = false;

                inputFile.style.display = 'block';
                inputFile.required = true;
            } else {
                // selectTheme.options[0].defaultSelected = true;
                // selectTheme.style.display = 'block';
                selectCompany.style.display = 'block';
                selectCompany.required = true;

                inputFile.style.display = 'none';
                inputFile.required = false;
            }

        }
    </script>


    <div onload="init()">

        <div class="all_fragments">
            <div class="fragment one">

                {{-- @if (Auth::user()->type == 'admin')
                    <div>{{ $student->fio }}</div>
                    <select class="form-select zxc" id="students" required name="teacher_id">
                        @foreach ($students as $stud)
                            <option><a href="/student/practika?id={{$stud->id}}">{{$stud->fio}}</a></option>
                        @endforeach
                    </select>
                @endif --}}

                <form method="post" action="/student/practika" enctype="multipart/form-data">
                    @csrf
                    <div class="block">
                        <label for="teacher" class="form-label">Руководитель:</label>
                        <select class="form-select zxc" id="teacher" required name="teacher_id" {{ $disabled }}>
                            @if ($disabled)
                                <option value={{ $teachers['id'] }}> {{ $teachers['fio'] }} </option>
                            @else
                                @foreach ($teachers as $teach)
                                    @if ($teach->teacher_score->score > 0)
                                        <option value={{ $teach->teacher_score->id }}>
                                            {{ $teach->teacher_score->teacher->fio }} (свободных мест:
                                            {{ $teach->teacher_score->score }} )</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>

                    </div>


                    <div class="block">
                        <label for="company" class="form-label">Компания:</label>
                        @if (!$checked)
                            <select class="form-select zxc" id="company" name="company_id" required {{ $disabled }}
                                {{ $displayNone }}>
                                @if ($disabled)
                                    <option value={{ $companies['id'] }}> {{ $companies['name'] }} </option>
                                @else
                                    <option value="" disabled selected>Выбрать</option>
                                    <option value="custom" style="display: none;">Своя компания</option>
                                    @foreach ($companies as $comp)
                                        <option value={{ $comp['id'] }}>{{ $comp['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endif
                        <input type="file" name="company_file" class="company_file" id="company_file" accept=".docx"
                            {{ $disabled }} style="display: none">


                        <div class="row">
                            @if (!$disabled)
                                <div class="col-10">
                                    <label {{ $displayNone }}>Свой договор</label>
                                </div>
                                <div class="col-2 d-flex align-item-center">
                                    <input type="checkbox" name="cbMyCompany" id="cbMyCompany" {{ $checked }}
                                        {{ $disabled }} onchange="change_company_format()">
                                </div>
                            @else
                                @if (!$student_practic->company_id)
                                    {{-- <input type="submit" class="btn btn-success" name="download" value="Скачать договор"> --}}
                                    <button type="submit" name="download" value="{{ $student_practic->id }}"
                                        class="btn btn-success">Скачать договор</button>
                                @endif
                            @endif
                        </div>

                        @if ($disabled && !$student_practic->company_id)
                            {{-- <input type="submit" class="btn btn-success" name="download" value="Скачать договор"> --}}
                            <button type="submit" name="download" value="{{ $student_practic->id }}"
                                class="btn btn-success">Скачать договор</button>
                        @endif

                        <div class="invalid-feedback">
                            Пожалуйста, выберите компанию.
                        </div>

                    </div>

                    <div class="block">
                        <label for="theme" class="form-label">Тема:</label>
                        {{-- <select class="form-select zxc" id="theme" required name="theme" onchange="theme_check()"
                            {{ $disabled }}></select> --}}
                        @if ($student_practic)
                            <label class="form-control zxc">{{ $student_practic['theme'] }}</label>
                        @else
                            <input type="text" class="form-control zxc" style="margin-left: 0" required id="theme_field"
                                name="theme_field" {{ $disabled }}>
                        @endif


                        <div class="invalid-feedback">
                            Пожалуйста, не забудьте написать тему.
                        </div>
                    </div>


                    <div class="d-flex justify-content-center">
                        @if ($disabled)
                            <input type="submit" class="btn btn-primary btn-lg" name="cancel" value="Отменить">
                        @else
                            <input type="submit" class="btn btn-primary btn-lg" name="send" value="Отправить">
                        @endif
                    </div>

                    <div class="d-flex justify-content-center">
                        @if ($student_practic)
                            @switch($student_practic['status'])
                                @case(0)
                                    <div class="alert alert-primary mt-2">Ждите уведомление о принятии руководителем заявки на
                                        практику!
                                    </div>
                                @break

                                @case(1)
                                    <div class="alert alert-success mt-2">Руководитель принял вашу заявку!</div>
                                @break

                                @case(2)
                                    <div class="alert alert-danger mt-2">Преподаватель отклонил вашу заявку, для получения большей
                                        информации свяжитесь с ним.</div>
                                @break

                                @default
                            @endswitch
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .all_fragments {
            display: flex;
            flex-direction: row-reverse;
            align-items: stretch;
            justify-content: space-evenly;
        }

        .fragment {
            padding: 80px 0;
        }

        .block {
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            width: 100%;
            max-width: 400px;
            margin: 10px auto;
            text-align: center;
        }

        .block label,
        input {
            padding-right: 20px;
            margin: 4px;
            font-size: 20px;
            margin-bottom: 10px;
            width 100%;
        }

        .block input {
            width: 100%;
        }

        .zxc {
            width: 100%;
            font-size: 20px;
        }

        .theme_field {
            display: block;
        }

        .test2 {
            display: none;
        }

        .download-section {
            text-align: center;
        }

        .status-message {
            border: 2px solid #4169E1;
            /* цвет рамки */
            background-color: #E0FFFF;
            /* Цвет фона */
            border-radius: 12px;
            padding: 15px;
            margin-top: 20px;
            display: inline-block;
            color: #4169E1;
            /* Цвет текста */
        }

        .status-succes {
            border: 2px solid #4169E1;
            /* цвет рамки */
            background-color: #E0FFFF;
            /* Цвет фона */
            border-radius: 12px;
            padding: 15px;
            margin-top: 20px;
            display: inline-block;
            color: #4169E1;
            /* Цвет текста */
        }
    </style>
@endsection
