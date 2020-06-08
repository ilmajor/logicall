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
				<label for="status_call_table">Таблица записи кодов завершения:</label>
				<input type="text" class="form-control" id="status_call_table" name="status_call_table" aria-describedby="status_call_table" 
				value="{{ $Task->status_call_table }}">
			</div>
			<div class="form-group">
				<label for="client_id">Поле таблицы для ID клиента:</label>
				<input type="text" class="form-control" id="client_id" name="client_id" aria-describedby="client_id" 
				value="{{ $Task->client_id }}">
			</div>

			
			<div class="form-group">
				<div class="form-check form-check-inline">
					@if( $Task->is_new_algorithm == true )
						<input class="form-check-input" type="checkbox" id="is_new_algorithm" name="is_new_algorithm" value="{{ $Task->id }}" checked>
					@else
						<input class="form-check-input" type="checkbox" id="is_new_algorithm" name="is_new_algorithm" value="{{ $Task->id }}">
					@endif
					<label class="form-check-label" for="inlineCheckbox1">Ноый алгоритм обзвона</label>
				</div>
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
				value="{{ empty($OktellSetting->MinClientTimeCalls) ? null : $OktellSetting->MinClientTimeCalls}}">
			</div>
			<div class="form-group">
				<label for="max_client_time_calls">Конец допустимого интервала звонка:</label>
				<input type="text" class="form-control" id="max_client_time_calls" name="max_client_time_calls" aria-describedby="max_client_time_calls" 
				value="{{ empty($OktellSetting->MaxClientTimeCalls) ? null : $OktellSetting->MaxClientTimeCalls }}">
			</div>

		</div>
		<a href="/lk/admin/task/{{ $Task->id }}/dublicate" class="btn btn-warning float-right" role="button">Создать скрипты и таблицы для задачи</a>
		<button type="submit" class="btn btn-primary float-left">Сохранить</button> 
		
	</form>	
</div>
@endsection