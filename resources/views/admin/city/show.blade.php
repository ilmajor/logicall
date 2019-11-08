@extends ('admin.layouts.master')
@section('content')
	
<h1>Пользователь {{ $city->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/city/{{ $city->id }}">

		{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя:</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ $city->name }}" required>
		</div>

		<div class="form-group">
			<label for="address">Адрес:</label>
			<input type="text" class="form-control" id="address" name="address" value="{{ $city->address }}" required>
		</div>

		<div class="form-group">
		<label for="director">Руководель:</label>
		<select class="form-control form-control" id="director" name="director" aria-describedby="director" required>
			@foreach($managers as $manager)
				@if((!empty($city)) && ($manager->id == $city->director))
					<option value="{{$manager->id}}" selected>{{$manager->name}}</option>
				@else 
					<option value="{{$manager->id}}">{{$manager->name}}</option>
				@endif
			@endforeach
		</select>
		</div>

		@include('admin.layouts.errors')

		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection