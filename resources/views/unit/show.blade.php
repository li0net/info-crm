@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $unit->title }}
@endsection

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_unit') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li><a href="{{ url('/unit')}}">{{ trans('adminlte_lang::message.units') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_unit') }}</li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

	<div class="row">
		<div class="col-sm-12">
            <dl class="dl-horizontal">
                <dt>{{ trans('adminlte_lang::message.unit_title') }}</dt>
                <dd>{{ $unit->title }}</dd>

                <dt>{{ trans('adminlte_lang::message.unit_short_title') }}</dt>
                <dd>{{ $unit->short_title }}</dd>

                <dt>{{ trans('adminlte_lang::message.description') }}</dt>
                <dd>{{ $unit->description }}</dd>
            </dl>
		</div>
        <div class="col-sm-12">
            @if ($user->hasAccessTo('unit', 'delete', 0))
                {!! Form::open(['route' => ['unit.destroy', $unit->unit_id], "method" => 'DELETE', "class" => 'pull-left m-r']) !!}
                {{ Form::submit(trans('adminlte_lang::message.delete'), ['class'=>'btn btn-danger']) }}
                {!! Form::close() !!}
            @endif
            @if ($user->hasAccessTo('unit', 'edit', 0))
            {!! Html::linkRoute('unit.edit', trans('adminlte_lang::message.edit'), [$unit->unit_id], ['class'=>'btn btn-primary pull-left']) !!}
            @endif
        </div>
	</div>
@endsection