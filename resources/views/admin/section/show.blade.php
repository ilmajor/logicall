@extends ('admin.layouts.master')
@section('content')
	
	<h1>Разделы на главном экране.</h1>
	<hr>

    <div class="table-responsive">
		<form method="POST" action="/lk/admin/section/{{ $section->id }}">

		{{ csrf_field() }}

			<div class="form-group">
				<label for="title">Название блока.</label>
				<input type="text" class="form-control" id="title" name="title" aria-describedby="title" value="{{ $section->title }}">
			</div>
			<div class="form-group">
				<label for="description">Описание.</label>
				<input type="text" class="form-control" id="description" name="description" aria-describedby="description" value="{{ $section->description }}">
			</div>
			<div class="form-group">
				<label for="url">url</label>
				<input type="text" class="form-control" id="url" name="url" aria-describedby="url" value="{{ $section->url }}">
			</div>
{{-- 
			<div class="form-group">
			    <label for="exampleFormControlSelect1">Ограничение по проекту</label>
				<select class="form-control" id="project" name="project">
					<option value='{{ $section->project }}'>{{ $section->project }}</option>
					@foreach($projects as $project)
						@if($section->project != $project->Name)
							<option value='{{ $project->Name }}'>{{ $project->Name }}</option>
						@endif
					@endforeach
				</select>
			</div> --}}
            <div class="form-group">
                <label for="project">Ограничение по проекту.</label>
                <select multiple class="form-control form-control" id="project" name="project[]" aria-describedby="project" size='10'required>
                        @foreach($projects as $project)
                            @if((!empty($section->project)) && in_array($project->Name, $section->project))
                                <option selected>{{$project->Name}}</option>
                             @else 
                                <option>{{$project->Name}}</option>
                            @endif
                        @endforeach
                </select>
            </div>

			<div class="form-group">
			    <label for="exampleFormControlSelect1">Группа пользователей.</label>
				<select class="form-control" id="role_id" name="role_id">
					<option value='{{ $section->role->id }}'>{{ $section->role->name }}</option>
					@foreach($roles as $role)
						@if($section->role->id != $role->id)
							<option value='{{ $role->id }}'>{{ $role->name }}</option>
						@endif
					@endforeach
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>	
	</div>

@endsection