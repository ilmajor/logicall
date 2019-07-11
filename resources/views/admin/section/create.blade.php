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
                <label for="role_id">Группа пользователей.</label>
                <select class="form-control form-control" id="role_id" name="role_id" aria-describedby="role_id" required>
                	<option></option>
                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="project">Ограничение по проекту</label>
                <select class="form-control form-control" id="project" name="project" aria-describedby="project">
                	<option></option>
                    @foreach($projects as $project)
                        <option>{{$project->Name}}</option>
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