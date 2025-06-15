<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode(app_lang('wh_loss_adjustments')); ?></h4>
					<div class="title-button-group">
						<?php if (has_permission('warehouse', '', 'create') || $login_user->is_admin ) { ?>
							
							<a href="<?php echo get_uri('warehouse/add_loss_adjustment'); ?>"class="btn btn-default pull-left mright10 display-block"><span data-feather="plus-circle" class="icon-16"></span>
								<?php echo app_lang('add'); ?>
							</a>

						<?php } ?>
					</div>
				</div>
				<div class="row ml2 mr5">
					<div class="col-md-3 ">
						<?php 
						$input_attr_e = [];
						$input_attr_e['placeholder'] = app_lang('_time');

						echo render_date_input1('time_filter','','',$input_attr_e ); ?>
					</div>

					<div class="col-md-3">
						<?php 
						$input_attr_e = [];
						$input_attr_e['placeholder'] = app_lang('datecreator');

						echo render_date_input1('date_create','','',$input_attr_e ); ?>
					</div>
					<div class="col-md-3">

						<div class="form-group">
							<select name="status_filter" class="select2 validate-hidden" id="status_filter" data-width="100%" placeholder="<?php echo app_lang('status_label'); ?>"> 
								<option value="">-</option>
								<option value="0"><?php echo app_lang('status_draft'); ?></option>
								<option value="1"><?php echo app_lang('adjusted'); ?></option>
								<option value="-1"><?php echo app_lang('reject'); ?></option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<select name="type_filter" class="select2 validate-hidden" id="patient" data-width="100%" placeholder="<?php echo app_lang('type_label'); ?>"> 
								<option value="">-</option>
								<option value="loss"><?php echo app_lang('loss'); ?></option>
								<option value="adjustment"><?php echo app_lang('adjustment'); ?></option>
							</select>
						</div>
					</div>

				</div>
				<div class="table-responsive">
					<?php render_datatable1(array(
						app_lang('id'),
						app_lang('loss_adjustment_title'),
						app_lang('type_label'),
						app_lang('_time'),
						app_lang('addedfrom'),
						app_lang('datecreator'),
						app_lang('reason'),
						app_lang('status_label'),
						"<i data-feather='menu' class='icon-16'></i>",

					),'table_loss_adjustment',['purchase_sm' => 'purchase_sm']);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require 'plugins/Warehouse/assets/js/loss_adjustments/manage_loss_adjustment_js.php';?>
</body>
</html>