@extends ('layouts.master')
@section('content')
	
	<h1>Создать пользователя Oktell.</h1>
	<hr>


	<form method="POST" action="/lk/users/create">
		
		{{ csrf_field() }}

		<div class="form-group">
			<label for="Surname">Фамилия</label>
			<input type="text" class="form-control" id="Surname" name="Surname" required>
			{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
		</div>

		<div class="form-group">
			<label for="Name">Имя</label>
			<input type="text" class="form-control" id="Name" name="Name" required>
			{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
		</div>

		<div class="form-group">
			<label for="middleName">Отчество</label>
			<input type="text" class="form-control" id="middleName" name="middleName" required>
			{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
		</div>


		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('layouts.errors')

	</form>
	@if (!empty($data))
		@foreach ($data as $value )
			<div class="alert alert-success" role="alert">
				<li>
					{{ $value->answer}}
				</li>
			</div>
		@endforeach
	@endif
@endsection