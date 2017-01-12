
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

const app = new Vue({
	el: '#app',
	data: {
		message: 'Фотопортрет',
		image: '',
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
		}
	}
});

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function () {
	$("#service_categories_grid").jqGrid({
		url: '/serviceCategories/gridData',
		mtype: "GET",
		styleUI : 'Bootstrap',
		datatype: "json",
		colNames:['Управление', 'Название', 'Название для онлайн регистрации', 'Пол'],
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
		colNames:['Управление', 'Название', 'Категория услуг', 'Описание', 'Мин. цена', 'Макс. цена', 'Длительность'],
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

	$("#users_grid").jqGrid({
		url: '/users/gridData',
		mtype: "GET",
		styleUI : 'Bootstrap',
		datatype: "json",
		colNames:['Управление', 'Имя', 'Телефон', 'Email'],
		colModel: [
			{ index: 'user_id', name: 'user_id', key: true, width: 60, formatter:UserFormatEditColumn },
			{ index: 'name', name: 'name', width: 100 },
			{ index: 'phone', name: 'phone', width: 100 },
			{ index: 'email', name: 'email', width: 100 }
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

	// Replace the <textarea id="o_info"> with a CKEditor instance, using default configuration.
	if ($('#o_info').length ) {
		CKEDITOR.replace('o_info');
	}

	// Datepicker defaults
	$.datepicker.setDefaults({
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		autoclose: true
	});

	// APPOINTMENT FORM
	$('#app_date_from').datepicker({
		autoclose: true,
		dateFormat: 'yy-mm-dd',
		firstDay: 1
	});
	// Service dropdown change event
	$('#app_service_id').change(function() {
		// удаляем все опции из селекта с сотрудниками
		$("#app_employee_id option").each(function() {
			$(this).remove();
		});

		var that = this;
		$.ajax({
			type: "POST",
			url: "/appointments/getEmployeesForService/"+$(that).val(),
			data: {},
			success: function(data) {
				var data = $.parseJSON(data);
				//if ( console && console.log ) {
					//console.log( "Employees data:", data);
				//}

				for (var i in data) {
					$('<option>').val(data[i].value).text(data[i].label).appendTo('#app_employee_id');
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Server error:'+textStatus);
			}
		});
	});
	$('#app_client_phone').blur(function() {
		if($("#app_client_info_container").length == 0) {
			return;
		}

		$('#app_client_info_container').html('');
		var that = this;
		$.ajax({
			type: "POST",
			dataType: 'html',
			url: "/appointments/getClientInfo/",
			data: {phone: $(that).val()},
			success: function(data) {
				if (data.length>0) {
					$('#app_client_info_container').html(data);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Server error:'+textStatus);
			}
		});
	});

	// Appointment form submit
	$("#appointment_form").on("submit", function (e) {
		e.preventDefault();

		if ($('#app_state').length) {
			$('#app_state').remove();
		}

		var btnLabel = '';

		var selectedTab = $('#appointment_tabs_header li.active a');
		if (selectedTab.length > 0) {
			var selectedTabId = $(selectedTab[0]).attr('href');
			if (selectedTabId == '#tab_client_wait') {
				var stateVal = 'created';
			} else if (selectedTabId == '#tab_client_came') {
				var stateVal = 'finished';
			} else if (selectedTabId == '#tab_client_didnt_came') {
				var stateVal = 'failed';
			} else if (selectedTabId == '#tab_client_confirm') {
				var stateVal = 'confirmed';
			}
		}

		if (stateVal !== undefined) {
			$('<input>').attr({
				type: 'hidden',
				id: 'app_state',
				name: 'state',
				value: stateVal
			}).appendTo('#appointment_form');
		}

		$.ajax({
			type: "POST",
			url: "/appointments/save",
			data: $("#appointment_form").serialize(),
			beforeSend: function() {
				//$('#result').html('<img src="loading.gif" />');
				var btn = $('#btn_submit_app_form');
				btnLabel = $(btn).val();
				$(btn).prop('disabled', true);
				$(btn).val("Сохранение...");	// localize
			},
			success: function(data) {
				//$('#result').html(data);
				var btn = $('#btn_submit_app_form');
				$(btn).val(btnLabel);
				$(btn).prop('disabled', false);
				alert("Saved");
			},
			error: function(data) {
				var btn = $('#btn_submit_app_form');
				$(btn).val(btnLabel);
				$(btn).prop('disabled', false);
				alert("Error");
			}
		});
	});

	$('#form_submit').on('click', function() {
		var activeTab = $('ul.nav.nav-tabs li.active a').attr('href');

		if(activeTab == '#menu1') {
			$('#employee_form__info').submit();
		}

		if(activeTab == '#menu2') {
			$('#employee_form__services').submit();
		}
		
		if(activeTab == '#menu3') {
			$('#employee_form__schedule').submit();
		}

		if(activeTab == '#menu4') {
			$('#employee_form__settings').submit();
		}

		if(activeTab == '#menu5') {
			$('#employee_form__wage').submit();
		}
	});

	// $('#avatar_upload_form__filename').on('change', function() {
	// 	$('#avatar_upload_form').submit();
	// });

	$(function () {
		$('#dp').datepicker(
			{language: 'ru'}
		);
	});

	var hash = window.location.hash;

	$('ul.nav.nav-tabs li a[href="' + hash + '"]').tab('show');

	$('#employee_form__info').removeClass('hidden');

	return false;
});

function ServiceCategoryFormatEditColumn(cellvalue, options, rowObject)
{
	var url = '';
	var urlDel = '';

	if (window.Settings.permissions_service_edit !== undefined && window.Settings.permissions_service_edit == 1) {
		url = '<a href="' + window.location.protocol + '//' + window.location.host + '/serviceCategories/edit/' + cellvalue + '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
	}
	if (window.Settings.permissions_service_delete !== undefined && window.Settings.permissions_service_delete == 1) {
		urlDel = '<a href="' + window.location.protocol + '//' + window.location.host + '/serviceCategories/destroy/' + cellvalue + '" class="btn btn-default"><i class="fa fa-trash-o"></i></a>';
	}

	return url + urlDel;
}

function ServiceFormatEditColumn(cellvalue, options, rowObject)
{
	var url = '';
	var urlDel = '';

	if (window.Settings.permissions_service_edit !== undefined && window.Settings.permissions_service_edit == 1) {
		url = '<a href="' + window.location.protocol + '//' + window.location.host + '/services/edit/' + cellvalue + '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
	}
	if (window.Settings.permissions_service_delete !== undefined && window.Settings.permissions_service_delete == 1) {
		urlDel = '<a href="' + window.location.protocol + '//' + window.location.host + '/services/destroy/' + cellvalue + '" class="btn btn-default"><i class="fa fa-trash-o"></i></a>';
	}

	return url + urlDel;
}

function UserFormatEditColumn(cellvalue, options, rowObject)
{
	var url = window.location.protocol + '//' + window.location.host + '/users/edit/' + cellvalue;
	return '<a href="' + url + '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
}
