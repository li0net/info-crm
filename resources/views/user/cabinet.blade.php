@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.user:page_title_cabinet')
@endsection


@section('main-content')

    <section class="content-header">
        <h1>@lang('main.user:title_personal_data_settings')</h1>
        <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Advanced Elements</li>
        </ol>-->
    </section>

    <section class="content">
        <div class="row">

            <div class="col-lg-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_personal_data')</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- avatar -->
                                <div class="text-center">
                                    <form id="avatar_form" method="post" action="/user/saveAvatar" style="height:120px;">
                                        <!--<img src="/img/crm/avatar/avatar100.jpg">-->
                                        <a id="avatar_anchor" href="#">
                                            <img src="{{$crmuser->getAvatarUri()}}">
                                        </a>
                                        <input type="file" id="usercabinet_avatar" name="avatar" style="display:none;">
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <!-- inf -->
                                <h3>{{$crmuser->name}}</h3>
                                <p><i class="fa fa-phone"></i>&nbsp;{{$crmuser->phone}}</p>
                                <p><i class="fa fa-envelope"></i>&nbsp;{{$crmuser->email}}</p>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <a href="#" class="btn btn-primary btn-sm">@lang('main.user:btn_my_records')</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_mailings')</h3>
                    </div>
                    <div class="box-body">
                        <form id="mailings_form" method="post" action="/user/saveMailingSettings">
                            <?php
                            if ($crmuser->send_news_inf_emails == '1') {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }?>
                            <label>
                                <input type="checkbox" name="send_news_inf_emails" id="u_send_news_inf_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_news_emails')
                            </label>
                            <br>

                            <?php
                            if ($crmuser->send_marketing_offer_emails == '1') {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }?>
                            <label>
                                <input type="checkbox" name="send_marketing_offer_emails" id="u_send_marketing_offer_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_marketing_offer_emails')
                            </label>
                            <br>

                            <?php
                            if ($crmuser->send_system_inf_emails == '1') {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }?>
                            <label>
                                <input type="checkbox" name="send_system_inf_emails" id="u_send_system_inf_emails" {{$checked}} value="1">&nbsp;@lang('main.user:receive_system_inf_emails')
                            </label>
                            <br>

                            <p><a href="#" id="mailings_submit" class="btn btn-primary btn-sm">@lang('main.btn_submit_label')</a></p>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-lg-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('main.user:title_section_settings')</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Date:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

<!-- Push a script dynamically from a view -->
@push('scripts')
    <script src="{{asset('js/usercabinet.js')}}"></script>
@endpush