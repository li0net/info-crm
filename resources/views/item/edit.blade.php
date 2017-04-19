@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.item_information') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

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

    @include('partials.alerts')

    <div class="row">
        <div class="col-sm-12">
				{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
				{!! Form::model($item, ['route' => ['item.update', $item->item_id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
					<div class="form-group">
						{{ Form::label('title',  trans('adminlte_lang::message.item_name'), ['class' => 'col-sm-4 control-label text-right']) }}
                        <div class="col-sm-8">
                            {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                        </div>
					</div>

					<div class="form-group">
						{{ Form::label('type', trans('adminlte_lang::message.item_type'), ['class' => 'col-sm-4 control-label text-right']) }}
                        <div class="col-sm-8">
                            {{ Form::select('type', [1 => trans('adminlte_lang::message.income'),
												 2 => trans('adminlte_lang::message.expenses_on_cost'), 
												 3 => trans('adminlte_lang::message.commercial_exps'), 
												 4 => trans('adminlte_lang::message.staff_exps'), 
												 5 => trans('adminlte_lang::message.admin_exps'), 
												 6 => trans('adminlte_lang::message.taxes'), 
												 7 => trans('adminlte_lang::message.other_exps')], $item->itemtype_id, ['class' => 'js-select-basic-single', 'required' => '']) }}
                        </div>
					</div>
					<div class="form-group">
						{{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-4 control-label text-right']) }}
                        <div class="col-sm-8">
                            {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                        </div>
					</div>
					<div class="m-t text-right">
                        {!! Html::linkRoute('item.show', trans('adminlte_lang::message.cancel'), [$item->item_id], ['class'=>'btn btn-info m-r']) !!}
                        {{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-primary']) }}
					</div>
				{!! Form::close() !!}	
			</div>
	</div>
</div>
@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}