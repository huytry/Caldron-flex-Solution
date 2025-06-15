<script>
	var size_type;
	$(document).ready(function () {
		"use strict";
		

		<?php if(isset($size_type_data)){ ?>
			var dataObject_pu = <?php echo json_encode($size_type_data) ; ?>;
		<?php }else{?>
			var dataObject_pu = [];
		<?php } ?>

		setTimeout(function(){

				//hansometable for allowance_no_taxable
				var hotElement1 = document.getElementById('add_handsontable_hs');

				size_type = new Handsontable(hotElement1, {
					contextMenu: true,
					manualRowMove: true,
					manualColumnMove: true,
					stretchH: 'all',
					autoWrapRow: true,
					rowHeights: 30,
					defaultRowHeight: 100,
					maxRows: <?php echo html_entity_decode($max_row) ?>,
					minRows: <?php echo html_entity_decode($min_row) ?>,
					width: '100%',
					height: 350,
					licenseKey: 'non-commercial-and-evaluation',
					rowHeaders: true,
					autoColumnSize: {
						samplingRatio: 23
					},

					minSpareRows: 1,
					filters: true,
					manualRowResize: true,
					manualColumnResize: true,
					allowInsertRow: true,
					allowRemoveRow: true,
					columnHeaderHeight: 40,

					colWidths: [40, 40, 100, 70, 40, 40, 140],
					
					rowHeights: 30,
					rowHeaderWidth: [44],
					hiddenColumns: {
						columns: [0],
						indicators: true
					},

					columns: [
					{
						type: 'text',
						data: 'size_type_id'
					},
					{
						type: 'text',
						data: 'size_code'
					},
					{
						type: 'text',
						data: 'size_name',
					},
					{
						type: 'text',
						data: 'size_symbol',
					},
					
					{
						type: 'numeric',
						data: 'order',
					},
					{
						type: 'checkbox',
						data: 'display',
						checkedTemplate: 'yes',
						uncheckedTemplate: 'no'
					},
					{
						type: 'text',
						data: 'note',
					},

					],


					colHeaders: [
					'<?php echo app_lang("size_type_id") ?>',
					'<?php echo app_lang("size_code") ?>',
					'<?php echo app_lang("size_name") ?>',
					'<?php echo app_lang("size_symbol") ?>',
					'<?php echo app_lang("order") ?>',
					'<?php echo app_lang("display") ?>',
					'<?php echo app_lang("note") ?>',
					],
					
					data: dataObject_pu,
					
				});
			},300);

	});

	$('.submit_commodity_modal').on('click', function() {
		'use strict';

		var valid_edit_multiple_transaction = $('#add_handsontable_hs').find('.htInvalid').html();

		if(valid_edit_multiple_transaction){
			appAlert.warning("<?php echo _l('data_must_number') ; ?>");
		}else{
			$('.submit_commodity_modal').attr( "disabled", "disabled" );
			$('input[name="add_handsontable_hs"]').val(JSON.stringify(size_type.getData()));   
			$('#size_type-form').submit(); 
		}
	});
</script>
