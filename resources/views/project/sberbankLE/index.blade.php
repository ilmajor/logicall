@extends ('layouts.master')
@section('content')

<h1>Задачи.</h1>
<hr>
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <tbody>
      @foreach ($tecos as $tasks )
        <tr>
          <td>{{ $tasks->task->name}}</td>
          <td><a href="/lk/project/tecos/{{ $tasks->task->id }}" class="btn btn-warning">Редактировать</a></td>
        </tr> 
      @endforeach
    </tbody>
  </table>
</div>


@endsection