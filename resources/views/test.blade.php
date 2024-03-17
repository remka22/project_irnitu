@extends('layouts.app')
@section('content')
    <form method="post" action="/test" enctype="multipart/form-data">
        @csrf
        <input type="file" required name="company_file" class="company_file" id="company_file">
        <input type="submit" class="btn btn-primary btn-lg" name="send" value="Отправить">
        <input type="submit" class="btn btn-primary btn-lg" name="cancel" value="Отменить">
    </form>
@endsection
