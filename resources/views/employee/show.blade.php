@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $employee->name }}
@endsection

@section('main-content')
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>Успешно:</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="well">
				{{ Form::label('employee_id', "Сотрудник: ") }}
				<p class="lead">#{{ $employee->employee_id }}</p>

				{{ Form::label('name', "ФИО: ") }}
				<p class="lead">{{ $employee->name }}</p>
			
				<dl class="dl-horizontal">
					<label>Email:</label>
					<p class="lead">{{ $employee->email }}</p>
				</dl>

				<dl class="dl-horizontal">
					<label>Номер телефона:</label>
					<p class="lead">{{ $employee->phone }}</p>
				</dl>

				<dl class="dl-horizontal">
					<label>Должность:</label>
					<p class="lead">{{ $employee->position->title }}</p>
				</dl>
				
				<hr>

				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('employee.edit', 'Редактировать', [$employee->employee_id], ['class'=>'btn btn-primary btn-block']) !!}
					</div>
					<div class="col-sm-6">
						{!! Form::open(['route' => ['employee.destroy', $employee->employee_id], "method" => 'DELETE']) !!}

						{{ Form::submit('Удалить', ['class'=>'btn btn-danger btn-block']) }}

						{!! Form::close() !!}
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
							{{ Html::linkRoute('employee.index', 'Все сотрудники »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 'style' => 'margin-top:15px']) }}
					</div>
				</div>

			</div>
		</div>
	</div>
@endsection