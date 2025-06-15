<script>

	$('.select2').select2();

	(function($) {
		"use strict";

		$(".checkbox #filter_all_simple_variation").change(function() {
			if(this.checked) {
				$('input[name="filter_all_simple_variation_value"]').val('true');
			}else{
				$('input[name="filter_all_simple_variation_value"]').val('false');
			}
		});

		var ProposalServerParams = {
			"warehouse_ft": "[name='warehouse_filter[]']",
			"commodity_ft": "[name='commodity_filter[]']",
			"alert_filter": "[name='alert_filter']",
			"item_filter": "[name='item_filter[]']",
			"parent_item": "[name='parent_item_filter']",
			"filter_all_simple_variation": "[name='filter_all_simple_variation_value']",
			"can_be_value_filter": "[name='can_be_value_filter[]']",
		};
		var table_commodity_list = $('table.table-table_commodity_list');
		var _table_api = initDataTable(table_commodity_list,"<?php echo get_uri("warehouse/table_commodity_list") ?>", [0], [0], ProposalServerParams,  [1, 'desc']);
		$.each(ProposalServerParams, function(i, obj) {
			$('select' + obj).on('change', function() {  
				table_commodity_list.DataTable().ajax.reload();
			});
		});

		$('#filter_all_simple_variation').on('change', function() {
			table_commodity_list.DataTable().ajax.reload();
		});
	})(jQuery);



	$("body").on('change', '#mass_select_all', function () {
		"use strict";

		var to, rows, checked;
		to = $(this).data('to-table');

		rows = $('.table-' + to).find('tbody tr');
		checked = $(this).prop('checked');
		$.each(rows, function () {
			$($(this).find('td').eq(0)).find('input').prop('checked', checked);
		});
	});
	

	function staff_bulk_actions(){
		"use strict";
		$('#table_commodity_list_bulk_actions').modal('show');
	}

	//update
	$('input[id="mass_delete"]').on('click', function() {
		"use strict";
		
		var mass_delete = $('input[id="mass_delete"]').is(":checked");


		if(mass_delete){

			$('input[id="change_item_selling_price"]').prop("checked", false);
			$('input[name="selling_price"]').val('');

			$('input[id="change_item_purchase_price"]').prop("checked", false);
			$('input[name="purchase_price"]').val('');
			$('input[id="clone_items"]').prop("checked", false);
		}

	});

	$('input[id="change_item_selling_price"]').on('click', function() {
		"use strict";
		
		var item_selling_price_checking = $('input[id="change_item_selling_price"]').is(":checked");


		if(item_selling_price_checking){
			$('input[id="mass_delete"]').prop("checked", false);

			$('input[id="change_item_purchase_price"]').prop("checked", false);
			$('input[name="purchase_price"]').val('');
			$('input[id="clone_items"]').prop("checked", false);
		}

	});

	$('input[id="change_item_purchase_price"]').on('click', function() {
		"use strict";
		
		var item_selling_purchase_checking = $('input[id="change_item_purchase_price"]').is(":checked");

		if(item_selling_purchase_checking){
			$('input[id="mass_delete"]').prop("checked", false);

			$('input[id="change_item_selling_price"]').prop("checked", false);
			$('input[name="selling_price"]').val('');
			$('input[id="clone_items"]').prop("checked", false);
		}

	});

	$('input[id="clone_items"]').on('click', function() {
		"use strict";
		
		var clone_items = $('input[id="clone_items"]').is(":checked");


		if(clone_items){

			$('input[id="change_item_selling_price"]').prop("checked", false);
			$('input[name="selling_price"]').val('');

			$('input[id="change_item_purchase_price"]').prop("checked", false);
			$('input[name="purchase_price"]').val('');

			$('input[id="mass_delete"]').prop("checked", false);
		}

	});

// Leads bulk action
function warehouse_delete_bulk_action(event) {
	"use strict";

	var mass_delete = $('#mass_delete').prop('checked');
	var change_item_selling_price = $('#change_item_selling_price').prop('checked');
	var change_item_purchase_price = $('#change_item_purchase_price').prop('checked');
	var clone_items = $('#clone_items').prop('checked');

	var selling_price = $('input[name="selling_price"]').val();
	var purchase_price = $('input[name="b_purchase_price"]').val();


	if(mass_delete == true || ( change_item_selling_price == true && selling_price != '') || ( change_item_purchase_price == true && purchase_price != '') || clone_items == true){
		var ids = [];
		var data = {};

		if(change_item_selling_price){
			data.change_item_selling_price = true;
			data.rel_type = 'change_item_selling_price';
			data.selling_price = selling_price;
			data.clone_items = false;
			data.mass_delete = false;

		}else if(change_item_purchase_price){
			data.change_item_purchase_price = true;
			data.rel_type = 'change_item_purchase_price';
			data.purchase_price = purchase_price;
			data.clone_items = false; 
			data.mass_delete = false;

		}else if(clone_items){
			data.mass_delete = false;
			data.rel_type = 'commodity_list';
			data.clone_items = true;
			data.change_item_selling_price = false;
			data.change_item_purchase_price = false;
		}else{
			data.mass_delete = true;
			data.rel_type = 'commodity_list';
			data.clone_items = false;
			data.change_item_selling_price = false;
			data.change_item_purchase_price = false;
		}

		var rows = $('#table-table_commodity_list').find('tbody tr');
		$.each(rows, function() {
			var checkbox = $($(this).find('td').eq(0)).find('input');
			if (checkbox.prop('checked') === true) {
				ids.push(checkbox.val());
			}
		});

		data.ids = ids;
		$(event).addClass('disabled');
		setTimeout(function() {

			$.post("<?php echo get_uri("warehouse/warehouse_delete_bulk_action") ?>", data).done(function() {

				window.location.reload();
			}).fail(function(data) {
				$('#table_commodity_list_bulk_actions').modal('hide');
				appAlert.warning(data.responseText);
			});
		}, 200);
	}else{
		window.location.reload();
	}
}

function staff_export_item(){
	"use strict";
	var ids = [];
	var data = {};

	data.mass_delete = true;
	data.rel_type = 'commodity_list';

	var rows = $('#table-table_commodity_list').find('tbody tr');
	$.each(rows, function() {
		var checkbox = $($(this).find('td').eq(0)).find('input');
		if (checkbox.prop('checked') === true) {
			ids.push(checkbox.val());
		}
	});

	data.ids = ids;
	$(event).addClass('disabled');
	setTimeout(function() {

		$.post("<?php echo get_uri("warehouse/warehouse_export_item_checked") ?>", data).done(function(response) {
			response = JSON.parse(response);
			if(response.success == true){
				appAlert.success("<?php echo _l("create_export_file_success") ?>");

				$('#dowload_items').removeClass('hide');

				$('#dowload_items').attr({target: '_blank', 
					href  : response.base_url+"\\"+response.filename});
			}else{
				appAlert.success("<?php echo _l("create_export_file_false") ?>");
			}
		}).fail(function(data) {

		});
	}, 200);
}

function print_barcode_option(invoker) {
	"use strict";
	var data={};
	data.profit_rate_by_purchase_price_sale = invoker.value;

	if(invoker.value == 1){
		$('.display-select-item').removeClass('hide');
	}else if(invoker.value == 0){
		$('.display-select-item').addClass('hide');
	}
}


/*print barcode*/
function print_barcode_bulk_actions(){
	"use strict";
	$('.display-select-item').addClass('hide');
	$("#y_opt_1_").prop("checked", true);

	$("#table_commodity_list_print_barcode option:selected").prop("selected", false).change()
	$("table_commodity_list_print_barcode select[id='item_select_print_barcode']");

	$('#table_commodity_list_print_barcode').modal('show');
}


 // Leads bulk action
 function warehouse_print_barcode_action(event) {
 	"use strict";

 	if (confirm_delete()) {
 		var mass_delete = $('#mass_delete').prop('checked');

 		if(mass_delete == true){
 			var ids = [];
 			var data = {};

 			data.mass_delete = true;
 			data.rel_type = 'commodity_list';

 			var rows = $('#table-table_commodity_list').find('tbody tr');
 			$.each(rows, function() {
 				var checkbox = $($(this).find('td').eq(0)).find('input');
 				if (checkbox.prop('checked') === true) {
 					ids.push(checkbox.val());
 				}
 			});

 			data.ids = ids;
 			$(event).addClass('disabled');
 			setTimeout(function() {

 				$.post("<?php echo get_uri("warehouse/warehouse_delete_bulk_action") ?>", data).done(function() {
 					window.location.reload();
 				}).fail(function(data) {
 					$('#table_commodity_list_print_barcode').modal('hide');
 					appAlert.warning(data.responseText);
 				});
 			}, 200);
 		}else{
 			window.location.reload();
 		}

 	}
 }


</script>
