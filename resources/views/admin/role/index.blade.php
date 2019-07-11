@extends ('admin.layouts.master')
@section('content')
	
	<h1>Пользователи ЛК.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($Roles as $role )
              <tr>
                <td>{{ $role->name}}</td>
                <td>{{ $role->description }}</td>
                <td><a href="/lk/admin/role/{{ $role->id }}" class="btn btn-warning">Редактировать</a></td>
                <td>
                  <form method="POST" action="/lk/admin/role/{{ $role->id }}">
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