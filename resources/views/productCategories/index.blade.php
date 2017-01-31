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
			<h4>Все категории товаров</h4>
		</div>	

		<div class="col-sm-2">
			<a href="{{ route('productCategories.create') }}" class="btn btn-primary">Новая категория товаров</a>
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
					<th>Наименование категории товара</th>
					<th>Описание</th>
					<th>Родительская категория</th>
					<th></th>
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
							<td class="text-right">
								@if ($user->hasAccessTo('productCategories', 'edit', 0))
									<a href="{{ route('productCategories.edit', $productCategory->product_category_id) }}" id="product_category_edit" class="btn btn-default btn-sm"><i class='fa fa-pencil'></i></a>
								@endif
								@if ($user->hasAccessTo('productCategories', 'delete', 0))
									{!! Form::open(['route' => ['productCategories.destroy', $productCategory->product_category_id], 'id' => 'form'.$productCategory->product_category_id, 'style' => 'max-width: 32px; margin:0; display: inline-block; float: none;', 'method' => 'DELETE']) !!}
										<a href="javascript: submitform('#form{{$productCategory->product_category_id}}')" class="btn btn-default btn-sm"><i class='fa fa-trash-o'></i></a>
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