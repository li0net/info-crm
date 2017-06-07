@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.organization:form_page_header')
@endsection


@section('main-content')
    <section class="content-header">
        <h1>@lang('main.organization:edit_form_header')</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
            <li class="active">{{ trans('adminlte_lang::message.basic_settings') }}</li>
        </ol>
    </section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <form method="post" action="/organization/save" enctype="multipart/form-data" class="form-horizontal">
                {{csrf_field()}}
                <div class="col-sm-9">
                    @if (isset($organization))
                        <div class="form-group">
                            <label class="col-sm-3 control-label">@lang('main.organization:id_label')</label>
                            <label class="col-sm-9 control-label text-left fat">{{ $organization->organization_id }}</label>
                            <input type="hidden" name="branch_id" id="organization_branch_id" value="{{$organization->organization_id}}">
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="o_name">@lang('main.organization:name_label')</label>
                        <div class="col-sm-9">
                            <?php
                            $old = old('name');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($organization)) {
                                $value = $organization->name;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="name" id="o_name" value="{{$value}}" class="form-control">
                            @foreach ($errors->get('name') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <!-- business area here -->
                    <div class="form-group">
                        <label for="o_category"class="col-sm-3 control-label">@lang('main.organization:category_label')</label>
                        <div class="col-sm-9">
                            <?php
                            $old = old('name');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($organization)) {
                                $value = $organization->category;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="category" id="o_category" value="{{$value}}" class="form-control">
                            @foreach ($errors->get('category') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="o_timezone" class="col-sm-3 control-label">@lang('main.organization:timezone_label')</label>
                        <div class="col-sm-9">
                            <select name="timezone" id="o_timezone" class="js-select-basic-single">
                                @foreach($timezonesOptions AS $timezone)
                                <option
                                        @if (old('timezone') AND old('timezone') == $timezone['value'])
                                selected="selected"
                                @elseif (!old('timezone') AND isset($organization) AND $organization->timezone == $timezone['value'])
                                selected="selected"
                                @elseif (!old('timezone') AND !isset($organization) AND isset($timezone['selected']) AND $timezone['selected'] == true)
                                selected="selected"
                                @endif
                                value="{{$timezone['value']}}">{{$timezone['label']}}</option>
                                @endforeach
                            </select>
                            @foreach ($errors->get('timezone') as $message)
                            <br/>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="o_country" class="col-sm-3 control-label">@lang('main.organization:country_label')</label>
                        <div class="col-sm-9">
                            <?php
                            $old = old('country');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($organization)) {
                                $value = $organization->country;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="country" id="o_country" value="{{$value}}" class="form-control">
                            @foreach ($errors->get('country') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="o_city" class="col-sm-3 control-label">@lang('main.organization:city_label')</label>
                        <div class="col-sm-9">
                            <?php
                            $old = old('city');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($organization)) {
                                $value = $organization->city;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="city" id="o_city" value="{{$value}}" class="form-control">
                            @foreach ($errors->get('city') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="o_currency" class="col-sm-3 control-label">@lang('main.organization:currency_label')</label>
                        <div class="col-sm-9">
                            <?php
                            $old = old('currency');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($organization)) {
                                $value = $organization->currency;
                            } else {
                                $value = '';
                            }?>
                            {{ Form::select('currency', ['rur' => 'RUR', 'usd' => 'USD', 'eur' => 'EUR'], $value, ['id' => 'o_currency', 'class' => 'js-select-basic-single']) }}
                            @foreach ($errors->get('currency') as $message)
                                <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="o_info" class="col-sm-3 control-label">@lang('main.organization:info_label')</label>
                        <div class="col-sm-9">
                            <?php
                            $old = old('info');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($organization)) {
                                $value = $organization->info;
                            } else {
                                $value = '';
                            }?>
                            <textarea name="info" id="o_info" class="form-control">{{$value}}</textarea>
                            @foreach ($errors->get('info') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group text-center">
                        <label for="o_logo_image" class="col-sm-3 control-label">@lang('main.organization:logo_label')</label>
                        <div class="col-sm-12 text-center ">
                            <div class="logo-block">
                                <div v-if="!image">
                                    <img src="{{$organization->getLogoUri()}}">
                                </div>
                                <div v-else>
                                    <img :src="image"/>
                                </div>
                            </div>
                            <div class="note m-b">
                                @lang('main.organization:logo_recommend')
                            </div>
                            <span class="btn btn-info btn-file">
                                @lang('main.user:logo_btn')<input type="file" @change="onFileChange" name="logo_image" id="o_logo_image" accept=".jpg,.jpeg,.png,.bmp,.gif" class="">
                            </span>

                            @foreach ($errors->get('logo_image') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="col-sm-12 text-right m-t">
                    <button type="submit" class="btn btn-primary">@lang('main.btn_submit_label')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
