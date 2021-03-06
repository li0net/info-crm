
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
import ex1 from './components/ex1.vue';

//Vue.component('ex1', require('./components/Ex1.vue'));
// Vue.component('example', {
//   template: '<div class="container">'+
//         '<div class="row">'+
//             '<div class="col-md-8 col-md-offset-2">'+
//                 '<div class="panel panel-default">'+
//                     '<div class="panel-heading">'+
//                     '</div>'+
//                     '<div class="panel-body">'+
//                         'Im an example component!'+
//                     '</div>'+
//                 '</div>'+
//             '</div>'+
//         '</div>'+
//     '</div>',
//   data: function(){
//   	return {
//     	detailed_services_count: 0
//     }
//   },
//   mounted: function() {
// 	        console.log('Component mounted.')
// 	},
//   // ready: function() {
//   //   console.log('jopa');
//   //   // $(this.$el).children('input').first().datepicker({
//   //   //   format: 'dd/mm/yyyy',
//   //   //   autoclose: true
//   //   // });
//   // },
// });


// Laravel passport components
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app',
    components: {
        ex1
    },
    data: function() {
        return {
            message: $('#js_photo').html(),
            image: '',
            filter_employee: 0,
            filter_service: 0,
            filter_start_time: '00:00',
            filter_end_time: '23:45',
            detailed_services_count: 0,
            detailed_products_count: 0,
            card_items_count: 0,
            transaction_items_count: 0,
            services_ctgs_options: '',
            storage_options: '',
            service_name: $('#js_service_not_chosen').html(),
            service_employee: $('#js_employee_not_chosen').html()
        }
    },
    methods: {
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },

        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        removeImage: function (e) {
            this.image = '';
        },

        onSelectChange(e) {
            var formData = new FormData();

            formData.append('filter_employee', this.filter_employee);
            formData.append('filter_service', this.filter_service);
            formData.append('filter_start_time', this.filter_start_time);
            formData.append('filter_end_time', this.filter_end_time);

            this.$http.post('/home', formData).then((response) => {
                    $('#result_container').html(response.body);
            }, (response) => {
                    $('#result_container').html('Error while processing data!');
            });
        },
    },
    mounted: function () {
        this.detailed_services_count = $('#detailed-services').find('.wrap-it').length-1;
        this.detailed_products_count = $('#detailed-products').find('.wrap-it').length-1;
        this.card_items_count = $('#card-items').find('.wrap-it').length-2;
        this.transaction_items_count = $('#transaction-items').find('.wrap-it').length-1;

        if(this.detailed_services_count != 0) {
            $('a[href="#detailed-services"] .badge.label-danger').removeClass('hidden');
        }

        if(this.detailed_products_count != 0) {
            $('a[href="#detailed-products"] .badge.label-danger').removeClass('hidden');
        }

        if(this.transaction_items_count != 0) {
            $('a[href="#transaction-items"] .badge.label-danger').removeClass('hidden');
        }
    }
});

export default {
        ex1
};

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    //отображаем не сразу чтобы vue мог заполнить счётчики
    $(".box-solid").find('.badge').css("display", "inline-block");

    //locales
    var women = $('#js_women').html();
    var men   = $('#js_men').html();
    var all   = $('#js_all').html();

    $("#service_categories_grid").jqGrid({
        url: '/serviceCategories/gridData',
        mtype: "GET",
        styleUI : 'Bootstrap',
        datatype: "json",
        colNames:[$('#js_designation').html(), $('#js_designation_online').html(), $('#js_sex').html(),  $('#js_actions').html()],
        colModel: [
            { index: 'name', name: 'name', width: 130 },
            { index: 'online_reservation_name', name: 'online_reservation_name', width: 150 },
            { index: 'gender', name: 'gender', width: 80, edittype:'select', formatter:'select', editoptions:{value:"1:"+men+";0:"+women+";null:"+all}},
            { index: 'service_category_id', align:'center', name: 'service_category_id', key: true, width: 50, formatter:ServiceCategoryFormatEditColumn },
        ],
        sortname: 'name',
        sortorder: 'asc',
        viewrecords: true,
        height: 600,
        //width: 800,
        autowidth: true,
        shrinkToFit: true,
        rowNum: 10,
        pager: "#service_categories_grid_pager"
    });

    $("#services_grid").jqGrid({
        url: '/services/gridData',
        mtype: "GET",
        styleUI : 'Bootstrap',
        datatype: "json",
        colNames:[$('#js_designation').html(), $('#js_category').html(), $('#js_description').html(), $('#js_min_price').html(), $('#js_max_price').html(), $('#js_duration').html(),$('#js_actions').html()],
        colModel: [
            { index: 'name', name: 'name', width: 110 },
            { index: 'service_category_id', name: 'service_category_id', width: 110 },
            { index: 'description', name: 'description', width: 160 },
            { index: 'price_min', name: 'price_min', formatter:'currency', width: 70, align:'center'},
            { index: 'price_max', name: 'price_max', formatter:'currency', width: 70, align:'center'},
            { index: 'duration', name: 'duration', formatter:'date', formatoptions:{srcformat:"H:i:s", newformat:"G:i", decimalPlaces: 2, prefix: "$ "}, width: 70, align:'center' },
            { index: 'service_id', name: 'service_id', key: true, width: 60, formatter:ServiceFormatEditColumn, align:'center'  }
        ],
        sortname: 'name',
        sortorder: 'asc',
        viewrecords: true,
        height: 600,
        autowidth: true,
        shrinkToFit: true,
        rowNum: 10,
        pager: "#services_grid_pager"
    });

    $("#users_grid").jqGrid({
        url: '/users/gridData',
        mtype: "GET",
        styleUI : 'Bootstrap',
        datatype: "json",
        colNames:['Имя', 'Телефон', 'Email','Управление'],
        colModel: [
            { index: 'name', name: 'name', width: 100 },
            { index: 'phone', name: 'phone', width: 100 },
            { index: 'email', name: 'email', width: 100 },
            { index: 'user_id', align: 'center', name: 'user_id', key: true, width: 60, formatter:UserFormatEditColumn }
        ],
        sortname: 'name',
        sortorder: 'asc',
        viewrecords: true,
        height: 600,
        autowidth: true,
        shrinkToFit: true,
        rowNum: 10,
        pager: "#users_grid_pager"
    });

    // Clients grid functions
    if ($('#clients_grid').length ) {
        $("#clients_grid").jqGrid({
            url: '/clients/gridData',
            mtype: "GET",
            styleUI: 'Bootstrap',
            datatype: "json",
            colNames: ['ID', $('#js_name').html(), $('#js_contacts').html(), $('#js_sold').html(), $('#js_discount').html(), 'Importance'],
            colModel: [
                {index: 'client_id', name: 'client_id', key: true, width: 60, hidden: true, search: false},
                {index: 'name', name: 'name', width: 120, search: true, stype: 'text'},
                {index: 'phone', name: 'phone', width: 100, search: true, stype: 'text'},
                {index: 'total_bought', align:'center', name: 'total_bought', width: 70, search: false},
                {index: 'discount', align:'center', name: 'discount', width: 60, search: false},
                {index: 'importance', name: 'importance',align:'center', width: 50, search: true, hidden: true}
            ],
            sortname: 'name',
            sortorder: 'asc',
            viewrecords: true,
            height: 550,
            autowidth: true,
            shrinkToFit: true,
            rowNum: 10,
            pager: "#appclients_grid_pager",
            multiselect: true,
            onSelectRow: function(id, status, e){
                //console.log(id, status, e);
                var selRows = $('#clients_grid').getGridParam('selarrrow');
                if (selRows.length > 0) {
                    $('#a_clients_delete_selected').removeClass("disabled");
                    $('#a_send_sms_to_selected').removeClass("disabled");
                    $('#a_clients_add_selected_to_category').removeClass("disabled");
                } else {
                    $('#a_clients_delete_selected').addClass("disabled");
                    $('#a_send_sms_to_selected').addClass("disabled");
                    $('#a_clients_add_selected_to_category').addClass("disabled");
                }
            },
            onSelectAll: function(aRowIds, status){
                //console.log(aRowIds, status);
                if (status == true) {
                    $('#a_clients_delete_selected').removeClass("disabled");
                    $('#a_send_sms_to_selected').removeClass("disabled");
                    $('#a_clients_add_selected_to_category').removeClass("disabled");
                } else {
                    $('#a_clients_delete_selected').addClass("disabled");
                    $('#a_send_sms_to_selected').addClass("disabled");
                    $('#a_clients_add_selected_to_category').addClass("disabled");
                }
            }
            /*
             search : {
             caption: "Поиск по имени и номеру телефона",
             Find: "Найти",
             Reset: "Сбросить",
             odata : ['equal', 'contains'],
             groupOps: [ { op: "OR", text: "any" } ],
             matchText: " match",
             rulesText: " rules"
             },
             */
        });

        $("#client_main_search_field").keypress(function (e) {
            var key = e.charCode || e.keyCode || 0;
            if (key === $.ui.keyCode.ENTER) { // 13
                $("#client_main_search_btn").click();
            }
        });
        $("#client_main_search_btn").click(function () {
            var $clientsGrid = $("#clients_grid");
            var rules = [], i, cm, postData = $clientsGrid.jqGrid("getGridParam", "postData"),
                colModel = $clientsGrid.jqGrid("getGridParam", "colModel"),
                searchText = $("#client_main_search_field").val(),
                l = colModel.length;
            for (i = 0; i < l; i++) {
                cm = colModel[i];
                if (cm.search !== false && (cm.stype === undefined || cm.stype === "text")) {
                    rules.push({
                        field: cm.name,
                        op: "cn",
                        data: searchText
                    });
                }
            }
            // добавляю поиск по email вручную, т.к. это поле как такоевое в грид не присутсвует (email добавлеяется в поле с phone)
            rules.push({
                field: 'email',
                op: "cn",
                data: searchText
            });

            postData.filters = JSON.stringify({
                groupOp: "OR",
                rules: rules
            });
            $clientsGrid.jqGrid("setGridParam", { search: true });
            $clientsGrid.trigger("reloadGrid", [{page: 1, current: true}]);
            return false;
        });

        $("#a_export_filtered_clients_to_excel").click(function () {
            sendDownloadClientsXlsRequest(false);
        });

        $("#a_export_all_clients_to_excel").click(function () {
            sendDownloadClientsXlsRequest(true);
        });

        $('#a_clients_delete_selected').click(function() {
            var selIds = $("#clients_grid").getGridParam('selarrrow');
            console.log('selIds', selIds);
            if (selIds.length > 0) {	// $('#a_clients_delete_selected').hasClass("disabled");
                // TODO: localize
                if (! confirm('Do you really want to delete ' + selIds.length + ' client record(s)?')) {
                    return false;
                }

                //var that = this;
                $.ajax({
                    type: "POST",
                    url: "/clients/destroy/",
                    data: {'client_ids' : JSON.stringify(selIds)},
                    success: function(data) {
                        var data = $.parseJSON(data);

                        if (data.success == true) {
                            $("#clients_grid").trigger("reloadGrid");
                        } else {
                            alert('Server error:' + data.error);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('Server error:'+textStatus);
                    }
                });
            }
        });

        // обработка клика по кнопке 'Удалить всех найденных' клиентов
        $('#a_clients_delete_all_found').click(function() {
            var postData;
            var filters;
            var $clientsGrid = $("#clients_grid");
            var recordsNum = $clientsGrid.getGridParam("records");
            // TODO: localize
            if (!confirm("Do you really want to delete "+recordsNum+" clients?")) {
                return FALSE;
            }

            $("#clientsGridModel").val(JSON.stringify($clientsGrid.getGridParam("colModel")));
            postData = $clientsGrid.getGridParam("postData");
            if(postData["filters"] != undefined) {
                filters = postData["filters"];
            } else {
                filters = '';
            }

            $.ajax({
                type: "POST",
                url: "/clients/destroyFiltered/",
                data: {'filters': filters},
                success: function(data) {
                    var data = $.parseJSON(data);

                    if (data.success == true) {
                        // reset filters and refresh grid
                        $("#client_main_search_field").val('');
                        $("#clients_grid").jqGrid('setGridParam', { search: false, postData: { "filters": ""} }).trigger("reloadGrid");
                    } else {
                        alert('Server error:' + data.error);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Server error:'+textStatus);
                }
            });
        });
    }

    function sendDownloadClientsXlsRequest(all) {
        var headers = [], rows = [], row, cellCounter, postData, groupingView, sidx, sord;

        var $clientsGrid = $("#clients_grid");

        $("#clientsGridModel").val(JSON.stringify($clientsGrid.getGridParam("colModel")));
        postData = $clientsGrid.getGridParam("postData");
        if(postData["filters"] != undefined && all != true)
        {
            $("#clientsGridFilters").val(postData["filters"]);
        } else {
            $("#clientsGridFilters").val("");
        }
        groupingView = $clientsGrid.getGridParam("groupingView");
        sidx = $clientsGrid.getGridParam("sortname");
        if(sidx == null) sidx = "";
        sord = $clientsGrid.getGridParam("sortorder");
        if(sord == null) sord = "";
        if(groupingView.groupField.length > 0)
        {
            $("#clientsGridSidx").val(groupingView.groupField[0] + " " + groupingView.groupOrder[0] + "," + " " + sidx);
        }
        else
        {
            $("#clientsGridSidx").val(sidx);
        }
        $("#clientsGridSord").val(sord);
        $("#clientsGridExportFormat").val("xls");
        $("#clientsGridExportForm").submit();
    }

    $("#client_categories_grid").jqGrid({
        url: '/clientCategories/gridData',
        mtype: "GET",
        styleUI : 'Bootstrap',
        datatype: "json",
        colNames:[$('#js_category').html(), ' '],
        colModel: [
            { index: 'title', name: 'title', width: 100 },
            { index: 'cc_id', name: 'cc_id', key: true, width: 20, align: 'right', formatter:ClientCategoryFormatEditColumn }
        ],
        sortname: 'title',
        sortorder: 'asc',
        viewrecords: true,
        height: 600,
        //width: 800,
        autowidth: true,
        shrinkToFit: true,
        rowNum: 500,
        //pager: "#service_categories_grid_pager"
    });

    // Replace the <textarea id="o_info"> with a CKEditor instance, using default configuration.
    if ($('#o_info').length ) {
        CKEDITOR.replace('o_info');
    }

    /** Datepickers **********************************/
    // Datepicker defaults
    $.datepicker.setDefaults({
        language: $('#current_lang').html(),
        format: 'yyyy-mm-dd',
        firstDay: 1,
        autoclose: true
    });
    $('.hasDatepicker').datepicker({
        language: $('#current_lang').html(),
        autoclose: true,
        format: 'yyyy-mm-dd',
        firstDay: 1,
        todayHighlight: true
    });

    var today = new Date();
    $('#payment-date, #date-from, #date-to, #transaction-date, #filter-date-from, #filter-date-to, #report-date, #dp').datepicker('update', today);
    $('#dp').datepicker('update', today);

    $('#payment-hour, #transaction-hour').val(today.getHours());
    $('#payment-minute, #transaction-minute').val(today.getMinutes());


    $('#payment-date, #date-from, #date-to, #filter-date-from, #filter-date-to, #transaction-date, #report-date').datepicker().on('show', function(e) {
        $('.datepicker.datepicker-dropdown').removeClass('datepicker-orient-bottom');
        $('.datepicker.datepicker-dropdown').addClass('datepicker-orient-top');
    });

    // выбор текущей недели
    $('#dp').find('td.today.day').click();
    /** /Datepickers **********************************/

    /** SELECT2 SELECT INIT **/
    $(".js-select-basic-multiple").select2({
        templateResult: formatClientCatColor,
        allowClear: true
    }).on("select2:open", function () {
        $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
    });

    $(".js-select-basic-single-search").select2({
    }).on("select2:open", function () {
        $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
    });

    $(".js-select-basic-single").select2({
        minimumResultsForSearch: Infinity
    }).on("select2:open", function () {
        $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
    });

    $(".js-select-basic-single-alt").select2({
        theme: "alt-control",
        minimumResultsForSearch: Infinity
    }).on("select2:open", function () {
        $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #787878", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.9, cursoropacitymax:1, boxzoom:true, autohidemode:false});
    });


    /** ICHECK INIT **/
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-purple',
        labelHover: false,
        cursor: true
    });
    $('input[type="radio"]:not(".raw")').iCheck({
        radioClass: 'iradio_flat-purple',
        labelHover: false,
        cursor: true
    });

    function formatClientCatColor(cat) {
        if (!cat.id) { return cat.text; }
        var $category = $(
            '<span style="background-color:' + cat.element.getAttribute('data-color') + '">' + cat.text + '</span>'
        );
        return $category;
    }

    $('#transaction-items').on('click', '#add-transaction-item', function(e) {
        if($(e.target).val() !== 'Удалить') {
            $('#transaction-content').prepend(
                '<div class="wrap-it"><div class="col-sm-2"></div> <div class="col-sm-8" style="padding: 0px;"><div class="col-sm-3"><select maxlength="110" name="product_id[]" class="form-control"><option selected="selected" value="">Выберите товар</option></select></div> <div class="col-sm-2"><input name="price[]" type="text" class="form-control"></div> <div class="col-sm-2"><input name="amount[]" type="text" class="form-control"></div> <div class="col-sm-1"><input name="discount[]" type="text" class="form-control"></div> <div class="col-sm-2"><input name="sum[]" type="text" class="form-control"></div> <div class="col-sm-2"><input name="code[]" type="text" class="form-control"></div></div> <div class="col-sm-2" style="margin-bottom: 15px;"><input type="button" id="add-transaction-item" value="Добавить" class="btn btn-info"></div></div>');

            // $('select.form-control[name="storage_id[]"]').last().find('option').remove();
            // $('select.form-control[name="storage_id[]"]').last().append($('#storage_options').val());

            app.transaction_items_count++;
            $('a[href="#transaction-items"] .badge.label-danger').removeClass('hidden');
            $(e.target).val('Удалить');
            $(e.target).toggleClass('btn-info btn-danger')
            $(e.target).off();
            $(e.target).on('click', function(e) {
                $(e.target).parent().parent().remove();
                app.transaction_items_count--;
                if(app.transaction_items_count == 0) {
                    $('a[href="#transaction-items"] .badge.label-danger').addClass('hidden');
                }
            });
        } else {
            $(e.target).parent().parent().remove();
            app.transaction_items_count--;
            if(app.transaction_items_count == 0) {
                $('a[href="#transaction-items"] .badge.label-danger').addClass('hidden');
            }
        }
    });

    $('#transaction-items').on('shown.bs.collapse', function(){
        $('a[href="#transaction-items"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
    });

    $('#transaction-items').on('hidden.bs.collapse', function(){
        $('a[href="#transaction-items"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
    });

    $('#card-items').on('click', '#add-card-item', function(e) {
        if( $(this).hasClass('btn-add') ) {
            $('#card-items').append($('#card-items-tpl').html());
            $('#card-items .wrap-it:last-of-type select[name="storage_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');
            // $('#card-items .wrap-it:last-of-type select[name="storage_id[]"]').prepend('<option id="storage_id_empty" selected value="null">'+$('#select_storage-placeholder-tpl').html()+'</option>');
            $('#card-items .wrap-it:last-of-type select[name="product_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');

            $('#card-items .wrap-it:last-of-type select[name="card_storage_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');
            // $('#card-items .wrap-it:last-of-type select[name="card_storage_id[]"]').prepend('<option id="storage_id_empty" selected value="null">'+$('#select_storage-placeholder-tpl').html()+'</option>');
            $('#card-items .wrap-it:last-of-type select[name="card_product_id[]"]').removeClass('form-control').addClass('js-select-basic-single-alt');

            $('#card-items .wrap-it:last-of-type .js-select-basic-single-alt').select2({
                theme: "alt-control",
                minimumResultsForSearch: Infinity
            }).on("select2:open", function () {
                $('.select2-results__options').niceScroll({cursorcolor:"#969696", cursorborder: "1px solid #787878", cursorborderradius: "0", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.9, cursoropacitymax:1, boxzoom:true, autohidemode:false});
            });
            app.card_items_count++;

            $(this).addClass('btn-remove').removeClass('btn-add');
            $(this).off();
            $(this).on('click', function(e) {
                $(this).parents('.wrap-it').remove();
                app.card_items_count--;
            });
        } else {
            $(this).parents('.wrap-it').remove();
            app.card_items_count--;
        }
    });

    $('#card-items').on('shown.bs.collapse', function(){
        $('a[href="#card-items"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
    });

    $('#card-items').on('hidden.bs.collapse', function(){
        $('a[href="#card-items"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
    });

    $('#detailed-services').on('click', '#add-detailed-section', function(e) {
        if( $(this).hasClass('btn-add') ) {
            $('#detailed-services').append($('#detailed-services-tpl').html());

            $('select.form-control[name="services_cats_detailed[]"]').first().find('option').remove();
            $('select.form-control[name="services_cats_detailed[]"]').first().append($('#service_ctgs_options').val());

            app.detailed_services_count++;

            // $('a[href="#detailed-services"] .badge.label-danger').removeClass('hidden');
            $(this).addClass('btn-remove').removeClass('btn-add');
            $(this).off();
            $(this).on('click', function(e) {
                $(this).parents('.wrap-it').remove();
                app.detailed_services_count--;
                // if(app.detailed_services_count == 0) {
                // 	$('a[href="#detailed-services"] .badge.label-danger').addClass('hidden');
                // }
            });
        } else {
            $(this).parents('.wrap-it').remove();
            app.detailed_services_count--;
            // if(app.detailed_services_count == 0) {
            // 	$('a[href="#detailed-services"] .badge.label-danger').addClass('hidden');
            // }
        }
    });

    $('#detailed-services').on('shown.bs.collapse', function(){
        $('a[href="#detailed-services"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
    });

    $('#detailed-services').on('hidden.bs.collapse', function(){
        $('a[href="#detailed-services"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
    });

    $('#detailed-products').on('click', '#add-detailed-section', function(e) {
        if( $(this).hasClass('btn-add') ) {
            $('#detailed-products').append($('#detailed-products-tpl').html());

            $('select.form-control[name="products_cats_detailed[]"]').first().find('option').remove();
            $('select.form-control[name="products_cats_detailed[]"]').first().append($('#product_ctgs_options').val());

            app.detailed_products_count++;

            // $('a[href="#detailed-products"] .badge.label-danger').removeClass('hidden');
            $(this).addClass('btn-remove').removeClass('btn-add');
            $(this).off();
            $(this).on('click', function(e) {
                $(this).parents('.wrap-it').remove();
                app.detailed_products_count--;
                // if(app.detailed_products_count == 0) {
                // 	$('a[href="#detailed-products"] .badge.label-danger').addClass('hidden');
                // }
            });
        } else {
            $(this).parents('.wrap-it').remove();
            app.detailed_products_count--;
            // if(app.detailed_products_count == 0) {
            // 	$('a[href="#detailed-products"] .badge.label-danger').addClass('hidden');
            // }
        }

    });
    $('#detailed-products').on('shown.bs.collapse', function(){
        $('a[href="#detailed-products"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
    });

    $('#detailed-products').on('hidden.bs.collapse', function(){
        $('a[href="#detailed-products"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
    });

    // select2 select init
    $(".js-select-basic").select2({
        placeholder: "Select wage scheme",
        allowClear: true
    }).on("select2:open", function () {
        $('.select2-results__options').niceScroll({cursorcolor:"#ffae1a", cursorborder: "1px solid #DF9917", cursorwidth: "10px", zindex: "100000", cursoropacitymin:0.7, cursoropacitymax:1, boxzoom:true, autohidemode:false});
    });

    $('#dp').on('changeDate', function() {

        $('#my_hidden_input').val(
            $('#dp').datepicker('getFormattedDate')
        );

        var me = this;
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "/home",
            data: {date: $('#dp').datepicker('getFormattedDate')},
            success: function(data) {
                    $('#result_container').html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log('Error while processing services data range!');
            }
        });
    });

    var hash = window.location.hash;

    $('ul.nav.nav-tabs li a[href="' + hash + '"]').tab('show');

    $('#employee_form__info').removeClass('hidden');

    // bootstrap colorpicker init
    $('#cc_cp_container').colorpicker();


    $('.select2-selection__rendered').removeAttr('title');


    /**
     * click on info-icon shows side-modal with information
     */
    $('.fa.fa-info-circle').on('click', function(){
        var id = $(this).attr('id');
        var text = '';

        if ( $('#sim_'+id).length ){
            text = $('#sim_'+id).html();
        } else {
            // temporary
            text = $('#sim_info_example').html();
        }
        // open side-modal
        showSideModal(text);
    });

    // открываем активные выпадающие меню, увеличиваем высоту контена, елси она минимальная
    $('.main-sidebar .activated').each(function( index ) {
        $(this).addClass('active');
        $(this).find('.treeview-menu').addClass('menu-open').stop(true, true).slideDown(400);
        var conHeight = $('.content-wrapper').height();
        if (conHeight < 800){
            $('.content-wrapper').height(conHeight + $(this).children('.treeview-menu').height() + 100);
        }
        $(this).removeClass('activated');
    });


    if ($('#branches_grid').length ) {
        $("#branches_grid").jqGrid({
            url: '/organizations/gridData',
            mtype: "GET",
            styleUI: 'Bootstrap',
            datatype: "json",
            colNames: [$('#js_branch_name').html(), $('#js_branch_country').html(), $('#js_branch_city').html(), $('#js_branch_address').html(), $('#js_branch_phone').html(), $('#js_branch_manage').html()],
            colModel: [
                {index: 'name', name: 'name', width: 120, search: true, stype: 'text'},
                {index: 'country', name: 'country', width: 100, search: true, stype: 'text'},
                {index: 'city', name: 'city', width: 100, search: true, stype: 'text'},
                {index: 'address', name: 'address', width: 100, search: true, stype: 'text'},
                {index: 'phone_1', name: 'phone_1', width: 90, search: true, stype: 'text'},
                {index: 'organization_id', name: 'organization_id', key: true, width: 35, align: 'right', formatter:BranchFormatEditColumn}
            ],
            sortname: 'organization_id',
            sortorder: 'asc',
            viewrecords: true,
            height: 550,
            autowidth: true,
            shrinkToFit: true,
            rowNum: 15,
            pager: "#branches_grid_pager",
            multiselect: false
        });
    }


    return false;
});


function ServiceCategoryFormatEditColumn(cellvalue, options, rowObject)
{
    var url = '';
    var urlDel = '';

    if (window.Settings.permissions_service_edit !== undefined && window.Settings.permissions_service_edit == 1) {
        url = '<a href="' + window.location.protocol + '//' + window.location.host + '/serviceCategories/edit/' + cellvalue + '" class="table-action-link"><i class="fa fa-pencil"></i></a>';
    }
    if (window.Settings.permissions_service_delete !== undefined && window.Settings.permissions_service_delete == 1) {
        urlDel = '<a href="' + window.location.protocol + '//' + window.location.host + '/serviceCategories/destroy/' + cellvalue + '" class="table-action-link danger-action"><i class="fa fa-trash-o"></i></a>';
    }

    return url + urlDel;
}

function ServiceFormatEditColumn(cellvalue, options, rowObject)
{
    var url = '';
    var urlDel = '';

    if (window.Settings.permissions_service_edit !== undefined && window.Settings.permissions_service_edit == 1) {
        url = '<a href="' + window.location.protocol + '//' + window.location.host + '/services/edit/' + cellvalue + '" class="table-action-link"><i class="fa fa-pencil"></i></a>';
    }
    if (window.Settings.permissions_service_delete !== undefined && window.Settings.permissions_service_delete == 1) {
        urlDel = '<a href="' + window.location.protocol + '//' + window.location.host + '/services/destroy/' + cellvalue + '" class="table-action-link danger-action"><i class="fa fa-trash-o"></i></a>';
    }

    return url + urlDel;
}

function UserFormatEditColumn(cellvalue, options, rowObject)
{
    var url = window.location.protocol + '//' + window.location.host + '/users/edit/' + cellvalue;
    return '<a href="' + url + '" class="table-action-link"><i class="fa fa-pencil"></i></a>';
}

function ClientCategoryFormatEditColumn(cellvalue, options, rowObject)
{
    var url = '<a href="' + window.location.protocol + '//' + window.location.host + '/clientCategories/edit/' + cellvalue + '" class="table-action-link"><i class="fa fa-pencil"></i></a>';
    var urlDel = '<a href="' + window.location.protocol + '//' + window.location.host + '/clientCategories/destroy/' + cellvalue + '" class="table-action-link danger-action"><i class="fa fa-trash-o"></i></a>';

    return  url + urlDel;
}

function BranchFormatEditColumn(cellvalue, options, rowObject) {
    var url = '<a href="' + window.location.protocol + '//' + window.location.host + '/organization/edit/' + cellvalue + '" class="table-action-link"><i class="fa fa-pencil"></i></a>';

    return  url;
}