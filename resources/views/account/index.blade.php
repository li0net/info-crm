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
		<div class="col-sm-10">
			<h4>Все счета</h4>
		</div>	

		<div class="col-sm-2">
			<a href="{{ route('account.create') }}" class="btn btn-primary btn-block">Новый счет</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<thead>
					<th class="text-center">#</th>
					<th>Наименование счета/кассы</th>
					<th>Остаток</th>
					<th>Доходы</th>
					<th>Расходы</th>
					<th></th>
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
								{{ $account->balance }} &#8381
								<br>
								<small>Текущий остаток на счете(в кассе)</small>
							</td>
							<td><Это расчетное поле> &#8381
								<br>
								<small>Выручка за текущий месяц</small>
							</td>
							<td><Это расчетное поле> &#8381
								<br> 
								<small>Расходы за текущий месяц</small>
							</td>
							<td class="text-right">
								@if ($user->hasAccessTo('account', 'edit', 0))
									<a href="{{ route('account.edit', $account->account_id) }}" id="account_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('account', 'delete', 0))
									{!! Form::open(['route' => ['account.destroy', $account->account_id], 'id' => 'form'.$account->account_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$account->account_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
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
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>