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
			<h1>Все должности</h1>
		</div>	

		<div class="col-md-2">
			<a href="{{ route('position.create') }}" class="btn btn-primary btn-lg btn-block btn-h1-spacing">Новая должность</a>
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
					<th>Название</th>
					<th>Описание</th>
					<th></th>
				</thead>

				<tbody>
					@foreach($positions as $position)
						<tr>
							<th>{{ $position->position_id }}</th>
							<td>{{ $position->title }}</td>
							<td>{{ $position->description }}</td>

							<td class="text-right">
								@if ($user->hasAccessTo('employee', 'edit', 0))
									<a href="{{ route('position.edit', $position->position_id) }}#menu1" id="employee_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('employee', 'delete', 0))
									{!! Form::open(['route' => ['position.destroy', $position->position_id], "id" => 'form'.$position->position_id, "style" => "display: inline-block", "method" => 'DELETE']) !!}
											<a href="javascript: submitform('#form{{$position->position_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="text-center">
				{!! $positions->render(); !!} 
			</div>
		</div>
	</div>

@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>