@extends ('admin.layouts.master')
@section('content')
	
<h1>Пользователь {{ $ContractingOrganization->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/ContractingOrganization/{{ $ContractingOrganization->id }}">

		{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя:</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ $ContractingOrganization->name }}" required>
		</div>

		@include('admin.layouts.errors')

		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection