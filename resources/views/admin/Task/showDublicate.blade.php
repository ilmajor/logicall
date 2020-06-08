@extends ('admin.layouts.master')
@section('content')
	
<h1>Задача {{ $Task->name }} \\ Проект {{ $Task->project->name }}</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/task/{{ $Task->id }}/dublicate">
		<div class="form-group">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="task_id">Выберете задачу:</label>
				<select class="form-control form-control" id="task_id" name="task_id" aria-describedby="task_id">
					<option></option>
					@foreach($OktellTasks as $task)
						<option value="{{$task->uuid}}">{{$task->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="tables">Тип копирования таблиц:</label>
				<select class="form-control form-control" id="tables" name="tables" aria-describedby="tables">
					<option value="create">Создать заново</option>
					<option value="duplicate">Дублировать</option>
				</select>
			</div>

		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	

</div>
@endsection