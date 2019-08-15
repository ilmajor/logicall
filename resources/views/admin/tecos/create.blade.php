@extends ('admin.layouts.master')
@section('content')
	
	<h1>Добавить задачу в Тэкос.</h1>
	<hr>


	<form method="POST" action="/lk/admin/project/sberbank/tecos/create ">
		
		{{ csrf_field() }}

		<div class="form-group">
			<label for="task">Выберете задачу.</label>
			<select class="form-control form-control" id="task" name="task" aria-describedby="task" >
				@foreach($tasks as $task)
					<option value='{{$task->id}}'>{{$task->name}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="task_table">Таблица задачи.</label>
			<input type="text" class="form-control" id="task_table" name="task_table" required>
		</div>



		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('admin.layouts.errors')

	</form>

@endsection