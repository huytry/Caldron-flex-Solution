<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('internal_delivery_note'); ?></h4>
					<div class="title-button-group">
						<span class="dropdown inline-block mt10">
							<button class="btn btn-info text-white dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true">
								<i data-feather="tool" class="icon-16"></i> <?php echo app_lang('actions'); ?>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_internal_delivery_pdf/" . $internal_delivery->id), "<i data-feather='download' class='icon-16'></i> " . app_lang('download_pdf'), array("title" => app_lang('download_pdf'), "class" => "dropdown-item")); ?> </li>
								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_internal_delivery_pdf/" . $internal_delivery->id . "/view"), "<i data-feather='file-text' class='icon-16'></i> " . app_lang('view_pdf'), array("title" => app_lang('view_pdf'), "target" => "_blank", "class" => "dropdown-item")); ?> </li>

								<li role="presentation"><?php echo js_anchor("<i data-feather='printer' class='icon-16'></i> " . app_lang('print_invoice'), array('title' => app_lang('print_invoice'), 'id' => 'print-invoice-btn', "class" => "dropdown-item")); ?> </li>

								<?php if((has_permission('warehouse', '', 'edit') || is_admin()) && ($internal_delivery->approval == 0)){ ?>
									<li role="presentation" class="dropdown-divider"></li>

									<li role="presentation"><a href="<?php echo site_url('warehouse/add_update_internal_delivery/' . $internal_delivery->id ) ?>" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> <?php echo app_lang('edit')  ?></a></li>

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
									<td class="bold" width="30%"><?php echo _l('internal_delivery_note'); ?></td>
									<td><?php echo html_entity_decode($internal_delivery->internal_delivery_code .' - '.$internal_delivery->internal_delivery_name) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold" width="30%"><?php echo _l('deliver_name'); ?></td>
									<td><?php echo html_entity_decode(get_staff_full_name1($internal_delivery->staff_id)) ; ?></td>

								</tr>
								<tr class="project-overview">
									<td class="bold"><?php echo _l('addedfrom'); ?></td>
									<td><?php echo html_entity_decode(get_staff_full_name1($internal_delivery->addedfrom)) ; ?></td>
								</tr>

								<tr class="project-overview">
									<td class="bold"><?php echo _l('datecreated'); ?></td>
									<td><?php echo format_to_datetime($internal_delivery->datecreated, false) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold"><?php echo _l('note_'); ?></td>
									<td><?php echo html_entity_decode($internal_delivery->description) ; ?></td>
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
											<th  colspan="1"><?php echo _l('commodity_code') ?></th>
											<th colspan="1"><?php echo _l('from_stock_name') ?></th>
											<th colspan="1"><?php echo _l('to_stock_name') ?></th>
											<th  colspan="1"><?php echo _l('unit_name') ?></th>
											<th  colspan="1" class="text-center"><?php echo _l('available_quantity') ?></th>
											<th  colspan="1" class="text-center"><?php echo _l('quantity_export') ?></th>
											<th align="right" colspan="1"><?php echo _l('unit_price') ?></th>
											<th align="right" colspan="1"><?php echo _l('into_money') ?></th>
										</tr>
									</thead>
									<tbody class="ui-sortable">

										<?php 
										foreach ($internal_delivery_detail as $internal_delivery_key => $internal_delivery_value) {

											$internal_delivery_key++;
											$availale_quantity = (isset($internal_delivery_value) ? $internal_delivery_value['available_quantity'] : '');
											$quantities = (isset($internal_delivery_value) ? $internal_delivery_value['quantities'] : '');

											$unit_price = (isset($internal_delivery_value) ? $internal_delivery_value['unit_price'] : '');
											$into_money = (isset($internal_delivery_value) ? $internal_delivery_value['into_money'] : '');

											$commodity_code = get_commodity_name($internal_delivery_value['commodity_code']) != null ? get_commodity_name($internal_delivery_value['commodity_code'])->commodity_code : '';
											$commodity_name = get_commodity_name($internal_delivery_value['commodity_code']) != null ? get_commodity_name($internal_delivery_value['commodity_code'])->description : '';

											$unit_name ='';
											if(is_numeric($internal_delivery_value['unit_id'])){
												$unit_name = get_unit_type($internal_delivery_value['unit_id']) != null ? get_unit_type($internal_delivery_value['unit_id'])->unit_name : '';

											}


											$from_stock_name = get_warehouse_name($internal_delivery_value['from_stock_name']) != null ? get_warehouse_name($internal_delivery_value['from_stock_name'])->warehouse_name : '';

											$to_stock_name = get_warehouse_name($internal_delivery_value['to_stock_name']) != null ? get_warehouse_name($internal_delivery_value['to_stock_name'])->warehouse_name : '';

											$commodity_name = $internal_delivery_value['commodity_name'];
											if(strlen($commodity_name) == 0){
												$commodity_name = wh_get_item_variatiom($internal_delivery_value['commodity_code']);
											}
											?>

											<tr>
												<td ><?php echo html_entity_decode($internal_delivery_key) ?></td>
												<td ><?php echo html_entity_decode($commodity_name) ?></td>
												<td ><?php echo html_entity_decode($from_stock_name) ?></td>
												<td ><?php echo html_entity_decode($to_stock_name) ?></td>
												<td ><?php echo html_entity_decode($unit_name) ?></td>

												<td class="text-right" ><?php echo html_entity_decode($availale_quantity) ?></td>
												<td class="text-right" ><?php echo html_entity_decode($quantities) ?></td>

												<td class="text-right"><?php echo to_currency((float)$unit_price) ?></td>
												<td class="text-right"><?php echo to_currency((float)$into_money) ?></td>

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
									<tr class="project-overview">
										<?php $total_amount = isset($internal_delivery) ?  $internal_delivery->total_amount : 0 ;?>
										<td class="td_style"><span class="bold"><?php echo _l('total_amount'); ?></span></td>
										<td><?php echo to_currency((float)$total_amount); ?></td>
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

											<?php if (file_exists(WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER . $internal_delivery->id . '/signature_'.$value['id'].'.png') ){ ?>

												<img src="<?php echo base_url('plugins/Warehouse/Uploads/internal_delivery/'.$internal_delivery->id.'/signature_'.$value['id'].'.png'); ?>" class="img-width-height">
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
								if($internal_delivery->approval != 1 && ($check_approve_status == false ))

									{ ?>
										<?php if($check_appr && $check_appr != false){ ?>

											<a data-toggle="tooltip" data-loading-text="<?php echo app_lang('wait_text'); ?>" class="btn btn-success lead-top-btn lead-view" data-placement="top" href="#" onclick="send_request_approve(<?php echo html_entity_decode($internal_delivery->id); ?>); return false;"><span data-feather="send" class="icon-16" ></span> <?php echo app_lang('send_request_approve'); ?></a>
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

															<a href="#" class="btn btn-success pull-left display-block  mr-4 button-margin-r-b" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="approve_request(<?php echo html_entity_decode($internal_delivery->id); ?>); return false;"><span data-feather="upload" class="icon-16"></span>
																<?php echo app_lang('approve'); ?>
															</a>

															<a href="#" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="deny_request(<?php echo html_entity_decode($internal_delivery->id); ?>); return false;" class="btn btn-warning text-white"><span data-feather="x" class="icon-16"></span><?php echo app_lang('deny'); ?>
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
				<button onclick="sign_request(<?php echo html_entity_decode($internal_delivery->id); ?>);"  autocomplete="off" class="btn btn-primary sign_request_class"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('e_signature_sign'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/internal_deliveries/view_internal_delivery_js.php';?>

</body>
</html>