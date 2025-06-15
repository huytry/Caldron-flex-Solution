<?php echo form_open(get_uri("warehouse/approval_setting/".$id), array("id" => "approval_setting-form", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">

					<?php 
					$related = [];
					$related = [ 
						0 => ['id' => 1, 'name' => _l('stock_import')],
						1 => ['id' => 2, 'name' => _l('stock_export')],
						2 => ['id' => 3, 'name' => _l('loss_adjustment')],
						3 => ['id' => 4, 'name' => _l('internal_delivery_note')],
						4 => ['id' => 5, 'name' => _l('wh_packing_list')],
						5 => ['id' => 6, 'name' => _l('wh_order_return')],
					];

					$name_value = '';
					$related_value = '';
					if(isset($approval_setting)){
						$name_value = $approval_setting->name;
						$related_value = $approval_setting->related;
					}

					?>

					<?php echo render_input1('name','_subject',$name_value,'text', [], [], '', '', true); ?>
					<?php echo render_select1('related',$related,array('id','name'),'related_type', $related_value, [], [], '', '', false); ?>

					<div class=" ">
						<div class="invoice-items-table items table-main-invoice-edit has-calculations">
							<?php echo html_entity_decode($create_approval_setting_row_template); ?>
						</div>

						<div id="removed-items"></div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
		<button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16" ></span> <?php echo app_lang('save'); ?></button>

	</div>
</div>
<?php echo form_close(); ?>
<?php require('plugins/Warehouse/assets/js/settings/modal_forms/approval_setting_modal_js.php'); ?>
