<script>

	(function($) {
		"use strict";

		$(document).ready(function () {
			setDatePicker("#time_filter,#date_create");
			$(".select2").select2();
		});

		var GoodsreceiptParams = {
			"time_filter": "input[name='time_filter']",
			"date_create": "input[name='date_create']",
			"status_filter": "[name='status_filter']",
			"type_filter": "[name='type_filter']",
		};

		var table_loss_adjustment = $('.table-table_loss_adjustment');
		initDataTable(table_loss_adjustment, "<?php echo get_uri("warehouse/table_loss_adjustment") ?>", [], [], GoodsreceiptParams, [0, 'desc']);

		$('#time_filter').on('change', function() {
			table_loss_adjustment.DataTable().ajax.reload();
		});
		$('#date_create').on('change', function() {
			table_loss_adjustment.DataTable().ajax.reload();
		});
		$('#status_filter').on('change', function() {
			table_loss_adjustment.DataTable().ajax.reload();
		});
		$('select[name="type_filter"]').on('change', function() {
			table_loss_adjustment.DataTable().ajax.reload();
		});
	})(jQuery);
	
</script>