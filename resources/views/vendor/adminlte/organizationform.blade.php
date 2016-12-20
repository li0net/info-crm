@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.organization:form_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('main.organization:edit_form_header')
                    </div>

                    <div class="panel-body">

                        <form method="post" action="/organization/save" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="o_name">@lang('main.organization:name_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('name');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($organization)) {
                                        $value = $organization->name;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="name" id="o_name" value="{{$value}}">
                                    @foreach ($errors->get('name') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <!-- business area here -->

                                <div class="col-md-6">
                                    <label for="o_category">@lang('main.organization:category_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('name');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($organization)) {
                                        $value = $organization->category;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="category" id="o_category" value="{{$value}}">
                                    @foreach ($errors->get('category') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="o_timezone">@lang('main.organization:timezone_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="timezone" id="o_timezone">
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

                                <div class="col-md-6">
                                    <label for="o_country">@lang('main.organization:country_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('country');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($organization)) {
                                        $value = $organization->country;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="country" id="o_country" value="{{$value}}">
                                    @foreach ($errors->get('country') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="o_city">@lang('main.organization:city_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('city');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($organization)) {
                                        $value = $organization->city;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="city" id="o_city" value="{{$value}}">
                                    @foreach ($errors->get('city') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="o_logo_image">@lang('main.organization:logo_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="logo_image" id="o_logo_image" accept=".jpg,.jpeg,.png,.bmp,.gif">
                                    @foreach ($errors->get('logo_image') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-12">
                                    <label for="o_city" class="">@lang('main.organization:info_label')</label>
                                </div>
                                <div class="col-md-12">
                                    <?php
                                    $old = old('info');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($organization)) {
                                        $value = $organization->info;
                                    } else {
                                        $value = '';
                                    }?>
                                    <textarea name="info" id="o_info">{{$value}}</textarea>
                                    @foreach ($errors->get('info') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-12">
                                    <hr/>
                                    <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                                </div>


                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
