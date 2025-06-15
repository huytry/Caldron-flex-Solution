<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-md-12">
			<?php
			$tab_view['active_tab'] = "inventory_valuation_report";
			echo view("Warehouse\Views\\reports/tabs", $tab_view);
			?>
		</div>
	</div>
	<div class="row ">
		<div class="col-md-12">
			<div class="card">
				<div class="page-title clearfix">
					<div class="title-button-group">
					</div>
				</div>

				<?php echo form_open_multipart(get_uri("warehouse/stock_summary_report_pdf"), array('id'=>'print_report')); ?>

				<div class="row ml2 mr5">

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

					<div class="col-md-3">
						<?php echo render_date_input1('from_date','from_date',get_my_local_time("Y-m-d")); ?>
					</div>
					<div class="col-md-3">
						<?php echo render_date_input1('to_date','to_date',get_my_local_time("Y-m-d")); ?>
					</div>

					<div class="col-md-2" >
						<a href="#" onclick="get_data_inventory_valuation_report(); return false;" class="btn btn-info display-block button-pdf-margin-top text-white mt25" ><i data-feather="tool" class="icon-16"></i> <?php echo _l('_filter'); ?></a>

						<span class="dropdown inline-block mt10 d-none">
							<button class="btn btn-info text-white dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true">
								<i data-feather="tool" class="icon-16"></i> <?php echo app_lang('actions'); ?>
							</button>
							<ul class="dropdown-menu" role="menu">

								<li role="presentation"><a href="#" target="_blank" onclick="stock_submit(this); return false;" class="dropdown-item"><?php echo _l('download_pdf'); ?></a> </li>

							</ul>
						</span>
					</div>


				</div>
				<?php echo form_close(); ?>

				<div id="stock_s_report">
					<div class="table-responsive ">
						<div class="dataTables_wrapper form-inline dt-bootstrap pt15 pl15 pr15 no-footer app_dt_empty">
							<table class="table table-bordered ">
								<tbody>
									<tr>
										<th colspan="1"><?php echo _l('_order') ?></th>
										<th colspan="1"><?php echo _l('commodity_code') ?></th>
										<th colspan="1"><?php echo _l('commodity_name') ?></th>
										<th colspan="1"><?php echo _l('unit_name') ?></th>
										<th colspan="1" class="text-center"><?php echo _l('inventory_number') ?></th>
										<th colspan="1" class="text-center"><?php echo _l('rate') ?></th>
										<th colspan="1" class="text-center"><?php echo _l('purchase_price') ?></th>
										<th colspan="1" class="text-center"><?php echo _l('amount_sold') ?></th>
										<th colspan="1" class="text-center"><?php echo _l('amount_purchased') ?></th>
										<th colspan="1" class="text-center"><?php echo _l('expected_profit') ?></th>
									</tr>

									<tr>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
										<td>.....</td>
									</tr>
									<tr>
										<th colspan="4" class="text-right"><?php echo _l('total') ?> : </th>
										<th colspan="1"></th>
										<th colspan="1"></th>
										<th colspan="1"></th>
										<th colspan="1"></th>
										<th colspan="1"></th>
										<th colspan="1"></th>

									</tr>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/reports/inventory_valuation_report_js.php';?>
</body>
</html>