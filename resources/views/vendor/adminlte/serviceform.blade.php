@extends('adminlte::layouts.app')

@section('htmlheader_title')
@lang('main.service_category:list_page_header')
@endsection

@section('main-content')
<section class="content-header">
    <h1>
        @if (isset($service))
        @lang('main.service:edit_form_header')
        @else
        @lang('main.service:create_form_header')
        @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
        <li><a href="/services">@lang('main.service:list_page_header')</a></li>
        <li class="active">
            @if (isset($service))
            @lang('main.service:edit_form_header')
            @else
            @lang('main.service:create_form_header')
            @endif
        </li>
    </ol>
</section>
<div class="container">
    <div class="row">
        <div class="col-sm-12 m-t">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#menu1">{{ trans('adminlte_lang::message.basic_settings') }}</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#menu2">{{ trans('adminlte_lang::message.employees') }}</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#menu3">{{ trans('adminlte_lang::message.resources') }}</a>
                </li>
            </ul>

            {!! Form::open(['url' => '/services/save', 'id' => 'service_form', 'class' => 'form-horizontal']) !!}
            {{ Form::hidden('employee-options', null, ['id' => 'employee-options']) }}
            {{ Form::hidden('routing-options', null, ['id' => 'routing-options']) }}
            {{ Form::hidden('resource-options', null, ['id' => 'resource-options']) }}
            {{-- {{ Form::hidden('id', 'service_form__basic_settings') }}		 --}}
            <div class="tab-content">
                <div id="menu1" class="tab-pane fade in active">
                    @if (isset($service))
                    <input type="hidden" name="service_id" id="sc_service_id" value="{{$service->service_id}}">
                    @endif
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-right" for="s_service_category_id">@lang('main.service:service_category_label')</label>
                        <div class="col-sm-8">
                            <select name="service_category_id" id="s_service_category_id" class="js-select-basic-single">
                                @foreach($serviceCategoriesOptions as $serviceCategory)
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
                            @foreach ($errors->get('service_category_id') as $message)
                            <br/>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-right" for="s_name">@lang('main.service:name_label')</label>
                        <div class="col-sm-8">
                            <?php
                            $old = old('name');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($service)) {
                                $value = $service->name;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="name" id="s_name" class="form-control" value="{{$value}}">
                            @foreach ($errors->get('name') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-right" for="s_price_min">@lang('main.service:price_min_label')</label>
                        <div class="col-sm-8">
                            <?php
                            $old = old('price_min');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($service)) {
                                $value = $service->price_min;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="price_min" id="s_price_min" class="form-control" value="{{$value}}">
                            @foreach ($errors->get('price_min') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-right" for="s_price_max">@lang('main.service:price_max_label')</label>
                        <div class="col-sm-8">
                            <?php
                            $old = old('price_max');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($service)) {
                                $value = $service->price_max;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="price_max" id="s_price_max" class="form-control" value="{{$value}}">
                            @foreach ($errors->get('price_max') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label text-right" for="s_duration">@lang('main.service:duration_label')</label>
                        <div class="col-sm-8">
                            <select name="duration" id="s_duration" class="js-select-basic-single">
                                @foreach($durationOptions as $duration)
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
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label text-right" for="s_description">@lang('main.service:description_label')</label>
                        <div class="col-sm-8">
                            <?php
                            $old = old('description');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($service)) {
                                $value = $service->description;
                            } else {
                                $value = '';
                            }?>
                            <textarea name="description" id="s_description" class="form-control" rows=5>{{$value}}</textarea>
                            @foreach ($errors->get('description') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label text-right" for="s_price_max">@lang('main.service:max_num_appointments')</label>
                        <div class="col-sm-8">
                            <?php
                            $old = old('max_num_appointments');
                            if (!is_null($old)) {
                                $value = $old;
                            } elseif (isset($service)) {
                                $value = $service->max_num_appointments;
                            } else {
                                $value = '';
                            }?>
                            <input type="text" name="max_num_appointments" id="s_max_num_appointments" class="form-control" value="{{$value}}">
                            @foreach ($errors->get('max_num_appointments') as $message)
                            <?='<br/>'?>{{$message}}
                            @endforeach
                        </div>
                    </div>

                    {{-- <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary center-block">@lang('main.btn_submit_label')</button>
                        </div>
                    </div> --}}
                </div>
                <div id="menu2" class="tab-pane fade alt-control-bar">
                    {{-- <h4>{{ trans('adminlte_lang::message.section_under_construction') }}</h4> --}}
                    {{-- {!! Form::open(['url' => 'services/save', 'id' => 'service_form__employees']) !!}
                    {{ Form::hidden('id', 'service_form__employees') }} --}}
                    @if (isset($service))
                    {{ Form::hidden('service_id', $service->service_id) }}
                    @endif
                    <div class="row m-t">
                        {{ Form::label('employee', trans('adminlte_lang::message.employee'), ['class' => 'col-sm-3 text-left small']) }}
                        {{ Form::label('duration', trans('adminlte_lang::message.duration'), ['class' => 'col-sm-4 text-left small']) }}
                        {{ Form::label('routing', trans('adminlte_lang::message.routing'), ['class' => 'col-sm-3 text-center small']) }}
                    </div>
                    <div class="row">
                        <div class="col-sm-12"><hr></div>
                    </div>
                    <div class="employee-content m-b">
                        @if (isset($service))
                        @foreach($service_attached_employees as $service_attached_employee)
                        <div class="row">
                            <div class="col-sm-3">
                                {{ Form::select(
                                'service-employee[]',
                                $service_employees,
                                $service_attached_employee->pivot->employee_id,
                                [
                                    'class' => 'js-select-basic-single-alt',
                                    'required' => '',
                                    'data-initial-value' => $service_attached_employee->pivot->employee_id
                                ])
                                }}
                            </div>
                            <div class="col-sm-2">
                                {{ Form::select(
                                'service-duration-hour[]',
                                $service_duration_hours,
                                date_parse($service_attached_employee->pivot->duration)['hour'],
                                ['class' => 'js-select-basic-single-alt', 'required' => ''])
                                }}
                            </div>
                            <div class="col-sm-2">
                                {{ Form::select(
                                'service-duration-minute[]',
                                $service_duration_minutes,
                                date_parse($service_attached_employee->pivot->duration)['minute'],
                                ['class' => 'js-select-basic-single-alt', 'required' => ''])
                                }}
                            </div>
                            <div class="col-sm-3">
                                {{ Form::select(
                                'service-routing[]',
                                $service_routings,
                                $service_attached_employee->pivot->routing_id,
                                [
                                'class' => 'js-select-basic-single-alt',
                                'required' => '',
                                'data-initial-value' => $service_attached_employee->pivot->routing_id
                                ])
                                }}
                            </div>
                            <div class="col-sm-2">
                                <button type="button" id="delete-employee" class="btn btn-danger">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <input type="button" id="add-employee" class="btn btn-info" value="{{ trans('adminlte_lang::message.employee_add') }}">
                </div>
                <div id="menu3" class="tab-pane fade alt-control-bar">
                    @if (isset($service))
                    {{ Form::hidden('service_id', $service->service_id) }}
                    @endif
                    <div class="row m-t">
                        {{ Form::label('resource', trans('adminlte_lang::message.resource_name'), ['class' => 'col-sm-6 text-left small']) }}
                        {{ Form::label('amount', trans('adminlte_lang::message.amount'), ['class' => 'col-sm-4 text-left small']) }}
                    </div>
                    <div class="row">
                        <div class="col-sm-12"><hr></div>
                    </div>
                    <div class="resource-content m-b">
                        @if (isset($service))
                        @foreach($resources_attached_service as $resource_attached_service)
                        <div class="row">
                            <div class="col-sm-6">
                                {{ Form::select(
                                'service-resource[]',
                                [],
                                $resource_attached_service->pivot->resource_id,
                                [
                                'class' => 'js-select-basic-single-alt',
                                'required' => '',
                                'data-initial-value' => $resource_attached_service->pivot->resource_id
                                ])
                                }}
                            </div>
                            <div class="col-sm-4">
                                {{ Form::text(
                                'amount[]',
                                $resource_attached_service->pivot->amount,
                                [
                                'class' => 'form-control',
                                'required' => ''
                                ])
                                }}
                            </div>
                            <div class="col-md-12">
                                <button type="button" id="delete-resource" class="btn btn-sm btn-white center-block">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <input type="button" id="add-resource" class="btn btn-info" value="{{ trans('adminlte_lang::message.resource_add') }}">
                </div>
                <div class="row m-t">
                    <div class="col-sm-12 text-right">
                        {!! Html::linkRoute('employee.update', trans('adminlte_lang::message.cancel'), null, ['class'=>'btn btn-info m-r']) !!}
                        {{ Form::button(trans('adminlte_lang::message.save'), ['class'=>'btn btn-primary', 'id' => 'form_submit']) }}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('page-specific-scripts')
<script>
    $(document).ready(function(){
        window.employeeOptions = [];
        window.routingOptions = [];

        $('#add-employee').on('click', function(e){
            $('.employee-content').prepend('<div class="row"><div class="col-sm-3"><select required="required" name="service-employee[]" class="js-select-basic-single-alt"></select></div> <div class="col-sm-2"><select required="required" name="service-duration-hour[]" class="js-select-basic-single-alt"><option value="0">0 ч</option><option value="1">1 ч</option><option value="2">2 ч</option><option value="3">3 ч</option><option value="4">4 ч</option><option value="5">5 ч</option><option value="6">6 ч</option><option value="7">7 ч</option><option value="8">8 ч</option><option value="9">9 ч</option></select></div> <div class="col-sm-2"><select required="required" name="service-duration-minute[]" class="js-select-basic-single-alt"><option value="00">00 мин</option><option value="15">15 мин</option><option value="30">30 мин</option><option value="45">45 мин</option></select></div> <div class="col-sm-3"><select required="required" name="service-routing[]" class="js-select-basic-single-alt"></select></div> <div class="col-sm-2"><button type="button" id="delete-employee" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></div></div>');
            sel = $('.employee-content').children('.row').first().children('.col-sm-3').children('select[name="service-employee[]"]').first();
            sel.html(window.employeeOptions);

            sel = $('.employee-content').children('.row').first().children('.col-sm-3').children('select[name="service-routing[]"]').first();
            sel.html(window.routingOptions);

            $(".employee-content .js-select-basic-single-alt").select2({
                theme: "alt-control",
                placeholder: "choose one",
                minimumResultsForSearch: Infinity
            }).on("select2:open", function () {
                $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
            });
        });

        $('.employee-content').on('click', '#delete-employee', function(e){
            $(this).parent().parent().remove();
        });

        $('#add-resource').on('click', function(e){
            $('.resource-content').prepend('<div class="row"><div class="col-sm-6"><select required="required" name="service-resource[]" class="js-select-basic-single-alt"></select></div> <div class="col-sm-4"><input type="text" name="amount[]" class="form-control" value="0"></div> <div class="col-sm-2"><button type="button" id="delete-resource" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></div></div>');
            sel = $('.resource-content').children('.row').first().children('.col-sm-6').children('select[name="service-resource[]"]').first();
            sel.html($('#resource-options').val());

            $(".resource-content .js-select-basic-single-alt").select2({
                theme: "alt-control",
                placeholder: "choose one",
                minimumResultsForSearch: Infinity
            }).on("select2:open", function () {
                $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
            });
        });

        $('.resource-content').on('click', '#delete-resource', function(e){
            $(this).parent().parent().remove();
        });

        $('#form_submit').on('click', function() {
            $('#service_form').submit();

            // var activeTab = $('ul.nav.nav-tabs li.active a').attr('href');

            // if(activeTab == '#menu1') {
            // 	$('#service_form__basic_settings').submit();
            // }

            // if(activeTab == '#menu2') {
            // 	$('#service_form__employees').submit();
            // }

            // if(activeTab == '#menu3') {
            // 	$('#service_form__resources').submit();
            // }
        });

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '/service/employeeOptions',
            data: {},
            success: function(data) {
                $('select[name="service-employee[]"]').html('');
                $('select[name="service-employee[]"]').html(data.options);

                //$('#employee-options').val(data.options);
                window.employeeOptions = data.options;
                // $('select.form-control[name="products_cats_detailed[]"]').find('option').remove();
                // $('select.form-control[name="products_cats_detailed[]"]').append(options);

                $('select.js-select-basic-single[name="service-employee[]"]').each(function() {
                    var initialValue = $(this).attr('data-initial-value');

                    $(this).val(initialValue).trigger("change");
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log('Error while processing employee data range!');
            }
        });

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '/service/routingOptions',
            data: {},
            success: function(data) {
                $('select[name="service-routing[]"]').html('');
                $('select[name="service-routing[]"]').html(data.options);

                //$('#routing-options').val(data.options);
                window.routingOptions = data.options;

                $('select.js-select-basic-single[name="service-routing[]"]').each(function() {
                    var initialValue = $(this).attr('data-initial-value');

                    $(this).val(initialValue).trigger("change");
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log('Error while processing routing data range!');
            }
        });

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: '/service/resourceOptions',
            data: {},
            success: function(data) {
                $('select[name="service-resource[]"]').html('');
                $('select[name="service-resource[]"]').html(data.options);

                $('#resource-options').val(data.options);

                $('select.js-select-basic-single[name="service-resource[]"]').each(function() {
                    var initialValue = $(this).attr('data-initial-value');

                    if ( 0 != initialValue ) {
                        $(this).val(initialValue);
                    } else {
                        $(this).val($(this).find('option').first().val());
                    }
                });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log('Error while processing resource data range!');
            }
        });
    });
</script>
@endsection
