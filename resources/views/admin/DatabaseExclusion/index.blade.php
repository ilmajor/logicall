@extends ('admin.layouts.master')
@section('content')
	
	<h1>Настройки для исключения базы абонентов.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($Tasks as $task )
              <tr>
                <td>{{ $task->name}}</td>
                <td>{{ $task->project->name }}</td>
                <td><a href="/lk/admin/DatabaseExclusion/{{ $task->id }}" class="btn btn-warning">Редактировать</a></td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>

@endsection