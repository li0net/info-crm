@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h4>Информация о схеме расчета ЗП</h4>	
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
				{!! Form::open(['route' => ['wage_scheme.store'], 'class' => 'form-horizontal']) !!}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('scheme_name', 'Наименование:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-8">
								<p class="lead">{{ $scheme->scheme_name }}
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label">
								{{ Form::label('services_percent', 'Услуги:', ['class' => 'form-spacing-top']) }}
							</label>
							<div class="col-sm-6">
								<p class="lead">{{ $scheme->services_percent }}
							</div>
							<div class="col-sm-2">
								<p class="lead">
									@if( $scheme->service_unit == 'rub' )
										&#8381
									@else
										%
									@endif
								</p>
								{{-- , ['rub' => '₽', 'pct' => '%'], 'rub', ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }} --}}
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								{{ Form::label('products_percent', 'Товары:', ['class' => 'form-spacing-top']) }}
							</label>
							<div class="col-sm-6">
								<p class="lead">{{ $scheme->products_percent }}
							</div>
							<div class="col-sm-2">
								<p class="lead">
									@if( $scheme->products_unit == 'rub' )
										&#8381
									@else
										%
									@endif
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								{{ Form::label('wage_rate', 'Оклад:', ['class' => 'form-spacing-top']) }}
							</label>
							<div class="col-sm-6">
								<p class="lead">{{ $scheme->wage_rate }}
							</div>
							<div class="col-sm-2">
								<p class="lead">
									@if( $scheme->wage_rate_period == 'hour' )
										в час
									@elseif( $scheme->wage_rate_period == 'day' )
										в день
									@else
										в месяц
									@endif
								</p>
							</div>
						</div>

						<div class="form-group">
							{{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }}
							<label class="col-sm-8 text-left">
								{{ Form::checkbox('is_client_discount_counted', 1, $scheme->is_client_discount_counted, ['style' => 'margin-right: 10px', 'disabled']) }}
								 Учитывать скидку клиенту при расчете ЗП 
							</label>
						</div>
						
						<div class="form-group">
							{{ Form::label(null, null, ['class' => 'col-sm-2 text-right ctrl-label']) }}
							<label class="col-sm-8 text-left">
								{{ Form::checkbox('is_material_cost_counted', 1, $scheme->is_material_cost_counted, ['style' => 'margin-right: 10px', 'disabled']) }}
								 Учитывать себестоимость материалов при расчете ЗП 
							</label>
						</div>
					</div>						
				{!! Form::close() !!}	
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('wage_scheme', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('wage_scheme.edit', 'Редактировать', [$scheme->scheme_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('wage_scheme', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['wage_scheme.destroy', $scheme->scheme_id], "method" => 'DELETE']) !!}

							{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('wage_scheme.index', 'Все схемы расчета »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}