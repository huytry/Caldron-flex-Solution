<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-md-12">
			<?php
			$tab_view['active_tab'] = "warranty_period_report";
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

				<?php echo form_open_multipart(get_uri("warehouse/download_warranty_period_pdf"), array('id'=>'print_report')); ?>

				<div class="row ml2 mr5">
					<div class=" col-md-3">
						<label><?php echo _l('commodity') ?></label>
						<?php echo  view('Warehouse\Views\item_include\item_select', ['select_name' => 'commodity_filter[]', 'id_name' => 'commodity_filter', 'multiple' => true, 'data_none_selected_text' => 'commodity']); ?>
					</div>

					<div class=" col-md-3">
						<?php echo render_select1('customer_name_filter[]', $clients, array('id', array('company_name')), 'customer_name', '', ['multiple' => true, 'data-width' => '100%', 'class' => '', 'data-live-search' => "true"], array(), '', '', false); ?>
					</div>

					<div class="col-md-2">
						<?php echo render_date_input1('to_date_filter', 'Warranty_Expiry_date', $period_to_date); ?>
					</div>

					<?php 
					$packing_list_status = [];
					$packing_list_status[] = [
						'id' => 1,
						'label' => _l('within_the_warranty_period'),
					];
					$packing_list_status[] = [
						'id' => 2,
						'label' => _l('expiry_of_warranty'),
					];

					?>
					<div class="col-md-3">
						<?php echo render_select1('status_filter[]', $packing_list_status, array('id', array('label')), 'status', $period_status_id, ['multiple' => true, 'data-width' => '100%', 'class' => ''], array(), '', '', false); ?>
					</div>

					<div class="col-md-1">
						<span class="dropdown inline-block  mt25">
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

				<div class="table-responsive">
					<?php 
					$table_data = array(
						_l('goods_delivery'),
						_l('customer_name'),
						_l('commodity_name'),
						_l('quantity'),
						_l('rate'),
						_l('expiry_date'),
						_l('lot_number'),
						_l('wh_serial_number'),
						_l('guarantee_period'),

					);
					render_datatable1($table_data,'table_warranty_period',
						array('customizable-table')
					); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/reports/warranty_period_report_js.php';?>
</body>
</html>
