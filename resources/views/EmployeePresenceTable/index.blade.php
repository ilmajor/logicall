@extends ('layouts.master')
@section('content')
{{--  <div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ">
      <h1 style=" display: inline;">Задача {{$task->name}}</h1>

        <a class="btn btn-primary float-right" href="/lk/CompletionCodes/{{$task->id}}/create" role="button">Добавить код завершения</a>
    </div>
  </div>
</div> --}}
<h4>Доступные задачи:</h4>
<h5>{{ $projects->pluck('name')->implode(' | ') }}</h5>

     <div class="table-responsive">
      <table class="table table-striped table-sm table-bordered">
        <thead>
          <tr>
            <th>ФИО</th>
            <th>отработанно часов в месяц</th>
            <th>рабочие дни</th>
            <th>выходных</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
              <td>{{$user->profiles->FullName}}</td>
              <td>{{$user->work_time}}</td>
              <td>{{$user->condition1}}</td>
              <td>{{$user->condition2}}</td>
              <td><a href="/lk/EmployeePresence/{{ $user->id }}">Редактировать</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection