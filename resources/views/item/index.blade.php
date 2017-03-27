@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.items') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.costs') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.costs') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">
			<a href="{{ route('item.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.item_create_new') }}</a>
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
					<th>{{ trans('adminlte_lang::message.item_name') }}</th>
					<th>{{ trans('adminlte_lang::message.item_type') }}</th>
					<th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
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
							
							<td class="text-center">
								@if ($user->hasAccessTo('item', 'edit', 0))
									<a href="{{ route('item.edit', $item->item_id) }}" id="item_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('item', 'delete', 0))
									{!! Form::open(['route' => ['item.destroy', $item->item_id], 'id' => 'form'.$item->item_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$item->item_id}}')" class="table-action-link"><i class='fa fa-trash-o'></i></a>
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
</div>
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>