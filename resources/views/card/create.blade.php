@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>Новая технологическая карта</h4>	
			{{-- <ex1></ex1> --}}
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
				{!! Form::open(['route' => 'card.store', 'class' => 'form-horizontal']) !!}
					<div class="row">
						<div class="form-group">
							<div class="col-sm-2 control-label">
								{{ Form::label('title', 'Наименование:', ['class' => 'form-spacing-top']) }}
							</div>
							<div class="col-sm-9">
								{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>

						<div class="form-group">
							{{ Form::label('description', 'Описание:', ['class' => 'form-spacing-top col-sm-2 control-label']) }}
							<div class="col-sm-9">
								{{ Form::textarea('description', null, ['class' => 'form-control']) }}
							</div>
							<label class="col-sm-1 text-left">
								<a class="fa fa-info-circle" id="service_unit" original-title="">&nbsp;</a>
							</label>
						</div>
					</div>
					
					<hr>

					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							{{	Form::submit('Создать новую технологическую карту', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:20px;']) }}
						</div>
					</div>
				{!! Form::close() !!}	
			</div>
		</div>
	</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}