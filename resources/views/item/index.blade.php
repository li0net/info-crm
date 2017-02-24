@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.items') }}
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
		<div class="col-sm-9">
			<h4>{{ trans('adminlte_lang::message.items') }}</h4>
		</div>	

		<div class="col-sm-3">
			<a href="{{ route('item.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.item_create_new') }}</a>
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
					<th>{{ trans('adminlte_lang::message.item_name') }}</th>
					<th>{{ trans('adminlte_lang::message.item_type') }}</th>
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
									switch ($item->itemtype_id) {
										case 1:
											echo trans('adminlte_lang::message.income'); break;
										case 2:
											echo trans('adminlte_lang::message.expenses_on_cost'); break;
										case 3:
											echo trans('adminlte_lang::message.commercial_exps'); break;
										case 4:
											echo trans('adminlte_lang::message.staff_exps'); break;
										case 5:
											echo trans('adminlte_lang::message.admin_exps'); break;
										case 6:
											echo trans('adminlte_lang::message.taxes'); break;
										default:
											echo trans('adminlte_lang::message.other_exps'); break;
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