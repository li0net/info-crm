@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.resources') }}
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
		<div class="col-sm-8">
			<h4>{{ trans('adminlte_lang::message.resources') }}</h4>
		</div>	

		<div class="col-sm-4">
			<a href="{{ route('resource.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.new_resource') }}</a>
		</div>
		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover table-condensed">
				<thead>
					<th class="text-center">#</th>
					<th>{{ trans('adminlte_lang::message.resource_name') }}</th>
					<th>{{ trans('adminlte_lang::message.description') }}</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($resources as $resource)
						<tr>
							<th class="text-center">{{ $resource->resource_id }}</th>
							<td>{{ $resource->title }}</td>
							<td>{{ $resource->description }}</td>
							<td class="text-right">
								@if ($user->hasAccessTo('resource', 'edit', 0))
									<a href="{{ route('resource.edit', $resource->resource_id) }}" id="resource_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('resource', 'delete', 0))
									{!! Form::open(['route' => ['resource.destroy', $resource->resource_id], 'id' => 'form'.$resource->resource_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$resource->resource_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $resources->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>