@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:form_page_header')
@endsection


@section('main-content')
<section class="content-header">
    <h1>{{$client->name}}</h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li><a href="{{ url('/clients') }}">{{ trans('adminlte_lang::message.client_list') }}</a></li>
        <li class="active">{{$client->name}}</li>
    </ol>
</section>
@if (isset($client))
<input type="hidden" name="client_id" id="c_client_id" value="{{$client->client_id}}">
@endif
<div class="container">
    <div class="row">
        <dl class="dl-horizontal">
            <dt><span>@lang('main.client:name_label')</span></dt>
            <dd><span>{{$client->name}}</span></dd>

            <dt><span>@lang('main.client:phone_label')</span></dt>
            <dd>
                @if ($crmuser->hasAccessTo('client_phone', 'view', 0))
                <span>{{$client->phone}}</span>
                @else
                <span>@lang('main.user:grid_phone_hidden_message')</span>
                @endif
            </dd>

            <dt><span>@lang('main.client:email_label')</span></dt>
            <dd>
                @if(trim($client->email) != '')
                <span><a href="mailto:{{$client->email}}">{{$client->email}}</a></span>
                @else
                <span>{{$client->email}}</span>
                @endif
            </dd>

            <dt><span>@lang('main.client:client_category_label')</span></dt>
            <dd>
                <?php
                $hasCategories = FALSE;
                foreach($clientCategoriesOptions AS $clientCategory) {
                    foreach($client->categories()->get() AS $cat) {
                        if($cat->cc_id == $clientCategory['value']) {
                            $hasCategories = TRUE;
                            $value = $clientCategory['label'];
                            $style = "style=\"background-color:{$clientCategory['color']}\"";

                            echo "<span $style>".htmlentities($value)."</span>&nbsp;";
                        }
                    }
                }
                if (!$hasCategories) {
                    echo "<span>&nbsp;</span>";
                }
                ?>
            </dd>
            <dt><span>@lang('main.client:gender_label')</span></dt>
            <dd><?php
                $value="";
                foreach($genderOptions AS $gender) {
                    if (($client->gender == $gender['value']) OR (trim($client->gender) == '' AND $gender['value'] == 'null')) {
                        $value = $gender['label'];
                    }
                }
                ?>
                <span>{{$value}}</span>
            </dd>

            <dt>
                <span>@lang('main.client:importance_label')</span>
            </dt>
            <dd>
                <?php
                $value="";
                foreach($importanceOptions AS $importance) {
                    if (($client->importance == $importance['value']) OR (trim($client->importance) == '' AND $importance['value'] == 'null')) {
                        $value = $importance['label'];
                    }
                }
                ?>
                <span style="width: 100%">{{$value}}</span>
            </dd>

            <dt >
                <span>@lang('main.client:discount_label')</span>
            </dt>
            <dd >
                <span>{{$client->discount}}%</span>
            </dd>

            <dt >
                <span>@lang('main.client:birthday_label')</span>
            </dt>
            <dd >
                <span>{{date('Y-m-d', strtotime($client->birthday))}}</span>
            </dd>

            <dt >
                <span>@lang('main.client:comment_label')</span>
            </dt>
            <dd >
                <span>{{$client->comment}}</span>
            </dd>

            <dt><span>@lang('main.client:online_record_label')</span></dt>
            <dd>
                <?php
                if ($client->online_reservation_available == '0') { $checked = "checked"; } else { $checked = ""; }
                ?>
                <input type="checkbox" disabled="disabled" name="online_reservation_available" id="c_online_reservation_available" {{$checked}} value="1">&nbsp;@lang('main.client:online_reservation_available')
            </dd>
            <dt >
                <span>@lang('main.client:total_bought_label')</span>
            </dt>
            <dd >
                <span>{{round($client->total_bought, 2)}}</span>
            </dd>

            <dt >
                <span>@lang('main.client:total_paid_label')</span>
            </dt>
            <dd >
                <span>{{round($client->total_paid, 2)}}</span>
            </dd>
        </dl>
    </div>
    <div class="row m-t">
        <div class="col-md-12">
            <button class="btn btn-primary pull-right" onclick="window.location='{{action('ClientsController@edit', [$client->client_id])}}'">@lang('main.clients:btn_edit_label')</button>
        </div>
    </div>
</div>

@endsection
