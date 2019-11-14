@extends ('admin.layouts.master')
@section('content')
	
	<h1>Создать подрядную организацию.</h1>
	<hr>
	<form method="POST" action="/lk/admin/ContractingOrganization/create ">
		
		{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя:</label>
			<input type="text" class="form-control" id="name" name="name" required>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('admin.layouts.errors')

	</form>

@endsection