 <script>
 	(function($) {
 		"use strict";

 		$('input[name="commodity_id"]').val("<?php echo html_entity_decode($commodity_item->id) ;?>");

	//inventory stock
	var ProposalServerParams = {
		"warehouse_ft": "[name='warehouse_filter[]']",
		"commodity_ft": "[name='commodity_id']",
		"alert_filter": "[name='alert_filter']",
	};
	var table_inventory_stock = $('table.table-table_inventory_stock');

	var  _table_api = initDataTable(table_inventory_stock, "<?php echo get_uri("warehouse/table_inventory_stock") ?>", [], [], ProposalServerParams, [0, 'desc']);

	$('.table-table_inventory_stock').DataTable().columns([0]).visible(false, false);

	$.each(ProposalServerParams, function(i, obj) {
		$('select' + obj).on('change', function() {  
			table_inventory_stock.DataTable().ajax.reload();
		});
	});

	//expriry date
	var ProposalServerParams = {
		"warehouse_ft": "[name='warehouse_filter[]']",
		"commodity_ft": "[name='commodity_id']",
		"alert_filter": "[name='alert_filter']",
	};
	var table_view_commodity_detail = $('table.table-table_view_commodity_detail');

	var  _table_api = initDataTable(table_view_commodity_detail, "<?php echo get_uri("warehouse/table_view_commodity_detail") ?>", [], [], ProposalServerParams);
	$.each(ProposalServerParams, function(i, obj) {
		$('select' + obj).on('change', function() {  
			table_view_commodity_detail.DataTable().ajax.reload();
		});
	});

	$('input[name="commodity_id"]').val("<?php echo html_entity_decode($commodity_item->id) ;?>");
	var ProposalServerParams = {
		"warehouse_ft": "[name='warehouse_filter[]']",
		"commodity_ft": "[name='commodity_filter[]']",
		"alert_filter": "[name='alert_filter']",
		"item_filter": "[name='item_filter[]']",
		"parent_item": "[name='parent_item_filter']",
		"sub_commodity_ft": "[name='commodity_id']",
	};



	var table_commodity_list = $('table.table-table_commodity_list');
	var _table_api = initDataTable(table_commodity_list, "<?php echo get_uri("warehouse/table_commodity_list") ?>", [0], [0], ProposalServerParams,  [1, 'desc']);
	$.each(ProposalServerParams, function(i, obj) {
		$('select' + obj).on('change', function() {  
			table_commodity_list.DataTable().ajax.reload();
		});
	});




//transaction, history
var ProposalServerParams = {
	"warehouse_ft": "[name='warehouse_filter[]']",
	"commodity_ft": "[name='commodity_id']",

};

var   table_warehouse_history = $('table.table-table_warehouse_history');

var  _table_api = initDataTable(table_warehouse_history, "<?php echo get_uri("warehouse/table_warehouse_history") ?>", [], [], ProposalServerParams, [0, 'desc']);

$('.table-table_warehouse_history').DataTable().columns([0]).visible(false, false);

$.each(ProposalServerParams, function(i, obj) {
	$('select' + obj).on('change', function() {  
		table_warehouse_history.DataTable().ajax.reload();
	});
});

init_ajax_search('items','#item_select_print_barcode.ajax-search',undefined, "<?php echo get_uri("warehouse/wh_commodity_code_search_all") ?>");

})(jQuery);

</script>