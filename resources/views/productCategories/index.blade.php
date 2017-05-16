@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.information_about_ctgs') }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.product_categories') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li class="active">{{ trans('adminlte_lang::message.product_categories') }}</li>
    </ol>
</section>
<div class="container-fluid">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12 text-right">
			<a href="{{ route('productCategories.create') }}" class="btn btn-primary pull-right">{{ trans('adminlte_lang::message.new_category') }}</a>
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
					<th>{{ trans('adminlte_lang::message.category_title') }}</th>
					<th>{{ trans('adminlte_lang::message.description') }}</th>
					<th>{{ trans('adminlte_lang::message.parent_category') }}</th>
					<th class="text-center">{{ trans('adminlte_lang::message.actions') }}</th>
				</thead>
				<tbody>
					@foreach($productCategories as $productCategory)
						<tr>
							<th class="text-center">{{ $productCategory->product_category_id }}</th>
							<td>
								{{ $productCategory->title }}
							</td>
							<td>
								{{ $productCategory->description }} 
							</td>
							<td>
								{{ $productCategory->parent_category_id }}
							</td>
							<td class="text-center">
								@if ($user->hasAccessTo('productCategories', 'edit', 0))
									<a href="{{ route('productCategories.edit', $productCategory->product_category_id) }}" id="product_category_edit" class="table-action-link"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('productCategories', 'delete', 0))
									{!! Form::open(['route' => ['productCategories.destroy', $productCategory->product_category_id], 'id' => 'form'.$productCategory->product_category_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$productCategory->product_category_id}}')" class="table-action-link danger-action"><i class='fa fa-trash-o'></i></a>
									{!! Form::close() !!}
								@endif
							</td>	
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="text-center">
				{!! $productCategories->render(); !!} 
			</div>
		</div>
	</div>		
@endsection

<script>
	function submitform(form_id){
		$(form_id).submit();
	}
</script>