@extends ('admin.layouts.master')
@section('content')
	
<h1>Проект {{ $project->name }}.</h1>
<hr>

<div class="table-responsive">
	<form method="POST" action="/lk/admin/project/{{ $project->id }}">
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
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_enabled" name="is_enabled" value="{{ $project->is_enabled }}"
            @if($project->is_enabled == true )
                checked>
            @else
                >
            @endif
            <label class="form-check-label" for="is_enabled" >Активный проект</label>
        </div>


		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>	
</div>
@endsection