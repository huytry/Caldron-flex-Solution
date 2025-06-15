
<style type="text/css">
/*goods receipt*/
.width-5{
	width: 5%;
}
.width-12{
	width: 12%;
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
.width-25{
	width: 25%;
}
.width-27{
	width: 27%;
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

<div style = " margin: auto;">
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
				<span class="font-size-20 font-weight-bold" style = "background-color: <?php echo html_entity_decode($color); ?>; color: <?php echo html_entity_decode($color_black) ?>;">&nbsp;<?php echo app_lang('internal_delivery_note'); ?>&nbsp;</span>

				<div class="line-height-5"></div>
				<span class="font-weight-bold" >&nbsp;<?php echo '#'.$internal_delivery->internal_delivery_code; ?>&nbsp;</span>

				<div class="line-height-10"></div>
				<span><?php echo html_entity_decode($internal_delivery->internal_delivery_name); ?></span><br/>
				<span><?php echo app_lang("datecreated") . ": " . format_to_date($internal_delivery->date_add, false); ?></span>
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
		<th class="border-right-1-eee width-20 color-fff" > <?php echo app_lang("commodity_name"); ?></th>
		<th class="border-right-1-eee width-12 color-fff" > <?php echo app_lang("from_stock_name"); ?></th>
		<th class="border-right-1-eee width-12 color-fff" > <?php echo app_lang("to_stock_name"); ?></th>
		<th class="border-right-1-eee width-12 color-fff" > <?php echo app_lang("available_quantity"); ?></th>
		<th class="border-right-1-eee width-12 color-fff" > <?php echo app_lang("quantity_export"); ?></th>
		<th class="border-right-1-eee width-12 color-fff" > <?php echo app_lang("unit_price"); ?></th>
		<th class="border-right-1-eee width-15 color-fff" > <?php echo app_lang("into_money"); ?></th>
	</tr>
	<?php
	$warehouse_address 	= '';
	$array_warehouse	= [];
	$array_from_warehouse	= [];
	$array_to_warehouse	= [];

	foreach ($internal_delivery_details as $item_key => $item) {
		$flag_from_warehouse = true;
		$flag_to_warehouse   = true;

		$commodity_name = (isset($item) ? $item['commodity_name'] : '');
		$quantities = (isset($item) ? $item['quantities'] : '');
		$unit_price = (isset($item) ? $item['unit_price'] : '');
		$commodity_code = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->commodity_code : ''; 
		$commodity_name = get_commodity_name($item['commodity_code']) != null ? get_commodity_name($item['commodity_code'])->description : '';
		$unit_name = get_unit_type($item['unit_id']) != null ? get_unit_type($item['unit_id'])->unit_name : '';
		$into_money = (isset($item) ? $item['into_money'] : '');
		$commodity_name = $item['commodity_name'];
		if(strlen($commodity_name) == 0){
			$commodity_name = wh_get_item_variatiom($item['commodity_code']);
		}


		$from_stock_name ='';
		if(isset($item['from_stock_name']) && ($item['from_stock_name'] !='')){
			if(!in_array($item['from_stock_name'], $array_from_warehouse)){
				$array_from_warehouse[] = $item['from_stock_name'];
				$arr_warehouse = explode(',', $item['from_stock_name']);

				$str = '';
				if(count($arr_warehouse) > 0){

					foreach ($arr_warehouse as $wh_key => $warehouseid) {
						$str = '';
						if ($warehouseid != '' && $warehouseid != '0') {

							$team = get_warehouse_name($warehouseid);
							if($team){
								$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

								$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide"> </span></span>';

								$from_stock_name .= $str;
								if($wh_key%3 ==0){
									$from_stock_name .='<br/>';
								}

								//get warehouse address
								if(!in_array($warehouseid, $array_warehouse)){
									$warehouse_address .= '<b>' .$team->warehouse_name .' : </b>'. wh_get_warehouse_address($warehouseid) .'.'.'<br/>';
								}
							}

						}
					}

				} else {
					$from_stock_name = '';
				}
			}
		}

		$to_stock_name ='';
		if(isset($item['to_stock_name']) && ($item['to_stock_name'] !='')){
			if(!in_array($item['to_stock_name'], $array_to_warehouse)){
				$array_to_warehouse[] = $item['to_stock_name'];
				$arr_warehouse = explode(',', $item['to_stock_name']);

				$str = '';
				if(count($arr_warehouse) > 0){

					foreach ($arr_warehouse as $wh_key => $warehouseid) {
						$str = '';
						if ($warehouseid != '' && $warehouseid != '0') {

							$team = get_warehouse_name($warehouseid);
							if($team){
								$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

								$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide"> </span></span>';

								$to_stock_name .= $str;
								if($wh_key%3 ==0){
									$to_stock_name .='<br/>';
								}
								//get warehouse address
								if(!in_array($warehouseid, $array_warehouse)){
									$warehouse_address .= '<b>' .$team->warehouse_name .' : </b>'. wh_get_warehouse_address($warehouseid) .'.'.'<br/>';
								}
							}

						}
					}

				} else {
					$to_stock_name = '';
				}
			}
		}

		$get_from_stock_name = get_warehouse_name($item['from_stock_name']);
		$get_to_stock_name = get_warehouse_name($item['to_stock_name']);
		if($get_from_stock_name){
			$from_stock_name = $get_from_stock_name->warehouse_name;
		}
		if($get_to_stock_name){
			$to_stock_name = $get_to_stock_name->warehouse_name;
		}

		$key = $item_key+1;
		?>
		
		<tr class="background-color-f4f4f4" >
			<td class="text-align-right width-5 border-1-solid-fff" > <?php echo html_entity_decode($key); ?></td>
			<td class="width-20 border-1-solid-fff"><?php echo html_entity_decode($item['commodity_name']); ?></td>
			<td class="text-align-left width-12 border-1-solid-fff"> <?php echo html_entity_decode($from_stock_name); ?></td>
			<td class="text-align-left width-12 border-1-solid-fff"> <?php echo html_entity_decode($to_stock_name); ?></td>
			<td class="text-align-right width-12 border-1-solid-fff"> <?php echo html_entity_decode($item['available_quantity']); ?></td>
			<td class="text-align-right width-12 border-1-solid-fff"> <?php echo html_entity_decode($quantities.$unit_name); ?></td>
			<td  class="text-align-right width-12 border-1-solid-fff"> <?php echo to_currency((float)$unit_price); ?></td>
			<td class="text-align-right width-15 border-1-solid-fff"> <?php echo to_currency((float)$into_money); ?></td>
		</tr>

	<?php } ?>


	<tr>
		<td colspan="6" class="text-align-right" ><?php echo app_lang("total_amount"); ?></td>
		<td class="text-align-right width-27 border-1-solid-fff background-color-black">
			<span class="color-fff"><?php echo to_currency($internal_delivery->total_amount); ?></span>
		</td>
	</tr>
</table>

<h4 class="note-align"><?php echo app_lang('warehouse_address').': ' ?></h4>
<p><?php echo html_entity_decode($warehouse_address) ?></p>

<?php if (strlen($internal_delivery->description) > 0) { ?>
	<br />
	<br />
	<div class="border-top-2-f2f2f2 color-black padding-0-0-20-0" ><br /><?php echo nl2br($internal_delivery->description); ?></div>
<?php }  ?>
