@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<h1>Создание нового сотрудника</h1>	
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
				{!! Form::open(['route' => 'employee.store']) !!}
					{{-- {{ 	Form::label('employee_id', 'ID сотрудника:') }}
					{{ 	Form::text('employee_id', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '3']) }} --}}
					<div class="form-group">
						{{ Form::label('name', 'ФИО:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('name', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
					</div>

					<div class="form-group">
						{{ Form::label('email', "Email: ", ['class' => 'form-spacing-top']) }}
						{{ Form::text('email', null, ['class' => 'form-control', 'email' => '']) }}
					</div>

					<div class="form-group">
						{{ 	Form::label('phone', 'Номер телефона: ') }}
						{{ 	Form::text('phone', null, ['class' => 'form-control', 'required' => '']) }}
					</div>
			
					<div class="form-group">
						{{ 	Form::label('position_id', 'Должность: ') }}
						{{	Form::select('position_id', [1 => 'Парикмахер', 2 => 'Мастер манюкюра', 3 => 'Визажист'], 1, ['class' => 'form-control', 'required' => '']) }}
					</div>

					{{	Form::submit('Создать нового сотрудника', ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px;']) }}
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}