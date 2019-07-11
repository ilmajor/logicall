@extends ('admin.layouts.master')
@section('content')
	
	<h1>Создать роль.</h1>
	<hr>


	<form method="POST" action="/lk/admin/role/create">
		
		{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя</label>
			<input type="text" class="form-control" id="name" name="name" required>
		</div>

		<div class="form-group">
			<label for="description">Описание</label>
			<input type="text" class="form-control" id="description" name="description" required>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('admin.layouts.errors')

	</form>

@endsection