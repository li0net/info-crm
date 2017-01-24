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
			<h4>Все контрагенты</h4>
		</div>	

		<div class="col-sm-4">
			<a href="{{ route('partner.create') }}" class="btn btn-primary pull-right">Новый контрагент</a>
			<a href="#" class="btn btn-default m-r pull-right">Загрузить из Excel</a>
			<a href="#" class="btn btn-default m-r pull-right">Выгрузить в Excel</a>
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
					<th>Наименование контрагента</th>
					<th>Контакты</th>
					<th>Реквизиты</th>
					<th>Адрес</th>
					<th>Баланс</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($partners as $partner)
						<tr>
							<th class="text-center">{{ $partner->partner_id }}</th>
							<td>
								{{ $partner->title }}
								<br>
								<small>{{ $partner->description }}</small>
							</td>
							<td>
								{{ $partner->contacts }}
								<br>
								<small>{{ $partner->phone }}</small>
								<br>
								<small>{{ $partner->email }}</small>
							</td>
							<td>
								ИНН: {{ $partner->inn }}
								<br>
								КПП: {{ $partner->kpp }}
							</td>
							<td>
								{{ $partner->address }}
							</td>
							<td>
								<Это расчетное поле> &#8381
							</td>
							<td class="text-right">
								@if ($user->hasAccessTo('partner', 'edit', 0))
									<a href="{{ route('partner.edit', $partner->partner_id) }}" id="partner_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('partner', 'delete', 0))
									{!! Form::open(['route' => ['partner.destroy', $partner->partner_id], 'id' => 'form'.$partner->partner_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$partner->partner_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $partners->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>