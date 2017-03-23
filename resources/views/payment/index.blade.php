@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.payments') }}
@endsection

@section('main-content')

    @include('partials.alerts')

	<div class="row">
		<div class="col-sm-4">
			<h4>{{ trans('adminlte_lang::message.payments') }}</h4>
		</div>	

		<div class="col-sm-8">
			<a href="{{ route('payment.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.new_payment') }}</a>
			<a href="#" class="btn btn-default m-r pull-right">{{ trans('adminlte_lang::message.load_from_excel') }}</a>
			<a href="#" class="btn btn-default m-r pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<form method="post" action="/payment" class="form">
		{{ csrf_field() }}
		{{ Form::hidden('organization_id', $user->organization_id, ['id' => 'organization_id']) }}
		<fieldset>
			<div class="row m-b">
				<div class="col-sm-3">
					<div class="input-group">
						<span class="input-group-addon">c&nbsp;&nbsp;</span>
						<input class="form-control hasDatepicker" name="start_date" data-days-offset="-1" type="text" id="date-from">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="input-group">
						<span class="input-group-addon">по</span>
						<input class="form-control hasDatepicker" name="end_date" type="text" id="date-to">
					</div>
				</div>
				<div class="col-sm-3">
					<select class="form-control" data-placeholder={{ trans('adminlte_lang::message.select_payment_status') }} name="balance_is">
						<option selected="" value="0">{{ trans('adminlte_lang::message.payment_all_types') }}</option>
						<option value="1">{{ trans('adminlte_lang::message.income') }}</option>
						<option value="2">{{ trans('adminlte_lang::message.expenses') }}</option>
						<option value="3">{{ trans('adminlte_lang::message.transfer') }}</option>
					</select>
				</div>	    	
				<div class="col-sm-3">
				{{ Form::select('partner_id', $partners, null, ['class' => 'form-control', 
																'required' => '', 
																'id' => 'partner_id', 
																'placeholder' => trans('adminlte_lang::message.partner_not_chosen')]) }}
				</div>	
			</div>
			<div class="row m-b">
				<div class="col-sm-3">
					{{ Form::select('account_id', $accounts, null, ['class' => 'form-control', 
																	'required' => '', 
																	'id' => 'account_id', 
																	'placeholder' => trans('adminlte_lang::message.account_not_chosen')]) }}
				</div>
				<div class="col-sm-3">
					{{ Form::select('item_id', $items, null, ['class' => 'form-control', 
															  'required' => '', 
															  'id' => 'item_id', 
															  'placeholder' => trans('adminlte_lang::message.payment_item_not_chosen')]) }}			
				</div>
				<div class="col-sm-3">
					{{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 
																	  'required' => '', 
																	  'id' => 'employee_id', 
																	  'placeholder' => trans('adminlte_lang::message.employee_not_chosen')]) }}
				</div>
				<div class="col-sm-3">
					{{ Form::select('client_id', $clients, null, ['class' => 'form-control', 
																  'required' => '', 
																  'id' => 'client_id', 
																  'placeholder' => trans('adminlte_lang::message.client_not_chosen')]) }}
				</div>
				{{-- <div class="col-sm-3">
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
					<input type="text" class="form-control ui-autocomplete-input" name="client" value="" placeholder="Поиск клиента (имя или телефон)" autocomplete="off">
					<input type="hidden" class="form-control" name="client_id" value=""> 
				</div> --}}
			</div>
			<div class="row m-b">
				<div class="col-sm-3 transactions-multi-filters">
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
				<div class="col-sm-3 transactions-multi-filters">
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
				<div class="col-sm-3">
					<select class="form-control" data-placeholder={{ trans('adminlte_lang::message.select_payment_status') }} name="deleted">
						<option selected="" value="0">{{ trans('adminlte_lang::message.not_cancelled') }}</option>
						<option value="1">{{ trans('adminlte_lang::message.cancelled') }}</option>
					</select>
				</div>
				<div class="form-inline">
					<div class="col-sm-3">
						<select name="editable_length" aria-controls="editable" class="form-control input-sm">
							<option selected="" value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select> {{ trans('adminlte_lang::message.payments_per_page') }}
					</div>
				</div>
			</div>
			<div class="row m-b ">
				<div class="col-sm-2 col-sm-offset-10">
					<input type="button" class="btn btn-success btn-sm pull-right" value={{ trans('adminlte_lang::message.show') }} id='form_submit'>
				</div>
			</div>
		</fieldset>
	</form>
	<div class="row">
		<div class="col-sm-12" id="result_container">
			<table class="table table-hover table-condensed">
				<thead>
					<th class="text-center">#</th>
					<th>{{ trans('adminlte_lang::message.date') }}</th>
					<th>{{ trans('adminlte_lang::message.beneficiary_name') }}</th>
					<th>{{ trans('adminlte_lang::message.purpose') }}</th>
					<th>{{ trans('adminlte_lang::message.account') }}</th>
					{{-- <th>{{ trans('adminlte_lang::message.comment') }}</th>
					<th>{{ trans('adminlte_lang::message.author') }}</th> --}}
					<th>{{ trans('adminlte_lang::message.sum') }}</th>
					<th>{{ trans('adminlte_lang::message.balance_in_cash') }}</th>
					{{-- <th>{{ trans('adminlte_lang::message.service_good') }}</th>
					<th>{{ trans('adminlte_lang::message.visit') }}</th> --}}
				</thead>
				<tbody>
					@foreach($payments as $payment)
						<tr>
							<th class="text-center">{{ $payment->payment_id }}</th>
							<td>{{ $payment->date }}</td>
							@if($payment->beneficiary_type == 'partner' && null !== $payment->partner)
								<td>{{ $payment->partner->title }}</td>
							@elseif($payment->beneficiary_type == 'client' && null !== $payment->client) 
								<td>{{ $payment->client->name }}</td>
							@elseif(null !== $payment->employee)
								<td>{{ $payment->employee->name }}</td>
							@else
								<td></td>
							@endif
							<td>{{ $payment->item->title }}</td>
							<td>{{ $payment->account->title }}</td>
							{{-- <td>{{ $payment->description }}</td>
							<td>{{ $payment->user->name }}</td> --}}
							<td>{{ $payment->sum }}</td>
							<td> 0-00 </td>
							{{-- <td></td>
							<td></td> --}}

							<td class="text-right" style="min-width: 100px;">
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
			weekStart: 1
		});

		var today = new Date();

		$('#date-from').datepicker('update', today);

		$('#date-to').datepicker({
			autoclose: true,
			orientation: 'auto',
			format: 'dd-mm-yyyy',
			weekStart: 1
		});

		$('#date-to').datepicker('update', today);

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

		$('#form_submit').on('click', function(e){
			var me = this;
			$.ajax({
				type: "POST",
				dataType: 'html',
				data: {	'date_from'			: $('#date-from').val(),
						'date_to'			: $('#date-to').val(),
						'partner_id'		: $('#partner_id').val(),
						'account_id'		: $('#account_id').val(),
						'item_id'			: $('#item_id').val(),
						'employee_id'		: $('#employee_id').val(),
						'client_id'			: $('#client_id').val(),
						'organization_id'	: $('#organization_id').val(),
						},
				url: "/payment/list",
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

			$.ajax({
				type: "POST",
				dataType: 'html',
				data: {	'date_from'			: $('#date-from').val(),
						'date_to'			: $('#date-to').val(),
						'partner_id'		: $('#partner_id').val(),
						'account_id'		: $('#account_id').val(),
						'item_id'			: $('#item_id').val(),
						'employee_id'		: $('#employee_id').val(),
						'client_id'			: $('#client_id').val(),
						'organization_id'	: $('#organization_id').val(),
						'page'				: page
						},
				url: "/payment/list",
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