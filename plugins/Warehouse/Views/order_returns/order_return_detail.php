<?php echo form_hidden('_attachment_sale_id',$order_return->id); ?>
<?php echo form_hidden('_attachment_sale_type','estimate'); ?>
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

								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_order_return_pdf/" . $order_return->id), "<i data-feather='download' class='icon-16'></i> " . app_lang('download_pdf'), array("title" => app_lang('download_pdf'), "class" => "dropdown-item")); ?> </li>
								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_order_return_pdf/" . $order_return->id . "/view"), "<i data-feather='file-text' class='icon-16'></i> " . app_lang('view_pdf'), array("title" => app_lang('view_pdf'), "target" => "_blank", "class" => "dropdown-item")); ?> </li>

								<li role="presentation"><?php echo js_anchor("<i data-feather='printer' class='icon-16'></i> " . app_lang('print_invoice'), array('title' => app_lang('print_invoice'), 'id' => 'print-invoice-btn', "class" => "dropdown-item")); ?> </li>

								<?php if((has_permission('warehouse', '', 'edit') || is_admin()) && ($order_return->approval == 0)){ ?>
									<li role="presentation" class="dropdown-divider"></li>

									<li role="presentation"><a href="<?php echo site_url('warehouse/order_return/'.$order_return->rel_type. '/' . $order_return->id ) ?>" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> <?php echo app_lang('edit')  ?></a></li>

								<?php } ?>
							</ul>
						</span>

					</div>
				</div>

				<div class="card-header ">
					<ul class="nav nav-tabs pb15 justify-content-left border-bottom-0" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="tab_items-tab" data-bs-toggle="tab" data-bs-target="#tab_items" type="button" role="tab" aria-controls="tab_items" aria-selected="true"><?php echo _l('wh_order_return_detail'); ?></button>
						</li>
						
						<li class="nav-item d-none" role="presentation">
							<button class="nav-link" id="tab_order_return-tab" data-bs-toggle="tab" data-bs-target="#tab_order_return" type="button" role="tab" aria-controls="tab_order_return" aria-selected="false"><?php echo _l('wh_activilog'); ?></button>
						</li>
					</ul>
				</div>

				<div class="card-body">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="tab_items" role="tabpanel" aria-labelledby="tab_items-tab">
							


							<div class="modal-body clearfix">

								<div class="row">
									<div class="col-md-6">
										<h4 class="bold">
											<span id="invoice-number">
												<?php echo html_entity_decode($order_return->order_return_number .' - '.$order_return->order_return_name); ?>
											</span>
										</h4>
										<address>
											<?php
											echo company_widget(get_default_company_id());
											?>
										</address>
										
										<?php if($order_return->rel_type == 'i_sales_return_order'){ ?>
											<p class="no-mbot">
												<span class="bold">
													<?php echo _l('sales_return_order'); ?>
													<a href="<?php echo get_uri('omni_sales/sales_order_manage_order_return#'.$order_return->rel_id) ?>" ><?php echo wh_get_order_return_code($order_return->rel_id); ?></a>
												</span>
												<h5 class="bold">
												</h5>
											</p>
										<?php }elseif($order_return->rel_type == 'i_purchasing_return_order'){ ?>
											<p class="no-mbot">
												<span class="bold">
													<?php echo _l('purchasing_return_order'); ?>
													<a href="<?php echo get_uri('purchase/order_returns#'.$order_return->rel_id) ?>" ><?php echo wh_get_order_return_code($order_return->rel_id); ?></a>
												</span>
												<h5 class="bold">
												</h5>
											</p>
										<?php }elseif($order_return->rel_type == 'manual' && $order_return->receipt_delivery_type == 'inventory_receipt_voucher_returned_goods'){ ?>
											<?php 

											$goods_delivery_code = '';
											$get_goods_delivery_code = get_goods_delivery_code($order_return->rel_id);
											if($get_goods_delivery_code){
												$goods_delivery_code = $get_goods_delivery_code->goods_delivery_code;
											}

											?>

											<p class="no-mbot">
												<span class="bold">
													<?php echo _l('from_stock_export'); ?>
													<a href="<?php echo get_uri('warehouse/view_delivery/'.$order_return->rel_id) ?>" ><?php echo html_entity_decode($goods_delivery_code); ?></a>
												</span>
												<h5 class="bold">
												</h5>
											</p>

										<?php }elseif($order_return->rel_type == 'manual' && $order_return->receipt_delivery_type == 'inventory_delivery_voucher_returned_purchasing_goods'){ ?>
											<?php 
											$goods_receipt_code = '';
											$get_goods_receipt_code = get_goods_receipt_code($order_return->rel_id);
											if($get_goods_receipt_code){
												$goods_receipt_code = $get_goods_receipt_code->goods_receipt_code;
											}

											?>
											<p class="no-mbot">
												<span class="bold">
													<?php echo _l('from_stock_import'); ?>
													<a href="<?php echo get_uri('warehouse/goods_receipt_detail/'.$order_return->rel_id) ?>" ><?php echo html_entity_decode($goods_receipt_code); ?></a>
												</span>
												<h5 class="bold">
												</h5>
											</p>

										<?php } ?>

										<?php if($order_return->receipt_delivery_id != 0){ ?>

											<?php if(($order_return->rel_type == 'manual' && $order_return->receipt_delivery_type == 'inventory_receipt_voucher_returned_goods') || $order_return->rel_type == 'i_sales_return_order'){ ?>
												<?php 
												$create_goods_receipt_code = '';
												$get_new_goods_receipt_code = get_goods_receipt_code($order_return->receipt_delivery_id);
												if($get_new_goods_receipt_code){
													$create_goods_receipt_code = $get_new_goods_receipt_code->goods_receipt_code;
												}

												?>
												<p class="no-mbot">
													<span class="bold">
														<?php echo _l('goods_receipt'); ?>
														<a href="<?php echo get_uri('warehouse/manage_purchase#'.$order_return->receipt_delivery_id) ?>" ><?php echo html_entity_decode($create_goods_receipt_code); ?></a>
													</span>
													<h5 class="bold">
													</h5>
												</p>

											<?php }elseif(($order_return->rel_type == 'manual' && $order_return->receipt_delivery_type == 'inventory_delivery_voucher_returned_purchasing_goods') || $order_return->rel_type == 'i_purchasing_return_order'){?>

												<?php 

												$create_goods_delivery_code = '';
												$get_new_goods_delivery_code = get_goods_delivery_code($order_return->receipt_delivery_id);
												if($get_new_goods_delivery_code){
													$create_goods_delivery_code = $get_new_goods_delivery_code->goods_delivery_code;
												}

												?>
												<p class="no-mbot">
													<span class="bold">
														<?php echo _l('stock_export'); ?>
														<a href="<?php echo get_uri('warehouse/view_delivery/'.$order_return->receipt_delivery_id) ?>" ><?php echo html_entity_decode($create_goods_delivery_code); ?></a>
													</span>
													<h5 class="bold">
													</h5>
												</p>
											<?php } ?>

										<?php } ?>
									</div>

									<div class="col-sm-6 text-right">
										<?php if( ($order_return->rel_type == 'manual' && $order_return->receipt_delivery_type == 'inventory_receipt_voucher_returned_goods') || $order_return->receipt_delivery_type == 'i_sales_return_order') { ?>
											<span class="bold"><?php echo _l('customer_name'); ?>:</span>
											<address>

												<?php 
												$customer_name = '';
												if(is_numeric($order_return->company_id)){
													$Clients_model = model("Models\Clients_model");

													$client_options = [
														'id' => $order_return->company_id,
													];
													$customer_value = $Clients_model->get_details($client_options)->getRow();

													if($customer_value){
														$customer_name .= $customer_value->company_name;
													}
												}
												?>
												<?php echo html_entity_decode($customer_name) ?>
											</address>
										<?php }else{ ?>
											<span class="bold"><?php echo _l('wh_vendor'); ?>:</span>
											<address>
												<?php if(get_status_modules_wh('purchase')){ ?>
													<?php echo html_entity_decode(get_vendor_company_name($order_return->company_id)) ?>
												<?php }else{ ?>
													<?php echo html_entity_decode($order_return->company_name) ?>
												<?php } ?>
											</address>
										<?php } ?>
										<span class="bold"><?php echo _l('email'); ?>:</span>
										<?php echo html_entity_decode($order_return->email) ?><br>
										<span class="bold"><?php echo _l('phonenumber'); ?>:</span>
										<?php echo html_entity_decode($order_return->phonenumber) ?>
										
										
										<p class="no-mbot">
											<span class="bold">
												<?php echo _l('order_return_date'); ?>
											</span>
											<?php echo format_to_date($order_return->datecreated, false); ?>
										</p>
									</div>
								</div>
								<?php 
								$rate_label = _l('rate');

								if($order_return->rel_type == 'sales_return_order'){
									$rate_label = _l('rate');
								}elseif($order_return->rel_type == 'purchasing_return_order'){
									$rate_label = _l('purchase_price');
								}
								?>

								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table class="table items items-preview estimate-items-preview" data-type="estimate">
												<thead>
													<tr>
														<th align="center">#</th>
														<th  colspan="1"><?php echo _l('commodity_code') ?></th>
														<th align="right" colspan="1"><?php echo _l('quantity') ?></th>
														<th align="right" colspan="1"><?php echo html_entity_decode($rate_label) ?></th>
														<th align="right" colspan="1"><?php echo _l('invoice_table_tax_heading') ?></th>
														<th align="right" colspan="1"><?php echo _l('subtotal') ?></th>
														<th align="right" colspan="1"><?php echo _l('discount').'(%)' ?></th>
														<th align="right" colspan="1"><?php echo _l('discount(money)') ?></th>
														<th align="right" colspan="1"><?php echo _l('total_money') ?></th>

													</tr>
												</thead>
												<tbody class="ui-sortable">
													<?php 
													$subtotal = 0 ;
													foreach ($order_return_detail as $delivery => $order_return_value) {
														$delivery++;
														$discount = (isset($order_return_value) ? $order_return_value['discount'] : '');
														$discount_money = (isset($order_return_value) ? $order_return_value['discount_total'] : '');

														$quantity = (isset($order_return_value) ? $order_return_value['quantity'] : '');
														$unit_price = (isset($order_return_value) ? $order_return_value['unit_price'] : '');
														$total_after_discount = (isset($order_return_value) ? $order_return_value['total_after_discount'] : '');

														$commodity_code = get_commodity_name($order_return_value['commodity_code']) != null ? get_commodity_name($order_return_value['commodity_code'])->commodity_code : '';
														$commodity_name = get_commodity_name($order_return_value['commodity_code']) != null ? get_commodity_name($order_return_value['commodity_code'])->description : '';

														$unit_name = '';
														if(is_numeric($order_return_value['unit_id'])){
															$unit_name = get_unit_type($order_return_value['unit_id']) != null ? ' '.get_unit_type($order_return_value['unit_id'])->unit_name : '';
														}

														$commodity_name = $order_return_value['commodity_name'];
														if(strlen($commodity_name) == 0){
															$commodity_name = wh_get_item_variatiom($order_return_value['commodity_code']);
														}

														?>

														<tr>
															<td ><?php echo html_entity_decode($delivery) ?></td>
															<td ><?php echo html_entity_decode($commodity_name) ?></td>
															<td class="text-right"><?php echo html_entity_decode($quantity).$unit_name ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$unit_price) ?></td>

															<?php echo  wh_render_taxes_html(wh_convert_item_taxes($order_return_value['tax_id'], $order_return_value['tax_rate'], $order_return_value['tax_name']), 15); ?>
															<td class="text-right"><?php echo to_decimal_format((float)$order_return_value['sub_total']) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$discount) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$discount_money) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$total_after_discount) ?></td>
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
												<tr id="subtotal">
													<td class="bold"><?php echo _l('subtotal'); ?></td>
													<td><?php echo to_currency((float)$order_return->subtotal); ?></td>
												</tr>
												<?php if(isset($order_return) && $tax_data['html_currency'] != ''){
													echo html_entity_decode($tax_data['html_currency']);
												} ?>
												<tr id="total_discount">
													<?php
													$discount_total = 0 ;
													if(isset($order_return)){
														$discount_total += (float)$order_return->discount_total  + (float)$order_return->additional_discount;
													}
													?>
													<td class="bold"><?php echo _l('total_discount'); ?></td>
													<td><?php echo to_currency((float)$discount_total); ?></td>
												</tr>
												<tr id="totalmoney">
													<?php
													$total_after_discount = isset($order_return) ?  $order_return->total_after_discount : 0 ;
													?>
													<td class="bold"><?php echo _l('total_money'); ?></td>
													<td><?php echo to_currency((float)$total_after_discount); ?></td>
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
														<?php if (file_exists(WAREHOUSE_ORDER_RETURN_MODULE_UPLOAD_FOLDER . $order_return->id . '/signature_'.$value['id'].'.png') ){ ?>

															<img src="<?php echo base_url('plugins/Warehouse/Uploads/order_returns/'.$order_return->id.'/signature_'.$value['id'].'.png'); ?>" class="img-width-height">

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
											if($order_return->approval != 1 && ($check_approve_status == false ))

												{ ?>
													<?php if($check_appr && $check_appr != false){ ?>

														<a data-toggle="tooltip" data-loading-text="<?php echo app_lang('wait_text'); ?>" class="btn btn-success lead-top-btn lead-view" data-placement="top" href="#" onclick="send_request_approve(<?php echo html_entity_decode($order_return->id); ?>); return false;"><span data-feather="send" class="icon-16" ></span> <?php echo app_lang('send_request_approve'); ?></a>
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

																		<a href="#" class="btn btn-success pull-left display-block  mr-4 button-margin-r-b" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="approve_request(<?php echo html_entity_decode($order_return->id); ?>); return false;"><span data-feather="upload" class="icon-16"></span>
																			<?php echo app_lang('approve'); ?>
																		</a>

																		<a href="#" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="deny_request(<?php echo html_entity_decode($order_return->id); ?>); return false;" class="btn btn-warning text-white"><span data-feather="x" class="icon-16"></span><?php echo app_lang('deny'); ?>
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
								<div class="row">
									<div class="col-md-12">
										<?php if( ( ($order_return->rel_type == 'manual' && $order_return->receipt_delivery_type == 'inventory_delivery_voucher_returned_purchasing_goods') || ($order_return->rel_type == 'i_purchasing_return_order' ) ) &&  (int)$order_return->approval == 1 && (int)$order_return->receipt_delivery_id == 0 ){ ?>

											<a data-toggle="tooltip" class="btn btn-success lead-top-btn lead-view send_request_approve_class" data-placement="top" href="#" onclick="open_warehouse_modal(<?php echo html_entity_decode($order_return->id); ?>, <?php echo html_entity_decode($order_return->id); ?>); return false;"><span data-feather="check-circle" class="icon-16"></span> <?php echo _l('wh_create_inventory_delivery_vocucher'); ?></a>

										<?php } ?>
									</div>
								</div>    
							</div>

							<?php if($order_return->return_reason != ''){ ?>
								<div class="col-md-12 row mtop15">
									<p class="bold text-muted"><?php echo _l('reason_return'); ?></p>
									<p><?php echo html_entity_decode($order_return->return_reason); ?></p>
								</div>
							<?php } ?>
							<?php if($order_return->admin_note != ''){ ?>
								<div class="col-md-12 row mtop15">
									<p class="bold text-muted"><?php echo _l('admin_note'); ?></p>
									<p><?php echo html_entity_decode($order_return->admin_note); ?></p>
								</div>
							<?php } ?>

							<?php if($order_return->return_policies_information != ''){ ?>
								<div class="col-md-12 row mtop15 table-responsive">
									<p class="bold text-muted"><?php echo _l('return_policies_information'); ?></p>
									<p><?php echo html_entity_decode($order_return->return_policies_information); ?></p>
								</div>
							<?php } ?>

						</div>

						<div class="tab-pane fade" id="tab_order_return" role="tabpanel" aria-labelledby="tab_order_return-tab">
							<div class="row">
								<div class="col-md-12">
									<div class="activity-feed">
										<?php foreach($activity_log as $log){ ?>
											<div class="feed-item">
												<div class="date">
													<span class="text-has-action" data-toggle="tooltip" data-title="<?php echo format_to_datetime($log['date']); ?>">
														<?php echo format_to_datetime($log['date']); ?>
													</span>
													<?php if($log['staffid'] == get_staff_user_id1() || is_admin() || has_permission('warehouse','','delete()')){ ?>
														<a href="#" class="pull-right text-danger" onclick="delete_wh_activitylog(this,<?php echo html_entity_decode($log['id']); ?>);return false;"><i class="fa fa fa-times"></i></a>
													<?php } ?>
												</div>
												<div class="text">
													<?php if($log['staffid'] == -1){ ?>
														<a href="<?php echo site_url('profile/'.$log["staffid"]); ?>">
															<?php echo staff_profile_image($log['staffid'],array('staff-profile-xs-image pull-left mright5'));
															?>
														</a>
														<?php
													}
													$additional_data = '';
													if(!empty($log['additional_data'])){
														$additional_data = unserialize($log['additional_data']);
														echo ($log['staffid'] == 0) ? _l($log['description'],$additional_data) : $log['full_name'] .' - '._l($log['description'],$additional_data);
													} else {
														echo html_entity_decode($log['full_name']) . ' - ';

														$pos = strpos($log['description'], 'default_lang');

														if ($pos !== false) {
															echo app_lang($log['description']);
														}else{
															echo html_entity_decode($log['description']);
														}
													}
													?>
												</div>

											</div>
										<?php } ?>
									</div>
									<div class="col-md-12">
										<?php echo render_textarea1('wh_activity_textarea','','',array('placeholder'=>_l('wh_activilog')),array(),'mtop15'); ?>
										<div class="text-right">
											<button id="wh_enter_activity" class="btn btn-info text-white"><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?></button>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
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
				<button onclick="sign_request(<?php echo html_entity_decode($order_return->id); ?>);"  autocomplete="off" class="btn btn-primary sign_request_class"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('e_signature_sign'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/order_returns/view_order_return_js.php';?>

</body>
</html>

