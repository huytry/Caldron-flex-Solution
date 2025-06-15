<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card pr15 pl15">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">
					</div>
				</div>
				<div class="row row-margin-bottom">
					<div class="col-md-12 ">
						<?php if (has_permission('warehouse', '', 'create') || $login_user->is_admin || has_permission('warehouse', '', 'edit') ) { ?>
							<a href="#" id="dowload_items"  class="btn btn-warning pull-left  mr-4 button-margin-r-b hide text-white mb-1"><?php echo _l('dowload_items'); ?></a>

						<?php } ?>
					</div>
				</div>
				<ul>
					<li class="text-danger">1. <?php echo _l('Create_file_import_Serial_number_Check_the_item_to_import_Serial_number_then_click_Export_the_seleted_item'); ?></li>
					<li class="text-danger">2. <?php echo _l('It_is_necessary_to_use_the_files_generated_from_the_system_to_enter_data_into_the_system'); ?></li>
					<li class="text-danger">3. <?php echo _l('Do_not_add_any_columns_or_rows_to_the_file_downloaded_from_the_system_Only_the_value_of_the_Serial_Number_column'); ?></li>
				</ul>

				<div class="row">
					<div class="col-md-4">
						<?php echo form_open_multipart(get_uri("warehouse/import_file_xlsx_opening_stock"), array("id" => "import_form", "class" => "general-form", "role" => "form")); ?>
						<?php echo form_hidden('leads_import','true'); ?>
						<?php echo render_input1('file_csv','choose_excel_file','','file'); ?> 

						<div class="form-group">
							<a href="<?php echo get_uri('warehouse/commodity_list'); ?>" class="btn btn-default pull-left display-block mr-5 button-margin-r-b" title="<?php echo _l('close') ?> "><?php echo _l('close'); ?></a>
							<button id="uploadfile" type="button" class="btn btn-primary import text-white" onclick="return uploadfilecsv(this);" ><?php echo _l('wh_import'); ?></button>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="col-md-8">
						<div class="form-group" id="file_upload_response">

						</div>

					</div>
				</div>
			</div>

			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('items'); ?></h4>
					<div class="title-button-group">
					</div>
				</div>
				<div class="row ml2 mr5">
					<?php 
					$serial_number_type = [];
					$serial_number_type[] = [
						'name' => 1,
						'label' => _l('wh_add_serial_numbers_for_items'),
					];
					$serial_number_type[] = [
						'name' => 2,
						'label' => _l('wh_update_serial_numbers_for_items'),
					];

					?>
					<div class="col-md-4">
						<?php echo render_select1('show_items_filter[]', $serial_number_type, array('name', array('label')), '', [2], ['multiple' => true, 'data-width' => '100%', 'class' => 'selectpicker'], array(), '', '', false); ?>
					</div>
					<div class=" col-md-4">
						<?php echo  view('Warehouse\Views\item_include\item_select', ['select_name' => 'commodity_filter[]', 'id_name' => 'commodity_filter', 'multiple' => true, 'data_none_selected_text' => 'commodity']); ?>
					</div>
					<div class=" col-md-4">
						<div class="form-group">
							<select name="warehouse_filter[]" id="warehouse_filter" class="select2 validate-hidden" multiple="true" data-live-search="true" data-width="100%" placeholder="<?php echo _l('warehouse_filter'); ?>">

								<?php foreach($warehouse_filter as $warehouse) { ?>
									<option value="<?php echo html_entity_decode($warehouse['warehouse_id']); ?>"><?php echo html_entity_decode($warehouse['warehouse_name']); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="row">

					<!-- update multiple item -->

					<a href="#"  onclick="export_item(); return false;" data-toggle="modal" data-table=".table-table_commodity_list" data-target="#leads_export_item" class=" hide bulk-actions-btn table-btn"><?php echo _l('export_item'); ?></a>

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
	<?php echo form_hidden('warehouse_id'); ?>
	<?php echo form_hidden('commodity_id'); ?>
	<?php echo form_hidden('filter_all_simple_variation_value'); ?>

	<div id="modal_wrapper"></div>
	<!-- box loading -->
	<div id="box-loading">
	</div>

	<?php require 'plugins/Warehouse/assets/js/serial_numbers/manage_commodity_js.php';?>
</body>
</html>