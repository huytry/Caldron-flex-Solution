
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($commodity_item->title); ?></h4>
					<div class="title-button-group">
					</div>
				</div>
				<div class="card-body">
					<div class="row col-md-12">

						<h4 class="h4-color"><?php echo _l('general_infor'); ?></h4>
						<hr class="hr-color">



						<div class="col-md-7 panel-padding">
							<table class="table border table-striped table-margintop">
								<tbody>

									<tr class="project-overview">
										<td class="bold" width="30%"><?php echo _l('commodity_code'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->commodity_code) ; ?></td>
									</tr>
									<tr class="project-overview">
										<td class="bold"><?php echo _l('commodity_name'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->title) ; ?></td>
									</tr>
									
									<tr class="project-overview">
										<td class="bold"><?php echo _l('commodity_barcode'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->commodity_barcode) ; ?></td>
									</tr>
									<tr class="project-overview">
										<td class="bold"><?php echo _l('sku_code'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->sku_code) ; ?></td>
									</tr>
									<tr class="project-overview">
										<td class="bold"><?php echo _l('sku_name'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->sku_name) ; ?></td>
									</tr>
									<tr class="project-overview">
										<td class="bold"><?php echo _l('tax_1'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->tax) != '' && get_tax_rate($commodity_item->tax) != null ? get_tax_rate($commodity_item->tax)->title : '';  ?></td>
									</tr> 
									<tr class="project-overview">
										<td class="bold"><?php echo _l('tax_2'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->tax2) != '' && get_tax_rate($commodity_item->tax2) != null ? get_tax_rate($commodity_item->tax2)->title : '';  ?></td>
									</tr> 
								</tbody>
							</table>
							<table class="table border table-striped table-margintop" >
								<tbody>
									<tr class="project-overview">
										<td class="bold" width="30%"><?php echo _l('origin'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->origin) ; ?></td>
									</tr>
									<tr class="project-overview">
										<td class="bold"><?php echo _l('colors'); ?></td>
										<?php
										$color_value ='';
										if($commodity_item->color){
											$color = get_color_type($commodity_item->color);
											if($color){
												$color_value .= $color->color_code.'_'.$color->color_name;
											}
										}
										?>
										<td><?php echo html_entity_decode($color_value) ; ?></td>
									</tr>
									<tr class="project-overview">
										<td class="bold"><?php echo _l('styles'); ?></td>
										<td><?php  if($commodity_item->style_id != null){ echo get_style_name(html_entity_decode($commodity_item->style_id)) != null ? get_style_name(html_entity_decode($commodity_item->style_id))->style_name : '';}else{echo '';} ?></td>
									</tr>

									<tr class="project-overview">
										<td class="bold"><?php echo _l('rate'); ?></td>
										<td><?php echo to_currency((float)$commodity_item->rate) ; ?></td>
									</tr>

									<tr class="project-overview">
										<td class="bold"><?php echo _l('_profit_rate_p'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->profif_ratio) ; ?></td>
									</tr>
								</tbody>
							</table>
							<table class="table table-striped table-margintop">
								<tbody>
									<tr class="project-overview">
										<td class="bold" width="30%"><?php echo _l('model_id'); ?></td>
										<td><?php if($commodity_item->style_id != null){ echo get_model_name(html_entity_decode($commodity_item->model_id)) != null ? get_model_name(html_entity_decode($commodity_item->model_id))->body_name : ''; }else{echo '';}?></td>
									</tr>
									<tr class="project-overview">
										<td class="bold"><?php echo _l('size_id'); ?></td>

										<td><?php if($commodity_item->style_id != null){ echo get_size_name(html_entity_decode($commodity_item->size_id)) != null ? get_size_name(html_entity_decode($commodity_item->size_id))->size_name : ''; }else{ echo '';}?></td>
									</tr>

									<tr class="project-overview">
										<td class="bold"><?php echo _l('unit_id'); ?></td>
										<td><?php echo  html_entity_decode($commodity_item->unit_id != '' && get_unit_type($commodity_item->unit_id) != null ? get_unit_type($commodity_item->unit_id)->unit_name : ''); ?></td>
									</tr> 

									<tr class="project-overview">
										<td class="bold"><?php echo _l('purchase_price'); ?></td>
										<td><?php echo to_currency((float)$commodity_item->purchase_price) ; ?></td>
									</tr>

									<tr class="project-overview">
										<td class="bold"><?php echo _l('guarantee'); ?></td>
										<td><?php echo html_entity_decode($commodity_item->guarantee) ._l('month_label'); ?></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="col-md-5">
							<div class="container-fluid">

								<?php
								if ($model_info->files) {
									$files = @unserialize($model_info->files);
									if (count($files)) {
										?>
										<div class="col-md-12 mt15">
											<?php
											if ($files) {
												$total_files = count($files);
												echo view("includes/timeline_preview", array("files" => $files));
											}
											?>
										</div>
										<?php
									}
								}
								?>
							</div>
						</div>

						<div class=" row ">
							<div class="col-md-12">
								<h4 class="h4-color"><?php echo _l('description'); ?></h4>
								<hr class="hr-color">
								<h6><?php echo html_entity_decode($commodity_item->description) ; ?></h6>

							</div>

						</div>

						<div class=" row ">
							<div class="col-md-12">
								<h4 class="h4-color"><?php echo _l('long_description'); ?></h4>
								<hr class="hr-color">
								<h6><?php echo html_entity_decode($commodity_item->long_descriptions) ; ?></h6>

							</div>
						</div>


						<br>
					</div>

				</div>

			</div>

			<div class="card">
				<div class="card-header ">
					<ul class="nav nav-tabs pb15 justify-content-left border-bottom-0" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="out_of_stock-tab" data-bs-toggle="tab" data-bs-target="#out_of_stock" type="button" role="tab" aria-controls="out_of_stock" aria-selected="true"><?php echo _l('inventory_stock'); ?></button>
						</li>
						
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="expiry_date-tab" data-bs-toggle="tab" data-bs-target="#expiry_date" type="button" role="tab" aria-controls="expiry_date" aria-selected="false"><?php echo _l('expiry_date'); ?></button>
						</li>

						<li class="nav-item" role="presentation">
							<button class="nav-link" id="transaction_history-tab" data-bs-toggle="tab" data-bs-target="#transaction_history" type="button" role="tab" aria-controls="transaction_history" aria-selected="false"><?php echo _l('transaction_history'); ?></button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="child_items-tab" data-bs-toggle="tab" data-bs-target="#child_items" type="button" role="tab" aria-controls="child_items" aria-selected="false"><?php echo _l('sub_items'); ?></button>
						</li>


					</ul>
				</div>

				<div class="card-body">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="out_of_stock" role="tabpanel" aria-labelledby="out_of_stock-tab">
							<div class="modal-body clearfix">
								<?php render_datatable1(array(
									_l('id'),
									_l('commodity_name'),
									_l('expiry_date'),
									_l('lot_number'),
									_l('warehouse_name'),

									_l('inventory_number'),
									_l('unit_name'),
									_l('rate'),
									_l('purchase_price'),
									_l('tax'),
									_l('status_label'),

								),'table_inventory_stock'); ?>
							</div>
						</div>

						<div class="tab-pane fade" id="expiry_date" role="tabpanel" aria-labelledby="expiry_date-tab">
							<div class="row">
								<div class="modal-body clearfix">
									<?php render_datatable1(array(
										_l('commodity_name'),
										_l('expiry_date'),
										_l('lot_number'),
										_l('warehouse_name'),

										_l('inventory_number'),
										_l('unit_name'),
										_l('rate'),
										_l('purchase_price'),
										_l('tax'),
										_l('status_label'),

									),'table_view_commodity_detail',['proposal_sm' => 'proposal_sm']); ?>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="transaction_history" role="tabpanel" aria-labelledby="transaction_history-tab">
							<div class="row">
								<div class="modal-body clearfix">
									<?php render_datatable1(array(
										_l('id'),
										_l('form_code'),
										_l('commodity_code'),
										_l('warehouse_code'),
										_l('warehouse_name'),
										_l('day_vouchers'),
										_l('opening_stock'),
										_l('closing_stock'),
										_l('lot_number').'/'._l('quantity'),
										_l('expiry_date'),
										app_lang('wh_serial_number'),
										_l('note'),
										_l('status_label'),
									),'table_warehouse_history'); ?>

								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="child_items" role="tabpanel" aria-labelledby="child_items-tab">
							<div class="row">
								<div class="modal-body clearfix">
									<?php 
									$table_data = array(
										'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="table_commodity_list" class="form-check-input"><label></label></div>',
										_l('_images'),
										_l('commodity_code'),
										_l('commodity_name'),
										_l('sku_code'),
										_l('group_name'),
										_l('warehouse_name'),
										_l('inventory_number'),
										_l('unit_name'),
										_l('rate'),
										_l('purchase_price'),
										_l('tax_1'),
										_l('tax_2'),
										_l('status'),                         
										_l('minimum_stock'),                         
										_l('maximum_stock'),
										_l('final_price'),                         
										"<i data-feather='menu' class='icon-16'></i>",                       
									);
									render_datatable1($table_data,'table_commodity_list',
										array('customizable-table'),
										array(
											'proposal_sm' => 'proposal_sm',
											'id'=>'table-table_commodity_list',
											'data-last-order-identifier'=>'table_commodity_list',
										)); ?>
									</div>
								</div>
							</div>


						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
	<?php echo form_hidden('commodity_id'); ?>
	<?php echo form_hidden('parent_item_filter', 'false'); ?>

	<?php require 'plugins/Warehouse/assets/js/items/commodity_detail_js.php';?>

</body>
</html>

