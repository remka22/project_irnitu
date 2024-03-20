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
                <body>
                    <table class="table">
                        <thead>
                            <tr class="tr">
                                <th class="th">Группа</th>
                                <th class="th">Шаблон приказа
                                </th>
                                <th class="th">Статус</th>
                                <th class="th">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </body>
            </div>
        </div>
    </div>
@endforeach
