@extends ('admin.layouts.master')
@section('content')
	
	<h1>Площадки.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($city as $values )
              <tr>
                <td>{{ $values->name}}</td>
                <td><a href="/lk/admin/city/{{ $values->id }}" class="btn btn-warning">Редактировать</a></td>
                <td>
                  <form method="POST" action="/lk/admin/city/{{ $values->id }}">
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