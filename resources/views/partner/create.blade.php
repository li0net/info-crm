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
			<h1>Информация о контрагенте</h1>	
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
				{!! Form::open(['route' => 'partner.store']) !!}
					<div class="form-group">
						{{ Form::label('title', 'Наименование:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', "Тип: ", ['class' => 'form-spacing-top']) }}
						{{ Form::select('type', ['company'=>'Юридическое лицо', 'person'=>'Физическое лицо', 'selfemployed'=>'Индивидуальный предприниматель'], 'company', ['class' => 'form-control', 'required' => '']) }}
					</div>

					<div class="form-group">
						{{ Form::label('inn', 'ИНН:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('inn', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '15']) }}
					</div>

					<div class="form-group">
						{{ Form::label('kpp', 'КПП:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('kpp', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '10']) }}
					</div>
					
					<div class="form-group">
						{{ Form::label('contacts', 'Контактное лицо:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('contacts', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('phone', 'Номер телефона:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('phone', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '25']) }}
					</div>

					<div class="form-group">
						{{ Form::label('email', 'e-mail:', ['class' => 'form-spacing-top']) }}
						{{ Form::email('email', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
					</div>

					<div class="form-group">
						{{ Form::label('address', 'Адрес:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('address', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '210']) }}
					</div>

					<div class="form-group">
						{{ Form::label('description', "Описание: ", ['class' => 'form-spacing-top']) }}
						{{ Form::textarea('description', null, ['class' => 'form-control']) }}
					</div>

					{{	Form::submit('Создать нового контрагента', ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px;']) }}
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}