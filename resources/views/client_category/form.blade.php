@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client_category:form_page_header')
@endsection

@section('main-content')
    <div class="panel-heading">
        <div class="col-xs-10">
            @if (isset($clientCategory))
                <h2>@lang('main.client_category:edit_form_header')</h2>
            @else
                <h2>@lang('main.client_category:create_form_header')</h2>
            @endif

        </div>
        <div class="col-xs-2">
        </div>
    </div>


    <div class="ibox float-e-margins">

        <div class="ibox-content">
            <form id="labels-form" class="form-horizontal" action="/clientCategories/save" method="POST">
                <div class="form-group">
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
                    <div class="col-sm-4">
                        <input type="text" id="cc_title" placeholder="@lang('main.client_category:name_placeholder')" class="form-control" name="title" value="{{$value}}">
                        @foreach ($errors->get('title') as $message)
                            <br/>{{$message}}
                        @endforeach
                    </div>

                    <?php
                    $old = old('color');
                    if (!is_null($old)) {
                        $value = $old;
                    } elseif (isset($clientCategory)) {
                        $value = $clientCategory->color;
                    } else {
                        $value = '';
                    }?>
                    <div class="col-sm-2">
                        <div id="cc_cp_container" class="input-group colorpicker-component">
                            <input type="text" id="cc_color" placeholder="@lang('main.client_category:color_placeholder')" name="color" class="form-control" value="{{$value}}">
                            <span class="input-group-addon"><i></i></span>
                        </div>
                        @foreach ($errors->get('color') as $message)
                            <br/>{{$message}}
                        @endforeach
                    </div>

                    <div class="col-sm-4">
                        <button type="submit" class="btn pull-right btn-primary">@lang('main.client_category:btn_save')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection