@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service_category:list_page_header')
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset($service))
                            @lang('main.service:edit_form_header')
                        @else
                            @lang('main.service:create_form_header')
                        @endif
                    </div>

                    <div class="panel-body">

                        <form method="post" action="/services/save">
                            {{csrf_field()}}
                            @if (isset($service))
                                <input type="hidden" name="service_id" id="sc_service_id" value="{{$service->service_id}}">
                            @endif
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="s_service_category_id">@lang('main.service:service_category_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="service_category_id" id="s_service_category_id">
                                        @foreach($serviceCategoriesOptions AS $serviceCategory)
                                            <option
                                                    @if (old('service_category_id') AND old('service_category_id') == $serviceCategory['value'])
                                                        selected="selected"
                                                    @elseif (!old('service_category_id') AND isset($service) AND $service->service_category_id == $serviceCategory['value'])
                                                        selected="selected"
                                                    @elseif (isset($serviceCategory['selected']) AND $serviceCategory['selected'] == true)
                                                        selected="selected"
                                                    @endif
                                            value="{{$serviceCategory['value']}}">{{$serviceCategory['label']}}</option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('duration') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="s_name">@lang('main.service:name_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('name');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($service)) {
                                        $value = $service->name;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="name" id="s_name" value="{{$value}}">
                                    @foreach ($errors->get('name') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="s_price_min">@lang('main.service:price_min_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('price_min');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($service)) {
                                        $value = $service->price_min;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="price_min" id="s_price_min" value="{{$value}}">
                                    @foreach ($errors->get('price_min') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="s_price_max">@lang('main.service:price_max_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('price_max');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($service)) {
                                        $value = $service->price_max;
                                    } else {
                                        $value = '';
                                    }?>
                                    <input type="text" name="price_max" id="s_price_max" value="{{$value}}">
                                    @foreach ($errors->get('price_max') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="s_duration">@lang('main.service:duration_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="duration" id="s_duration">
                                        @foreach($durationOptions AS $duration)
                                            <option
                                                    @if (old('duration') AND old('duration') == $duration['value'])
                                                        selected="selected"
                                                    @elseif (!old('duration') AND isset($service) AND $service->duration == $duration['value'])
                                                        selected="selected"
                                                    @elseif (isset($duration['selected']) AND $duration['selected'] == true)
                                                        selected="selected"
                                                    @endif
                                            value="{{$duration['value']}}">{{$duration['label']}}</option>
                                        @endforeach
                                    </select>
                                    @foreach ($errors->get('duration') as $message)
                                        <?='<br/>'?>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    <label for="s_description">@lang('main.service:description_label')</label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                    $old = old('description');
                                    if (!is_null($old)) {
                                        $value = $old;
                                    } elseif (isset($service)) {
                                        $value = $service->description;
                                    } else {
                                        $value = '';
                                    }?>
                                    <textarea name="description" id="s_description">{{$value}}</textarea>
                                    @foreach ($errors->get('description') as $message)
                                        <br/>{{$message}}
                                    @endforeach
                                </div>

                                <div class="col-md-12">
                                    <hr/>
                                    <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                                </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
