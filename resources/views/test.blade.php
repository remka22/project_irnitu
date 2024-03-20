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

        <tr class="tr">
            <td class="td custom_column" style="width: 100px;  vertical-align: middle;">
                <strong class="strong">
                    BCN,20-1
                </strong>
            </td>
            <td class="td custom_column" style= "width: 200px; color: #1E8EC2;  vertical-align: middle;">
                <form method="post" action="/prikazy" enctype="text/plain">
                    @csrf
                    <button name="download" value="1"
                        style="color: #1E8EC2; font-family: Helvetica Neue OTS, sans-serif;"
                        class="btn">Файл</button>
                </form>
            </td>
            <td class="td" style= "width: 200px; vertical-align: middle;">
                <div style="display: flex; justify-content: center; align-items: center;">

                    <div class="custom_column temp_check"
                        style="display: inline-block; padding: 5px; border-radius: 15px;  ">
                        <span class="temp_check">
                            Не проверено
                        </span>
                    </div>

                </div>
            </td>
            <td class="td" style= "width: 400px; text-align: center; vertical-align: middle; margin: 0;">
                <form method="post" action="/prikazy" enctype="text/plain">
                    @csrf
                    <div class="input-group input-group-sm mb-0" style= "margin: 0;">

                            <button type="submit" name="done" value="1" class="btn dropdown-item1"
                                style = "border-radius: 5px;"></button>

                        <textarea class="form-control" name="comment" placeholder="RJVTYN" id="comment1"
                            rows="1" style = "display: none; border-radius: 5px;" aria-label="Комментарий" aria-describedby="basic-addon2"
                            placeholder="Комментарий"></textarea>
                        <a class="btn dropdown-item3" id="showComment1" style = "border-radius: 5px;"
                            ></a>
                        <button type="submit" value="1" name="remake" class="btn dropdown-item3"
                            id="reqComment1" style = "border-radius: 5px; display: none;"></button>
                        <button type="submit" name="noShow" value="1" class="btn dropdown-item2"
                            style = "border-radius: 5px; display: none;"></button>
                    </div>
                </form>
            </td>
        </tr>


    </tbody>
</table>


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
</style>