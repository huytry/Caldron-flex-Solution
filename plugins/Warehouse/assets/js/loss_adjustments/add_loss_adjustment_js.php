<script>
	$(document).ready(function () {
		setDatePicker("#time");
		setDatePicker(".datePickerInput");
		
		$(".select2").select2();

	});

	var lastAddedItemKey = null;
	(function($) {
		"use strict";
		/* Maybe items ajax search*/
		init_ajax_search('items','#item_select.ajax-search',undefined, "<?php echo get_uri("warehouse/wh_commodity_code_search") ?>");
		wh_calculate_total();

	})(jQuery); 



	(function($) {
		"use strict"; 
		/*Add item to preview from the dropdown for invoices estimates*/
		$("body").on('change', 'select[name="item_select"]', function () {
			if ($('select[name="warehouses"]').val() === '' && $(this).val() != 0) {
				alert('You need to select warehouse');
				$('html,body').animate({
					scrollTop: 0
				}, 'slow');
				return false;
			}

			if ($(this).valid() === true) {

				var itemid = $('select[name="item_select"]').val();
				if (itemid != '') {
					wh_add_item_to_preview(itemid);
				}
			}

		});

		/*Recaulciate total on these changes*/
		$("body").on('change', 'select.taxes', function () {
			wh_calculate_total();
		});

		$('.save_detail').on('click', function() {
			submit_form(false);
		});

		$('input[name="lot_number"]').on('change', function() {
			"use strict"; 

			var commodity_id = $('.main input[name="items"]').val();
			var warehouse_id = $('select[name="warehouses"]').val();
			var lot_number = $('.main input[name="lot_number"]').val();
			var expiry_date = $('.main input[name="expiry_date"]').val();
			
			var available_quantity = loss_adjustment_get_available_quantity(warehouse_id, commodity_id, lot_number, expiry_date);
			$('.main input[name="current_number"]').val(parseFloat(available_quantity));
		});

		$('input[name="expiry_date"]').on('change', function() {
			"use strict"; 

			var commodity_id = $('.main input[name="items"]').val();
			var warehouse_id = $('select[name="warehouses"]').val();
			var lot_number = $('.main input[name="lot_number"]').val();
			var expiry_date = $('.main input[name="expiry_date"]').val();
			
			var available_quantity = loss_adjustment_get_available_quantity(warehouse_id, commodity_id, lot_number, expiry_date);
			$('.main input[name="current_number"]').val(parseFloat(available_quantity));

		});


		$('input[name="updates_number"]').on('change', function() {
			"use strict"; 

			var current_number = $('.main input[name="current_number"]').val();
			var updates_number = $('.main input[name="updates_number"]').val();
			var type = $('select[name="type"]').val();

			if(type == 'loss'){
				if(parseFloat(current_number) < parseFloat(updates_number)){
					appAlert.warning("<?php echo _l('Please_enter_the_actual_quantity_smaller_than_the_quantity_in_stock') ?>");
				}
			}else if(type == 'adjustment'){
				if(parseFloat(current_number) > parseFloat(updates_number)){
					appAlert.warning("<?php echo _l('Please_enter_the_actual_quantity_larger_than_the_quantity_in_stock') ?>");
				}
			}else{
				appAlert.warning("<?php echo _l('Please_select_lost_adjustment_type') ?>");
			}
		});


	})(jQuery);

	/*Add item to preview*/
	function wh_add_item_to_preview(id) {
		"use strict"; 

		var warehouse_id = $('select[name="warehouses"]').val();
		requestGetJSON("<?php  echo get_uri('warehouse/get_item_by_id/') ?>" + id +'/'+1+'/'+warehouse_id).done(function (response) {
			wh_clear_item_preview_values();

			$('.main input[name="items"]').val(response.itemid);
			$('.main textarea[name="commodity_name"]').val(response.code_description);
			$('.main input[name="unit_name"]').val(response.unit_name);
			$('.main input[name="unit"]').val(response.unit_id);
			$('.main input[name="current_number"]').val(response.available_quantity);
			$('.main input[name="updates_number"]').val('');

			var taxSelectedArray = [];
			if (response.taxname && response.taxrate) {
				taxSelectedArray.push(response.taxname + '|' + response.taxrate);
			}
			if (response.taxname_2 && response.taxrate_2) {
				taxSelectedArray.push(response.taxname_2 + '|' + response.taxrate_2);
			}

			$('.main select.taxes').val(taxSelectedArray).change();

			$(document).trigger({
				type: "item-added-to-preview",
				item: response,
				item_type: 'item',
			});
		});
	}


	function wh_add_item_to_table(data, itemid) {
		"use strict"; 

		data = typeof (data) == 'undefined' || data == 'undefined' ? wh_get_item_preview_values() : data;

		if (data.available_quantity == "" || data.quantities == "" || data.commodity_code == "" ) {
			return;
		}
		var type = $('select[name="type"]').val();
		if(type == 'loss'){
			if(parseFloat(data.available_quantity) < parseFloat(data.quantities)){
				appAlert.warning("<?php echo _l('Please_enter_the_actual_quantity_smaller_than_the_quantity_in_stock') ?>");
				return;
			}
		}else if(type == 'adjustment'){
			if(parseFloat(data.available_quantity) > parseFloat(data.quantities)){
				appAlert.warning("<?php echo _l('Please_enter_the_actual_quantity_larger_than_the_quantity_in_stock') ?>");
				return;
			}
		}else{
			if(type == ''){
				appAlert.warning("<?php echo _l('Please_select_lost_adjustment_type') ?>");
				return;
			}
		}

		var table_row = '';
		var item_key = lastAddedItemKey ? lastAddedItemKey += 1 : $("body").find('.invoice-items-table tbody .item').length + 1;
		lastAddedItemKey = item_key;
		$("body").append('<div class="dt-loader"></div>');
		wh_get_item_row_template('newitems[' + item_key + ']',data.commodity_name, data.lot_number, data.expiry_date, data.available_quantity, data.quantities, data.unit_name, data.commodity_code, data.unit_id, itemid).done(function(output){
			table_row += output;

			$('.invoice-item table.invoice-items-table.items tbody').append(table_row);

			setTimeout(function () {
				wh_calculate_total();
			}, 15);

			wh_reorder_items('.invoice-item');
			wh_clear_item_preview_values('.invoice-item');
			$('body').find('#items-warning').remove();
			$("body").find('.dt-loader').remove();
			$('#item_select').val('');

			/*open serial modal*/
			if(type == 'loss'){
				var quantity = parseFloat(data.available_quantity) - parseFloat(data.quantities);
				loss_fill_multiple_serial_number_modal(quantity, 'newitems[' + item_key + ']', 'add');
			}else if(type == 'adjustment'){
				var quantity =  parseFloat(data.quantities) - parseFloat(data.available_quantity);
				adjustment_fill_multiple_serial_number_modal(quantity, 'newitems[' + item_key + ']', 'add');
			}

			return true;
		});
		return false;
	}

	function wh_get_item_preview_values() {
		"use strict"; 

		var response = {};
		response.commodity_name = $('.invoice-item .main textarea[name="commodity_name"]').val();
		response.lot_number = $('.invoice-item .main input[name="lot_number"]').val();
		response.expiry_date = $('.invoice-item .main input[name="expiry_date"]').val();
		response.available_quantity = $('.invoice-item .main input[name="current_number"]').val();
		response.quantities = $('.invoice-item .main input[name="updates_number"]').val();
		response.unit_name = $('.invoice-item .main input[name="unit_name"]').val();
		response.commodity_code = $('.invoice-item .main input[name="items"]').val();
		response.unit_id = $('.invoice-item .main input[name="unit"]').val();

		return response;
	}

	function wh_clear_item_preview_values(parent) {
		"use strict"; 

		var taxSelectedArray = [];
		$('.main select.taxes').val(taxSelectedArray).change();
		$('.main input').val('');
		$('.main textarea').val('');

	}

	function wh_get_item_row_template(name, commodity_name, lot_number, expiry_date, available_quantity, quantities, unit_name, commodity_code, unit_id, item_key)  {
		"use strict"; 

		jQuery.ajaxSetup({
			async: false
		});

		var d = $.post("<?php echo get_uri("warehouse/get_loss_adjustment_row_template") ?>", {
			name: name,
			commodity_name : commodity_name,
			expiry_date : expiry_date,
			lot_number : lot_number,
			available_quantity : available_quantity,
			quantities : quantities,
			unit_name : unit_name,
			commodity_code : commodity_code,
			unit_id : unit_id,
			item_key : item_key
		});
		jQuery.ajaxSetup({
			async: true
		});
		return d;
	}

	function wh_delete_item(row, itemid,parent) {
		"use strict"; 

		$(row).parents('tr').remove();
		wh_calculate_total();

		if (itemid && $('input[name="isedit"]').length > 0) {
			$(parent+' #removed-items').append(hidden_input('removed_items[]', itemid));
		}
	}

	function wh_reorder_items(parent) {
		"use strict"; 

		var rows = $(parent + ' .table.has-calculations tbody tr.item');
		var i = 1;
		$.each(rows, function () {
			$(this).find('input.order').val(i);
			i++;
		});
	}

	function wh_calculate_total(){
		"use strict";

		if ($('body').hasClass('no-calculate-total')) {
			return false;
		}

		if (AppHelper.settings.noOfDecimals == "0") {
			var decimal_places  = 0; /*round it and the add static 2 decimals*/
		} else {
			var decimal_places  = 2;
		}

		var calculated_tax,
		taxrate,
		item_taxes,
		row,
		_amount,
		_tax_name,
		taxes = {},
		taxes_rows = [],
		subtotal = 0,
		total = 0,
		total_tax_money = 0,
		quantity = 1,
		total_discount_calculated = 0,
		rows = $('.table.has-calculations tbody tr.item'),
		subtotal_area = $('#subtotal'),
		discount_area = $('#discount_area'),
		adjustment = $('input[name="adjustment"]').val(),
		discount_percent = 'before_tax',
		discount_fixed = $('input[name="discount_total"]').val(),
		discount_total_type = $('.discount-total-type.selected'),
		discount_type = $('select[name="discount_type"]').val(),
		total_row =  0;

		$('.wh-tax-area').remove();

		$.each(rows, function () {
			total_row++;

			quantity = $(this).find('[data-quantity]').val();
			if (quantity === '') {
				quantity = 1;
				$(this).find('[data-quantity]').val(1);
			}

			_amount = parseFloat($(this).find('td.rate input').val() * quantity).toFixed(decimal_places)
			_amount = parseFloat(_amount);

			$(this).find('td.amount').html(toCurrency(_amount));

			subtotal += _amount;
			row = $(this);
			item_taxes = $(this).find('select.taxes').val();
			$(this).find('td.into_money input').val($(this).find('td.rate input').val() * quantity);

			if (item_taxes) {
				$.each(item_taxes, function (i, taxname) {
					taxrate = row.find('select.taxes [value="' + taxname + '"]').data('taxrate');
					calculated_tax = (_amount / 100 * taxrate);
					if (!taxes.hasOwnProperty(taxname)) {
						if (taxrate != 0) {
							_tax_name = taxname.split('|');
							var tax_row = '<tr class="wh-tax-area"><td>' + _tax_name[0] + '(' + taxrate + '%)</td><td id="tax_id_' + slugify(taxname) + '"></td></tr>';
							$(subtotal_area).after(tax_row);
							taxes[taxname] = calculated_tax;
						}
					} else {
						/*Increment total from this tax*/
						taxes[taxname] = taxes[taxname] += calculated_tax;
					}
				});
			}
		});

		/*Discount by percent*/
		if ((discount_percent !== '' && discount_percent != 0) && discount_type == 'before_tax' && discount_total_type.hasClass('discount-type-percent')) {
			total_discount_calculated = (subtotal * discount_percent) / 100;
		} else if ((discount_fixed !== '' && discount_fixed != 0) && discount_type == 'before_tax' && discount_total_type.hasClass('discount-type-fixed')) {
			total_discount_calculated = discount_fixed;
		}

		$.each(taxes, function (taxname, total_tax) {
			if ((discount_percent !== '' && discount_percent != 0) && discount_type == 'before_tax' && discount_total_type.hasClass('discount-type-percent')) {
				total_tax_calculated = (total_tax * discount_percent) / 100;
				total_tax = (total_tax - total_tax_calculated);
			} else if ((discount_fixed !== '' && discount_fixed != 0) && discount_type == 'before_tax' && discount_total_type.hasClass('discount-type-fixed')) {
				var t = (discount_fixed / subtotal) * 100;
				total_tax = (total_tax - (total_tax * t) / 100);
			}

			total += total_tax;
			total_tax_money += total_tax;
			total_tax = toCurrency(total_tax);
			$('#tax_id_' + slugify(taxname)).html(total_tax);
		});

		total = (total + subtotal);

		/*Discount by percent*/
		if ((discount_percent !== '' && discount_percent != 0) && discount_type == 'after_tax' && discount_total_type.hasClass('discount-type-percent')) {
			total_discount_calculated = (total * discount_percent) / 100;
		} else if ((discount_fixed !== '' && discount_fixed != 0) && discount_type == 'after_tax' && discount_total_type.hasClass('discount-type-fixed')) {
			total_discount_calculated = discount_fixed;
		}

		total = total - total_discount_calculated;
		adjustment = parseFloat(adjustment);

		/*Check if adjustment not empty*/
		if (!isNaN(adjustment)) {
			total = total + adjustment;
		}

		var discount_html = '-' + toCurrency(total_discount_calculated);
		$('input[name="discount_total"]').val(parseFloat(total_discount_calculated).toFixed(decimal_places));

		/*Append, format to html and display*/
		$('.discount-total').html(discount_html);
		$('.adjustment').html(toCurrency(adjustment));

		$('.wh-total').html(toCurrency(total) + hidden_input('total_amount', parseFloat(total).toFixed(decimal_places)));
		if(total_row == 0){
			$('#warehouses').attr("disabled", false); 
		}else{
			$('#warehouses').attr("disabled", true); 
		}

		$(document).trigger('wh-loss-adjustment-total-calculated');

	}



	function submit_form(save_and_send_request) {
		"use strict"; 

		wh_calculate_total();

		var $itemsTable = $('.invoice-items-table');
		var $previewItem = $itemsTable.find('.main');

		if ( $itemsTable.length && $itemsTable.find('.item').length === 0) {
			appAlert.warning("<?php echo _l('wh_enter_at_least_one_product') ?>");
			return false;
		}

		var rows = $('.table.has-calculations tbody tr.item');
		var check_quantity = true,
		check_available_quantity = true,
		check_the_same_available_quantity = true;

		$.each(rows, function () {
			var available_quantity_value = $(this).find('td.available_quantity input').val();
			var quantity_value = $(this).find('td.quantities input').val();

			
			if(parseFloat(available_quantity_value) == 0){
				check_available_quantity = false;
			}
			if(parseFloat(available_quantity_value) == parseFloat(quantity_value) ){
				check_the_same_available_quantity = false;
			}

		})

		if(check_available_quantity == true && check_the_same_available_quantity == true){
		// Remove the disabled attribute from the disabled fields becuase if they are disabled won't be sent with the request.
		$('select[name="warehouses"]').prop('disabled', false);
		// Add disabled to submit buttons
		$(this).find('.save_detail').prop('disabled', true);
		$('#pur_order-form').submit();
	}else{
		if(check_available_quantity == false){
			appAlert.warning("<?php echo _l('No_adjustment_is_allowed_when_the_product_has_an_Available_quantity_of_0') ?>");
		}else if(check_the_same_available_quantity == false){
			appAlert.warning("<?php echo _l('Please_choose_Stock_quantity_different_from_Available_quantity') ?>");
		}
	}

	return true;
}

function la_get_available_quantity(commodity_code_name, lot_number_name, expiry_date_name, name_available_quantity){
	"use strict"; 

	var warehouse_id = $('select[name="warehouses"]').val();
	var commodity_id = $('input[name="'+commodity_code_name+'"]').val();
	var lot_number = $('input[name="'+lot_number_name+'"]').val();
	var expiry_date = $('input[name="'+expiry_date_name+'"]').val();

	var available_quantity = loss_adjustment_get_available_quantity(warehouse_id, commodity_id, lot_number, expiry_date);
	$('input[name="'+name_available_quantity+'"]').val(parseFloat(available_quantity));

}

function loss_adjustment_get_available_quantity(warehouse_id, commodity_id, lot_number, expiry_date) {
	var data ={};
	data.warehouse_id = warehouse_id;
	data.commodity_id = commodity_id;
	data.lot_number = lot_number;
	data.expiry_date = expiry_date;
	var available_quantity = 0;
	jQuery.ajaxSetup({
		async: false
	});
	
	$.post("<?php echo get_uri("warehouse/quantity_inventory") ?>",data).done(function(response){
		response = JSON.parse(response);
		available_quantity = parseFloat(response.value);
		
	});
	jQuery.ajaxSetup({
		async: true
	});
	return available_quantity;
}

/*scanner barcode*/
$(document).ready(function() {
	var pressed = false;
	var chars = [];
	$(window).keypress(function(e) {
		if (e.key == '%') {
			pressed = true;
		}
		chars.push(String.fromCharCode(e.which));
		if (pressed == false) {
			setTimeout(function() {
				if (chars.length >= 8) {
					var barcode = chars.join('');
					requestGetJSON("<?php  echo get_uri('warehouse/wh_get_item_by_barcode') ?>"  + barcode).done(function (response) {
						if(response.status == true || response.status == 'true'){
							wh_add_item_to_preview(response.id);
							appAlert.success(response.message);

						}else{
							appAlert.warning("<?php echo _l('no_matching_products_found') ?>");
						}
					});

				}
				chars = [];
				pressed = false;
			}, 200);
		}
		pressed = true;
	});
});

function loss_fill_multiple_serial_number_modal(quantity, prefix_name, slug, serial_input_value) {

	if( quantity > 0){

		var data = {ajaxModal: 1},
		isLargeModal = $(this).attr('data-modal-lg'),
		isFullscreenModal = $(this).attr('data-modal-fullscreen'),
		title = "<?php echo app_lang("Enter_the_serial_number_of_the_damaged_or_lost_product_otherwise_the_system_will_automatically_get_a_random_serial_number") ?>";
		
		if (title) {
			$("#ajaxModalTitle").html(title);
		} else {
			$("#ajaxModalTitle").html($("#ajaxModalTitle").attr('data-title'));
		}

		if ($(this).attr("data-post-hide-header")) {
			$("#ajaxModal .modal-header").addClass("hide");
			$("#ajaxModal .modal-footer").addClass("hide");
		} else {
			$("#ajaxModal .modal-header").removeClass("hide");
			$("#ajaxModal .modal-footer").removeClass("hide");
		}

		$("#ajaxModalContent").html($("#ajaxModalOriginalContent").html());
		$("#ajaxModalContent").find(".original-modal-body").removeClass("original-modal-body").addClass("modal-body");
		$("#ajaxModal").modal('show');
		$("#ajaxModal").find(".modal-dialog").removeClass("custom-modal-lg");
		$("#ajaxModal").find(".modal-dialog").removeClass("modal-fullscreen");
		$(".modal-backdrop").remove();

		data.slug = slug;
		data.quantity = quantity;
		data.prefix_name = prefix_name;
		data.serial_input_value = serial_input_value;

		ajaxModalXhr = $.ajax({
			url: "<?php echo get_uri("warehouse/loss_fill_multiple_serial_number_modal") ?>",
			data: data,
			cache: false,
			type: 'POST',
			success: function (response) {
				$("#ajaxModal").find(".modal-dialog").removeClass("mini-modal");
				if (isLargeModal === "1") {
					$("#ajaxModal").find(".modal-dialog").addClass("custom-modal-lg");
				} else if (isFullscreenModal === "1") {
					$("#ajaxModal").find(".modal-dialog").addClass("modal-fullscreen");
				}
				$("#ajaxModalContent").html(response);

				setSummernoteToAll(true);
				setModalScrollbar();

				feather.replace();
			},
			statusCode: {
				404: function () {
					$("#ajaxModalContent").find('.modal-body').html("");
					appAlert.error("404: Page not found.", {container: '.modal-body', animate: false});
				}
			},
			error: function () {
				$("#ajaxModalContent").find('.modal-body').html("");
				appAlert.error("500: Internal Server Error.", {container: '.modal-body', animate: false});
			}
		});
		return false;

	}else{
		appAlert.warning("<?php echo _l('please_choose_quantity_more_than_0') ?>");
	}

}

function loss_wh_view_serial_number(name_available_quantity, name_quantities, serial_input, prefix_name){
	"use strict";

	var serial_input_value = $('input[name="'+serial_input+'"]').val();
	if(serial_input_value == ''){
		var quantity = $('input[name="'+name_quantities+'"]').val();
		var available_quantity = $('input[name="'+name_available_quantity+'"]').val();
		var _quantity = parseFloat(available_quantity) - parseFloat(quantity);

		loss_fill_multiple_serial_number_modal(parseInt(_quantity), prefix_name, 'add');
	}else{
		loss_fill_multiple_serial_number_modal(1, prefix_name, 'edit', serial_input_value);

	}

}

function adjustment_fill_multiple_serial_number_modal(quantity, prefix_name, slug, serial_input_value) {

	if( quantity > 0){

		var data = {ajaxModal: 1},
		isLargeModal = $(this).attr('data-modal-lg'),
		isFullscreenModal = $(this).attr('data-modal-fullscreen'),
		title = "<?php echo app_lang("wh_enter_the_serial_number") ?>";
		
		if (title) {
			$("#ajaxModalTitle").html(title);
		} else {
			$("#ajaxModalTitle").html($("#ajaxModalTitle").attr('data-title'));
		}

		if ($(this).attr("data-post-hide-header")) {
			$("#ajaxModal .modal-header").addClass("hide");
			$("#ajaxModal .modal-footer").addClass("hide");
		} else {
			$("#ajaxModal .modal-header").removeClass("hide");
			$("#ajaxModal .modal-footer").removeClass("hide");
		}

		$("#ajaxModalContent").html($("#ajaxModalOriginalContent").html());
		$("#ajaxModalContent").find(".original-modal-body").removeClass("original-modal-body").addClass("modal-body");
		$("#ajaxModal").modal('show');
		$("#ajaxModal").find(".modal-dialog").removeClass("custom-modal-lg");
		$("#ajaxModal").find(".modal-dialog").removeClass("modal-fullscreen");
		$(".modal-backdrop").remove();

		data.slug = slug;
		data.quantity = quantity;
		data.prefix_name = prefix_name;
		data.serial_input_value = serial_input_value;

		ajaxModalXhr = $.ajax({
			url: "<?php echo get_uri("warehouse/adjustment_fill_multiple_serial_number_modal") ?>",
			data: data,
			cache: false,
			type: 'POST',
			success: function (response) {
				$("#ajaxModal").find(".modal-dialog").removeClass("mini-modal");
				if (isLargeModal === "1") {
					$("#ajaxModal").find(".modal-dialog").addClass("custom-modal-lg");
				} else if (isFullscreenModal === "1") {
					$("#ajaxModal").find(".modal-dialog").addClass("modal-fullscreen");
				}
				$("#ajaxModalContent").html(response);

				setSummernoteToAll(true);
				setModalScrollbar();

				feather.replace();
			},
			statusCode: {
				404: function () {
					$("#ajaxModalContent").find('.modal-body').html("");
					appAlert.error("404: Page not found.", {container: '.modal-body', animate: false});
				}
			},
			error: function () {
				$("#ajaxModalContent").find('.modal-body').html("");
				appAlert.error("500: Internal Server Error.", {container: '.modal-body', animate: false});
			}
		});
		return false;
	}else{
		appAlert.warning("<?php echo _l('please_choose_quantity_more_than_0') ?>");
	}

}

function adjustment_wh_view_serial_number(name_available_quantity, name_quantities, serial_input, prefix_name){
	"use strict";

	var serial_input_value = $('input[name="'+serial_input+'"]').val();
	if(serial_input_value == ''){
		var quantity = $('input[name="'+name_quantities+'"]').val();
		var available_quantity = $('input[name="'+name_available_quantity+'"]').val();
		var _quantity = parseFloat(quantity) - parseFloat(available_quantity);

		adjustment_fill_multiple_serial_number_modal(parseInt(_quantity), prefix_name, 'add');
	}else{

		adjustment_fill_multiple_serial_number_modal(1, prefix_name, 'edit', serial_input_value);
	}
}

</script>