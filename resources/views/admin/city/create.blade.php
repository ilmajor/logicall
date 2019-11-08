@extends ('admin.layouts.master')
@section('content')
	
	<h1>Создать площадку.</h1>
	<hr>


	<form method="POST" action="/lk/admin/city/create ">
		
		{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя:</label>
			<input type="text" class="form-control" id="name" name="name" required>
		</div>

		<div class="form-group">
			<label for="address">Адрес:</label>
			<input type="text" class="form-control" id="address" name="address" required>
		</div>

		<div class="form-group">
			<label for="director">Руководель:</label>
			<select class="form-control form-control" id="director" name="director" aria-describedby="director" >
				@foreach($managers as $manager)
					<option value='{{$manager->id}}'>{{$manager->name}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('admin.layouts.errors')

	</form>

@endsection