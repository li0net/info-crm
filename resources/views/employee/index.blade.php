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
		<div class="col-sm-10">
			<h4>Все сотрудники</h4>
		</div>	

		<div class="col-sm-2">
			<a href="{{ route('employee.create') }}" class="btn btn-primary btn-block">Новый сотрудник</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<table class="table">
				<thead>
					<th class="text-center">#</th>
					<th></th>
					<th>ФИО</th>
					<th>Email</th>
					<th>Номер телефона</th>
					<th>Должность</th>
					<th></th>
				</thead>

				<tbody>
					@foreach($employees as $employee)
						<tr>
							<th class="text-center">{{ $employee->employee_id }}</th>
							<td class="text-center"><img src="/images/{{ $employee->avatar_image_name }}" alt="image" style="width: 32px; height: 32px; border-radius: 50%;"></td>
							<td>{{ $employee->name }}</td>
							<td>{{ $employee->email }}</td>
							<td>{{ $employee->phone }}</td>
							<td>{{ $employee->position->title }}</td>

							<td class="text-right">
								<a href="{{ route('employee.show', $employee->employee_id) }}" class="btn btn-default btn-sm"><i class='fa fa-eye'></i></a> 
								@if ($user->hasAccessTo('employee', 'edit', 0))
									<a href="{{ route('employee.edit', $employee->employee_id) }}#menu1" id="employee_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu2" class="btn btn-default btn-sm"><i class='fa fa-tags'></i></a> 
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu3" class="btn btn-default btn-sm"><i class='fa fa-clock-o'></i></a>
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu4" class="btn btn-default btn-sm"><i class='fa fa-cog'></i></a>
								@if ($user->hasAccessTo('employee', 'delete', 0))
									{!! Form::open(['route' => ['employee.destroy', $employee->employee_id], 'id' => 'form'.$employee->employee_id, 'style' => 'max-width: 32px; margin:0; padding:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$employee->employee_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="text-center">
				{!! $employees->render(); !!} 
			</div>
		</div>
	</div>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>