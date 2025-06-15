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

								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_goods_delivery_pdf/" . $goods_delivery->id), "<i data-feather='download' class='icon-16'></i> " . app_lang('download_pdf'), array("title" => app_lang('download_pdf'), "class" => "dropdown-item")); ?> </li>
								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_goods_delivery_pdf/" . $goods_delivery->id . "/view"), "<i data-feather='file-text' class='icon-16'></i> " . app_lang('view_pdf'), array("title" => app_lang('view_pdf'), "target" => "_blank", "class" => "dropdown-item")); ?> </li>

								<li role="presentation"><?php echo js_anchor("<i data-feather='printer' class='icon-16'></i> " . app_lang('print_invoice'), array('title' => app_lang('print_invoice'), 'id' => 'print-invoice-btn', "class" => "dropdown-item")); ?> </li>

								<?php if((has_permission('warehouse', '', 'edit') || is_admin()) && ($goods_delivery->approval == 0)){ ?>
									<li role="presentation" class="dropdown-divider"></li>

									<li role="presentation"><a href="<?php echo site_url('warehouse/goods_delivery/' . $goods_delivery->id ) ?>" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> <?php echo app_lang('edit')  ?></a></li>

								<?php } ?>
							</ul>
						</span>

					</div>
				</div>

				<div class="card-header ">
					<ul class="nav nav-tabs pb15 justify-content-left border-bottom-0" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="tab_items-tab" data-bs-toggle="tab" data-bs-target="#tab_items" type="button" role="tab" aria-controls="tab_items" aria-selected="true"><?php echo _l('export_output_slip'); ?></button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="tab_receipt_delivery-tab" data-bs-toggle="tab" data-bs-target="#tab_receipt_delivery" type="button" role="tab" aria-controls="tab_receipt_delivery" aria-selected="false"><?php echo _l('wh_packing_list'); ?></button>
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

								<div class="col-md-12 panel-padding">
									<table class="table border table-striped table-margintop" >
										<tbody>

											<?php 

											$customer_name='';
											if($goods_delivery){


												if(is_numeric($goods_delivery->customer_code)){
													$Clients_model = model("Models\Clients_model");

													$client_options = [
														'id' => $goods_delivery->customer_code,
													];
													$customer_value = $Clients_model->get_details($client_options)->getRow();

													if($customer_value){
														$customer_name .= $customer_value->company_name;
													}
												}

											}
											?>

											<tr class="project-overview">
												<td class="bold" width="30%"><?php echo _l('customer_name'); ?></td>
												<td><?php echo html_entity_decode($customer_name) ; ?></td>
											</tr>
											<tr class="project-overview">
												<td class="bold"><?php echo _l('to'); ?></td>
												<td><?php echo html_entity_decode($goods_delivery->to_) ; ?></td>
											</tr>
											<tr class="project-overview">
												<td class="bold"><?php echo _l('address'); ?></td>
												<td><?php echo html_entity_decode($goods_delivery->address) ; ?></td>
											</tr>
											<tr class="project-overview">
												<td class="bold"><?php echo _l('note_'); ?></td>
												<td><?php echo html_entity_decode($goods_delivery->description) ; ?></td>
											</tr>

											<?php 
											if( ($goods_delivery->invoice_id != '') && ($goods_delivery->invoice_id != 0) ){ ?>

												<tr class="project-overview">
													<td class="bold"><?php echo _l('invoices'); ?></td>
													<td>
														<a href="<?php echo get_uri('invoices/view/'.$goods_delivery->invoice_id) ?>" ><?php echo get_invoice_id($goods_delivery->invoice_id) ?></a>

													</td>
												</tr>

											<?php   }
											?>

											<?php 
											if (get_status_modules_wh('purchase')) {
												if( ($goods_delivery->pr_order_id != '') && ($goods_delivery->pr_order_id != 0) ){ ?>

													<tr class="project-overview">
														<td class="bold"><?php echo _l('reference_purchase_order'); ?></td>
														<td>
															<a href="<?php echo get_uri('purchase/purchase_order/'.$goods_delivery->pr_order_id) ?>" ><?php echo get_pur_order_name($goods_delivery->pr_order_id) ?></a>

														</td>
													</tr>

												<?php   }
											}
											?>

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
														<th  colspan="1"><?php echo _l('commodity_code') ?></th>
														<th colspan="1"><?php echo _l('warehouse_name') ?></th>
														<th colspan="1"><?php echo _l('available_quantity') ?></th>
														<th  colspan="1"><?php echo _l('unit_name') ?></th>
														<th  colspan="1" class="text-center"><?php echo _l('quantity') ?></th>
														<th align="right" colspan="1"><?php echo _l('rate') ?></th>
														<th align="right" colspan="1"><?php echo _l('subtotal') ?></th>
														<th align="right" colspan="1"><?php echo _l('subtotal_after_tax') ?></th>
														<th align="right" colspan="1"><?php echo _l('discount').'(%)' ?></th>
														<th align="right" colspan="1"><?php echo _l('discount(money)') ?></th>
														<th align="right" colspan="1"><?php echo _l('lot_number').'/'._l('quantity') ?></th>
														<th align="right" colspan="1"><?php echo _l('total_money') ?></th>
														<th align="right" colspan="1"><?php echo _l('guarantee_period') ?></th>

													</tr>
												</thead>
												<tbody class="ui-sortable">
													<?php 
													$subtotal = 0 ;
													foreach ($goods_delivery_detail as $delivery => $delivery_value) {
														$delivery++;
														$available_quantity = (isset($delivery_value) ? $delivery_value['available_quantity'] : '');
														$total_money = (isset($delivery_value) ? $delivery_value['total_money'] : '');
														$discount = (isset($delivery_value) ? $delivery_value['discount'] : '');
														$discount_money = (isset($delivery_value) ? $delivery_value['discount_money'] : '');
														$guarantee_period = (isset($delivery_value) ? format_to_date($delivery_value['guarantee_period']) : '');

														$quantities = (isset($delivery_value) ? $delivery_value['quantities'] : '');
														$unit_price = (isset($delivery_value) ? $delivery_value['unit_price'] : '');
														$total_after_discount = (isset($delivery_value) ? $delivery_value['total_after_discount'] : '');

														$commodity_code = get_commodity_name($delivery_value['commodity_code']) != null ? get_commodity_name($delivery_value['commodity_code'])->commodity_code : '';
														$commodity_name = get_commodity_name($delivery_value['commodity_code']) != null ? get_commodity_name($delivery_value['commodity_code'])->description : '';
														$subtotal += (float)$delivery_value['quantities'] * (float)$delivery_value['unit_price'];
														$item_subtotal = (float)$delivery_value['quantities'] * (float)$delivery_value['unit_price'];



														$warehouse_name ='';

														if(isset($delivery_value['warehouse_id']) && ($delivery_value['warehouse_id'] !='')){
															$arr_warehouse = explode(',', $delivery_value['warehouse_id']);

															$str = '';
															if(count($arr_warehouse) > 0){

																foreach ($arr_warehouse as $wh_key => $warehouseid) {
																	$str = '';
																	if ($warehouseid != '' && $warehouseid != '0') {

																		$team = get_warehouse_name($warehouseid);
																		if($team){
																			$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

																			$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide">, </span></span>&nbsp';

																			$warehouse_name .= $str;
																			if($wh_key%3 ==0){
																				$warehouse_name .='<br/>';
																			}
																		}

																	}
																}

															} else {
																$warehouse_name = '';
															}
														}



														$unit_name = '';
														if(is_numeric($delivery_value['unit_id'])){
															$unit_name = get_unit_type($delivery_value['unit_id']) != null ? get_unit_type($delivery_value['unit_id'])->unit_name : '';
														}

														$lot_number ='';
														if(($delivery_value['lot_number'] != null) && ( $delivery_value['lot_number'] != '') ){
															$array_lot_number = explode(',', $delivery_value['lot_number']);
															foreach ($array_lot_number as $key => $lot_value) {

																if($key%2 ==0){
																	$lot_number .= $lot_value;
																}else{
																	$lot_number .= ' : '.$lot_value.' ';
																}

															}
														}

														$commodity_name = $delivery_value['commodity_name'];
														if(strlen($commodity_name) == 0){
															$commodity_name = wh_get_item_variatiom($delivery_value['commodity_code']);
														}

														?>

														<tr>
															<td ><?php echo html_entity_decode($delivery) ?></td>
															<td ><?php echo html_entity_decode($commodity_name) ?></td>
															<td ><?php echo html_entity_decode($warehouse_name) ?></td>
															<td ><?php echo html_entity_decode($available_quantity) ?></td>
															<td ><?php echo html_entity_decode($unit_name) ?></td>
															<td class="text-right"><?php echo html_entity_decode($quantities) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$unit_price) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$item_subtotal) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$total_money,) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$discount) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$discount_money) ?></td>
															<td class="text-right"><?php echo html_entity_decode($lot_number) ?></td>
															<td class="text-right"><?php echo to_decimal_format((float)$total_after_discount) ?></td>
															<td class="text-right"><?php echo html_entity_decode($guarantee_period) ?></td>
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
													<td><?php echo to_currency((float)$subtotal); ?></td>
												</tr>
												<?php if(isset($goods_delivery) && $tax_data['html_currency'] != ''){
													echo html_entity_decode($tax_data['html_currency']);
												} ?>
												<tr id="total_discount">
													<?php
													$total_discount = 0 ;
													if(isset($goods_delivery)){
														$total_discount += (float)$goods_delivery->total_discount  + (float)$goods_delivery->additional_discount;
													}
													?>
													<td class="bold"><?php echo _l('total_discount'); ?></td>
													<td><?php echo to_currency((float)$total_discount); ?></td>
												</tr>
												<tr id="shipping_fee">
													<?php
													$shipping_fee = 0 ;
													if(isset($goods_delivery)){
														$shipping_fee = (float)$goods_delivery->shipping_fee;
													}
													?>
													<td class="bold"><?php echo _l('wh_shipping_fee'); ?></td>
													<td><?php echo to_currency((float)$shipping_fee); ?></td>
												</tr>
												<tr id="totalmoney">
													<?php
													$after_discount = isset($goods_delivery) ?  $goods_delivery->after_discount : 0 ;
													if($goods_delivery->after_discount == null){
														$after_discount = $goods_delivery->total_money;
													}
													?>
													<td class="bold"><?php echo _l('total_money'); ?></td>
													<td><?php echo to_currency((float)$after_discount); ?></td>
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
															<?php if (file_exists(WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER . $goods_delivery->id . '/signature_'.$value['id'].'.png') ){ ?>

																<img src="<?php echo base_url('plugins/Warehouse/Uploads/stock_export/'.$goods_delivery->id.'/signature_'.$value['id'].'.png'); ?>" class="img-width-height">

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
													if($goods_delivery->approval != 1 && ($check_approve_status == false ))

														{ ?>
															<?php if($check_appr && $check_appr != false){ ?>

																<a data-toggle="tooltip" data-loading-text="<?php echo app_lang('wait_text'); ?>" class="btn btn-success lead-top-btn lead-view" data-placement="top" href="#" onclick="send_request_approve(<?php echo html_entity_decode($goods_delivery->id); ?>); return false;"><span data-feather="send" class="icon-16" ></span> <?php echo app_lang('send_request_approve'); ?></a>
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

																				<a href="#" class="btn btn-success pull-left display-block  mr-4 button-margin-r-b" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="approve_request(<?php echo html_entity_decode($goods_delivery->id); ?>); return false;"><span data-feather="upload" class="icon-16"></span>
																					<?php echo app_lang('approve'); ?>
																				</a>

																				<a href="#" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="deny_request(<?php echo html_entity_decode($goods_delivery->id); ?>); return false;" class="btn btn-warning text-white"><span data-feather="x" class="icon-16"></span><?php echo app_lang('deny'); ?>
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

								<div class="tab-pane fade" id="tab_receipt_delivery" role="tabpanel" aria-labelledby="tab_receipt_delivery-tab">
									<div class="row">
										<div class="col-md-12">
											<?php if(count($packing_lists) > 0){ ?>
												<div class="table-responsive">
													<table class="table items items-preview estimate-items-preview" data-type="estimate">
														<thead>
															<tr>
																<th  colspan="1"><?php echo _l('packing_list_number') ?></th>
																<th  colspan="1"><?php echo _l('customer_name') ?></th>
																<th align="right" colspan="1"><?php echo _l('wh_dimension') ?></th>
																<th align="right" colspan="1"><?php echo _l('volume_m3_label') ?></th>
																<th align="right" colspan="1"><?php echo _l('total_amount') ?></th>
																<th align="right" colspan="1"><?php echo _l('discount_total') ?></th>
																<th align="right" colspan="1"><?php echo _l('total_after_discount') ?></th>
																<th align="right" colspan="1"><?php echo _l('datecreated') ?></th>
																<th align="right" colspan="1"><?php echo _l('status_label') ?></th>
															</tr>
														</thead>
														<tbody class="ui-sortable">
															<?php 
															$subtotal = 0 ;
															foreach ($packing_lists as $key => $packing_list) {
																$delivery++;

																$customer_name = '';
																if(is_numeric($packing_list['clientid'])){
																	$Clients_model = model("Models\Clients_model");

																	$client_options = [
																		'id' => $packing_list['clientid'],
																	];
																	$customer_value = $Clients_model->get_details($client_options)->getRow();

																	if($customer_value){
																		$customer_name .= $customer_value->company_name;
																	}
																}

																?>

																<tr>
																	<td ><a href="<?php echo get_uri('warehouse/view_packing_list/' . $packing_list['id'] ) ?>" ><?php echo html_entity_decode($packing_list['packing_list_number'] .' - '.$packing_list['packing_list_name']) ?></a></td>
																	<td ><?php echo html_entity_decode($customer_name) ?></td>
																	<td class="text-right"><?php echo html_entity_decode($packing_list['width'].' x '.$packing_list['height'].' x '.$packing_list['lenght']) ?></td>
																	<td class="text-right"><?php echo to_decimal_format($packing_list['volume']) ?></td>
																	<td class="text-right"><?php echo to_decimal_format($packing_list['total_amount']) ?></td>
																	<td class="text-right"><?php echo to_decimal_format($packing_list['discount_total']+$packing_list['additional_discount']) ?></td>
																	<td class="text-right"><?php echo to_decimal_format($packing_list['total_after_discount']) ?></td>
																	<td class="text-right"><?php echo format_to_datetime($packing_list['datecreated']) ?></td>
																	<?php 
																	$approve_data = '';
																	if($packing_list['approval'] == 1){
																		$approve_data = '<span class="badge bg-info large mt-0">'._l('approved').'</span>';
																	}elseif($packing_list['approval'] == 0){
																		$approve_data = '<span class="badge bg-primary large mt-0">'._l('not_yet_approve').'</span>';
																	}elseif($packing_list['approval'] == -1){
																		$approve_data = '<span class="badge bg-danger large mt-0">'._l('reject').'</span>';
																	}
																	?>
																	<td class="text-right"><?php echo html_entity_decode($approve_data); ?></td>
																</tr>
															<?php  } ?>
														</tbody>
													</table>

												</div>
											<?php } ?>
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
						<button onclick="sign_request(<?php echo html_entity_decode($goods_delivery->id); ?>);"  autocomplete="off" class="btn btn-primary sign_request_class"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('e_signature_sign'); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php require 'plugins/Warehouse/assets/js/goods_deliveries/view_delivery_js.php';?>

	</body>
	</html>






