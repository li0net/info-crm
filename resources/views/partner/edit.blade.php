@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.partner_information') }}
@endsection

{{-- @section('Stylesheets')
	{!! Html::style('css/parsley.css') !!}
@endsection --}}

@section('main-content')
    <section class="content-header">
        <h1>{{ trans('adminlte_lang::message.partner_information') }}</h1>
        <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Advanced Elements</li>
        </ol>-->
    </section>
	<div class="row m-t">
		<div class="col-sm-12">
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
        <div class="col-sm-12">
            {{-- {!! Form::open(['route' => 'employee.store', 'data-parsley-validate' => '']) !!} --}}
            {!! Form::model($partner, ['route' => ['partner.update', $partner->partner_id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {{ Form::label('title', trans('adminlte_lang::message.partner_name'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::text('title', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('type', trans('adminlte_lang::message.partner_type'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::select('type', ['company' => trans('adminlte_lang::message.company'),
                        'person' => trans('adminlte_lang::message.person'),
                        'selfemployed' => trans('adminlte_lang::message.self_employed')], 'company', ['class' => 'js-select-basic-single', 'required' => '']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('inn', trans('adminlte_lang::message.INN'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::text('inn', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '15']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('kpp', trans('adminlte_lang::message.KPP'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::text('kpp', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '10']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('contacts', trans('adminlte_lang::message.partner_contacts'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::text('contacts', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '110']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('phone', trans('adminlte_lang::message.phone'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::text('phone', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '25']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('email', trans('adminlte_lang::message.email'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::email('email', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '70']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('address', trans('adminlte_lang::message.address'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::text('address', null, ['class' => 'form-control', 'required' => '', 'maxlength' => '210']) }}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('description', trans('adminlte_lang::message.description'), ['class' => 'col-sm-3 control-label text-right']) }}
                    <div class="col-sm-9">
                        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-sm-12 m-t" >
                    {!! Html::linkRoute('partner.show', trans('adminlte_lang::message.cancel'), [$partner->partner_id],
                    ['class'=>'btn btn-info']) !!}
                    {{ Form::submit(trans('adminlte_lang::message.save'), ['class'=>'btn btn-primary pull-right']) }}
                </div>
            {!! Form::close() !!}
        </div>
	</div>

@endsection

{{-- @section('scripts')
	{!! Html::script('js/parsley.min.js') !!}
@endsection --}}