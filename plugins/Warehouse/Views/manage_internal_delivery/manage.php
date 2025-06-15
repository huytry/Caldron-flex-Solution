
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">
						<?php if (has_permission('warehouse', '', 'create') || $login_user->is_admin ) { ?>
							
							<a href="<?php echo get_uri('warehouse/add_update_internal_delivery'); ?>"class="btn btn-default pull-left mright10 display-block"><span data-feather="plus-circle" class="icon-16"></span>
								<?php echo _l('_new'); ?>
							</a>

						<?php } ?>
					</div>
				</div>
				<div class="row ml2 mr5">
					
				</div>
				<div class="table-responsive">
					<?php render_datatable1(array(
						_l('internal_delivery_note'),
						_l('deliver_name'),
						_l('addedfrom'),
						_l('datecreated'),
						_l('total_amount'),
						_l('status_label'),
						"<i data-feather='menu' class='icon-16'></i>",
					),'table_internal_delivery',['internal_delivery_sm' => 'internal_delivery_sm']); ?>
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/internal_deliveries/manage_internal_delivery_js.php';?>

</body>
</html>
