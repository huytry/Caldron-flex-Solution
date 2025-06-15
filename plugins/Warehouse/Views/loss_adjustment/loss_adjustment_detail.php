<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group d-none">
						<span class="dropdown inline-block mt10">
							<button class="btn btn-info text-white dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true">
								<i data-feather="tool" class="icon-16"></i> <?php echo app_lang('actions'); ?>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_loss_adjustment_pdf/" . $loss_adjustment->id), "<i data-feather='download' class='icon-16'></i> " . app_lang('download_pdf'), array("title" => app_lang('download_pdf'), "class" => "dropdown-item")); ?> </li>
								<li role="presentation"><?php echo anchor(get_uri("warehouse/download_loss_adjustment_pdf/" . $loss_adjustment->id . "/view"), "<i data-feather='file-text' class='icon-16'></i> " . app_lang('view_pdf'), array("title" => app_lang('view_pdf'), "target" => "_blank", "class" => "dropdown-item")); ?> </li>

								<li role="presentation"><?php echo js_anchor("<i data-feather='printer' class='icon-16'></i> " . app_lang('print_invoice'), array('title' => app_lang('print_invoice'), 'id' => 'print-invoice-btn', "class" => "dropdown-item")); ?> </li>

								<?php if((has_permission('warehouse', '', 'edit') || is_admin()) && ($loss_adjustment->status == 0)){ ?>
									<li role="presentation" class="dropdown-divider"></li>

									<li role="presentation"><a href="<?php echo site_url('warehouse/manage_loss_adjustment/' . $loss_adjustment->id ) ?>" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> <?php echo app_lang('edit')  ?></a></li>

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
									<td class="bold" width="30%"><?php echo app_lang('loss_adjustment_title'); ?></td>
									<td><?php echo html_entity_decode($loss_adjustment->loss_adjustment_title) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold" width="30%"><?php echo _l('type'); ?></td>
									<td><?php echo _l($loss_adjustment->type) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold" width="30%"><?php echo _l('add_from'); ?></td>
									<td><?php echo get_staff_full_name1($loss_adjustment->addfrom) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold"><?php echo _l('time'); ?></td>
									<td><?php echo html_entity_decode(format_to_datetime($loss_adjustment->time)) ; ?></td>
								</tr>
								<tr class="project-overview">
									<td class="bold"><?php echo _l('reason'); ?></td>
									<td><?php echo html_entity_decode($loss_adjustment->reason) ; ?></td>
								</tr>

								<?php 
								$warehouse_code = get_warehouse_name($loss_adjustment->warehouses) != null ? get_warehouse_name($loss_adjustment->warehouses)->warehouse_name : '';
								?>
								<tr class="project-overview">
									<td class="bold"><?php echo _l('warehouse_name'); ?></td>
									<td><?php echo html_entity_decode($warehouse_code) ; ?></td>
								</tr>

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
										<th  colspan="1"><?php echo _l('unit_name') ?></th>
										<th align="right" colspan="1"><?php echo _l('lot_number') ?></th>
										<th align="right" colspan="1"><?php echo _l('expiry_date') ?></th>
										<th  colspan="1" class="text-center"><?php echo _l('available_quantity') ?></th>
										<th align="right" colspan="1"><?php echo _l('stock_quantity') ?></th>
										<th align="right" colspan="1"><?php echo _l('wh_serial_number_list') ?></th>

									</tr>
								</thead>
								<tbody class="ui-sortable">

									<?php 
									foreach ($loss_adjustment_detail as $detail_key => $detail_value) {

										$detail_key++;

										$available_quantity = (isset($detail_value) ? $detail_value['current_number'] : '');
										$stock_quantity = (isset($detail_value) ? $detail_value['updates_number'] : '');

										$commodity_code = get_commodity_name($detail_value['items']) != null ? get_commodity_name($detail_value['items'])->commodity_code : '';
										$commodity_name = get_commodity_name($detail_value['items']) != null ? get_commodity_name($detail_value['items'])->description : '';

										$unit_name ='';
										if(is_numeric($detail_value['unit'])){
											$unit_name = get_unit_type($detail_value['unit']) != null ? get_unit_type($detail_value['unit'])->unit_name : '';

										}

										$expiry_date =(isset($detail_value) ? $detail_value['expiry_date'] : '');
										$lot_number =(isset($detail_value) ? $detail_value['lot_number'] : '');
										$commodity_name = $detail_value['commodity_name'];
										if(strlen($commodity_name) == 0){
											$commodity_name = wh_get_item_variatiom($detail_value['items']);
										}

										if(strlen($detail_value['serial_number']) > 0){
											$name_serial_number_tooltip = _l('wh_serial_number').': '.$detail_value['serial_number'];
										}else{
											$name_serial_number_tooltip = '';
										}

										?>

										<tr data-toggle="tooltip" data-original-title="<?php echo html_entity_decode($name_serial_number_tooltip); ?>">
											<td ><?php echo html_entity_decode($detail_key) ?></td>
											<td ><?php echo html_entity_decode($commodity_name) ?></td>
											<td ><?php echo html_entity_decode($unit_name) ?></td>
											<td class="text-right"><?php echo html_entity_decode($lot_number) ?></td>
											<td class="text-right"><?php echo format_to_date($expiry_date) ?></td>
											<td class="text-right" ><?php echo html_entity_decode($available_quantity) ?></td>
											<td class="text-right"><?php echo html_entity_decode($stock_quantity) ?></td>
											<td class="text-right"><?php echo html_entity_decode($detail_value['serial_number']) ?></td>

										</tr>
									<?php  } ?>
								</tbody>
							</table>
						</div>
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
										<?php if (file_exists(WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER . $loss_adjustment->id . '/signature_'.$value['id'].'.png') ){ ?>

											<img src="<?php echo base_url('plugins/Warehouse/Uploads/lost_adjustment/'.$loss_adjustment->id.'/signature_'.$value['id'].'.png'); ?>" class="img-width-height">

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
							if($loss_adjustment->status != 1 && ($check_approve_status == false ))

								{ ?>
									<?php if($check_appr && $check_appr != false){ ?>

										<a data-toggle="tooltip" data-loading-text="<?php echo app_lang('wait_text'); ?>" class="btn btn-success lead-top-btn lead-view" data-placement="top" href="#" onclick="send_request_approve(<?php echo html_entity_decode($loss_adjustment->id); ?>); return false;"><span data-feather="send" class="icon-16" ></span> <?php echo app_lang('send_request_approve'); ?></a>
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

														<a href="#" class="btn btn-success pull-left display-block  mr-4 button-margin-r-b" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="approve_request(<?php echo html_entity_decode($loss_adjustment->id); ?>); return false;"><span data-feather="upload" class="icon-16"></span>
															<?php echo app_lang('approve'); ?>
														</a>

														<a href="#" data-loading-text="<?php echo app_lang('wait_text'); ?>" onclick="deny_request(<?php echo html_entity_decode($loss_adjustment->id); ?>); return false;" class="btn btn-warning text-white"><span data-feather="x" class="icon-16"></span><?php echo app_lang('deny'); ?>
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

				<div class="btn-bottom-toolbar text-right mb20">
					<a href="<?php echo get_uri('warehouse/loss_adjustment'); ?>"class="btn btn-default text-right mright5"><span data-feather="x" class="icon-16"></span> <?php echo _l('close'); ?></a>
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
				<button onclick="sign_request(<?php echo html_entity_decode($loss_adjustment->id); ?>);"  autocomplete="off" class="btn btn-primary sign_request_class"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('e_signature_sign'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/loss_adjustments/view_lost_adjustment_js.php';?>

</body>
</html>