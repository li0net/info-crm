@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $productCategory->title }}
@endsection

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

    @include('partials.alerts')

    <div class="row">
		<div class="col-md-12">
            <dl class="dl-horizontal">
                <dt>{{ trans('adminlte_lang::message.category_title') }}</dt>
                <dd>{{ $productCategory->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $productCategory->description }}</dd>

                <dt>{{ trans('adminlte_lang::message.parent_category') }}</dt>
                <dd>{{ $productCategory->article }}</dd>
            </dl>
        </div>
        <div class="col-md-12">
            @if ($user->hasAccessTo('productCategories', 'delete', 0))
                {!! Form::open(['route' => ['productCategories.destroy', $productCategory->product_category_id], "method" => 'DELETE', "class" => 'pull-left m-r']) !!}
                    {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger']) }}
                {!! Form::close() !!}
            @endif
            @if ($user->hasAccessTo('productCategories', 'edit', 0))
            {!! Html::linkRoute('productCategories.edit', trans('adminlte_lang::message.edit'), [$productCategory->product_category_id],
            ['class'=>'btn btn-primary pull-left']) !!}
            @endif
        </div>
	</div>
</div>
@endsection