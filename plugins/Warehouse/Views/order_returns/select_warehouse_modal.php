<?php echo form_open(get_uri("warehouse/order_return_create_stock_export"), array("id" => "select_warehouse_modal", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<div class="row">
					<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">
					<div class="panel-body mtop10 invoice-item">
						<div class="table-responsive s_table ">
							<table class="table invoice-items-table items table-main-invoice-edit has-calculations no-mtop">
								<thead>
									<tr>
										<th width="50%" align="left" ><?php echo _l('commodity_name'); ?></th>
										<th width="25%" align="left"><?php echo _l('quantity'); ?></th>
										<th width="25%" align="left"><?php echo _l('warehouse_name'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php echo html_entity_decode($html); ?>
								</tbody>
							</table>
						</div>
					</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default close-serial-modal d-none" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>

		<button  type="submit" class="btn btn-info pull-right mright10 text-white"><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></button>

	</div>
</div>
<?php echo form_close(); ?>
<?php require 'plugins/Warehouse/assets/js/order_returns/select_warehouse_modal_js.php';?>