<script>

	$(document).ready(function () {
		setDatePicker("#from_date, #to_date");
		$(".select2").select2();
	});

	(function($) {

		"use strict";

		var InvoiceServerParams = {
			"from_date": "input[name='from_date']",
			"to_date": "input[name='to_date']",
			"staff_id": "select[name='staff_id[]']",
			"delivery_id": "select[name='delivery_id[]']",
			"rel_type_filter": "select[name='rel_type_filter[]']",
			"status_id": "select[name='status_id[]']",
			"receipt_delivery_type": "select[name='receipt_delivery_type[]']",

		};


		var table_manage_order_return = $('.table-table_manage_order_return');
		initDataTable(table_manage_order_return, "<?php echo get_uri("warehouse/table_manage_order_return") ?>",[],[], InvoiceServerParams, [0 ,'desc']);

		$('.order_return_sm').DataTable().columns([0]).visible(false, false);

		$('input[name="from_date"], input[name="to_date"], select[name="staff_id[]"], select[name="delivery_id[]"], select[name="rel_type_filter[]"], select[name="status_id[]"], select[name="receipt_delivery_type[]"]').on('change', function() {
			table_manage_order_return.DataTable().ajax.reload();
		});

	})(jQuery);


	function open_warehouse_modal(iv, order_return_id) {
				var data = {ajaxModal: 1},
		isLargeModal = $(this).attr('data-modal-lg'),
		isFullscreenModal = $(this).attr('data-modal-fullscreen'),
		title = "<?php echo app_lang("wh_select_the_serial_number") ?>";

		if (title) {
			$("#ajaxModalTitle").html(title);
		} else {
			$("#ajaxModalTitle").html($("#ajaxModalTitle").attr('data-title'));
		}

		if ($(this).attr("data-post-hide-header")) {
			$("#ajaxModal .modal-header").addClass("hide");
			$("#ajaxModal .modal-footer").addClass("hide");
		} else {
			$("#ajaxModal .modal-header").removeClass("hide");
			$("#ajaxModal .modal-footer").removeClass("hide");
		}

		$("#ajaxModalContent").html($("#ajaxModalOriginalContent").html());
		$("#ajaxModalContent").find(".original-modal-body").removeClass("original-modal-body").addClass("modal-body");
		$("#ajaxModal").modal('show');
		$("#ajaxModal").find(".modal-dialog").removeClass("custom-modal-lg");
		$("#ajaxModal").find(".modal-dialog").removeClass("modal-fullscreen");
		$(".modal-backdrop").remove();

		data.order_return_id = order_return_id;

		ajaxModalXhr = $.ajax({
			url: "<?php echo get_uri("warehouse/load_serial_number_modal") ?>",
			data: data,
			cache: false,
			type: 'POST',
			success: function (response) {
				$("#ajaxModal").find(".modal-dialog").removeClass("mini-modal");
				if (isLargeModal === "1") {
					$("#ajaxModal").find(".modal-dialog").addClass("custom-modal-lg");
				} else if (isFullscreenModal === "1") {
					$("#ajaxModal").find(".modal-dialog").addClass("modal-fullscreen");
				}
				$("#ajaxModalContent").html(response);

				setSummernoteToAll(true);
				setModalScrollbar();

				feather.replace();
			},
			statusCode: {
				404: function () {
					$("#ajaxModalContent").find('.modal-body').html("");
					appAlert.error("404: Page not found.", {container: '.modal-body', animate: false});
				}
			},
			error: function () {
				$("#ajaxModalContent").find('.modal-body').html("");
				appAlert.error("500: Internal Server Error.", {container: '.modal-body', animate: false});
			}
		});
		return false;


		$("#warehouse_modal_wrapper").load("<?php echo get_uri('warehouse/warehouse/open_warehouse_modal'); ?>", {
			order_return_id:order_return_id,
		}, function() {

			$("body").find('#warehouse_modal').modal({ show: true, backdrop: 'static' });
		});
	}


</script>