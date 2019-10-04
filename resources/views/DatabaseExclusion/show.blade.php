@extends ('layouts.master')
@section('content')
    <h1>Задача {{$task->name}}</h1>
    <hr>


    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="exclude-tab" data-toggle="tab" href="#exclude" role="tab" aria-controls="exclude" aria-selected="true">Исключить</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="include-tab" data-toggle="tab" href="#include" role="tab" aria-controls="include" aria-selected="false">Включить</a>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="exclude" role="tabpanel" aria-labelledby="exclude-tab">
            <div class="table-responsive">
                <form method="POST" action="/lk/DatabaseExclusion/{{ $task->id }}">
                    {{ csrf_field() }}
                    <div class="container">
                        <div class="row">
                            <div class="form-group">

                                @if(!empty($columnsExclusion))
                                    @foreach($columnsExclusion as $column => $values)
                                        <label for="project">{{$column}}:</label>   
                                         <select class="custom-select" name="{{$column}}"> 
                                            @foreach($values as $value => $data)
                                                @if(!empty($value) or $data != Null)
                                                    <option value="{{ $value }}">{{ $value }} | {{$data}}</option>
                                                @else
                                                    <option disabled>Выключать нечего :(</option> 
                                                @endif
                                            @endforeach 
                                        </select>
                                    @endforeach 
                                @else
                                    <label for="project">Выключать нечего :(</label> 
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Исключить</button>
                    </div>
                </form>
                
            </div>
        </div>

        <div class="tab-pane fade" id="include" role="tabpanel" aria-labelledby="include-tab">
            <div class="table-responsive">
                <form method="POST" action="/lk/DatabaseInclusion/{{ $task->id }}">
                    {{ csrf_field() }}
                    <div class="container">
                        <div class="row">
                            <div class="form-group">
                                @if(!empty($columnsInclusion))
                                    @foreach($columnsInclusion as $column => $values)
                                        <label for="project">{{$column}}:</label>   
                                         <select class="custom-select" name="{{$column}}"> 
                                            @foreach($values as $value => $data)
                                                @if(!empty($value) or $data != Null)
                                                    <option value="{{ $value }}">{{ $value }} | {{$data}}</option>
                                                @else
                                                    <option disabled>Включать нечего :(</option> 
                                                @endif
                                            @endforeach 
                                        </select>
                                    @endforeach 
                                @else
                                    <label for="project">Включать нечего :(</label> 
                                @endif

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Включить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection