<script>

	var signaturePad;
	var croppedCtx;

	(function($) {
		"use strict";

		var data_send_mail = {};
		<?php if(isset($send_mail_approve)){ 
			?>
			data_send_mail = <?php echo json_encode($send_mail_approve); ?>;
			data_send_mail.rel_id = <?php echo html_entity_decode($order_return->id); ?>;
			data_send_mail.rel_type = '6';

			data_send_mail.addedfrom = <?php echo html_entity_decode($order_return->staff_id); ?>;

			$.get("<?php echo get_uri("warehouse/send_mail") ?>", data_send_mail).done(function(response){
				response = JSON.parse(response);

			}).fail(function(error) {

			});
		<?php } ?>


		SignaturePad.prototype.toDataURLAndRemoveBlanks = function() {
			var canvas = this._ctx.canvas;
		 // First duplicate the canvas to not alter the original
		 var croppedCanvas = document.createElement('canvas');
		 croppedCtx = croppedCanvas.getContext('2d');

		 croppedCanvas.width = canvas.width;
		 croppedCanvas.height = canvas.height;
		 croppedCtx.drawImage(canvas, 0, 0);

		 // Next do the actual cropping
		 var w = croppedCanvas.width,
		 h = croppedCanvas.height,
		 pix = {
			x: [],
			y: []
		 },
		 imageData = croppedCtx.getImageData(0, 0, croppedCanvas.width, croppedCanvas.height),
		 x, y, index;

		 for (y = 0; y < h; y++) {
			for (x = 0; x < w; x++) {
				index = (y * w + x) * 4;
				if (imageData.data[index + 3] > 0) {
					pix.x.push(x);
					pix.y.push(y);

				}
			}
		 }
		 pix.x.sort(function(a, b) {
			return a - b
		 });
		 pix.y.sort(function(a, b) {
			return a - b
		 });
		 var n = pix.x.length - 1;

		 w = pix.x[n] - pix.x[0];
		 h = pix.y[n] - pix.y[0];
		 var cut = croppedCtx.getImageData(pix.x[0], pix.y[0], w, h);

		 croppedCanvas.width = w;
		 croppedCanvas.height = h;
		 croppedCtx.putImageData(cut, 0, 0);

		 return croppedCanvas.toDataURL();
	 };

	 var canvas = document.getElementById("signature");
	 signaturePad = new SignaturePad(canvas, {
		maxWidth: 2,
		onEnd:function(){
			signaturePadChanged();
		}
	 });

	 $('#identityConfirmationForm').submit(function() {
		signaturePadChanged();
	 });


	 $('select[name="customer_name"]').on('change',function(){

		var data_select = {};
		data_select.userid = $('select[name="customer_name"]').val();

		$.post("<?php echo get_uri("warehouse/get_primary_contact") ?>",data_select).done(function(response){
			response = JSON.parse(response);
			$('input[name="email"]').val(response.primary_email);
		});

	 });


	})(jQuery);

	function signaturePadChanged() {
		"use strict";

		var input = document.getElementById('signatureInput');
		var $signatureLabel = $('#signatureLabel');
		$signatureLabel.removeClass('text-danger');

		if (signaturePad.isEmpty()) {
			$signatureLabel.addClass('text-danger');
			input.value = '';
			return false;
		}

		$('#signatureInput-error').remove();
		var partBase64 = signaturePad.toDataURLAndRemoveBlanks();
		partBase64 = partBase64.split(',')[1];
		input.value = partBase64;
	}




	function signature_clear(){
		"use strict";

		var canvas = document.getElementById("signature");
		var signaturePad = new SignaturePad(canvas, {
			maxWidth: 2,
			onEnd:function(){

			}
		});
		signaturePad.clear();
		$('input[name="signature"]').val('');
		
	}

	function sign_request(id){
		"use strict";
		var signature_val = $('input[name="signature"]').val();
		if(signature_val.length > 0){
			change_request_approval_status(id,1, true);
			$('.sign_request_class').prop('disabled', true);
			$('.sign_request_class').html('<?php echo _l('wait_text'); ?>');
			$('.clear').prop('disabled', true);
		}else{
			appAlert.warning( '<?php echo _l('please_sign_the_form'); ?>');
			$('.sign_request_class').prop('disabled', false);
			$('.clear').prop('disabled', false);
		}
	}

	function approve_request(id){
		"use strict";

	//check before approval
	var data = {};
	data.rel_id = <?php echo html_entity_decode($order_return->id); ?>;
	data.rel_type = '6';
	data.order_rel_type = '<?php echo html_entity_decode($order_return->rel_type); ?>';
	
	data.addedfrom = <?php echo html_entity_decode($order_return->staff_id); ?>;
	$("body").append('<div class="dt-loader"></div>');

	$.post("<?php echo get_uri("warehouse/order_return_check_before_approval") ?>", data).done(function(response){
		response = JSON.parse(response);
		$("body").find('.dt-loader').remove();
		if (response.success === true || response.success == 'true') {
			change_request_approval_status(id,1);
		}else{
			appAlert.warning(response.message);

		}
	});
}
function deny_request(id){
	"use strict";
	change_request_approval_status(id,-1);
}

function change_request_approval_status(id, status, sign_code){
	"use strict";

	var data = {};
	data.rel_id = id;
	data.rel_type = '6';

	data.approve = status;

	if(status == 1){
		
		$('.approve_request_class').prop('disabled', true);
		$('.approve_request_class').html('<?php echo _l('wait_text'); ?>');

		if(sign_code == true){
			data.signature = $('input[name="signature"]').val();
		}else{
			data.note = $('textarea[name="reason"]').val();
		}

		$.post("<?php echo get_uri("warehouse/approve_request/") ?>" + id, data).done(function(response){
			response = JSON.parse(response); 
			if (response.success === true || response.success == 'true') {
				appAlert.success(response.message);
				if( (response.open_warehouse_modal === true || response.open_warehouse_modal == 'true') && response.receipt_delivery_type == 'inventory_delivery_voucher_returned_purchasing_goods'){
					$('#add_action').modal('hide');
					open_warehouse_modal(id, id);
				}else{
					window.location.reload();
				}
			}
		});

	}else{
		if(sign_code == true){
			data.signature = $('input[name="signature"]').val();
		}else{
			data.note = $('textarea[name="reason"]').val();
		}

		$.post("<?php echo get_uri("warehouse/approve_request/") ?>" + id, data).done(function(response){
			response = JSON.parse(response); 
			if (response.success === true || response.success == 'true') {
				appAlert.success(response.message);
				window.location.reload();
			}
		});
	}

}

function send_request_approve(id){
	"use strict";

	var data = {};
	data.rel_id = <?php echo html_entity_decode($order_return->id); ?>;
	data.rel_type = '6';
	data.order_rel_type = '<?php echo html_entity_decode($order_return->rel_type); ?>';
	
	data.addedfrom = <?php echo html_entity_decode($order_return->staff_id); ?>;
	$("body").append('<div class="dt-loader"></div>');

	$.post("<?php echo get_uri("warehouse/send_request_approve") ?>", data).done(function(response){
		response = JSON.parse(response);
		$("body").find('.dt-loader').remove();
		if (response.success === true || response.success == 'true') {
			appAlert.success(response.message);

			window.location.reload();
		}else{
			appAlert.warning(response.message);

		}
	});
}

function accept_action() {
	"use strict";
	$('#add_action').modal('show');
}

function get_goods_delivery_ajax(id, invoice_id) {
	"use strict"; 
	var data={};
	data.id =  id;

	$.post("<?php echo get_uri("warehouse/get_delivery_ajax") ?>", data).done(function(response){
		response = JSON.parse(response);

		$("select[name='customer_name']").html('');
		$("select[name='customer_name']").append(response.options);
		$('input[name="email"]').val(response.primary_email);

		$("select[name='customer_name']").selectpicker('refresh');
	});

	$('#additional_goods_delivery').html('');
	$('#additional_goods_delivery').append(hidden_input('goods_delivery',id));

	$('#goods_delivery_invoice_id').html('');
	$('#goods_delivery_invoice_id').append(hidden_input('invoice_id',invoice_id));

	$('#send_goods_delivery').modal('show');
}

	// Manually add goods delivery activity
	$("#wh_enter_activity").on('click', function() {
		"use strict"; 

		var message = $('#wh_activity_textarea').val();
		var goods_delivery_id = $('input[name="_attachment_sale_id"]').val();

		if (message === '') { return; }

		$.post("<?php echo get_uri("warehouse/wh_add_activity") ?>", {
			goods_delivery_id: goods_delivery_id,
			activity: message,
			rel_type: 'order_return',
		}).done(function(response) {
			response = JSON.parse(response);
			if(response.status == true){

				appAlert.success(response.message);
				$('.activity-feed').append(response.activity_log_html);
			}else{
				appAlert.warning(response.message);
			}
		}).fail(function(data) {
			appAlert.warning(data.message);
		});
	});

	function delete_wh_activitylog(wrapper, id) {
		"use strict"; 

		if (confirm_delete()) {
			requestGetJSON("<?php echo get_uri("warehouse/delete_activitylog/") ?>" + id).done(function(response) {
				if (response.success === true || response.success == 'true') { $(wrapper).parents('.feed-item').remove(); }
			}).fail(function(data) {
				appAlert.warning(data.responseText);
			});
		}
	}

	$('.show_approve').on('click', function() {
		"use strict";

		$('#approve_modal').modal('show');
	});

	/*print invoice*/
	$("#print-invoice-btn").click(function () {
		appLoader.show();

		$.ajax({
			url: "<?php echo get_uri('warehouse/print_order_return/' . $order_return->id) ?>",
			dataType: 'json',
			success: function (result) {
				if (result.success) {
					document.body.innerHTML = result.print_view;  /*add invoice's print view to the page*/
					$("html").css({"overflow": "visible"});

					setTimeout(function () {
						window.print();
					}, 200);
				} else {
					appAlert.error(result.message);
				}

				appLoader.hide();
			}
		});
	});

	/*reload page after finishing print action*/
	window.onafterprint = function () {
		location.reload();
	};
	

	

	function open_warehouse_modal(iv, order_return_id) {
				var data = {ajaxModal: 1},
		isLargeModal = $(this).attr('data-modal-lg'),
		isFullscreenModal = $(this).attr('data-modal-fullscreen'),
		title = "<?php echo app_lang("select_warehouse_to_create_inventory_delivery") ?>";

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
			url: "<?php echo get_uri("warehouse/open_warehouse_modal") ?>",
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
	}

</script>

