<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<?php echo form_open_multipart(get_uri("warehouse/packing_list"), array("id" => "add_edit_packing_list", "class" => "general-form", "role" => "form")); ?>
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
				</div>
				<div class="modal-body clearfix">

					<?php 
					$id = '';
					$additional_discount = 0;
					$shipping_fee = 0;
					if(isset($packing_list)){
						$id = $packing_list->id;
						echo form_hidden('isedit');
						$additional_discount = $packing_list->additional_discount;
						$shipping_fee = $packing_list->shipping_fee;
					}
					?>

					<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">
					<input type="hidden" name="edit_approval" value="<?php echo html_entity_decode($edit_approval); ?>">
					<input type="hidden" name="save_and_send_request" value="false">
					<input type="hidden" name="main_additional_discount" value="<?php echo html_entity_decode($additional_discount); ?>">
					<input type="hidden" name="main_shipping_fee" value="<?php echo html_entity_decode($shipping_fee); ?>">
					<?php 
					$input_number_attr = ['min' => '0.00', 'step' => 'any'];
					$volume_attr = ['min' => '0.00', 'step' => 'any', 'readonly' => true];
					$shipping_fee_number_attr = ['min' => '0.00', 'step' => 'any'];
					$packing_list_code = isset($packing_list)? $packing_list->packing_list_number : (isset($goods_code) ? $goods_code : '');
					$packing_list_name = isset($packing_list)? $packing_list->packing_list_name : $packing_list_name_ex;
					$clientid = isset($packing_list)? $packing_list->clientid : '';
					$delivery_note_id = isset($packing_list)? $packing_list->delivery_note_id : '';
					$width = isset($packing_list)? $packing_list->width : 0.0;
					$height = isset($packing_list)? $packing_list->height : 0.0;
					$lenght = isset($packing_list)? $packing_list->lenght : 0.0;
					$weight = isset($packing_list)? $packing_list->weight : 0.0;
					$volume = isset($packing_list)? $packing_list->volume : 0.0;
					$client_note = isset($packing_list)? $packing_list->client_note : '';
					$admin_note = isset($packing_list)? $packing_list->admin_note : '';


					?>

					<!-- start-->
					<div class="row">
						<div class="col-md-6">
							<?php echo render_select1('delivery_note_id', $goods_deliveries, array('id', array('goods_delivery_code')), 'stock_export', $delivery_note_id, ['data-width' => '100%', 'class' => 'selectpicker', 'data-live-search' => "true"], array(), '', '', true); ?>

							<?php echo render_select1('clientid', $clients, array('id', array('company_name')), 'client', $clientid, ['data-width' => '100%', 'class' => 'selectpicker', 'data-live-search' => "true"], array(), '', '', true); ?>

							<div class="row">
								<div class="col-md-6 bill_to_data">
									<?php if(isset($billing_shipping)){
										echo html_entity_decode($billing_shipping);
									} ?>
								</div>
							</div>

							<div class="form-group">
								<label for="number">
									<?php echo _l('packing_list_number'); ?>
								</label>
								<div class="input-group" id="discount-total">
									<span class="input-group-text" id="basic-addon1"><?php echo html_entity_decode($packing_list_code) ;?></span>
									<input type="text" name="packing_list_name" class="form-control" value="<?php echo html_entity_decode($packing_list_name); ?>" >
								</div>

							</div>

						</div>

						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6">
									<?php echo render_input1('width','width_m_label',$width, 'number', $input_number_attr) ?>
								</div>
								<div class="col-md-6">
									<?php echo render_input1('height','height_m_label',$height, 'number', $input_number_attr) ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php echo render_input1('lenght','lenght_m_label',$lenght, 'number', $input_number_attr) ?>
								</div>
								<div class="col-md-6">
									<?php echo render_input1('weight','weight_kg_label',$weight, 'number', $input_number_attr) ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<?php echo render_input1('volume','volume_m3_label',$volume, 'number', $volume_attr) ?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<?php echo render_textarea1('client_note','client_note', $client_note,array(),array(),'mtop15'); ?>
								</div>
							</div>

						</div>

					</div>
				</div>

			</div>

			<div class="card">
				<div class="modal-body clearfix invoice-item">

					<div class="row">
						<div class="col-md-4">
							<?php echo  view('Warehouse\Views\item_include\main_item_select'); ?>
						</div>
						<div class="col-md-8 text-right">
							<label class="bold mtop10 text-right" data-toggle="tooltip" title="" data-original-title="<?php echo _l('support_barcode_scanner_tooltip'); ?>"><?php echo _l('support_barcode_scanner'); ?>
							<i class="fa fa-question-circle i_tooltip"></i></label>
						</div>
					</div>

					<div class="table-responsive s_table ">
						<table class="table invoice-items-table items table-main-invoice-edit has-calculations no-mtop">
							<thead>
								<tr>
									<th></th>
									<th width="20%" align="left"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" data-title="<?php echo _l('item'); ?>"></i> <?php echo _l('invoice_table_item_heading'); ?></th>
									<th width="10%" align="right" class="qty"><?php echo _l('quantity'); ?></th>
									<th width="10%" align="right"><?php echo _l('rate'); ?></th>
									<th width="12%" align="right"><?php echo _l('invoice_table_tax_heading'); ?></th>
									<th width="15%" align="right"><?php echo _l('subtotal'); ?></th>
									<th width="10%" align="right"><?php echo _l('discount'); ?></th>
									<th width="10%" align="right"><?php echo _l('discount(money)'); ?></th>
									<th width="15%" align="right"><?php echo _l('total_money'); ?></th>

									<th align="center"><span data-feather="settings" class="icon-16"></span></th>
									<th align="center"></th>
								</tr>
							</thead>
							<tbody>
								<?php echo html_entity_decode($packing_list_row_template); ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-8 title-button-group">
						<table class="table text-right">
							<tbody>
								<tr id="subtotal">
									<td><span class="bold"><?php echo _l('subtotal'); ?> :</span>
									</td>
									<td class="wh-subtotal">
									</td>
								</tr>
								<tr id="wh_additional_discount">
									<td><span class="bold"><?php echo _l('additional_discount'); ?> :</span>
									</td>
									<td class="wh-additional_discount" width="30%">
										<?php echo render_input1('additional_discount','',$additional_discount, 'number', $input_number_attr); ?>
									</td>
								</tr>
								<tr id="total_discount">
									<td><span class="bold"><?php echo _l('total_discount'); ?> :</span>
									</td>
									<td class="wh-total_discount">
									</td>
								</tr>
								<tr id="wh_shipping_fee">
									<td><span class="bold"><?php echo _l('wh_shipping_fee'); ?> :</span>
									</td>
									<td class="wh-shipping_fee" width="30%">
										<?php echo render_input1('shipping_fee','',$shipping_fee, 'number', $shipping_fee_number_attr); ?>
									</td>
								</tr>
								<tr id="totalmoney">
									<td><span class="bold"><?php echo _l('total_money'); ?> :</span>
									</td>
									<td class="wh-total">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div id="removed-items"></div>
				</div>
			</div>

			<div class="card">
				<div class="container-fluid">
					<div class="">
						<?php echo render_textarea1('admin_note','admin_note',$admin_note,array(),array(),'mtop15'); ?>

						<div class="btn-bottom-toolbar text-right mb20">
							<a href="<?php echo get_uri('warehouse/manage_packing_list'); ?>"class="btn btn-default text-right mright5"><span data-feather="x" class="icon-16"></span> <?php echo _l('close'); ?></a>

							<?php if(wh_check_approval_setting('5') != false) { ?>
								<?php if(isset($packing_list) && $packing_list->approval != 1){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_packing_list_send text-white" ><span data-feather="send" class="icon-16" ></span> <?php echo _l('save_send_request'); ?></a>
								<?php }elseif(!isset($packing_list)){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_packing_list_send text-white" ><span data-feather="send" class="icon-16" ></span> <?php echo _l('save_send_request'); ?></a>
								<?php } ?>
							<?php } ?>

							<?php if (is_admin() || has_permission('warehouse', '', 'edit') || has_permission('warehouse', '', 'create')) { ?>
								<?php if(isset($packing_list) && $packing_list->approval == 0){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_packing_list text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></a>
								<?php }elseif(!isset($packing_list)){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_packing_list text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></a>
								<?php } ?>

							<?php } ?>

						</div>
					</div>
					<div class="btn-bottom-pusher"></div>
				</div>
			</div>

			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div id="modal_wrapper"></div>
<div id="change_serial_modal_wrapper"></div>

<?php require 'plugins/Warehouse/assets/js/packing_lists/add_edit_packing_list_js.php';?>

</body>
</html>
