<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">
						<?php if (has_permission('warehouse', '', 'create') || $login_user->is_admin ) { ?>
							
							<a href="<?php echo get_uri('warehouse/packing_list'); ?>"class="btn btn-default pull-left mright10 display-block"><span data-feather="plus-circle" class="icon-16"></span>
								<?php echo _l('add'); ?>
							</a>

						<?php } ?>
					</div>
				</div>
				<div class="row ml2 mr5">
					<div class="col-md-2">
						<?php echo render_date_input1('from_date', '', $from_date, ['placeholder' => app_lang('from_date')]); ?>
					</div>
					<div class="col-md-2">
						<?php echo render_date_input1('to_date', '', $to_date, ['placeholder' => app_lang('to_date')]); ?>
					</div>
					<div class="col-md-3">
						<?php echo render_select1('staff_id[]', $staffs, array('id', array('first_name', 'last_name')), '', '', ['multiple' => true, 'data-width' => '100%', 'placeholder' => app_lang('staff_name'), 'data-live-search' => "true"], array(), '', '', false); ?>
					</div>
					<div class="col-md-3">
						<?php echo render_select1('delivery_id[]', $get_goods_delivery, array('id', array('goods_delivery_code')), '', '', ['multiple' => true, 'data-width' => '100%', 'placeholder' => app_lang('stock_export'), 'data-live-search' => "true"], array(), '', '', false); ?>
					</div>
					<?php 
					$packing_list_status = [];
					$packing_list_status[] = [
						'id' => 1,
						'label' => _l('approved'),
					];
					$packing_list_status[] = [
						'id' => 5,
						'label' => _l('not_yet_approve'),
					];
					$packing_list_status[] = [
						'id' => -1,
						'label' => _l('reject'),
					];

					?>
					<div class="col-md-2">
						<?php echo render_select1('status_id[]', $packing_list_status, array('id', array('label')), '', $status_id, ['multiple' => true, 'data-width' => '100%', 'placeholder' => app_lang('status')], array(), '', '', false); ?>
					</div>
				</div>
				<div class="table-responsive">
					<?php render_datatable1(array(
						_l('id'),
						_l('packing_list_number'),
						_l('customer_name'),
						_l('wh_dimension'),
						_l('volume_m3_label'),
						_l('total_amount'),
						_l('discount_total'),
						_l('total_after_discount'),
						_l('datecreated'),
						_l('status_label'),
						_l('delivery_status'),
						"<i data-feather='menu' class='icon-16'></i>",

					),'table_manage_packing_list',['packing_list_sm' => 'packing_list_sm']); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require 'plugins/Warehouse/assets/js/packing_lists/manage_packing_list_js.php';?>

</body>
</html>
