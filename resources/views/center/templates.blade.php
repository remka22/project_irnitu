@extends('layouts.app')
@section('content')
    <div class="accordion" id="accordionInstitute">
        @foreach ($facultys as $inst)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $inst['id'] }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $inst['id'] }}" aria-expanded="false"
                        aria-controls="collapse{{ $inst['id'] }}">
                        {{ $inst['name'] }}
                    </button>
                </h2>
                <div id="collapse{{ $inst['id'] }}" class="accordion-collapse collapse"
                    aria-labelledby="heading{{ $inst['id'] }}" data-bs-parent="#accordionInstitute">
                    <div class="accordion-body">
                        <div class="accordion" id="accordionFormat{{ $inst['id'] }}">
                            @foreach ($formEducation as $index => $form)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $form }}{{ $inst['id'] }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $form }}{{ $inst['id'] }}"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $form }}{{ $inst['id'] }}">
                                            {{ $formRus[$index] }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $form }}{{ $inst['id'] }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $form }}{{ $inst['id'] }}"
                                        data-bs-parent="#accordionFormat{{ $inst['id'] }}">
                                        <div class="accordion-body">
                                            @foreach ($inst->profiles as $prof)
                                                <div class="accordion"
                                                    id="accordionStream{{ $form }}{{ $inst['id'] }}">
                                                    @foreach ($prof->streams_b as $st)
                                                        {{ view('center.templates_stream_accord', ['profiles' => $st]) }}
                                                    @endforeach
                                                    @foreach ($prof->streams_m as $st)
                                                        {{ view('center.templates_stream_accord', ['profiles' => $st]) }}
                                                    @endforeach
                                                    @foreach ($prof->streams_z as $st)
                                                        {{ view('center.templates_stream_accord', ['profiles' => $st]) }}
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>



    <script>
        function showComment(id) {
            let comment = document.getElementById('comment' + id);
            let bt_comment = document.getElementById('reqComment' + id);
            let sh_comment = document.getElementById('showComment' + id);
            comment.style.display = 'block';
            bt_comment.style.display = 'block';
            sh_comment.style.display = 'none';

        }
    </script>
@endsection
