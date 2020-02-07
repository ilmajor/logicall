<footer class="text-muted">
	<div class="container">
		<p class="float-right">
		  {{-- <a href="#">Back to top</a> --}}
{{-- 		  @if(Auth::check())
			  	<hr>
				<ul>
					@foreach ($userdata as $data )
						Имя : {{ $data->name }}
						ID : {{ $data->id_user }}
						login : {{ $data->login}}
						dte : {{ $data->dte}}
					@endforeach

				</ul>
				<ul>
					Имя: {{ Auth::user()->name }}
					login: {{ Auth::user()->login }}
					id: {{ Auth::user()->id }}
					id_user: {{ Auth::user()->id_user }}
					date: {{ date('Y-m-d')}}
				</ul>
			@endif --}}
		</p>
	</div>
</footer>