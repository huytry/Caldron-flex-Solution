<div id="page-content" class="clearfix">
	<?php
	load_css(array(
		"assets/css/invoice.css",
	));
	$internal_delivery_status_label = '';
	?>

	<div class="invoice-preview print-invoice">
		<div class="invoice-preview-container bg-white mt15">
			<div class="row">
				<div class="col-md-12 position-relative">
					<div class="ribbon"><?php echo html_entity_decode($internal_delivery_status_label); ?></div>
				</div>
			</div>

			<?php echo html_entity_decode($internal_delivery_preview); ?>
		</div>

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$("html, body").addClass("dt-print-view");
	});
</script>