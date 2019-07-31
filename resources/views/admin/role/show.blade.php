@extends ('admin.layouts.master')
@section('content')
	
<h1>Пользователь {{ $role->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/role/{{ $role->id }}">
		<div class="form-group">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="name">Название роли.</label>
				<input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="{{ $role->name }}">
			</div>
			<div class="form-group">
				<label for="description">Описание.</label>
				<input type="text" class="form-control" id="description" name="description" aria-describedby="description" value="{{ $role->description }}">
			</div>

			<div class="form-group">
				<label for="weight">Описание.</label>
				<input type="text" class="form-control" id="weight" name="weight" aria-describedby="weight" value="{{ $role->weight }}">
			</div>
			
		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection