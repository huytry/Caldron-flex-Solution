<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<?php echo form_open_multipart(get_uri("warehouse/manage_goods_receipt"), array("id" => "add_goods_receipt", "class" => "general-form", "role" => "form")); ?>
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
				</div>
				<div class="modal-body clearfix">

					<?php 
					$id = '';
					if(isset($goods_receipt)){
						$id = $goods_receipt->id;
						echo form_hidden('isedit');
					}
					?>

					<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">
					<input type="hidden" name="save_and_send_request" value="false">

					<!-- start-->
					<div class="row">
						<div class="col-md-6">
							<?php $goods_receipt_code =isset($goods_receipt) ? $goods_receipt->goods_receipt_code : (isset($goods_code) ? $goods_code : '');?>
							<?php echo render_input1('goods_receipt_code', 'stock_received_docket_number',$goods_receipt_code,'',array('disabled' => 'true')) ?>
						</div>
						<div class="col-md-3">
							<?php $date_c =  isset($goods_receipt) ? $goods_receipt->date_c : get_my_local_time("Y-m-d") ?>
							<?php echo render_date_input1('date_c','accounting_date', format_to_date($date_c, false)) ?>
						</div>
						<div class="col-md-3">
							<?php $date_add =  isset($goods_receipt) ? $goods_receipt->date_add : get_my_local_time("Y-m-d") ?>
							<?php echo render_date_input1('date_add','day_vouchers', format_to_date($date_add, false)) ?>
						</div>

						<div class="col-md-6 <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
							<div class="form-group">
								<label for="pr_order_id"><?php echo _l('reference_purchase_order'); ?></label>
								<select name="pr_order_id" id="pr_order_id" class="select2 validate-hidden" data-live-search="true" data-width="100%" placeholder="<?php echo _l('ticket_settings_none_assigned'); ?>">
									<option value=""></option>
									<?php foreach($pr_orders as $pr_order) { ?>
										<option value="<?php echo html_entity_decode($pr_order['id']); ?>" <?php if(isset($goods_receipt) && ($goods_receipt->pr_order_id == $pr_order['id'])){ echo 'selected' ;} ?>><?php echo html_entity_decode($pr_order['pur_order_number'].' - '.$pr_order['pur_order_name']); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="col-md-6 <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
							<div class="form-group">
								<label for="supplier_code"><?php echo _l('supplier_name'); ?></label>
								<select  name="supplier_code" id="supplier_code" class="select2 validate-hidden" data-live-search="true" data-width="100%" placeholder="<?php echo _l('ticket_settings_none_assigned'); ?>">
									<option value=""></option>

									<?php if(isset($vendors)){ ?>
										<?php foreach($vendors as $s) { ?>
											<option value="<?php echo html_entity_decode($s['userid']); ?>" <?php if(isset($goods_receipt) && $goods_receipt->supplier_code == $s['userid']){ echo 'selected'; } ?>><?php echo html_entity_decode($s['company']); ?></option>
										<?php } ?>
									<?php } ?>

								</select>
							</div>
						</div>

						<div class="col-md-6 <?php if($pr_orders_status == true){ echo 'hide';} ;?>" >

							<?php $supplier_name =  isset($goods_receipt) ? $goods_receipt->supplier_name : ''?>
							<?php 
							echo render_input1('supplier_name','supplier_name', $supplier_name) ?>
						</div>

						<div class=" col-md-3">
							<div class="form-group">
								<label for="buyer_id" class="control-label"><?php echo _l('Buyer'); ?></label>
								<select name="buyer_id" class="select2 validate-hidden" id="buyer_id" data-width="100%" placeholder=""> 
									<!-- <option value=""></option>  -->
									<?php foreach($staff as $s){ ?>
										<option value="<?php echo html_entity_decode($s['id']); ?>" <?php if(isset($goods_receipt) && ($goods_receipt->buyer_id == $s['id'])){ echo 'selected' ;} ?>> <?php echo html_entity_decode($s['first_name'].''.$s['last_name']); ?></option>                  
									<?php }?>
								</select>
							</div>
						</div>

						<div class=" col-md-3">
							<?php $deliver_name = (isset($goods_receipt) ? $goods_receipt->deliver_name : '');
							echo render_input1('deliver_name','deliver_name',$deliver_name) ?>
						</div>

						<div class="col-md-3 ">
							<?php $warehouse_id_value = (isset($goods_receipt) ? $goods_receipt->warehouse_id : '');?>
							<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle skucode-tooltip"  data-toggle="tooltip" title="" data-original-title="<?php echo _l('goods_receipt_warehouse_tooltip'); ?>"></i></a>
							<?php echo render_select1('warehouse_id_m',$warehouses,array('warehouse_id','warehouse_name'),'warehouse_name', $warehouse_id_value, [], [], '', '', true); ?>
						</div>

						<div class="col-md-3 form-group" >
							<?php $invoice_no = (isset($goods_receipt) ? $goods_receipt->invoice_no : '');
							echo render_input1('invoice_no','invoice_no',$invoice_no) ?>
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
									<th width="10%" align="right" class="qty"><?php echo _l('quantity'); ?></th>
									<th width="10%" align="right"><?php echo _l('unit_price'); ?></th>
									<th width="12%" align="right"><?php echo _l('invoice_table_tax_heading'); ?></th>
									<th width="10%" align="right"><?php echo _l('lot_number'); ?></th>
									<th width="10%" align="right"><?php echo _l('date_manufacture'); ?></th>
									<th width="10%" align="right"><?php echo _l('expiry_date'); ?></th>
									<th width="10%" align="right"><?php echo _l('invoice_table_amount_heading'); ?></th>

									<th align="center"><span data-feather="settings" class="icon-16"></span></th>
									<th align="center"></th>
								</tr>
							</thead>
							<tbody>
								<?php echo html_entity_decode($goods_receipt_row_template); ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-8 title-button-group">
						<table class="table text-right">
							<tbody>
								<tr id="subtotal">
									<td><span class="bold"><?php echo _l('total_goods_money'); ?> :</span>
									</td>
									<td class="wh-subtotal">
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
						<?php $description = (isset($goods_receipt) ? $goods_receipt->description : ''); ?>
						<?php echo render_textarea1('description','note',$description,array(),array(),'mtop15'); ?>

						<div class="btn-bottom-toolbar text-right mb20">
							<a href="<?php echo get_uri('warehouse/manage_purchase'); ?>"class="btn btn-default text-right mright5"><span data-feather="x" class="icon-16"></span> <?php echo _l('close'); ?></a>

							<?php if(wh_check_approval_setting('1') != false) { ?>
								<?php if(isset($goods_receipt) && $goods_receipt->approval != 1){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_receipt_send text-white" ><span data-feather="send" class="icon-16" ></span> <?php echo _l('save_send_request'); ?></a>
								<?php }elseif(!isset($goods_receipt)){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_receipt_send text-white" ><span data-feather="send" class="icon-16" ></span> <?php echo _l('save_send_request'); ?></a>
								<?php } ?>
							<?php } ?>

							<?php if (is_admin() || has_permission('warehouse', '', 'edit') || has_permission('warehouse', '', 'create')) { ?>
								<?php if(isset($goods_receipt) && $goods_receipt->approval == 0){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_receipt text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></a>
								<?php }elseif(!isset($goods_receipt)){ ?>
									<a href="javascript:void(0)"class="btn btn-primary pull-right mright5 add_goods_receipt text-white" ><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></a>
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

<?php require 'plugins/Warehouse/assets/js/goods_receipts/purchase_js.php';?>


</body>
</html>

