@extends ('layouts.master')
@section('content')
	<h1>Задача {{$task->name}}</h1>
	<div class="container">
		<div class="row">
			<h6>
				Размер базы:  
				<span class="badge badge-secondary" id="" data-toggle="tooltip" data-placement="top" title="кол-во контактов, загруженных в работу.">{{$baseData->base}}</span>
			</h6>
			<h6>
				 | Доступно для обзвона сейчас:  
				<span class="badge badge-secondary" id="" data-toggle="tooltip" data-placement="top" title="кол-во контактов, которые доступны для обзвона в настоящий момент, данное значение меняется исходя из кол-ва выставленных попыток и по мере обработки базы операторами.">{{$baseData->selection}}</span>
			</h6>
			<h6> | % потеряных в очереди:  <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="это процентное отношение «клиент прервавший ожидание в очереди» / «общее количество клиентов с которым происходила коммутация">{{round($queue->go_from_queue_percent,2)}}</span></h6>
			<h6> | % Отбоя из дозванивающихся:  <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="это процентное отношение «Отбоя из дозвонившихся» / «общее количество клиентов с которым происходила коммутация». Если в поле «кол-во звонков на оператора» указано 2, то система набирает 2 вызова, первого ответившего клиента отправляет на оператора, второго сбрасывает. Нужно следить за этим значением и регулировать настройки если данное значение растет.">{{round($queue->callout_from_dialing_percent,2)}}</span></h6>

		</div>
	</div>
	<hr>
	<form method="POST" action="/lk/algorithmSettings/{{ $task->id }}">
		{{ csrf_field() }}
		<div class="container">
			<div class="row">

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="" data-toggle="tooltip" data-placement="top" title="Данные границы регулируют время ожидания оператором нового звонка, это сказывается на интенсивности набора, а также может сказаться % Отбоя.">Верхняя и нижняя граница ожидания оператором нового звонка</span>
					</div>
					<input type="text" class="form-control" name="waitcall_max" value="{{$settings->waitcall_max}}">
					<input type="text" class="form-control" name="waitcall_min" value="{{$settings->waitcall_min}}">
				</div>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1" data-toggle="tooltip" data-placement="top" title="данное значение регулируется и показывает какое кол-во звонков система отправляет на вызов на одного оператора.

•	Если ожидание между звонками у оператора в норме, то данное значение лучше не увеличивать, так как может вырасти % отбоя из дозвонившихся.
•	Если % дозвона до клиентов низкий и ожидание у операторов растет, данное значение можно увеличить.">Максимальное количество звонков на оператора</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="CallMaxCount" value="{{$settings->CallMaxCount}}">
				</div>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1" data-toggle="tooltip" data-placement="top" title="Порог по кол-ву помещаемых в очередь  абонентов.">Макисмальная длина очереди для задачи</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="max_queue" value="{{$settings->max_queue}}">
				</div>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1" data-toggle="tooltip" data-placement="top" title="это время в которое начинает работать линия. Соответственно стартовые значения работают от начала работы линии в течении 20 минут, пока не наберется статистика.">Час начала работы задачи</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="StartHour" value="{{$settings->StartHour}}">
				</div>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1" data-toggle="tooltip" data-placement="top" title="Количество набираемых клиентов на время набора статистики.">Стартовое значение числа звонков на день для задачи</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="startcount" value="{{$settings->startcount}}">
				</div>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1" data-toggle="tooltip" data-placement="top" title="Это порог на количество помещаемых в очередь абонентов на время набора статистики">Стартовое значение очереди на день для задачи</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="startqueue" value="{{$settings->startqueue}}">
				</div>

				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1" data-toggle="tooltip" data-placement="top" title="Данное значение регулирует кол-во попыток дозвона на одного клиента.">Количество звонков на клиента</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="count_calls" value="{{$settings->count_calls}}">
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Сохранить</button>
	</form>
		{{-- <li>Максимальное количество звонков на оператора: {{$settings->CallMaxCount}}</li> --}}
		{{-- <li>Макисмальная длина очереди для задачи: {{$settings->max_queue}}</li> --}}
		{{-- <li>Час начала работы задачи: {{$settings->StartHour}}</li> --}}
		{{-- <li>Стартовое значение числа звонков на день для задачи: {{$settings->startcount}}</li> --}}
		{{-- <li>Стартовое значение очереди на день для задачи: {{$settings->startqueue}}</li> --}}
{{-- 		<li>Верхняя граница ожидания оператором нового звонка: {{$settings->waitcall_max}}</li>
		<li>Нижняя граница ожидания оператором нового звонка: {{$settings->waitcall_min}}</li> --}}
		{{-- <li>Количество звонков на клиента: {{$settings->count_calls}}</li> --}}
		<hr>

@endsection