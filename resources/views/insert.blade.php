@extends('welcome')

@section('content')
    <form method="POST">
        @csrf
        <input type="submit" name="insertInst" value="Импортить институты">
        <input type="submit" name="insertProf" value="Импортить направления">
        <input type="submit" name="insertStream" value="Импортить потоки">
        <input type="submit" name="insertStud" value="Импортить студентов">
        <input type="submit" name="insertComp" value="Импортить компании">
    </form>
@endsection
