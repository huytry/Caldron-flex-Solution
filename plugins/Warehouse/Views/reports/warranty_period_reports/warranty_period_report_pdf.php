

<style type="text/css">
/*goods receipt*/
.width-5{
	width: 5%;
}
.width-7{
	width: 7%;
}
.width-15{
	width: 15%;
}
.width-13{
	width: 15%;
}
.width-10{
	width: 10%;
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
	$serial_number_html = '';
	$serial_number_index = 1;
	$table_text_color = 'style  =  "color:red";';


	?>

	<table class="header-style">
		<tr class="invoice-preview-header-row">
			<td class="width-45 vertical-align-top" >
				<img src="<?php echo get_file_from_setting("invoice_logo", true); ?>" />
			</td>
			<td class="hidden-invoice-preview-row width-20 "></td>
			<td class="invoice-info-container width-35 vertical-align-top text-align-right">
				<span class="font-size-20 font-weight-bold" style  =  "background-color: <?php echo html_entity_decode($color); ?>; color: <?php echo html_entity_decode($color_black) ?>;">&nbsp;<?php echo app_lang('wh_warranty_period_report'); ?>&nbsp;</span>

				<div class="line-height-5"></div>
				<span class="font-weight-bold" >&nbsp;<?php echo '#'.get_my_local_time("Y-m-d"); ?>&nbsp;</span>
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
			</td>
		</tr>
	</table>
</div>

<br />

<table class="table-responsive width-100 color-black" >            
	<tr class="font-weight-bold color-black background-color-black">

		<th class="border-right-1-eee width-5 color-fff" >#</th>
		<th class="border-right-1-eee width-10 color-fff" > <?php echo app_lang("goods_delivery"); ?></th>
		<th class="border-right-1-eee width-17 color-fff" > <?php echo app_lang("customer_name"); ?></th>
		<th class="border-right-1-eee width-20 color-fff" > <?php echo app_lang("commodity_name"); ?></th>
		<th class="border-right-1-eee width-10 color-fff" > <?php echo app_lang("quantity"); ?></th>
		<th class="border-right-1-eee width-10 color-fff" > <?php echo app_lang("rate"); ?></th>
		<th class="border-right-1-eee width-15 color-fff" > <?php echo app_lang("expiry_date").' / '.app_lang("lot_number").' / '.app_lang("wh_serial_number"); ?></th>
		<th class="border-right-1-eee width-13 color-fff" > <?php echo app_lang("guarantee_period"); ?></th>
	</tr>
	<?php
	$subtotal = 0;
	foreach ($warranty_period as $item_key => $item) {
		$key = $item_key+1;

		$text_color = '';
		$goods_delivery_code = '';
		if(strtotime($item['guarantee_period']) <= strtotime(get_my_local_time("Y-m-d"))){
			$text_color = $table_text_color;
		}

		$get_goods_delivery_code = get_goods_delivery_code($item['goods_delivery_id']);
		if($get_goods_delivery_code){
			$goods_delivery_code = 	$get_goods_delivery_code->goods_delivery_code;	
		}

		if($item['expiry_date'] != null &&strlen($item['expiry_date']) > 0){
			$expiry_date = $item['expiry_date'];
		}else{
			$expiry_date = '--------';
		}

		if($item['lot_number'] != null &&strlen($item['lot_number']) > 0){
			$lot_number = $item['lot_number'];
		}else{
			$lot_number = '--------';
		}

		if($item['serial_number'] != null &&strlen($item['serial_number']) > 0){
			$serial_number = $item['serial_number'];
		}else{
			$serial_number = '--------';
		}

		?>
		
		<tr class="background-color-f4f4f4" >
			<td class="text-align-right width-5 border-1-solid-fff" <?php echo html_entity_decode($text_color) ?>> <?php echo html_entity_decode($key); ?></td>
			<td class="width-10 border-1-solid-fff" <?php echo html_entity_decode($text_color) ?>><?php echo html_entity_decode($goods_delivery_code); ?></td>
			<td class="width-17 border-1-solid-fff" <?php echo html_entity_decode($text_color) ?>><?php echo wh_get_company_name($item['customer_code']); ?></td>
			<td class="width-20 border-1-solid-fff" <?php echo html_entity_decode($text_color) ?>><?php echo html_entity_decode($item['commodity_name']); ?></td>
			<td class="width-10 border-1-solid-fff" <?php echo html_entity_decode($text_color) ?>><?php echo html_entity_decode($item['quantities'].' '.wh_get_unit_name($item['unit_id'])); ?></td>
			<td class="width-10 border-1-solid-fff text-align-right" <?php echo html_entity_decode($text_color) ?>><?php echo to_decimal_format($item['unit_price']); ?></td>
			<td class="width-15 border-1-solid-fff" <?php echo html_entity_decode($text_color) ?>><?php echo html_entity_decode($expiry_date); ?><br/><?php echo html_entity_decode($lot_number); ?><br/><?php echo html_entity_decode($serial_number); ?></td>
			<td class="width-13 border-1-solid-fff" <?php echo html_entity_decode($text_color) ?>><?php echo format_to_date($item['guarantee_period']); ?></td>
		</tr>
		
	<?php } ?>

</table>