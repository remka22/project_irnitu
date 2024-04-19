@extends('layouts.app')
@section('content')
    <form method="post" action="/direct/twl" enctype="multipart/form-data">
        @csrf
        <input type="file" required name="teacher_workload_file" class="teacher_workload" id="teacher_workload_file"
            accept=".xlsx">
        <button class="btn btn-primary" type="submit">Отправить</button>
    </form>
    <form class="d-flex justify-content-end mb-2">
        <button name="upload_teacher" class="btn btn-warning">Загрузить нагрузку преподавателей</button>
    </form>
    <div class="accordion accordion-flush" id="accordionFlushExample">
      @foreach ($faculties as $faculty)
      <h2>{{$faculty->name}}</h2>
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
                      @if ($stream->profile_id == $profile->id && strpos($stream->name, "б") && (date("Y") - $stream->year_in < 5 and date("Y") - $stream->year_in > 0) && $stream->full_name != '' && $form=="Бакалавриат")
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
    
                            <!---->
                            <form class="d-flex justify-content-end">
                            <button name="download" value="{{ $gr->id }}" href="excel_php/direktsiya/download.php?{{$gr->id}}" class="btn btn-primary"  role="button" type="submit">Сформировать приказ</button>
                            </form>
                            <!---->
                          </script>
                          </div>
                          @endif
                        @endforeach
                        </div>
                      @elseif($stream->profile_id == $profile->id && strpos($stream->name, "м") && (date("Y") - $stream->year_in < 3 and date("Y") - $stream->year_in > 0) && $stream->full_name != '' && $form=="Магистратура")
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab{{ $stream->id }}-tab" data-bs-toggle="tab" data-bs-target="#tab{{ $stream->id }}"
                              type="button" role="tab" aria-controls="home" aria-selected="true">Скрыть</button>
                          </li>
                          @foreach($groups as $gr)
                            @if ($gr->stream_id == $stream->id && $stream->full_name != '' )
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
                                            <td class="td" style="width: 100px; font-family: Helvetica Neue OTS, sans-serif; text-align: center; vertical-align: middle;"><strong class="strong">Обрабатывается</strong></td>
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
    
                            <!---->
                            <form class="d-flex justify-content-end">
                              
                            </form>
                            <!---->
    
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
