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
                                    <form method="post" action="/user/saveAvatar" style="height:120px;">
                                        <!--<img src="/img/crm/avatar/avatar100.jpg">-->
                                        <img src="{{$crmuser->getAvatarUri()}}">
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <!-- inf -->
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
                        <div class="row">


                        </div>

                        <div class="row">

                        </div>
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