
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
            { index: 'gender', name: 'gender', width: 90 },
        ],
        sortname: 'name',
        sortorder: 'asc',
        viewrecords: true,
        height: 300,
        width: 740,
        rowNum: 3,
        pager: "#service_categories_grid_pager"
    });
});