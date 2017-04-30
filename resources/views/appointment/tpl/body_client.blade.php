<div class="row ">
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#menu1"><i class="fa fa-users" aria-hidden="true"></i>Существующий клиент</a>
            </li>
            <li class="">
                <a data-toggle="tab" href="#menu2"><i class="fa fa-user-plus" aria-hidden="true"></i>Новый клиент/Распознать</a>
            </li>
        </ul>
        <div class="tab-content form-horizontal">
            <div id="menu1" class="tab-pane fade in active">
                <div class="form-group">
                    <label for="app_client_id" class="col-sm-3 control-label text-right">@lang('main.appointment:client_name_label')</label>
                    <div class="col-sm-9">
                        <?php
                        $old = old('client_id');
                        $needNull = TRUE;
                        if (!is_null($old)) {
                            $value = $old;
                            $needNull = FALSE;
                        } elseif (isset($appointment)) {
                            $value = $appointment->client->client_id;
                            $needNull = FALSE;
                        } else {
                            $value = '';
                        }?>
                        <select name="client_id" id="app_client_id" class = "js-select-basic-single-search">
                            @if ($needNull)
                                <option id="app_client_id_empty" value="null">{{ trans('adminlte_lang::message.select_client') }}</option>
                            @endif
                            @if (isset($clients) OR session()->has('clients'))
                                <?php if(!isset($clients)) $clients = session('clients');?>
                                @foreach($clients as $client)
                                <option
                                        @if (old('client_id') AND old('client_id') == $client['client_id'])
                                        selected="selected"
                                        @elseif (!old('client_id') AND isset($appointment) AND $appointment->client_id == $client['client_id'])
                                        selected="selected"
                                        @endif
                                        value="{{$client['client_id']}}">{{$client['name']}}
                                </option>
                                @endforeach
                            @endif
                        </select>
                        <!--    <input type="text" name="client_name" id="app_client_name" class = "form-control" value="{{$value}}" required>-->
                        <div id="client_name_error">
                            @foreach ($errors->get('client_name') as $message)
                            <br/>{{$message}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="client_edit_oo">
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                <div class="form-group">
                    <label for="app_new_client_name" class="col-sm-3 control-label text-right">@lang('main.appointment:client_name_label')</label>
                    <div class="col-sm-9">
                        <input type="text" name="client_name" id="app_new_client_name" class = "form-control" value="">
                        <div id="client_name_error">
                            @foreach ($errors->get('client_name') as $message)
                            <br/>{{$message}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label text-right" for="app_new_client_phone">@lang('main.appointment:client_phone_label')*</label>
                    <div class="col-sm-9">
                        <input type="text" name="client_phone" id="app_new_client_phone" class = "form-control" value="">
                        <div id="client_phone_error">
                            @foreach ($errors->get('client_phone') as $message)
                            <br/>{{$message}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label text-right"for="app_new_client_email">@lang('main.appointment:client_email_label')</label>
                    <div class="col-sm-9">
                        <input type="email" name="client_email" id="app_new_client_email" class = "form-control" value="">
                        <div id="client_email_error">
                            @foreach ($errors->get('client_email') as $message)
                            <br/>{{$message}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" id="btn_app_form_create_client" class="btn btn-info">Распознать/Создать нового клиента</button>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>

<?php
//dd($servicesOptions);
//dd($clients);
?>
