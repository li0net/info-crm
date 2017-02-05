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
		<div class="col-sm-8">
			<h4>Все единицы измерения</h4>
		</div>	

		<div class="col-sm-4">
			<a href="{{ route('unit.create') }}" class="btn btn-primary pull-right">Новая единица измерения</a>
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
					<th>Наименование</th>
					<th>Комментарий</th>
					<th></th>
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
							<td> 
							<td class="text-right">
								@if ($user->hasAccessTo('unit', 'edit', 0))
									<a href="{{ route('unit.edit', $unit->unit_id) }}" id="unit_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('unit', 'delete', 0))
									{!! Form::open(['route' => ['unit.destroy', $unit->unit_id], 'id' => 'form'.$unit->unit_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$unit->unit_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
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