@extends ('admin.layouts.master')
@section('content')
	
<h1>Задача {{ $Task->name }} \\ Проект {{ $Task->project->name }}</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/task/{{ $Task->id }}">
		<div class="form-group">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="task_table">Таблица абонентов.</label>
				<input type="text" class="form-control" id="task_table" name="task_table" aria-describedby="task_table" 
				value="{{ $Task->task_table }}">
			</div>
			<div class="form-group">
				<label for="task_abonent">Оперативная таблица абонентов:</label>
				<input type="text" class="form-control" id="task_abonent" name="task_abonent" aria-describedby="task_abonent" 
				value="{{ $Task->task_abonent }}">
			</div>
			<div class="form-group">
				<label for="task_phone">Оперативная таблица номеров:</label>
				<input type="text" class="form-control" id="task_phone" name="task_phone" aria-describedby="task_phone" 
				value="{{ $Task->task_phone }}">
			</div>
			<div class="form-group">
				<div class="form-check form-check-inline">
					@if( $Task->is_taskid == true )
						<input class="form-check-input" type="checkbox" id="is_taskid" name="is_taskid" value="{{ $Task->id }}" checked>
					@else
						<input class="form-check-input" type="checkbox" id="is_taskid" name="is_taskid" value="{{ $Task->id }}">
					@endif
					<label class="form-check-label" for="inlineCheckbox1">Есть линк по Id Task</label>
				</div>
			</div>
			<div class="form-group">
				<label for="min_client_time_calls">Начало допустимого интервала звонка:</label>
				<input type="text" class="form-control" id="min_client_time_calls" name="min_client_time_calls" aria-describedby="min_client_time_calls" 
				value="{{ $Task->min_client_time_calls }}">
			</div>
			<div class="form-group">
				<label for="max_client_time_calls">Конец допустимого интервала звонка:</label>
				<input type="text" class="form-control" id="max_client_time_calls" name="max_client_time_calls" aria-describedby="max_client_time_calls" 
				value="{{ $Task->max_client_time_calls }}">
			</div>

		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection