@extends('layouts.app')
@section('content')
    <script>
        function init() {
            // get_options();
            change_company_format();
        }

        // function get_options() {
        //     let company_id = document.getElementById("company").value

        //     // // let test = fetch("company_api.php/?company_options=" + company_id, {
        //     // //     method: 'get',
        //     // }).then(function(response) {
        //     //     if (response.status >= 200 && response.status < 300) {
        //     //         return response.json()
        //     //     }
        //     //     throw new Error(response.statusText)
        //     // }).then(function(response) {
        //     //     change_options(response);
        //     // })
        // }

        // function change_options(new_options) {
        //     let select = document.getElementById("theme");
        //     delete_options("theme");
        //     var opt = document.createElement('option');
        //     opt.value = "Своя тема";
        //     opt.innerHTML = "Своя тема";
        //     select.appendChild(opt);

        //     for (let option of new_options) {
        //         let opt = document.createElement('option');
        //         opt.value = option;
        //         opt.innerHTML = option;
        //         select.appendChild(opt);
        //     }
        //     select.options[0].defaultSelected = true;

        // }

        // function delete_options(id) {
        //     let select_item = document.getElementById(id);
        //     let options = select_item.getElementsByTagName('option');

        //     for (let i = options.length; i--;) {
        //         select_item.removeChild(options[i]);
        //     }
        // }

        function change_company_format() {
            let cbMyCompany = document.getElementById("cbMyCompany");
            // let selectTheme = document.getElementById("theme");
            let selectCompany = document.getElementById("company");
            if (cbMyCompany.checked == true) {
                // selectTheme.options[0].defaultSelected = true;
                // selectTheme.style.display = 'none';
                selectCompany.style.display = 'none';
                selectCompany.value = 'custom';
            } else {
                // selectTheme.options[0].defaultSelected = true;
                // selectTheme.style.display = 'block';
                selectCompany.style.display = 'block';
            }

        }

        // function theme_check() {
        //     let option = document.getElementById("theme").value;
        //     let test = document.getElementById("theme_field");
        //     if (option == "Своя тема") {
        //         document.getElementById("theme_field").style.display = "block";
        //     } else {
        //         test.value = "";
        //         document.getElementById("theme_field").style.display = "none";
        //     }
        // }
    </script>


    <body onload="init()">

        <div class="all_fragments">
            <div class="fragment one">
                <form method="post" action="index.php" class="test" id="test" enctype="multipart/form-data">

                    <div class="block">
                        <label for="teacher" class="form-label">Руководитель:</label>
                        <select class="form-select zxc" id="teacher" required name="teacher_id" {{ $disabled }}>
                            @if ($disabled)
                                <option value={{ $teachers['id'] }}> {{ $teachers['fio'] }} </option>
                            @else
                                @foreach ($teachers as $teach)
                                    @if ($teach['work_load'] > 0)
                                        <option value={{ $teach['id'] }}> {{ $teach['fio'] }} (свободных мест:
                                            {{ $teach['work_load'] }} )</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>

                    </div>


                    <div class="block">
                        <label for="company" class="form-label">Компания:</label>
                        <select class="form-select zxc" id="company" name="company_id" required
                            {{ $disabled }} {{ $displayNone }}>
                            @if ($disabled && !$checked)
                                <option value={{ $companies['id'] }}> {{ $companies['name'] }} </option>
                            @else
                                <option value="" disabled selected>Выбрать</option>
                                <option value="custom" style="display: none;">Своя компания</option>
                                @foreach ($companies as $comp)
                                    <option value={{ $comp['id'] }}>{{ $comp['name'] }}</option>
                                @endforeach
                            @endif
                        </select>

                        <div class="row">
                            <div class="col-10">
                                <label {{ $displayNone }}>Свой договор</label>
                            </div>

                            <div class="col-2 d-flex align-item-center">
                                <input type="checkbox" name="cbMyCompany" id="cbMyCompany" {{ $checked }}
                                    {{ $disabled }} onchange="change_company_format()">
                            </div>
                        </div>

                        <input type="file" required name="company_file" class="company_file" id="company_file"
                            {{ $disabled }}>

                        @if ($disabled)
                            <button class="btn btn-success" name="download">Скачать договор</button>
                        @endif

                        <div class="invalid-feedback">
                            Пожалуйста, выберите компанию.
                        </div>

                    </div>

                    <div class="block">
                        <label for="theme" class="form-label">Тема:</label>
                        {{-- <select class="form-select zxc" id="theme" required name="theme" onchange="theme_check()"
                            {{ $disabled }}></select> --}}
                        <input type="text" class="form-control zxc" style="margin-left: 0" required
                            value={{ $student_practic['theme'] ?? "" }} id="theme_field" name="theme_field" {{ $disabled }}>

                        <div class="invalid-feedback">
                            Пожалуйста, не забудьте написать тему.
                        </div>
                    </div>


                    <div class="d-flex justify-content-center">
                        @if ($student_practic)
                            <button type="submit" class="btn btn-primary btn-lg" name="cancel">Отменить заявку</button>
                        @else
                            <button type="submit" class="btn btn-primary btn-lg" name="send">Отправить</button>
                        @endif
                    </div>

                    <div class="d-flex justify-content-center">

                    </div>
                </form>
            </div>
    </body>
    <style>
        body {
            background-image: linear-gradient(to right, rgba(192, 217, 214, 0.2) 10%, rgba(167, 207, 206, 0.6) 40%, rgba(27, 62, 84) 80%);
        }

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
