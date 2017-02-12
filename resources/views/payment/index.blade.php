@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>Успешно:</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>

	<div class="row">
		<div class="col-sm-8">
			<h4>Все финансовые операции</h4>
		</div>	

		<div class="col-sm-4">
			<a href="{{ route('payment.create') }}" class="btn btn-primary pull-right">Новый платеж</a>
			<a href="#" class="btn btn-default m-r pull-right">Загрузить из Excel</a>
			<a href="#" class="btn btn-default m-r pull-right">Выгрузить в Excel</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<form method="get" action="#" class="form">
		<fieldset>
			<div class="row m-b">
				<div class="col-md-3">
					<div class="input-group">
						<span class="input-group-addon">c&nbsp;&nbsp;</span>
						<input class="form-control hasDatepicker" name="start_date" data-days-offset="-1" type="text" id="date-from">
					</div>
				</div>
				<div class="col-md-3">
					<div class="input-group">
						<span class="input-group-addon">по</span>
						<input class="form-control hasDatepicker" name="end_date" type="text" id="date-to">
					</div>
				</div>
				<div class="col-md-3">
					<select class="form-control" data-placeholder="Выберите вид платежа" name="balance_is">
						<option selected="" value="0">Все виды платежей</option>
						<option value="1">Доходы</option>
						<option value="2">Расходы</option>
						<option value="3">Перемещение</option>
					</select>
				</div>	    	
				<div class="col-md-3">
					<select class="form-control" data-placeholder="Выберите контрагента" name="supplier_id">
						<option value="0">Контрагент не выбран</option>
						<option value="11222">Пирожки</option>
					</select>				
				</div>	
			</div>
			<div class="row m-b">
				<div class="col-md-3">
					<select class="form-control" data-placeholder="Выберите кассу" name="account_id">
						<option value="0">Касса не выбрана</option>
						<option value="87128">Основная касса</option>
						<option value="87129">Расчетный счет</option>
					</select>
				</div>
				<div class="col-md-3">
					<select class="form-control" data-placeholder="Выберите статью платежа" name="type">
						<option value="0">Статья платежа не выбрана</option>
						<option value="1">Закупка материалов</option>
						<option value="2">Закупка товаров</option>
						<option value="3">Зарплата персонала</option>
						<option value="4">Налоги и сборы</option>
						<option value="5">Оказание услуг</option>
						<option value="6">Продажа абонементов</option>
						<option value="7">Продажа товаров</option>
						<option value="8">Прочие доходы</option>
						<option value="9">Прочие расходы</option>
					</select>				
				</div>
				<div class="col-md-3">
					<select class="form-control" data-placeholder="Выберите сотрудника" name="master_id">
						<option value="0">Сотрудник не выбран</option>
						<option value="106305">Роман Бакланов</option>
						<option value="110867">Руслан Абдрашитов</option>
						<option value="110871">Константин Дудукалов</option>
					</select>
				</div>
				<div class="col-md-3">
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
					<input type="text" class="form-control ui-autocomplete-input" name="client" value="" placeholder="Поиск клиента (имя или телефон)" autocomplete="off">
					<input type="hidden" class="form-control" name="client_id" value=""> 
				</div>
				
			</div>
			<div class="row m-b">
				<div class="col-md-3 transactions-multi-filters">
					{{-- <select name="good_ids[]" data-placeholder="Выберите товары..." class="chosen-filter-goods small_select form-control" multiple="multiple" style="display: none;">
						<option value="436655">111111111</option>
						<option value="453399">rasas</option>
					</select>
					<div class="chosen-container chosen-container-multi" style="width: 376px;" title="">
						<ul class="chosen-choices">
							<li class="search-field">	
								<input type="text" value="Выберите товары..." class="default" autocomplete="off" style="width: 158px;">
							</li>
						</ul>
						<div class="chosen-drop">
							<ul class="chosen-results">
								<li class="no-results">Начните печатать для поиска товаров...</li>
							</ul>
						</div>
					</div> --}}
				</div>
				<div class="col-md-3 transactions-multi-filters">
					{{-- <select name="service_ids[]" class="form-control chosen-filter-services" data-placeholder="Выберите услуги..." multiple="multiple" style="display: none;">
						<option value="508710">Стрижки и укладки</option>
						<option value="508711">Полубокс</option>
						<option value="529076">Маникюр</option>
						<option value="529077">Стилистика</option>
						<option value="529093">Модельная</option>
						<option value="529094">Наголо</option>
						<option value="529095">Ирокез</option>
						<option value="529096">Французский</option>
						<option value="529100">Со стразами</option>
						<option value="529101">Профилактика</option>
						<option value="529102">Свадебный</option>
						<option value="529104">Деловой</option>
						<option value="529105">Нарядный</option>
					</select>
					<div class="chosen-container chosen-container-multi" style="width: 376px;" title="">
						<ul class="chosen-choices">
							<li class="search-field">
								<input type="text" value="Выберите услуги..." class="default" autocomplete="off" style="width: 151px;">
							</li>
						</ul>
						<div class="chosen-drop">
							<ul class="chosen-results">
								<li class="no-results">Начните печатать для поиска услуг...</li>
							</ul>
						</div>
					</div> --}}
				</div>
				<div class="col-md-3">
					<select class="form-control" data-placeholder="Выберите статус платежа" name="deleted">
						<option selected="" value="0">Не отмененные</option>
						<option value="1">Отмененные</option>
					</select>
				</div>
				<div class="form-inline">
					<div class="col-md-3">
						<select name="editable_length" aria-controls="editable" class="form-control input-sm">
							<option selected="" value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select> платежей на странице            
					</div>
				</div>
			</div>
			<div class="row m-b ">
				<div class="col-md-2 col-md-offset-10">
					<input type="submit" class="btn btn-success btn-sm pull-right" value="Показать">
				</div>
			</div>
		</fieldset>
	</form>
	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<thead>
					<th class="text-center">#</th>
					<th>Дата</th>
					<th>Наименование контрагента</th>
					<th>Назначение</th>
					<th>Касса</th>
					<th>Комментарий</th>
					<th>Автор</th>
					<th>Сумма</th>
					<th>Остаток в кассе</th>
					<th>Услуга/Товар</th>
					<th>Визит</th>
				</thead>
				<tbody>
					@foreach($payments as $payment)
						<tr>
							<th class="text-center">{{ $payment->payment_id }}</th>
							<td>{{ $payment->date }}</td>
							<td>{{ $payment->beneficiary_title }}</td>
							<td>{{ $payment->item->title }}</td>
							<td>{{ $payment->account->title }}</td>
							<td>{{ $payment->description }}</td>
							<td>{{ $payment->user->name }}</td>
							<td>{{ $payment->sum }}</td>
							<td> <Это расчетное поле> </td>
							<td></td>
							<td></td>

							<td class="text-right">
								@if ($user->hasAccessTo('payment', 'edit', 0))
									<a href="{{ route('payment.edit', $payment->payment_id) }}" id="payment_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('payment', 'delete', 0))
									{!! Form::open(['route' => ['payment.destroy', $payment->payment_id], 'id' => 'form'.$payment->payment_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$payment->payment_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $payments->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

@section('page-specific-scripts')
<script>
	$(document).ready(function(){
		$('#date-from').datepicker({
			autoclose: true,
			orientation: 'auto',
			format: 'dd-mm-yyyy',
			firstDay: 1,
		});

		$('#date-to').datepicker({
			autoclose: true,
			orientation: 'auto',
			format: 'dd-mm-yyyy',
			firstDay: 1
		});

		$('#date-from').datepicker()
			.on('show', function(e) {
				$('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
				$('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
			});

		$('#date-to').datepicker()
		    .on('show', function(e) {
		        $('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
		        $('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
		    });
	});
		
</script>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>