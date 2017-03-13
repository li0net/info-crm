@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employees') }}
@endsection

@section('main-content')

<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.employees') }}</h1>
    <!--<ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Advanced Elements</li>
    </ol>-->
</section>
<div class="row">
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            <strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
        </div>
    @endif
</div>
	<div class="row">
		<div class="col-sm-12 text-right">
			<a href="{{ route('employee.create') }}" class="btn btn-primary ">{{ trans('adminlte_lang::message.employee_create_new') }}</a>
		</div>
        <hr>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover table-condensed">
				<thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th></th>
                        <th>{{ trans('adminlte_lang::message.employee_name') }}</th>
                        <th>{{ trans('adminlte_lang::message.employee_email') }}</th>
                        <th>{{ trans('adminlte_lang::message.employee_phone') }}</th>
                        <th>{{ trans('adminlte_lang::message.employee_position') }}</th>
                        <th class="text-right">{{ trans('adminlte_lang::message.actions') }}</th>
                    </tr>
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
								<a href="{{ route('employee.show', $employee->employee_id) }}" class="table-action-link"><i class='fa fa-eye'></i></a>
								@if ($user->hasAccessTo('employee', 'edit', 0))
									<a href="{{ route('employee.edit', $employee->employee_id) }}#menu1" id="employee_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu2" class="table-action-link"><i class='fa fa-tags'></i></a>
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu3" class="table-action-link"><i class='fa fa-clock-o'></i></a>
								<a href="{{ route('employee.edit', $employee->employee_id) }}#menu4" class="table-action-link"><i class='fa fa-cog'></i></a>
								@if ($user->hasAccessTo('employee', 'delete', 0))
									{!! Form::open(['route' => ['employee.destroy', $employee->employee_id], 'id' => 'form'.$employee->employee_id, 'style' => 'max-width: 32px; margin:0; padding:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$employee->employee_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
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