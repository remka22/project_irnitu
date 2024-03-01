@extends('welcome')

@section('content')
<form method="POST" action="/profile">
    @csrf
    <button type="button" class="btn btn-primary ">Block level button</button>
    </form>
@endsection