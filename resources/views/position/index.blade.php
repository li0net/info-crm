@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.positions') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.positions') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.positions') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12 text-right">
			<a href="{{ route('position.create') }}" class="btn btn-primary ">{{ trans('adminlte_lang::message.new_position') }}</a>
		</div>
		<div class="col-sm-12">
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-hover table-condensed">
				<thead>
					<th>#</th>
					<th>{{ trans('adminlte_lang::message.position_name') }}</th>
					<th>{{ trans('adminlte_lang::message.description') }}</th>
					<th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
				</thead>
				<tbody>
					@foreach($positions as $position)
						<tr>
							<th>{{ $position->position_id }}</th>
							<td>{{ $position->title }}</td>
							<td>{{ $position->description }}</td>
							<td class="text-center">
								@if ($user->hasAccessTo('position', 'edit', 0))
									<a href="{{ route('position.edit', $position->position_id) }}#menu1" id="position_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('position', 'delete', 0))
									{!! Form::open(['route' => ['position.destroy', $position->position_id], "id" => 'form'.$position->position_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', "method" => 'DELETE']) !!}
											<a href="javascript: submitform('#form{{$position->position_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
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
</div>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>