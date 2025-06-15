
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">
						<?php if (has_permission('warehouse', '', 'create') || $login_user->is_admin ) { ?>
							
							<a href="<?php echo get_uri('warehouse/manage_goods_receipt'); ?>"class="btn btn-default pull-left mright10 display-block"><span data-feather="plus-circle" class="icon-16"></span>
								<?php echo _l('stock_received_docket'); ?>
							</a>

						<?php } ?>
					</div>
				</div>
				<div class="row ml2 mr5">
					<div  class="col-md-3 pull-right">
						<?php 
						$input_attr_e = [];
						$input_attr_e['placeholder'] = _l('day_vouchers');

						echo render_date_input1('date_add','','',$input_attr_e ); ?>
					</div> 
				</div>
				<div class="table-responsive">
					<?php render_datatable1(array(
						_l('id'),
						_l('stock_received_docket_code'),
						_l('supplier_name'),
						_l('Buyer'),
						_l('reference_purchase_order'),
						_l('day_vouchers'),
						_l('total_tax_money'),
						_l('total_goods_money'),
						_l('value_of_inventory'),
						_l('total_money'),
						_l('status_label'),
						"<i data-feather='menu' class='icon-16'></i>",
					),'table_manage_goods_receipt',['purchase_sm' => 'purchase_sm']);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/goods_receipts/manage_receipt_js.php';?>
</body>
</html>
