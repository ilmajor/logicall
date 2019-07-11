@extends('layouts.master')

@section('content')

	<div class="col-sm-8">
		<h1>Регистрация</h1>
		<hr>

		<form method="POST" action="/lk/register">

			{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Имя оператора" required>
			{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
		</div>			

		<div class="form-group">
			<label for="login">Логин</label>
			<input type="text" class="form-control" id="login" name="login" placeholder="Логин оператора" required>
			{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
		</div>

		<div class="form-group">
			<label for="id_user">Id оператора</label>
			<input type="text" class="form-control" id="id_user" name="id_user" placeholder="00000000-0000-0000-0000-000000000000" required>
			{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
		</div>

		<div class="form-group">
			<label for="password">Пароль</label>
			<input type="password" class="form-control" id="password" placeholder="Пароль" name="password" required>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Регистрация</button>
		</div>

		</form>
		<div class="form-group">
			@include('layouts.errors')
		</div>

	</div>

@endsection