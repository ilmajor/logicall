@extends ('layouts.master')
@section('content')
	
<div class="table-responsive">
	<form method="POST" action="/lk/city/{{ $city->id }}">

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
		<div class="form-group">


		<div class="form-group">
			<label for="CCTV">видеонаблюдение:</label>
			<textarea 
				type="text" 
				class="form-control" 
				id="CCTV" 
				name="CCTV" 
				
				rows="3" 
				required
			>{{ $city->CCTV }}</textarea>
		</div>

		<div class="form-group">
			<label for="security_phone_numbers">номера телофонов охраны:</label>
			<textarea 
				type="text" 
				class="form-control" 
				id="security_phone_numbers" 
				name="security_phone_numbers" 
				rows="3" 
				required
			>{{ $city->security_phone_numbers }} </textarea>
		</div>

		@include('layouts.errors')

		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection