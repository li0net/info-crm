@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2"></div>
			<h4>Журнал услуг</h4>
			<hr>
		</div>
		<div class="row">
			{{ Form::open() }}
				<div class="col-sm-3">
					{{ Form::label('filter-employee', 'ФИО мастера:', ['class' => 'ctrl-label']) }}
					{{ Form::select('filter-employee', $employees, null,  ['class' => 'form-control', '@change' => 'onSelectChange', 'v-model' => 'filter_employee']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::label('filter-service', 'Наименование услуги:', ['class' => 'ctrl-label']) }}
					{{ Form::select('filter-service', $services, null,  ['class' => 'form-control', '@change' => 'onSelectChange', 'v-model' => 'filter_service']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::label('filter-start-time', 'Время начала:', ['class' => 'ctrl-label']) }}
					{{ Form::select('filter-start-time', $sessionStart, null,  ['class' => 'form-control', '@change' => 'onSelectChange', 'v-model' => 'filter_start_time']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::label('filter-end-time', 'Время окончания:', ['class' => 'ctrl-label']) }}
					{{ Form::select('filter-end-time', $sessionEnd, null,  ['class' => 'form-control', '@change' => 'onSelectChange', 'v-model' => 'filter_end_time']) }}
				</div>
			{{ Form::close() }}
		</div>
		<div class="row">
			<hr>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<th># назначения</th>
						<th># мастера</th>
						<th># клиента</th>
						<th>Время начала</th>
						<th>Время окончания</th>
					</thead>

					<tbody id = 'result_container'>
						@foreach($appointments as $appointment)
							<tr>
								<th>{{ $appointment->appointment_id }}</th>
								<td>{{ $appointment->employee_id }}</td>
								<td>{{ $appointment->client_id }}</td>
								<td>{{ $appointment->start }}</td>
								<td>{{ $appointment->end }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>	
@endsection