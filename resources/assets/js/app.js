
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

// const app = new Vue({
// 	el: '#app'
// });

$(document).ready(function () {
    $("#service_categories_grid").jqGrid({
        url: '/serviceCategories/gridData',
        mtype: "GET",
        styleUI : 'Bootstrap',
        datatype: "json",
        colNames:['Редактировать', 'Название', 'Название для онлайн регистрации', 'Пол'],
        colModel: [
            { index: 'service_category_id', name: 'service_category_id', key: true, width: 50, formatter:ServiceCategoryFormatEditColumn },
            { index: 'name', name: 'name', width: 130 },
            { index: 'online_reservation_name', name: 'online_reservation_name', width: 150 },
            { index: 'gender', name: 'gender', width: 80, edittype:'select', formatter:'select', editoptions:{value:"1:Мужчины;0:Женщины;null:Все"} },
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
        colNames:['Редактировать', 'Название', 'Категория услуг', 'Описание', 'Мин. цена', 'Макс. цена', 'Длительность'],
        colModel: [
            { index: 'service_id', name: 'service_id', key: true, width: 60, formatter:ServiceFormatEditColumn },
            { index: 'name', name: 'name', width: 110 },
            { index: 'service_category_id', name: 'service_category_id', width: 110 },
            { index: 'description', name: 'description', width: 160 },
            { index: 'price_min', name: 'price_min', formatter:'currency', width: 70 },
            { index: 'price_max', name: 'price_max', formatter:'currency', width: 70 },
            { index: 'duration', name: 'duration', formatter:'date', formatoptions:{srcformat:"H:i:s", newformat:"G:i", decimalPlaces: 2, prefix: "$ "}, width: 70 }
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

    // Replace the <textarea id="o_info"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'o_info');
});

function ServiceCategoryFormatEditColumn(cellvalue, options, rowObject)
{
    var url = window.location.protocol + '//' + window.location.host + '/serviceCategories/edit/' + cellvalue;
    return '<a href="' + url + '" class="btn btn-default">Редактировать</a>';
}

function ServiceFormatEditColumn(cellvalue, options, rowObject)
{
    var url = window.location.protocol + '//' + window.location.host + '/services/edit/' + cellvalue;
    return '<a href="' + url + '" class="btn btn-default">Редактировать</a>';
}
