@extends ('layouts.master')

@section('content')
		<br>
		<div class='container'>

			@php $id = '' @endphp
			@foreach($sections as $section)
				@php $url = $section->url @endphp
				@if($id !== $section->role_id)
					@if($section->role_id > 1)
						</div>
					@endif
					<hr>
					<div class='row'>
				@endif
				<div class="col-sm-6">
					<div class="jumbotron">
						<h2>{{$section->title }}</h2>
						<p class="lead">{{ $section->description}}</p>
						<a class="btn btn-lg btn-primary" href="<?php echo $section->url ?>" role="button">	
							Перейти к разделу &raquo;
						</a>
					</div>
				</div>
				@if($id != $section->role_id)
					@php $id =  $section->role_id @endphp

				@endif
			@endforeach
		</div>
@endsection
