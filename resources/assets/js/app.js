
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
			message: 'Фотопортрет',
			image: '',
			filter_employee: 0,
			filter_service: 0,
			filter_start_time: '00:00',
			filter_end_time: '23:45',
			detailed_services_count: 0,
			detailed_products_count: 0,
			card_items_count: 0,
			services_ctgs_options: '',
			storage_options: ''
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
		this.card_items_count = $('#card-items').find('.wrap-it').length-1;

		if(this.detailed_services_count != 0) {
			$('a[href="#detailed-services"] .badge.label-danger').removeClass('hidden');
		}

		if(this.detailed_products_count != 0) {
			$('a[href="#detailed-products"] .badge.label-danger').removeClass('hidden');
		}

		if(this.card_items_count != 0) {
			$('a[href="#card-items"] .badge.label-danger').removeClass('hidden');
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

	// Clients grid functions
	if ($('#clients_grid').length ) {
		$("#clients_grid").jqGrid({
			url: '/clients/gridData',
			mtype: "GET",
			styleUI: 'Bootstrap',
			datatype: "json",
			colNames: ['ID', 'Имя', 'Контакты', 'Продано', 'Скидка'],
			colModel: [
				{index: 'client_id', name: 'client_id', key: true, width: 60, hidden: true, search: false},
				{index: 'name', name: 'name', width: 120, search: true, stype: 'text'},
				{index: 'phone', name: 'phone', width: 100, search: true, stype: 'text'},
				{index: 'total_bought', name: 'total_bought', width: 70, search: false},
				{index: 'discount', name: 'discount', width: 60, search: false}
			],
			sortname: 'name',
			sortorder: 'asc',
			viewrecords: true,
			height: 550,
			autowidth: true,
			shrinkToFit: true,
			rowNum: 10,
			pager: "#clients_grid_pager",
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
						//if ( console && console.log ) {
						//console.log( "Employees data:", data);
						//}

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
		colNames:['Категория', ' '],
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

	// Datepicker defaults
	$.datepicker.setDefaults({
		//language: 'ru',
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

	// CLIENT form
	$('#c_birthday').datepicker({
		autoclose: true,
		dateFormat: 'yy-mm-dd',
		firstDay: 1
	});
	// select2 multiple select init
	$(".js-select-basic-multiple").select2({
		placeholder: "Выберите категории",
		templateResult: formatClientCatColor,
		allowClear: true
	});
	function formatClientCatColor(cat) {
		if (!cat.id) { return cat.text; }
		var $category = $(
			'<span style="background-color:' + cat.element.getAttribute('data-color') + '">' + cat.text + '</span>'
		);
		return $category;
	};

	$('#card-items').on('click', '#add-card-item', function(e) {
		if($(e.target).val() !== 'Удалить') {
			$('#card-items').append(
				'<div class="wrap-it"><div class="col-sm-2"></div> <div class="col-sm-8" style="padding: 0px;"><div class="col-sm-5"><input maxlength="110" name="product_id[]" type="text" class="form-control"></div> <div class="col-sm-5"><select maxlength="110" name="storage_id[]" class="form-control"><option value="0" selected="selected">Новый</option><option value="1">Расходники</option><option value="2">Готовая продукция</option></select></div> <div class="col-sm-2"><input maxlength="110" name="amount[]" type="text" class="form-control"></div></div> <div class="col-sm-2" style="margin-bottom: 15px;"><input type="button" id="add-card-item" value="Добавить" class="btn btn-info"></div></div>');

			$('select.form-control[name="storage_id[]"]').last().find('option').remove();
			$('select.form-control[name="storage_id[]"]').last().append($('#storage_options').val());

			app.card_items_count++;
			$('a[href="#card-items"] .badge.label-danger').removeClass('hidden');
			$(e.target).val('Удалить');
			$(e.target).toggleClass('btn-info btn-danger')
			$(e.target).off();
			$(e.target).on('click', function(e) {
				$(e.target).parent().parent().remove();
				app.card_items_count--;
				if(app.card_items_count == 0) {
					$('a[href="#card-items"] .badge.label-danger').addClass('hidden');
				}
			});
		} else {
			$(e.target).parent().parent().remove();
			app.card_items_count--;
			if(app.card_items_count == 0) {
				$('a[href="#card-items"] .badge.label-danger').addClass('hidden');
			}
		}
	});

	$('#card-items').on('shown.bs.collapse', function(){
		$('a[href="#card-items"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
	});

	$('#card-items').on('hidden.bs.collapse', function(){
		$('a[href="#card-items"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
	});

	$('#detailed-services').on('click', '#add-detailed-section', function(e) {
		if( 'Удалить' !== $(e.target).val() ) {
			$('#detailed-services').prepend(
				'<div class="wrap-it"><div class="col-sm-2"></div>' +						
				'<div class="col-sm-8" style="padding: 0px;"><div class="col-sm-4"><select required="required" maxlength="110" name="services_cats_detailed[]" class="form-control"></select></div> <div class="col-sm-4"><select required="required" maxlength="110" name="services_detailed[]" class="form-control"><option value="">Выберите услугу</option></select></div> <div class="col-sm-2"><input required="required" maxlength="110" name="services_percent_detailed[]" type="text" class="form-control"></div> <div class="col-sm-2"><select required="required" maxlength="110" name="services_unit_detailed[]" class="form-control"><option value="rub" selected="selected">₽</option><option value="pct">%</option></select></div></div>' +
				'<div class="col-sm-2" style="margin-bottom: 15px"><input type="button" id="add-detailed-section" value="Добавить" class="btn btn-info"></div></div>');
			
			$('select.form-control[name="services_cats_detailed[]"]').first().find('option').remove();
			$('select.form-control[name="services_cats_detailed[]"]').first().append($('#service_ctgs_options').val());

			app.detailed_services_count++;

			$('a[href="#detailed-services"] .badge.label-danger').removeClass('hidden');
			$(e.target).val('Удалить');
			$(e.target).toggleClass('btn-info btn-danger')
			$(e.target).off();
			$(e.target).on('click', function(e) {
				$(e.target).parent().parent().remove();
				app.detailed_services_count--;
				if(app.detailed_services_count == 0) {
					$('a[href="#detailed-services"] .badge.label-danger').addClass('hidden');
				}
			});
		} else {
			$(e.target).parent().parent().remove();
			app.detailed_services_count--;
			if(app.detailed_services_count == 0) {
				$('a[href="#detailed-services"] .badge.label-danger').addClass('hidden');
			}
		}
	});

	$('#detailed-services').on('shown.bs.collapse', function(){
		$('a[href="#detailed-services"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
	});

	$('#detailed-services').on('hidden.bs.collapse', function(){
		$('a[href="#detailed-services"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
	});

	$('#detailed-products').on('click', '#add-detailed-section', function(e) {
		if($(e.target).val() !== 'Удалить') {
			$('#detailed-products').prepend(
				'<div class="wrap-it"><div class="col-sm-2"></div>' +						
				'<div class="col-sm-8" style="padding: 0px;"><div class="col-sm-4"><select required="required" maxlength="110" name="products_cats_detailed[]" class="form-control"><option value="0" selected="selected">Лаки</option><option value="1">Краски</option></select></div> <div class="col-sm-4"><select required="required" maxlength="110" name="products_detailed[]" class="form-control"><option value="0" selected="selected">LONDA</option><option value="1">WELLA</option></select></div> <div class="col-sm-2"><input required="required" maxlength="110" name="products_percent_detailed[]" type="text" class="form-control"></div> <div class="col-sm-2"><select required="required" maxlength="110" name="products_unit_detailed[]" class="form-control"><option value="rub" selected="selected">₽</option><option value="pct">%</option></select></div></div>' +
				'<div class="col-sm-2" style="margin-bottom: 15px"><input type="button" id="add-detailed-section" value="Добавить" class="btn btn-info"></div></div>');
			
			$('select.form-control[name="products_cats_detailed[]"]').first().find('option').remove();
			$('select.form-control[name="products_cats_detailed[]"]').first().append($('#product_ctgs_options').val());

			app.detailed_products_count++;
			
			$('a[href="#detailed-products"] .badge.label-danger').removeClass('hidden');
			$(e.target).val('Удалить');
			$(e.target).toggleClass('btn-info btn-danger')
			$(e.target).off();
			$(e.target).on('click', function(e) {
				$(e.target).parent().parent().remove();
				app.detailed_products_count--;
				if(app.detailed_products_count == 0) {
					$('a[href="#detailed-products"] .badge.label-danger').addClass('hidden');
				}
			});
		} else {
			$(e.target).parent().parent().remove();
			app.detailed_products_count--;
			if(app.detailed_products_count == 0) {
				$('a[href="#detailed-products"] .badge.label-danger').addClass('hidden');
			}
		}
	});

	$('#detailed-products').on('shown.bs.collapse', function(){
		$('a[href="#detailed-products"] .fa.fa-caret-down').toggleClass('fa-caret-down fa-caret-up');
	});

	$('#detailed-products').on('hidden.bs.collapse', function(){
		$('a[href="#detailed-products"] .fa.fa-caret-up').toggleClass('fa-caret-up fa-caret-down');
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

	$(function () {
		$.fn.datepicker.dates['ru'] = {
			days: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
			daysShort: ["Вск", "Пнд", "Втр", "Срд", "Чтв", "Птн", "Суб"],
			daysMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
			months: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
			monthsShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
			today: "Сегодня",
			clear: "Очистить",
			format: "dd.mm.yyyy",
			weekStart: 1,
		monthsTitle: 'Месяцы'
		};

		$('#dp').datepicker({
			language: 'ru',
			format: 'yyyy-mm-dd',
			startDate: '19/01/2017'
		});
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

function ClientCategoryFormatEditColumn(cellvalue, options, rowObject)
{
	var url = '<a href="' + window.location.protocol + '//' + window.location.host + '/clientCategories/edit/' + cellvalue + '" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
	var urlDel = '<a href="' + window.location.protocol + '//' + window.location.host + '/clientCategories/destroy/' + cellvalue + '" class="btn btn-default"><i class="fa fa-trash-o"></i></a>';

	return  url + urlDel;
}
