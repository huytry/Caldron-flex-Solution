<script>
	$('.select2').select2();
	setDatePicker(".datePickerInput");
	
	function get_data_inventory_valuation_report() {
		"use strict";

		var formData = new FormData();
		formData.append("rise_csrf_token", $('input[name="rise_csrf_token"]').val());
		formData.append("from_date", $('input[name="from_date"]').val());
		formData.append("to_date", $('input[name="to_date"]').val());
		formData.append("warehouse_id", $('select[id="warehouse_filter"]').val());
		$.ajax({ 
			url: "<?php echo get_uri("warehouse/get_data_inventory_valuation_report") ?>", 
			method: 'post', 
			data: formData, 
			contentType: false, 
			processData: false
		}).done(function(response) {
			var response = JSON.parse(response);

			$('#stock_s_report').html('');
			$('#stock_s_report').append(response.value);

		});
	}

	function stock_submit(invoker){
		"use strict";
		$('#print_report').submit(); 
	}
</script>