@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.service_category:list_page_header')
@endsection

@section('main-content')
<section class="content-header">
    <h1> @lang('main.service_category:list_page_header')</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li class="active">{{ trans('adminlte_lang::message.settings') }}</li>
        <li><a href="{{ url('/serviceCategories')}}">{{ trans('adminlte_lang::message.service_categories') }}</a></li>
        <li class="active">
            @if (isset($serviceCategory))
                @lang('main.service_category:edit_form_header')
            @else
                @lang('main.service_category:create_form_header')
            @endif
        </li>
    </ol>
</section>
    <div class="container">
        <div class="row">
            <form method="post" action="/serviceCategories/save" class="form-horizontal">

                {{csrf_field()}}
                @if (isset($serviceCategory))
                <input type="hidden" name="service_category_id" id="sc_service_category_id" value="{{$serviceCategory->service_category_id}}">
                @endif

                <div class="form-group">
                    <label for="sc_name" class="col-sm-4 control-label text-right">@lang('main.service_category:name_label')</label>
                    <div class="col-sm-8">
                        <?php
                        $old = old('name');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($serviceCategory)) {
                            $value = $serviceCategory->name;
                        } else {
                            $value = '';
                        }?>
                        <input type="text" name="name" class="form-control" id="sc_name" value="{{$value}}">

                        @foreach ($errors->get('name') as $message)
                            <br/>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label text-right" for="sc_online_reservation_name">@lang('main.service_category:online_reservation_name_label')</label>
                    <div class="col-sm-8">
                        <?php
                        $old = old('online_reservation_name');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($serviceCategory)) {
                            $value = $serviceCategory->online_reservation_name;
                        } else {
                            $value = '';
                        }?>
                        <input type="text" class="form-control"  name="online_reservation_name" id="sc_online_reservation_name" value="{{$value}}">

                        @foreach ($errors->get('online_reservation_name') as $message)
                         <br/>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="sc_online_reservation_name"  class="col-sm-4 control-label text-right">@lang('main.service_category:online_reservation_name_label')</label>
                    <div class="col-sm-8">
                        <select name="gender" id="sc_gender" class="js-select-basic-single">
                            @foreach($genderOptions AS $gender)
                            <option
                                    @if (old('gender') AND old('gender') == $gender['value'])
                            selected="selected"
                            @elseif (!old('gender') AND isset($serviceCategory) AND $serviceCategory->gender == $gender['value'])
                            selected="selected"
                            @endif
                            value="{{$gender['value']}}">{{$gender['label']}}
                            </option>
                            @endforeach
                        </select>
                        @foreach ($errors->get('gender') as $message)
                        <br/>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12 m-t text-right">
                    <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
