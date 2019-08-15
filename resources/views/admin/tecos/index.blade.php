@extends ('admin.layouts.master')
@section('content')
	
	<h1>Задачи для Тэкос.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($tecos as $values )
              <tr>
                <td>{{ $values->task->name}}</td>
                <td><a href="/lk/admin/project/sberbank/tecos/{{ $values->id }}" class="btn btn-warning">Редактировать</a></td>
                <td>
                  <form method="POST" action="/lk/admin/project/sberbank/tecos/{{ $values->id }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <div class="form-group">
                      <input type="submit" class="btn btn-danger" value="Удалить">
                    </div>
                  </form>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>

@endsection