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

							<td class="text-right">
								<a href="{{ route('employee.edit', $employee->employee_id) }}" class="btn btn-default btn-sm"><i class='fa fa-eye'></i></a> 
								@if ($user->hasAccessTo('employee', 'edit', 0))
									<a href="{{ route('employee.edit', $employee->employee_id) }}#menu1" id="employee_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu2" class="btn btn-default btn-sm"><i class='fa fa-tags'></i></a> 
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu3" class="btn btn-default btn-sm"><i class='fa fa-clock-o'></i></a>
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu4" class="btn btn-default btn-sm"><i class='fa fa-cog'></i></a>
								@if ($user->hasAccessTo('employee', 'delete', 0))
									{!! Form::open(['route' => ['employee.destroy', $employee->employee_id], "id" => 'form1', "style" => "display: inline-block", "method" => 'DELETE']) !!}
										<a href="javascript: submitform('form1')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>
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

<script>
	function submitform(){
		$('#form1').submit();
	}
</script>