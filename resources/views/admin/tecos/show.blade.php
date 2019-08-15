@extends ('admin.layouts.master')
@section('content')
	
<h1>Пользователь {{ $tecos->task->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/project/sberbank/tecos/{{ $tecos->id }}">
		<div class="form-group">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="task_table">Таблица задачи.</label>
				<input type="text" class="form-control" id="task_table" name="task_table" aria-describedby="task_table" value="{{ $tecos->task_table }}">
			</div>

			<div class="form-group">
				<label for="task_table_daily">Оперативная таблица задачи.</label>
				<input type="text" class="form-control" id="task_table_daily" name="task_table_daily" aria-describedby="task_table_daily" value="{{ $tecos->task_table_daily }}">
			</div>
			
		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection