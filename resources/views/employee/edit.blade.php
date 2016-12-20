@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_edit') }}
@endsection

@section('main-content')
	<div class="row">
		{!! Form::model($employee, ['route' => ['employee.update', $employee->employee_id], 'method' => 'PUT']) !!}
			<div class="col-md-4 col-md-offset-4">
				{{ Form::label('employee_id', 'Сотрудник:') }}
				<p class="lead">#{{ $employee->employee_id }}</p>
				{{-- {{ Form::('employee_id', null, ['class' => 'form-control']) }} --}}

				{{ Form::label('name', 'ФИО:', ['class' => 'form-spacing-top']) }}
				{{ Form::text('name', null, ['class' => 'form-control']) }}

				{{ Form::label('email', "Email: ", ['class' => 'form-spacing-top']) }}
				{{ Form::text('email', null, ['class' => 'form-control']) }}

				{{ Form::label('phone', "Номер телефона: ", ['class' => 'form-spacing-top']) }}
				{{ Form::text('phone', null, ['class' => 'form-control']) }}

				{{ 	Form::label('position_id', 'Должность: ') }}
				{{	Form::select('position_id', [1 => 'Парикмахер', 2 => 'Мастер манюкюра', 3 => 'Визажист'], $employee->position_id, ['class' => 'form-control', 'required' => '']) }}

				<hr>
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('employee.show', 'Отмена', [$employee->employee_id], ['class'=>'btn btn-danger btn-block']) !!}
					</div>
					<div class="col-sm-6">
						{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
					</div>
				</div>
			</div>

			{{-- <div class="col-md-4">
				<div class="well">
					<dl class="dl-horizontal">
						<dt>Сотрудник создан:</dt>
						<dd>{{ date('d-m-Y H:i:s', strtotime($employee->created_at))}}</dd>
					</dl>

					<dl class="dl-horizontal">
						<dt>Данные сотрудника обновлены:</dt>
						<dd>{{ date('d-m-Y H:i:s', strtotime($employee->updated_at))}}</dd>
					</dl>
					
					<hr>

					<div class="row">
						<div class="col-sm-6">
							{!! Html::linkRoute('employee.show', 'Отмена', [$employee->employee_id], ['class'=>'btn btn-danger btn-block']) !!}
						</div>
						<div class="col-sm-6">
							{{ Form::submit('Сохранить', ['class'=>'btn btn-success btn-block']) }}
						</div>
					</div>
				</div>
			</div> --}}
		{!! Form::close() !!}
	</div>
@stop