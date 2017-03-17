@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client_category:form_page_header')
@endsection

@section('main-content')
<section class="content-header">
    <h1>
        @if (isset($clientCategory))
        @lang('main.client_category:edit_form_header')
        @else
        @lang('main.client_category:create_form_header')
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li><a href="{{ url('/clients') }}">{{ trans('adminlte_lang::message.client_list') }}</a></li>
        <li><a href="{{ url('/clientCategories') }}">{{ trans('adminlte_lang::message.loyality') }}</a></li>
        <li class="active">
            @if (isset($clientCategory))
            @lang('main.client_category:edit_form_header')
            @else
            @lang('main.client_category:create_form_header')
            @endif
        </li>
    </ol>
</section>
<div class="container">
    <div class="row">
        <form id="labels-form" class="form-horizontal m-t" action="/clientCategories/save" method="POST">
            <div class="form-group">
                <label for="cc_title" class="col-sm-3 control-label text-right">@lang('main.client_category:name_placeholder')</label>
                <div class="col-sm-9">
                    {{ csrf_field() }}

                    @if (isset($clientCategory))
                    <input type="hidden" name="client_category_id" id="cc_client_category_id" name="client_category_id" value="{{$clientCategory->cc_id}}">
                    @endif

                    <?php
                    $old = old('title');
                    if (!is_null($old)) {
                        $value = $old;
                    } elseif (isset($clientCategory)) {
                        $value = $clientCategory->title;
                    } else {
                        $value = '';
                    }?>

                    <input type="text" id="cc_title" placeholder="@lang('main.client_category:name_placeholder')" class="form-control" name="title" value="{{$value}}">
                    @foreach ($errors->get('title') as $message)
                    <br/>{{$message}}
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="cc_color" class="col-sm-3 control-label text-right">@lang('main.client_category:color_placeholder')</label>
                <div class="col-sm-9">
                    <?php
                    $old = old('color');
                    if (!is_null($old)) {
                        $value = $old;
                    } elseif (isset($clientCategory)) {
                        $value = $clientCategory->color;
                    } else {
                        $value = '';
                    }?>

                    <div id="cc_cp_container" class="input-group colorpicker-component input-group-addon-right">
                        <input type="text" id="cc_color" placeholder="@lang('main.client_category:color_placeholder')" name="color" class="form-control" value="{{$value}}">
                        <span class="input-group-addon"><i class="fa fa-paint-brush" aria-hidden="true"></i></span>
                    </div>

                    @foreach ($errors->get('color') as $message)
                    <br/>{{$message}}
                    @endforeach

                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn pull-right btn-primary">@lang('main.client_category:btn_save')</button>
            </div>
        </form>
    </div>
</div>
@endsection