@extends('layouts.app')
@section('content')
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModalWorkload">Загрузить
    нагрузку преподавателей</button>

<form method="post" action="/direct/twl" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="exampleModalWorkload" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Загрузка нагрузки преподавателей</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($workload)
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Выберете xlsx файл</label>
                        <input class="form-control" type="file" id="formFile"  name="teacher_workload_file" accept=".xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Загрузить</button>
                </div>
                @else
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Загрузка уже загружена! Обратитесь к администратору</label>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</form>


    <div class="accordion accordion-flush" id="accordionFlushExample">
      @foreach ($faculties as $faculty)
      <h3>{{$faculty->name}}</h3>
        @foreach($formEducation as $form)
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $form }}{{ $faculty->id }}">
              <button class="accordion-button collapsed" type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapse{{ $form }}{{ $faculty->id }}"
                      aria-expanded="false"
                      aria-controls="collapse{{ $form }}{{ $faculty->id }}">
                {{ $form}}
              </button>
            </h2>
            <div id="collapse{{ $form }}{{ $faculty->id }}"
                class="accordion-collapse collapse"
                aria-labelledby="heading{{ $form }}{{ $faculty->id }}"
                data-bs-parent="#accordionFormat{{ $faculty->id }}">
              <div class="accordion-body">
                @foreach ($profiles as $profile)
                  @if ($faculty->id == $profile->faculty_id)
                    @foreach($streams as $stream)
                      @if ($stream->profile_id == $profile->id && strpos($stream->name, "б") && (date("Y") - $stream->year < 5 and date("Y") - $stream->year > 0) && $stream->full_name != '' && $form=="Бакалавриат")
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          @foreach($groups as $gr)
                            @if ($gr->stream_id == $stream->id && $stream->full_name != '' )
                              @if($gr->group_number == 1)
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active" id="tab{{ $stream->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $stream->id }}"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Скрыть</button>
                                </li>
                              @endif
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab{{ $gr->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $gr->id }}"
                                type="button" role="tab" aria-controls="home" aria-selected="true">{{ $stream->name }}-{{ $gr->group_number }}</button>
                              </li>
                            @endif
                          @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show" id="tab{{ $stream->id }}" role="tabpanel" aria-labelledby="tab{{ $stream->id }}-tab">
    
                          </div>
                        @foreach($groups as $gr)
                        @if ($gr->stream_id == $stream->id && $stream->full_name != '')
                          <div class="tab-pane fade show" id="tab{{ $gr->id }}" role="tabpanel" aria-labelledby="tab{{ $gr->id }}-tab">
                            <!---->
    
                            <body>
                              <table class="table">
                                <thead>
                                  <tr class="tr">
                                    <th class="th" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;">ФИО Студента  </th>
                                    <th class="th" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;">Руководитель</th>
                                    <th class="th" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;">Статус</th>
                                  </tr>
                                </thead>
                            <tbody>
                              @foreach($students as $student)
                                @if($gr->id == $student->group_id)
                                  @foreach($student_practic as $studPrac)
                                    @if ($student->id == $studPrac->student_id) <!--Условие для отбора студентов практики по группам-->
                                      <tr class="tr">
                                        <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">{{ $student->fio}}</strong></td>
                                        @if(!$studPrac->teacher_id)
                                          <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">-</strong></td>
                                        @else
                                          <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">
                                            @foreach ($teacher_score as $teacherScore)
                                              @if($teacherScore->id == $studPrac->teacher_id)
                                                @foreach($teachers as $teacher)
                                                  @if($teacher->id == $teacherScore->teacher_id)
                                                    {{$teacher->fio}} </strong></td>
                                                  @endif
                                                @endforeach
                                              @endif
                                            @endforeach
                                        @endif
                                        @switch($studPrac->status)
                                          @case(0)
                                            <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">Ожидается ответ</strong></td>
                                            @break
                                          @case(1)
                                            <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">Принят</strong></td>
                                            @break
                                          @case(2)
                                            <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">Не принят</strong></td>
                                            @break
                                        @endswitch
                                      </tr>
                                    @endif
                                  @endforeach
                                  <tr class="tr">
                                      <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">{{ $student->fio}}</strong></td>
                                      <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">-</strong></td>
                                      <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">-</strong></td>
                                    </tr>
                                @endif
                              @endforeach
                            </tbody>
                          </table>
                        </body>
                          @php ($showButton = true)
                          @foreach($templates as $template)
                            @if($template->group_id == $gr->id)
                              @if($template->decanat_check == 0)                         
                              <div class="d-flex flex-row bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 25rem;">
                                      <h6>В ожидании проверки</h6>
                                  </div>
                                </div>
                              @elseif($template->decanat_check == 1)
                                <div class="d-flex flex-row-reverse bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 10rem;">
                                      <h6>Принят</h6>
                                  </div>
                                </div>
                              @php($showButton = false)
                              @elseif($template->decanat_check == 2 && $template->comment != NULL)
                                <div class="d-flex flex-row bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 50rem;">
                                      <h6>Не принят - {{$template->comment}}</h6>
                                  </div>
                                </div>
                              @elseif($template->decanat_check == 2 && $template->comment == NULL)
                                <div class="d-flex flex-row bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 10rem;">
                                      <h6>Не принят</h6>
                                  </div>
                                </div>  
                              @endif
                              @break
                            @endif
                          @endforeach
                            @if ($showButton)
                              <form method="post" action="/direct/shablon_prikazy" class="d-flex justify-content-end">
                                <div class="d-flex flex-row-reverse bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 15rem;">
                                    @csrf
                                    <button name="download" value="{{ $gr->id }}" class="btn btn-primary" type="submit"> <h6> Сформировать приказ </h6> </button>
                                  </div>
                                </div>
                              </form>
                            @endif
                          </div>
                          @endif
                        @endforeach
                        </div>
                      @elseif($stream->profile_id == $profile->id && strpos($stream->name, "м") && (date("Y") - $stream->year < 3 and date("Y") - $stream->year > 0) && $stream->full_name != '' && $form=="Магистратура")
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                          @foreach($groups as $gr)
                            @if ($gr->stream_id == $stream->id && $stream->full_name != '' )
                              @if($gr->group_number == 1)
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active" id="tab{{ $stream->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $stream->id }}"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Скрыть</button>
                                </li>
                              @endif
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab{{ $gr->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $gr->id }}"
                                type="button" role="tab" aria-controls="home" aria-selected="true">{{ $stream->name }}-{{ $gr->group_number }}</button>
                              </li>
                            @endif
                          @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane fade show" id="tab{{ $stream->id }}" role="tabpanel" aria-labelledby="tab{{ $stream->id }}-tab">
    
                          </div>
                        @foreach($groups as $gr)
                        @if ($gr->stream_id == $stream->id && $stream->full_name != '')
                          <div class="tab-pane fade show" id="tab{{ $gr->id }}" role="tabpanel" aria-labelledby="tab{{ $gr->id }}-tab">
                            <!---->
    
                            <body>
                              <table class="table">
                                <thead>
                                  <tr class="tr">
                                    <th class="th" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;">ФИО Студента  </th>
                                    <th class="th" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;">Руководитель</th>
                                    <th class="th" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;">Статус</th>
                                  </tr>
                                </thead>
                            <tbody>
                              @foreach($students as $student)
                                @if($gr->id == $student->group_id)
                                  @foreach($student_practic as $studPrac)
                                    @if ($student->id == $studPrac->student_id) <!--Условие для отбора студентов практики по группам-->
                                      <tr class="tr">
                                        <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">{{ $student->fio}}</strong></td>
                                        @if(!$studPrac->teacher_id)
                                          <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">-</strong></td>
                                        @else
                                          <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">
                                            @foreach ($teacher_score as $teacherScore)
                                              @if($teacherScore->id == $studPrac->teacher_id)
                                                @foreach($teachers as $teacher)
                                                  @if($teacher->id == $teacherScore->teacher_id)
                                                    {{$teacher->fio}} </strong></td>
                                                  @endif
                                                @endforeach
                                              @endif
                                            @endforeach
                                        @endif
                                        @switch($studPrac->status)
                                          @case(0)
                                            <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">Ожидается ответ</strong></td>
                                            @break
                                          @case(1)
                                            <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">Принят</strong></td>
                                            @break
                                          @case(2)
                                            <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">Не принят</strong></td>
                                            @break
                                        @endswitch
                                      </tr>
                                    @else
                                      <tr class="tr">
                                          <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">{{ $student->fio}}</strong></td>
                                          <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">-</strong></td>
                                          <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">-</strong></td>
                                      </tr>
                                    @endif
                                  @endforeach
                                @endif
                              @endforeach
                            </tbody>
                          </table>
                        </body>
                          @php ($showButton = true)
                          @foreach($templates as $template)
                            @if($template->group_id == $gr->id)
                              @if($template->decanat_check == 0)                         
                              <div class="d-flex flex-row bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 25rem;">
                                      <h6>В ожидании проверки</h6>
                                  </div>
                                  <div class="alert alert-info" role="alert">
                                      В ожидании проверки
                                  </div>
                                </div>
                              @elseif($template->decanat_check == 1)
                                <div class="d-flex flex-row-reverse bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 10rem;">
                                      <h6>Принят</h6>
                                  </div>
                                  <div class="alert alert-success" role="alert">
                                      Принят
                                  </div>  
                                </div>
                              @php($showButton = false)
                              @elseif($template->decanat_check == 2)
                                <div class="d-flex flex-row bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 50rem;">
                                      <h6>Не принят - {{$template->comment}}</h6>
                                  </div>
                                  <div class="alert alert-warning" role="alert">
                                      Не принят
                                  </div> 
                                  @if ($template->comment != NULL)
                                      <div class="alert alert-secondary" role="alert">
                                          {{$template->comment}}
                                      </div> 
                                  @endif
                                </div>
                              @endif
                              @break
                            @endif
                          @endforeach
                            @if ($showButton)
                              <form method="post" action="/direct/shablon_prikazy" class="d-flex justify-content-end">
                                <div class="d-flex flex-row-reverse bd-highlight">
                                  <div class="badge bg-primary text-wrap" style="width: 15rem;">
                                    @csrf
                                    <button name="download" value="{{ $gr->id }}" class="btn btn-primary" type="submit"> <h6> Сформировать приказ </h6> </button>
                                  </div>
                                </div>
                              </form>
                            @endif
                          </div>
                          @endif
                        @endforeach
                        </div>
                      @endif
                    @endforeach
                  @endif
                @endforeach
              </div>
            </div>
        @endforeach
      @endforeach
    </div>
@endsection
