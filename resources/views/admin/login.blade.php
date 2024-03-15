@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="container">
            <div class="row" style="padding-top: 3rem;">
                <div class="col-4 offset-4 d-flex align-items-center justify-content-center flex-column colstyle">
                    <div style="color: rgb(73, 73, 73);">Авторизация</div>
                    <div>
                        <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"
                            style="margin-top: .5rem;" value="{{ old('login') }}" required>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            id="password" placeholder="Введите пароль" style="margin-top: .5rem;" required
                            autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            Запомнить пароль?
                        </label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" name="inputLogin" class="btn btn-primary"
                                style="margin-top: 0.6rem;">Войти</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
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