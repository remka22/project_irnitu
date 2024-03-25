@extends('layouts.app')
@section('content')
    <form method="post" action="/directs/twl" enctype="multipart/form-data">
        @csrf
        <input type="file" required name="teacher_workload_file" class="teacher_workload" id="teacher_workload_file"
            accept=".xlsx">
        <button class="btn btn-primary" type="submit">Отправить</button>
    </form>
@endsection
