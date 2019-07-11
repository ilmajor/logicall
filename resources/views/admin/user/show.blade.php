@extends ('admin.layouts.master')
@section('content')
	
<h1>Пользователь {{ $User->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/users/{{ $User->id }}">
		<div class="form-group">
			{{ csrf_field() }}
	 		@foreach($Roles as $role)
				<div class="form-check form-check-inline">
				  @if(!empty($UserRoles->find($role->id)))
				  	<input class="form-check-input" type="checkbox" id="{{ $role->name }}" name="role[]" value="{{ $role->id }}" checked>
				  @else
				 	<input class="form-check-input" type="checkbox" id="{{ $role->name }}" name="role[]" value="{{ $role->id }}" >
				  @endif
				  <label class="form-check-label" for="inlineCheckbox1">{{ $role->name }}</label>
				</div>
			@endforeach
		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection