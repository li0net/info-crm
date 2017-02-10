@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h4>Информация о платеже</h4>	
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
					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('date', 'Дата и время:', ['class' => 'form-spacing-top']) }}
						</div>
						<div class="col-sm-8">
							{{ Form::text('date', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('item_id', "Статья платежа: ", ['class' => 'form-spacing-top']) }}
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
							{{ Form::label('account_id', "Счет: ", ['class' => 'form-spacing-top']) }}
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
							{{ Form::label('beneficiary_type', 'Получатель:') }}
						</div>
						<div class="col-sm-8">
							<div class="radio">
								<label>
									{{ Form::radio('beneficiary_type', 'partner', $payment->beneficiary_type == 'partner', ['style' => 'margin-right: 10px']) }}
									 Контрагент 
								</label>
							</div>
							<div class="radio">
								<label>
									{{ Form::radio('beneficiary_type', 'client', $payment->beneficiary_type == 'client', ['style' => 'margin-right: 10px']) }}
									 Клиент 
								</label>
							</div>
							<div class="radio">
								<label>
									{{ Form::radio('beneficiary_type', 'employee', $payment->beneficiary_type == 'employee', ['style' => 'margin-right: 10px']) }}
									 Сотрудник 
								</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('beneficiary_title', 'Контрагент:', ['class' => 'form-spacing-top']) }}
						</div>
						<div class="col-sm-8">
							{{ Form::text('beneficiary_title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '15']) }}
						</div>
						<label class="col-sm-1 text-left">
							<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
						</label>
					</div>

					<div class="form-group">
						<div class="col-sm-3 control-label">
							{{ Form::label('sum', 'Сумма:', ['class' => 'form-spacing-top']) }}
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
							{{ Form::label('description', "Описание: ", ['class' => 'form-spacing-top']) }}
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
						<div class="col-md-8 col-md-offset-2">
							<div class="row">
								<div class="col-md-6">
									{!! Html::linkRoute('payment.show', 'Отмена', [$payment->payment_id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-md-6">
									{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
								</div>
							</div>
						</div>
					</div>
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}