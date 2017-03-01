@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-sm-8 text-left">
				<h4>{{ trans('adminlte_lang::message.schedule') }}</h4>
			</div>
			<div class="col-sm-4">
				<a href="#" class="btn btn-primary m-r pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
			</div>
		</div>
		<div class="row">
			<hr>
		</div>
		<div class="row">
			{{-- {{ Form::open() }}
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
			{{ Form::close() }} --}}
			<form method="post" action="#" class="form">
				{{ csrf_field() }}
				{{ Form::hidden('organization-id', $user->organization_id, ['id' => 'organization-id']) }}
				<fieldset>
					<div class="row m-b">
						<div class="col-sm-3">
							{{ Form::label('filter-date-from', trans('adminlte_lang::message.appointment_time'), ['class' => 'ctrl-label']) }}
							<div class="input-group">
								<span class="input-group-addon">c&nbsp;&nbsp;</span>
								<input class="form-control hasDatepicker" name="start_date" data-days-offset="-1" type="text" id="filter-date-from">
							</div>
						</div>
						<div class="col-sm-3">
							{{ Form::label('filter-date-to', null, ['class' => 'ctrl-label', 'style' => 'visibility:hidden']) }}
							<div class="input-group">
								<span class="input-group-addon">по</span>
								<input class="form-control hasDatepicker" name="end_date" type="text" id="filter-date-to">
							</div>
						</div>
						<div class="col-sm-3">
							{{ Form::label('filter-employee-id', trans('adminlte_lang::message.manager'), ['class' => 'ctrl-label']) }}
							{{ Form::select('filter-employee-id', $employees, null,  ['class' => 'form-control',
																					  'id' => 'filter-employee-id', 
																					  'placeholder' => 'Все сотрудники']) }}
						</div>	    	
						<div class="col-sm-3">
							{{ Form::label('filter-client-id', trans('adminlte_lang::message.client_name'), ['class' => 'ctrl-label']) }}
							{{ Form::select('filter-client-id', $clients, null, ['class' => 'form-control', 
																		  		 'id' => 'filter-client-id', 
																				 'placeholder' => 'Все клиенты']) }}
						</div>	
					</div>
					<div class="row m-b">
						<div class="col-sm-3 transactions-multi-filters">
						</div>
						<div class="col-sm-3">
							{{ Form::label('filter-service-id', trans('adminlte_lang::message.service_name'), ['class' => 'ctrl-label']) }}
							{{ Form::select('filter-service-id', $services, null,  ['class' => 'form-control', 
																					'id' => 'filter-service-id',
																					'placeholder' => 'Все услуги']) }}
						</div>
						<div class="col-sm-3">
							{{ Form::label('filter-appointment-status', trans('adminlte_lang::message.appointment_status'), ['class' => 'ctrl-label']) }}
							{{ Form::select('filter-appointment-status', ['failed' => 'Клиент не пришел', 
																	   	  'created' => 'Ожидание клиента', 
																		  'finished' => 'Клиент пришел',
																		  'confirmed' => 'Клиент подтвердил'], 
																		 null,  
																		 ['class' => 'form-control',
																		  'id' => 'filter-appointment-status',
																		  'placeholder' => 'Любой статус']) }}
						</div>
						<div class="form-inline">
							<div class="col-sm-3">
								{{ Form::label('records-on-page', null, ['class' => 'ctrl-label', 'style' => 'visibility:hidden']) }}
								<br>
								{{ Form::select('records-on-page', [25 => '25', 
															   		50 => '50', 
															   		100 => '100',], null,  ['class' => 'form-control', 'id' => 'records-on-page']) }}
								&nbsp;&nbsp;операций на странице           
							</div>
						</div>
					</div>
					<div class="row m-b ">
						<div class="col-sm-2 col-sm-offset-10">
							<input type="button" class="btn btn-success btn-sm pull-right" value="Показать" id='form_submit'>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="row">
			<hr>
		</div>

		<div class="row">
			<div class="col-sm-12" id="result_container">
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
				<div class="text-center">
					{!! $appointments->render(); !!} 
				</div>
			</div>
		</div>
	</div>	
@endsection

@section('page-specific-scripts')
<script>
	$(document).ready(function(){
		$('#filter-date-from').datepicker({
			autoclose: true,
			orientation: 'auto',
			format: 'dd-mm-yyyy',
			weekStart: 1
		});

		var today = new Date();

		$('#filter-date-from').datepicker('update', today);

		$('#filter-date-to').datepicker({
			autoclose: true,
			orientation: 'auto',
			format: 'dd-mm-yyyy',
			weekStart: 1
		});

		$('#filter-date-to').datepicker('update', today);

		$('#filter-date-from').datepicker()
			.on('show', function(e) {
				$('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
				$('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
			});

		$('#filter-date-to').datepicker()
		    .on('show', function(e) {
		        $('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
		        $('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
		    });

		$('#form_submit').on('click', function(e){
			var me = this;
			$.ajax({
				type: "POST",
				dataType: 'html',
				data: {	'filter_date_from'			: $('#filter-date-from').val(),
						'filter_date_to'			: $('#filter-date-to').val(),
						'filter_employee_id'		: $('#filter-employee-id').val(),
						'filter_service_id'			: $('#filter-service-id').val(),
						'filter_client_id'			: $('#filter-client-id').val(),
						'filter_appointment_status'	: $('#filter-appointment-status').val(),
						'records_on_page'			: $('#records-on-page').val(),
						'organization_id'			: $('#organization-id').val(),
						},
				url: "/home",
				success: function(data) {
					$('#result_container').html(data);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing payments data range!');
				}
			});
		});

		$('#result_container').on('click', '.filtered > .pagination', function(e) {
			var me = this, page = 0;
			if ($(e.target).html() == '»') {
				page = parseInt($('.pagination li.active span').html()) + 1;
			} else if ($(e.target).html() == '«'){
				page = parseInt($('.pagination li.active span').html()) - 1;
			} else {
				page = parseInt($(e.target).html());
			}

			var me = this;
			$.ajax({
				type: "POST",
				dataType: 'html',
				data: {	'filter_date_from'			: $('#filter-date-from').val(),
						'filter_date_to'			: $('#filter-date-to').val(),
						'filter_employee_id'		: $('#filter-employee-id').val(),
						'filter_service_id'			: $('#filter-service-id').val(),
						'filter_client_id'			: $('#filter-client-id').val(),
						'filter_appointment_status'	: $('#filter-appointment-status').val(),
						'records_on_page'			: $('#records-on-page').val(),
						'organization_id'			: $('#organization-id').val(),
						'page'						: page
						},
				url: "/home",
				success: function(data) {
					$('#result_container').html(data);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log('Error while processing payments data range!');
				}
			});

			return false;
		});
	});
</script>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>