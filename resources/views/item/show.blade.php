@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $item->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.item_information') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.finance') }}</li>
        <li><a href="{{ url('/item')}}">{{ trans('adminlte_lang::message.costs') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.item_information') }}</li>
    </ol>
</section>
<div class="container">
	<div class="row">
		@if (Session::has('success'))
		
		<div class="alert alert-success" role="alert">
			<strong>{{ trans('adminlte_lang::message.success') }}</strong> {{ Session::get('success') }}
		</div>

		@endif
	</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="well">
				{{ Form::label('title', trans('adminlte_lang::message.item_name')) }}
				<p class="lead">{{ $item->title }}</p>

				{{ Form::label('type', trans('adminlte_lang::message.item_type')) }}
				<p class="lead">
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
				</p>
				
				{{ Form::label('description', trans('adminlte_lang::message.description')) }}
				<p class="lead">{{ $item->description }}</p>
				
				<hr>

				<div class="row">
					@if ($user->hasAccessTo('item', 'edit', 0))
						<div class="col-sm-6">
							{!! Html::linkRoute('item.edit', trans('adminlte_lang::message.edit'), [$item->item_id], ['class'=>'btn btn-primary btn-block']) !!}
						</div>
					@endif
					@if ($user->hasAccessTo('item', 'delete', 0))
						<div class="col-sm-6">
							{!! Form::open(['route' => ['item.destroy', $item->item_id], "method" => 'DELETE']) !!}

							{{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger btn-block']) }}

							{!! Form::close() !!}
						</div>
					@endif
				</div>

				<div class="row">
					<div class="col-sm-12">
							{{ Html::linkRoute('item.index', trans('adminlte_lang::message.items').' »', [], ['class' => 'btn btn-default btn-block btn-h1-spacing', 
																											  'style' => 'margin-top:15px']) }}
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection