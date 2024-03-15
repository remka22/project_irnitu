@extends('layouts.app')
@section('content')
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
@endsection
