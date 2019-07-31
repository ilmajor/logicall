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
 
            <div class="form-group">
                <label for="project">Ограничение по проекту.</label>
                <select multiple class="form-control form-control" id="project" name="project[]" aria-describedby="project" size='10'>
                	<option value=''></option>
                        @foreach($projects as $project)
                            @if((!empty($section->id)) && in_array($project->id, $section->projects->pluck('id')->toArray()))

                                <option value='{{ $project->id }}' selected>{{$project->name}}</option>
                             @else 
                                <option value='{{ $project->id }}'>{{$project->name}}</option>
                            @endif
                        @endforeach
                </select>
            </div>

			<div class="form-group">
			    <label for="exampleFormControlSelect1">Группа пользователей.</label>
				<select multiple class="form-control form-control" id="role" name="role[]">
					<option value=''></option>
{{-- 					<option value='{{ $section->role->first()->id }}'>{{ $section->role->first()->name }}</option>
					@foreach($roles as $role)
						@if($section->role->first()->id != $role->id)
							<option value='{{ $role->id }}'>{{ $role->name }}</option>
						@endif
					@endforeach --}}


                     @foreach($roles as $role)
                        @if((!empty($role->id)) && in_array($role->id, $section->role->pluck('id')->toArray()))
                            <option value='{{ $role->id }}' selected>{{$role->name}}</option>
                         @else 
                            <option value='{{ $role->id }}'>{{$role->name}}</option>
                        @endif
                    @endforeach 
				</select>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>	
	</div>

@endsection