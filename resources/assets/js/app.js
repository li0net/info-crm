
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

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});


$(document).ready(function () {
    $("#service_categories_grid").jqGrid({
        url: '/serviceCategories/gridData',
        mtype: "GET",
        styleUI : 'Bootstrap',
        datatype: "json",
        colNames:['ID', 'Название', 'Название для онлайн регистрации', 'Пол'],
        colModel: [
            { index: 'service_category_id', name: 'service_category_id', key: true, hidden: true, width: 75 },
            { index: 'name', name: 'name', width: 140 },
            { index: 'online_reservation_name', name: 'online_reservation_name', width: 250 },
            { index: 'gender', name: 'gender', width: 90, edittype:'select', formatter:'select', editoptions:{value:"1:Мужчины;0:Женщины;null:Все"} },
        ],
        sortname: 'name',
        sortorder: 'asc',
        viewrecords: true,
        height: 320,
        width: 740,
        rowNum: 10,
        pager: "#service_categories_grid_pager"
    });

    $("#services_grid").jqGrid({
        url: '/services/gridData',
        mtype: "GET",
        styleUI : 'Bootstrap',
        datatype: "json",
        colNames:['ID', 'Название', 'Категория услуг', 'Описание', 'Мин. цена', 'Макс. цена', 'Длительность'],
        colModel: [
            { index: 'service_id', name: 'service_id', key: true, hidden: true, width: 75 },
            { index: 'name', name: 'name', width: 110 },
            { index: 'service_category_id', name: 'service_category_id', width: 120 },
            { index: 'description', name: 'description', width: 150 },
            { index: 'price_min', name: 'price_min', formatter:'currency', width: 70 },
            { index: 'price_max', name: 'price_max', formatter:'currency', width: 70 },
            { index: 'duration', name: 'duration', formatter:'date', formatoptions:{srcformat:"H:i:s", newformat:"G:i", decimalPlaces: 2, prefix: "$ "}, width: 70 }
        ],
        sortname: 'name',
        sortorder: 'asc',
        viewrecords: true,
        height: 380,
        width: 740,
        rowNum: 10,
        pager: "#services_grid_pager"
    });
});