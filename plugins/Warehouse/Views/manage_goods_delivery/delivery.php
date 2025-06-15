<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<?php echo form_open_multipart(get_uri("warehouse/goods_delivery"), array("id" => "add_goods_delivery", "class" => "general-form", "role" => "form")); ?>
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
				</div>
				<div class="modal-body clearfix">

					<?php 
					$id = '';
					$additional_discount = 0;
					$shipping_fee = '0';
					$shipping_fee_number_attr = ['min' => '0.00', 'step' => 'any'];

					if(isset($goods_delivery)){
						$id = $goods_delivery->id;
						echo form_hidden('isedit');
						$additional_discount = $goods_delivery->additional_discount;
						$shipping_fee = (float)($goods_delivery->shipping_fee);
					}
					?>

					<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">
					<input type="hidden" name="edit_approval" value="<?php echo html_entity_decode($edit_approval); ?>">
					<input type="hidden" name="save_and_send_request" value="false">
					<input type="hidden" name="additional_discount" value="<?php echo html_entity_decode($additional_discount); ?>">

					<!-- start-->
					<div class="row">
						<div class="col-md-6">
							<?php $goods_delivery_code = isset($goods_delivery)? $goods_delivery->goods_delivery_code: (isset($goods_code) ? $goods_code : '');?>
							<?php echo render_input1('goods_delivery_code', 'document_number',$goods_delivery_code,'',array('disabled' => 'true')) ?>
						</div>
						<div class="col-md-3">
							<?php $date_c = isset($goods_delivery) ? $goods_delivery->date_c : get_my_local_time("Y-m-d") ;?>
							<?php $disabled=[]; ?>

							<?php if($edit_approval == 'true'){ 
								$disabled['disabled'] = 'true' ;
							} ?>
							<?php echo render_date_input1('date_c','accounting_date', format_to_date($date_c, false), $disabled) ?>

						</div>
						<div class="col-md-3">
							<?php $date_add = isset($goods_delivery) ? $goods_delivery->date_add : get_my_local_time("Y-m-d") ;?>
							<?php echo render_date_input1('date_add','day_vouchers', format_to_date($date_add, false), $disabled) ?>
						</div>

						<div class="col-md-6 <?php if($pr_orders_status == false || get_setting('goods_delivery_required_po') == 0){ echo 'd-none';} ;?>" >
							<div class="form-group">
								<label for="pr_order_id"><?php echo _l('reference_purchase_order'); ?></label>
								<select onchange="pr_order_change(this); return false;" name="pr_order_id" id="pr_order_id" class="select2 validate-hidden" data-live-search="true" data-width="100%" placeholder="<?php echo _l('ticket_settings_none_assigned'); ?>" <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?> >
									<option value=""></option>
									<?php foreach($pr_orders as $pr_order) { ?>
										<option value="<?php echo html_entity_decode($pr_order['id']); ?>" <?php if(isset($goods_delivery) && ($goods_delivery->pr_order_id == $pr_order['id'])){ echo 'selected' ;} ?>><?php echo html_entity_decode($pr_order['pur_order_number'].' - '.$pr_order['pur_order_name']); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-6 d-none <?php if($pr_orders_status == true && get_warehouse_option('goods_delivery_required_po') == 1){ echo 'd-none';} ;?> ">
							<div class="form-group">
								<label for="invoice_id"><?php echo _l('invoices'); ?></label>
								<select onchange="invoice_change(this); return false;" name="invoice_id" id="invoice_id" class="select2 validate-hidden" data-live-search="true" data-width="100%"  <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?> >
									<option value=""></option>
									<?php foreach($invoices as $invoice) { ?>
										<option value="<?php echo html_entity_decode($invoice['id']); ?>" <?php if(isset($goods_delivery) && $goods_delivery->invoice_id == $invoice['id']){ echo 'selected'; } ?>><?php echo get_invoice_id($invoice['id']); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">

							<div class="form-group">
								<label for="customer_code"><?php echo _l('customer_name'); ?></label>
								<select name="customer_code" id="vendor" class="select2 validate-hidden" data-live-search="true" data-width="100%"  <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?>  >
									<option value="">-</option>
									<?php foreach($customer_code as $s) { ?>
										<option value="<?php echo html_entity_decode($s['id']); ?>" <?php if(isset($goods_delivery) && $goods_delivery->customer_code == $s['id']){ echo 'selected'; } ?>><?php echo html_entity_decode($s['company_name']); ?></option>
									<?php } ?>
								</select>
							</div>

						</div>


						<div class=" col-md-3">
							<?php $to = (isset($goods_delivery) ? $goods_delivery->to_ : '');
							echo render_input1('to_','receiver',$to, '',$disabled) ?>
						</div>
						<div class=" col-md-6">
							<?php $address = (isset($goods_delivery) ? $goods_delivery->address : '');
							echo render_input1('address','address',$address,'', $disabled) ?>
						</div>

						<div class=" col-md-6">
							<div class="form-group">
								<label for="staff_id" class="control-label"><?php echo _l('salesman'); ?></label>
								<select name="staff_id" class="select2 validate-hidden" id="staff_id" data-width="100%"  <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?>> 
									<option value="">-</option> 
									<?php foreach($staff as $s){ ?>
										<option value="<?php echo html_entity_decode($s['id']); ?>" <?php if(isset($goods_delivery) && $goods_delivery->staff_id == $s['id']){ echo 'selected' ;} ?>> <?php echo html_entity_decode($s['first_name']).''.html_entity_decode($s['last_name']); ?></option>                  
									<?php }?>
								</select>

							</div>
						</div>

						<div class="col-md-6 form-group" >
							<?php $invoice_no = (isset($goods_delivery) ? $goods_delivery->invoice_no : '');
							echo render_input1('invoice_no','invoice_no',$invoice_no, '',$disabled) ?>

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

									<th width="15%" align="left"><?php echo _l('warehouse_name'); ?></th>
									<th width="10%" align="right" class="available_quantity"><?php echo _l('available_quantity'); ?></th>
									<th width="10%" align="right" class="qty"><?php echo _l('quantity'); ?></th>
									<th width="10%" align="right"><?php echo _l('rate'); ?></th>
									<th width="12%" align="right"><?php echo _l('invoice_table_tax_heading'); ?></th>
									<th width="10%" align="right"><?php echo _l('subtotal'); ?></th>
									<th width="7%" align="right"><?php echo _l('discount'); ?></th>
									<th width="10%" align="right"><?php echo _l('discount(money)'); ?></th>
									<th width="10%" align="right"><?php echo _l('total_money'); ?></th>

									<th align="center"><span data-feather="settings" class="icon-16"></span></th>
									<th align="center"></th>
								</tr>
							</thead>
							<tbody>
								<?php echo html_entity_decode($goods_delivery_row_template); ?>
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
						<?php $description = (isset($goods_delivery) ? $goods_delivery->description : ''); ?>
						<?php echo render_textarea1('description','note_',$description,array(),array(),'mtop15'); ?>

						<div class="btn-bottom-toolbar text-right mb20">
							<a href="<?php echo get_uri('warehouse/manage_delivery'); ?>"class="btn btn-default text-right mright5"><span data-feather="x" class="icon-16"></span> <?php echo _l('close'); ?></a>

							<?php if(wh_check_approval_setting('2') != false) { ?>
								<?php if(isset($goods_delivery) && $goods_delivery->approval != 1){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_delivery_send text-white" ><span data-feather="send" class="icon-16" ></span> <?php echo _l('save_send_request'); ?></a>
								<?php }elseif(!isset($goods_delivery)){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_delivery_send text-white" ><span data-feather="send" class="icon-16" ></span> <?php echo _l('save_send_request'); ?></a>
								<?php } ?>
							<?php } ?>

							<?php if (is_admin() || has_permission('warehouse', '', 'edit') || has_permission('warehouse', '', 'create')) { ?>
								<?php if(isset($goods_delivery) && $goods_delivery->approval == 0){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_delivery text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></a>
								<?php }elseif(!isset($goods_delivery)){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_delivery text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></a>
								<?php } elseif(isset($goods_delivery) && $goods_delivery->approval == 1 && is_admin()){ ?>
									<a href="javascript:void(0)"class="btn btn-info pull-right mright5 add_goods_delivery text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('save'); ?></a>
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

<?php require 'plugins/Warehouse/assets/js/goods_deliveries/goods_delivery_js.php';?>

</body>
</html>

