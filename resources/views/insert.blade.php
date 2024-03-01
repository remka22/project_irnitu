@extends('welcome')

@section('content')
<form method="POST" action="/">
    @csrf
    <button type="button" class="btn btn-primary ">Block level button</button>
    </form>
@endsection