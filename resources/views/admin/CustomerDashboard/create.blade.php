@extends ('admin.layouts.master')
@section('content')
	
	<h1>Создать dashboard.</h1>
	<hr>
	<form method="POST" action="/lk/admin/CustomerDashboard/create ">
		
		{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя:</label>
			<input type="text" class="form-control" id="name" name="name" required>
		</div>

		<div class="form-group">
			<label for="query">Запрос:</label>
			<textarea class="form-control" id="query" name="query" rows="3" required></textarea>
		</div>

		<div class="form-group">
			<label for="charts">Тип графика:</label>
			<select class="form-control form-control" id="charts" name="charts" aria-describedby="charts" >
				<option></option>
				<option value="line">line</option>
				<option value="pie">pie</option>
				<option value="column">column</option>
			</select>
		</div>

		<div class="form-group">
			<label for="project_id">Выберете проект.</label>
			<select class="form-control form-control" id="project_id" name="project_id" aria-describedby="project_id" >
				<option> </option>
				@foreach($Projects as $Project)
					<option value='{{$Project->id}}'>{{$Project->Name}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="timeout">Таймаут исполнения:</label>
			<input class="form-control" id="timeout" name="timeout" required>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('admin.layouts.errors')

	</form>

@endsection