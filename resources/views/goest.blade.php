@extends('layouts.app')
@section('content')
    @csrf

    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="col-4  m-2 p-3 colstyle ">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <img src="https://www.istu.edu/upload/iblock/d66/logo_2.png" jsaction="VQAsE"
                            class="sFlh5c pT0Scc iPVvYb" style="max-width: 500px; height: 250px; margin: 0px; width: 250px;"
                            alt="ИРНИТУ-Гимн, эмблема, флаг и девиз" jsname="kn3ccd" aria-hidden="false">
                    </div>
                </div>

                <div class="mt-3">
                    {{-- <a href="/bitrix" class="btn btn-primary mt-3 form-control">Авторизоваться</a> --}}
                    <div class="potentialidp">
                        <a href="/bitrix" style="text-decoration: none;">
                            <style>
                                div#campusAuth {
                                    all: unset;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    border-radius: 5px;
                                    border: 1px solid #67B8DB;
                                    border-right-color: #2A88B0;
                                    border-bottom-color: #2A88B0;
                                    background-color: #3EA4D0;
                                    background-image: url('//int.istu.edu/bitrix/templates/bitrix24/themes/light/pattern-bluish-green/pattern-bluish-green.svg');
                                    background-repeat: repeat;
                                    background-size: 150px;
                                    cursor: pointer;
                                }

                                div#campusAuth:hover {
                                    background-image: url('//int.istu.edu/bitrix/templates/bitrix24/themes/dark/pattern-sky-blue/pattern-sky-blue.svg');
                                }

                                div#campusAuth * {
                                    all: initial;
                                    font-family: 'Tahoma', 'Arial', sans-serif;
                                    font-size: 0.9em;
                                    font-weight: bold;
                                    font-style: normal;
                                    text-align: center;
                                    color: #FFF3A7;
                                    cursor: pointer;
                                }

                                div#campusAuth>div:nth-child(1) {
                                    color: #FFF;
                                }

                                div#campusAuth>div:nth-child(2) {
                                    width: 2.5em;
                                    height: 2.5em;
                                    margin: 5px 10px;
                                    background-image: url('//int.istu.edu/logo_yellow.svg');
                                    background-repeat: no-repeat;
                                    animation-name: campusAuthRotation;
                                    animation-duration: 5s;
                                    animation-iteration-count: infinite;
                                    animation-timing-function: cubic-bezier(.45, .05, .55, .95);
                                }

                                @keyframes campusAuthRotation {
                                    92% {
                                        margin: 5px 10px;
                                        opacity: 1;
                                        transform: rotate(0deg);
                                    }

                                    96% {
                                        margin: 5px 20px;
                                        opacity: 0.6;
                                    }

                                    100% {
                                        margin: 5px 10px;
                                        opacity: 1;
                                        transform: rotate(360deg);
                                    }
                                }
                            </style>
                            <div id="campusAuth">
                                <div>ВОЙТИ<br>ЧЕРЕЗ</div>
                                <div></div>
                                <div>ЛИЧНЫЙ<br>КАБИНЕТ</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div>
                    <a href="/out" class="btn btn-primary mt-3 form-control">Для компаний</a>
                </div>

                <div>
                    <div class="card-body mt-3 colstyle">
                        <br>
                        <label>Сервис - Производственная практика студентов ИРНИТУ</label>
                        <br>
                        <br>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <style>
        .colstyle {
            padding-top: .75rem;
            padding-bottom: .75rem;
            background-color: rgba(255, 255, 255, 0.308);
            border: 1px solid rgba(194, 194, 194, 0.438);
            border-radius: 2rem;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endsection
