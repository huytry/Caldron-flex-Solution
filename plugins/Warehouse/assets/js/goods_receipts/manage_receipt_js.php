<script>

	$(document).ready(function () {
		setDatePicker("#date_add");
		$(".select2").select2();
	});

	var GoodsreceiptParams = {
		"day_vouchers": "input[name='date_add']",
	};

	var table_manage_goods_receipt = $('.table-table_manage_goods_receipt');
	initDataTable(table_manage_goods_receipt, "<?php echo get_uri("warehouse/table_manage_goods_receipt") ?>", [], [], GoodsreceiptParams, [0, 'desc']);

	$('.purchase_sm').DataTable().columns([0]).visible(false, false);

	$('#date_add').on('change', function() {
		table_manage_goods_receipt.DataTable().ajax.reload();
	});

</script>