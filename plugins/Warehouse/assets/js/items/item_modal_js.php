<script>
	var sub_group_value ='';
	var addMoreVendorsInputKey;
	
	$(document).ready(function () {
		"use strict";
		
		var uploadUrl = "<?php echo get_uri("items/upload_file"); ?>";
		var validationUri = "<?php echo get_uri("items/validate_items_file"); ?>";
		var dropzone = attachDropzoneWithForm("#items-dropzone", uploadUrl, validationUri);

		$("#item-form").appForm({
			ajaxSubmit: false,
			onSuccess: function (result) {
				if (window.refreshAfterUpdate) {
					window.refreshAfterUpdate = false;
					location.reload();
				} else {
					$("#item-table").appTable({newData: result.data, dataId: result.id});
				}
			}
		});

		$("#item-form .select2").select2();
	});

	(function($) {
		"use strict";

		init_ajax_search('items','#parent_id.ajax-search',undefined, "<?php echo get_uri("warehouse/wh_parent_item_search") ?>");

		$('input[name="description"]' ).change(function() {
			if($( 'input[name="sku_name"]' ).val() == ''){
				$( 'input[name="sku_name"]' ).val($('input[name="description"]' ).val());
			}
		});

		$('select[name="group_id"]').on('change',function(){
			return true;
			var data_select = {};
			data_select.group_id = $('select[name="group_id"]').val();

			$.post("<?php  echo get_uri('warehouse/get_subgroup_fill_data') ?>",data_select).done(function(response){
				response = JSON.parse(response);
				$("select[name='sub_group']").html('');

				$("select[name='sub_group']").append(response.subgroup);
				$("select[name='sub_group']").select2();

				if(sub_group_value != ''){

					$("select[name='sub_group']").val(sub_group_value).change();
					sub_group_value = '';
				}
			});
		});

		$('input[name="purchase_price"]').keyup(function(){
			"use strict";
			var data={};
			data.purchase_price = $('input[name="purchase_price"]').val();
			data.profit_rate = $('input[name="profif_ratio"]').val();

			$.post("<?php  echo get_uri('warehouse/caculator_sale_price') ?>", data).done(function(response) {
				response = JSON.parse(response);
				$('#item-form input[name="rate"]').val(response.sale_price);
			});

		});

		$('input[name="profif_ratio"]').keyup(function(){
			"use strict";
			var data={};
			data.purchase_price = $('input[name="purchase_price"]').val();
			data.profit_rate = $('input[name="profif_ratio"]').val();

			$.post("<?php  echo get_uri('warehouse/caculator_sale_price') ?>", data).done(function(response) {
				response = JSON.parse(response);
				$('#item-form input[name="rate"]').val(response.sale_price);
			});

		});


		$('input[name="rate"]').keyup(function(){
			"use strict";
			var data={};
			data.sale_price = $('input[name="rate"]').val();
			data.profit_rate = $('input[name="profif_ratio"]').val();
			data.purchase_price = $('input[name="purchase_price"]').val();

			if($('input[name="profif_ratio"]').val() != 0 && $('input[name="purchase_price"]').val() != 0){
				$.post("<?php  echo get_uri('warehouse/caculator_profit_rate') ?>", data).done(function(response) {
					response = JSON.parse(response);

					$('#item-form input[name="profif_ratio"]').val(response.profit_rate);

				});
			}else if($('input[name="profif_ratio"]').val() == 0){
				$('input[name="purchase_price"]').val($('input[name="rate"]').val());

			}else if($('input[name="profif_ratio"]').val() != 0){

				$.post("<?php  echo get_uri('warehouse/caculator_purchase_price') ?>", data).done(function(response) {
					response = JSON.parse(response);

					$('#item-form input[name="purchase_price"]').val(response.purchase_price);

				});
			}
		});

		/*update*/
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

		addMoreVendorsInputKey = $('.list_approve').length;
		$("body").on('click', '.new_wh_approval', function() {
			if ($(this).hasClass('disabled')) { return false; }

			var newattachment = $('.list_approve').find('#item_approve').eq(0).clone().appendTo('.list_approve');
			newattachment.find('button[data-toggle="dropdown"]').remove();
			newattachment.find('.select2').select2();


			newattachment.find('button[data-id="name[0]"]').attr('data-id', 'name[' + addMoreVendorsInputKey + ']');
			newattachment.find('label[for="name[0]"]').attr('for', 'name[' + addMoreVendorsInputKey + ']');
			newattachment.find('input[name="name[0]"]').attr('name', 'name[' + addMoreVendorsInputKey + ']');
			newattachment.find('input[id="name[0]"]').attr('id', 'name[' + addMoreVendorsInputKey + ']').val('');

			newattachment.find('button[data-id="options[0]"]').attr('data-id', 'options[' + addMoreVendorsInputKey + ']');
			newattachment.find('label[for="options[0]"]').attr('for', 'options[' + addMoreVendorsInputKey + ']');
			newattachment.find('textarea[name="options[0]"]').attr('name', 'options[' + addMoreVendorsInputKey + ']');
			newattachment.find('textarea[id="options[0]"]').attr('id', 'options[' + addMoreVendorsInputKey + ']').val('');

			newattachment.find('a[name="add"] svg').removeClass('feather-plus-circle').addClass('feather-x-circle');
			newattachment.find('a[name="add"]').find('svg').empty('').html('<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>');

			newattachment.find('a[name="add"]').removeClass('new_wh_approval').addClass('remove_wh_approval').removeClass('btn-success').addClass('btn-danger');
			addMoreVendorsInputKey++;

		});

		$("body").on('click', '.remove_wh_approval', function() {
			$(this).parents('#item_approve').remove();
		});

		$('.account-template-form-submiter').on('click', function() {
			$('input[name="account_template"]').val(account_template.getData());
		});

		/*parent change*/
		$("body").on('change', 'select[name="parent_id"]', function () {

			var parent_id = $('select[name="parent_id"]').val();

			var check_id = $('input[name="id"]').val();
			var parent_data={};
			if(check_id.length > 0){
				parent_data.item_id = $('input[name="id"]').val();
			}else{
				parent_data.item_id = '';
			}
			parent_data.parent_id = $('select[name="parent_id"]').val();
			$.post("<?php  echo get_uri('warehouse/get_variation_from_parent_item') ?>", parent_data).done(function(response) {
				response = JSON.parse(response);

				$('.list_approve').html('');
				$('.list_approve').append(response.variation_html);
				addMoreVendorsInputKey = response.variation_index;


				/*get parent value use for child if is add new*/
				if(check_id.length == 0){

					$('#item-form textarea[name="long_description"]').val(response.parent_value.long_description);
					$('#item-form input[name="title"]').val(response.parent_value.title);
					$('#item-form input[name="description"]').val(response.parent_value.description);
					$('#item-form input[name="sku_name"]').val(response.parent_value.sku_name);
					$('#item-form input[name="purchase_price"]').val(response.parent_value.purchase_price);


					if(response.parent_value.tax != 0){
						$('#item-form select[name="tax"]').val(response.parent_value.tax);
					}else{
						$('#item-form select[name="tax"]').val('');
					}

					if(response.parent_value.tax2 != 0){
						$('#item-form select[name="tax2"]').val(response.parent_value.tax2);
					}else{
						$('#item-form select[name="tax2"]').val('');
					}

					if(response.parent_value.unit_id != 0 ){
						$('#item-form select[name="unit_id"]').val(response.parent_value.unit_id);
					}else{

						$('#item-form select[name="unit_id"]').val('');
					}

					if(response.parent_value.commodity_type != 0){
						$('#item-form select[name="commodity_type"]').val(response.parent_value.commodity_type);

					}else{

						$('#item-form select[name="commodity_type"]').val('');
					}

					if(response.parent_value.sub_group != 0){
						sub_group_value = response.parent_value.sub_group;
					}

					if(response.parent_value.group_id != 0){
						$('#item-form select[name="group_id"]').val(response.parent_value.group_id);

					}else{
						$('#item-form select[name="group_id"]').val('');

					}

					if(response.parent_value.warehouse_id != 0){
						$('#item-form select[name="warehouse_id"]').val(response.parent_value.warehouse_id);
					}else{
						$('#item-form select[name="warehouse_id"]').val('');
					}

					if(response.parent_value.tax != 0){
						$('#item-form select[name="tax"]').val(response.parent_value.tax);
					}else{
						$('#item-form select[name="tax"]').val('');
					}

					$('#item-form input[name="origin"]').val(response.parent_value.origin);
					$('#item-form input[name="rate"]').val(response.parent_value.rate);
					$('#item-form input[name="type_product"]').val(response.parent_value.type_product);
					$('#item-form input[name="guarantee"]').val(response.parent_value.guarantee);
					$('#item-form input[name="profif_ratio"]').val(response.parent_value.profif_ratio);

					if(response.parent_value.style_id != 0){
						$('#item-form select[name="style_id"]').val(response.parent_value.style_id);
					}else{
						$('#item-form select[name="style_id"]').val('');
					}
					if(response.parent_value.model_id != 0){
						$('#item-form select[name="model_id"]').val(response.parent_value.model_id);
					}else{
						$('#item-form select[name="model_id"]').val('');
					}
					if(response.parent_value.size_id != 0){
						$('#item-form select[name="size_id"]').val(response.parent_value.size_id);
					}else{
						$('#item-form select[name="size_id"]').val('');
					}
					if(response.parent_value.sub_group != 0){
						$('#item-form select[name="sub_group"]').val(response.parent_value.sub_group);
					}else{
						$('#item-form select[name="sub_group"]').val('');
					}
					if(response.parent_value.color != 0){
						$('#item-form select[name="color"]').val(response.parent_value.color);
					}else{
						$('#item-form select[name="color"]').val('');
					}
					if(response.parent_value.date_manufacture != 0){
						$('#item-form select[name="date_manufacture"]').val(response.parent_value.date_manufacture);
					}else{
						$('#item-form select[name="date_manufacture"]').val('');
					}
					if(response.parent_value.expiry_date != 0){
						$('#item-form select[name="expiry_date"]').val(response.parent_value.expiry_date);
					}else{
						$('#item-form select[name="expiry_date"]').val('');
					}

					$('textarea[name="long_descriptions"]').val(response.parent_value.long_descriptions);
				}

				$('.select2').select2('destroy');
				$('.select2').select2();


			});

});

})(jQuery); 

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

					if($( "#item-form" ).hasClass( "in" )){
						$('input[name="commodity_barcode"]').val('');
						$('input[name="commodity_barcode"]').focus().val(barcode);
					}else{
						$('#table-table_commodity_list_filter input[type="search"]').val('');
						$('#table-table_commodity_list_filter input[type="search"]').focus().val(barcode);
						$('#table-table_commodity_list_filter input[type="search"]').focusout();
					}
				}
				chars = [];
				pressed = false;
			}, 200);
		}
		pressed = true;
	});
});


/*Maybe items ajax search*/
init_ajax_search('items','#commodity_filter.ajax-search',undefined,"<?php echo get_uri("warehouse/wh_commodity_code_search_all") ?>");

init_ajax_search('items','#item_select_print_barcode.ajax-search',undefined,"<?php echo get_uri("warehouse/wh_commodity_code_search_all") ?>");

</script>