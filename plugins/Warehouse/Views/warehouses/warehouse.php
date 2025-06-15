<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('wh_warehouses'); ?></h4>
					<div class="title-button-group">
						<?php if (has_permission('warehouse', '', 'create') || is_admin() ) { ?>
							
							<?php echo modal_anchor(get_uri("warehouse/warehouse_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_warehouse'), array("class" => "btn btn-default", "title" => app_lang('add_warehouse'))); ?>
						<?php } ?>
					</div>
				</div>
				<div class="table-responsive">
					<table id="warehouse-table" class="display" cellspacing="0" width="100%">            
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/warehouses/warehouse_js.php';?>
</body>
</html>