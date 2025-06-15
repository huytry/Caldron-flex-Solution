<?php echo form_open(get_uri("warehouse/serial_number_modal"), array("id" => "serial_number_modal", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<input type="hidden" name="prefix_name" value="<?php echo html_entity_decode($prefix_name); ?>">
				<div class="row">
					<div class="col-md-12">
						<div class="form"> 
							<div id="fill_multiple_serial_number_hs" class="col-md-12 fill_multiple_serial_number handsontable htColumnHeaders">
							</div>
							<?php echo form_hidden('fill_multiple_serial_number_hs'); ?>
						</div>
					</div>
				</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default close-serial-modal" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>

		<a href="javascript:void(0)"class="btn btn-info pull-right mright10 display-block btn_submit_multiple_serial_number text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo app_lang('save'); ?></a>
	</div>
</div>
<?php echo form_close(); ?>
<?php require 'plugins/Warehouse/assets/js/goods_receipts/fill_multiple_serial_number_js.php';?>

