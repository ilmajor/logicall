@extends ('admin.layouts.master')
@section('content')
	
	<h1>Dashboard.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($CustomerDashboards as $CustomerDashboard )
              <tr>
                <td>{{ $CustomerDashboard->name}}</td>
                <td>
                  <a href="/lk/admin/CustomerDashboard/{{ $CustomerDashboard->id }}" class="btn btn-warning">Редактировать</a></td>
                <td>
                  <form method="POST" action="/lk/admin/CustomerDashboard/{{ $CustomerDashboard->id }}">
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