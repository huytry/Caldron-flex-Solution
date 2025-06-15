
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo html_entity_decode($title); ?></h4>
					<div class="title-button-group">
						<?php if (has_permission('warehouse', '', 'create') || $login_user->is_admin ) { ?>
							
							<a href="<?php echo get_uri('warehouse/goods_delivery'); ?>"class="btn btn-default pull-left mright10 display-block"><span data-feather="plus-circle" class="icon-16"></span>
								<?php echo _l('export_ouput_splip'); ?>
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
						_l('goods_delivery_code'),
						_l('customer_name'),
						_l('day_vouchers'),
						_l('invoices'),
						_l('to'),
						_l('address'),
						_l('staff_id'),
						_l('status_label'),
						_l('delivery_status'),
						"<i data-feather='menu' class='icon-16'></i>",
					),'table_manage_delivery',['delivery_sm' => 'delivery_sm']); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="send_goods_delivery" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<?php echo form_open_multipart(site_url('warehouse/send_goods_delivery'),array('id'=>'send_goods_delivery-form')); ?>
		<div class="modal-content modal_withd">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<span><?php echo _l('send_delivery_note_by_email'); ?></span>
				</h4>
			</div>
			<div class="modal-body">
				<div id="additional_goods_delivery"></div>
				<div id="goods_delivery_invoice_id"></div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label for="customer_name"><span class="text-danger">* </span><?php echo _l('customer_name'); ?></label>
						<select name="customer_name" id="customer_name" class="selectpicker" required  data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>" >

						</select>
						<br>
					</div>

					<div class="col-md-12">
						<label for="email"><span class="text-danger">* </span><?php echo _l('email'); ?></label>
						<?php echo render_input1('email','','','',array('required' => 'true')); ?>
					</div>

					<div class="col-md-12">
						<label for="subject"><span class="text-danger">* </span><?php echo _l('_subject'); ?></label>
						<?php echo render_input1('subject','','','',array('required' => 'true')); ?>
					</div>
					<div class="col-md-12">
						<label for="attachment"><span class="text-danger">* </span><?php echo _l('acc_attach'); ?></label>
						<?php echo render_input1('attachment','','','file',array('required' => 'true')); ?>
					</div>
					<div class="col-md-12">
						<?php echo render_textarea1('content','email_content','',array(),array(),'','tinymce') ?>
					</div>     
					<div id="type_care">

					</div>        
				</div>
			</div>
			<div class="modal-footer">
				<button type=""class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
				<button id="sm_btn" type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
			</div>
		</div><!-- /.modal-content -->
		<?php echo form_close(); ?>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php require 'plugins/Warehouse/assets/js/goods_deliveries/manage_delivery_js.php';?>
</body>
</html>
