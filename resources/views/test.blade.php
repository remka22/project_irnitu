@extends('layouts.app')
@section('content')
    <form method="post" action="/prikazy" enctype="text/plain">
        @csrf
        <div class="input-group input-group-sm mb-0" style= "margin: 0;">
            <button type="submit" name="done" value="1" class="btn dropdown-item1"
                style = "border-radius: 5px;"></button>
            <textarea class="form-control" name="comment" placeholder=" Comentttttt " id="comment1" rows="1"
                style = "display: none; border-radius: 5px;" aria-label="Комментарий" aria-describedby="basic-addon2"
                placeholder="Комментарий"></textarea>
            <a class="btn dropdown-item3" id="showComment1" style = "border-radius: 5px;" onclick="showComment(1)"></a>
            <button type="submit" value="1" name="remake" class="btn dropdown-item3" id="reqComment1"
                style = "border-radius: 5px; display: none;"></button>
            <button type="submit" name="noShow" value="1" class="btn dropdown-item2"
                style = "border-radius: 5px; display: none;"></button>
        </div>
    </form>
@endsection


<style>
    .dropdown-item1 {
        background: url(https://cdn-icons-png.flaticon.com/512/8832/8832098.png) 50% 50% no-repeat;
        background-size: cover;
        width: 30px;
        height: 30px;

    }

    .dropdown-item1:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

    }

    .dropdown-item2 {
        background: url(https://cdn-icons-png.flaticon.com/512/179/179386.png) 50% 50% no-repeat;

        background-size: cover;
        width: 30px;
        height: 30px;

    }

    .dropdown-item2:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

    }

    .dropdown-item3 {
        background: url(https://cdn-icons-png.flaticon.com/512/1159/1159876.png) 50% 50% no-repeat;
        background-size: cover;
        width: 30px;
        height: 30px;

    }

    .dropdown-item3:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

    }
</style>
