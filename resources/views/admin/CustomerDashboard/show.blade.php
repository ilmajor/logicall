@extends ('admin.layouts.master')
@section('content')
	
<h1>Dashboard {{ $CustomerDashboard->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/CustomerDashboard/{{ $CustomerDashboard->id }}">

		{{ csrf_field() }}

		<div class="form-group">
			<label for="name">Имя:</label>
			<input type="text" class="form-control" id="name" name="name" value="{{ $CustomerDashboard->name }}" required>
		</div>

		<div class="form-group">
			<label for="name">Запрос:</label>
			<textarea class="form-control" id="query" name="query" rows="3" required>{{ $CustomerDashboard->query }}</textarea>
		</div>

		<div class="form-group">
			<label for="charts">Тип графика:</label>
			<select class="form-control form-control" id="charts" name="charts" aria-describedby="charts" >
				<option value="{{ $CustomerDashboard->charts }}">{{ $CustomerDashboard->charts }}</option>
				<option value="line">line</option>
				<option value="pie">pie</option>
				<option value="column">column</option>
			</select>
		</div>
		<div class="form-group">
			<label for="project_id">Проект.</label>
			<select class="form-control form-control" id="project_id" name="project_id" aria-describedby="project_id">
				@foreach($Projects as $project)
					@if(!empty($CustomerDashboard) && $project->id == $CustomerDashboard->project_id)
						<option value="{{$project->id}}" selected>{{$project->Name}}</option>
					@else 
						<option value="{{$project->id}}">{{$project->Name}}</option>
					@endif
				@endforeach
			</select>
		</div>
		<div class="form-group">
			<label for="timeout">Таймаут исполнения(секунды):</label>
			<input type="text" class="form-control" id="timeout" name="timeout" value="{{ $CustomerDashboard->timeout }}" required>
		</div>
		@include('admin.layouts.errors')

		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection