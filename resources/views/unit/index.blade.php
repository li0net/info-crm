@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.units') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.units') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.units') }}</li>
    </ol>
</section>
<div class="container-fluid">
	<div class="row">
		@if (Session::has('success'))
			<div class="alert alert-success" role="alert">
				<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
			</div>
		@endif
	</div>
	<div class="row">
		<div class="col-sm-12">
			<a href="{{ route('unit.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.new_measurement_unit') }}</a>
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
					<th>{{ trans('adminlte_lang::message.unit_title') }}</th>
					<th>{{ trans('adminlte_lang::message.comment') }}</th>
					<th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
				</thead>
				<tbody>
					@foreach($units as $unit)
						<tr>
							<th class="text-center">{{ $unit->unit_id }}</th>
							<td>
								{{ $unit->title }}
								<br>
								<small>{{ $unit->short_title }}</small>
							</td>
							<td>
								{{ $unit->description }}
							</td>
							<td class="text-center">
								@if ($user->hasAccessTo('unit', 'edit', 0))
									<a href="{{ route('unit.edit', $unit->unit_id) }}" id="unit_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('unit', 'delete', 0))
									{!! Form::open(['route' => ['unit.destroy', $unit->unit_id], 'id' => 'form'.$unit->unit_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$unit->unit_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $units->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>