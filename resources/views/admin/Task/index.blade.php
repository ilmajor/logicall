@extends ('admin.layouts.master')
@section('content')
	
	<h1>Пользователи ЛК.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($Tasks as $task )
              <tr>
                <td>{{ $task->name}}</td>
                <td>{{ $task->project }}</td>
                <td><a href="/lk/admin/task/{{ $task->id }}" class="btn btn-warning">Редактировать</a></td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>

@endsection