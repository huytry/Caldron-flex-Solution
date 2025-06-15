<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-md-12">
			<?php
			$tab_view['active_tab'] = "inventory_inside";
			echo view("Warehouse\Views\\reports/tabs", $tab_view);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="page-title clearfix">
					<div class="title-button-group">
					</div>
				</div>
				<div class="row ml2 mr5">
					<div class=" col-md-4">
						<?php echo render_input1('profit_rate_search','exchange_profit_margin_differences_','',''); ?>
					</div>
					<div class=" col-md-4">
						<label><?php echo _l('commodity') ?></label>
						<?php echo  view('Warehouse\Views\item_include\item_select', ['select_name' => 'commodity_filter[]', 'id_name' => 'commodity_filter', 'multiple' => true, 'data_none_selected_text' => 'commodity']); ?>
					</div>
					<!-- update filter by warehouse -->
					<div class=" col-md-4">
						<div class="form-group">
							<label><?php echo _l('warehouse_name') ?></label>
							<select name="warehouse_filter[]" id="warehouse_filter" class="select2 validate-hidden" multiple="true" data-live-search="true" data-width="100%" data-none-selected-text="" data-actions-box="true">

								<?php foreach($warehouse_filter as $warehouse) { ?>
									<option value="<?php echo html_entity_decode($warehouse['warehouse_id']); ?>"><?php echo html_entity_decode($warehouse['warehouse_name']); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<?php 
					$table_data = array(
						_l('commodity_name'),
						_l('_profit_rate_p'),
						_l('purchase_price'),
						_l('rate'),
						_l('average_price_of_inventory'),
						_l('profit_rate_inventory'),
						_l('exchange_profit_margin_differences'),
					);
					render_datatable1($table_data,'table_inventory_inside',
						array('customizable-table')
					); ?>

				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/reports/inventory_analytic_js.php';?>
</body>
</html>