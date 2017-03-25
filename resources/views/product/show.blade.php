@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $product->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_product') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/product')}}">{{ trans('adminlte_lang::message.products') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_product') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
		<div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>{{ trans('adminlte_lang::message.product_title') }}</dt>
                <dd>{{ $product->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.article') }}</dt>
                <dd>{{ $product->article }}</dd>

                <dt>{{ trans('adminlte_lang::message.bar_code') }}</dt>
                <dd>{{ $product->barcode }}</dd>

                <dt>{{ trans('adminlte_lang::message.category') }}</dt>
                <dd>{{ $category->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.storage') }}</dt>
                <dd>{{ $storage->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.sell_price') }}</dt>
                <dd>{{ $product->price }}</dd>

                <dt>{{ trans('adminlte_lang::message.unit') }}</dt>
                <dd>
                    @if($product->unit_for_sale = 'pcs')
                    {{ trans('adminlte_lang::message.pieces') }}&nbsp;
                    @else
                    {{ trans('adminlte_lang::message.milliliters') }}
                    @endif
                    =&nbsp;{{ $product->is_equal }}&nbsp;
                    @if($product->unit_for_disposal = 'pcs')
                    {{ trans('adminlte_lang::message.pieces') }}&nbsp;
                    @else
                    {{ trans('adminlte_lang::message.milliliters') }}
                    @endif
                </dd>

                <dt>{{ trans('adminlte_lang::message.critical_balance') }}</dt>
                <dd>{{ $product->critical_balance }}</dd>

                <dt>{{ trans('adminlte_lang::message.net_weight') }}</dt>
                <dd>{{ $product->net_weight }}</dd>
                <dt>{{ trans('adminlte_lang::message.gross_weight') }}</dt>
                <dd>{{ $product->gross_weight }}</dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $product->description }}</dd>
            </dl>

            <div class="text-left m-t">
                @if ($user->hasAccessTo('product', 'delete', 0))
                    {!! Form::open(['route' => ['product.destroy', $product->product_id], "class" => 'pull-left m-r', "method" => 'DELETE']) !!}
                    {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger']) }}
                    {!! Form::close() !!}
                @endif

                @if ($user->hasAccessTo('product', 'edit', 0))
                    {!! Html::linkRoute('product.edit', trans('adminlte_lang::message.edit'), [$product->product_id], ['class'=>'btn btn-primary pull-left']) !!}
                @endif

            </div>
		</div>
	</div>
@endsection