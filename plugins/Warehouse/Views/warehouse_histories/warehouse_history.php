
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					
				</div>
				<div class="row ml2 mr5">
					<div class=" col-md-3">
						<div class="form-group">
							<select name="warehouse_filter[]" id="warehouse_filter" class="select2 validate-hidden" multiple="true" data-live-search="true" data-width="100%" placeholder="<?php echo app_lang('filters_by_warehouse'); ?>">

								<?php foreach($warehouse_filter as $warehouse) { ?>
									<option value="<?php echo html_entity_decode($warehouse['warehouse_id']); ?>"><?php echo html_entity_decode($warehouse['warehouse_name']); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class=" col-md-3">
						<?php echo  view('Warehouse\Views\item_include\item_select', ['select_name' => 'commodity_filter[]', 'id_name' => 'commodity_filter', 'multiple' => true, 'data_none_selected_text' => 'filters_by_commodity']); ?>
					</div>
					
					<div class=" col-md-2">
						<div class="form-group">
							<select name="status[]" id="status" class="select2 validate-hidden" data-live-search="true" multiple="true" data-width="100%" placeholder="<?php echo app_lang('filters_by_status'); ?>">

								<option value="1"><?php echo app_lang('stock_import'); ?></option>
								<option value="2"><?php echo app_lang('stock_export'); ?></option>
								<option value="3"><?php echo app_lang('loss_adjustment'); ?></option>
								<option value="4"><?php echo app_lang('internal_delivery_note'); ?></option>
							</select>
						</div>
					</div>
					<div  class="col-md-2 leads-filter-column">
						<div class="form-group" app-field-wrapper="validity_start_date">
							<div class="input-group date">
								<input type="text" id="validity_start_date" name="validity_start_date" class="form-control datepicker" value="" autocomplete="off" placeholder="<?php echo app_lang('start_date') ?>">
								<div class="input-group-addon">
									<i class="fa fa-calendar calendar-icon"></i>
								</div>
							</div>
						</div>
					</div>
					<div  class="col-md-2 leads-filter-column">
						<div class="form-group" app-field-wrapper="validity_end_date">
							<div class="input-group date">
								<input type="text" id="validity_end_date" name="validity_end_date" class="form-control datepicker" value="" autocomplete="off" placeholder="<?php echo app_lang('end_date') ?>">
								<div class="input-group-addon">
									<i class="fa fa-calendar calendar-icon"></i>
								</div>
							</div>
						</div>
					</div> 

				</div>
				<div class="table-responsive">

					<?php render_datatable1(array(
						app_lang('id'),
						app_lang('form_code'),
						app_lang('commodity_code'),
						app_lang('warehouse_code'),
						app_lang('warehouse_name'),
						app_lang('day_vouchers'),
						app_lang('opening_stock'),
						app_lang('closing_stock'),
						app_lang('lot_number').'/'.app_lang('quantity_sold'),
						app_lang('expiry_date'),
						app_lang('wh_serial_number'),
						app_lang('note'),
						app_lang('status_label'),
					),'table_warehouse_history'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/warehouse_histories/warehouse_history_js.php';?>

</body>
</html>