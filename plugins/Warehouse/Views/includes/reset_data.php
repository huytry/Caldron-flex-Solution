<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-3 col-lg-2">
			<?php
			$tab_view['active_tab'] = "reset_data";
			echo view("Warehouse\Views\includes/tabs", $tab_view);
			?>
		</div>

		<div class="col-sm-9 col-lg-10">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('reset_data'); ?></h4>
					<div class="title-button-group">
						<?php if ($login_user->is_admin ) { ?>
							<?php echo js_anchor(app_lang("reset_data"), array('title' => app_lang('delete'), "class" => " reset_data btn btn-danger delete", "data-reload-on-success" => 0, "data-remove-on-success" => 1,  "data-action-url" => get_uri("warehouse/reset_data"), "data-action" => "delete-confirmation")); ?>
						<?php } ?>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
</body>

</html>


