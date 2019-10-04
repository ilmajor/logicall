@extends ('admin.layouts.master')
@section('content')
	
<h1>Задача {{ $task->name }} \\ Проект {{ $task->project->name }}</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/DatabaseExclusion/{{ $task->id }}">
		<div class="form-group">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="column">Поля таблицы.</label>
				<select multiple class="form-control form-control" id="column" name="column[]" aria-describedby="column" size='25'>
					@foreach($columns as $column)
						@if((!empty($column)) && in_array($column, $DatabaseExclusions->pluck('exclusion_column')->toArray()))
							<option value='{{ $column }}' selected>{{ $column }}</option>
						@else 
							<option value='{{ $column }}'>{{ $column }}</option>
						@endif
					@endforeach
                </select>
            </div>

		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection