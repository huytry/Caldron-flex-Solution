<script>
	$(document).ready(function () {
		setDatePicker("#from_date,#to_date");
		$(".select2").select2();
	});

	(function($) {

		"use strict";

		var InvoiceServerParams = {
			"from_date": "input[name='from_date']",
			"to_date": "input[name='to_date']",
			"staff_id": "select[name='staff_id[]']",
			"delivery_id": "select[name='delivery_id[]']",
			"status_id": "select[name='status_id[]']",
		};

		var table_manage_packing_list = $('.table-table_manage_packing_list');

		initDataTable(table_manage_packing_list, "<?php echo get_uri("warehouse/table_manage_packing_list") ?>",[],[], InvoiceServerParams, [0 ,'desc']);

		$('.packing_list_sm').DataTable().columns([0]).visible(false, false);

		$('input[name="from_date"], input[name="to_date"], select[name="staff_id[]"], select[name="delivery_id[]"], select[name="status_id[]"]').on('change', function() {
			table_manage_packing_list.DataTable().ajax.reload();
		});


		var hidden_columns = [3,4,5];
	})(jQuery);

</script>