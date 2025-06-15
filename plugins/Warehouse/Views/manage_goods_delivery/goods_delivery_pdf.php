
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
				<span class="font-size-18 font-weight-bold" style  =  "background-color: <?php echo html_entity_decode($color); ?>; color: <?php echo html_entity_decode($color_black) ?>;">&nbsp;<?php echo app_lang('inventory_delivery_voucher'); ?>&nbsp;</span>

				<div class="line-height-5"></div>
				<span class="font-weight-bold" >&nbsp;<?php echo '#'.$goods_delivery->goods_delivery_code; ?>&nbsp;</span>

				<div class="line-height-10"></div>
				<span><?php echo app_lang("goods_receipt_date") . ": " . format_to_date($goods_delivery->date_add, false); ?></span>
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
		<th class="border-right-1-eee width-28 color-fff" > <?php echo app_lang("commodity_name"); ?></th>
		<th class="border-right-1-eee width-15 color-fff" > <?php echo app_lang("warehouse_name"); ?></th>
		<th class="border-right-1-eee width-17 color-fff" > <?php echo app_lang("quantity").' / '.app_lang("lot_number").' / '.app_lang("guarantee_period"); ?></th>
		<th class="border-right-1-eee width-15 color-fff" > <?php echo app_lang("unit_price"); ?></th>
		<th class="border-right-1-eee width-20 color-fff" > <?php echo app_lang("total_money"); ?></th>
	</tr>
	<?php
	$subtotal = 0;
	foreach ($goods_delivery_details as $item_key => $item) {
		$commodity_name = (isset($item) ? $item['commodity_name'] : '');
		$quantities = (isset($item) ? $item['quantities'] : '');
		$unit_price = (isset($item) ? $item['unit_price'] : '');
		$commodity_code = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->commodity_code : ''; 
		$commodity_name = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->description : '';
		$unit_name = get_unit_type($item['unit_id']) != null ? get_unit_type($item['unit_id'])->unit_name : '';
		$warehouse_code = get_warehouse_name($item['warehouse_id']) != null ? get_warehouse_name($item['warehouse_id'])->warehouse_name : '';
		$tax_money =(isset($item['tax_money']) ? $item['tax_money'] : '');
		$commodity_name = $item['commodity_name'];
		if(strlen($commodity_name) == 0){
			$commodity_name = wh_get_item_variatiom($item['commodity_code']);
		}

		$total_money = (isset($item) ? $item['total_money'] : '');
		$discount = (isset($item) ? $item['discount'] : '');
		$discount_money = (isset($item) ? $item['discount_money'] : '');

		$total_after_discount = (isset($item) ? $item['total_after_discount'] : '');
		$subtotal += (float)$item['quantities'] * (float)$item['unit_price'];
		$item_subtotal = (float)$item['quantities'] * (float)$item['unit_price'];

		$warehouse_name ='';

		if(isset($item['warehouse_id']) && ($item['warehouse_id'] !='')){
			$arr_warehouse = explode(',', $item['warehouse_id']);

			$str = '';
			if(count($arr_warehouse) > 0){

				foreach ($arr_warehouse as $wh_key => $warehouseid) {
					$str = '';
					if ($warehouseid != '' && $warehouseid != '0') {

						$team = get_warehouse_name($warehouseid);
						if($team){
							$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

							if(strlen($str) > 0){
								$str .= ',<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span></span>';
							}else{
								$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span></span>';
							}

							$warehouse_name .= $str;
							if($wh_key%3 ==0){
								$warehouse_name .='<br/>';
							}
						}
					}
				}
			} else {
				$warehouse_name = '';
			}
		}

		$lot_number ='';
		if(($item['lot_number'] != null) && ( $item['lot_number'] != '') ){
			$array_lot_number = explode(',', $item['lot_number']);
			foreach ($array_lot_number as $key => $lot_value) {

				if($key%2 ==0){
					$lot_number .= $lot_value;
				}else{
					$lot_number .= ' : '.$lot_value.' ';
				}
			}
		}


		$key = $item_key+1;
		?>
		
		<tr class="background-color-f4f4f4" >
			<td class="text-align-right width-5 border-1-solid-fff" > <?php echo html_entity_decode($key); ?></td>
			<td class="width-28 border-1-solid-fff"><?php echo html_entity_decode($item['commodity_name']); ?></td>
			<td class="text-align-left width-15 border-1-solid-fff"> <?php echo html_entity_decode($warehouse_name); ?></td>
			<td class="text-align-right width-17 border-1-solid-fff"> <?php echo html_entity_decode($quantities.' '.$unit_name); ?><br><?php echo html_entity_decode($lot_number); ?><br><?php echo format_to_date($item['guarantee_period']); ?></td>
			<td  class="text-align-right width-15 border-1-solid-fff"> <?php echo to_currency($unit_price); ?></td>
			<td class="text-align-right width-20 border-1-solid-fff"> <?php echo to_currency($item['sub_total']); ?></td>
		</tr>
		
	<?php } ?>

	<?php 
	$after_discount = isset($goods_delivery) ?  $goods_delivery->after_discount : 0 ;
	$shipping_fee = isset($goods_delivery) ?  $goods_delivery->shipping_fee : 0 ;
	if($goods_delivery->after_discount == null){
		$after_discount = $goods_delivery->total_money;
	}
	$total_discount = 0 ;
	if(isset($goods_delivery)){
		$total_discount += (float)$goods_delivery->total_discount  + (float)$goods_delivery->additional_discount;
	}
	?>


	<tr>
		<td colspan="5" class="text-align-right" ><?php echo app_lang("subtotal"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($subtotal); ?>
		</td>
	</tr>
	<tr>
		<td colspan="5" class="text-align-right"><?php echo app_lang("total_discount"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($total_discount); ?>
		</td>
	</tr>
	<?php echo html_entity_decode($tax_data['pdf_html']); ?>
	<tr>
		<td colspan="5" class="text-align-right"><?php echo app_lang("wh_shipping_fee"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-f4f4f4">
			<?php echo to_currency($shipping_fee); ?>
		</td>
	</tr>
	<tr>
		<td colspan="5" class="text-align-right"><?php echo app_lang("total_money"); ?></td>
		<td class="text-align-right width-20 border-1-solid-fff background-color-black">
			<span class="color-fff"><?php echo to_currency($after_discount); ?></span>
		</td>
	</tr>

</table>
<?php if (strlen($goods_delivery->description) > 0) { ?>
	<br />
	<br />
	<div class="border-top-2-f2f2f2 color-black padding-0-0-20-0" ><br /><?php echo nl2br($goods_delivery->description); ?></div>
<?php }  ?>
