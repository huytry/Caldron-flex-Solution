<script>
	var purchase;
	var warehouses;
	var lastAddedItemKey = null;

	$(document).ready(function () {
		setDatePicker("#date_c, #date_add");
		setDatePicker(".datePickerInput");
		$('input[name="date_manufacture"]').val('');
		$('input[name="expiry_date"]').val('');

		$(".select2").select2();

	});
	
	(function($) {
		"use strict";  
		/*required fields date_c,date_add,pr_order_id*/

		/*Maybe items ajax search*/
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

		/*Recaulciate total on these changes*/
		$("body").on('change', 'select.taxes', function () {
			wh_calculate_total();
		});

		$("body").on('click', '.add_goods_delivery', function () {
			submit_form(false);
		});

		$('.add_goods_delivery_send').on('click', function() {
			submit_form(true);
		});


		$("body").on('change', 'select[name="warehouse_id"]', function() {
			"use strict"; 

			var data = {};
			data.commodity_id = $('.main input[name="commodity_code"]').val();
			data.warehouse_id = $('.main select[name="warehouse_id"]').val();
			var quantities = $('.main input[name="quantities"]').val();

			if(data.commodity_id != '' && data.warehouse_id != ''){

				$.post("<?php echo get_uri("warehouse/get_quantity_inventory") ?>", data).done(function(response){
					response = JSON.parse(response);
					$('.main input[name="available_quantity"]').val(response.value);
					if(parseFloat(response.value) < parseFloat(quantities)){
					}
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
				appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
				$('.main input[name="quantities"]').val(available_quantity);

			}
		});

		$("body").on('change', 'input[name="shipping_fee"]', function () {
			wh_calculate_total();
		});

	})(jQuery);

	function check_quantity_inventory(commodity_id, quantity, warehouse_id, switch_barcode_scanners = false) {

		data.commodity_id = commodity_id;
		data.quantity = quantity;
		data.switch_barcode_scanners = switch_barcode_scanners;
		data.warehouse_id = warehouse_id;

		if(commodity_id != '' && warehouse_id != '' ){

			$.post("<?php echo get_uri("warehouse/check_quantity_inventory") ?>", data).done(function(response){
				response = JSON.parse(response);

				purchase.setDataAtCell(row,2,response.value);

			});
		}
	}

	/*Add item to preview*/
	function wh_add_item_to_preview(id) {
		"use strict";

		requestGetJSON("<?php  echo get_uri('warehouse/get_item_by_id/') ?>" + id +'/'+true).done(function (response) {
			wh_clear_item_preview_values();

			$('.main input[name="commodity_code"]').val(response.itemid);
			$('.main textarea[name="commodity_name"]').val(response.code_description);
			$('.main input[name="unit_price"]').val(response.rate);
			$('.main input[name="unit_name"]').val(response.unit_name);
			$('.main input[name="unit_id"]').val(response.unit_id);
			$('.main input[name="quantities"]').val(1);
			$('.main select[name="warehouse_id"]').html(response.warehouses_html);
			$('.main input[name="guarantee_period"]').val(response.guarantee_new);
			$('.main input[name="without_checking_warehouse"]').val(response.without_checking_warehouse);

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

	function after_wh_add_item_to_table(data, itemid, formdata) {
		"use strict";

		data = typeof (data) == 'undefined' || data == 'undefined' ? wh_get_item_preview_values() : data;

		if ((data.warehouse_id == "" ||  data.available_quantity == "" || data.quantities == "" || data.commodity_code == "" ) && (data.without_checking_warehouse == 0 || data.without_checking_warehouse == '0' ) ) {
			if(data.warehouse_id == ""){
				appAlert.warning("<?php echo _l('please_select_a_warehouse') ?>");
			}
			if(parseFloat(data.available_quantity) < parseFloat(data.quantities)){
			//check_available_quantity
			appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
		}

		return;
	}
	if(parseFloat(data.available_quantity) < parseFloat(data.quantities) && (data.without_checking_warehouse == 0 || data.without_checking_warehouse == '0' ) ){
			//check_available_quantity
			appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
			return;
		}

		var table_row = '';
		var item_key = lastAddedItemKey ? lastAddedItemKey += 1 : $("body").find('.invoice-items-table tbody .item').length + 1;
		lastAddedItemKey = item_key;
		$("body").append('<div class="dt-loader"></div>');
		wh_get_item_row_template('newitems[' + item_key + ']',data.commodity_name,data.warehouse_id, data.available_quantity, data.quantities, data.unit_name,data.unit_price, data.taxname, data.lot_number, data.expiry_date, data.commodity_code, data.unit_id, data.tax_rate, data.discount, data.note, data.guarantee_period, itemid, item_key, formdata, data.without_checking_warehouse).done(function(output){
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

			$('.refresh_tax2 .select2').select2('destroy');
			$('.refresh_tax2 .select2').select2();
			$('.refresh_warehouse2 .select2').select2('destroy');
			$('.refresh_warehouse2 .select2').select2();

			return true;
		});
		return false;
	}

	function wh_get_item_preview_values() {
		"use strict";

		var response = {};
		response.commodity_name = $('.invoice-item .main textarea[name="commodity_name"]').val();
		response.warehouse_id = $('.invoice-item .main select[name="warehouse_id"]').val();
		response.available_quantity = $('.invoice-item .main input[name="available_quantity"]').val();
		response.quantities = $('.invoice-item .main input[name="quantities"]').val();
		response.unit_name = $('.invoice-item .main input[name="unit_name"]').val();
		response.unit_price = $('.invoice-item .main input[name="unit_price"]').val();
		response.taxname = $('.main select.taxes').val();
		response.lot_number = '';
		response.expiry_date = '';
		response.commodity_code = $('.invoice-item .main input[name="commodity_code"]').val();
		response.unit_id = $('.invoice-item .main input[name="unit_id"]').val();
		response.tax_rate = $('.invoice-item .main input[name="tax_rate"]').val();
		response.discount = $('.invoice-item .main input[name="discount"]').val();
		response.note = $('.invoice-item .main input[name="note"]').val();
		response.guarantee_period = $('.invoice-item .main input[name="guarantee_period"]').val();
		response.without_checking_warehouse = $('.invoice-item .main input[name="without_checking_warehouse"]').val();

		return response;
	}

	function wh_clear_item_preview_values(parent) {
		"use strict";
		var taxSelectedArray = [];

		$('.main select.taxes').val(taxSelectedArray).change();
		$('.main select[name="warehouse_id"]').val('').change();
		$('.main input').val('');
		$('.main textarea').val('');
	}

	function wh_get_item_row_template(name, commodity_name, warehouse_id, available_quantity, quantities, unit_name, unit_price, taxname, lot_number, expiry_date, commodity_code, unit_id, tax_rate, discount, note, guarantee_period, item_key, item_index, formdata, without_checking_warehouse)  {
		"use strict";

		jQuery.ajaxSetup({
			async: false
		});

		var d = $.post("<?php echo get_uri("warehouse/get_good_delivery_row_template") ?>", {
			name: name,
			commodity_name : commodity_name,
			warehouse_id : warehouse_id,
			available_quantity : available_quantity,
			quantities : quantities,
			unit_name : unit_name,
			unit_price : unit_price,
			taxname : taxname,
			lot_number : lot_number,
			expiry_date : expiry_date,
			commodity_code : commodity_code,
			unit_id : unit_id,
			tax_rate : tax_rate,
			discount : discount,
			note : note,
			guarantee_period : guarantee_period,
			item_key : item_key,
			item_index : item_index,
			formdata : formdata,
			without_checking_warehouse : without_checking_warehouse,
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
		shipping_fee = $('input[name="shipping_fee"]').val();


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

	total = total - total_discount_calculated - parseFloat(additional_discount);
	adjustment = parseFloat(adjustment);

	// Check if adjustment not empty
	if (!isNaN(adjustment)) {
		total = total + adjustment;
	}

	if (!isNaN(shipping_fee) && shipping_fee != '') {
		total = total + parseFloat(shipping_fee);
	}

	var discount_html = '-' + toCurrency(parseFloat(total_discount_calculated)+ parseFloat(additional_discount));
	$('input[name="discount_total"]').val(parseFloat(total_discount_calculated).toFixed(decimal_places));

	// Append, format to html and display
	$('.wh-total_discount').html(discount_html + hidden_input('total_discount', parseFloat(total_discount_calculated).toFixed(decimal_places))  );
	$('.adjustment').html(toCurrency(adjustment));
	

	$('.wh-subtotal').html(toCurrency(subtotal) + hidden_input('sub_total', parseFloat(subtotal).toFixed(decimal_places)) + hidden_input('total_money', parseFloat(total_money).toFixed(decimal_places)));
	$('.wh-total').html(toCurrency(parseFloat(total)) + hidden_input('after_discount', parseFloat(total).toFixed(decimal_places)));

	$(document).trigger('wh-receipt-note-total-calculated');

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
	check_quantity_status = true,
	check_available_quantity_status = true;

	if ( $itemsTable.length && $itemsTable.find('.item').length === 0) {
		appAlert.warning("<?php echo _l('wh_enter_at_least_one_product') ?>");
		return false;
	}

	$('input[name="save_and_send_request"]').val(save_and_send_request);

	var rows = $('.table.has-calculations tbody tr.item');
	$.each(rows, function () {

		var warehouse_id = $(this).find('td.warehouse_select select').val();
		var available_quantity_value = $(this).find('td.available_quantity input').val();
		var quantity_value = $(this).find('td.quantities input').val();
		var without_checking_warehouse = $(this).find('td.without_checking_warehouse input').val();

		if((warehouse_id == '' || warehouse_id == undefined) && (without_checking_warehouse == 0 || without_checking_warehouse == '0')){
			check_warehouse_status = false;
		}
		if(parseFloat(quantity_value) == 0 && (without_checking_warehouse == 0 || without_checking_warehouse == '0')){
			check_quantity_status = false;
		}
		if(parseFloat(available_quantity_value) < parseFloat(quantity_value) && (without_checking_warehouse == 0 || without_checking_warehouse == '0')){
			check_available_quantity_status = false;
		}
	})

	if(check_warehouse_status == true && check_quantity_status == true && check_available_quantity_status == true){
		// Add disabled to submit buttons
		$(this).find('.add_goods_receipt_send').prop('disabled', true);
		$(this).find('.add_goods_receipt').prop('disabled', true);
		$('#add_goods_delivery').submit();
	}else{
		if(check_warehouse_status == false){
			appAlert.warning("<?php echo _l('please_select_a_warehouse') ?>");

		}else if(check_quantity_status == false){
			appAlert.warning("<?php echo _l('please_choose_quantity_export') ?>");

		}else{
			/*check_available_quantity*/
			appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");

		}
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

		wh_reorder_items('.invoice-item');
		wh_clear_item_preview_values('.invoice-item');
		$('body').find('#items-warning').remove();
		$("body").find('.dt-loader').remove();
		$('#item_select').val('').change();

		$('select[name="staff_id"]').val((response.goods_delivery.addedfrom)).change();
		$('textarea[name="description"]').val((response.goods_delivery.description)).change();
		$('input[name="address"]').val((response.goods_delivery.address));
		$('select[name="customer_code"]').val((response.goods_delivery.customer_code)).change();
		$('input[name="invoice_no"]').val(response.invoice_no);

	});

}

function pr_order_change(){
	"use strict";

	var pr_order_id = $('select[name="pr_order_id"]').val();
	appAlert.warning("<?php echo _l('stock_received_docket_from_purchase_request') ?>");

	$.post("<?php echo get_uri("warehouse/goods_delivery_copy_pur_order/") ?>"+pr_order_id).done(function(response){
		response = JSON.parse(response);

		$('input[name="additional_discount"]').val((response.additional_discount));
		$('.invoice-item table.invoice-items-table.items tbody').html('');
		$('.invoice-item table.invoice-items-table.items tbody').append(response.result);

		setTimeout(function () {
			wh_calculate_total();
		}, 15);

		wh_reorder_items('.invoice-item');
		wh_clear_item_preview_values('.invoice-item');
		$('body').find('#items-warning').remove();
		$("body").find('.dt-loader').remove();
		$('#item_select').val('').change();

	});

	if(pr_order_id != ''){

		$.post("<?php echo get_uri("warehouse/copy_pur_vender/") ?>"+pr_order_id).done(function(response){
			var response_vendor = JSON.parse(response);

			$('select[name="buyer_id"]').val(response_vendor.buyer).change();
			$('select[name="project"]').val(response_vendor.project).change();
			$('select[name="type"]').val(response_vendor.type).change();
			$('select[name="department"]').val(response_vendor.department).change();
			$('select[name="requester"]').val(response_vendor.requester).change();

		});
	}else{
		$('select[name="buyer_id"]').val('').change();
		$('select[name="project"]').val('').change();
		$('select[name="type"]').val('').change();
		$('select[name="department"]').val('').change();
		$('select[name="requester"]').val('').change();
	}

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
					requestGetJSON("<?php  echo get_uri('warehouse/wh_get_item_by_barcode/') ?>" + barcode).done(function (response) {
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

function wh_add_item_to_table(data, itemid) {
	"use strict";
	data = typeof (data) == 'undefined' || data == 'undefined' ? wh_get_item_preview_values() : data;

	if ((data.warehouse_id == "" ||  data.available_quantity == "" || data.quantities == "" || data.commodity_code == "" ) && (data.without_checking_warehouse == 0 || data.without_checking_warehouse == '0' ) ) {
		if(data.warehouse_id == ""){
			appAlert.warning("<?php echo _l('please_select_a_warehouse') ?>");
		}
		if(parseFloat(data.available_quantity) < parseFloat(data.quantities)){
			//check_available_quantity
			appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
			
		}
		return;
	}

	if(parseFloat(data.available_quantity) < parseFloat(data.quantities) && (data.without_checking_warehouse == 0 || data.without_checking_warehouse == '0' ) ){
			//check_available_quantity
			appAlert.warning("<?php echo _l('inventory_quantity_is_not_enough') ?>");
			return;
		}
		var data_post = {};
		data_post.commodity_id = data.commodity_code;
		data_post.quantity = data.quantities;
		data_post.warehouse_id = data.warehouse_id;
		data_post.commodity_name = data.commodity_name;

		//get serial number
		$.post("<?php echo get_uri("warehouse/get_serial_number") ?>", data_post).done(function(response){
			response = JSON.parse(response);
			if(response.status == true || response.status == 'true'){
				fill_multiple_serial_number_modal(response.table_serial_number);
			}else{
				after_wh_add_item_to_table('undefined', 'undefined', '');
			}

		});
	}
	
	function fill_multiple_serial_number_modal(table_serial_number) {

		var data = {ajaxModal: 1},
		isLargeModal = $(this).attr('data-modal-lg'),
		isFullscreenModal = $(this).attr('data-modal-fullscreen'),
		title = "<?php echo app_lang("wh_select_the_serial_number") ?>";

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

		data.table_serial_number = table_serial_number;

		ajaxModalXhr = $.ajax({
			url: "<?php echo get_uri("warehouse/load_serial_number_modal") ?>",
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
	}

	function wh_change_serial_number(name_commodity_code, name_warehouse_id, name_serial_number, name_commodity_name) {
		"use strict";

		var data_post = {};

		data_post.commodity_id = $('input[name="'+name_commodity_code+'"]').val();
		data_post.warehouse_id = $('select[name="'+name_warehouse_id+'"]').val();
		data_post.serial_number = $('input[name="'+name_serial_number+'"]').val();
		data_post.commodity_name = $('textarea[name="'+name_commodity_name+'"]').val();

		var row_serial_numbers = $('.table.has-calculations tbody tr.item');
		var serial_number_array = [];

		$.each(row_serial_numbers, function () {
			var warehouse_id = $(this).find('td.warehouse_select select').val();
			var commodity_code = $(this).find('td.commodity_code input').val();
			var serial_number = $(this).find('td.serial_number input').val();

			if(data_post.commodity_id == commodity_code &&  data_post.warehouse_id == warehouse_id && data_post.serial_number != serial_number){

				serial_number_array.push(serial_number);
			}

		});
		data_post.serial_number_array = serial_number_array;


		// get serial number
		
		$.post("<?php echo get_uri("warehouse/get_serial_number_for_change_modal") ?>", data_post).done(function(response){
			response = JSON.parse(response);
			if(response.status == true || response.status == 'true'){

				open_change_serial_number_modal(response.table_serial_number, name_commodity_name, name_serial_number);
			}else{
				appAlert.warning("<?php echo _l('wh_dont_have_any_serial_number_for_this_item') ?>");
			}
		});

	}

	function open_change_serial_number_modal(table_serial_number, name_commodity_name, name_serial_number) {
		"use strict";

		$("#change_serial_modal_wrapper").load("<?php echo get_uri("warehouse/load_change_serial_number_modal") ?>", {
			table_serial_number: table_serial_number,
			name_commodity_name: name_commodity_name,
			name_serial_number: name_serial_number,
		}, function() {
			$("body").find('#changeSerialNumberModal').modal({ show: true, backdrop: 'static' });
		});

	}

</script>