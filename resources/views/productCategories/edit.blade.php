@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.employee_create') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_ctgs') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/productCategories')}}">{{ trans('adminlte_lang::message.product_categories') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_ctgs') }}</li>
    </ol>
</section>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			@if (count($errors) > 0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
        </div>
        <div class="col-md-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::model($productCategory, ['route' => ['productCategories.update', $productCategory->product_category_id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {{ Form::label('title', trans('adminlte_lang::message.category_title'), ['class' => 'col-sm-4 control-label text-right']) }}
                    <div class="col-md-8">
                        {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                    </div>

                </div>

                <div class="form-group">
                    {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-4 control-label text-right']) }}
                    <div class="col-md-8">
                        {{ Form::text('description', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                    </div>

                </div>

                <div class="form-group">
                    {{ Form::label('parent_category_id', trans('adminlte_lang::message.parent_category'), ['class' => 'col-sm-4 control-label text-right', 'disabled' => '']) }}
                    <div class="col-md-8">
                        {{ Form::text('parent_category_id', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110', 'disabled'=> '']) }}
                    </div>
                </div>
                <div class="m-t text-right">
                    {!! Html::linkRoute('productCategories.show', trans('adminlte_lang::message.cancel'), [$productCategory->product_category_id], ['class'=>'btn btn-info']) !!}
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