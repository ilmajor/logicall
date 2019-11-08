@extends ('admin.layouts.master')
@section('content')
	
<h1>Проект {{ $project->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/project/{{ $project->id }}">
		<div class="form-group">
			{{ csrf_field() }}
            <div class="form-group">
                <label for="director">Руководитель проекта:</label>
                <select class="form-control form-control" id="director" name="director" aria-describedby="director" required>
                    	@foreach($managers as $manager)
                            @if((!empty($project)) && ($manager->id == $project->director))
                                <option value="{{$manager->id}}" selected>{{$manager->name}}</option>
                             @else 
                                <option value="{{$manager->id}}">{{$manager->name}}</option>
                            @endif
                        @endforeach
                </select>
            </div>
			
		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection