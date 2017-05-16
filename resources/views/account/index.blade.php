@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.accounts') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.accounts') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

	<div class="row">
		<div class="col-sm-12 text-right">
			<a href="{{ route('account.create') }}" class="btn btn-primary">{{ trans('adminlte_lang::message.account_create_new') }}</a>
		</div>
		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover table-condensed">
				<thead>
					<th class="text-center">#</th>
					<th>{{ trans('adminlte_lang::message.account_name') }}</th>
					<th>{{ trans('adminlte_lang::message.account_balance') }}</th>
					<th>{{ trans('adminlte_lang::message.account_income') }}</th>
					<th>{{ trans('adminlte_lang::message.account_expenses') }}</th>
					<th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
				</thead>
				<tbody>
					@foreach($accounts as $account)
						<tr>
							<th class="text-center">{{ $account->account_id }}</th>
							<td>
								{{ $account->title }}
								<br>
								<small>{{ $account->comment }}</small>
							</td>
							<td>
								{{ $account->balance }} &#8381;
								<br>
								<small>{{ trans('adminlte_lang::message.account_balance_descr') }}</small>
							</td>
							<td><Это расчетное поле> &#8381;
								<br>
								<small>{{ trans('adminlte_lang::message.account_income_descr') }}</small>
							</td>
							<td><Это расчетное поле> &#8381;
								<br> 
								<small>{{ trans('adminlte_lang::message.account_expenses_descr') }}</small>
							</td>
							<td class="text-center">
								@if ($user->hasAccessTo('account', 'edit', 0))
									<a href="{{ route('account.edit', $account->account_id) }}" id="account_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('account', 'delete', 0))
									{!! Form::open(['route' => ['account.destroy', $account->account_id], 'id' => 'form'.$account->account_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$account->account_id}}')" class="table-action-link danger-action"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $accounts->render(); !!}
			</div>
		</div>
	</div>
</div>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>