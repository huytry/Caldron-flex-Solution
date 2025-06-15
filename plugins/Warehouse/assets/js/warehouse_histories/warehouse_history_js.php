<script>
	$(document).ready(function () {
		setDatePicker("#validity_start_date,#validity_end_date");
		$(".select2").select2();
	});

	(function($) {
		"use strict";

		var ProposalServerParams = {
			"warehouse_ft": "[name='warehouse_filter[]']",
			"commodity_ft": "[name='commodity_filter[]']",
			"status_ft": "[name='status[]']",
			"validity_start_date": "input[name='validity_start_date']",
			"validity_end_date": "input[name='validity_end_date']",

		};

		var  table_warehouse_history = $('table.table-table_warehouse_history');
		var  _table_api = initDataTable(table_warehouse_history, "<?php echo get_uri("warehouse/table_warehouse_history") ?>",[], [], ProposalServerParams, [0, 'desc']);

		$('.table-table_warehouse_history').DataTable().columns([0]).visible(false, false);

		$.each(ProposalServerParams, function(i, obj) {
			$('select' + obj).on('change', function() {  
				table_warehouse_history.DataTable().ajax.reload();
			});
		});

		$('#validity_start_date').on('change', function() {
			table_warehouse_history.DataTable().ajax.reload();
		});
		$('#validity_end_date').on('change', function() {
			table_warehouse_history.DataTable().ajax.reload();
		});
		$('#status').on('change', function() {
			table_warehouse_history.DataTable().ajax.reload();
		});
		// Maybe items ajax search
		init_ajax_search('items','#commodity_filter.ajax-search',undefined,"<?php echo get_uri("warehouse/wh_commodity_code_search_all") ?>");
	})(jQuery);
</script>