@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/wage_scheme')}}">{{ trans('adminlte_lang::message.schemes') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</li>
    </ol>
</section>
<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>{{ trans('adminlte_lang::message.information_about_payroll_scheme') }}</h4>	
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
				{!! Form::open(['route' => ['wage_scheme.store']]) !!}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-4">
								{{ Form::label('scheme_name', trans('adminlte_lang::message.scheme_name')) }}
							</div>
							<div class="col-sm-8">
								<p class="lead">{{ $scheme->scheme_name }}</p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="form-group">
							<div class="col-sm-4">
								{{ Form::label('services_percent', trans('adminlte_lang::message.services')) }}
							</div>
							<div class="col-sm-8">
								<p class="lead">
									{{ $scheme->services_percent }}
									@if( $scheme->service_unit == 'rub' )
										&#8381;
									@else
										%
									@endif
								</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<div class="col-sm-4">
								{{ Form::label('products_percent', trans('adminlte_lang::message.products')) }}
							</div>
							<div class="col-sm-8">
								<p class="lead">
									{{ $scheme->products_percent }}
									@if( $scheme->products_unit == 'rub' )
										&#8381;
									@else
										%
									@endif
								</p>
							</div>							
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-4">
								{{ Form::label('wage_rate', trans('adminlte_lang::message.wage')) }}
							</div>
							<div class="col-sm-8">
								<p class="lead">
									{{ $scheme->wage_rate }}
									&#8381;
									@if( $scheme->wage_rate_period == 'hour' )
										{{ trans('adminlte_lang::message.an_hour') }}
									@elseif( $scheme->wage_rate_period == 'day' )
										{{ trans('adminlte_lang::message.a_day') }}
									@else
										{{ trans('adminlte_lang::message.a_month') }}
									@endif
								</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							{{-- {{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }} --}}
							<label class="col-sm-12 text-left">
								{{ Form::checkbox('is_client_discount_counted', 1, $scheme->is_client_discount_counted, ['style' => 'margin-right: 10px', 'disabled']) }}
									{{ trans('adminlte_lang::message.consider_discount') }} 
							</label>
						</div>
					</div>
					
					<div class="row">
						<div class="form-group">
							{{-- {{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }} --}}
							<label class="col-sm-12 text-left">
								{{ Form::checkbox('is_material_cost_counted', 1, $scheme->is_material_cost_counted, ['style' => 'margin-right: 10px', 'disabled']) }}
									{{ trans('adminlte_lang::message.consider_cost_of_materials') }} 
							</label>
						</div>
					</div>
				{!! Form::close() !!}	
				
				<div class="row"><hr></div>

				@if ($crmuser->hasAccessTo('wage_schemes', 'edit', '0'))
					<div class="row">
						@if ($user->hasAccessTo('wage_scheme', 'edit', 0))
							<div class="col-sm-6">
								{!! Html::linkRoute('wage_scheme.edit', trans('adminlte_lang::message.edit'), [$scheme->scheme_id], ['class'=>'btn btn-primary btn-block']) !!}
							</div>
						@endif
						@if ($user->hasAccessTo('wage_scheme', 'delete', 0))
							<div class="col-sm-6">
								{!! Form::open(['route' => ['wage_scheme.destroy', $scheme->scheme_id], "method" => 'DELETE']) !!}
									{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}
								{!! Form::close() !!}
							</div>
						@endif
					</div>
				@endif

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('wage_scheme.index', trans('adminlte_lang::message.schemes').' »', [], ['class' => 'btn btn-default btn-block', 
																													   'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}