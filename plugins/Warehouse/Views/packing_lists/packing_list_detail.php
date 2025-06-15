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

								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_packing_list_pdf/" . $packing_list->id), "<i data-feather='download' class='icon-16'></i> " . app_lang('download_pdf'), array("title" => app_lang('download_pdf'), "class" => "dropdown-item")); ?> </li>
								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_packing_list_pdf/" . $packing_list->id . "/view"), "<i data-feather='file-text' class='icon-16'></i> " . app_lang('view_pdf'), array("title" => app_lang('view_pdf'), "target" => "_blank", "class" => "dropdown-item")); ?> </li>

								<li role="presentation"><?php echo js_anchor("<i data-feather='printer' class='icon-16'></i> " . app_lang('print_invoice'), array('title' => app_lang('print_invoice'), 'id' => 'print-invoice-btn', "class" => "dropdown-item")); ?> </li>

								<?php if((has_permission('warehouse', '', 'edit') || is_admin()) && ($packing_list->approval == 0)){ ?>
									<li role="presentation" class="dropdown-divider"></li>

									<li role="presentation"><a href="<?php echo site_url('warehouse/packing_list/' . $packing_list->id ) ?>" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> <?php echo app_lang('edit')  ?></a></li>

								<?php } ?>
							</ul>
						</span>

					</div>
				</div>

				<div class="card-header ">
					<ul class="nav nav-tabs pb15 justify-content-left border-bottom-0" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="tab_items-tab" data-bs-toggle="tab" data-bs-target="#tab_items" type="button" role="tab" aria-controls="tab_items" aria-selected="true"><?php echo _l('wh_packing_list_detail'); ?></button>
						</li>
						
						<li class="nav-item" role="presentation">
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
												<?php echo html_entity_decode($packing_list->packing_list_number .' - '.$packing_list->packing_list_name); ?>
											</span>
										</h4>
										<address>
											<?php
											echo company_widget(get_default_company_id());
											?>
										</address>
										<p class="no-mbot">
											<span class="bold">
												<?php echo _l('stock_export'); ?>
												<a href="<?php echo get_uri('warehouse/view_delivery/'.$packing_list->delivery_note_id) ?>" ><?php echo wh_get_delivery_code($packing_list->delivery_note_id); ?></a>
											</span>
											<h5 class="bold">
											</h5>
										</p>
									</div>
									<div class="col-sm-6 text-right">
										<?php if(isset($billing_shipping)){
											echo html_entity_decode($billing_shipping);
										}
										?>
										
										<p class="no-mbot">
											<span class="bold">
												<?php echo _l('packing_date'); ?>
											</span>
											<?php echo format_to_datetime($packing_list->datecreated, false); ?>
										</p>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive">
											<table class="table items items-preview estimate-items-preview" data-type="estimate">
												<thead>
													<tr>
														<th align="center">#</th>
														<th  colspan="1"><?php echo _l('commodity_code') ?></th>
														<th align="right" colspan="1"><?php echo _l('quantity') ?></th>
														<th align="right" colspan="1"><?php echo _l('rate') ?></th>
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
													foreach ($packing_list_detail as $delivery => $packing_list_value) {
														$delivery++;
														$discount = (isset($packing_list_value) ? $packing_list_value['discount'] : '');
														$discount_money = (isset($packing_list_value) ? $packing_list_value['discount_total'] : '');

														$quantity = (isset($packing_list_value) ? $packing_list_value['quantity'] : '');
														$unit_price = (isset($packing_list_value) ? $packing_list_value['unit_price'] : '');
														$total_after_discount = (isset($packing_list_value) ? $packing_list_value['total_after_discount'] : '');

														$commodity_code = get_commodity_name($packing_list_value['commodity_code']) != null ? get_commodity_name($packing_list_value['commodity_code'])->commodity_code : '';
														$commodity_name = get_commodity_name($packing_list_value['commodity_code']) != null ? get_commodity_name($packing_list_value['commodity_code'])->description : '';

														$unit_name = '';
														if(is_numeric($packing_list_value['unit_id'])){
															$unit_name = get_unit_type($packing_list_value['unit_id']) != null ? ' '.get_unit_type($packing_list_value['unit_id'])->unit_name : '';
														}

														$commodity_name = $packing_list_value['commodity_name'];
														if(strlen($commodity_name) == 0){
															$commodity_name = wh_get_item_variatiom($packing_list_value['commodity_code']);
														}

														?>

														<tr>
															<td ><?php echo html_entity_decode($delivery) ?></td>
															<td ><?php echo html_entity_decode($commodity_name) ?></td>
															<td class="text-right"><?php echo html_entity_decode(to_decimal_format($quantity, 0)).$unit_name ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$unit_price) ?></td>

															<?php echo  wh_render_taxes_html(wh_convert_item_taxes($packing_list_value['tax_id'], $packing_list_value['tax_rate'], $packing_list_value['tax_name']), 15); ?>
															<td class="text-right"><?php echo to_decimal_format((float)$packing_list_value['sub_total'],'') ?></td>
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
										<table class="table text-right">
											<tbody>
												<tr id="subtotal">
													<td class="bold"><?php echo _l('subtotal'); ?></td>
													<td><?php echo to_currency((float)$packing_list->subtotal); ?></td>
												</tr>
												<?php if(isset($packing_list) && $tax_data['html_currency'] != ''){
													echo html_entity_decode($tax_data['html_currency']);
												} ?>
												<tr id="total_discount">
													<?php
													$discount_total = 0 ;
													if(isset($packing_list)){
														$discount_total += (float)$packing_list->discount_total  + (float)$packing_list->additional_discount;
													}
													?>
													<td class="bold"><?php echo _l('total_discount'); ?></td>
													<td><?php echo to_currency((float)$discount_total); ?></td>
												</tr>
												<tr id="shipping_fee">
													<?php
													$shipping_fee = isset($packing_list) ?  $packing_list->shipping_fee : 0 ;
													?>
													<td class="bold"><?php echo _l('wh_shipping_fee'); ?></td>
													<td><?php echo to_currency((float)$shipping_fee); ?></td>
												</tr>
												<tr id="totalmoney">
													<?php
													$total_after_discount = isset($packing_list) ?  $packing_list->total_after_discount : 0 ;
													?>
													<td class="bold"><?php echo _l('total_money'); ?></td>
													<td><?php echo to_currency((float)$total_after_discount); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<?php if($packing_list->client_note != ''){ ?>
										<div class="col-md-12 row mtop15">
											<p class="bold text-muted"><?php echo _l('client_note'); ?></p>
											<p><?php echo html_entity_decode($packing_list->client_note); ?></p>
										</div>
									<?php } ?>
									<?php if($packing_list->admin_note != ''){ ?>
										<div class="col-md-12 row mtop15">
											<p class="bold text-muted"><?php echo _l('admin_note'); ?></p>
											<p><?php echo html_entity_decode($packing_list->admin_note); ?></p>
										</div>
									<?php } ?>
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
														<?php if (file_exists(WAREHOUSE_PACKING_LIST_MODULE_UPLOAD_FOLDER . $packing_list->id . '/signature_'.$value['id'].'.png') ){ ?>

															<img src="<?php echo base_url('plugins/Warehouse/Uploads/packing_lists/'.$packing_list->id.'/signature_'.$value['id'].'.png'); ?>" class="img-width-height">

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
											if($packing_list->approval != 1 && ($check_approve_status == false ))

												{ ?>
													<?php if($check_appr && $check_appr != false){ ?>

														<a data-toggle="tooltip" data-loading-text="<?php echo app_lang('wait_text'); ?>" class="btn btn-success lead-top-btn lead-view" data-placement="top" href="#" onclick="send_request_approve(<?php echo html_entity_decode($packing_list->id); ?>); return false;"><span data-feather="send" class="icon-16" ></span> <?php echo app_lang('send_request_approve'); ?></a>
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

																		<a href="#" class="btn btn-success pull-left display-block  mr-4 button-margin-r-b" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="approve_request(<?php echo html_entity_decode($packing_list->id); ?>); return false;"><span data-feather="upload" class="icon-16"></span>
																			<?php echo app_lang('approve'); ?>
																		</a>

																		<a href="#" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="deny_request(<?php echo html_entity_decode($packing_list->id); ?>); return false;" class="btn btn-warning text-white"><span data-feather="x" class="icon-16"></span><?php echo app_lang('deny'); ?>
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


						<div class="tab-pane fade" id="tab_order_return" role="tabpanel" aria-labelledby="tab_order_return-tab">
							<div class="row">
								<div class="col-md-12">
									<div class="activity-feed">
										<?php foreach($activity_log as $log){ ?>
											<div class="feed-item">
												<div class="date">
													<span class="text-has-action" data-toggle="tooltip" data-title="<?php echo format_to_datetime($log['date'], false); ?>">
														<?php echo format_to_datetime($log['date'], false); ?>
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
				<button onclick="sign_request(<?php echo html_entity_decode($packing_list->id); ?>);"  autocomplete="off" class="btn btn-primary sign_request_class"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('e_signature_sign'); ?></button>
			</div>
		</div>
	</div>
</div>

<?php require 'plugins/Warehouse/assets/js/packing_lists/view_packing_list_js.php';?>

</body>
</html>
<?php echo form_hidden('_attachment_sale_id',$packing_list->id); ?>