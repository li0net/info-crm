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
			<h4>Все схемы расчет ЗП</h4>
		</div>	

		<div class="col-sm-2">
			<a href="{{ route('wage_scheme.create') }}" class="btn btn-primary btn-block">Новая схема</a>
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
					<th>Наименование схемы</th>
					<th>За услуги</th>
					<th>За товары</th>
					<th>Оклад</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($schemes as $scheme)
						<tr>
							<th class="text-center">{{ $scheme->scheme_id }}</th>
							<td>
								{{ $scheme->scheme_name }}
							</td>
							<td>
								{{ $scheme->services_percent }}
								@if( $scheme->service_unit == 'rub')
									&#8381
								@else
									%
								@endif
							</td>
							<td>
								{{ $scheme->products_percent }}
								@if( $scheme->products_unit == 'rub')
									&#8381
								@else
									%
								@endif
							</td>
							<td>
								{{ $scheme->wage_rate }}
								<br>
								@if( $scheme->wage_rate_period == 'hour')
									<small>в час</small>
								@elseif( $scheme->wage_rate_period == 'day' )
									<small>в день</small>
								@else
									<small>в месяц</small>
								@endif
							</td>
							<td class="text-right">
								@if ($user->hasAccessTo('wage_schemes', 'edit', 0))
									<a href="{{ route('wage_scheme.edit', $scheme->scheme_id) }}" id="scheme_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('wage_schemes', 'delete', 0))
									{!! Form::open(['route' => ['wage_scheme.destroy', $scheme->scheme_id], 'id' => 'form'.$scheme->scheme_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$scheme->scheme_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $schemes->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>