<script>

	var lastAddedItemKey = null;
	(function($) {
		"use strict";  
		$(document).ready(function () {
			setDatePicker("#date_c, #date_add");
			setDatePicker(".datePickerInput");
			$('input[name="date_manufacture"]').val('');
			$('input[name="expiry_date"]').val('');

			$(".select2").select2();

		});

		/*required clientid,packing_list_name,delivery_note_id*/
		init_ajax_search('items','#item_select.ajax-search',undefined,"<?php echo get_uri("warehouse/wh_commodity_code_search/rate") ?>");
		wh_calculate_total();

	})(jQuery);


	(function($) {
		"use strict";

		/*Add item to preview from the dropdown for invoices estimates*/
		$("body").on('change', 'select[name="item_select"]', function () {
			var itemid = $('select[name="item_select"]').val();

			if (itemid != '') {
				wh_add_item_to_preview(itemid);
			}
		});

		$("body").on('change', 'select.taxes', function () {
			wh_calculate_total();
		});

		$("body").on('change', 'input[name="additional_discount"]', function () {

			var additional_discount = $('input[name="additional_discount"]').val();
			var main_additional_discount = $('input[name="main_additional_discount"]').val();
			if(parseFloat(additional_discount) <= parseFloat(main_additional_discount)){
				wh_calculate_total();
			}else{
				appAlert.warning("<?php echo _l('The_maximum_allowed_additional_discount_is') ?>"+': '+parseFloat(main_additional_discount));
				$('input[name="additional_discount"]').val(parseFloat(main_additional_discount));
			}
		});

		$("body").on('click', '.add_packing_list', function () {
			submit_form(false);
		});

		$('.add_packing_list_send').on('click', function() {
			submit_form(true);
		});

		$("body").on('change', 'input[name="shipping_fee"]', function () {
			wh_calculate_total();
		});

	})(jQuery);


	function wh_add_item_to_preview(id) {
		"use strict";

		requestGetJSON("<?php  echo get_uri('warehouse/get_item_by_id/') ?>" + id +'/'+true).done(function (response) {
			wh_clear_item_preview_values();

			$('.main input[name="commodity_code"]').val(response.itemid);
			$('.main textarea[name="commodity_name"]').val(response.code_description);
			$('.main input[name="unit_price"]').val(response.rate);
			$('.main input[name="unit_name"]').val(response.unit_name);
			$('.main input[name="unit_id"]').val(response.unit_id);
			$('.main input[name="quantity"]').val(1);
			$('.selectpicker').selectpicker('refresh');

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

		if ( data.quantity == "" || data.commodity_code == "" ) {
			if(parseFloat(data.quantity) < 0){
			//check_available_quantity
			appAlert.warning("<?php echo _l('please_choose_quantity_more_than_0') ?>");
		}
		return;
	}
	var table_row = '';
	var item_key = lastAddedItemKey ? lastAddedItemKey += 1 : $("body").find('.invoice-items-table tbody .item').length + 1;
	lastAddedItemKey = item_key;
	$("body").append('<div class="dt-loader"></div>');
	wh_get_item_row_template('newitems[' + item_key + ']',data.commodity_name, data.quantity, data.unit_name,data.unit_price, data.taxname, data.commodity_code, data.unit_id, data.tax_rate, data.discount, itemid).done(function(output){
		table_row += output;

		$('.invoice-item table.invoice-items-table.items tbody').append(table_row);

		setTimeout(function () {
			wh_calculate_total();
		}, 15);

		wh_reorder_items('.invoice-item');
		wh_clear_item_preview_values('.invoice-item');
		$('body').find('#items-warning').remove();
		$("body").find('.dt-loader').remove();
		$('#item_select').val('').change();

		return true;
	});
	return false;
}

function wh_get_item_preview_values() {
	"use strict";

	var response = {};
	response.commodity_name = $('.invoice-item .main textarea[name="commodity_name"]').val();
	response.quantity = $('.invoice-item .main input[name="quantity"]').val();
	response.unit_name = $('.invoice-item .main input[name="unit_name"]').val();
	response.unit_price = $('.invoice-item .main input[name="unit_price"]').val();
	response.taxname = $('.main select.taxes').val();
	response.commodity_code = $('.invoice-item .main input[name="commodity_code"]').val();
	response.unit_id = $('.invoice-item .main input[name="unit_id"]').val();
	response.tax_rate = $('.invoice-item .main input[name="tax_rate"]').val();
	response.discount = $('.invoice-item .main input[name="discount"]').val();

	return response;
}

function wh_clear_item_preview_values(parent) {
	"use strict";

	var taxSelectedArray = [];
	$('.main select.taxes').val(taxSelectedArray).change();
	$('.main input').val('');
	$('.main textarea').val('');
}

function wh_get_item_row_template(name, commodity_name, quantity, unit_name, unit_price, taxname, commodity_code, unit_id, tax_rate, discount, item_key)  {
	"use strict";

	jQuery.ajaxSetup({
		async: false
	});

	var d = $.post("<?php echo get_uri("warehouse/get_packing_list_row_template") ?>", {
		name: name,
		commodity_name : commodity_name,
		quantity : quantity,
		unit_name : unit_name,
		unit_price : unit_price,
		taxname : taxname,
		commodity_code : commodity_code,
		unit_id : unit_id,
		tax_rate : tax_rate,
		discount : discount,
		item_key : item_key
	});
	jQuery.ajaxSetup({
		async: true
	});
	return d;
}

function wh_delete_item(row, itemid,parent) {
	"use strict";

	var shipping_fee = $('input[name="shipping_fee"]').val();
	var max_shipping_fee = $('input[name="shipping_fee"]').attr('max');
	if(parseFloat(shipping_fee) == parseFloat(max_shipping_fee)){
		var new_shipping_fee = parseFloat(max_shipping_fee)/2;
		$('input[name="shipping_fee"]').val(new_shipping_fee);
	}

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
	total_money = 0,
	total_tax_money = 0,
	quantity = 1,
	total_discount_calculated = 0,
	item_discount_percent = 0,
	item_discount = 0,
	item_total_payment,
	rows = $('.table.has-calculations tbody tr.item'),
	subtotal_area = $('#subtotal'),
	discount_area = $('#discount_area'),
	adjustment = $('input[name="adjustment"]').val(),
	discount_percent = 'before_tax',
	discount_fixed = $('input[name="discount_total"]').val(),
	discount_total_type = $('.discount-total-type.selected'),
	discount_type = $('select[name="discount_type"]').val(),
	additional_discount = $('input[name="additional_discount"]').val(),
	main_additional_discount = $('input[name="main_additional_discount"]').val(),
	shipping_fee = $('input[name="shipping_fee"]').val(),
	main_shipping_fee = $('input[name="main_shipping_fee"]').val();


	$('.wh-tax-area').remove();

	$.each(rows, function () {

		var item_tax = 0,
		item_amount  = 0;

		quantity = $(this).find('[data-quantity]').val();
		if (quantity === '') {
			quantity = 1;
			$(this).find('[data-quantity]').val(1);
		}
		item_discount_percent = $(this).find('td.discount input').val();

		if (isNaN(item_discount_percent) || item_discount_percent == '') {
			item_discount_percent = 0;
		}

		_amount =  parseFloat($(this).find('td.rate input').val() * quantity).toFixed(decimal_places)
		item_amount = _amount;
		_amount = parseFloat(_amount);

		$(this).find('td.amount').html(toCurrency(_amount));

		subtotal += _amount;
		row = $(this);
		item_taxes = $(this).find('select.taxes').val();

		if (item_taxes) {
			$.each(item_taxes, function (i, taxname) {
				taxrate = row.find('select.taxes [value="' + taxname + '"]').data('taxrate');
				calculated_tax = (_amount / 100 * taxrate);
				item_tax += calculated_tax;
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
			//Discount of item
			item_discount = (parseFloat(item_amount) + parseFloat(item_tax) ) * parseFloat(item_discount_percent) / 100;
			item_total_payment = parseFloat(item_amount) + parseFloat(item_tax) - parseFloat(item_discount);

			// Append value to item
			total_discount_calculated += item_discount;
			$(this).find('td.discount_money input').val(item_discount);
			$(this).find('td.total_after_discount input').val(item_total_payment);

			$(this).find('td.label_discount_money').html(toCurrency(item_discount));
			$(this).find('td.label_total_after_discount').html(toCurrency(item_total_payment));

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
	total_money = total;
	// Discount by percent
	if ((discount_percent !== '' && discount_percent != 0) && discount_type == 'after_tax' && discount_total_type.hasClass('discount-type-percent')) {
		total_discount_calculated = (total * discount_percent) / 100;
	} else if ((discount_fixed !== '' && discount_fixed != 0) && discount_type == 'after_tax' && discount_total_type.hasClass('discount-type-fixed')) {
		total_discount_calculated = discount_fixed;
	}

	if (!isNaN(parseFloat(additional_discount))) {
		total = total - total_discount_calculated - parseFloat(additional_discount);
	} else {
		total = total - total_discount_calculated;
	}

	adjustment = parseFloat(adjustment);

	// Check if adjustment not empty
	if (!isNaN(adjustment)) {
		total = total + adjustment;
	}

	if (!isNaN(shipping_fee) && shipping_fee != '') {
		total = total + parseFloat(shipping_fee);
	}

	if (!isNaN(parseFloat(total_discount_calculated)) && !isNaN(parseFloat(additional_discount))) {
		var discount_html = '-' + toCurrency(parseFloat(total_discount_calculated)+ parseFloat(additional_discount));
	}else if(!isNaN(parseFloat(total_discount_calculated))){
		var discount_html = '-' + toCurrency(parseFloat(total_discount_calculated));
	}else if(!isNaN(parseFloat(additional_discount))){
		var discount_html = '-' + toCurrency(parseFloat(additional_discount));
	}

	$('input[name="discount_total"]').val(parseFloat(total_discount_calculated).toFixed(decimal_places));

	// Append, format to html and display
	$('.wh-total_discount').html(discount_html + hidden_input('discount_total', parseFloat(total_discount_calculated).toFixed(decimal_places))  );
	$('.adjustment').html(toCurrency(adjustment));

	$('.wh-additional_discount').html('<input type="number" class="form-control" name="additional_discount" min="0.0" step="any" max="'+main_additional_discount+'" value="' + additional_discount + '">');
	$('.wh-shipping_fee').html('<input type="number" class="form-control" name="shipping_fee" min="0.0" step="any" max="'+main_shipping_fee+'" value="' + shipping_fee + '">');
	
	$('.wh-subtotal').html(toCurrency(subtotal) + hidden_input('subtotal', parseFloat(subtotal).toFixed(decimal_places)) + hidden_input('total_amount', parseFloat(total_money).toFixed(decimal_places)));
	$('.wh-total').html(toCurrency(total) + hidden_input('total_after_discount', parseFloat(total).toFixed(decimal_places)));

	$(document).trigger('wh-packing-list-total-calculated');

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

function submit_form(save_and_send_request) {
	"use strict";

	wh_calculate_total();

	var $itemsTable = $('.invoice-items-table');
	var $previewItem = $itemsTable.find('.main');
	var check_warehouse_status = true,
	check_quantity_status = true;

	if ( $itemsTable.length && $itemsTable.find('.item').length === 0) {
		appAlert.warning("<?php echo _l('wh_enter_at_least_one_product') ?>");
		return false;
	}

	$('input[name="save_and_send_request"]').val(save_and_send_request);

	var rows = $('.table.has-calculations tbody tr.item');
	$.each(rows, function () {
		var quantity_value = $(this).find('td.quantities input').val();
		if(parseFloat(quantity_value) == 0){
			check_quantity_status = false;
		}
		
	})

	if( check_quantity_status == true ){
		// Add disabled to submit buttons
		$(this).find('.add_goods_receipt_send').prop('disabled', true);
		$(this).find('.add_goods_receipt').prop('disabled', true);
		$('#add_edit_packing_list').submit();
	}else{
		appAlert.warning("<?php echo _l('please_choose_quantity_export') ?>");

	}

	return true;
}

function invoice_change(){
	"use strict";

	var invoice_id = $('select[name="invoice_id"]').val();

	$.post("<?php echo get_uri("warehouse/copy_invoices/") ?>"+invoice_id).done(function(response){
		response = JSON.parse(response);

		$('input[name="additional_discount"]').val((response.goods_delivery.additional_discount));
		$('.invoice-item table.invoice-items-table.items tbody').html('');
		$('.invoice-item table.invoice-items-table.items tbody').append(response.result);

		setTimeout(function () {
			wh_calculate_total();
		}, 15);

		init_selectpicker();
		init_datepicker();
		wh_reorder_items('.invoice-item');
		wh_clear_item_preview_values('.invoice-item');
		$('body').find('#items-warning').remove();
		$("body").find('.dt-loader').remove();
		$('#item_select').selectpicker('val', '');

		$('select[name="staff_id"]').val((response.goods_delivery.addedfrom)).change();
		$('textarea[name="description"]').val((response.goods_delivery.description)).change();
		$('input[name="address"]').val((response.goods_delivery.address));
		$('select[name="customer_code"]').val((response.goods_delivery.customer_code)).change();
		$('input[name="invoice_no"]').val(response.invoice_no);
	});

}


$('select[name="delivery_note_id"]').on('change', function() {
	"use strict";

	var delivery_note_id = $('select[name="delivery_note_id"]').val();

	$.post("<?php echo get_uri("warehouse/packing_list_copy_delivery_note/") ?>"+delivery_note_id).done(function(response){
		response = JSON.parse(response);

		$('input[name="additional_discount"]').val((response.additional_discount));
		$('input[name="main_additional_discount"]').val((response.additional_discount));
		$('.invoice-item table.invoice-items-table.items tbody').html('');
		$('.invoice-item table.invoice-items-table.items tbody').append(response.result);
		$('select[name="clientid"]').val(response.customer_id).change();
		$('input[name="shipping_fee"]').val((response.shipping_fee));
		$('input[name="main_shipping_fee"]').val((response.shipping_fee));

		setTimeout(function () {
			wh_calculate_total();
		}, 15);

		wh_reorder_items('.invoice-item');
		wh_clear_item_preview_values('.invoice-item');
		$('body').find('#items-warning').remove();
		$("body").find('.dt-loader').remove();
		$('#item_select').val('').change();

		$('.refresh_tax2 .select2').select2('destroy');
		$('.refresh_tax2 .select2').select2();


	});
});

$("body").on('change', '#clientid', function () {
	var val = $('select[name="clientid"]').val();

	requestGetJSON("<?php  echo get_uri('warehouse/wh_client_change_data/') ?>" + val).done(function (response) {
		$('.bill_to_data').html(response.billing_shipping);
	});

});

$('input[name="width"]').on('change', function () {
	"use strict";
	calculate_volume();
})
$('input[name="height"]').on('change', function () {
	"use strict";
	calculate_volume();
})
$('input[name="lenght"]').on('change', function () {
	"use strict";
	calculate_volume();
})

function calculate_volume(){
	"use strict";

	var volume = 0;
	var width = $('input[name="width"]').val(),
	height = $('input[name="height"]').val(),
	lenght = $('input[name="lenght"]').val();

	volume = parseFloat(width) * parseFloat(height) * parseFloat(lenght);
	$('input[name="volume"]').val(volume);
}

</script>