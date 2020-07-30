@extends ('admin.layouts.master')
@section('content')
	
	<h1>Создать задачу.</h1>
	<hr>


	<form method="POST" action="/lk/admin/task/create">
		
		{{ csrf_field() }}

        <div class="form-group">
            <label for="task_id">Выберете задачу:</label>
            <select class="form-control form-control" id="task_id" name="task_id" aria-describedby="task_id">
            	<option></option>
                @foreach($OktellTasks as $task)
                    <option value="{{$task->Id}}">{{$task->Name}}</option>
                @endforeach
            </select> 
        </div>

		<div class="form-group">
			<label for="task_table">Таблица абонентов:</label>
			<input type="text" class="form-control" id="task_table" name="task_table" required>
		</div>

		<div class="form-group">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="is_new_algorithm" name="is_new_algorithm" value="true">
				<label class="form-check-label" for="inlineCheckbox1">Ноый алгоритм обзвона</label>
			</div>
		</div>

		<div class="form-group">
			<label for="task_abonent">Оперативная таблица абонентов:</label>
			<input type="text" class="form-control" id="task_abonent" name="task_abonent">
		</div>

		<div class="form-group">
			<label for="task_phone">Оперативная таблица номеров:</label>
			<input type="text" class="form-control" id="task_phone" name="task_phone">
		</div>
		
		<div class="form-group">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="is_taskid" name="is_taskid" value="true">
				<label class="form-check-label" for="inlineCheckbox1">Есть линк по Id Task</label>
			</div>
		</div>
		<div class="form-group">
			<label for="status_call_table">Таблица записи кодов завершения:</label>
			<input type="text" class="form-control" id="status_call_table" name="status_call_table" aria-describedby="status_call_table">
		</div>
		<div class="form-group">
			<label for="client_id">Поле таблицы для ID клиента:</label>
			<input type="text" class="form-control" id="client_id" name="client_id" aria-describedby="client_id">
		</div>

		<hr>
		<h6>Начальные настройки для задачи.</h6>
		<div class="form-group">
			<label for="waitcall_max">Верхняя граница ожидания оператором нового звонка:</label>
			<input type="text" class="form-control" id="waitcall_max" name="waitcall_max">
		</div>
		<div class="form-group">
			<label for="waitcall_min">Нижняя граница ожидания оператором нового звонка:</label>
			<input type="text" class="form-control" id="waitcall_min" name="waitcall_min">
		</div>
		<div class="form-group">
			<label for="CallMaxCount">Максимальное количество звонков на оператора:</label>
			<input type="text" class="form-control" id="CallMaxCount" name="CallMaxCount">
		</div>
		<div class="form-group">
			<label for="max_queue">Макисмальная длина очереди для задачи:</label>
			<input type="text" class="form-control" id="max_queue" name="max_queue">
		</div>
		<div class="form-group">
			<label for="StartHour">Час начала работы задачи:</label>
			<input type="text" class="form-control" id="StartHour" name="StartHour">
		</div>
		<div class="form-group">
			<label for="startcount">Стартовое значение числа звонков на день для задачи:</label>
			<input type="text" class="form-control" id="startcount" name="startcount">
		</div>
		<div class="form-group">
			<label for="startqueue">Стартовое значение очереди на день для задачи:</label>
			<input type="text" class="form-control" id="startqueue" name="startqueue">
		</div>
		<div class="form-group">
			<label for="count_calls">Количество звонков на клиента:</label>
			<input type="text" class="form-control" id="count_calls" name="count_calls">
		</div>
		<div class="form-group">
			<label for="min_client_time_calls">Начало допустимого интервала звонка:</label>
			<input type="text" class="form-control" id="min_client_time_calls" name="min_client_time_calls" aria-describedby="min_client_time_calls">
		</div>
		<div class="form-group">
			<label for="max_client_time_calls">Конец допустимого интервала звонка:</label>
			<input type="text" class="form-control" id="max_client_time_calls" name="max_client_time_calls" aria-describedby="max_client_time_calls">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('admin.layouts.errors')

	</form>

@endsection