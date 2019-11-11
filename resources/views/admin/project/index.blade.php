@extends ('admin.layouts.master')
@section('content')
	
	<h1>Задачи для Тэкос.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($project as $values )
              <tr>
                <td>{{ $values->name}}</td>
                    @if($values->is_enabled == true)
                      <td><span class="badge badge-success badge-pill">Активен</span></td>
                    @else
                      <td><span class="badge badge-primary badge-pill">Завершен</span></td>
                    @endif

                <td><a href="/lk/admin/project/{{ $values->id }}" class="btn btn-warning">Редактировать</a></td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>

@endsection