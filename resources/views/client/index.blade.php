@extends('adminlte::layouts.app')

@section('htmlheader_title')
    @lang('main.client:list_page_header')
@endsection

@section('main-content')
    <section class="content-header">
        <h1>@lang('main.client:list_header')</h1>
        <ol class="breadcrumb">
            <li><a href="/home"><i class="fa fa-home" aria-hidden="true"></i>{{ trans('adminlte_lang::message.home') }}</a></li>
            <li class="active">{{ trans('adminlte_lang::message.client_list') }}</li>
        </ol>
    </section>
    <div class="container-fluid">

        @include('partials.alerts')

        <div class="row">
            <div class="col-md-12 text-right m-b">
                <a href="{{$newClientUrl}}" class="btn btn-primary">@lang('main.client:create_new_btn_label')</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 clients-grid-block">
                <div class="input-group input-group-addon-right m-b">
                    <input class="form-control" id="client_main_search_field" type="text" placeholder="@lang('main.client:search_field_placeholder')">
                    <div class="input-group-btn">
                        <button id="client_main_search_btn" type="button" class="btn btn-primary">@lang('main.client:search_button_label')</button>
                    </div>
                </div>
                <table id="clients_grid" class="table table-hover table-condensed"></table>
                <div id="clients_grid_pager"></div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        {{--<h3 class="box-title">@lang('main.client:list_actions')</h3>--}}
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        {{--<h4>SMS</h4>--}}
                        {{--<ul class="list-unstyled m-b">--}}
                            {{--<li>--}}
                                {{--<a id="a_send_sms_to_selected" href="#" class="disabled btn btn-link link-blue btn-xs" onclick="alert('Not implemented yet');">--}}
                                    {{--<i class="fa fa-paper-plane"></i>--}}
                                    {{--@lang('main.client:list_send_sms_to_selected')--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--<li>--}}
                                {{--<a id="a_send_sms_to_all_found" class='btn btn-link link-blue btn-xs' href="#" onclick="alert('Not implemented yet');">--}}
                                    {{--<i class="fa fa-paper-plane"></i>--}}
                                    {{--@lang('main.client:list_send_sms_to_all_found')--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}

                        <h4>@lang('main.client:list_actions')</h4>
                        <ul class="list-unstyled m-b">
                            <li>
                                <a id="a_clients_delete_selected" class='btn btn-link link-blue btn-xs disabled' href="#">
                                    <i class="fa fa-trash-o"></i>
                                    @lang('main.client:list_delete_selected')
                                </a>
                            </li>
                            <li>
                                <a id="a_clients_delete_all_found" class='btn btn-link link-blue btn-xs' href="#">
                                    <i class="fa fa-trash-o"></i>
                                    @lang('main.client:list_delete_all_found')
                                </a>
                            </li>
                            <li>
                                <a id="a_clients_add_selected_to_category" class='btn btn-link link-blue btn-xs disabled' href="#">
                                    <i class="fa fa-users"></i>
                                    @lang('main.client:list_add_selected_to_category')
                                </a>
                            </li>
                            <li>
                                <a id="a_clients_add_all_found_to_category" class='btn btn-link link-blue btn-xs' href="#">
                                    <i class="fa fa-users"></i>
                                    @lang('main.client:list_add_all_found_to_category')
                                </a>
                            </li>

                        </ul>

                        @if ($crmuser->hasAccessTo('clients_export_xls', 'view', null))
                        <h4>Excel</h4>
                        <ul class="list-unstyled m-b">
                            <li>
                                <a id="a_export_filtered_clients_to_excel" class='btn btn-link link-blue btn-xs' href="#">
                                    <i class="fa fa-file-excel-o"></i>
                                    @lang('main.client:list_export_filtered_to_excel')
                                </a>
                            </li>
                            <li>
                                <a id="a_export_all_clients_to_excel" class='btn btn-link link-blue btn-xs' href="#">
                                    <i class="fa fa-file-excel-o"></i>
                                    @lang('main.client:list_export_all_to_excel')
                                </a>
                            </li>
                        </ul>
                        @endif

                        <form method="POST" action="/clients/gridData" accept-charset="UTF-8" id="clientsGridExportForm">
                            {{csrf_field()}}
                            <input id="clientsGridName" name="name" type="hidden" value="clients_filtered">
                            <input id="clientsGridModel" name="model" type="hidden">
                            <input id="clientsGridSidx" name="sidx" type="hidden">
                            <input id="clientsGridSord" name="sord" type="hidden">
                            <input id="clientsGridExportFormat" name="exportFormat" type="hidden" value="xls">
                            <input id="clientsGridFilters" name="filters" type="hidden">

                            <input id="docGridPivotFlag" name="pivot" type="hidden" value="">
                            <input id="docGridRows" name="pivotRows" type="hidden">
                            <input name="fileProperties" type="hidden" value='[]'>
                            <input name="sheetProperties" type="hidden" value='[]'>
                            <input name="groupingView" type="hidden" value='[]'>
                            <input name="groupHeaders" type="hidden" value=''>
                        </form>
                    </div><!-- /.box-body -->
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>@lang('main.client:filter_panel_title')</h4>
                        <div class="form-group">
                            <label for="c_category_id_filter" class="col-sm-3 control-label">@lang('main.client:client_category_label')</label>
                            <div class="col-sm-9">
                                <select name="category_id_filter" id="c_category_id_filter" class="js-select-basic-single">
                                    @foreach($clientCategoriesOptions AS $clientCategory)
                                        <option data-color="{{$clientCategory['color']}}"
                                                value="{{$clientCategory['value']}}">{{$clientCategory['label']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="c_gender_filter" class="col-sm-3 control-label">@lang('main.client:gender_label')</label>
                            <div class="col-sm-9">
                                <select name="gender_filter" id="c_gender_filter" class="js-select-basic-single">
                                    @foreach($genderOptions AS $gender)
                                        <option value="{{$gender['value']}}">{{$gender['label']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="c_importance_filter" class="col-sm-3 control-label">@lang('main.client:importance_label')</label>
                            <div class="col-sm-9">
                                <select name="importance_filter" id="c_importance_filter" class="js-select-basic-single">
                                    @foreach($importanceOptions AS $importance)
                                        <option value="{{$importance['value']}}">{{$importance['label']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-right m-t">
                            <button type="submit" id="btn_client_filter_search" class="btn btn-primary center-block">@lang('main.client:filter_button')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-specific-scripts')
<script>
    $(document).ready(function(e){
        /**
         * обработчик кнопки "Добавить выбранных в категорию"
         */
        $( "#a_clients_add_selected_to_category").on( "click", function() {
            // получаем список категорий
            $.ajax({
                type: "POST",
                url: "/clientCategories/getList",
                success: function(data) {
                    if (data.length){
                        // из полученного массива генерим селект
                        data = $.parseJSON(data);
                        var ccSel = $("<select></select>").attr("id", 'cc_select').attr("name", "name").addClass('js-select-basic-single');
                        $.each(data, function (i, el) {
                            ccSel.append("<option value='" +el['value']+ "' data-color='"+el['color']+"'>"+ el['label'] + "</option>");
                        });

                        // открываем модальное окно
                        // задаём buttonId чтобы потом привязать хендлер
                        showBiModal(ccSel ,{
                            buttonId:'sendCCSel',
                            title: '@lang('main.client:list_add_selected_to_category')'
                        });

                        // генерим "красивый селект", #biModal - id модального окна
                        $("#biModal .js-select-basic-single").select2({
                            placeholder: "Choose Category",
                            templateResult: formatClientCatModalColor,
                            minimumResultsForSearch: Infinity
                        }).on("select2:open", function () {
                            $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                        });
                    } else {
                        alert('Server error:' + data.error);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Server error:'+textStatus);
                }
            });
        });

        /**
         * обработчик кнопки сохранения диалога "Добавить выбранных в категорию"
         */
        $('#biModal').on('click', '#sendCCSel', function() {
            // подчищаем сообщения об ошибках
            $('#biModal').find('.alert').remove();

            // получаем список клиентов из грида и выбранную категорию
            var clients = $('#clients_grid').getGridParam('selarrrow');
            var category = $( "select#cc_select option:checked" ).val();

//            console.log('category:'+category);
//            console.log('clients:');
//            console.log(clients);
//            $('#biModal').modal('hide');
//            $("#clients_grid").trigger("reloadGrid");
//            return;

            // отправляем для сохранения
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/clients/addSelToCategory",
                data: {'client_ids' : JSON.stringify(clients), "category_id":category },
                success: function(data) {
                    if (data.success == true) {
                        // в случае удачи закрываем окно, перегружаем грид
                        $('#biModal').modal('hide');
                        $("#clients_grid").trigger("reloadGrid");
                    } else {
                        showBiModalError(data.error);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showBiModalError(textStatus);
                }
            });
        });
        /**
         * обработчик кнопки "Добавить найденных в категорию"
         */
        $( "#a_clients_add_all_found_to_category").on( "click", function() {
            // получаем список категорий
            $.ajax({
                type: "POST",
                url: "/clientCategories/getList",
                success: function(data) {
                    if (data.length){
                        // из полученного массива генерим селект
                        data = $.parseJSON(data);
                        var ccSel = $("<select></select>").attr("id", 'cc_select').attr("name", "name").addClass('js-select-basic-single');
                        $.each(data, function (i, el) {
                            ccSel.append("<option value='" +el['value']+ "' data-color='"+el['color']+"'>"+ el['label'] + "</option>");
                        });

                        // открываем модальное окно
                        // задаём buttonId чтобы потом привязать хендлер
                        showBiModal(ccSel ,{
                            buttonId:'sendCCFnd',
                            title:'@lang('main.client:list_add_all_found_to_category')'
                        });

                        // генерим "красивый селект", #biModal - id модального окна
                        $("#biModal .js-select-basic-single").select2({
                            placeholder: "Choose Category",
                            templateResult: formatClientCatModalColor,
                            minimumResultsForSearch: Infinity
                        }).on("select2:open", function () {
                            $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
                        });
                    } else {
                        alert('Server error:' + data.error);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Server error:'+textStatus);
                }
            });
        });

        /**
         * обработчик кнопки сохранения диалога "Добавить найденных в категорию"
         */
        $('#biModal').on('click', '#sendCCFnd', function() {
            // подчищаем сообщения об ошибках
            $('#biModal').find('.alert').remove();

            // получаем выбранную категорию
            var category = $( "select#cc_select option:checked" ).val();
            // получаем фильтр грида

            var postData;
            var filters;
            var $clientsGrid = $("#clients_grid");

            $("#clientsGridModel").val(JSON.stringify($clientsGrid.getGridParam("colModel")));
            postData = $clientsGrid.getGridParam("postData");
            if(postData["filters"] != undefined) {
                filters = postData["filters"];
            } else {
                filters = '';
            }

//            console.log('category:'+category);
//            console.log('filters:');
//            console.log(filters);
//            $('#biModal').modal('hide');
//            $("#clients_grid").trigger("reloadGrid");
//            return;

            // отправляем для сохранения
            // TODO: прописать правильный урл
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "/clients/addToCategory",
                data: {'filters' : filters, "category_id":category },
                success: function(data) {
                    if (data.success == true) {
                        // в случае удачи закрываем окно, перегружаем грид
                        $('#biModal').modal('hide');
                        $("#clients_grid").trigger("reloadGrid");
                    } else {
                        showBiModalError(data.error);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showBiModalError(textStatus);
                }
            });
        });


        /**
         * форматирует строки "красивого селекта" , подставляет блоки цвета
         * @param cat
         * @returns {void|jQuery|HTMLElement}
         */
        function formatClientCatModalColor(cat) {
            if (!cat.id) { return cat.text; }
            var $category = $(
                "<div class='cc_color' style='background:"+cat.element.getAttribute('data-color')+"'></div>" + "<span class='dd_text'>" + cat.text + '</span>'
            );
            return $category;
        }

        $('#btn_client_filter_search').click(function() {
            var $clientsGrid = $("#clients_grid");
            var rules = [], i, postData = $clientsGrid.jqGrid("getGridParam", "postData"),
                    colModel = $clientsGrid.jqGrid("getGridParam", "colModel"), fVal;

            var filterFields = [
                {'id': 'c_category_id_filter', 'field': 'category_id'},
                {'id': 'c_gender_filter', 'field': 'gender'},
                {'id': 'c_importance_filter', 'field': 'importance'}
            ];
            for (i = 0; i < filterFields.length; i++) {
                fVal = $('#'+filterFields[i]['id']).val();
                if (fVal != '-') {
                    if (fVal == 'null') {
                        rules.push({
                            field: filterFields[i]['field'],
                            op: "nu",
                            data: fVal
                        });
                    } else {
                        rules.push({
                            field: filterFields[i]['field'],
                            op: "eq",
                            data: fVal
                        });
                    }
                }
            }

            //console.log('rules', rules);
            postData.filters = JSON.stringify({
                groupOp: "AND",
                rules: rules
            });
            $clientsGrid.jqGrid("setGridParam", { search: true });
            $clientsGrid.trigger("reloadGrid", [{page: 1, current: true}]);
            return false;
        });

    });
</script>
@endsection

