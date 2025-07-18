<?php

use App\Controllers\Security_Controller;
use App\Controllers\App_Controller;

$Warehouse_model = model("Warehouse\Models\Warehouse_model");
$Taxes_model = model("Models\Taxes_model");

$arr_inventory_min_data = $Warehouse_model->arr_inventory_min(false);
$filter_arr_inventory_min_max = $Warehouse_model->filter_arr_inventory_min_max();
$arr_inventory_min_id = $filter_arr_inventory_min_max['inventory_min'];
$arr_inventory_max_id = $filter_arr_inventory_min_max['inventory_max'];

$aColumns = [
	'1',
	get_db_prefix() . 'items.id',
	'commodity_code',
	get_db_prefix() . 'items.title',
	'sku_code',
	get_db_prefix() . 'item_categories.title as group_name',
	get_db_prefix() . 'items.warehouse_id',
	
	'commodity_barcode',
	'unit_id',
	'rate',
	'purchase_price',
	't1.percentage as taxrate_1',
    't2.percentage as taxrate_2',
	'origin',
	'2',	//minimum stock
	'3',	//maximum stock
	'4',	//maximum stock
];
$sIndexColumn = 'id';
$sTable = get_db_prefix() . 'items';

$where = [];
$where[] = 'AND '.get_db_prefix().'items.deleted = 0';

if(isset($dataPost['warehouse_ft'])){
	$warehouse_ft = $dataPost['warehouse_ft'];
}

if(isset($dataPost['commodity_ft'])){
	$commodity_ft = $dataPost['commodity_ft'];
}
if(isset($dataPost['alert_filter'])){
	$alert_filter = $dataPost['alert_filter'];
}

if(isset($dataPost['filter_all_simple_variation'])){
	$filter_all_simple_variation = $dataPost['filter_all_simple_variation'];
}
if(isset($dataPost['show_items_filter'])){
	$show_items_filter = $dataPost['show_items_filter'];
}

$join = [
	'LEFT JOIN ' . get_db_prefix() . 'taxes t1 ON t1.id = ' . get_db_prefix() . 'items.tax',
	'LEFT JOIN ' . get_db_prefix() . 'taxes t2 ON t2.id = ' . get_db_prefix() . 'items.tax2',
	'LEFT JOIN ' . get_db_prefix() . 'item_categories ON ' . get_db_prefix() . 'item_categories.id = ' . get_db_prefix() . 'items.category_id',
];


if(isset($filter_all_simple_variation) && $filter_all_simple_variation == 'true'){
	$filter_all_simple_variation_flag = ' OR true';
}elseif(isset($filter_all_simple_variation) && $filter_all_simple_variation == 'false'){
	$filter_all_simple_variation_flag = '';
}else{
	$filter_all_simple_variation_flag = '';
}

$where[] = 'AND ('  .get_db_prefix().'items.parent_id is null OR  '.get_db_prefix().'items.parent_id = 0 OR  '.get_db_prefix().'items.parent_id = "" '.$filter_all_simple_variation_flag.' )  ';


if (isset($warehouse_ft)) {
	$arr_commodity_id = $Warehouse_model->get_commodity_in_warehouse($warehouse_ft);
	if(count($arr_commodity_id) > 0){
		$where[] = 'AND '.get_db_prefix().'items.id IN (' . implode(', ', $arr_commodity_id) . ')';
	}else{
		$where[] = 'AND '.get_db_prefix().'items.id IN (0)';
	}
}

if (isset($commodity_ft)) {
	$where_commodity_ft = '';
	foreach ($commodity_ft as $commodity_id) {
		if ($commodity_id != '') {
			if ($where_commodity_ft == '') {
				$where_commodity_ft .= 'AND ('.get_db_prefix().'items.id = "' . $commodity_id . '"';
			} else {
				$where_commodity_ft .= ' or '.get_db_prefix().'items.id = "' . $commodity_id . '"';
			}
		}
	}
	if ($where_commodity_ft != '') {
		$where_commodity_ft .= ')';
		array_push($where, $where_commodity_ft);
	}
}

if (isset($show_items_filter)) {
	if(count($show_items_filter) == 1 ){
		if((int)$show_items_filter[0] == 1){
			//add serial numbers for items
			// get item need add: parent item and variation item
			$where[] = "AND (
			select sum(inventory_number) from ".get_db_prefix()."inventory_manage as iv
			where iv.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id  )
			) > (
			select count(id) from ".get_db_prefix()."wh_inventory_serial_numbers as snm
			where snm.is_used = 'no' AND snm.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id )
			) ";
			
		}elseif((int)$show_items_filter[0] == 2){
			//update serial numbers for items
			// get item need update: parent item and variation item
			$where[] = "AND (
			select sum(inventory_number) from ".get_db_prefix()."inventory_manage as iv
			where iv.inventory_number > 0 AND  iv.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id  )
			) = (
			select count(id) from ".get_db_prefix()."wh_inventory_serial_numbers as snm
			where snm.is_used = 'no' AND snm.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id )
			) ";

		}
	}else{
		$where[] = "AND ((
			select sum(inventory_number) from ".get_db_prefix()."inventory_manage as iv
			where iv.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id   )
			) > (
			select count(id) from ".get_db_prefix()."wh_inventory_serial_numbers as snm
			where snm.is_used = 'no' AND snm.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id )
			) OR (
			select sum(inventory_number) from ".get_db_prefix()."inventory_manage as iv
			where iv.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id  )
			) = (
			select count(id) from ".get_db_prefix()."wh_inventory_serial_numbers as snm
			where snm.is_used = 'no' AND snm.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id = ".get_db_prefix()."items.id OR tem_items.id = ".get_db_prefix()."items.id )
			) ) ";
	}
}

//only show item can be inventory
$where_can_be_ft = '';
if ($where_can_be_ft == '') {
	$where_can_be_ft .= 'AND ('.get_db_prefix().'items.can_be_inventory = "can_be_inventory"';
} else {
	$where_can_be_ft .= ' or '.get_db_prefix().'items.can_be_inventory = "can_be_inventory"';
}
if ($where_can_be_ft != '') {
	$where_can_be_ft .= ')';
	array_push($where, $where_can_be_ft);
}


$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, [get_db_prefix() . 'items.id', get_db_prefix() . 'items.description', get_db_prefix() . 'items.unit_id', get_db_prefix() . 'items.commodity_code', get_db_prefix() . 'items.commodity_barcode', get_db_prefix() . 'items.commodity_type', get_db_prefix() . 'items.warehouse_id', get_db_prefix() . 'items.origin', get_db_prefix() . 'items.color_id', get_db_prefix() . 'items.style_id', get_db_prefix() . 'items.model_id', get_db_prefix() . 'items.size_id', get_db_prefix() . 'items.rate', get_db_prefix() . 'items.tax', get_db_prefix() . 'items.category_id', get_db_prefix() . 'items.sku_code', get_db_prefix() . 'items.sku_name', get_db_prefix() . 'items.sub_group', get_db_prefix() . 'items.color', get_db_prefix() . 'items.guarantee', get_db_prefix().'items.profif_ratio', get_db_prefix().'items.without_checking_warehouse', get_db_prefix().'items.parent_id', get_db_prefix().'items.tax2', 
	get_db_prefix().'items.can_be_sold', get_db_prefix().'items.can_be_purchased', get_db_prefix().'items.can_be_manufacturing', get_db_prefix().'items.can_be_inventory', 'files'], '', [], $dataPost);

$output = $result['output'];
$rResult = $result['rResult'];

$arr_tax_rate = [];
$tax_options = array(
	"deleted" => 0,
);
$get_tax_rate = $Taxes_model->get_details($tax_options)->getResultArray();
foreach ($get_tax_rate as $key => $value) {
    $arr_tax_rate[$value['id']] = $value;
}

$arr_images = [];
$arr_inventory_min = $arr_inventory_min_data;
$arr_warehouse_by_item = $Warehouse_model->arr_warehouse_by_item();
$arr_warehouse_id = $Warehouse_model->arr_warehouse_id();
$arr_unit_id = [];
$get_unit_type = $Warehouse_model->get_unit_type();
foreach ($get_unit_type as $key => $value) {
   $arr_unit_id[$value['unit_type_id']] = $value;
}
$inventory_min = $Warehouse_model->arr_inventory_min(true);
$arr_inventory_number = $Warehouse_model->arr_inventory_number_by_item();
$item_have_variation = $Warehouse_model->arr_item_have_variation();


	foreach ($rResult as $aRow) {
		$product_inventory_quantity = 0;
		$row = [];
		for ($i = 0; $i < count($aColumns); $i++) {

			 if (strpos($aColumns[$i], 'as') !== false && !isset($aRow[$aColumns[$i]])) {
	            $_data = $aRow[strafter($aColumns[$i], 'as ')];
	        } else {
				$_data = $aRow[$aColumns[$i]];
	        }


			/*get commodity file*/
			if($aColumns[$i] == get_db_prefix() . 'items.id'){
				if ($aRow['files']){
					$files = unserialize($aRow['files']);

					if (count($files)) {

						$timeline_file_path = get_setting("timeline_file_path");
						foreach ($files as $file_key => $file) {
							if($file_key == 0){
								$file_name = get_array_value($file, "file_name");
								$thumbnail = get_source_url_of_file($file, $timeline_file_path, "thumbnail");
								if (is_viewable_image_file($file_name)) {
									$_data = "<img class='sortable-file images_w_table' src='".$thumbnail."' alt='".$file_name."'/>";

								} else {
									$_data = get_file_icon(strtolower(pathinfo($file_name, PATHINFO_EXTENSION)));
								}
							}
						}
					}else{
						$thumbnail = get_file_uri('plugins/Warehouse/Uploads/nul_image.jpg');
						$_data = "<img class='sortable-file images_w_table' src='".$thumbnail."' alt='null_image'/>";
					}
				}
			}

			if ($aColumns[$i] == 'commodity_code') {
				$code = '<a href="' . site_url('warehouse/view_commodity_detail/' . $aRow['id']) . '">' . $aRow['commodity_code'] . '</a>';
				$_data = $code;

			}elseif($aColumns[$i] == '1'){
				$_data = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"  class="form-check-input"><label></label></div>';
			} elseif ($aColumns[$i] == get_db_prefix().'item.title') {

				if (isset($arr_inventory_min[$aRow['id']]) && $arr_inventory_min[$aRow['id']] == true) {
					$_data = '<a href="javascript:void(0)" class="text-danger"   data-name="' . $aRow[get_db_prefix().'item.title'] . '" data-warehouse_id="' . $aRow['warehouse_id'] . '" data-commodity_id="' . $aRow['id'] . '"  >' . $aRow[get_db_prefix().'item.title'] . '</a>';
				} else {

					$_data = '<a href="javascript:void(0)"  data-name="' . $aRow[get_db_prefix().'item.title'] . '"  data-commodity_id="' . $aRow['id'] . '"  >' . $aRow[get_db_prefix().'item.title'] . '</a>';
				}

			}elseif($aColumns[$i] == 'sku_code'){
				$_data = '<span class="badge bg-secondary large mt-0">' . $aRow['sku_code'] . '</span>';
			} elseif ($aColumns[$i] == 'group_name') {
				$_data = $aRow['group_name'];

			} elseif ($aColumns[$i] == get_db_prefix() . 'items.warehouse_id') {
				$_data ='';

				if(isset($item_have_variation[$aRow['id']]) && (float)$item_have_variation[$aRow['id']]['total_child'] > 0 ){

					$arr_warehouse = get_inventory_by_warehouse_variation($aRow['id']);

					$str = '';
					if(count($arr_warehouse) > 0){
						foreach ($arr_warehouse as $wh_key => $warehouseid) {
							$str = '';
							if ($warehouseid['warehouse_id'] != '' && $warehouseid['warehouse_id'] != '0') {
								//get inventory quantity
								$quantity_by_warehouse = $warehouseid['inventory_number'];
								$product_inventory_quantity += $quantity_by_warehouse;
								$team = get_warehouse_name($warehouseid['warehouse_id']);
								if($team){
									$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

									$str .= '<span class="badge bg-success large mt-0">' . $value . ': ( '.$quantity_by_warehouse.' )</span>';

									$_data .= $str;
									if($wh_key%3 ==0){
										$_data .='<br/>';
									}
								}

							}
						}

					} else {
						$_data = '';
					}


				}else{


					$str = '';
					if(isset($arr_warehouse_by_item[$aRow['id']]) > 0){
						foreach ($arr_warehouse_by_item[$aRow['id']] as $wh_key => $warehouse_value) {
							$str = '';
							if ($warehouse_value['warehouse_id'] != '' && $warehouse_value['warehouse_id'] != '0') {
								//get inventory quantity
								$quantity_by_warehouse = $warehouse_value['inventory_number'];
								$product_inventory_quantity += $quantity_by_warehouse;
								if(isset($arr_warehouse_id[$warehouse_value['warehouse_id']])){

									$str .= '<span class="badge bg-success large mt-0">' . $arr_warehouse_id[$warehouse_value['warehouse_id']]['warehouse_name'] . ': ( '.$quantity_by_warehouse.' )</span>';

									$_data .= $str;
									if($wh_key%3 ==0){
										$_data .='<br/>';
									}
								}

							}
						}

					} else {
						$_data = '';
					}
				}
			} elseif ($aColumns[$i] == 'unit_id') {
				if ($aRow['unit_id'] != null) {
					if(isset($arr_unit_id[$aRow['unit_id']])){
						$_data = $arr_unit_id[$aRow['unit_id']]['unit_name'];
					}else{
						$_data = '';
					}
				} else {
					$_data = '';
				}
			} elseif ($aColumns[$i] == 'rate') {
				$_data = to_decimal_format((float) $aRow['rate']);
			} elseif ($aColumns[$i] == 'purchase_price') {
				$_data = to_decimal_format((float) $aRow['purchase_price']);

			} elseif ($aColumns[$i] == 'taxrate_1') {

				$aRow['taxrate_1'] = $aRow['taxrate_1'] ?? 0;
				$_data             = '<span data-toggle="tooltip" title="' . $aRow['taxname_1'] . '" data-taxid="' . $aRow['tax_id_1'] . '">' . app_format_number($aRow['taxrate_1']) . '%' . '</span>';

			} elseif ($aColumns[$i] == 'taxrate_2') {
				$aRow['taxrate_2'] = $aRow['taxrate_2'] ?? 0;
				$_data             = '<span data-toggle="tooltip" title="' . $aRow['taxname_2'] . '" data-taxid="' . $aRow['tax_id_2'] . '">' . app_format_number($aRow['taxrate_2']) . '%' . '</span>';

			} elseif ($aColumns[$i] == 'commodity_barcode') {
				/*inventory number*/
				$inventory_number = 0;

        		if(isset($arr_inventory_number[$aRow['id']])){
        			$inventory_number =  $arr_inventory_number[$aRow['id']]['inventory_number'];
        		}
				$_data = $product_inventory_quantity;

			} elseif ($aColumns[$i] == 'origin') {

        		if (isset($arr_inventory_min[$aRow['id']]) && $arr_inventory_min[$aRow['id']]) {
					$_data = '<span class="label label-tag tag-id-1 label-tabus "><span class="tag text-danger">' . _l('unsafe_inventory') . '</span><span class="hide">, </span></span>&nbsp';
				} else {
					$_data = '';
				}

			} elseif ($aColumns[$i] == '2') {
				/*3: minmumstock, maximum stock*/
				$minmumstock = '';

				if(isset($inventory_min[$aRow['id']])){
					$minmumstock .= $inventory_min[$aRow['id']]['inventory_number_min'] ;
				}

				$_data =  $minmumstock;

			}elseif ($aColumns[$i] == '3') {
				/*3: minmumstock, maximum stock*/
				$maxmumstock = '';

				if(isset($inventory_min[$aRow['id']])){
					$maxmumstock .= $inventory_min[$aRow['id']]['inventory_number_max'] ;
				}

				$_data = $maxmumstock;

			}elseif($aColumns[$i] == '4') {
				//final price: price*Vat
				$tax_value=0;
				if($aRow['tax'] != 0 && $aRow['tax'] != ''){
					if(isset($arr_tax_rate[$aRow['tax']])){
						$tax_value = $arr_tax_rate[$aRow['tax']]['percentage'];
					}
				}

				if($aRow['tax2'] != 0 && $aRow['tax2'] != ''){
					if(isset($arr_tax_rate[$aRow['tax2']])){
						$tax_value += (float)$arr_tax_rate[$aRow['tax2']]['percentage'];
					}
				}

				$_data = to_decimal_format((float)$aRow['rate'] + (float)$aRow['rate']*$tax_value/100);
				
			}


			$row[] = $_data;

		}
		$output['aaData'][] = $row;
	}

