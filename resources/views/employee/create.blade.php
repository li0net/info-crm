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
				{!! Form::open(['route' => ['employee.store'], 'method' => 'PUT', 'files' => 'true']) !!}
					<div class="col-sm-8 b-r">	
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
							{{	Form::select('position_id', $items, 1, ['class' => 'form-control', 'required' => '']) }}
						</div>
					</div>

					<div class="col-sm-4 text-center">
						<label class="ctrl-label">@{{message}}</label>
						<div class="logo-block">
							<div v-if="!image">
								<img src="/images/no-master.png" alt="">
							</div>
							<div v-else>
								<img :src="image" />
							</div>
						</div>
						<span class="btn btn-success btn-file">
							@lang('main.user:logo_btn')<input type="file" name="avatar" @change="onFileChange">
						</span>
					</div>

					<hr>

					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							{{	Form::submit('Создать нового сотрудника', ['class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px;']) }}
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