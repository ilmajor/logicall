@extends ('layouts.master')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 ">
				<h3>{{$task->name}} // {{$CallData->idchain}} // {{$CallData->id_client}}</h3>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<div class="col-md-12 ">
			<div class="table-responsive-sm">
				<table class="table table-striped table-sm table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>Дата</th>
							<th>Время</th>
							<th>Код завершения</th>
							<th>ID</th>
						</tr> 
					</thead>
					<tbody>
						@foreach ($ClientCalls as $ClientCall)
							<tr>
								<td>{{$ClientCall->DateStart}}</td>
								<td>{{$ClientCall->TimeStart}}</td>
								<td>{{$ClientCall->Name}}</td>
								<td>{{$ClientCall->idchain}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<hr>
 	<div class="container">
		<form method="POSt" action="/lk/ChangeCompletionCode/idchain/update">
			{{ csrf_field() }}

			<div class="form-group">
				<label for="Result">Код завершения звонка:</label>
				<select class="form-control form-control" id="Result" name="Result" aria-describedby="Result">
					@foreach($Results as $Result)
						@if((!empty($Result)) && ((int) $CallData->Result == $Result->Result))
							<option value="{{$Result->Result}}" selected>{{$Result->Name}}</option>
						@else 
							<option value="{{$Result->Result}}">{{$Result->Name}}</option>
						@endif
					@endforeach
				</select>
			</div>
			{{ Form::hidden('idchain', $CallData->idchain) }}
			<button type="submit" class="btn btn-primary">Сохранить</button>
		</form>
	</div>
@endsection