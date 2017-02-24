@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.item_information') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h4>{{ trans('adminlte_lang::message.item_information') }}</h4>	
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
				{!! Form::open(['route' => 'item.store']) !!}
					<div class="form-group">
						{{ Form::label('title', trans('adminlte_lang::message.item_name'), ['class' => 'form-spacing-top']) }}
						{{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
					</div>

					<div class="form-group">
						{{ Form::label('type', trans('adminlte_lang::message.item_type'), ['class' => 'form-spacing-top']) }}
						{{ Form::select('type', [1 => trans('adminlte_lang::message.income'), 
												 2 => trans('adminlte_lang::message.expenses_on_cost'), 
												 3 => trans('adminlte_lang::message.commercial_exps'), 
												 4 => trans('adminlte_lang::message.staff_exps'), 
												 5 => trans('adminlte_lang::message.admin_exps'), 
												 6 => trans('adminlte_lang::message.taxes'), 
												 7 => trans('adminlte_lang::message.other_exps')], 'income', ['class' => 'form-control', 'required' => '']) }}
					</div>

					<div class="form-group">
						{{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'form-spacing-top']) }}
						{{ Form::textarea('description', null, ['class' => 'form-control']) }}
					</div>

					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							{{ Form::submit(trans('adminlte_lang::message.item_create_new'), ['class' => 'btn btn-success btn-block']) }}
						</div>
					</div>
					{{-- {{	Form::submit(trans('adminlte_lang::message.item_create_new'), ['class' => 'btn btn-success text-center', 'style' => 'margin-top:20px;']) }} --}}
				{!! Form::close() !!}	
			</div>
		</div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}