<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">
						<span class="dropdown inline-block mt10">
							<button class="btn btn-info text-white dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true">
								<i data-feather="tool" class="icon-16"></i> <?php echo app_lang('actions'); ?>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_goods_receipt_pdf/" . $goods_receipt->id), "<i data-feather='download' class='icon-16'></i> " . app_lang('download_pdf'), array("title" => app_lang('download_pdf'), "class" => "dropdown-item")); ?> </li>
								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_goods_receipt_pdf/" . $goods_receipt->id . "/view"), "<i data-feather='file-text' class='icon-16'></i> " . app_lang('view_pdf'), array("title" => app_lang('view_pdf'), "target" => "_blank", "class" => "dropdown-item")); ?> </li>

								<li role="presentation"><?php echo js_anchor("<i data-feather='printer' class='icon-16'></i> " . app_lang('print_invoice'), array('title' => app_lang('print_invoice'), 'id' => 'print-invoice-btn', "class" => "dropdown-item")); ?> </li>

								<?php if((has_permission('warehouse', '', 'edit') || is_admin()) && ($goods_receipt->approval == 0)){ ?>
									<li role="presentation" class="dropdown-divider"></li>

									<li role="presentation"><a href="<?php echo site_url('warehouse/manage_goods_receipt/' . $goods_receipt->id ) ?>" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> <?php echo app_lang('edit')  ?></a></li>

								<?php } ?>
							</ul>
						</span>

					</div>
				</div>


				<div class="modal-body clearfix">

					<div class="col-md-12 panel-padding">
						<table class="table border table-striped table-margintop" >
							<tbody>

								<tr class="project-overview">
									<td class="bold" width="30%"><?php echo app_lang('supplier_name'); ?></td>

									<?php 
									if(get_status_modules_wh('purchase') && ($goods_receipt->supplier_code != '') && ($goods_receipt->supplier_code != 0) ){ ?>
										<td><?php echo html_entity_decode(wh_get_vendor_company_name($goods_receipt->supplier_code)) ; ?></td>
									<?php   }else{?>
										<td><?php echo html_entity_decode($goods_receipt->supplier_name) ; ?></td>
									<?php   }

									?>
									
								</tr>
								<tr class="project-overview">
									<td class="bold" width="30%"><?php echo app_lang('deliver_name'); ?></td>
									<td><?php echo html_entity_decode($goods_receipt->deliver_name) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold"><?php echo app_lang('Buyer'); ?></td>
									<td><?php echo get_staff_full_name1($goods_receipt->buyer_id) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold"><?php echo app_lang('stock_received_docket_code'); ?></td>
									<td><?php echo html_entity_decode($goods_receipt->goods_receipt_code) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold"><?php echo app_lang('note_'); ?></td>
									<td><?php echo html_entity_decode($goods_receipt->description) ; ?></td>
								</tr>

								<?php 
								if (get_status_modules_wh('purchase')) {
									if( ($goods_receipt->pr_order_id != '') && ($goods_receipt->pr_order_id != 0) ){ ?>

										<tr class="project-overview">
											<td class="bold"><?php echo app_lang('reference_purchase_order'); ?></td>
											<td>
												<a href="<?php echo get_uri('purchase/purchase_order/'.$goods_receipt->pr_order_id) ?>" ><?php echo get_pur_order_name($goods_receipt->pr_order_id) ?></a>

											</td>
										</tr>

									<?php   }
								} 
								?>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table items items-preview estimate-items-preview" data-type="estimate">
								<thead>
									<tr>
										<th align="center">#</th>
										<th  colspan="1"><?php echo app_lang('commodity_code') ?></th>
										<th colspan="1"><?php echo app_lang('warehouse_name') ?></th>
										<th  colspan="1"><?php echo app_lang('unit_name') ?></th>
										<th  colspan="2" class="text-center"><?php echo app_lang('quantity') ?></th>
										<th align="right" colspan="1"><?php echo app_lang('unit_price') ?></th>
										<th align="right" colspan="1"><?php echo app_lang('total_money') ?></th>
										<th align="right" colspan="1"><?php echo app_lang('tax_money') ?></th>
										<th align="right" colspan="1"><?php echo app_lang('lot_number') ?></th>
										<th align="right" colspan="1"><?php echo app_lang('expiry_date') ?></th>
									</tr>
								</thead>
								<tbody class="ui-sortable">

									<?php 
									foreach ($goods_receipt_detail as $receipt_key => $receipt_value) {

										$receipt_key++;
										$quantities = (isset($receipt_value) ? $receipt_value['quantities'] : '');
										$unit_price = (isset($receipt_value) ? $receipt_value['unit_price'] : '');
										$unit_price = (isset($receipt_value) ? $receipt_value['unit_price'] : '');
										$goods_money = (isset($receipt_value) ? $receipt_value['goods_money'] : '');

										$commodity_code = get_commodity_name($receipt_value['commodity_code']) != null ? get_commodity_name($receipt_value['commodity_code'])->commodity_code : '';
										$commodity_name = get_commodity_name($receipt_value['commodity_code']) != null ? get_commodity_name($receipt_value['commodity_code'])->description : '';

										$unit_name ='';
										if(is_numeric($receipt_value['unit_id'])){
											$unit_name = (get_unit_type($receipt_value['unit_id']) != null && isset(get_unit_type($receipt_value['unit_id'])->unit_name)) ? get_unit_type($receipt_value['unit_id'])->unit_name : '';

										}

										if(is_numeric($receipt_value['warehouse_id']) && $receipt_value['warehouse_id'] != 0){
											$warehouse_code = get_warehouse_name($receipt_value['warehouse_id']) != null ? get_warehouse_name($receipt_value['warehouse_id'])->warehouse_name : '';
										}else{
											$warehouse_code = '';
										}

										$tax_money =(isset($receipt_value) ? $receipt_value['tax_money'] : '');
										$expiry_date =(isset($receipt_value) ? $receipt_value['expiry_date'] : '');
										$lot_number =(isset($receipt_value) ? $receipt_value['lot_number'] : '');
										$commodity_name = $receipt_value['commodity_name'];
										if(strlen($commodity_name) == 0){
											$commodity_name = wh_get_item_variatiom($receipt_value['commodity_code']);
										}

										if(strlen($receipt_value['serial_number']) > 0){
											$name_serial_number_tooltip = app_lang('wh_serial_number').': '.$receipt_value['serial_number'];
										}else{
											$name_serial_number_tooltip = '';
										}


										?>

										<tr data-toggle="tooltip" data-original-title="<?php echo html_entity_decode($name_serial_number_tooltip); ?>">
											<td ><?php echo html_entity_decode($receipt_key) ?></td>
											<td ><?php echo html_entity_decode($commodity_name) ?></td>
											<td ><?php echo html_entity_decode($warehouse_code) ?></td>
											<td ><?php echo html_entity_decode($unit_name) ?></td>
											<td ></td>
											<td class="text-right" ><?php echo html_entity_decode($quantities) ?></td>
											<td class="text-right"><?php echo to_decimal_format((float)$unit_price) ?></td>
											<td class="text-right"><?php echo to_decimal_format((float)$goods_money) ?></td>
											<td class="text-right"><?php echo to_decimal_format((float)$tax_money) ?></td>
											<td class="text-right"><?php echo html_entity_decode($lot_number) ?></td>
											<td class="text-right"><?php echo format_to_date($expiry_date, false) ?></td>
										</tr>
									<?php  } ?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-md-6"></div>
					<div class="col-md-6 title-button-group">
						<table class="table text-right table-margintop">
							<tbody>
								<tr class="project-overview" id="subtotal">
									<td class="td_style"><span class="bold"><?php echo app_lang('total_goods_money'); ?></span>
									</td>
									<?php $total_goods_money = (isset($goods_receipt) ? $goods_receipt->total_goods_money : '');?>
									<td><?php echo to_currency((float)$total_goods_money); ?></td>
								</tr>

								<tr class="project-overview">
									<td class="td_style"><span class="bold"><?php echo app_lang('value_of_inventory'); ?></span>
									</td>
									<?php $value_of_inventory = (isset($goods_receipt) ? $goods_receipt->value_of_inventory : '');?>
									<td><?php echo to_currency((float)$value_of_inventory); ?></td>
								</tr>

								<?php if(isset($goods_receipt) && $tax_data['html_currency'] != ''){
									echo html_entity_decode($tax_data['html_currency']);
								} ?>

								<tr class="project-overview">
									<td class="td_style"><span class="bold"><?php echo app_lang('total_tax_money'); ?></span>
									</td>
									<?php $total_tax_money = (isset($goods_receipt) ? $goods_receipt->total_tax_money : '');?>
									<td><?php echo to_currency((float)$total_tax_money); ?></td>
								</tr>

								<tr class="project-overview">
									<td class="td_style"><span class="bold"><?php echo app_lang('total_money'); ?></span>
									</td>
									<?php $total_money = (isset($goods_receipt) ? $goods_receipt->total_money : '');?>
									<td><?php echo to_currency((float)$total_money); ?></td>

								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<?php if(count($list_approve_status) > 0){ ?>
					<div class="row">
						<div class="col-md-4 text-center">
						</div>
						<?php 
						$Users_model = model("Models\Users_model");

						$enter_charge_code = 0;
						foreach ($list_approve_status as $value) {
							$value['staffid'] = explode(', ',$value['staffid']);
							if($value['action'] == 'sign'){
								?>
								<div class="col-md-3 text-center">
									<p class="text-uppercase text-muted no-mtop bold">
										<?php
										$staff_name = '';
										$st = app_lang('status_0');
										$color = 'warning';
										foreach ($value['staffid'] as $key => $val) {
											if($staff_name != '')
											{
												$staff_name .= ' or ';
											}

											$options = array(
												"id" => $val,
												"user_type" => "staff",
											);
											$user = $Users_model->get_details($options)->getRow();

											if($user){
												$staff_name .= $user->first_name.' '.$user->last_name;
											}
										}
										echo html_entity_decode($staff_name); 
									?></p>
									<?php if($value['approve'] == 1){ 
										?>
										<?php if (file_exists(WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER . $goods_receipt->id . '/signature_'.$value['id'].'.png') ){ ?>

											<img src="<?php echo base_url('plugins/Warehouse/Uploads/stock_import/'.$goods_receipt->id.'/signature_'.$value['id'].'.png'); ?>" class="img-width-height">

										<?php }else{ ?>
											<img src="<?php echo base_url('plugins/Warehouse/Uploads/image_not_available.jpg'); ?>" class="img-width-height">
										<?php } ?>


									<?php }
									?>    
								</div>
							<?php }else{ ?>
								<div class="col-md-3 text-center">
									<p class="text-uppercase text-muted no-mtop bold">
										<?php
										$staff_name = '';
										foreach ($value['staffid'] as $key => $val) {
											if($staff_name != '')
											{
												$staff_name .= ' or ';
											}

											$options = array(
												"id" => $val,
												"user_type" => "staff",
											);
											$user = $Users_model->get_details($options)->getRow();

											if($user){
												$staff_name .= $user->first_name.' '.$user->last_name;
											}

										}
										echo html_entity_decode($staff_name); 
									?></p>
									<?php if($value['approve'] == 1){ 
										?>
										<img src="<?php echo base_url('plugins/Warehouse/Uploads/approval/approved.png') ; ?>" class="img-width-height">
									<?php }elseif($value['approve'] == -1){ ?>
										<img src="<?php echo base_url('plugins/Warehouse/Uploads/approval/rejected.png') ; ?>" class="img-width-height">
									<?php }
									?>
									<p class="text-muted no-mtop bold">  
										<?php echo html_entity_decode($value['note']) ?>
									</p>    
								</div>
							<?php }
						} ?>
					</div>
				<?php } ?>


				<div class="row">

					<div class="col-md-12">

						<div class="pull-right">

							<?php 
							if($goods_receipt->approval != 1 && ($check_approve_status == false ))

								{ ?>
									<?php if($check_appr && $check_appr != false){ ?>

										<a data-toggle="tooltip" data-loading-text="<?php echo app_lang('wait_text'); ?>" class="btn btn-success lead-top-btn lead-view" data-placement="top" href="#" onclick="send_request_approve(<?php echo html_entity_decode($goods_receipt->id); ?>); return false;"><span data-feather="send" class="icon-16" ></span> <?php echo app_lang('send_request_approve'); ?></a>
									<?php } ?>

								<?php }
								if(isset($check_approve_status['staffid'])){
									?>
									<?php 
									if(in_array(get_staff_user_id1(), $check_approve_status['staffid']) && !in_array(get_staff_user_id1(), $get_staff_sign)){ ?>
										<a href="#" class="btn btn-success  show_approve" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo app_lang('approve'); ?><span class="caret"></span></a>

										<div class="modal fade" id="approve_modal" tabindex="-1" role="dialog">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title"><?php echo app_lang('approve'); ?></h4>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body general-form">
														<?php echo render_textarea1('reason', 'reason'); ?>
													</div>
													<div class="modal-footer">

														<a href="#" class="btn btn-success pull-left display-block  mr-4 button-margin-r-b" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="approve_request(<?php echo html_entity_decode($goods_receipt->id); ?>); return false;"><span data-feather="upload" class="icon-16"></span>
															<?php echo app_lang('approve'); ?>
														</a>

														<a href="#" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="deny_request(<?php echo html_entity_decode($goods_receipt->id); ?>); return false;" class="btn btn-warning text-white"><span data-feather="x" class="icon-16"></span><?php echo app_lang('deny'); ?>
													</a>

												</div>
											</div>
										</div>
									</div>

								<?php }
								?>

								<?php
								if(in_array(get_staff_user_id1(), $check_approve_status['staffid']) && in_array(get_staff_user_id1(), $get_staff_sign)){ ?>
									<button onclick="accept_action();" class="btn btn-success pull-right action-button"><span data-feather="edit" class="icon-16"></span> <?php echo app_lang('e_signature_sign'); ?></button>
								<?php }
								?>
								<?php 
							}
							?>
						</div>

					</div>                                          

				</div>


			</div>

		</div>
	</div>
</div>
</div>

<div class="modal fade" id="add_action" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-body">
				<h5 class="bold" id="signatureLabel"><?php echo app_lang('signature'); ?></h5>
				<div class="signature-pad--body">
					<canvas id="signature" height="130" width="470"></canvas>
				</div>
				<input type="text" class="sig-input-style d-none" tabindex="-1" name="signature" id="signatureInput">
				<div class="dispay-block">
					<button type="button" class="btn btn-default btn-xs clear" tabindex="-1" onclick="signature_clear();"><span data-feather="refresh-cw" class="icon-16"></span> <?php echo app_lang('clear'); ?></button>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('cancel'); ?></button>
				<button onclick="sign_request(<?php echo html_entity_decode($goods_receipt->id); ?>);"  autocomplete="off" class="btn btn-primary sign_request_class"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('e_signature_sign'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/goods_receipts/view_purchase_js.php';?>

</body>
</html>
