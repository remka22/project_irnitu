@extends('layouts.app')
@section('content')
    <div class="all_fragments">
        <div class="fragment one">
            <form method="POST" action="/student/otchet" enctype="multipart/form-data">
                @csrf
                <div class="form-floating">
                    <input class="form-control" id="lastName" placeholder="name@example.com" value="{{ $name }}"
                        readonly>
                    <label for="lastName">ФИО</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="Tema" placeholder="name@example.com" value="{{ $teacher }}"
                        readonly>
                    <label for="Tema">Руководитель практики</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="company" placeholder="name@example.com" value="{{ $company }}"
                        readonly>
                    <label for="company">Компания</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" id="Tema" placeholder="Тема" readonly>{{ $theme }}</textarea>
                    <label for="Tema">Тема</label>
                </div>

                {{-- @if ($disabled == '')
                    <div>
                        <label class="form-control">
                            Необходимо отправить ссылку на облачное хранилище <br/>
                            <label>
                                с отчётными документами, для корректной загрузки <br/> 
                                <label>
                                    файлов используйте инструкцию ниже.<br/> 
                                    <a href="https://drive.google.com/drive/folders/1VtF_41jN8bayRbZWEAp7h_r_7CUxyLp1" target="_blank">Ссылка на инструкцию!</a>
                                </label>
                            </label>
                        </label>
                    </div>
                @endif
                <div class="form-floating">
                    @if ($disabled == '')
                        <input type="text" class="form-control" required id="YaUrl" name = "YaUrl" placeholder="ссылка на яндекс диск">
                        <label for="yaUrl">Ссылка на Яндекс Диск</label>
                    @else
                        <input class="form-control" required id="YaUrl" {{ $disabled }} value="{{$student_otchet -> link_ya}}">Отчет</input>
                        <label for="yaUrl">Ссылка на Яндекс Диск</label>	
                    @endif
                </div> --}}


                {{-- <input type="file" name="report" required>
                    <button type="submit">Загрузить отчет</button> --}}
                <input type="file" required name="link_ya" class="link_ya" id="link_ya" accept=".docx"
                    {{ $disabled }}>

                @if ($disabled)
                <div>
                    <input type="submit" class="btn btn-success" name="download" value="Скачать отчет">
                </div>
                @endif

                <div class="form-floating">
                    <input type="text" id="status" class="form-control" readonly value="{{ $status }}">
                    <label for="status">Статус проверки</label>
                </div>
                <div class="d-flex justify-content-center">
                    @if ($disabled == '')
                        <button type="submit" name="SubmitYaUrl" class="btn btn-primary btn-lg"
                            value="{{ $student_practic->student_id }}">Отправить</button>
                    @else
                        <button type="submit" name="fallSubmitYaUrl" class="btn btn-primary btn-lg"
                            value="{{ $student_otchet->id }}">Отменить отправку</button>
                    @endif
                </div>
                @if ($status_message)
                    <div class="alert alert-{{ $status_color }} mt-2"> {{ $status_message }} </div>
                @endif
        </div>
        </form>
    </div>
    </div>
    <style>
        body {
            background-image: linear-gradient(to right, rgba(192, 217, 214, 0.2) 10%, rgba(167, 207, 206, 0.6) 40%, rgba(27, 62, 84) 80%);
        }
        .all_fragments {
            flex-direction: row-reverse;
            align-items: stretch;
            justify-content: center;
        }

        .fragment {
            padding: 80px 0;
        }

        .download-section {
            text-align: center;
        }

        .form-floating textarea {
            height: auto;
            min-height: 100px;
            max-height: 200px;
            overflow-y: auto;
        }

        .block {
            align-items: flex-start;
            flex-direction: column;
            width: 100%;
            max-width: 200px;
            margin: 20px auto;
            text-align: center;
        }

        .size1 {
            Height: 25px;
            Top: 107px;
            Left: 235px;
            border-radius: 10px;
            border: 1px solid black;

        }

        .text {
            Width: 100px;
            Height: 16px;
            Top: 106px;
            Left: 188px;
            Font: Helvetica Neue OTS;
            Weight: 400;
            font-size: 25px;
            Line height: 16px;
        }

        .input1 {
            display: inline;
            color: #FFF;
            text-align: center;
            font-family: Inter;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            width: 250px;
            height: 45px;
            flex-shrink: 0;
            border-radius: 10px;
            border: none;
            background: #2155AF;
        }

        .silka {
            color: #2155AF;
            text-align: center;
            font-family: Inter;
            font-size: 32px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            border-radius: 10px;
            background: #D9D9D9;
            width: 397px;
            height: 46px;
            flex-shrink: 0;
        }

        .text2 {
            color: red;
            font-family: Inter;
            font-size: 28px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }

        .in {
            display: inline-block;
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
        textarea#Tema{
            padding-right: 20px;
            margin: 4px;
            font-size: 17px;
            margin-bottom: 10px;
            width 100%;
        }

        .btn-success {
            width: 100%;
            margin: 0 auto;
            margin-left: 4px;
            margin-bottom: 10px;
            padding-right: 20px;
            display: block; 
        }

    </style>
@endsection
