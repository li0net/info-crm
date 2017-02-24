@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.payment_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h4>{{ trans('adminlte_lang::message.payment_create_new') }}</h4>	
			<hr>	
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="well">
				{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
				{!! Form::model($payment, ['route' => ['payment.update', $payment->payment_id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
					{{ Form::hidden('bene-id', $payment->beneficiary_id, ['id' => 'bene-id']) }}
					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('date', trans('adminlte_lang::message.date_and_time'), ['class' => 'form-spacing-top']) }}
						</div>
						<div class="col-sm-4">
							{{ Form::text('payment-date', '10-02-2017', ['class' => 'form-control', 'required' => '', 'maxlength' => '110', 'id' => 'payment-date']) }}
						</div>
						<div class="col-sm-2">
							{{ Form::select('payment-hour', $payment_hours, $payment_hour, ['class' => 'form-control', 'required' => '', 'id' => 'payment-hour']) }}
						</div>
						<div class="col-sm-2">
							{{ Form::select('payment-minute', $payment_minutes, $payment_minute, ['class' => 'form-control', 'required' => '', 'id' => 'payment-minute']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('item_id', trans('adminlte_lang::message.payment_item'), ['class' => 'form-spacing-top']) }}
						</div>
						<div class="col-sm-8">
							{{ Form::select('item_id', $items, $payment->item_id, ['class' => 'form-control', 'required' => '']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('account_id',  trans('adminlte_lang::message.account'), ['class' => 'form-spacing-top']) }}
						</div>
						<div class="col-sm-8">
							{{ Form::select('account_id', $accounts, $payment->account_id, ['class' => 'form-control', 'required' => '']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('beneficiary_type',  trans('adminlte_lang::message.beneficiary_type')) }}
						</div>
						<div class="col-sm-8">
							<div class="radio">
								<label>
									{{ Form::radio('beneficiary_type', 'partner', $payment->beneficiary_type == 'partner', ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.partner') }}
								</label>
							</div>
							<div class="radio">
								<label>
									{{ Form::radio('beneficiary_type', 'client', $payment->beneficiary_type == 'client', ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.client') }} 
								</label>
							</div>
							<div class="radio">
								<label>
									{{ Form::radio('beneficiary_type', 'employee', $payment->beneficiary_type == 'employee', ['style' => 'margin-right: 10px']) }}
										{{ trans('adminlte_lang::message.employee') }} 
								</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							@if ($payment->beneficiary_type == 'partner')
								{{ Form::label('beneficiary_id', trans('adminlte_lang::message.partner'), ['class' => 'form-spacing-top']) }}
							@elseif ($payment->beneficiary_type == 'client')
								{{ Form::label('beneficiary_id', trans('adminlte_lang::message.client'), ['class' => 'form-spacing-top']) }}
							@else 
								{{ Form::label('beneficiary_id', trans('adminlte_lang::message.employee'), ['class' => 'form-spacing-top']) }} 
							@endif
						</div>
						<div class="col-sm-8">
							{{ Form::select('beneficiary_id', [''=>''], $payment->beneficiary_id, ['class' => 'form-control', 'required' => '', 'placeholder' => 'Не выбрано']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('sum',  trans('adminlte_lang::message.sum'), ['class' => 'form-spacing-top']) }}
						</div>
						<div class="col-sm-8">
							{{ Form::text('sum', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '10']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>
					
					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('description',  trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top']) }}
						</div>
						<div class="col-sm-8">
							{{ Form::textarea('description', null, ['class' => 'form-control']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>

					<hr>
					
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('payment.show',  trans('adminlte_lang::message.cancel'), [$payment->payment_id], 
																												 ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
									{{ Form::submit( trans('adminlte_lang::message.save'), ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}	
			</div>
		</div>
	</div>
@endsection

@section('page-specific-scripts')
	<script>
		$(document).ready(function(e){
			$('#payment-date').datepicker({
				autoclose: true,
				orientation: 'auto',
				format: 'dd-mm-yyyy',
				weekStart: 1
			});

			var today = new Date();

			$('#payment-date').datepicker('update', today);

			$('#payment-date').datepicker()
				.on('show', function(e) {
					$('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
					$('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
				});

			$('input[name="beneficiary_type"]').on('change', function() {
				switch($(this).val()) {
					case 'client':
						$('label[for="beneficiary_id"]').html(<?php echo "'". trans('adminlte_lang::message.client')."'" ?>);
							break;
					case 'partner':
						$('label[for="beneficiary_id"]').html(<?php echo "'". trans('adminlte_lang::message.partner')."'" ?>);
							break;
					case 'employee':
						$('label[for="beneficiary_id"]').html(<?php echo "'". trans('adminlte_lang::message.employee')."'" ?>);
							break;
				}

				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'beneficiary_type' : $(this).val()},
					url: "<?php echo route('payment.beneficiaryOptions') ?>",
					success: function(data) {
						$('#beneficiary_id').html('');
						$('#beneficiary_id').html(data.options);
						
						var id = $('#bene-id').val();
						if( 0 != id ) {
							$('#beneficiary_id').val(id);
							$('#bene-id').val(0);
						} else {
							{{-- $('#beneficiary_id').val($('#beneficiary_id option:first').val()); --}}
							$('#beneficiary_id option:first').attr('selected', true);
						}
					}
				});
			});
			
			var t = $('input[name="beneficiary_type"]:checked').val();

			$('input[name="beneficiary_type"]').filter('[value="' + t + '"]').trigger("change");
		});
	</script>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}