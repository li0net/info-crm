@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.product_ctgs_create_new') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.product_ctgs_create_new') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/productCategories')}}">{{ trans('adminlte_lang::message.product_categories') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.product_ctgs_create_new') }}</li>
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
	</div>
    <div class="row">
        {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '', 'class' => 'form-horizontal']) !!} --}}
        {!! Form::open(['route' => 'productCategories.store']) !!}
            <div class="form-group">
                {{ Form::label('title', trans('adminlte_lang::message.category_title'), ['class' => 'col-sm-4 control-label text-right']) }}
                <div class="col-sm-8">
                    {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-4 control-label text-right']) }}
                <div class="col-sm-8">
                    {{ Form::text('description', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('parent_category_id', trans('adminlte_lang::message.parent_category'), ['class' => 'col-sm-4 control-label text-right', 'disabled' => '']) }}
                <div class="col-sm-8">
                    {{ Form::text('parent_category_id', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110', 'disabled'=> '']) }}
                </div>
            </div>
            </div>
            <div class="text-right m-t">
                {{	Form::submit(trans('adminlte_lang::message.product_ctgs_create_new'), ['class' => 'btn btn-primary']) }}
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}