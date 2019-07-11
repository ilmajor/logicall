@extends ('admin.layouts.master')
@section('content')
	
	<h1>Пользователи ЛК.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($Users as $user )
              <tr>
                <td>{{ $user->name}}</td>
                <td><a href="/lk/admin/users/{{ $user->id }}" class="btn btn-warning">Редактировать</a></td>

              </tr>
          @endforeach
        </tbody>
      </table>
    </div>



@endsection