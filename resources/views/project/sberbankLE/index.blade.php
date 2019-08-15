@extends ('layouts.master')
@section('content')
  
    <h1>Задачи.</h1>
    <hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($tasks as $task )
              <tr>
                <td>{{ $task->name}}</td>

                <td><a href="/lk/project/tecos/{{ $task->id }}" class="btn btn-warning">Редактировать</a></td>
                <td>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>


@endsection