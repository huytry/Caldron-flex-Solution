
<?php echo form_open(get_uri("warehouse/serial_number_modal"), array("id" => "serial_number_modal", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive s_table ">
						<table class="table invoice-items-table items table-main-invoice-edit has-calculations no-mtop">
							<thead>
								<tr>
									<th width="20%" align="left"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" data-title="<?php echo _l('item_description_new_lines_notice'); ?>"></i> <?php echo _l('invoice_table_item_heading'); ?></th>
									<th width="15%" align="left"><?php echo _l('wh_serial_number'); ?></th>
								</tr>
							</thead>
							<tbody class="body_content">
								<?php echo html_entity_decode($table_serial_number); ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default close-serial-modal d-none" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>

		<a href="javascript:void(0)"class="btn btn-info pull-right mright10 display-block btn_submit_multiple_serial_number text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo app_lang('save'); ?></a>
	</div>
</div>
<?php echo form_close(); ?>
<?php require 'plugins/Warehouse/assets/js/goods_deliveries/select_serial_number_modal_js.php';?>
