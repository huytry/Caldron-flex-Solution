
<div id="page-content" class="page-wrapper clearfix">
	<div class="card clearfix">
		<?php echo form_hidden('proposal_id',$proposal_id); ?>

		<div class="page-title clearfix">
			<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo ($title); ?></h4>
			<div class="title-button-group">
				<?php echo modal_anchor(get_uri("warehouse/item_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>

				<a href="<?php echo get_uri('warehouse/import_xlsx_commodity'); ?>" class="btn btn-success pull-left display-block  mr-4 button-margin-r-b" title="<?php echo _l('import_items') ?> "><span data-feather="upload" class="icon-16"></span>
					<?php echo _l('import_items'); ?>
				</a>

				<a href="#" id="dowload_items"  class="btn btn-warning pull-left text-white mr-4 button-margin-r-b hide"><?php echo _l('dowload_items'); ?></a>

				<a href="<?php echo get_uri('warehouse/import_opening_stock'); ?>" class="btn btn-default pull-left display-block  mr-4 button-margin-r-b" title="<?php echo _l('import_opening_stock') ?> "><span data-feather="upload" class="icon-16"></span>
					<?php echo _l('import_opening_stock'); ?>
				</a>
				<a href="<?php echo get_uri('warehouse/import_serial_number'); ?>" class="btn btn-default pull-left display-block  mr-4 button-margin-r-b" title="<?php echo _l('import_serial_number') ?> ">
					<?php echo _l('wh_serial_numbers'); ?>
				</a>
			</div>
		</div>

		<div class="row ml2 mr5">
			<div class=" col-md-3">
				<div class="form-group">
					<select name="warehouse_filter[]" id="warehouse_filter" class="select2 validate-hidden" multiple="true" data-live-search="true" data-width="100%" placeholder="<?php echo _l('warehouse_filter'); ?>">

						<?php foreach($warehouse_filter as $warehouse) { ?>
							<option value="<?php echo html_entity_decode($warehouse['warehouse_id']); ?>"><?php echo html_entity_decode($warehouse['warehouse_name']); ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class=" col-md-3">
				<?php echo  view('Warehouse\Views\item_include\item_select', ['select_name' => 'commodity_filter[]', 'id_name' => 'commodity_filter', 'multiple' => true, 'data_none_selected_text' => 'commodity']); ?>
			</div>
			<div class=" col-md-2 d-none">
				<div class="form-group">
					<select name="item_filter[]" id="item_filter" class="select2 validate-hidden" multiple="true"  data-live-search="true" data-width="100%" placeholder="<?php echo _l('tags'); ?>">

						<?php foreach($item_tags as $item_f) { ?>
							<option value="<?php echo html_entity_decode($item_f['rel_id']); ?>"><?php echo html_entity_decode($item_f['name']); ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class=" col-md-3">
				<div class="form-group">
					<select name="alert_filter" id="alert_filter" class="select2 validate-hidden"  data-live-search="true" data-width="100%" placeholder="<?php echo _l('alert_filter'); ?>">

						<option value=""></option>
						<option value="3"><?php echo _l('minimum_stock') ; ?></option>
						<option value="4"><?php echo _l('maximum_stock') ; ?></option>
						<option value="1"><?php echo _l('out_of_stock') ; ?></option>
						<option value="2"><?php echo _l('1_month_before_expiration_date') ; ?></option>

					</select>
				</div>
			</div>
			<?php 
			$can_be_type1 = [];
			$can_be_type = [];
			$can_be_type[] = [
				'id' => 'can_be_sold',
				'label' => _l('can_be_sold'),
			];
			$can_be_type1[] = [
				'id' => 'can_be_purchased',
				'label' => _l('can_be_purchased'),
			];
			$can_be_type1[] = [
				'id' => 'can_be_manufacturing',
				'label' => _l('can_be_manufacturing'),
			];
			$can_be_type[] = [
				'id' => 'can_be_inventory',
				'label' => _l('can_be_inventory'),
			];


			?>
			<div class="col-md-3">
				<?php echo render_select1('can_be_value_filter[]', $can_be_type, array('id', array('label')), '', ['can_be_inventory'], ['multiple' => true, 'data-width' => '100%', 'class' => 'selectpicker'], array(), '', '', false); ?>
			</div>

		</div>

			<!-- view/manage -->            
			<div class="modal bulk_actions" id="table_commodity_list_bulk_actions" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="checkbox checkbox-danger">
								<div class="row">

									<?php if(has_permission('warehouse','','delete') ){ ?>
										<div class="col-md-4">
											<div class="form-group">
												<input type="checkbox" class="form-check-input" name="mass_delete" id="mass_delete">
												<label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
											</div>
										</div>
									<?php } ?>


								</div>

								<!-- TODO -->
								<div class="row d-none">
									<?php if(has_permission('warehouse','','create') ){ ?>
										<div class="col-md-4">
											<div class="form-group">
												<input type="checkbox" class="form-check-input" name="clone_items" id="clone_items">
												<label for="clone_items"><?php echo _l('clone_this_items'); ?></label>
											</div>
										</div>
									<?php } ?>
								</div>

								<?php if(has_permission('warehouse','','edit') ){ ?>
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">

												<input type="checkbox" class="form-check-input" name="change_item_selling_price" id="change_item_selling_price" >
												<label for="change_item_selling_price"><?php echo _l('change_item_selling_price'); ?></label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">

												<div class="input-group" id="discount-total">
													<input type="number" class="form-control text-right" min="0" max="100" name="selling_price" value="">
													<div class="input-group-addon">
														<div class="dropdown">
															<span class="discount-type-selected">
																%
															</span>
														</div>
													</div>
												</div>
											</div>

										</div>
									</div>

									<div class="row">
										<div class="col-md-5">
											<div class="form-group">

												<input type="checkbox" class="form-check-input" name="change_item_purchase_price" id="change_item_purchase_price">
												<label for="change_item_purchase_price"><?php echo _l('change_item_purchase_price'); ?></label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">

												<div class="input-group" id="discount-total">
													<input type="number" class="form-control text-right" min="0" max="100" name="b_purchase_price" value="">
													<div class="input-group-addon">
														<div class="dropdown">
															<span class="discount-type-selected">
																%
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>

							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>

							<?php if(has_permission('warehouse','','delete') ){ ?>
								<a href="#" class="btn btn-primary text-white" onclick="warehouse_delete_bulk_action(this); return false;"><span data-feather="check-circle" class="icon-16"></span><?php echo _l('confirm'); ?></a>

							<?php } ?>
						</div>
					</div>

				</div>

			</div>

			<!-- update multiple item -->

			<div class="modal export_item" id="table_commodity_list_export_item" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo _l('export_item'); ?></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<?php if(has_permission('warehouse','','create') ){ ?>
								<div class="checkbox checkbox-danger">
									<input type="checkbox" name="mass_delete" id="mass_delete">
									<label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
								</div>

							<?php } ?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>

							<?php if(has_permission('warehouse','','create') ){ ?>
								<a href="#" class="btn btn-info" onclick="warehouse_delete_bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
							<?php } ?>
						</div>
					</div>

				</div>

			</div>

			<!-- print barcode -->      
			<?php echo form_open_multipart(get_uri('warehouse/download_barcode'), array('id'=>'item_print_barcode')); ?>      
			<div class="modal bulk_actions" id="table_commodity_list_print_barcode" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title"><?php echo _l('print_barcode'); ?></h4>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<?php if(has_permission('warehouse','','create') ){ ?>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<div class="radio radio-primary radio-inline" >
												<input onchange="print_barcode_option(this); return false" type="radio" id="y_opt_1_" name="select_item" value="0" checked class="form-check-input">
												<label for="y_opt_1_"><?php echo _l('select_all'); ?></label>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<div class="radio radio-primary radio-inline" >
												<input onchange="print_barcode_option(this); return false" type="radio" id="y_opt_2_" name="select_item" value="1" class="form-check-input">
												<label for="y_opt_2_"><?php echo _l('select_item'); ?></label>
											</div>
										</div>
									</div>
								</div>     
								<div class="row display-select-item hide ">
									<div class=" col-md-12">
										<?php echo  view('Warehouse\Views\item_include\item_select', ['select_name' => 'item_select_print_barcode[]', 'id_name' => 'item_select_print_barcode', 'multiple' => true, 'data_none_selected_text' => 'select_item_print_barcode']); ?>
									</div>
								</div>

							<?php } ?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-bs-dismiss="modal"><i data-feather="x" class="icon-16"></i> <?php echo app_lang('close'); ?></button>
							<?php if(has_permission('warehouse','','create') ){ ?>
								<button type="submit" class="btn btn-primary text-white print-barcode-btn" ><span data-feather="check-circle" class="icon-16"></span> <?php echo _l('confirm'); ?></button>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>


			<a href="#"  onclick="staff_bulk_actions(); return false;" data-toggle="modal" data-table=".table-table_commodity_list" data-target="#leads_bulk_actions" class=" hide bulk-actions-btn table-btn"><?php echo _l('bulk_actions'); ?></a>

			<a href="#"  onclick="staff_export_item(); return false;" data-toggle="modal" data-table=".table-table_commodity_list" data-target="#leads_export_item" class=" hide bulk-actions-btn table-btn"><?php echo _l('export_item'); ?></a>

			<a href="#"  onclick="print_barcode_bulk_actions(); return false;" data-toggle="modal" data-table=".table-table_commodity_list" data-target="#print_barcode_item" class=" hide print_barcode-bulk-actions-btn table-btn"><?php echo _l('print_barcode'); ?></a>

			<div class="row ml2">
				<div class="form-group pull-right">
					<div class="checkbox checkbox-primary">
						<input  type="checkbox" id="filter_all_simple_variation" name="filter_all_simple_variation" class="form-check-input">
						<label for="filter_all_simple_variation"><?php echo _l('search_all_simple_variation_product'); ?> <i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('search_all_simple_variation_tooltip'); ?>"></i>
						</label>
					</div>
				</div>
			</div>

			<div class="table-responsive">
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
		<?php echo form_hidden('warehouse_id'); ?>
		<?php echo form_hidden('commodity_id'); ?>
		<?php echo form_hidden('expiry_date'); ?>
		<?php echo form_hidden('parent_item_filter', 'true'); ?>
		<?php echo form_hidden('filter_all_simple_variation_value'); ?>

		<?php require('plugins/Warehouse/assets/js/commodity_list_js.php'); ?>


