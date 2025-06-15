<script>
	$(document).ready(function () {
		$(".select2").select2();
	});

	(function($) {
		"use strict";
		/*Validate Form*/	
		$("#warehouse-form").appForm({
			ajaxSubmit: false,
			onSuccess: function (result) {
				if (window.refreshAfterUpdate) {
					window.refreshAfterUpdate = false;
					location.reload();
				} else {
					$("#warehouse-table").appTable({newData: result.data, dataId: result.id});
				}
			}
		});
	})(jQuery);
	
</script>