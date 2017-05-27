@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.resources') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.resources') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.resources') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12 text-right">
			<a href="{{ route('resource.create') }}" class="btn btn-primary">{{ trans('adminlte_lang::message.new_resource') }}</a>
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
					<th class="text-left">{{ trans('adminlte_lang::message.actions') }}</th>
				</thead>
				<tbody>
					@foreach($resources as $resource)
						<tr>
							<th class="text-center">{{ $resource->resource_id }}</th>
							<td>{{ $resource->title }}</td>
							<td>{{ $resource->description }}</td>
							<td  class="text-left">
								@if ($user->hasAccessTo('resource', 'edit', 0))
									<a href="{{ route('resource.edit', $resource->resource_id) }}" id="resource_edit" class="table-action-link pull-left"><i class='fa fa-pencil'></i></a>
								@endif

								@if ($user->hasAccessTo('resource', 'delete', 0))
									{!! Form::open(['route' => ['resource.destroy', $resource->resource_id], 'id' => 'form'.$resource->resource_id, 'class' => 'pull-left', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$resource->resource_id}}')" class="table-action-link danger-action"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $resources->render() !!}
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>