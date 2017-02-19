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
			<h4>Все склады</h4>
		</div>	

		<div class="col-sm-4">
			<a href="{{ route('storage.create') }}" class="btn btn-primary pull-right">Новый склад</a>
			<a href="#" class="btn btn-success m-r pull-right">Переместить товары</a>
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
					<th>Количество единиц</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($storages as $storage)
						<tr>
							<th class="text-center">{{ $storage->storage_id }}</th>
							<td>
								{{ $storage->title }}
								<br>
								<small>{{ $storage->description }}</small>
							</td>
							<td>
								{{ count($storage->products) }} товар(ов)
							</td>
							<td> 
							<td class="text-right">
								@if ($user->hasAccessTo('storage', 'edit', 0))
									<a href="{{ route('storage.edit', $storage->storage_id) }}" id="storage_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('storage', 'delete', 0))
									{!! Form::open(['route' => ['storage.destroy', $storage->storage_id], 'id' => 'form'.$storage->storage_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$storage->storage_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $storages->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>