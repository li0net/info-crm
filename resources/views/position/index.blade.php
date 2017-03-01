@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.positions') }}
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
		<div class="col-sm-10">
			<h4>{{ trans('adminlte_lang::message.positions') }}</h1>
		</div>	

		<div class="col-sm-2">
			<a href="{{ route('position.create') }}" class="btn btn-primary btn-block">{{ trans('adminlte_lang::message.new_position') }}</a>
		</div>

		<div class="col-sm-12">
			<hr>	
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover table-striped">
				<thead>
					<th>#</th>
					<th>{{ trans('adminlte_lang::message.position_name') }}</th>
					<th>{{ trans('adminlte_lang::message.description') }}</th>
					<th></th>
				</thead>

				<tbody>
					@foreach($positions as $position)
						<tr>
							<th>{{ $position->position_id }}</th>
							<td>{{ $position->title }}</td>
							<td>{{ $position->description }}</td>

							<td class="text-right">
								@if ($user->hasAccessTo('position', 'edit', 0))
									<a href="{{ route('position.edit', $position->position_id) }}#menu1" id="position_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('position', 'delete', 0))
									{!! Form::open(['route' => ['position.destroy', $position->position_id], "id" => 'form'.$position->position_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', "method" => 'DELETE']) !!}
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