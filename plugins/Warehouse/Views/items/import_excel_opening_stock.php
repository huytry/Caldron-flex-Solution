<?php 
$file_header = array();
$file_header[] = _l('commodity_code');
$file_header[] = _l('warehouse_code');
$file_header[] = _l('lot_number');
$file_header[] = _l('expiry_date');
$file_header[] = _l('inventory_number');

?>
<div id="page-content" class="page-wrapper clearfix">
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<div class="card pr15 pl15">
				<div class="page-title clearfix">
					<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('import_opening_stock'); ?></h4>
					<div class="title-button-group">
						<div id ="dowload_file_sample">
						</div>
					</div>
				</div>


				<?php if(!isset($simulate)) { ?>
					<ul>
						<li class="text-danger">1. <?php echo _l('file_xlsx_import_opening_stock'); ?></li>
						<li class="text-danger">2. <?php echo _l('file_xlsx_format'); ?></li>
					</ul>
					<div class="table-responsive no-dt">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<?php
									$total_fields = 0;

									for($i=0;$i<count($file_header);$i++){
										if($i == 0  ||$i == 1 ||$i == 4){
											?>
											<th class="bold"><span class="text-danger">*</span> <?php echo html_entity_decode($file_header[$i]) ?> </th>
											<?php 
										} else {
											?>
											<th class="bold"><?php echo html_entity_decode($file_header[$i]) ?> </th>

											<?php

										} 
										$total_fields++;
									}

									?>

								</tr>
							</thead>
							<tbody>
								<?php for($i = 0; $i<1;$i++){
									echo '<tr>';
									for($x = 0; $x<count($file_header);$x++){
										echo '<td>- </td>';
									}
									echo '</tr>';
								}
								?>
							</tbody>
						</table>
					</div>

				<?php } ?>


				<div class="row">
					<div class="col-md-4">
						<?php echo form_open_multipart(get_uri("warehouse/import_file_xlsx_opening_stock"), array("id" => "import_form", "class" => "general-form", "role" => "form")); ?>
						<?php echo form_hidden('leads_import','true'); ?>
						<?php echo render_input1('file_csv','choose_excel_file','','file', [], [], '', '', true ); ?> 

						<div class="form-group">
							<a href="<?php echo get_uri('warehouse/commodity_list'); ?>" class="btn btn-default pull-left display-block mr-5 button-margin-r-b" title="<?php echo _l('close') ?> "><?php echo _l('close'); ?>
						</a>
						<button id="uploadfile" type="button" class="btn btn-primary text-white import" onclick="return uploadfilecsv(this);" ><?php echo _l('wh_import'); ?></button>
					</div>
					<?php echo form_close(); ?>

				</div>
				<div class="col-md-8">
					<div class="form-group" id="file_upload_response">
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>

<!-- box loading -->
<div id="box-loading">

</div>
<?php require('plugins/Warehouse/assets/js/items/import_excel_opening_inventory_js.php'); ?>

</body>
</html>
