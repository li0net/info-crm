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
			<h4>Все складские операции</h4>
		</div>	

		<div class="col-sm-4">
			<a href="{{ route('storagetransaction.create') }}" class="btn btn-primary pull-right">Новая операция</a>
			<a href="#" class="btn btn-default m-r pull-right">Выгрузить в Excel</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<form method="post" action="#" class="form">
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
					<select class="form-control" data-placeholder="Выберите вид платежа" id="transaction_type">
						<option selected="" value="0">Все виды операций</option>
						<option value="income">Приход</option>
						<option value="expenses">Расход</option>
						<option value="discharge">Списание</option>
						<option value="transfer">Перемещение</option>
					</select>
				</div>	    	
				<div class="col-sm-3">
				{{ Form::select('partner_id', $partners, null, ['class' => 'form-control', 'required' => '', 'id' => 'partner_id', 'placeholder' => 'Контрагент не выбран']) }}
				</div>	
			</div>
			<div class="row m-b">
				<div class="col-sm-3">
					{{ Form::select('account_id', $accounts, null, ['class' => 'form-control', 'required' => '', 'id' => 'account_id', 'placeholder' => 'Счет не выбран']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::select('storage_id', $storages, null, ['class' => 'form-control', 'required' => '', 'id' => 'storage_id', 'placeholder' => 'Склад не выбран']) }}			
				</div>
				<div class="col-sm-3">
					{{ Form::select('employee_id', $employees, null, ['class' => 'form-control', 'required' => '', 'id' => 'employee_id', 'placeholder' => 'Сотрудник не выбран']) }}
				</div>
				<div class="col-sm-3">
					{{ Form::select('client_id', $clients, null, ['class' => 'form-control', 'required' => '', 'id' => 'client_id', 'placeholder' => 'Клиент не выбран']) }}
				</div>
			</div>
			<div class="row m-b">
				<div class="col-sm-3 transactions-multi-filters">
				</div>
				<div class="col-sm-3 transactions-multi-filters">
				</div>
				<div class="col-sm-3">
					<select class="form-control" data-placeholder="Выберите статус платежа" name="deleted">
						<option selected="" value="0">Не отмененные</option>
						<option value="1">Отмененные</option>
					</select>
				</div>
				<div class="form-inline">
					<div class="col-sm-3">
						<select name="editable_length" aria-controls="editable" class="form-control input-sm">
							<option selected="" value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select> операций на странице            
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
	<div class="row">
		<div class="col-sm-12" id = "result_container">
			<table class="table">
				<thead>
					<th class="text-center">#</th>
					<th>Дата</th>
					<th>Наименование контрагента</th>
					<th>Тип операции</th>
					<th>Склад</th>
					<th>Комментарий</th>
					<th>Товар</th>
					<th>Количество</th>
					<th>Себестоимость</th>
					<th>Остаток на складе</th>
					<th>Визит</th>
				</thead>
				<tbody>
					@foreach($transactions as $transaction)
						<tr>
							<th class="text-center">{{ $transaction->id }}</th>
							<td>{{ $transaction->date }}</td>
							@if($transaction->type == 'income' && null !== $transaction->partner)
								<td>{{ $transaction->partner->title }}</td>
							@elseif($transaction->type == 'expenses' && null !== $transaction->client) 
								<td>{{ $transaction->client->name }}</td>
							@elseif($transaction->type == 'discharge')
								<td class='text-center'>-</td>
							@else
								<td class='text-center'>-</td>
							@endif
							{{-- <td>{{ $transaction->partner->title }}</td> --}}
							
							@if($transaction->type == 'income')
								<td>Приход</td>
							@elseif($transaction->type == 'expenses') 
								<td>Расход</td>
							@elseif($transaction->type == 'discharge')
								<td>Списание</td>
							@else
								<td>Перемещение</td>
							@endif

							<td>{{ $transaction->storage1->title }}</td>
							{{-- <td>{{ $transaction->account->title }}</td> --}}
							<td>{{ $transaction->description }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>

							<td class="text-right">
								@if ($user->hasAccessTo('storateTransaction', 'edit', 0))
									<a href="{{ route('storagetransaction.edit', $transaction->id) }}" id="transaction_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('storageTransaction', 'delete', 0))
									{!! Form::open(['route' => ['storagetransaction.destroy', $transaction->id], 'id' => 'form'.$transaction->id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$transaction->id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $transactions->render(); !!} 
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
						'transaction_type'	: $('#transaction_type').val(),
						'partner_id'		: $('#partner_id').val(),
						'account_id'		: $('#account_id').val(),
						'employee_id'		: $('#employee_id').val(),
						'client_id'			: $('#client_id').val(),
						'storage_id'		: $('#storage_id').val(),
						'organization_id'	: $('#organization_id').val(),
						},
				url: "/storagetransaction/list",
				success: function(data) {
						$('#result_container').html(data);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
						console.log('Error while processing payments data range!');
				}
			});
		});

		$('#result_container').on('click', '.pagination', function(e) {
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
						'transaction_type'	: $('#transaction_type').val(),
						'partner_id'		: $('#partner_id').val(),
						'account_id'		: $('#account_id').val(),
						'employee_id'		: $('#employee_id').val(),
						'client_id'			: $('#client_id').val(),
						'storage_id'		: $('#storage_id').val(),
						'organization_id'	: $('#organization_id').val(),
						'page'				: page
						},
				url: "/storagetransaction/list",
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