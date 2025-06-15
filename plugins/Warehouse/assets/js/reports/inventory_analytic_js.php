<script>
	(function($) {
		"use strict";

		$('.select2').select2();

		var ProposalServerParams = {
			"commodity_ft": "[name='commodity_filter[]']",
			"profit_rate_search": "[name='profit_rate_search']",
			"warehouse_filter": "[name='warehouse_filter[]']",
		};

		var table_inventory_inside = $('table.table-table_inventory_inside');

		var _table_api = initDataTable(table_inventory_inside, "<?php echo get_uri("warehouse/table_inventory_inside") ?>", [0], [0], ProposalServerParams, [6, 'desc']);

		$.each(ProposalServerParams, function(i, obj) {
			$('select' + obj).on('change', function() {  
				table_inventory_inside.DataTable().ajax.reload();
			});
		});

		$('#profit_rate_search').on('change', function() {
			table_inventory_inside.DataTable().ajax.reload();
		});

		$('#warehouse_filter').on('change', function() {
			table_inventory_inside.DataTable().ajax.reload();
		});

    // Maybe items ajax search
    init_ajax_search('items','#commodity_filter.ajax-search',undefined,"<?php echo get_uri("warehouse/wh_commodity_code_search_all") ?>");

})(jQuery);

</script>