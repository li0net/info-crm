@if(count($appointments) == 0)
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<h4><b>Записей с такими параметрами не обнаружено</b></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center m-b">
			Вы можете добавить новую запись
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 text-center">
			<a href="#" class="btn btn-primary">Новая запись</a>
		</div>
	</div>
@else
	<table class="table table-hover table-striped">
		<thead>
			<th>#</th>
			<th>{{ trans('adminlte_lang::message.manager') }}</th>
			<th>{{ trans('adminlte_lang::message.client') }}</th>
			<th>{{ trans('adminlte_lang::message.service_name') }}</th>
			<th>{{ trans('adminlte_lang::message.start_time') }}</th>
			<th>{{ trans('adminlte_lang::message.end_time') }}</th>
		</thead>

		<tbody>
			@foreach($appointments as $appointment)
				<tr>
					<th>{{ $appointment->appointment_id }}</th>
					<td>{{ $appointment->employee->name }}</td>
					<td>{{ $appointment->client->name }}</td>
					<td>{{ $appointment->service->name }}</td>
					<td>{{ $appointment->start }}</td>
					<td>{{ $appointment->end }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<div class="text-center filtered">
		{!! $appointments->render(); !!} 
	</div>
@endif