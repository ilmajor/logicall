@extends ('layouts.master')
@section('content')
 <div class="container-fluid">
  <div class="row">
    <div class="col-md-12 ">
      <h1 style=" display: inline;">Задача {{$task->name}}</h1>

        <a class="btn btn-primary float-right" href="/lk/CompletionCodes/{{$task->id}}/create" role="button">Добавить код завершения</a>
    </div>
  </div>
</div>


    <hr>   
    <div class="table-responsive">
      <table class="table table-striped table-sm table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>Name</th>
            <th>code_name</th>
            <th>code_descript</th>
            <th>Скрытый код</th>
            <th>TRUE</th>
            <th>DIAL</th>
            <th>PRESENTATION</th>
            <th>CONSENT</th>
            <th>CONSENT_OP</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($CompletionCodes as $CompletionCode)
            <tr>
              <td>{{$CompletionCode->Name}}</td>
              <td>{{$CompletionCode->code_name}}</td>
              <td>{{$CompletionCode->code_descript}}</td>
              <td>{{$CompletionCode->NotShow == true ? 'да': 'нет'}}</td>
              <td>{{$CompletionCode->TRUE == true ? 'да': 'нет'}}</td>
              <td>{{$CompletionCode->DIAL == true ? 'да': 'нет'}}</td>
              <td>{{$CompletionCode->PRESENTATION == true ? 'да': 'нет'}}</td>
              <td>{{$CompletionCode->CONSENT == true ? 'да': 'нет'}}</td>
              <td>{{$CompletionCode->CONSENT_OP == true ? 'да': 'нет'}}</td>
              <td>
                <a href="/lk/CompletionCodes/{{$task->id}}/{{ $CompletionCode->Result }}" class="btn btn-warning btn-sm">Редактировать</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
@endsection