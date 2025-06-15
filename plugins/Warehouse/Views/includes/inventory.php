<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-3 col-lg-2">
			<?php
			$tab_view['active_tab'] = "inventory";
			echo view("Warehouse\Views\includes/tabs", $tab_view);
			?>
		</div>

		<div class="col-sm-9 col-lg-10">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('inventory_config_min'); ?></h4>
					<div class="title-button-group mt-3">
						<?php echo render_input1('inventory_filter','','', 'text', ['placeholder' => 'Search...']); ?>  
					</div>
				</div>

				<?php echo form_open_multipart(get_uri("warehouse/update_inventory_min"), array("id" => "inventory_min-form", "class" => "general-form", "role" => "form")); ?>

				<div class="table-responsive pt15 pl15 pr15">
					<div id="inventory_min">
					</div>   
					<div class="form"> 
						<div id="add_handsontable_hs" class="col-md-12 add_handsontable handsontable htColumnHeaders">

						</div>
						<?php echo form_hidden('add_handsontable_hs'); ?>
					</div>
				</div>
				<?php if (has_permission('warehouse', '', 'create') || $login_user->is_admin || has_permission('warehouse', '', 'edit')  ) { ?>
					<div class="modal-footer">

						<button type="button" class="btn btn-primary inventory_min_modal"><span data-feather="check-circle" class="icon-16" ></span> <?php echo app_lang('save'); ?></button>
					</div>
				<?php } ?>

				<?php echo form_close(); ?>

			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/settings/inventory_js.php';?>
</body>
</html>