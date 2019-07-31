@extends ('admin.layouts.master')
@section('content')
	<h1>Разделы на главном экране.</h1>
	<hr>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <tbody>
          @foreach ($sections as $section )
              <tr>
                <td>{{ $section->title !== null ? $section->title : ''}}</td>
                <td>{{ !empty($section->role->first()->name) ? $section->role->pluck('name')->implode(' | ') : '' }}</td>
                <td><a href="/lk/admin/section/{{ $section->id }}" class="btn btn-warning">Редактировать</a></td>
                <td>
                  <form method="POST" action="/lk/admin/section/{{ $section->id }}">
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