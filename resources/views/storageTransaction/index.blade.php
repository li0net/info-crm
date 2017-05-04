@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')
    <section class="content-header">
        <h1>{{ trans('adminlte_lang::message.operations')}}</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
            <li class="active">{{ trans('adminlte_lang::message.operations')}}</li>
        </ol>
    </section>
        <div class="container-fluid">

        @include('partials.alerts')

        <div class="row">

            <div class="col-sm-12">
                <a href="{{ route('storagetransaction.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.new_operation')}}</a>
                <a href="#" class="btn btn-info m-r pull-right">{{ trans('adminlte_lang::message.upload_into_excel') }}</a>
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
                            <span class="input-group-addon">{{ trans('adminlte_lang::message.date_from')}}</span>
                            <input class="form-control hasDatepicker" name="start_date" data-days-offset="-1" type="text" id="date-from">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">{{ trans('adminlte_lang::message.date_to')}}</span>
                            <input class="form-control hasDatepicker" name="end_date" type="text" id="date-to">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <select class="js-select-basic-single" data-placeholder="Выберите вид платежа" id="transaction_type">
                            <option selected="" value="0">Все виды операций</option>
                            <option value="income">Приход</option>
                            <option value="expenses">Расход</option>
                            <option value="discharge">Списание</option>
                            <option value="transfer">Перемещение</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                    {{ Form::select('partner_id', $partners, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'partner_id', 'placeholder' => trans('adminlte_lang::message.partner_not_chosen') ]) }}
                    </div>
                </div>
                <div class="row m-b">
                    <div class="col-sm-3">
                        {{ Form::select('account_id', $accounts, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'account_id', 'placeholder' => trans('adminlte_lang::message.account_not_chosen') ]) }}
                    </div>
                    <div class="col-sm-3">
                        {{ Form::select('storage_id', $storages, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'storage_id', 'placeholder' => trans('adminlte_lang::message.storage_not_chosen') ]) }}
                    </div>
                    <div class="col-sm-3">
                        {{ Form::select('employee_id', $employees, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'employee_id', 'placeholder' => trans('adminlte_lang::message.employee_not_chosen') ]) }}
                    </div>
                    <div class="col-sm-3">
                        {{ Form::select('client_id', $clients, null, ['class' => 'js-select-basic-single', 'required' => '', 'id' => 'client_id', 'placeholder' => trans('adminlte_lang::message.client_not_chosen') ]) }}
                    </div>
                </div>
                <div class="row m-b">
                    <div class="col-sm-3 transactions-multi-filters">
                    </div>
                    <div class="col-sm-3 transactions-multi-filters">
                    </div>
                    <div class="col-sm-3">
                        <select class="js-select-basic-single" data-placeholder="{{ trans('adminlte_lang::message.select_payment_status')}}" name="deleted">
                            <option selected="" value="0">{{ trans('adminlte_lang::message.not_cancelled')}}</option>
                            <option value="1">{{ trans('adminlte_lang::message.cancelled')}}</option>
                        </select>
                    </div>
                    <div class="form-inline">
                        <div class="col-sm-1">
                            <select name="editable_length" aria-controls="editable" class="js-select-basic-single">
                                <option selected="" value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <p class="m-t">{{ trans('adminlte_lang::message.rows_per_page')}}</p>
                        </div>

                    </div>
                </div>
                <div class="row m-b ">
                    <div class="col-sm-12 text-right">
                        <input type="button" class="btn btn-primary" value="{{ trans('adminlte_lang::message.show')}}" id='form_submit'>
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="row">
            <div class="col-sm-12" id="result_container">
                <table class="table table-hover table-condensed">
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
                        <th class="text-center">{{ trans('adminlte_lang::message.actions')}}</th>
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

                                <td class="text-center">
                                    @if ($user->hasAccessTo('storateTransaction', 'edit', 0))
                                        <a href="{{ route('storagetransaction.edit', $transaction->id) }}" id="transaction_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
                                    @endif
                                    @if ($user->hasAccessTo('storageTransaction', 'delete', 0))
                                        {!! Form::open(['route' => ['storagetransaction.destroy', $transaction->id], 'id' => 'form'.$transaction->id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
                                            <a href="javascript: submitform('#form{{$transaction->id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
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
    </div>
@endsection

@section('page-specific-scripts')
<script>
	$(document).ready(function(){
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