@foreach ($streams as $st)
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingStream{{ $st->id }}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseStream{{ $st['id'] }}" aria-expanded="false"
                aria-controls="collapseStream{{ $st['id'] }}">
                {{ $st['name'] . ' - ' . $st['full_name'] }}
            </button>
        </h2>
        <div id="collapseStream{{ $st['id'] }}" class="accordion-collapse collapse"
            aria-labelledby="headingStream{{ $st['id'] }}"
            data-bs-parent="#accordionStream{{ $form }}{{ $inst['id'] }}">
            <div class="accordion-body">
                <table class="table">
                    <thead>
                        <tr class="tr">
                            <th class="th">Группа</th>
                            <th class="th">Шаблон приказа</th>
                            <th class="th">Статус</th>
                            <th class="th">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($st->groups as $gr)
                            @if ($gr->templates)
                                <tr class="tr">
                                    <td class="td custom_column" style="width: 100px;  vertical-align: middle;">
                                        <strong class="strong">
                                            {{ $st['name'] . '-' . $gr['group_number'] }}
                                        </strong>
                                    </td>
                                    <td class="td custom_column"
                                        style= "width: 200px; color: #1E8EC2;  vertical-align: middle;">
                                        <form method="post" action="/prikazy" enctype="text/plain">
                                            @csrf
                                            <button name="download" value="{{ $gr->templates->id }}"
                                                style="color: #1E8EC2; font-family: Helvetica Neue OTS, sans-serif;"
                                                class="btn">Файл</button>
                                        </form>
                                    </td>
                                    <td class="td" style= "width: 200px; vertical-align: middle;">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            @switch($gr->templates->decanat_check)
                                                @case(0)
                                                    <div class="custom_column temp_check"
                                                        style="display: inline-block; padding: 5px; border-radius: 15px;  ">
                                                        <span class="temp_check">
                                                            Не проверено
                                                        </span>
                                                    </div>
                                                @break

                                                @case(1)
                                                    <div class="custom_column temp_done"
                                                        style="display: inline-block; padding: 5px; border-radius: 15px;  ">
                                                        <span class="temp_done">
                                                            Принято
                                                        </span>
                                                    </div>
                                                @break

                                                @case(2)
                                                    <div class="custom_column temp_remake"
                                                        style="display: inline-block; padding: 5px; border-radius: 15px;  ">
                                                        <span class="temp_remake">
                                                            Переделать
                                                        </span>
                                                    </div>
                                                @break

                                                @default
                                            @endswitch
                                        </div>
                                    </td>
                                    <td class="td"
                                        style= "width: 400px; text-align: center; vertical-align: middle; margin: 0;">
                                        <form method="post" action="/prikazy" enctype="text/plain">
                                            @csrf
                                            <div class="input-group input-group-sm mb-0" style= "margin: 0;">
                                                @if ($gr->templates->decanat_check == 1)
                                                    <button type="submit" name="done" value="{{ $gr->templates['id'] }}"
                                                        class="btn dropdown-item1"
                                                        style = "border-radius: 5px;"></button>
                                                @endif
                                                <textarea class="form-control" name="comment" placeholder="{{ $gr->templates['comment'] }}" id="comment{{ $gr->templates['id'] }}"
                                                    rows="1" style = "display: none; border-radius: 5px;" aria-label="Комментарий" aria-describedby="basic-addon2"
                                                    placeholder="Комментарий"></textarea>
                                                <a class="btn dropdown-item3" id="showComment{{ $gr->templates['id'] }}"
                                                    style = "border-radius: 5px;"
                                                    onclick="showComment({{ $gr->templates['id'] }})"></a>
                                                <button type="submit" value="{{ $gr->templates['id'] }}" name="remake"
                                                    class="btn dropdown-item3" id="reqComment{{ $gr->templates['id'] }}"
                                                    style = "border-radius: 5px; display: none;"></button>
                                                <button type="submit" name="noShow" value="{{ $gr->templates['id'] }}"
                                                    class="btn dropdown-item2"
                                                    style = "border-radius: 5px; display: none;"></button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach


<style>
    .temp_check {
        background-color: #FEF2E5;
    }

    .temp_check span {
        color: #CD6200;
    }

    .temp_done {
        background-color: #b1f0ad;
    }

    .temp_done span {
        color: #1F9254
    }

    .temp_remake {
        background-color: #fadadd;
    }

    .temp_remake span {
        color: #f23a11
    }

    .custom_column {
        font-family: Helvetica Neue OTS, sans-serif;
        text-align: center;
    }

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
