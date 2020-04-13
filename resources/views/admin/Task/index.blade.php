@extends ('admin.layouts.master')
@section('content')
	
	<h1>Задачи Oktell в ЛК.</h1>
	<hr>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="outbound-tab" data-toggle="tab" href="#outbound" role="tab" aria-controls="outbound" aria-selected="true">Входящие</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="inbound-tab" data-toggle="tab" href="#inbound" role="tab" aria-controls="inbound" aria-selected="false">Исходящие</a>
  </li>
</ul> 
 <div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="outbound" role="tabpanel" aria-labelledby="outbound-tab">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Имя</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($Tasks as $task )
            @if($task->is_outbound == 0)
              <tr>
                <td>{{ $task->name}}</td>
                <td>{{ $task->project->name }}</td>
                <td><a href="/lk/admin/task/{{ $task->id }}" class="btn btn-warning">Редактировать</a></td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="tab-pane fade" id="inbound" role="tabpanel" aria-labelledby="inbound-tab">
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Имя</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($Tasks as $task )
            @if($task->is_outbound == 1)
              <tr>
                <td>{{ $task->name}}</td>
                <td>{{ $task->project->name }}</td>
                <td><a href="/lk/admin/task/{{ $task->id }}" class="btn btn-warning">Редактировать</a></td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection