<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<?php echo form_open_multipart(get_uri("warehouse/add_loss_adjustment"), array("id" => "pur_order-form", "class" => "_transaction_form general-form", "role" => "form")); ?>
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('loss_adjustment'); ?></h4>
				</div>
				<div class="modal-body clearfix">

					<?php 
					$id = '';
					if(isset($loss_adjustment)){
						$id = $loss_adjustment->id;
						echo form_hidden('isedit');
					}
					?>

					<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">

					<!-- start-->

					<div class="row">

						<div class=" col-md-6">
							<?php $loss_adjustment_title = (isset($loss_adjustment) ? $loss_adjustment->loss_adjustment_title : $internal_delivery_name_ex);
							echo render_input1('loss_adjustment_title','loss_adjustment_title',$loss_adjustment_title) ?>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="vendor"><span class="text-danger">* </span><?php echo _l('_warehouse'); ?></label>
								<select name="warehouses" class="select2 validate-hidden" id="warehouses" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" required="true"> 
									<option value=""></option>
									<?php foreach($warehouses as $wh){ ?>
										<option value="<?php echo html_entity_decode($wh['id']); ?>" <?php if(isset($loss_adjustment) && $loss_adjustment->warehouses == $wh['id']){ echo 'selected';} ?> ><?php echo html_entity_decode($wh['label']); ?></option>
									<?php } ?>
								</select>
							</div>

						</div>


						<div class="col-md-6">
							<?php $time =isset($loss_adjustment) ? $loss_adjustment->time : get_my_local_time("Y-m-d H:i:s") ;?>
							<?php echo render_date_input1('time','_time', format_to_date($time, false)) ?>
						</div>

						<?php $type =isset($loss_adjustment) ? $loss_adjustment->type : 'loss' ;?>
						<div class="col-md-6 ">
							<div class="form-group">
								<label for="vendor"><span class="text-danger">* </span><?php echo _l('type_label'); ?></label>
								<select name="type" class="select2 validate-hidden" id="type" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" required="true"> 
									<option value=""></option>
									<option value="loss" <?php if($type == 'loss'){ echo 'selected'; } ?>><?php echo _l('loss'); ?></option>
									<option value="adjustment" <?php if($type == 'adjustment'){ echo 'selected'; } ?>><?php echo _l('adjustment'); ?></option>
								</select>
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
									<th width="40%" align="left"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" data-title="<?php echo _l('item'); ?>"></i> <?php echo _l('invoice_table_item_heading'); ?></th>
									<th width="17%" align="right"><?php echo _l('lot_number'); ?></th>
									<th width="17%" align="right"><?php echo _l('expiry_date'); ?></th>
									<th width="13%" align="right"><?php echo _l('available_quantity'); ?></th>
									<th width="13%" align="right"><?php echo _l('stock_quantity'); ?></th>

									<th align="center"><span data-feather="settings" class="icon-16"></span></th>
									<th align="center"></th>
								</tr>
							</thead>
							<tbody>
								<?php echo html_entity_decode($loss_adjustment_row_template); ?>
							</tbody>
						</table>
					</div>
					
					<div id="removed-items"></div>
				</div>
			</div>

			<div class="card">
				<div class="container-fluid">
					<div class="">
						<?php $reason = (isset($loss_adjustment) ? $loss_adjustment->reason : ''); ?>
						<?php echo render_textarea1('reason','reason',$reason,array(),array(),'mtop15'); ?>

						<div class="btn-bottom-toolbar text-right mb20">
							<a href="<?php echo get_uri('warehouse/loss_adjustment'); ?>"class="btn btn-default text-right mright5"><span data-feather="x" class="icon-16"></span> <?php echo _l('close'); ?></a>

							<?php if(isset($loss_adjustment) && $loss_adjustment->status == 0){ ?>

								<?php if (has_permission('warehouse', '', 'create') || is_admin() || has_permission('warehouse', '', 'edit')) { ?>
									<button type="button" class="btn-tr save_detail btn btn-info text-white">
										<span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?>
									</button>
								<?php } ?>

							<?php }  ?>

							<?php 
							if(!isset($loss_adjustment)){ ?>
								<?php if (has_permission('warehouse', '', 'create') || is_admin() || has_permission('warehouse', '', 'edit')) { ?>
									<button type="button" class="btn-tr save_detail btn btn-info text-white">
										<span data-feather="check-circle" class="icon-16" ></span> <?php echo _l('submit'); ?>
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
<div id="add_modal_wrapper"></div>
<div id="delete_modal_wrapper"></div>

<?php require 'plugins/Warehouse/assets/js/loss_adjustments/add_loss_adjustment_js.php';?>


</body>
</html>
