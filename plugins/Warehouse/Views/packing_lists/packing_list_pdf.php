
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
.width-43{
	width: 43%;
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

.font-size-20{
	font-size: 20px;
}
.font-weight-bold{
	font-weight: bold;
}
.line-height-10{
	line-height: 10px;
}
.line-height-5{
	line-height: 5px;
}
.line-height-2{
	line-height: 2px;
}
.line-height-3{
	line-height: 3px;
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

<div style =  " margin: auto;">
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
				<span class="font-size-20 font-weight-bold" style  =  "background-color: <?php echo html_entity_decode($color); ?>; color: <?php echo html_entity_decode($color_black) ?>;">&nbsp;<?php echo app_lang('wh_packing_list'); ?>&nbsp;</span>

				<div class="line-height-5"></div>
				<span class="font-weight-bold" >&nbsp;<?php echo '#'.$packing_list->packing_list_number.' - '.$packing_list->packing_list_name; ?>&nbsp;</span>
				<div class="line-height-10"></div>
				<span><?php echo app_lang("datecreated") . ": " . format_to_datetime($packing_list->datecreated, false); ?></span>
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
				<?php
				echo view('invoices/invoice_parts/bill_to', ['client_info' => $client_info]);
				?>
				<span></span>
			</td>
		</tr>
	</table>
</div>

<br />

<table class="table-responsive width-100 color-black" >            
	<tr class="font-weight-bold color-black background-color-black">

		<th class="border-right-1-eee width-5 color-fff" >#</th>
		<th class="border-right-1-eee width-43 color-fff" > <?php echo app_lang("commodity_name"); ?></th>
		<th class="border-right-1-eee width-17 color-fff" > <?php echo app_lang("quantity"); ?></th>
		<th class="border-right-1-eee width-15 color-fff" > <?php echo app_lang("unit_price"); ?></th>
		<th class="border-right-1-eee width-20 color-fff" > <?php echo app_lang("total_money"); ?></th>
	</tr>
	<?php
	$subtotal = 0;
	foreach ($packing_list_details as $item_key => $item) {
		$commodity_name = (isset($item) ? $item['commodity_name'] : '');
		$quantities = (isset($item) ? $item['quantity'] : '');
		$unit_price = (isset($item) ? $item['unit_price'] : '');
		$commodity_code = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->commodity_code : ''; 
		$commodity_name = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->description : '';
		$unit_name = get_unit_type($item['unit_id']) != null ? get_unit_type($item['unit_id'])->unit_name : '';
		$tax_money =(isset($item['tax_money']) ? $item['tax_money'] : '');
		$commodity_name = $item['commodity_name'];
		if(strlen($commodity_name) == 0){
			$commodity_name = wh_get_item_variatiom($item['commodity_code']);
		}

		$subtotal += (float)$item['quantity'] * (float)$item['unit_price'];
		$item_subtotal = (float)$item['quantity'] * (float)$item['unit_price'];

		$key = $item_key+1;
		?>
		
		<tr class="background-color-f4f4f4" >
			<td class="text-align-right width-5 border-1-solid-fff" > <?php echo html_entity_decode($key); ?></td>
			<td class="width-43 border-1-solid-fff"><?php echo html_entity_decode($item['commodity_name']); ?></td>
			<td class="text-align-right width-17 border-1-solid-fff"> <?php echo html_entity_decode($quantities.' '.$unit_name); ?></td>
			<td  class="text-align-right width-15 border-1-solid-fff"> <?php echo to_currency($unit_price); ?></td>
			<td class="text-align-right width-20 border-1-solid-fff"> <?php echo to_currency($item['sub_total']); ?></td>
		</tr>
		
	<?php } ?>

	<?php 
	
	$total_discount = 0 ;
	if(isset($packing_list)){
		$total_discount += (float)$packing_list->discount_total  + (float)$packing_list->additional_discount;
	}
	?>


	<tr>
		<td colspan="4" class="text-align-right" ><?php echo app_lang("subtotal"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($packing_list->subtotal); ?>
		</td>
	</tr>
	<?php echo html_entity_decode($tax_data['pdf_html']); ?>
	<tr>
		<td colspan="4" class="text-align-right"><?php echo app_lang("total_discount"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($total_discount); ?>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="text-align-right"><?php echo app_lang("wh_shipping_fee"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($packing_list->shipping_fee); ?>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="text-align-right"><?php echo app_lang("total_money"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-black">
			<span class="color-fff"><?php echo to_currency($packing_list->total_after_discount); ?></span>
		</td>
	</tr>

</table>
<?php if (strlen($packing_list->client_note) > 0) { ?>
	<br />
	<br />
	<div class="border-top-2-f2f2f2 color-black padding-0-0-20-0" ><br /><?php echo nl2br($packing_list->client_note); ?></div>
<?php }  ?>
