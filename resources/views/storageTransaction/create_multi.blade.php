@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

@include('partials.alerts')

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
				{!! Form::open(['route' => 'storagetransaction.store', 'class' => 'form-horizontal']) !!}
					{{ Form::hidden('storage_options', null, ['id' => 'storage_options']) }}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('date', 'Дата и время:') }}
							</div>
							<div class="col-sm-5">
								{{ Form::text('transaction-date', '10-02-2017', ['class' => 'form-control transaction-date', 'required' => '', 'maxlength' => '110', 'id' => 'transaction-date']) }}
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
							</label>
						</div>
						<div class="transaction-type-content">
							<div class="form-group">
								<div class="col-sm-2 control-label">
									{{ Form::label('partner_id', 'Контрагент: ') }}
								</div>
								<div class="col-sm-9">
									{{ Form::select('partner_id', $partners, null, ['class' => 'form-control', 'required' => '']) }}
								</div>
								<label class="col-sm-1 text-left">
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
								</label>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-2 control-label">
								<a href="#transaction-items" data-toggle="collapse" class="btn btn-link btn-xs">
								<span class="badge label-danger hidden">@{{ transaction_items_count }}</span>
								&nbsp;&nbsp;Список товаров&nbsp;&nbsp;
								<i class="fa fa-caret-down"></i></a>
							</div>
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
							</label>
						</div>
					</div>
					
					<hr>

					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							{{	Form::submit('Создать новую складскую операцию', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;']) }}
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
			$('select[name="type"]').on('change', function(e){
				$('.transaction-type-content').children().remove();
				if( $(this).val() == 'income') {
					$('.transaction-type-content').append(
								'<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('partner_id', 'Контрагент: ') }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('partner_id', $partners, null, ['class' => 'form-control', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
									</label> \
								</div> \
								\
								<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('storage_id', 'Склад: ') }} \
									</div> \
									<div class="col-sm-9">\
										{{ Form::select('storage_id', $storages, null, ['class' => 'form-control', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
									</label> \
								</div>');
				} else if ($(this).val() == 'expenses') {
					$('.transaction-type-content').append(
								'<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('client_id', 'Клиент: ') }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
									</label> \
								</div> \
								\
								<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('employee_id', 'Сотрудник: ') }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
									</label> \
								</div> \
								\
								<div class="form-group"> \
									<div class="col-sm-2 control-label"> \
										{{ Form::label('storage_id', 'Склад: ') }} \
									</div> \
									<div class="col-sm-9"> \
										{{ Form::select('storage_id', $storages, null, ['class' => 'form-control', 'required' => '']) }} \
									</div> \
									<label class="col-sm-1 text-left"> \
									</label> \
								</div>');
				} else if ($(this).val() == 'discharge') {
					$('.transaction-type-content').append(
									'<div class="form-group"> \
										<div class="col-sm-2 control-label"> \
											{{ Form::label('storage_id', 'Склад: ') }} \
										</div> \
										<div class="col-sm-9"> \
											{{ Form::select('storage_id', $storages, null, ['class' => 'form-control', 'required' => '']) }} \
										</div> \
										<label class="col-sm-1 text-left"> \
										</label> \
									</div>');
				} else {
					$('.transaction-type-content').append(
									'<div class="form-group"> \
										<div class="col-sm-2 control-label"> \
											{{ Form::label('storage_id', 'Со склада: ') }} \
										</div> \
										<div class="col-sm-9"> \
											{{ Form::select('storage_id', $storages, null, ['class' => 'form-control', 'required' => '']) }} \
										</div> \
										<label class="col-sm-1 text-left"> \
										</label> \
									</div> \
									<div class="form-group"> \
										<div class="col-sm-2 control-label"> \
											{{ Form::label('storage2_id', 'На склад: ') }} \
										</div> \
										<div class="col-sm-9"> \
											{{ Form::select('storage2_id', $storages, null, ['class' => 'form-control', 'required' => '']) }} \
										</div> \
										<label class="col-sm-1 text-left"> \
										</label> \
									</div>');
				}
			});
			$('.transaction-type-content').on('change', 'select[name="storage_id"]', function(e){
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