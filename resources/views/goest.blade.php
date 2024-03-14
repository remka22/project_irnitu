@extends('layouts.app')
@section('content')
    @csrf
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="col-4  m-2 p-3 colstyle ">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <svg class="bd-placeholder-img rounded" width="200" height="200" xmlns="http://www.w3.org/2000/svg"
                            role="img" aria-label="Placeholder: 200x200" preserveAspectRatio="xMidYMid slice"
                            focusable="false">
                            <rect width="100%" height="100%" fill="#868e96"></rect>
                            <text x="10%" y="50%" fill="#dee2e6" dy=".3em">Место лого ИРНИТУ</text>
                        </svg>
                    </div>
                </div>

                <div>
                    <a href="/bitrix" class="btn btn-primary mt-3 form-control">Авторизоваться</a>
                </div>
                <div>
                    <a href="/out" class="btn btn-primary mt-3 form-control">Для компаний</a>
                </div>

                <div>
                    <div class="card-body mt-3 colstyle">
                        <br>
                        Место какого нибудь описания
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
