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
			<h4>Все статьи доходов-расходов</h4>
		</div>	

		<div class="col-sm-2">
			<a href="{{ route('item.create') }}" class="btn btn-primary btn-block">Новая статья</a>
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
					<th>Наименование статьи</th>
					<th>Тип статьи</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($items as $item)
						<tr>
							<th class="text-center">{{ $item->item_id }}</th>
							<td>
								{{ $item->title }}
								<br>
								<small>{{ $item->description }}</small>
							</td>
							<td>
								@php
									switch ($item->type) {
										case 'income':
											echo 'Доходы'; break;
										case 'exp_oncost':
											echo 'Расходы', ' ', 'на', ' ', 'себестоимость'; break;
										case 'sales_exp':
											echo 'Коммерческие', ' ', 'расходы'; break;
										case 'staff_exp':
											echo 'Расходы', ' ', 'на', ' ', 'персонал'; break;
										case 'admin_exp':
											echo 'Административно-хозяйственные', ' ', 'расходы'; break;
										case 'taxes':
											echo 'Налоги', ' ', 'и', ' ', 'сборы'; break;
										default:
											echo 'Прочие'; break;
									}
								@endphp
							</td>
							
							<td class="text-right">
								@if ($user->hasAccessTo('item', 'edit', 0))
									<a href="{{ route('item.edit', $item->item_id) }}" id="item_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('item', 'delete', 0))
									{!! Form::open(['route' => ['item.destroy', $item->item_id], 'id' => 'form'.$item->item_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$item->item_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
					{!! $items->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>