@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
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
		<div class="col-md-10">
			<h1>Все сотрудники</h1>
		</div>	

		<div class="col-md-2">
			<a href="{{ route('employee.create') }}" class="btn btn-primary btn-lg btn-block btn-h1-spacing">Новый сотрудник</a>
		</div>

		<div class="col-md-12">
			<hr>	
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead>
					<th>#</th>
					<th>ФИО</th>
					<th>Email</th>
					<th>Номер телефона</th>
					<th>Должность</th>
					<th></th>
				</thead>

				<tbody>
					@foreach($employees as $employee)
						<tr>
							<th>{{ $employee->employee_id }}</th>
							<td>{{ $employee->name }}</td>
							<td>{{ $employee->email }}</td>
							<td>{{ $employee->phone }}</td>
							<td>{{ $employee->position->title }}</td>

							<td><a href="{{ route('employee.show', $employee->employee_id) }}" class="btn btn-default btn-sm"><i class='fa fa-eye'></i></a> <a href="{{ route('employee.edit', $employee->employee_id) }}" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a></td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="text-center">
				{!! $employees->render(); !!} 
				{{-- {{ $employees->appends(Input::all())->render() }} --}}
			</div>
		</div>
	</div>

@endsection