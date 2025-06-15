<?php echo form_open(get_uri("warehouse/commodity_list_add_edit"), array("id" => "item-form", "class" => "general-form", "role" => "form")); ?>
<div id="items-dropzone" class="post-dropzone">
	<div class="modal-body clearfix">
		<div class="container-fluid">
			<input type="hidden" name="id" value="<?php echo html_entity_decode($model_info->id); ?>" />

			<ul class="nav nav-tabs pb15" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="general_infor-tab" data-bs-toggle="tab" data-bs-target="#general_infor" type="button" role="tab" aria-controls="general_infor" aria-selected="true"><?php echo _l('general_infor'); ?></button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="properties-tab" data-bs-toggle="tab" data-bs-target="#properties" type="button" role="tab" aria-controls="properties" aria-selected="false"><?php echo _l('properties'); ?></button>
				</li>

				<li class="nav-item" role="presentation">
					<button class="nav-link" id="variation1-tab" data-bs-toggle="tab" data-bs-target="#variation1" type="button" role="tab" aria-controls="variation1" aria-selected="false"><?php echo _l('variation'); ?></button>
				</li>
			</ul>
			<?php 
			$commodity_code = isset($item) ? $item->commodity_code : '';
			$title = isset($item) ? $item->title : '';
			$description = isset($item) ? $item->description : '';
			$commodity_barcode = isset($item) ? $item->commodity_barcode : $get_commodity_barcode;
			$sku_code = isset($item) ? $item->sku_code : '';
			$sku_name = isset($item) ? $item->sku_name : '';
			$commodity_type = isset($item) ? $item->commodity_type : '';
			$unit_id = isset($item) ? $item->unit_id : '';
			$category_id = isset($item) ? $item->category_id : '';
			$sub_group = isset($item) ? $item->sub_group : '';
			$profif_ratio = isset($item) ? $item->profif_ratio : get_setting('warehouse_selling_price_rule_profif_ratio');
			$tax = isset($item) ? $item->tax : '';
			$tax2 = isset($item) ? $item->tax2 : '';
			$purchase_price = isset($item) ? $item->purchase_price : '';
			$rate = isset($item) ? $item->rate : '';
			$origin = isset($item) ? $item->origin : '';
			$style_id = isset($item) ? $item->style_id : '';
			$model_id = isset($item) ? $item->model_id : '';
			$size_id = isset($item) ? $item->size_id : '';
			$color = isset($item) ? $item->color : '';
			$guarantee = isset($item) ? $item->guarantee : '';

			$without_checking_warehouse_check = '';
			$can_be_sold_check = ' checked';
			$can_be_inventory_check = ' checked';
			$can_be_purchased_check = ' checked';
			$can_be_manufacturing_check = ' checked';
			if(isset($item) && (int)$item->without_checking_warehouse == 1){
				$without_checking_warehouse_check = ' checked';
			}

			if(isset($item)){
				if($item->can_be_sold == 'can_be_sold'){
					$can_be_sold_check = ' checked';
				}else{
					$can_be_sold_check = '';
				}
			}

			if(isset($item)){
				if($item->can_be_inventory == 'can_be_inventory'){
					$can_be_inventory_check = ' checked';
				}else{
					$can_be_inventory_check = '';
				}
			}

			if(isset($item) ){
				if($item->can_be_purchased == 'can_be_purchased'){
					$can_be_purchased_check = ' checked';
				}else{
					$can_be_purchased_check = '';
				}
			}

			if(isset($item)){
				if($item->can_be_manufacturing == 'can_be_manufacturing'){
					$can_be_manufacturing_check = ' checked';
				}else{
					$can_be_manufacturing_check = '';
				}
			}

			$long_descriptions = isset($item) ? $item->long_descriptions : '';


			 ?>

			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="general_infor" role="tabpanel" aria-labelledby="general_infor-tab">
					<?php if(!$parent_item_hide){ ?>
						<div class="row parent_item_hide">
							<div class=" col-md-12">
								<div id="parent_item_html">
									<?php echo html_entity_decode($item_html); ?>
								</div>
							</div>
						</div>
					<?php } ?>

					<div class="row">
						<div class="col-md-6">
							<?php echo render_input1('commodity_code', 'commodity_code', $commodity_code, '', [], [], '', '', true); ?>
						</div>
						<div class="col-md-6">
							<?php echo render_input1('title', 'commodity_name', $title); ?>
						</div>

					</div>

					<div class="row">
						<div class="col-md-6">
							<?php echo render_input1('commodity_barcode', 'commodity_barcode', $commodity_barcode,'text'); ?>
						</div>
						<div class="col-md-3">
							<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle skucode-tooltip"  data-toggle="tooltip" title="" data-original-title="<?php echo _l('commodity_sku_code_tooltip'); ?>"></i></a>
							<?php echo render_input1('sku_code', 'sku_code', $sku_code,''); ?>
						</div>
						<div class="col-md-3">
							<?php echo render_input1('sku_name', 'sku_name', $sku_name); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<?php echo render_textarea1('description', 'description', $description); ?>
						</div>
					</div>

					<!--  add warehouse for item-->
					<div class="row d-none">
						<div class="col-md-12">
							<?php echo render_select1('warehouse_id',$warehouses,array('warehouse_id',array('warehouse_code','warehouse_name')),'warehouse_name'); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<?php echo render_select1('commodity_type',$commodity_types,array('commodity_type_id','commondity_name'),'commodity_type', $commodity_type); ?>

						</div>

						<div class="col-md-6">
							<?php 
							$select_attrs = ['data-rule-required' => true, "data-msg-required" => app_lang('field_required')];
							 ?>
							<?php echo render_select1('unit_id',$units,array('unit_type_id','unit_name'),'units', $unit_id, [], [], '', '', false, true); ?>
						</div>
					</div>


					<div class="row">

						<div class="col-md-12">
							<?php echo render_select1('category_id',$commodity_groups,array('id','title'),'commodity_group', $category_id); ?>
						</div>
						<div class="col-md-6 d-none">
							<?php echo render_select1('sub_group',$sub_groups,array('id','sub_group_name'),'sub_group', $sub_group); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<?php 
							$attr = array();

							?>
							<?php echo render_input1('profif_ratio','_profit_rate_p', $profif_ratio,'number',$attr); ?>
						</div>
							
						<div class="col-md-3">
							<?php echo render_select1('tax',$taxes,array('id','title'),'tax_1', $tax); ?>
						</div>
						<div class="col-md-3">
							<?php echo render_select1('tax2',$taxes,array('id','title'),'tax_2', $tax2); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">

							<?php 
							$attr = array();
							echo render_input1('purchase_price', 'purchase_price', $purchase_price, 'number', $attr); ?>

						</div>
						<div class="col-md-6">

							<?php $premium_rates = isset($premium_rates) ? $premium_rates : '' ?>
							<?php 
							$attr = array();
							echo render_input1('rate', 'rate', $rate, 'number', $attr, [], '', '', true); ?>


						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 row pr0">
								<?php
								echo view("includes/file_list", array("files" => $model_info->files, "image_only" => true));
								?>
							</div>
						</div>
					</div>

					<?php echo view("includes/dropzone_preview"); ?>

					<button class="btn btn-default upload-file-button float-start btn-sm round me-auto color-7988a2" type="button" ><i data-feather="camera" class="icon-16"></i> <?php echo app_lang("upload_image"); ?></button>

				</div>
				<div class="tab-pane fade" id="properties" role="tabpanel" aria-labelledby="properties-tab">
					<div class="row">
						<div class="col-md-6">
							<?php echo render_input1('origin', 'origin', $origin); ?>
						</div>
						<div class="col-md-6">
							<?php echo render_select1('style_id',$styles,array('style_type_id','style_name'),'styles', $style_id); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<?php echo render_select1('model_id',$models,array('body_type_id','body_name'),'model_id', $model_id); ?>
						</div>
						<div class="col-md-6">
							<?php echo render_select1('size_id',$sizes,array('size_type_id','size_name'),'sizes', $size_id); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<?php echo render_select1('color',$colors,array('color_id',array('color_hex','color_name')),'_color', $color); ?>
						</div>
						<div class="col-md-6">
							<?php $attr = array();
							$attr = ['min' => 0, 'step' => 1]; ?>

							<?php echo render_input1('guarantee','guarantee_month', $guarantee, 'number', $attr); ?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="checkbox checkbox-primary">
									<input class="form-check-input" type="checkbox" id="without_checking_warehouse" name="without_checking_warehouse" value="without_checking_warehouse" <?php echo html_entity_decode($without_checking_warehouse_check) ?>>

									<label for="without_checking_warehouse"><?php echo _l('without_checking_warehouse'); ?><small ><?php echo _l('without_checking_warehouse_tooltip') ?> </small>
									</label>
								</div>
							</div>
						</div>

						<div class="col-md-3 col-sm-6">
							<div class="form-group">
								<div class="checkbox checkbox-primary">
									<input class="form-check-input" type="checkbox" id="can_be_sold" name="can_be_sold" value="can_be_sold" <?php echo html_entity_decode($can_be_sold_check) ?>>
									<label for="can_be_sold"><?php echo _l('can_be_sold'); ?></label>
								</div>
								<div class="checkbox checkbox-primary <?php if(!get_status_modules_wh('purchase')){echo ' hide';} ?>">
									<input class="form-check-input" type="checkbox" id="can_be_purchased" name="can_be_purchased" value="can_be_purchased" <?php echo html_entity_decode($can_be_purchased_check) ?>>
									<label for="can_be_purchased"><?php echo _l('can_be_purchased'); ?></label>
								</div>

							</div>
						</div>  
						<div class="col-md-3 col-sm-6">
							<div class="form-group">
								<div class="checkbox checkbox-primary">
									<input class="form-check-input" type="checkbox" id="can_be_inventory" name="can_be_inventory" value="can_be_inventory" <?php echo html_entity_decode($can_be_inventory_check) ?>>
									<label for="can_be_inventory"><?php echo _l('can_be_inventory'); ?></label>
								</div>
								<div class="checkbox checkbox-primary <?php if(!get_status_modules_wh('manufacturing')){echo ' hide';} ?>">
									<input class="form-check-input" type="checkbox" id="can_be_manufacturing" name="can_be_manufacturing" value="can_be_manufacturing" <?php echo html_entity_decode($can_be_manufacturing_check) ?>>
									<label for="can_be_manufacturing"><?php echo _l('can_be_manufacturing'); ?></label>
								</div>
							</div>
						</div>  
					</div>  

					<div class="row">
						<div class="col-md-12 ">
							<p class="bold"><?php echo _l('long_description'); ?></p>
							<?php echo render_textarea1('long_descriptions','', $long_descriptions,array(),array(),'','tinymce'); ?>

						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="variation1" role="tabpanel" aria-labelledby="variation1-tab">
					<div class="list_approve">
						<?php echo html_entity_decode($variation_html); ?>
						
					</div>
				</div>

			</div>




		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
		<button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
	</div>
</div>
<?php echo form_close(); ?>
<?php require('plugins/Warehouse/assets/js/items/item_modal_js.php'); ?>
