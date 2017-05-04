@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:form_page_header')
@endsection


@section('main-content')
<section class="content-header">
    <h1>
        @if (isset($client))
            @lang('main.client:edit_form_header')
        @else
            @lang('main.client:create_form_header')
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li><a href="{{ url('/clients') }}">{{ trans('adminlte_lang::message.client_list') }}</a></li>
        <li class="active">
            @if (isset($client))
            @lang('main.client:edit_form_header')
            @else
            @lang('main.client:create_form_header')
            @endif
        </li>
    </ol>
</section>
<div class="container">

    @include('partials.alerts')

    <div class="row">
        <div class="col-md-12">
            <form method="post" action="/clients/save" class="form-horizontal">
                {{csrf_field()}}
                @if (isset($client))
                <input type="hidden" name="client_id" id="c_client_id" value="{{$client->client_id}}">
                @endif
                <div class="form-group">
                    <!--
                    Имя (name)
                    Сотовый (phone)
                    Email (email)
                    Категория (dropdown - category_id)
                    Пол (gender)
                    Класс важности (селект - без категории, золото, серебро, бронза) importance enum('bronze','silver','gold')
                    Скидка  discount tinyint(3)
                    --Номер карты--
                    Дата рождения  birthday
                    Комментарий (textarea - comment)
                    SMS
                        v Поздравлять с днем рождения по SMS  birthday_sms
                        v Исключить из SMS рассылок  do_not_send_sms
                    Онлайн запись
                        v Запретить записываться онлайн  online_reservation_available

                    Продано  total_bought
                    Оплачено  total_paid
                    -->
                    <label for="c_name" class="col-sm-3 control-label">@lang('main.client:name_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('name');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($client)) {
                            $value = $client->name;
                        } else {
                            $value = '';
                        }?>
                        <input type="text" class="form-control" name="name" id="c_name" value="{{$value}}" placeholder="@lang('main.client:name_label')">
                        @foreach ($errors->get('name') as $message)
                        <?='<br/>'?>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_phone" class="col-sm-3 control-label">@lang('main.client:phone_label')</label>
                    <div class="col-sm-9">
                        @if ($crmuser->hasAccessTo('client_phone', 'view', 0))
                        <?php
                        $old = old('phone');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($client)) {
                            $value = $client->phone;
                        } else {
                            $value = '';
                        }?>
                        {{ Form::text('phone', $value, ['id' => 'c_phone', 'class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.example').'7 495 232 00 20']) }}
                        @foreach ($errors->get('phone') as $message)
                        <br/>{{$message}}
                        @endforeach
                        @else
                        <span>@lang('main.user:grid_phone_hidden_message')</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_email" class="col-sm-3 control-label">@lang('main.client:email_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('email');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($client)) {
                            $value = $client->email;
                        } else {
                            $value = '';
                        }?>
                            {{ Form::text('email', $value, ['id' => 'c_email', 'class' => 'form-control', 'placeholder' => trans('adminlte_lang::message.example').'info@mail.com']) }}
                        @foreach ($errors->get('email') as $message)
                        <?='<br/>'?>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_category_id" class="col-sm-3 control-label">@lang('main.client:client_category_label')</label>
                    <div class="col-sm-9">
                        <select name="category_id[]" id="c_category_id" class="js-select-basic-multiple" multiple="multiple" >
                            @foreach($clientCategoriesOptions AS $clientCategory)
                            <option data-color="{{$clientCategory['color']}}"
                                    @if(old('category_id') AND old('category_id') == $clientCategory['value'])
                            selected="selected"

                            @elseif(!old('category_id') AND isset($client))
                            @foreach($client->categories()->get() AS $cat)
                            @if($cat->cc_id == $clientCategory['value'])
                            selected="selected"
                            @endif
                            @endforeach
                            @endif

                            value="{{$clientCategory['value']}}">{{$clientCategory['label']}}</option>
                            @endforeach
                        </select>
                        @foreach ($errors->get('category_id') as $message)
                        <br/>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_gender" class="col-sm-3 control-label">@lang('main.client:gender_label')</label>
                    <div class="col-sm-9">
                        <select name="gender" id="c_gender" class="js-select-basic-single">
                            @foreach($genderOptions AS $gender)
                            <option
                                    @if (old('gender') AND old('gender') == $gender['value'])
                            selected="selected"
                            @elseif (!old('gender') AND isset($client) AND $client->gender == $gender['value'])
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
                <div class="form-group">
                    <label for="c_importance" class="col-sm-3 control-label">@lang('main.client:importance_label')</label>
                    <div class="col-sm-9">
                        <select name="importance" id="c_importance" class="js-select-basic-single">
                            @foreach($importanceOptions AS $importance)
                            <option
                                    @if (old('importance') AND old('importance') == $importance['value'])
                            selected="selected"
                            @elseif (!old('importance') AND isset($client) AND $client->importance == $importance['value'])
                            selected="selected"
                            @endif
                            value="{{$importance['value']}}">{{$importance['label']}}
                            </option>
                            @endforeach
                        </select>
                        @foreach ($errors->get('importance') as $message)
                        <br/>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_discount" class="col-sm-3 control-label">@lang('main.client:discount_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('discount');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($client)) {
                            $value = $client->discount;
                        } else {
                            $value = '';
                        }?>
                        <input type="text" class="form-control" name="discount" id="c_discount" value="{{$value}}" placeholder="@lang('main.client:discount_label')">
                        @foreach ($errors->get('discount') as $message)
                        <?='<br/>'?>{{$message}}
                        @endforeach
                    </div>
                </div>
                <!-- Дата рождения  birthday -->
                <div class="form-group">
                    <label for="c_birthday" class="col-sm-3 control-label">@lang('main.client:birthday_label')</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <?php
                            $old = old('birthday');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($client)) {
                                $value = date('Y-m-d', strtotime($client->birthday));
                            } else {
                                $value = '';
                            }?>
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control hasDatepicker" name="birthday" id="c_birthday" value="{{$value}}" placeholder="@lang('main.client:birthday_label')">
                            @foreach ($errors->get('birthday') as $message)
                            <br/>{{$message}}
                            @endforeach
                            <!--<input type="text" class="form-control" name="birthday" id="c_birthday" value="{{$value}}">-->
                        </div>
                    </div>
                </div>
                <!-- Комментарий (textarea - comment) -->
                <div class="form-group">
                    <label for="c_comment" class="col-sm-3 control-label">@lang('main.client:comment_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('comment');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($client)) {
                            $value = $client->comment;
                        } else {
                            $value = '';
                        }?>
                        <textarea name="comment" id="c_comment" class="form-control" placeholder="@lang('main.client:comment_label')">{{$value}}</textarea>
                        @foreach ($errors->get('comment') as $message)
                        <?='<br/>'?>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_online_reservation_available" class="col-sm-3 control-label">@lang('main.client:online_record_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('online_reservation_available');
                        if (!is_null($old)) {
                            if ($old == '0') { $checked = "checked"; } else { $checked = ""; }
                        } elseif (isset($client)) {
                            if ($client->online_reservation_available == '0') { $checked = "checked"; } else { $checked = ""; }
                        } else {
                            $checked = "";
                        }?>
                        <div class="checkbox">
                            <label><input type="checkbox" name="online_reservation_available" id="c_online_reservation_available" {{$checked}} value="1">&nbsp;@lang('main.client:online_reservation_available')</label>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label for="c_total_bought" class="col-sm-3 control-label">@lang('main.client:total_bought_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('total_bought');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($client)) {
                            $value = $client->total_bought;
                        } else {
                            $value = '';
                        }?>
                        <input type="text" class="form-control" name="total_bought" id="c_total_bought" value="{{$value}}" placeholder="@lang('main.client:total_bought_label')">
                        @foreach ($errors->get('total_bought') as $message)
                        <?='<br/>'?>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_total_paid" class="col-sm-3 control-label">@lang('main.client:total_paid_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('total_paid');
                        if (!is_null($old)) {
                            $value = $old;
                        } elseif (isset($client)) {
                            $value = $client->total_paid;
                        } else {
                            $value = '';
                        }?>
                        <input type="text" class="form-control" name="total_paid" id="c_total_paid" value="{{$value}}" placeholder="@lang('main.client:total_paid_label')">
                        @foreach ($errors->get('total_paid') as $message)
                        <?='<br/>'?>{{$message}}
                        @endforeach
                    </div>
                </div>
                <div class=" text-right m-t">
                    <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
