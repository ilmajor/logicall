@extends ('layouts.master')
@section('content')
  
  <h1>Выберете задачу.</h1>

 	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($tasks as $task )
              <tr>
                <td>{{ $task->name}}</td>
                <td>{{ $task->project }}</td>
                <td><a href="/lk/algorithmSettings/{{ $task->id }}" class="btn btn-success">>></a></td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>




@endsection