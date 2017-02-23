@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $employee->name }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="well">
				{{ Form::label('employee_id', trans('adminlte_lang::message.employee')) }}
				<p class="lead">#{{ $employee->employee_id }}</p>

				{{ Form::label('name', trans('adminlte_lang::message.employee_name')) }}
				<p class="lead">{{ $employee->name }}</p>
			
				<dl class="dl-horizontal">
					<label>Email:</label>
					<p class="lead">{{ $employee->email }}</p>
				</dl>

				<dl class="dl-horizontal">
					<label>{{ trans('adminlte_lang::message.employee_phone') }}</label>
					<p class="lead">{{ $employee->phone }}</p>
				</dl>

				<dl class="dl-horizontal">
					<label>{{ trans('adminlte_lang::message.employee_position') }}</label>
					<p class="lead">{{ $employee->position->title }}</p>
				</dl>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('employee', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('employee.edit', trans('adminlte_lang::message.edit'), [$employee->employee_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('employee', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['employee.destroy', $employee->employee_id], "method" => 'DELETE']) !!}

							{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('employee.index', trans('adminlte_lang::message.employees').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection