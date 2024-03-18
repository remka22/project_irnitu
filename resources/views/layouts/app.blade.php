<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>job.istu.edu</title>
</head>

<body>
    {{-- <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @guest
                        @else
                            <div>{{ Auth::user()->last_name }} {{ Auth::user()->name }} {{ Auth::user()->second_name }}
                            </div>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <a href="/admin">admin</a>
                        @else
                            <a class='btn btn-primary' href='/logout'>Выход</a>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row mt-2">
            @guest
            <div class="col-2">

                <div class="container  ">
                    <div class="row gy-2">
                        <a href="/center/shablon_prikazy" class="btn custom-button btn-lg">Шаблоны приказов</a>
                        <a href="/center/stud_dogovory" class="btn custom-button btn-lg">Договора студентов</a>
                    </div>
                </div>

            </div>
            @else
                <div class="col-2">

                    <div class="container  ">
                        <div class="row gy-2">
                            @if (Auth::user()->type == 'student' || Auth::user()->type == 'admin')
                                <a href="/student/practika" class="btn btn-custom ">Заявка</a>
                                <a href="/student/otchet" class="btn btn-custom ">Отчет</a>
                            @endif
                            @if (Auth::user()->type == 'teacher' || Auth::user()->type == 'admin')
                                <a href="/teacher/stud_practika" class="btn btn-custom ">Заявки студентов</a>
                                <a href="/teacher/stud_otchet" class="btn btn-custom ">Отчетность студентов</a>
                            @endif
                            @if (Auth::user()->type == 'rop' || Auth::user()->type == 'admin')
                                <a href="/teacher/stud_practika" class="btn btn-custom ">Заявки студентов</a>
                                <a href="/teacher/stud_otchet" class="btn btn-custom ">Отчетность студентов</a>
                                <a href="/rop/control_activity_student" class="btn btn-custom ">Контроль активности
                                    студентов</a>
                            @endif
                            @if (Auth::user()->type == 'direct' || Auth::user()->type == 'admin')
                                <a href="/direct/shablon_prikazy" class="btn btn-custom ">Формирование шаблонов
                                    приказа</a>
                            @endif
                            @if (Auth::user()->type == 'center' || Auth::user()->type == 'admin')
                                <a href="/center/shablon_prikazy" class="btn btn-custom ">Шаблоны приказов</a>
                                <a href="/center/stud_dogovory" class="btn btn-custom ">Договора студентов</a>
                            @endif
                            <a href="/center/shablon_prikazy" class="btn btn-custom ">Шаблоны приказов</a>
                            <a href="/center/stud_dogovory" class="btn btn-custom ">Договора студентов</a>
                        </div>
                    </div>

                </div>
            @endguest


            <div class="col gy-2">
                @yield('content')
            </div>


            @guest
            @else
                <div class="col-2">
                    <form method="POST" action="/insert">
                        @csrf
                        @if (Auth::user()->type == 'admin')
                            <div class="container  ">
                                <div class="row gy-2">
                                    <input type="submit"class="btn btn-warning" name="insertInst"
                                        value="Импортить институты">
                                    <input type="submit"class="btn btn-warning" name="insertProf"
                                        value="Импортить направления">
                                    <input type="submit"class="btn btn-warning" name="insertStream"
                                        value="Импортить потоки">
                                    <input type="submit"class="btn btn-warning" name="insertStud"
                                        value="Импортить студентов">
                                    <input type="submit"class="btn btn-warning" name="insertComp"
                                        value="Импортить компании">
                                    <input type="submit"class="btn btn-warning" name="insertTeach"
                                        value="Импортить преподавателей">
                                </div>
                            </div>
                        @else
                            <div class="container  ">
                                <div class="row gy-2">
                                    <input style="display: none;">
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            @endguest

        </div> --}}

    <div class="container-fluid">
        <div class="row">
            @guest
            @else
                <div class="col-2 d-flex justify-content-end">
                    <div class="d-flex flex-column flex-shrink-0 p-3 text-dark bg-white "
                        style="width: auto; height: fit-content;">
                        <ul class="nav nav-pills flex-column">
                            <span class="fs-4">{{ Auth::user()->last_name }}</span>
                            <span class="fs-6">{{ Auth::user()->name }}</span>
                            <span class="fs-6">{{ Auth::user()->second_name }}</span>
                        </ul>

                        <hr>
                        <ul class="nav nav-pills flex-column ">
                            @if (Auth::user()->type == 'student' || Auth::user()->type == 'admin')
                                <li class="nav-item mb-2">
                                    <a href="/student/practika" class="btn btn-custom ">Подать заявку</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="/student/otchet" class="btn btn-custom ">Отправить отчет</a>
                                </li>
                            @endif
                            @if (Auth::user()->type == 'teacher' || Auth::user()->type == 'admin' || Auth::user()->type == 'rop')
                                <li class="nav-item mb-2">
                                    <a href="/teacher/stud_practika" class="btn btn-custom ">Заявки студентов</a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a href="/teacher/stud_otchet" class="btn btn-custom ">Отчетность студентов</a>
                                </li>
                            @endif
                            @if (Auth::user()->type == 'rop' || Auth::user()->type == 'admin')
                                <li class="nav-item mb-2">
                                    <a href="/rop/control_activity_student" class="btn btn-custom ">Контроль активности
                                        студентов</a>
                                </li>
                            @endif
                            @if (Auth::user()->type == 'direct' || Auth::user()->type == 'admin')
                                <li class="nav-item mb-2">
                                    <a href="/direct/shablon_prikazy" class="btn btn-custom ">Формирование шаблонов
                                        приказа</a>
                                </li>
                            @endif
                            @if (Auth::user()->type == 'center' || Auth::user()->type == 'admin')
                                <li class="nav-item mb-2">
                                    <a href="/center/shablon_prikazy" class="btn btn-custom ">Шаблоны приказов</a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a href="/center/stud_dogovory" class="btn btn-custom ">Договора студентов</a>>
                                </li>
                            @endif
                        </ul>

                        <hr>

                        <ul class="nav nav-pills flex-column ">
                            <li class="nav-item">
                                <a class='btn btn-custom' href='/logout'>Выход</a>
                            </li>

                        </ul>

                        <hr>
                    </div>
                </div>
            @endguest


            <div class="col">
                @yield('content')
            </div>

            @guest
            @else
                <div class="col-2">
                    <div class="col-2">
                        <form method="POST" action="/insert">
                            @csrf
                            @if (Auth::user()->type == 'admin')
                                <div class="container  ">
                                    <div class="row gy-2">
                                        <input type="submit"class="btn btn-warning" name="insertInst"
                                            value="Импортить институты">
                                        <input type="submit"class="btn btn-warning" name="insertProf"
                                            value="Импортить направления">
                                        <input type="submit"class="btn btn-warning" name="insertStream"
                                            value="Импортить потоки">
                                        <input type="submit"class="btn btn-warning" name="insertStud"
                                            value="Импортить студентов">
                                        <input type="submit"class="btn btn-warning" name="insertComp"
                                            value="Импортить компании">
                                        <input type="submit"class="btn btn-warning" name="insertTeach"
                                            value="Импортить преподавателей">
                                    </div>
                                </div>
                            @else
                                <div class="container  ">
                                    <div class="row gy-2">
                                        <input style="display: none;">
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</body>

</html>

<style>
    .btn-custom {
        color: #1E8EC2 !important;
        background-color: #E1F3F9 !important;
        border-radius: 10px;
    }

    .btn:hover {
        text-decoration: underline;

    }
</style>
