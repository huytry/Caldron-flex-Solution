<div id="page-content" class="page-wrapper clearfix">
	<div class="row">

		<div class="col-sm-3 col-lg-2">
			<?php
			$tab_view['active_tab'] = "general";
			echo view("Warehouse\Views\includes/tabs", $tab_view);
			?>
		</div>

		<div class="col-sm-9 col-lg-10">

			<div class="card">
				<div class="card-header ">

					<ul class="nav nav-tabs pb15 justify-content-left border-bottom-0" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="tab_items-tab" data-bs-toggle="tab" data-bs-target="#tab_items" type="button" role="tab" aria-controls="tab_items" aria-selected="true"><?php echo _l('items'); ?></button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="tab_receipt_delivery-tab" data-bs-toggle="tab" data-bs-target="#tab_receipt_delivery" type="button" role="tab" aria-controls="tab_receipt_delivery" aria-selected="false"><?php echo _l('wh_receipt_delivery_voucher'); ?></button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="tab_order_return-tab" data-bs-toggle="tab" data-bs-target="#tab_order_return" type="button" role="tab" aria-controls="tab_order_return" aria-selected="false"><?php echo _l('inventory_receipt_inventory_delivery_returns_goods'); ?></button>
						</li>
						<li class="nav-item d-none" role="presentation">
							<button class="nav-link" id="tab_pdf-tab" data-bs-toggle="tab" data-bs-target="#tab_pdf" type="button" role="tab" aria-controls="tab_pdf" aria-selected="false"><?php echo _l('wh_pdf'); ?></button>
						</li>
						<li class="nav-item d-none" role="presentation">
							<button class="nav-link" id="tab_shipment-tab" data-bs-toggle="tab" data-bs-target="#tab_shipment" type="button" role="tab" aria-controls="tab_shipment" aria-selected="false"><?php echo _l('wh_shipments'); ?></button>
						</li>

					</ul>
				</div>

				<div class="card-body">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="tab_items" role="tabpanel" aria-labelledby="tab_items-tab">

							<div class="row">
								<div class="col-md-12">
									<h5 class="no-margin font-bold h5-color"><?php echo _l('_profit_rate_p') ?></h5>
									<hr class="hr-color">
								</div>
							</div>
							<div class="form-group">
								<div onchange="setting_rule_sale_price(this); return false" class="form-group" app-field-wrapper="warehouse_selling_price_rule_profif_ratio">
									<input type="number" min="0" max="100" id="warehouse_selling_price_rule_profif_ratio" name="warehouse_selling_price_rule_profif_ratio" class="form-control" value="<?php echo get_setting('warehouse_selling_price_rule_profif_ratio'); ?>">
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h5 class="no-margin font-bold h5-color"><?php echo _l('rate') ?></h5>
									<hr class="hr-color">
								</div>
							</div>

							<div class="form-group">
								<div class="radio radio-primary radio-inline" >
									<input class="form-check-input" onchange="setting_profit_rate(this); return false" type="radio" id="y_opt_1_" name="profit_rate_by_purchase_price_sale" value="0" <?php if(get_setting('profit_rate_by_purchase_price_sale') == '0'){ echo "checked" ;}; ?>>
									<label for="y_opt_1_"><?php echo _l('warehouse_profit_rate_sale_price'); ?></label>

									<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('profit_rate_sale_price'); ?>"></i></a>
								</div>
							</div>

							<div class="form-group">
								<div class="radio radio-primary radio-inline" >
									<input class="form-check-input" onchange="setting_profit_rate(this); return false" type="radio" id="y_opt_2_" name="profit_rate_by_purchase_price_sale" value="1" <?php if(get_setting('profit_rate_by_purchase_price_sale') == '1'){ echo "checked" ;}; ?>>
									<label for="y_opt_2_"><?php echo _l('warehouse_profit_rate_purchase_price'); ?></label>

									<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('profit_rate_purchase_price'); ?>"></i></a>
								</div>
							</div>

							<div class="row">
								<div class="col-md-5">
									<label for="y_opt_2_"><?php echo _l('the_fractional_part'); ?></label>
								</div>
								<div class="col-md-2">
									<input onchange="setting_rules_for_rounding_prices(this); return false" type="number" min="0" max="100" step="1" id="warehouse_the_fractional_part" name="warehouse_the_fractional_part" class="form-control" value="<?php echo get_setting('warehouse_the_fractional_part'); ?>">
								</div>
							</div>

							<br/>
							<div class="row">
								<div class="col-md-5">
									<label for="y_opt_2_"><?php echo _l('integer_part'); ?></label>
								</div>
								<div class="col-md-2">
									<input onchange="setting_rules_for_rounding_prices(this); return false" type="number" min="0" max="100" step="1" id="warehouse_integer_part" name="warehouse_integer_part" class="form-control" value="<?php echo get_setting('warehouse_integer_part'); ?>">
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h5 class="no-margin font-bold h5-color" ><?php echo _l('barcode_setting')?></h5>
									<hr class="hr-color" >
								</div>
							</div>
							<div class="row hide">
								<div class="col-md-12">
									<div class="form-group">
										<div class="checkbox checkbox-primary">
											<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="barcode_with_sku_code" name="purchase_setting[barcode_with_sku_code]" <?php if(get_setting('barcode_with_sku_code') == 1 ){ echo 'checked';} ?> value="barcode_with_sku_code">
											<label for="barcode_with_sku_code"><?php echo _l('barcode_equal_sku_code'); ?>
											<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('create_barcode_equal_sku_code_tooltip'); ?>"></i></a>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<div class="checkbox checkbox-primary">
										<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="display_product_name_when_print_barcode" name="purchase_setting[display_product_name_when_print_barcode]" <?php if(get_setting('display_product_name_when_print_barcode') == 1 ){ echo 'checked';} ?> value="display_product_name_when_print_barcode">
										<label for="display_product_name_when_print_barcode"><?php echo _l('display_product_name_when_print_barcode'); ?>
										<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('display_only_the_first_50'); ?>"></i></a>
									</label>
								</div>
							</div>
						</div>
					</div>

					<?php if ($login_user->is_admin) { ?>
						<div class="row">
							<div class="col-md-12">
								<h5 class="no-margin font-bold h5-color" ><?php echo _l('button_update_do_not_update_inventory_numbers')?></h5>
								<hr class="hr-color" >
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<?php echo form_open_multipart(get_uri('warehouse/update_unchecked_inventory_numbers'), array('id'=>'update_unchecked_inventory_numbers')); ?>
								<div class="_buttons">
									<div class="row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-info text-white"  ><?php echo _l('update'); ?></button>
											<a href="#" class="input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('update_unchecked_inventory_numbers_title'); ?>"></i></a>
										</div>
									</div>

								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					<?php } ?>


				</div>
				<div class="tab-pane fade" id="tab_receipt_delivery" role="tabpanel" aria-labelledby="tab_receipt_delivery-tab">
					<div class="row">
						<div class="col-md-12">
							<h5 class="no-margin font-bold h5-color" ><?php echo _l('wh_general')?></h5>
							<hr class="hr-color" >
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="checkbox checkbox-primary">
									<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="revert_goods_receipt_goods_delivery" name="purchase_setting[revert_goods_receipt_goods_delivery]" <?php if(get_setting('revert_goods_receipt_goods_delivery') == 1 ){ echo 'checked';} ?> value="revert_goods_receipt_goods_delivery">
									<label for="revert_goods_receipt_goods_delivery"><?php echo _l('delete_goods_receipt_goods_delivery'); ?>
									<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('delete_goods_receipt_goods_delivery_tooltip'); ?>"></i></a>
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<h5 class="no-margin font-bold h5-color" ><?php echo _l('export_method')?></h5>
						<hr class="hr-color" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-5">
						<?php 
						$method_fifo_data = [];
						$method_fifo_data[] = [
							'name' => 'method_fifo',
							'lable' => _l('method_fifo'),
						]
						 ?>
						<?php echo render_select1('method_fifo',$method_fifo_data,array('name','lable'),'', 'method_fifo', [], [], '', '', false); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<h5 class="no-margin font-bold h5-color" ><?php echo _l('goods_receipt')?></h5>
						<hr class="hr-color" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="vendor"></label>
							<div class="checkbox checkbox-primary">
								<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="auto_create_goods_received" name="auto_create_goods_received" <?php if(get_setting('auto_create_goods_received') == 1 ){ echo 'checked';} ?> value="auto_create_goods_received">
								<label for="auto_create_goods_received"><?php echo _l('create_goods_received_note'); ?>
								<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('create_goods_received_note_tooltip'); ?>"></i></a>
							</label>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="select-placeholder form-group" app-field-wrapper="goods_receipt_warehouse">
						<label for="goods_receipt_warehouse" class="control-label"><?php echo _l('goods_receipt_warehouse'); ?></label>
						<select onchange="goods_receipt_warehouse_change(this); return false" name="goods_receipt_warehouse" class="select2 validate-hidden" id="goods_receipt_warehouse" data-width="100%" data-none-selected-text="<?php echo _l('warehouse_name'); ?>"> 
							<option value=""></option>
							<?php foreach($warehouses as $wh){ ?>
								<option value="<?php echo html_entity_decode($wh['warehouse_id']); ?>" <?php if(get_setting('goods_receipt_warehouse') == $wh['warehouse_id']){ echo 'selected';} ?> ><?php echo html_entity_decode($wh['warehouse_code'].'_'.$wh['warehouse_name']); ?></option>
							<?php } ?>
						</select>
					</div>  
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="checkbox checkbox-primary">
							<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="goods_receipt_required_po" name="purchase_setting[goods_receipt_required_po]" <?php if(get_setting('goods_receipt_required_po') == 1 ){ echo 'checked';} ?> value="goods_receipt_required_po">
							<label for="goods_receipt_required_po"><?php echo _l('goods_receipt_required_po'); ?></label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<h5 class="no-margin font-bold h5-color" ><?php echo _l('stock_export')?></h5>
					<hr class="hr-color" >
				</div>
			</div>
			<div class="row d-none">
				<div class="col-md-12">
					<div class="form-group">
						<div class="checkbox checkbox-primary">
							<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="auto_create_goods_delivery" name="purchase_setting[auto_create_goods_delivery]" <?php if(get_setting('auto_create_goods_delivery') == 1 ){ echo 'checked';} ?> value="auto_create_goods_delivery">
							<label for="auto_create_goods_delivery"><?php echo _l('create_goods_delivery_note'); ?>
							<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('create_goods_delivery_note_tooltip'); ?>"></i></a>
						</label>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<div class="checkbox checkbox-primary">
						<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="cancelled_invoice_reverse_inventory_delivery_voucher" name="purchase_setting[cancelled_invoice_reverse_inventory_delivery_voucher]" <?php if(get_setting('cancelled_invoice_reverse_inventory_delivery_voucher') == 1 ){ echo 'checked';} ?> value="cancelled_invoice_reverse_inventory_delivery_voucher">
						<label for="cancelled_invoice_reverse_inventory_delivery_voucher"><?php echo _l('cancelled_invoice_reverse_inventory_delivery_voucher_note'); ?>
						<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title=""></i></a>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="checkbox checkbox-primary">
					<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="uncancelled_invoice_create_inventory_delivery_voucher" name="purchase_setting[uncancelled_invoice_create_inventory_delivery_voucher]" <?php if(get_setting('uncancelled_invoice_create_inventory_delivery_voucher') == 1 ){ echo 'checked';} ?> value="uncancelled_invoice_create_inventory_delivery_voucher">
					<label for="uncancelled_invoice_create_inventory_delivery_voucher"><?php echo _l('uncancelled_invoice_create_inventory_delivery_voucher_note'); ?>
					<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title=""></i></a>
				</label>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<div class="checkbox checkbox-primary">
				<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="goods_delivery_required_po" name="purchase_setting[goods_delivery_required_po]" <?php if(get_setting('goods_delivery_required_po') == 1 ){ echo 'checked';} ?> value="goods_delivery_required_po">
				<label for="goods_delivery_required_po"><?php echo _l('goods_delivery_required_po'); ?></label>
			</div>
		</div>
	</div>
</div>

</div>


<div class="tab-pane fade" id="tab_order_return" role="tabpanel" aria-labelledby="tab_order_return-tab">

	<div class="row hide">
		<div class="col-md-12">
			<h5 class="no-margin font-bold h5-color"><?php echo _l('return_request_must_be_placed_within_X_days_after_the_delivery_date') ?></h5>
			<hr class="hr-color">
		</div>
	</div>
	<div class="form-group hide">
		<div onchange="setting_rule_sale_price(this); return false" class="form-group" app-field-wrapper="wh_return_request_within_x_day">
			<input type="number" min="0" max="100" id="wh_return_request_within_x_day" name="wh_return_request_within_x_day" class="form-control" value="<?php echo get_setting('wh_return_request_within_x_day'); ?>">
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h5 class="no-margin font-bold h5-color" ><?php echo _l('warehouse_receive_return_order') ?></h5>
			<hr class="hr-color">
		</div>
	</div>
	<div class=" form-group">
		<select onchange="goods_receipt_warehouse_change(this); return false" name="warehouse_receive_return_order" class="select2 validate-hidden" id="warehouse_receive_return_order" data-width="100%" data-none-selected-text="<?php echo _l('warehouse_name'); ?>"> 
			<option value=""></option>
			<?php foreach($warehouses as $wh){ ?>
				<option value="<?php echo html_entity_decode($wh['warehouse_id']); ?>" <?php if(get_setting('warehouse_receive_return_order') == $wh['warehouse_id']){ echo 'selected="selected"';} ?> ><?php echo html_entity_decode($wh['warehouse_code'].'_'.$wh['warehouse_name']); ?></option>
			<?php } ?>
		</select>
	</div>  

	<div class="row">
		<div class="col-md-12">
			<h5 class="no-margin font-bold h5-color" data-toggle="tooltip" title="" data-original-title="<?php echo _l('fee_for_return_order_tooltip'); ?>"><?php echo _l('fee_for_return_order') ?></h5>
			<hr class="hr-color">
		</div>
	</div>
	<div class="form-group">
		<div onchange="warehouse_fee_return_order(this); return false" class="form-group" app-field-wrapper="wh_fee_for_return_order">
			<input type="number" min="0" max="100" id="wh_fee_for_return_order" name="wh_fee_for_return_order" class="form-control" value="<?php echo get_setting('wh_fee_for_return_order'); ?>" data-toggle="tooltip" title="" data-original-title="<?php echo _l('fee_for_return_order_tooltip'); ?>">
		</div>
	</div>

	<div class="row hide">
		<div class="col-md-12">
			<div class="form-group">
				<div class="checkbox checkbox-primary">
					<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="wh_refund_loyaty_point" name="purchase_setting[wh_refund_loyaty_point]" <?php if(get_setting('wh_refund_loyaty_point') == 1 ){ echo 'checked';} ?> value="wh_refund_loyaty_point">
					<label for="wh_refund_loyaty_point" data-toggle="tooltip" title="" data-original-title="<?php echo _l('refund_loyalty_point_tooltip'); ?>"><?php echo _l('refund_loyalty_point'); ?>
				</label>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<h5 class="no-margin font-bold h5-color"><?php echo _l('return_policies_information') ?></h5>
		<hr class="hr-color">
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php echo render_textarea1('wh_return_policies_information', '', get_setting('wh_return_policies_information'), array(), array(), '', 'tinymce'); ?>
	</div>
</div>

<button type="button" class="btn btn-info text-white float-end submit_policies_information" onclick ="submit_policies_information(this); return false"><?php echo _l('submit'); ?></button>

</div>

<div class="tab-pane fade" id="tab_pdf" role="tabpanel" aria-labelledby="tab_pdf-tab">

	<div class="row">
		<div class="col-md-12">
			<h5 class="no-margin font-bold h5-color" ><?php echo _l('wh_general')?></h5>
			<hr class="hr-color" >
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="checkbox checkbox-primary">
					<input  class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor" name="purchase_setting[goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor]" <?php if(get_setting('goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor') == 1 ){ echo 'checked';} ?> value="goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor">
					<label for="goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor"><?php echo _l('goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor'); ?>
				</label>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<h5 class="no-margin font-bold h5-color" ><?php echo _l('stock_export')?></h5>
		<hr class="hr-color" >
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<div class="checkbox checkbox-primary">
				<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="goods_delivery_pdf_display" name="purchase_setting[goods_delivery_pdf_display]" <?php if(get_setting('goods_delivery_pdf_display') == 1 ){ echo 'checked';} ?> value="goods_delivery_pdf_display">
				<label for="goods_delivery_pdf_display"><?php echo _l('goods_delivery_pdf_display'); ?>
			</label>
		</div>
	</div>
</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<div class="checkbox checkbox-primary">
				<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="goods_delivery_pdf_display_outstanding" name="purchase_setting[goods_delivery_pdf_display_outstanding]" <?php if(get_setting('goods_delivery_pdf_display_outstanding') == 1 ){ echo 'checked';} ?> value="goods_delivery_pdf_display_outstanding">
				<label for="goods_delivery_pdf_display_outstanding"><?php echo _l('goods_delivery_pdf_display_outstanding'); ?>
			</label>
		</div>
	</div>
</div>
</div>


</div>

<div class="tab-pane fade" id="tab_shipment" role="tabpanel" aria-labelledby="tab_shipment-tab">

	<div class="row">
		<div class="col-md-12">
			<h5 class="no-margin font-bold h5-color" ><?php echo _l('wh_general')?></h5>
			<hr class="hr-color" >
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="checkbox checkbox-primary">
					<input class="form-check-input" onchange="auto_create_change_setting(this); return false" type="checkbox" id="wh_display_shipment_on_client_portal" name="purchase_setting[wh_display_shipment_on_client_portal]" <?php if(get_setting('wh_display_shipment_on_client_portal') == 1 ){ echo 'checked';} ?> value="wh_display_shipment_on_client_portal">
					<label for="wh_display_shipment_on_client_portal"><?php echo _l('wh_display_shipment_on_client_portal'); ?>
				</label>
			</div>
		</div>
	</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>


<div class="clearfix"></div>

<?php require 'plugins/Warehouse/assets/js/settings/rule_sale_price_js.php';?>
</body>
</html>


