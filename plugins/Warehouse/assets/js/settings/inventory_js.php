<script>
	var inventory_min;
	$(document).ready(function () {
      "use strict"
		

		<?php if(isset($inventory_min_data)){ ?>
			var dataObject_pu = <?php echo json_encode($inventory_min_data) ; ?>;
		<?php }else{?>
			var dataObject_pu = [];
		<?php } ?>

		setTimeout(function(){

				//hansometable for allowance_no_taxable
				var hotElement1 = document.getElementById('add_handsontable_hs');

				inventory_min = new Handsontable(hotElement1, {
					contextMenu: true,
					manualRowMove: true,
					manualColumnMove: true,
					stretchH: 'all',
					autoWrapRow: true,
					rowHeights: 30,
					defaultRowHeight: 100,
					width: '100%',
					height: 500,

					rowHeaders: true,
					hiddenColumns: {
						columns: [0, 1],
						indicators: true
					},
					autoColumnSize: {
						samplingRatio: 23
					},
					licenseKey: 'non-commercial-and-evaluation',
					filters: true,
					manualRowResize: true,
					manualColumnResize: true,
					allowInsertRow: false,
					allowRemoveRow: false,
					columnHeaderHeight: 40,

					rowHeights: 30,
					rowHeaderWidth: [44],
					columnSorting: true,
					columnSorting: {
						sortEmptyCells: true,
						initialConfig: {
							column: 2,
							sortOrder: 'asc'
						}
					},

					columns: [
					{
						type: 'text',
						data: 'id'
					},
					{
						type: 'text',
						data: 'commodity_id'
					},
					{
						type: 'text',
						data: 'commodity_code',
					},
					{
						type: 'text',
						data: 'commodity_name',
					},
					{
						type: 'text',
						data: 'sku_code',
					},
					{
						type: 'numeric',
						data: 'inventory_number_min',
						numericFormat: {
							pattern: '0,00',
						}
					},

					{
						type: 'numeric',
						data: 'inventory_number_max',
						numericFormat: {
							pattern: '0,00',
						}
					},

					],


					colHeaders: [
					'<?php echo _l('id'); ?>',
					'<?php echo _l('commodity_id'); ?>',
					'<?php echo _l('commodity_code'); ?>',
					'<?php echo _l('commodity_name'); ?>',
					'<?php echo _l('sku_code'); ?>',
					'<?php echo _l('inventory_minimum'); ?>',
					'<?php echo _l('inventory_maximum'); ?>',
					],
					
					data: dataObject_pu,
					
				});
			},300);

	});

	$('.inventory_min_modal').on('click', function() {
		'use strict';

		var valid_edit_multiple_transaction = $('#add_handsontable_hs').find('.htInvalid').html();

		if(valid_edit_multiple_transaction){
			appAlert.warning("<?php echo _l('data_must_number') ; ?>");
		}else{
			$('.inventory_min_modal').attr( "disabled", "disabled" );
			$('input[name="add_handsontable_hs"]').val(JSON.stringify(inventory_min.getData()));   
			$('#inventory_min-form').submit(); 
		}
	});

	//filter
	function maximum_minimum_inventory_filter(invoker){
		'use strict';

		var data = {};
		data.inventory_filter = $('input[name="inventory_filter"]').val();

		$.post("<?php  echo get_uri('warehouse/maximum_minimum_inventory_filter'); ?>", data).done(function(response){
			response = JSON.parse(response);
			inventory_min.updateSettings({
				data: response.data_object,
			})
		});
	};

	$('#inventory_filter').on('keyup', function() {
		'use strict';
		
		maximum_minimum_inventory_filter();
	});
</script>
