@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<h4>{{ trans('adminlte_lang::message.account_create_new') }}</h4>	
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
						{{ Form::label('title', trans('adminlte_lang::message.account_create_new'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', trans('adminlte_lang::message.account_type'), ['class' => 'form-spacing-top']) }}
						{{ Form::select('type', ['cash' => trans('adminlte_lang::message.cash'), 'noncache' => trans('adminlte_lang::message.non-cash')], 'cash', ['class' => 'form-control', 'required' => '']) }}
					</div>

					<div class="form-group">
						{{ Form::label('balance', trans('adminlte_lang::message.account_initial_balance'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('balance', null, ['class' => 'form-control']) }}
					</div>

					<div class="form-group">
						{{ Form::label('comment', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top']) }}
						{{ Form::textarea('comment', null, ['class' => 'form-control']) }}
					</div>

					{{	Form::submit(trans('adminlte_lang::message.account_create_new'), ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px;']) }}
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}