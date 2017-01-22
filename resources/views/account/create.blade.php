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
			<h1>Создание нового счета</h1>	
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
				{!! Form::open(['route' => 'account.store']) !!}
					<div class="form-group">
						{{ Form::label('title', 'Название:', ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', "Тип счета: ", ['class' => 'form-spacing-top']) }}
						{{ Form::select('type', ['cash'=>'Наличный расчет', 'noncache'=>'Безналичный расчет'], 'cash', ['class' => 'form-control', 'required' => '']) }}
					</div>

					<div class="form-group">
						{{ Form::label('balance', "Начальный баланс: ", ['class' => 'form-spacing-top']) }}
						{{ Form::text('balance', null, ['class' => 'form-control']) }}
					</div>

					<div class="form-group">
						{{ Form::label('comment', "Комментарий: ", ['class' => 'form-spacing-top']) }}
						{{ Form::textarea('comment', null, ['class' => 'form-control']) }}
					</div>

					{{	Form::submit('Создать новый счет', ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px;']) }}
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}