@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.schemes') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.schemes') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.schemes') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12 text-right">
			@if ($user->hasAccessTo('wage_schemes', 'edit', '0'))
				<a href="{{ route('wage_scheme.create') }}" class="btn btn-primary">{{ trans('adminlte_lang::message.new_scheme') }}</a>
			@endif
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
					<th>{{ trans('adminlte_lang::message.scheme_name') }}</th>
					<th>{{ trans('adminlte_lang::message.for_services') }}</th>
					<th>{{ trans('adminlte_lang::message.for_products') }}</th>
					<th>{{ trans('adminlte_lang::message.wage') }}</th>
					<th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
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
									&#8381;
								@else
									%
								@endif
							</td>
							<td>
								{{ $scheme->products_percent }}
								@if( $scheme->products_unit == 'rub')
									&#8381;
								@else
									%
								@endif
							</td>
							<td>
								{{ $scheme->wage_rate }}
								<br>
								@if( $scheme->wage_rate_period == 'hour')
									<small>{{ trans('adminlte_lang::message.an_hour') }}</small>
								@elseif( $scheme->wage_rate_period == 'day' )
									<small>{{ trans('adminlte_lang::message.a_day') }}</small>
								@else
									<small>{{ trans('adminlte_lang::message.a_month') }}</small>
								@endif
							</td>
							<td class="text-center">
								@if ($user->hasAccessTo('wage_schemes', 'edit', 0))
									<a href="{{ route('wage_scheme.edit', $scheme->scheme_id) }}" id="scheme_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>

									{!! Form::open(['route' => ['wage_scheme.destroy', $scheme->scheme_id], 'id' => 'form'.$scheme->scheme_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$scheme->scheme_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
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
</div>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>