@extends ('layouts.master')
@section('content')
  
    <h1>{{ $task->name }}</h1>
    <hr>
    <div class="accordion" id="accordionExample{{ $task->id}}">
        @foreach ($baseSize as $base )
          
            <div class="card">
              <div class="card-header" id="headingOne{{ $base->ID_CAMPAIGN}}">
                 <li class="list-group-item d-flex justify-content-between align-items-center">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne{{ $base->ID_CAMPAIGN}}" aria-expanded="true" aria-controls="collapseOne{{ $base->ID_CAMPAIGN}}">
                      {{ $base->ID_CAMPAIGN}}
                      | {{ $base->dte}}
                      | {{ $base->baseSize}}
                      | {{ $base->baseSizeDaily}}
                    </button>
                    @if($base->baseSizeDaily < $base->baseSize)
                      <span class="badge badge-danger badge-pill">База отключенна</span>
                    @else
                      <span class="badge badge-success badge-pill">База включена</span>
                    @endif
                  </li>
              </div>
              <div id="collapseOne{{ $base->ID_CAMPAIGN}}" class="collapse" aria-labelledby="headingOne{{ $base->ID_CAMPAIGN}}" data-parent="#accordionExample{{ $task->id}}">
                <div class="card-body">
                  @if($base->baseSizeDaily < $base->baseSize)
                    <p><a href='/lk/project/tecos/start/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}' class='btn btn-success'>Включить</a></p>
                  @else
                    <p><a href='/lk/project/tecos/stopTemporarily/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}' class='btn btn-danger'>Выключить только для Oktell(не быдет выгружатся отчет RESP)</a></p>
                    <p><a href='/lk/project/tecos/stopForever/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}' class='btn btn-danger'>Выключить совсем!!!</a></p>
                  @endif

                </div>
              </div>
            </div>
          
        @endforeach
    </div>
@endsection
<span class="badge badge-secondary" data-toggle="tooltip" data-placement="top"></span>