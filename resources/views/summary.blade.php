@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.summary') }}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="jumbotron">
                <p class="lead">{{ trans('adminlte_lang::message.summary') }}</p>
                <hr>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::message.organization_id') }}</h3>
                </div>
                <div class="box-body" style="min-height: 0; padding: 0">
                    <div class="row">
                        <p class="text-center" style="font-size: 40px; font-weight: 100; margin: 0;">#{{ $organization_id }}</p>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::message.consultant') }}</h3>
                </div>
                <div class="box-body" style="min-height: 0; padding: 10px 0 0 0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <img alt="image" class="m-t-xs" style="max-width: 90px" src="img/logo-info-group.svg">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <p class="form-text"><i class="fa fa-user"></i>&nbsp;Кривошеев Сергей Викторович</p>
                            <p class="form-text"><i class="fa fa-phone"></i>&nbsp;+7 8442 45-13-23</p>
                            <p class="form-text"><i class="fa fa-envelope"></i>&nbsp;zallador.starsinger@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('adminlte_lang::message.activity_log') }}</h3>
                </div>
                <div class="box-body" style="min-height: 0; padding: 10px 0px 10px 30px">
                    <div class="row">
                        @foreach($dts as $dt)
                            <p>{{ $dt->date }}</p>
                            @foreach($appointments as $appointment)
                                @if($dt->date == date("d-m-Y", strtotime($appointment->start)))
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-4"><i class="fa fa-calendar"></i>&nbsp;{{ date("d-m-Y", strtotime($appointment->start)) }}</div>
                                                <div class="col-sm-4"><i class="fa fa-user"></i>&nbsp;{{ $appointment->employee->name }}</div>
                                                <div class="col-sm-4"><i class="fa fa-clock-o"></i>&nbsp;{{ date("H:i", strtotime($appointment->end) - strtotime($appointment->start)) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10"><i class="fa fa-calendar"></i>&nbsp;{{ date("d-m-Y", strtotime($appointment->start)) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10"><i class="fa fa-certificate"></i>&nbsp;{{ $appointment->service->name }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10"><i class="fa fa-user"></i>&nbsp;{{ $appointment->employee->name }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10"><i class="fa fa-clock-o"></i>&nbsp;{{ date("H:i", strtotime($appointment->end) - strtotime($appointment->start)) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                @if( $appointment->state == "created")
                                                    <div class="col-sm-10"><i class="fa fa-hourglass-2"></i>&nbsp;Запись создана</div>
                                                @elseif( $appointment->state == "confirmed")
                                                    <div class="col-sm-10"><i class="fa fa-hourglass-2"></i>&nbsp;Клиент подтвердил визит</div>
                                                @elseif( $appointment->state == "finished")
                                                    <div class="col-sm-10"><i class="fa fa-hourglass-2"></i>&nbsp;Визит завершен</div>
                                                @else
                                                    <div class="col-sm-10"><i class="fa fa-hourglass-2"></i>&nbsp;Клиент не пришел</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" style="padding-right: 50px">
                                        @if ($appointment != end($appointments))
                                            <hr>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection