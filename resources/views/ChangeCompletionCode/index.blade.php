@extends ('layouts.master')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 ">
				<h1>Введите ID звонка</h1>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<form method="POSt" action="/lk/ChangeCompletionCode/idchain">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="idchain">ID звонка:</label>
				<input type="text" class="form-control" id="idchain" name="idchain" placeholder="61A25519-146E-48DD-A653-B0A6E2D671A7" required>
			</div>
			<button type="submit" class="btn btn-primary">Найти</button>
		</form>
	</div>
@endsection