@extends ('admin.layouts.master')
@section('content')
	
	<h1>Создать раздел.</h1>
	<hr>


	<form method="POST" action="/lk/admin/section/create">
		
		{{ csrf_field() }}

		<div class="form-group">
			<label for="title">Название блока.</label>
			<input type="text" class="form-control" id="title" name="title" required>
			<label for="description">Описание.</label>
			<input type="text" class="form-control" id="description" name="description" required>
			<label for="url">url</label>
			<input type="text" class="form-control" id="url" name="url" required>

			<div class="form-group">
			    <label for="exampleFormControlSelect1">Группа пользователей.</label>
				<select multiple class="form-control form-control" id="role" name="role[]">
                     @foreach($roles as $role)
                     	<option value='{{ $role->id }}'>{{$role->name}}</option>
                    @endforeach 
				</select>
			</div>

            <div class="form-group">
                <label for="project">Ограничение по проекту.</label>
                <select multiple class="form-control form-control" id="project" name="project[]" aria-describedby="project" size='10'>
                	<option value=''></option>
                        @foreach($projects as $project)
  		                    <option value='{{ $project->id }}'>{{$project->name}}</option>
                        @endforeach
                </select>
            </div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">Создать</button>
		</div>

		@include('admin.layouts.errors')

	</form>

@endsection