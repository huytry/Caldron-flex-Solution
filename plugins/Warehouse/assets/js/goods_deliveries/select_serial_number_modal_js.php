<script>
	
	$(document).ready(function () {
		$('.serial_number .select2').select2('destroy');
		$('.serial_number .select2').select2();
	});

	$('.btn_submit_multiple_serial_number').on('click', function() {
		'use strict';

		var formdata = $('#serial_number_modal').serializeArray();
		after_wh_add_item_to_table('undefined', 'undefined', formdata);
		$('.close-serial-modal').click();

	});
</script>