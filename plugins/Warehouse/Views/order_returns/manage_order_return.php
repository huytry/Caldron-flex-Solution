<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">

						<?php if (has_permission('warehouse', '', 'create') || is_admin()) { ?>

							<span class="dropdown inline-block mt10">
								<button class="btn btn-info text-white dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true">
									<i data-feather="tool" class="icon-16"></i> <?php echo app_lang('add'); ?>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li role="presentation">
										<a href="<?php echo site_url('warehouse/order_return/inventory_receipt' ) ?>" class="dropdown-item">
											<span data-feather="log-in" class="icon-16"></span> 
											<?php echo app_lang('wh_inventory_receipt_voucher_returned_goods')  ?>
										</a>
									</li>
									
									<li role="presentation">
										<a href="<?php echo site_url('warehouse/order_return/inventory_delivery' ) ?>" class="dropdown-item">
											<span data-feather="log-out" class="icon-16"></span> 
											<?php echo app_lang('wh_inventory_delivery_voucher_returned_purchasing_goods')  ?>
										</a>
									</li>

								</ul>
							</span>

						<?php } ?>

					</div>
				</div>
				<div class="row ml2 mr5">

					<div class="col-sm-4 col-md-2">
						<?php echo render_date_input1('from_date', 'from_date', $from_date); ?>
					</div>
					<div class="col-sm-4 col-md-2">
						<?php echo render_date_input1('to_date', 'to_date', $to_date); ?>
					</div>
					<?php 
					$receipt_delivery_type = [];
					$receipt_delivery_type[] = [
						'id' => 'inventory_receipt_voucher_returned_goods',
						'label' => _l('wh_inventory_receipt_voucher_returned_goods'),
					];
					$receipt_delivery_type[] = [
						'id' => 'inventory_delivery_voucher_returned_purchasing_goods',
						'label' => _l('wh_inventory_delivery_voucher_returned_purchasing_goods'),
					];
					?>

					<div class="col-sm-4 col-md-3">
						<?php echo render_select1('receipt_delivery_type[]', $receipt_delivery_type, array('id', array('label')), 'type', '', ['multiple' => true, 'data-width' => '100%', 'class' => 'selectpicker', 'data-live-search' => "true"], array(), '', '', false); ?>
					</div>
					<div class="col-sm-6 col-md-3">
						<?php echo render_select1('staff_id[]', $staffs, array('id', array('first_name', 'last_name')), 'staff_name', '', ['multiple' => true, 'data-width' => '100%', 'class' => 'selectpicker', 'data-live-search' => "true"], array(), '', '', false); ?>
					</div>


					<?php 
					$order_return_status = [];
					$order_return_status[] = [
						'id' => 1,
						'label' => _l('approved'),
					];
					$order_return_status[] = [
						'id' => 5,
						'label' => _l('not_yet_approve'),
					];
					$order_return_status[] = [
						'id' => -1,
						'label' => _l('reject'),
					];

					?>
					<div class="col-sm-6 col-md-2">
						<?php echo render_select1('status_id[]', $order_return_status, array('id', array('label')), 'status', [], ['multiple' => true, 'data-width' => '100%', 'class' => 'selectpicker'], array(), '', '', false); ?>
					</div>
				</div>
				<div class="table-responsive">
					<?php render_datatable1(array(
						_l('id'),
						_l('order_return_number'),
						_l('customer_name'),
						_l('total_amount'),
						_l('discount_total'),
						_l('total_after_discount'),
						_l('datecreated'),
						_l('type'),
						_l('status_label'),
						"<i data-feather='menu' class='icon-16'></i>",
						"<i data-feather='menu' class='icon-16'></i>",


					),'table_manage_order_return',['order_return_sm' => 'order_return_sm']); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="warehouse_modal_wrapper"></div>
<?php require 'plugins/Warehouse/assets/js/order_returns/manage_order_return_js.php';?>

</body>
</html>
