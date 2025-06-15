<script> 
	/*load table*/
	$(document).ready(function () {
      "use strict"
		
		$("#commodity_type-table").appTable({
			source: '<?php echo get_uri("warehouse/list_commodity_type_data") ?>',
			order: [[0, 'desc']],
			filterDropdown: [
			],
			columns: [
			{title: "<?php echo app_lang('_order') ?> ", "class": "w20p"},
			{title: "<?php echo app_lang('commodity_type_code') ?>"},
			{title: "<?php echo app_lang('commodity_type_name') ?>"},
			{title: "<?php echo app_lang('display') ?>", "class": "text-right w100"},
			{title: "<?php echo app_lang('note') ?>", "class": "text-right w100"},
			{title: "<i data-feather='menu' class='icon-16'></i>", "class": "text-center option w100"}
			],
			printColumns: [0, 1, 2, 3, 4],
			xlsColumns: [0, 1, 2, 3, 4]
		});
	});

</script>