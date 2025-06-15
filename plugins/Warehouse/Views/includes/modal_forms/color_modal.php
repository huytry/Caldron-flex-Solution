<?php echo form_open(get_uri("warehouse/colors_setting/".$id), array("id" => "color-form", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div id="color_id_t"></div>   
					<div class="form"> 
						<div class="col-md-12">
							<?php 
								$color_code = isset($color) ? $color->color_code : '';
								$color_name = isset($color) ? $color->color_name : '';
								$color_hex = isset($color) ? $color->color_hex : '#000000';
								$order = isset($color) ? $color->order : 1;
								$note = isset($color) ? $color->note : '';
								$display = 'checked';
								if(isset($color) && $color->display == 0){
									$display = '';
								}
							 ?>
							<?php echo render_input1('color_code', 'color_code', $color_code); ?>
						</div>

						<div class="col-md-12">
							<?php echo render_input1('color_name', 'color_name', $color_name); ?>
						</div>

						<div class="col-md-12">
							<?php echo render_color_picker1('color_hex',  app_lang('color_hex'), $color_hex); ?>
						</div>
						<div class="col-md-12">
							<?php $mint_point_f="1";
							$min_p =[];
							$min_p['min']='0';
							$min_p['required']='true';

							?>
							<?php echo render_input1('order','order', $order,'number', $min_p) ?>
						</div>

						<div class="col-md-12">
							<?php echo render_textarea1('note', 'note', $note); ?>

						</div>

						<div class="col-md-12">
							<input data-can-view="" type="checkbox" class="form-check-input" name="display" <?php echo html_entity_decode($display) ?>>
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
