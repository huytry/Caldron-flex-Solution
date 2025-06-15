<?php


$aColumns = [
	get_db_prefix().'goods_transaction_detail.id',
	'goods_receipt_id',
	'commodity_id',
	get_db_prefix().'goods_transaction_detail.warehouse_id',
	get_db_prefix().'goods_transaction_detail.date_add',
	'old_quantity',
	'quantity',
	'lot_number',
	get_db_prefix().'goods_transaction_detail.expiry_date',
	get_db_prefix().'goods_transaction_detail.serial_number',
	'note',
	get_db_prefix().'goods_transaction_detail.status',
];
$sIndexColumn = 'id';
$sTable       = get_db_prefix().'goods_transaction_detail';

$where = [];

if(isset($dataPost['warehouse_ft'])){
	$warehouse_ft = $dataPost['warehouse_ft'];
}
if(isset($dataPost['commodity_ft'])){
	$commodity_ft = $dataPost['commodity_ft'];
}
if(isset($dataPost['status_ft'])){
	$status_ft = $dataPost['status_ft'];
}


$join =[
	'LEFT JOIN '.get_db_prefix().'goods_receipt ON '.get_db_prefix().'goods_receipt.id = '.get_db_prefix().'goods_transaction_detail.goods_receipt_id AND  '.get_db_prefix().'goods_transaction_detail.status = 1',
	'LEFT JOIN '.get_db_prefix().'goods_delivery ON '.get_db_prefix().'goods_delivery.id = '.get_db_prefix().'goods_transaction_detail.goods_receipt_id AND  '.get_db_prefix().'goods_transaction_detail.status = 2',
	'LEFT JOIN '.get_db_prefix().'wh_loss_adjustment ON '.get_db_prefix().'wh_loss_adjustment.id = '.get_db_prefix().'goods_transaction_detail.goods_receipt_id AND  '.get_db_prefix().'goods_transaction_detail.status = 3',
	'LEFT JOIN '.get_db_prefix().'internal_delivery_note ON '.get_db_prefix().'internal_delivery_note.id = '.get_db_prefix().'goods_transaction_detail.goods_receipt_id AND  '.get_db_prefix().'goods_transaction_detail.status = 4'
];



if(isset($warehouse_ft)){

	$where_warehouse_ft = '';
	foreach ($warehouse_ft as $warehouse_id) {
		if($warehouse_id != '')
		{

			if ($where_warehouse_ft == '') {
				$where_warehouse_ft .= ' AND (find_in_set('.$warehouse_id.', '.get_db_prefix().'goods_transaction_detail.warehouse_id) or find_in_set('.$warehouse_id.', '.get_db_prefix().'goods_transaction_detail.from_stock_name) or find_in_set('.$warehouse_id.', '.get_db_prefix().'goods_transaction_detail.to_stock_name) ';

			} else {
				$where_warehouse_ft .= ' or find_in_set('.$warehouse_id.', '.get_db_prefix().'goods_transaction_detail.warehouse_id) or find_in_set('.$warehouse_id.', '.get_db_prefix().'goods_transaction_detail.from_stock_name) or find_in_set('.$warehouse_id.', '.get_db_prefix().'goods_transaction_detail.to_stock_name) ';

			}

		}
	}
	if($where_warehouse_ft != '')
	{
		$where_warehouse_ft .= ')';

		array_push($where, $where_warehouse_ft);
	}
}


if(isset($commodity_ft)){
	if(!is_array($commodity_ft)){
		$where_commodity_ft = ' AND '.get_db_prefix().'goods_transaction_detail.commodity_id = "'.$commodity_ft.'"';
		array_push($where, $where_commodity_ft);

	}else{

		$where_commodity_ft = '';
		foreach ($commodity_ft as $commodity_id) {
			if($commodity_id != '')
			{
				if($where_commodity_ft == ''){
					$where_commodity_ft .= ' AND ('.get_db_prefix().'goods_transaction_detail.commodity_id = "'.$commodity_id.'"';
				}else{
					$where_commodity_ft .= ' or '.get_db_prefix().'goods_transaction_detail.commodity_id = "'.$commodity_id.'"';
				}
			}
		}
		if($where_commodity_ft != '')
		{
			$where_commodity_ft .= ')';

			array_push($where, $where_commodity_ft);
		}
	}

}

if(isset($status_ft)){

	$where_status_ft = '';
	foreach ($status_ft as $status_id) {
		if($status_id != '')
		{
			if($where_status_ft == ''){
				$where_status_ft .= ' AND ('.get_db_prefix().'goods_transaction_detail.status = "'.$status_id.'"';
			}else{
				$where_status_ft .= ' or '.get_db_prefix().'goods_transaction_detail.status = "'.$status_id.'"';
			}
		}
	}
	if($where_status_ft != '')
	{
		$where_status_ft .= ')';

		array_push($where, $where_status_ft);
	}
}

if(isset($dataPost['validity_start_date'])){
	$start_date = to_sql_date1($dataPost['validity_start_date']);
}

if(isset($dataPost['validity_end_date'])){
	$end_date = to_sql_date1($dataPost['validity_end_date']);
}

if(isset($start_date) && isset($end_date)){


	array_push($where, ' AND ( (date_format('.get_db_prefix().'goods_receipt.date_add,"%Y-%m-%d") BETWEEN "'.$start_date.'" AND "'.$end_date.'") OR (date_format('.get_db_prefix().'goods_delivery.date_add,"%Y-%m-%d") BETWEEN "'.$start_date.'" AND "'.$end_date.'") OR (date_format('.get_db_prefix().'internal_delivery_note.date_add,"%Y-%m-%d") BETWEEN "'.$start_date.'" AND "'.$end_date.'") OR (date_format('.get_db_prefix().'wh_loss_adjustment.date_create,"%Y-%m-%d") BETWEEN "'.$start_date.'" AND "'.$end_date.'") )');



}elseif(isset($start_date) && !isset($end_date)){

	array_push($where, ' AND ( (date_format('.get_db_prefix().'goods_receipt.date_add,"%Y-%m-%d") >= "'.$start_date.'" ) OR (date_format('.get_db_prefix().'goods_delivery.date_add,"%Y-%m-%d") >= "'.$start_date.'") OR (date_format('.get_db_prefix().'internal_delivery_note.date_add,"%Y-%m-%d") >= "'.$start_date.'") OR (date_format('.get_db_prefix().'wh_loss_adjustment.date_create,"%Y-%m-%d") >= "'.$start_date.'"))');


}elseif(!isset($start_date) && isset($end_date)){

	array_push($where, ' AND ( (date_format('.get_db_prefix().'goods_receipt.date_add,"%Y-%m-%d") <= "'.$end_date.'" ) OR (date_format('.get_db_prefix().'goods_delivery.date_add,"%Y-%m-%d") <= "'.$end_date.'") OR (date_format('.get_db_prefix().'internal_delivery_note.date_add,"%Y-%m-%d") <= "'.$end_date.'") OR (date_format('.get_db_prefix().'wh_loss_adjustment.date_create,"%Y-%m-%d") <= "'.$end_date.'"))');

}



$result  = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, [get_db_prefix().'goods_transaction_detail.id',get_db_prefix().'goods_transaction_detail.old_quantity',get_db_prefix().'goods_transaction_detail.from_stock_name',get_db_prefix().'goods_transaction_detail.to_stock_name',get_db_prefix().'goods_receipt.date_add as 1_date_add',get_db_prefix().'goods_delivery.date_add as 2_date_add',get_db_prefix().'internal_delivery_note.date_add as 4_date_add',get_db_prefix().'wh_loss_adjustment.date_create as 3_date_add', get_db_prefix().'goods_transaction_detail.date_add as opening_stock_date_add'], '', [], $dataPost);


$output  = $result['output'];
$rResult = $result['rResult'];



foreach ($rResult as $aRow) {
	$row = [];


	$row[] = $aRow['id'];

	if($aRow[get_db_prefix().'goods_transaction_detail.status'] == 1){

		$value = get_goods_receipt_code($aRow['goods_receipt_id']) != null ? get_goods_receipt_code($aRow['goods_receipt_id'])->goods_receipt_code : '';

		if($value != ''){
			$row[] = '<a href="' . site_url('warehouse/goods_receipt_detail/' . $aRow['goods_receipt_id']) . '" >'. $value.'</a>';
		}else{
			$row[] = '';
		}



	}elseif($aRow[get_db_prefix().'goods_transaction_detail.status'] == 2){

		$value = get_goods_delivery_code($aRow['goods_receipt_id']) != null ? get_goods_delivery_code($aRow['goods_receipt_id'])->goods_delivery_code : '';

		if($value != ''){
			$row[] = '<a href="' . site_url('warehouse/view_delivery/' . $aRow['goods_receipt_id']) . '" >'. $value.'</a>';
		}else{
			$row[] = '';
		}


	}elseif($aRow[get_db_prefix().'goods_transaction_detail.status'] == 4){

		$value = get_internal_delivery_code($aRow['goods_receipt_id']) != null ? get_internal_delivery_code($aRow['goods_receipt_id'])->internal_delivery_code : '';

		if($value != ''){
			$row[] = '<a href="' . site_url('warehouse/view_internal_delivery/' . $aRow['goods_receipt_id']) . '" >'. $value.'</a>';
		}else{
			$row[] = '';
		}


	}else{
			//3 lost adjustment
		$value = "LA#".$aRow['goods_receipt_id'];

		if($value != ''){
			$row[] = '<a href="' . site_url('warehouse/view_lost_adjustment/' . $aRow['goods_receipt_id']) . '" >'. $value.'</a>';
		}else{
			$row[] = '';
		}
	}    

	$row[] = wh_get_item_variatiom($aRow['commodity_id']);

	$warehouse_name ='';
	$warehouse_code ='';

	if($aRow[get_db_prefix().'goods_transaction_detail.status'] == 4){

		$str_code = '';
		$str = '';
		if ($aRow['from_stock_name'] != '' && $aRow['from_stock_name'] != '0') {

			$team = get_warehouse_name($aRow['from_stock_name']);
			if($team){
				$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

				$value_code = $team != null ? get_object_vars($team)['warehouse_code'] : '';

				$str .= 'From: <span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide">, </span></span>&nbsp';

				$str_code .= 'From: <span class="label label-tag tag-id-1"><span class="tag">' . $value_code . '</span><span class="hide">, </span></span>&nbsp';

				$warehouse_name .= $str;
				$warehouse_code .= $str_code;

				$warehouse_name .='<br/>';
				$warehouse_code .='<br/>';
			}

		}

		$str_code = '';
		$str = '';
		if ($aRow['to_stock_name'] != '' && $aRow['to_stock_name'] != '0') {

			$team1 = get_warehouse_name($aRow['to_stock_name']);
			if($team1){
				$value1 = $team1 != null ? get_object_vars($team1)['warehouse_name'] : '';

				$value_code1 = $team1 != null ? get_object_vars($team1)['warehouse_code'] : '';

				$str .= '- To: <span class="label label-tag tag-id-1"><span class="tag">' . $value1 . '</span><span class="hide">, </span></span>&nbsp';

				$str_code .= '- To: <span class="label label-tag tag-id-1"><span class="tag">' . $value_code1 . '</span><span class="hide">, </span></span>&nbsp';

				$warehouse_name .= $str;
				$warehouse_code .= $str_code;


			}

		}


	}else{

		$str_code = '';
		$str = '';

		if(isset($aRow[get_db_prefix().'goods_transaction_detail.warehouse_id']) && ($aRow[get_db_prefix().'goods_transaction_detail.warehouse_id'] !='')){
			$arr_warehouse = explode(',', $aRow[get_db_prefix().'goods_transaction_detail.warehouse_id']);

			if(count($arr_warehouse) > 0){

				foreach ($arr_warehouse as $wh_key => $warehouseid) {
					$str_code = '';
					$str = '';
					if ($warehouseid != '' && $warehouseid != '0') {

						$team = get_warehouse_name($warehouseid);
						if($team){
							$value = $team != null ? get_object_vars($team)['warehouse_name'] : '';

							$value_code = $team != null ? get_object_vars($team)['warehouse_code'] : '';

							$str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide">, </span></span>&nbsp';

							$str_code .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value_code . '</span><span class="hide">, </span></span>&nbsp';

							$warehouse_name .= $str;
							$warehouse_code .= $str_code;

							if($wh_key%3 ==0){
								$warehouse_name .='<br/>';
								$warehouse_code .='<br/>';
							}
						}

					}
				}

			} else {
				$warehouse_name = '';
				$warehouse_code = '';
			}
		}
	}


	$row[] = $warehouse_code;
	$row[] = $warehouse_name;

	if($aRow['goods_receipt_id'] == 0){

		$row[] = format_to_date(date('Y-m-d', strtotime($aRow['opening_stock_date_add'])), false); 
	}else{
		$row[] = format_to_date($aRow[$aRow[get_db_prefix().'goods_transaction_detail.status'].'_date_add'], false); 
	}


	switch ($aRow[get_db_prefix().'goods_transaction_detail.status']) {
		case 1:
					 //stock_import
		$row[] = $aRow['old_quantity']; 
		break;
		case 2:
					 //stock_export
		$row[] = (float)$aRow['old_quantity']+ (float)$aRow['quantity'];
		break;
		case 3:
					 //lost adjustment
		$row[] = $aRow['old_quantity']; 
		break;
		case 4:
					 //internal_delivery_note
		$row[] = $aRow['old_quantity'];
		break;

	} 



		//update view old quantity, new quantity
	if($aRow['old_quantity'] != null && $aRow['old_quantity'] != ''){
		switch ($aRow[get_db_prefix().'goods_transaction_detail.status']) {
			case 1:
					 //stock_import
			$row[] = (float)$aRow['old_quantity'] + (float)$aRow['quantity'];

			break;
			case 2:
					 //stock_export
			$row[] = (float)$aRow['old_quantity'];
			break;
			case 3:
					 //lost adjustment
			$row[] = $aRow['quantity'];
			break;
			case 4:
					 //internal_delivery_note
			$row[] = to_decimal_format((float)$aRow['old_quantity'] - (float)$aRow['quantity']);
			break;
		} 

	}else{
		$row[] = $aRow['quantity'];
	}



	$lot_number ='';
	if(($aRow['lot_number'] != null) && ( $aRow['lot_number'] != '') ){
		$array_lot_number = explode(',', $aRow['lot_number']);
		foreach ($array_lot_number as $key => $lot_value) {

			if($key%2 ==0){
				$lot_number .= $lot_value;
			}else{
				$lot_number .= ' : '.$lot_value.' ';
			}

		}
	}



	$row[] = $lot_number;

	$expiry_date ='';
	if(($aRow[get_db_prefix().'goods_transaction_detail.expiry_date'] != null) && ( $aRow[get_db_prefix().'goods_transaction_detail.expiry_date'] != '') ){
		$array_expiry_date = explode(',', $aRow[get_db_prefix().'goods_transaction_detail.expiry_date']);
		foreach ($array_expiry_date as $key => $expiry_date_value) {

			if($key%2 ==0){
				$expiry_date .= format_to_date($expiry_date_value, false);
			}else{
				$expiry_date .= ' : '.$expiry_date_value.' ';
			}

		}
	}

	$row[] = $expiry_date;

	/*get frist 100 character */
	if (strlen($aRow[get_db_prefix().'goods_transaction_detail.serial_number']) > 40) {
		$pos = strpos($aRow[get_db_prefix().'goods_transaction_detail.serial_number'], ' ', 40);
		$description_sub = substr($aRow[get_db_prefix().'goods_transaction_detail.serial_number'], 0, $pos).'...';
	} else {
		$description_sub = $aRow[get_db_prefix().'goods_transaction_detail.serial_number'];
	}

	$row[] = '<span class="pull-left" title="'. str_replace(',', ', ', $aRow[get_db_prefix().'goods_transaction_detail.serial_number']).'">'.$description_sub.'</span>';

	$row[] = $aRow['note'];
	switch ($aRow[get_db_prefix().'goods_transaction_detail.status']) {
		case 1:
		$row[] = app_lang('stock_import');
		break;
		case 2:
		$row[] = app_lang('stock_export');
		break;
		case 3:
		$row[] = app_lang('loss_adjustment');
		break;
		case 4:
		$row[] = app_lang('internal_delivery_note');
		break;
	}  


	$output['aaData'][] = $row;

}

