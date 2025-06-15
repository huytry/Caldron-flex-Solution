
<style type="text/css">
/*goods receipt*/
.width-5{
	width: 5%;
}
.width-15{
	width: 15%;
}
.width-17{
	width: 17%;
}
.width-20{
	width: 20%;
}
.width-28{
	width: 28%;
}
.width-35{
	width: 35%;
}

.width-45{
	width: 45%;
}
.width-100{
	width: 100%;
}

.vertical-align-top{
	vertical-align: top;
}

.text-align-right{
	text-align: right;
}
.text-align-center{
	text-align: center;
}
.text-align-left{
	text-align: left;
}

.font-size-18{
	font-size: 18px;
}
.font-size-20{
	font-size: 20px;
}
.font-weight-bold{
	font-weight: bold;
}
.line-height-10{
	line-height: 10px;
}
.line-height-2{
	line-height: 2px;
}
.line-height-3{
	line-height: 3px;
}
.line-height-5{
	line-height: 5px;
}

.padding-5{
	padding: 5px;
}
.padding-10{
	padding: 10px;
}
.padding-0-0-20-0{
	padding:0 0 20px 0;
}
.border-bottom-1{
	border-bottom: 1px solid #f2f4f6;
}
.border-right-1-eee{
	border-right: 1px solid #eee;
}
.border-1-solid-fff{
	border: 1px solid #fff
}

.border-top-2-f2f2f2{
	border-top: 2px solid #f2f2f2;
}
.color-black{
	color: #444;
}
.color-fff{
	color: #fff;
}

.background-color-black{
	background-color: #000000;
}
.background-color-f4f4f4{
	background-color: #f4f4f4;
}
</style>

<div style  =  " margin: auto;">
	<?php
	$color = get_setting("invoice_color");
	if (!$color) {
		$color = "#2AA384";
	}
	$color_black = "#fff";

	$invoice_style = get_setting("invoice_style");
	$warehouse_lotnumber_bottom_infor_option = get_setting('goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor');
	$serial_number_html = '';
	$serial_number_index = 1;

	?>

	<table class="header-style">
		<tr class="invoice-preview-header-row">
			<td class="width-45 vertical-align-top" >
				<img src="<?php echo get_file_from_setting("invoice_logo", true); ?>" />
			</td>
			<td class="hidden-invoice-preview-row width-20 "></td>
			<td class="invoice-info-container width-35 vertical-align-top text-align-right">
				<span class="font-size-18 font-weight-bold" style =  "background-color: <?php echo html_entity_decode($color); ?>; color: <?php echo html_entity_decode($color_black) ?>;">&nbsp;<?php echo app_lang('inventory_receiving_voucher'); ?>&nbsp;</span>

				<div class="line-height-5"></div>
				<span class="font-weight-bold" >&nbsp;<?php echo '#'.$goods_receipt->goods_receipt_code; ?>&nbsp;</span>
				<div class="line-height-10"></div>
				<span><?php echo app_lang("datecreated") . ": " . format_to_date($goods_receipt->date_add, false); ?></span>
			</td>
		</tr>
		<tr>
			<td class="padding-5"></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>
				<?php
				echo company_widget(get_default_company_id());
				?>
			</td>
			<td></td>
			<td>
				<div><b><?php echo app_lang("supplier_name"); ?></b></div>
				<div class="line-height-2 border-bottom-1"> </div>
				<div class="line-height-3"> </div>
				<span><?php echo html_entity_decode($goods_receipt->supplier_name); ?> </span>
			</td>
		</tr>
	</table>
</div>

<br />

<table class="table-responsive width-100 color-black" >            
	<tr class="font-weight-bold color-black background-color-black">

		<th class="border-right-1-eee width-5 color-fff" >#</th>
		<th class="border-right-1-eee width-28 color-fff" > <?php echo app_lang("commodity_name"); ?></th>
		<th class="border-right-1-eee width-15 color-fff" > <?php echo app_lang("warehouse_name"); ?></th>
		<th class="border-right-1-eee width-17 color-fff" > <?php echo app_lang("quantity"); ?></th>
		<th class="border-right-1-eee width-15 color-fff" > <?php echo app_lang("unit_price"); ?></th>
		<th class="border-right-1-eee width-20 color-fff" > <?php echo app_lang("total_money"); ?></th>
	</tr>
	<?php
	foreach ($goods_receipt_details as $item_key => $item) {
		$commodity_name = (isset($item) ? $item['commodity_name'] : '');
		$quantities = (isset($item) ? $item['quantities'] : '');
		$unit_price = (isset($item) ? $item['unit_price'] : '');
		$goods_money = (isset($item) ? $item['goods_money'] : '');
		$commodity_code = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->commodity_code : ''; 
		$commodity_name = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->description : '';
		$unit_name = get_unit_type($item['unit_id']) != null ? get_unit_type($item['unit_id'])->unit_name : '';
		$warehouse_code = get_warehouse_name($item['warehouse_id']) != null ? get_warehouse_name($item['warehouse_id'])->warehouse_name : '';
		$tax_money =(isset($item['tax_money']) ? $item['tax_money'] : '');
		$expiry_date =(isset($item['expiry_date']) ? format_to_date($item['expiry_date']) : '');
		$lot_number =(isset($item['lot_number']) ? $item['lot_number'] : '');
		$commodity_name = $item['commodity_name'];
		if(strlen($commodity_name) == 0){
			$commodity_name = wh_get_item_variatiom($item['commodity_code']);
		}

		$key = $item_key+1;
		?>
		
		<tr class="background-color-f4f4f4" >
			<td class="text-align-right width-5 border-1-solid-fff" > <?php echo html_entity_decode($key); ?></td>
			<td class="width-28 border-1-solid-fff"><?php echo html_entity_decode($item['commodity_name']); ?></td>
			<td class="text-align-left width-15 border-1-solid-fff"> <?php echo html_entity_decode($warehouse_code); ?></td>
			<td class="text-align-right width-17 border-1-solid-fff"> <?php echo html_entity_decode($quantities.$unit_name); ?><br><?php echo html_entity_decode($lot_number); ?><br><?php echo html_entity_decode($expiry_date); ?></td>
			<td  class="text-align-right width-15 border-1-solid-fff"> <?php echo to_currency($unit_price); ?></td>
			<td class="text-align-right width-20 border-1-solid-fff"> <?php echo to_currency($goods_money); ?></td>
		</tr>
		<!-- Serial Numbers -->
		<?php 
		if(strlen($item['serial_number']) > 0){
			$arr_serial_numbers = explode(',', $item['serial_number']);
			foreach ($arr_serial_numbers as $serial_number_value) {

				$serial_number_html .= '<tr><td class="width-5" width="5%"><b>' . $serial_number_index . '</b></td>
				<td class="width-30 " width="30%"><b>' . $commodity_name.'</b></td>
				<td class="width-20" width="20%">' . $warehouse_code . '</td>
				<td class="width-45" width="45%">' . $serial_number_value . '</td></tr>';
				$serial_number_index++;
			}
		}
		?>
	<?php } ?>


	<tr>
		<td colspan="5" class="text-align-right" ><?php echo app_lang("total_goods_money"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($goods_receipt->total_goods_money); ?>
		</td>
	</tr>
	<tr>
		<td colspan="5" class="text-align-right"><?php echo app_lang("value_of_inventory"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($goods_receipt->value_of_inventory); ?>
		</td>
	</tr>
	<?php echo html_entity_decode($tax_data['pdf_html']); ?>
	<tr>
		<td colspan="5" class="text-align-right"><?php echo app_lang("total_tax_money"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($goods_receipt->total_tax_money); ?>
		</td>
	</tr>
	<tr>
		<td colspan="5" class="text-align-right"><?php echo app_lang("total_money"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-black">
			<span class="color-fff"><?php echo to_currency($goods_receipt->total_money); ?></span>
		</td>
	</tr>

</table>
<?php if (strlen($goods_receipt->description) > 0) { ?>
	<br />
	<br />
	<div class="border-top-2-f2f2f2 color-black padding-0-0-20-0" ><br /><?php echo nl2br($goods_receipt->description); ?></div>
<?php }  ?>

<!-- display serial number -->
<?php if(strlen($serial_number_html) > 0){ ?>
	<div>
		<strong><?php echo app_lang("wh_serial_number_list") ?></strong>
	</div><br/>

	<table class="table-responsive width-100 color-black">
		<tr class="font-weight-bold color-black background-color-black">
			<th class="width-5 border-right-1-eee color-fff" >#</th>
			<th class="width-30 text-align-center border-right-1-eee color-fff" > <?php echo app_lang("commodity_code"); ?></th>
			<th class="width-20 text-align-right border-right-1-eee color-fff"> <?php echo app_lang("warehouse_name"); ?></th>
			<th class="width-45 text-align-center border-right-1-eee color-fff"> <?php echo app_lang("wh_serial_number"); ?></th>
		</tr>

		<tbody class="background-color-f4f4f4" >
			<?php echo html_entity_decode($serial_number_html) ?>
		</tbody>
	</table>
	<br/>

	<?php } ?>