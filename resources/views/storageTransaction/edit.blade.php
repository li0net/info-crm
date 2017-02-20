@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h4>Новая складская операция</h4>	
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
				{!! Form::model($transaction, ['route' => ['storagetransaction.update', $transaction->id], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
					{{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('date', 'Дата и время:') }}
							</div>
							<div class="col-sm-5">
								{{ Form::text('transaction-date', '10-02-2017', ['class' => 'form-control', 'required' => '', 'maxlength' => '110', 'id' => 'transaction-date']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('transaction-hour', $transaction_hours, null, ['class' => 'form-control', 'required' => '', 'id' => 'transaction-hour']) }}
							</div>
							<div class="col-sm-2">
								{{ Form::select('transaction-minute', $transaction_minutes, null, ['class' => 'form-control', 'required' => '', 'id' => 'transaction-minute']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id='service_unit' original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('type', 'Тип: ') }}
							</div>
							<div class="col-sm-9">
								{{ Form::select('type', ['income' => 'Приход', 'expenses' => 'Расход', 'discharge' => 'Списание', 'transfer' => 'Перемещение'],
																	'income', 
																	['class' => 'form-control', 'required' => '']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('partner_id', 'Контрагент: ') }}
							</div>
							<div class="col-sm-9">
								{{ Form::select('partner_id', $partners, null, ['class' => 'form-control', 'required' => '']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('storage_id', 'Склад: ') }}
							</div>
							<div class="col-sm-9">
								{{ Form::select('storage_id', $storages, null, ['class' => 'form-control', 'required' => '']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								<a href="#transaction-items" data-toggle="collapse" class="btn btn-link btn-xs">
								<span class="badge label-danger hidden">@{{ transaction_items_count }}</span>
								&nbsp;&nbsp;Список товаров&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div>
							{{-- <div class="col-sm-9">
								<a href="#transaction-items" data-toggle="collapse" class="btn btn-link btn-xs">
								<span class="badge label-danger hidden">@{{ transaction_items_count }}</span>
								&nbsp;&nbsp;Список товаров&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div> --}}
							
						</div>

						<div id="transaction-items" class="form-group collapse">
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-8">
									<div class="col-sm-3">Товар</div>
									<div class="col-sm-2">Цена</div>
									<div class="col-sm-2">Количество</div>
									<div class="col-sm-1">Скидка</div>
									<div class="col-sm-2">Сумма</div>
									<div class="col-sm-2">Код</div>
								</div>
								<div class="col-sm-2"></div>
							</div>
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1">
									<hr>
								</div>
							</div>
							<div class="row" id="transaction-content">
								<div class="wrap-it">
									<div class="col-sm-2"></div>							
									<div class="col-sm-8" style="padding:0">
										<div class="col-sm-3">
											{{ Form::select('product_id[]', [], null, ['class' => 'form-control', 'maxlength' => '110', 'placeholder' => 'Выберите товар']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('price[]', null, ['class' => 'form-control']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('amount[]', null, ['class' => 'form-control']) }}
										</div>
										<div class="col-sm-1">
											{{ Form::text('discount[]', null, ['class' => 'form-control']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('sum[]', null, ['class' => 'form-control']) }}
										</div>
										<div class="col-sm-2">
											{{ Form::text('code[]', null, ['class' => 'form-control']) }}
										</div>
									</div>
									<div class="col-sm-2" style="margin-bottom: 15px;">
										<input type="button" id="add-transaction-item" class="btn btn-info" value="Добавить">
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('is_paidfor', 'Оплата: ') }}
							</div>
							<label class="col-sm-9 text-left" style="font-weight: 300">
								{{ Form::checkbox('is_paidfor', 1, 0, ['style' => 'margin-right: 10px;']) }}
								Оплачено
							</label>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="is_paidfor" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('description', 'Описание:') }}
							</div>
							<div class="col-sm-9">
								{{ Form::textarea('description', null, ['class' => 'form-control']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>
					</div>
					
					<hr>

					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="row">
								<div class="col-sm-6">
									{!! Html::linkRoute('storagetransaction.show', 'Отмена', [$transaction->id], ['class'=>'btn btn-danger btn-block']) !!}
								</div>
								<div class="col-sm-6">
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

@section('page-specific-scripts')
	<script type="text/javascript">
		$(document).ready(function($) {
			$('#transaction-date').datepicker({
				autoclose: true,
				orientation: 'auto',
				format: 'dd-mm-yyyy',
				weekStart: 1
			});

			var today = new Date();

			$('#transaction-date').datepicker('update', today);
			$('#transaction-hour').val(today.getHours());
			$('#transaction-minute').val(today.getMinutes());

			$('#transaction-date').datepicker()
				.on('show', function(e) {
					$('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
					$('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
				});

			$('select[name="storage_id"]').on('change', function(e){
				$.ajax({
					type: 'POST',
					dataType: 'json',
					data: {'storage_id' : $(this).val()},
					url: "<?php echo route('card.productOptions') ?>",
					success: function(data) {
						$('select[name="product_id[]"]').first().html('');
						$('select[name="product_id[]"]').first().html(data.options);
					}
				});
			});
		});
	</script>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}