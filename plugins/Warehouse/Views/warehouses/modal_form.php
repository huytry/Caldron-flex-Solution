<?php echo form_open(get_uri("warehouse/create_warehouse/".$id), array("id" => "warehouse-form", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div id="color_id_t"></div>   
					<div class="form"> 
						<div class="col-md-12">
							<?php 
							$warehouse_code = isset($warehouse) ? $warehouse->warehouse_code : '';
							$warehouse_name = isset($warehouse) ? $warehouse->warehouse_name : '';
							$warehouse_address = isset($warehouse) ? $warehouse->warehouse_address : '';
							$order = isset($warehouse) ? $warehouse->order : 1;
							$note = isset($warehouse) ? $warehouse->note : '';
							$city = isset($warehouse) ? $warehouse->city : '';
							$state = isset($warehouse) ? $warehouse->state : '';
							$zip_code = isset($warehouse) ? $warehouse->zip_code : '';
							$country = isset($warehouse) ? $warehouse->country : '';

							$display = 'checked';
							if(isset($warehouse) && $warehouse->display == 0){
								$display = '';
							}
							?>
						</div>

						<div class="row">
							
							<div class="col-md-6">
								<?php echo render_input1('warehouse_code', 'warehouse_code', $warehouse_code, '', ['maxlength' => 100]); ?>
							</div>
							<div class="col-md-6">
								<?php echo render_input1('warehouse_name', 'warehouse_name', $warehouse_name); ?>
							</div>
						</div>

						<div class="row">

							<div class="col-md-12">
								<?php $mint_point_f="1";
								$min_p =[];
								$min_p['min']='0';
								$min_p['required']='true';
								$min_p['step']= 1;
								$min_p['maxlength']= 10;
								?>
								<?php echo render_input1('order','order',html_entity_decode($order),'number', $min_p) ?>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<?php echo render_textarea1('warehouse_address', 'warehouse_address', $warehouse_address, ['rows' =>5, ]); ?>
							</div>

							<div class="col-md-6">
								<?php echo render_input1('city', 'city', $city); ?>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6">
								<?php echo render_input1('state', 'state', $state); ?>
							</div>
							<div class="col-md-6">
								<?php echo render_input1('zip_code', 'zip_code', $zip_code); ?>
							</div>
						</div>
						<div class="row">

							<div class="col-md-12">
								<?php echo render_input1('country', 'clients_country', $country); ?>
								
							</div>
						</div>

						<div class="col-md-12">
							<?php echo render_textarea1('note', 'note', $note); ?>

						</div>

						<div class="col-md-12">
							<input data-can-view="" type="checkbox" class="form-check-input" name="display" id="display" <?php echo html_entity_decode($display) ?>>
							<label for="display" class="">
								<?php echo _l('display'); ?>               
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
		<button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16" ></span> <?php echo app_lang('save'); ?></button>

	</div>
</div>
<?php echo form_close(); ?>
<?php require('plugins/Warehouse/assets/js/warehouses/modal_form_js.php'); ?>

