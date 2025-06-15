
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<?php echo form_open_multipart(get_uri("warehouse/add_update_internal_delivery"), array("id" => "add_update_internal_delivery", "class" => "general-form", "role" => "form")); ?>
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
				</div>
				<div class="modal-body clearfix">

					<?php 
					$id = '';
					if(isset($internal_delivery)){
						$id = $internal_delivery->id;
						echo form_hidden('isedit');
					}
					?>
					<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">

					<!-- start-->
					<div class="row">
						<div class="col-md-6">
							<?php $internal_delivery_name = (isset($internal_delivery) ? $internal_delivery->internal_delivery_name : $internal_delivery_name_ex);
							echo render_input1('internal_delivery_name','internal_delivery_name',$internal_delivery_name); ?>
						</div>
						<div class="col-md-3">
							<?php $date_c = isset($internal_delivery) ? $internal_delivery->date_c : get_my_local_time("Y-m-d") ;?>
							<?php echo render_date_input1('date_c','accounting_date', format_to_date($date_c, false)) ?>
						</div>

						<div class="col-md-3">
							<?php $date_add = isset($internal_delivery) ? $internal_delivery->date_add : get_my_local_time("Y-m-d") ;?>
							<?php echo render_date_input1('date_add','day_vouchers', format_to_date($date_add, false)) ?>
						</div>

						<div class="col-md-6">

							<?php $prefix = get_setting('internal_delivery_number_prefix');
							$next_number = get_setting('next_internal_delivery_mumber');

							$internal_delivery_code = (isset($internal_delivery) ? $internal_delivery->internal_delivery_code : $next_number);
							$internal_delivery_code = (isset($internal_delivery) ? $internal_delivery->internal_delivery_code : $next_number);
							echo form_hidden('internal_delivery_code',$internal_delivery_code); ?> 

							<label for="internal_delivery_code"><?php echo _l('internal_delivery_note_number'); ?></label>
							<div class="input-group" id="discount-total">
								<span class="input-group-text" id="basic-addon1"><?php echo html_entity_decode($prefix) ;?></span>
								<input type="text" readonly class="form-control" name="internal_delivery_code" value="<?php echo html_entity_decode($internal_delivery_code); ?>">
							</div>

						</div>
						<div class="col-md-6">
							<?php
							$selected = '';
							foreach($staff as $member){
								if(isset($internal_delivery)){
									if($internal_delivery->staff_id == $member['id']) {
										$selected = $member['id'];
									}
								}
							}
							echo render_select1('staff_id',$staff,array('id',array('first_name','last_name')),'deliver_name',$selected);
							?>
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
									<th width="20%" align="left"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" data-title="<?php echo _l('item_description_new_lines_notice'); ?>"></i> <?php echo _l('invoice_table_item_heading'); ?></th>
									<th width="15%" align="left"><?php echo _l('from_stock_name'); ?></th>
									<th width="15%" align="left"><?php echo _l('to_stock_name'); ?></th>
									<th width="10%" align="right" class="qty"><?php echo _l('available_quantity'); ?></th>
									<th width="10%" align="right" class="qty"><?php echo _l('quantity'); ?></th>
									<th width="10%" align="right"><?php echo _l('unit_price'); ?></th>
									<th width="10%" align="right"><?php echo _l('invoice_table_amount_heading'); ?></th>
									<th align="center"><span data-feather="settings" class="icon-16"></span></th>
								</tr>
							</thead>
							<tbody>
								<?php echo html_entity_decode($internal_delivery_row_template); ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-8 title-button-group">
						<table class="table text-right">
							<tbody>
								<tr id="totalmoney">
									<td><span class="bold"><?php echo _l('total_amount'); ?> :</span>
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
						<?php $description = (isset($internal_delivery) ? $internal_delivery->description : ''); ?>
						<?php echo render_textarea1('description','note_',$description,array(),array(),'mtop15'); ?>

						<div class="btn-bottom-toolbar text-right mb20">

							<a href="<?php echo get_uri('warehouse/manage_internal_delivery'); ?>"class="btn btn-default text-right mright5"><span data-feather="x" class="icon-16"></span> <?php echo _l('close'); ?>
						</a>
						<?php if (is_admin() || has_permission('warehouse', '', 'edit') || has_permission('warehouse', '', 'create')) { ?>
							<?php if(isset($internal_delivery) && $internal_delivery->approval == 0){ ?>
								<button type="button" class="btn btn-info btn_add_internal_delivery text-white"><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('save'); ?>
							</button>
						<?php }elseif(!isset($internal_delivery)){ ?>
							<button type="button" class="btn btn-info btn_add_internal_delivery text-white"><span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('save'); ?>
						</button>
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

<?php require 'plugins/Warehouse/assets/js/internal_deliveries/add_edit_internal_delivery_js.php';?>

</body>
</html>
