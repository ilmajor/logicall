@extends ('layouts.master')
@section('content')
  
    <h1>{{ $task->name }}</h1>
    <hr>
     <div id="accordion">
        @foreach ($baseSize as $base )
         
            <div class="card">
              <div class="card-header" id="headingOne{{ $base->ID_CAMPAIGN}}{{ $base->dte }}">
                 <li class="list-group-item d-flex justify-content-between align-items-center">
                   <button class="btn btn-link" data-toggle="collapse" data-target="#{{ $base->ID_CAMPAIGN}}{{ $base->dte }}" aria-expanded="true" aria-controls="{{ $base->ID_CAMPAIGN}}{{ $base->dte }}">
                      {{ $base->ID_CAMPAIGN}}
                      | {{ $base->dte}}
                      | {{ $base->baseSize}}
                      | {{ $base->baseSizeDaily}}
                    </button>
                    @if($base->baseSizeDaily < $base->baseSize && $base->done == 3 )
                      <span class="badge badge-danger badge-pill">База отключенна</span>
                    @elseif($base->baseSizeDaily < $base->baseSize && $base->done < 2 )
                      <span class="badge badge-danger badge-pill">База отключенна | База отключена</span>
                    @elseif($base->baseSizeDaily < $base->baseSize && $base->done == 2 )
                      <span class="badge badge-danger badge-pill">База отключенна | База приостановлена</span>
                    @else
                      <span class="badge badge-success badge-pill">База включена</span>
                    @endif
                  </li>
              </div>
            </div>
            <div class="card">
                <div id="{{ $base->ID_CAMPAIGN}}{{ $base->dte }}" class="collapse" aria-labelledby="headingOne{{ $base->ID_CAMPAIGN}}{{ $base->dte }}" data-parent="#accordion">
                  <div class="card-body">

                    @if($base->baseSizeDaily < $base->baseSize && $base->done == 3 )
                      <p><a href='/lk/project/tecos/start/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}/{{ $base->dte}}' class='btn btn-success'>Включить</a></p>
                    @elseif($base->baseSizeDaily < $base->baseSize && $base->done < 2 )
                      <p><a href='/lk/project/tecos/start/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}/{{ $base->dte}}' class='btn btn-success'>Включить</a></p>
                    @elseif($base->baseSizeDaily < $base->baseSize && $base->done == 2 )
                      <p><a href='/lk/project/tecos/start/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}/{{ $base->dte}}' class='btn btn-success'>Включить</a></p>
                    @else
                      <p><a href='/lk/project/tecos/stopTemporarily/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}/{{ $base->dte}}' class='btn btn-danger'>Выключить только для Oktell</a></p>
                      <p><a href='/lk/project/tecos/stopForever/{{ $task->id }}/{{ $base->ID_CAMPAIGN}}/{{ $base->dte}}' class='btn btn-danger'>Выключить совсем!!!</a></p>
                    @endif
                  </div>

                </div>
            </div>
            
          
        @endforeach
    </div>
@endsection
<span class="badge badge-secondary" data-toggle="tooltip" data-placement="top"></span>
