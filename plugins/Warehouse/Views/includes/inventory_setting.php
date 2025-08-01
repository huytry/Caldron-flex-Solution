<?php echo form_open(get_uri("warehouse/inventory_setting"), array("id" => "inventory_setting-form", "class" => "general-form", "role" => "form")); ?>

<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-3 col-lg-2">
			<?php
			$tab_view['active_tab'] = "inventory_setting";
			echo view("Warehouse\Views\includes/tabs", $tab_view);
			?>
		</div>

		<div class="col-sm-9 col-lg-10">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('inventory_config_min'); ?></h4>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<h5 class="no-margin font-bold h5-color"><?php echo _l('inventory_received_note') ?></h5>
							<hr class="hr-color">
						</div>
					</div>

					<div class="form-group">
						<label><?php echo _l('inventory_received_number_prefix'); ?></label>
						<div  class="form-group" app-field-wrapper="inventory_received_number_prefix">
							<input type="text" id="inventory_received_number_prefix" name="inventory_received_number_prefix" class="form-control" value="<?php echo get_setting('inventory_received_number_prefix'); ?>">
						</div>
					</div>

					<div class="form-group">
						<label><?php echo _l('next_inventory_received_mumber'); ?></label>
						<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_inventory_received_mumber_tooltip'); ?>"></i>
						<div  class="form-group" app-field-wrapper="next_inventory_received_mumber">
							<input type="number" min="0" id="next_inventory_received_mumber" name="next_inventory_received_mumber" class="form-control" value="<?php echo get_setting('next_inventory_received_mumber'); ?>">
						</div>
					</div>


					<div class="row">
						<div class="col-md-12">
							<h5 class="no-margin font-bold h5-color"><?php echo _l('inventory_delivery_note') ?></h5>
							<hr class="hr-color">
						</div>
					</div>

					<div class="form-group">
						<label><?php echo _l('inventory_delivery_number_prefix'); ?></label>
						<div class="form-group" app-field-wrapper="inventory_delivery_number_prefix">
							<input type="text" id="inventory_delivery_number_prefix" name="inventory_delivery_number_prefix" class="form-control" value="<?php echo get_setting('inventory_delivery_number_prefix'); ?>">
						</div>
					</div>

					<div class="form-group">
						<label> <?php echo _l('next_inventory_delivery_mumber'); ?></label>
						<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_delivery_received_mumber_tooltip'); ?>"></i>

						<div  class="form-group" app-field-wrapper="next_inventory_delivery_mumber">
							<input type="number" min="0" id="next_inventory_delivery_mumber" name="next_inventory_delivery_mumber" class="form-control" value="<?php echo get_setting('next_inventory_delivery_mumber'); ?>">
						</div>
					</div>


					<div class="row">
						<div class="col-md-12">
							<h5 class="no-margin font-bold h5-color"><?php echo _l('internal_delivery_note') ?></h5>
							<hr class="hr-color">
						</div>
					</div>

					<div class="form-group">
						<label><?php echo _l('internal_delivery_number_prefix'); ?></label>
						<div class="form-group" app-field-wrapper="internal_delivery_number_prefix">
							<input type="text" id="internal_delivery_number_prefix" name="internal_delivery_number_prefix" class="form-control" value="<?php echo get_setting('internal_delivery_number_prefix'); ?>">
						</div>
					</div>

					<div class="form-group">
						<label> <?php echo _l('next_internal_delivery_mumber'); ?></label>
						<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_delivery_received_mumber_tooltip'); ?>"></i>

						<div  class="form-group" app-field-wrapper="next_internal_delivery_mumber">
							<input type="number" min="0" id="next_internal_delivery_mumber" name="next_internal_delivery_mumber" class="form-control" value="<?php echo get_setting('next_internal_delivery_mumber'); ?>">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<h5 class="no-margin font-bold h5-color"><?php echo _l('wh_packing_list') ?></h5>
							<hr class="hr-color">
						</div>
					</div>

					<div class="form-group">
						<label><?php echo _l('packing_list_number_prefix'); ?></label>
						<div class="form-group" app-field-wrapper="packing_list_number_prefix">
							<input type="text" id="packing_list_number_prefix" name="packing_list_number_prefix" class="form-control" value="<?php echo get_setting('packing_list_number_prefix'); ?>">
						</div>
					</div>

					<div class="form-group">
						<label> <?php echo _l('next_packing_list_number'); ?></label>
						<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_delivery_received_mumber_tooltip'); ?>"></i>

						<div  class="form-group" app-field-wrapper="next_packing_list_number">
							<input type="number" min="0" id="next_packing_list_number" name="next_packing_list_number" class="form-control" value="<?php echo get_setting('next_packing_list_number'); ?>">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<h5 class="no-margin font-bold h5-color"><?php echo _l('inventory_receipt_inventory_delivery_returns_goods') ?></h5>
							<hr class="hr-color">
						</div>
					</div>
					<div class="form-group">
						<label><?php echo _l('receipt_return_order_prefix'); ?></label>
						<div class="form-group" app-field-wrapper="order_return_number_prefix">
							<input type="text" id="order_return_number_prefix" name="order_return_number_prefix" class="form-control" value="<?php echo get_setting('order_return_number_prefix'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label> <?php echo _l('next_receipt_return_order'); ?></label>
						<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_delivery_received_mumber_tooltip'); ?>"></i>

						<div  class="form-group" app-field-wrapper="next_order_return_number">
							<input type="number" min="0" id="next_order_return_number" name="next_order_return_number" class="form-control" value="<?php echo get_setting('next_order_return_number'); ?>">
						</div>
					</div>

					<div class="form-group">
						<label><?php echo _l('delivery_return_order_prefix'); ?></label>
						<div class="form-group" app-field-wrapper="e_order_return_number_prefix">
							<input type="text" id="e_order_return_number_prefix" name="e_order_return_number_prefix" class="form-control" value="<?php echo get_setting('e_order_return_number_prefix'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label> <?php echo _l('next_delivery_return_order'); ?></label>
						<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_delivery_received_mumber_tooltip'); ?>"></i>

						<div  class="form-group" app-field-wrapper="e_next_order_return_number">
							<input type="number" min="0" id="e_next_order_return_number" name="e_next_order_return_number" class="form-control" value="<?php echo get_setting('e_next_order_return_number'); ?>"></div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<h5 class="no-margin font-bold h5-color"><?php echo _l('item_sku_prefix') ?></h5>
								<hr class="hr-color">
							</div>
						</div>

						<div class="form-group">
							<label><?php echo _l('item_sku_prefix'); ?></label>
							<div class="form-group" app-field-wrapper="item_sku_prefix">
								<input type="text" id="item_sku_prefix" name="item_sku_prefix" class="form-control" value="<?php echo get_setting('item_sku_prefix'); ?>">
							</div>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary inventory_min_modal"><span data-feather="check-circle" class="icon-16" ></span> <?php echo app_lang('save'); ?></button>
						</div>
						<?php echo form_close(); ?>

					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>