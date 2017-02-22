@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2"></div>
			<h4>{{ trans('adminlte_lang::message.schedule') }}</h4>
			<hr>
		</div>
		<div class="row">
			{{ Form::open() }}
				<div class="col-sm-3">
					{{ Form::label('filter-employee', trans('adminlte_lang::message.manager'), ['class' => 'ctrl-label']) }}
					{{ Form::select('filter-employee', $employees, null,  ['class' => 'form-control', '@change' => 'onSelectChange', 'v-model' => 'filter_employee', 'placeholder' => '- все -']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::label('filter-service', trans('adminlte_lang::message.service_name'), ['class' => 'ctrl-label']) }}
					{{ Form::select('filter-service', $services, null,  ['class' => 'form-control', '@change' => 'onSelectChange', 'v-model' => 'filter_service', 'placeholder' => '- все -']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::label('filter-start-time', trans('adminlte_lang::message.start_time'), ['class' => 'ctrl-label']) }}
					{{ Form::select('filter-start-time', $sessionStart, null,  ['class' => 'form-control', '@change' => 'onSelectChange', 'v-model' => 'filter_start_time']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::label('filter-end-time', trans('adminlte_lang::message.end_time'), ['class' => 'ctrl-label']) }}
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
						<th>#</th>
						<th>{{ trans('adminlte_lang::message.manager') }}</th>
						<th>{{ trans('adminlte_lang::message.client') }}</th>
						<th>{{ trans('adminlte_lang::message.service_name') }}</th>
						<th>{{ trans('adminlte_lang::message.start_time') }}</th>
						<th>{{ trans('adminlte_lang::message.end_time') }}</th>
					</thead>

					<tbody id = 'result_container'>
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
			</div>
		</div>
	</div>	
@endsection