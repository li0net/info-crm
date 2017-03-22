@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ $storage->title }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
<section class="content-header">
    <h1>{{ trans('adminlte_lang::message.information_about_storage') }}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.stock') }}</li>
        <li ><a href="{{ url('/storage')}}">{{ trans('adminlte_lang::message.storages') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.information_about_storage') }}</li>
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
		<div class="col-sm-12">
			{{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
			{!! Form::model($storage, ['route' => ['storage.update', $storage->storage_id], 'method' => 'PUT', "class"=>'form-horizontal']) !!}
                <div class="form-group">
                    {{ Form::label('title', trans('adminlte_lang::message.storage_title'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}

                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('type', trans('adminlte_lang::message.storage_type'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        <label style="width: 100%">
                            {{ Form::radio('type', 1, $storage->type ? true : false, ['style' => 'margin-right: 10px']) }}
                            {{ trans('adminlte_lang::message.writeoff_supplies') }}
                        </label>
                        <label>
                            {{ Form::radio('type', 2, $storage->type ? true : false, ['style' => 'margin-right: 10px']) }}
                            {{ trans('adminlte_lang::message.sale_goods') }}
                        </label>
                    </div>

                </div>

                <div class="form-group">
                    {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'cols' => 'auto', 'rows' => 'auto']) }}
                    </div>
                </div>
                <div class="m-t text-right">
                    {!! Html::linkRoute('storage.show', trans('adminlte_lang::message.cancel'), [$storage->storage_id], ['class'=>'btn btn-danger']) !!}
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