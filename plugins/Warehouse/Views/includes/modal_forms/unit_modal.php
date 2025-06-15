<?php echo form_open(get_uri("warehouse/unit_type/".$id), array("id" => "unit_type-form", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div id="unit_type_id">
					</div>   
					<div class="form"> 
						<div id="add_handsontable_hs" class="col-md-12 add_handsontable handsontable htColumnHeaders">

						</div>
						<?php echo form_hidden('add_handsontable_hs'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
		<button type="button" class="btn btn-primary submit_commodity_modal"><span data-feather="check-circle" class="icon-16" ></span> <?php echo app_lang('save'); ?></button>
	</div>
</div>
<?php echo form_close(); ?>
<?php require('plugins/Warehouse/assets/js/settings/modal_forms/unit_modal_js.php'); ?>
