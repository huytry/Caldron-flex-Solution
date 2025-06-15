<script>
	var purchase;
	var warehouses;
	var lastAddedItemKey = null;

	$(document).ready(function () {
		"use strict";
		
		setDatePicker("#date_c, #date_add");
		setDatePicker(".datePickerInput");
		$('input[name="date_manufacture"]').val('');
		$('input[name="expiry_date"]').val('');

		$(".select2").select2();
	});

	(function($) {
		"use strict";  
		/*required field internal_delivery_name,date_add*/

	// Maybe items ajax search
	init_ajax_search('items','#item_select.ajax-search',undefined, "<?php echo get_uri("warehouse/wh_commodity_code_search") ?>");
	wh_calculate_total();

})(jQuery);


(function($) {
	"use strict"; 
// Add item to preview from the dropdown for invoices estimates
$("body").on('change', 'select[name="item_select"]', function () {
	var itemid = $('select[name="item_select"]').val();
	if (itemid != '') {
		wh_add_item_to_preview(itemid);
	}
});

// Recaulciate total on these changes
$("body").on('change', 'select.taxes', function () {
	wh_calculate_total();
});

$("body").on('click', '.btn_add_internal_delivery', function () {
	submit_form(false);
});

$('select[name="from_stock_name"]').on('change', function() {
	"use strict"; 

	var data = {};
	data.commodity_id = $('.main input[name="commodity_code"]').val();
	data.warehouse_id = $('.main select[name="from_stock_name"]').val();
	if(data.commodity_id != '' && data.warehouse_id != ''){

		$.post("<?php echo get_uri("warehouse/get_quantity_inventory") ?>", data).done(function(response){
			response = JSON.parse(response);
			$('.main input[name="available_quantity"]').val(response.value);
		});
	}else{
		$('.main input[name="available_quantity"]').val(0);
	}
});

$('input[name="quantities"]').on('change', function() {
	"use strict"; 

	
	var available_quantity = $('.main input[name="available_quantity"]').val();
	var quantities = $('.main input[name="quantities"]').val();

	if(parseFloat(available_quantity) < parseFloat(quantities)){
		$('.main input[name="quantities"]').val(available_quantity);
		appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
	}
});

})(jQuery);

// Add item to preview
function wh_add_item_to_preview(id) {
	"use strict"; 

	requestGetJSON("<?php  echo get_uri('warehouse/get_item_by_id/') ?>" + id +'/'+true).done(function (response) {
		wh_clear_item_preview_values();

		$('.main input[name="commodity_code"]').val(response.itemid);
		$('.main textarea[name="commodity_name"]').val(response.code_description);
		$('.main input[name="unit_price"]').val(response.purchase_price);
		$('.main input[name="unit_name"]').val(response.unit_name);
		$('.main input[name="unit_id"]').val(response.unit_id);
		$('.main input[name="quantities"]').val('');
		$('.main select[name="from_stock_name"]').html(response.warehouses_html);

		if($('select[name="warehouse_id"]').val() != ''){
			$('.main select[name="warehouse_id"]').val($('select[name="warehouse_id"]').val()).change();
		}

		var taxSelectedArray = [];
		if (response.taxname && response.taxrate) {
			taxSelectedArray.push(response.taxname + '|' + response.taxrate);
		}
		if (response.taxname_2 && response.taxrate_2) {
			taxSelectedArray.push(response.taxname_2 + '|' + response.taxrate_2);
		}

		$('.main select.taxes').val(taxSelectedArray).change();
		$('.main input[name="unit"]').val(response.unit_name);

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

	if (data.from_stock_name == "" || data.to_stock_name == "" || data.quantities == "" || data.commodity_code == "" || data.available_quantity == "") {

		if(data.from_stock_name == ""){
			appAlert.warning("<?php echo _l('please_choose_from_stock_name') ?>");
		}else if(data.from_stock_name == ""){
			appAlert.warning("<?php echo _l('please_choose_to_stock_name') ?>");
		}else if(parseFloat(data.from_warehouse_id) == parseFloat(data.to_warehouse_id)){
			appAlert.warning("<?php echo _l('Please_choose_a_different_export_warehouse_than_the_receipt_warehouse') ?>");
		}else if(data.quantities == ""){
			appAlert.warning("<?php echo _l('please_choose_quantity_export') ?>");
		}else if(parseFloat(data.available_quantity) < parseFloat(data.quantities)){
			//check_available_quantity
			appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
		}

		return;
	}
	if(data.from_stock_name == ""){
		appAlert.warning("<?php echo _l('please_choose_from_stock_name') ?>");
		return;
	}else if(data.from_stock_name == ""){
		appAlert.warning("<?php echo _l('please_choose_to_stock_name') ?>");
		return;
	}else if(parseFloat(data.from_warehouse_id) == parseFloat(data.to_warehouse_id)){
		appAlert.warning("<?php echo _l('Please_choose_a_different_export_warehouse_than_the_receipt_warehouse') ?>");
		return;
	}else if(data.quantities == ""){
		appAlert.warning("<?php echo _l('please_choose_quantity_export') ?>");
		return;
	}else if(parseFloat(data.available_quantity) < parseFloat(data.quantities)){
		//check_available_quantity
		appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
		return;
	}

	var table_row = '';
	var item_key = lastAddedItemKey ? lastAddedItemKey += 1 : $("body").find('.invoice-items-table tbody .item').length + 1;
	lastAddedItemKey = item_key;
	$("body").append('<div class="dt-loader"></div>');
	wh_get_item_row_template('newitems[' + item_key + ']',data.commodity_name, data.from_stock_name, data.to_stock_name, data.available_quantity, data.quantities, data.unit_name, data.unit_price, data.commodity_code, data.unit_id, data.into_money, data.note, itemid, item_key).done(function(output){
		table_row += output;

		lastAddedItemKey = parseInt(lastAddedItemKey) + parseInt(data.quantities);
		$('.invoice-item table.invoice-items-table.items tbody').append(table_row);

		setTimeout(function () {
			wh_calculate_total();
		}, 15);

		setDatePicker(".datePickerInput");
		wh_reorder_items('.invoice-item');
		wh_clear_item_preview_values('.invoice-item');
		$('body').find('#items-warning').remove();
		$("body").find('.dt-loader').remove();
		$('#item_select').val('').change();

		// refesh warehouse select
		$('.refresh_tax2 .select2').select2('destroy');
		$('.refresh_tax2 .select2').select2();
		$('.refresh_from_warehouse2 .select2').select2('destroy');
		$('.refresh_from_warehouse2 .select2').select2();
		$('.refresh_to_warehouse2 .select2').select2('destroy');
		$('.refresh_to_warehouse2 .select2').select2();

		return true;
	});
	return false;
}

function wh_get_item_preview_values() {
	"use strict"; 

	var response = {};
	response.commodity_name = $('.invoice-item .main textarea[name="commodity_name"]').val();
	response.from_stock_name = $('.invoice-item .main select[name="from_stock_name"]').val();
	response.to_stock_name = $('.invoice-item .main select[name="to_stock_name"]').val();
	response.available_quantity = $('.invoice-item .main input[name="available_quantity"]').val();
	response.quantities = $('.invoice-item .main input[name="quantities"]').val();
	response.unit_name = $('.invoice-item .main input[name="unit_name"]').val();
	response.unit_price = $('.invoice-item .main input[name="unit_price"]').val();
	response.commodity_code = $('.invoice-item .main input[name="commodity_code"]').val();
	response.unit_id = $('.invoice-item .main input[name="unit_id"]').val();
	response.into_money = $('.invoice-item .main input[name="into_money"]').val();
	response.note = $('.invoice-item .main input[name="note"]').val();

	return response;
}

function wh_clear_item_preview_values(parent) {
	"use strict"; 

	var taxSelectedArray = [];
	$('.main select.taxes').val(taxSelectedArray).change();
	$('.main select[name="from_stock_name"]').val('').change();
	$('.main select[name="to_stock_name"]').val('').change();
	$('.main input').val('');
	$('.main textarea').val('')
}

function wh_get_item_row_template(name, commodity_name, from_stock_name, to_stock_name, available_quantity, quantities, unit_name, unit_price, commodity_code, unit_id, into_money, note, item_key, item_index)  {
	"use strict"; 

	jQuery.ajaxSetup({
		async: false
	});

	var d = $.post("<?php echo get_uri("warehouse/get_internal_delivery_row_template") ?>", {
		name: name,
		commodity_name : commodity_name,
		from_stock_name : from_stock_name,
		to_stock_name : to_stock_name,
		available_quantity : available_quantity,
		quantities : quantities,
		unit_name : unit_name,
		unit_price : unit_price,
		commodity_code : commodity_code,
		unit_id : unit_id,
		into_money : into_money,
		note : note,
		item_key : item_key,
		item_index : item_index,
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
		var decimal_places  = 0; //round it and the add static 2 decimals
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
	discount_type = $('select[name="discount_type"]').val();

	$('.wh-tax-area').remove();

	$.each(rows, function () {

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
										// Increment total from this tax
										taxes[taxname] = taxes[taxname] += calculated_tax;
									}
								});
		}
	});

	// Discount by percent
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

	// Discount by percent
	if ((discount_percent !== '' && discount_percent != 0) && discount_type == 'after_tax' && discount_total_type.hasClass('discount-type-percent')) {
		total_discount_calculated = (total * discount_percent) / 100;
	} else if ((discount_fixed !== '' && discount_fixed != 0) && discount_type == 'after_tax' && discount_total_type.hasClass('discount-type-fixed')) {
		total_discount_calculated = discount_fixed;
	}

	total = total - total_discount_calculated;
	adjustment = parseFloat(adjustment);

	// Check if adjustment not empty
	if (!isNaN(adjustment)) {
		total = total + adjustment;
	}

	var discount_html = '-' + toCurrency(total_discount_calculated);
	$('input[name="discount_total"]').val(parseFloat(total_discount_calculated).toFixed(decimal_places));

	// Append, format to html and display
	$('.discount-total').html(discount_html);
	$('.adjustment').html(toCurrency(adjustment));


	$('.wh-total').html(toCurrency(total) + hidden_input('total_amount', parseFloat(total).toFixed(decimal_places)));

	$(document).trigger('wh-internal-delivery-total-calculated');

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
	var check_from_stock_name = true,
	check_to_stock_name = true,
	check_quantity = true,
	check_available_quantity = true,
	check_the_same_warehouse = true;

	$.each(rows, function () {
		var from_warehouse_id = $(this).find('td.warehouse_select select').val();
		var to_warehouse_id = $(this).find('td.to_warehouse_select select').val();
		var available_quantity_value = $(this).find('td.available_quantity input').val();
		var quantity_value = $(this).find('td.quantities input').val();

		if(from_warehouse_id == '' || from_warehouse_id == undefined){
			check_from_stock_name = false;
		}
		if(to_warehouse_id == '' || to_warehouse_id == undefined){
			check_to_stock_name = false;
		}
		if(parseFloat(quantity_value) == 0){
			check_quantity = false;
		}
		if(parseFloat(available_quantity_value) < parseFloat(quantity_value) ){
			check_available_quantity = false;
		}

		if(parseFloat(from_warehouse_id) == parseFloat(to_warehouse_id)){
			check_the_same_warehouse = false;
		}
		
	})

	if(check_from_stock_name == true && check_to_stock_name == true && check_quantity == true && check_available_quantity == true && check_the_same_warehouse){
		// Add disabled to submit buttons
		$(this).find('.btn_add_internal_delivery').prop('disabled', true);
		$('#add_update_internal_delivery').submit();
	}else{
		if(check_from_stock_name == false){
			appAlert.warning("<?php echo _l('please_choose_from_stock_name') ?>");
		}else if(check_to_stock_name == false){
			appAlert.warning("<?php echo _l('please_choose_to_stock_name') ?>");
		}else if(check_the_same_warehouse == false){
			appAlert.warning("<?php echo _l('Please_choose_a_different_export_warehouse_than_the_receipt_warehouse') ?>");
		}else if(check_quantity == false){
			appAlert.warning("<?php echo _l('please_choose_quantity_export') ?>");
		}else{
			//check_available_quantity
			appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
		}
	}

	return true;
}

function get_available_quantity(commodity_code_name, from_stock_name, available_quantity_name){
	"use strict"; 

	var data = {};
	data.commodity_id = $('input[name="'+commodity_code_name+'"]').val();
	data.warehouse_id = $('select[name="'+from_stock_name+'"]').val();
	if(data.commodity_id != '' && data.warehouse_id != ''){

		$.post("<?php echo get_uri("warehouse/get_quantity_inventory") ?>", data).done(function(response){
			response = JSON.parse(response);
			$('input[name="'+available_quantity_name+'"]').val(response.value);
		});
	}else{
		$('input[name="'+available_quantity_name+'"]').val(0);
	}

	setTimeout(function () {
		wh_calculate_total();
	}, 15);

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
					requestGetJSON("<?php  echo get_uri('warehouse/wh_get_item_by_barcode') ?>" + barcode).done(function (response) {
						if(response.status == true || response.status == 'true'){
							wh_add_item_to_preview(response.id);
							appAlert.warning(response.message);

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




</script>