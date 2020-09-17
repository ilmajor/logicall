@extends ('layouts.master')
@section('content')

<h1>Изменение URL</h1>
<hr>
<div class="table-responsive-sm">
  <table class="table">
    <tbody>
      @foreach ($data as $value )
        <tr>
          <form method="POST" action="/lk/project/alfabankUrl/{{ $value->Id }}">
            {{ csrf_field() }}
            <td>{{ $value->task->name}}</td>
            <td><input class="form-control" type="text" name="url" id="url"value="{{ $value->url}}"></td>
            <td><button type="submit" class="btn btn-primary">Сохранить</button></td>
          </form>
        </tr> 
      @endforeach
    </tbody>
  </table>
</div>


@endsection