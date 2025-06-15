<?php
$Clients_model = model("Models\Clients_model");

$aColumns = [
	'goods_delivery_id',
	'commodity_code',
	get_db_prefix() . 'goods_delivery.customer_code as customer_code',
	'quantities',
	'unit_price', 
	'expiry_date',
	'lot_number',
	'serial_number',
	'guarantee_period',
];
$sIndexColumn = 'id';
$sTable = get_db_prefix() . 'goods_delivery';

$where = [];

if(isset($dataPost['commodity_filter'])){
	$commodity_filter = $dataPost['commodity_filter'];
}
if(isset($dataPost['customer_name_filter'])){
	$customer_name_filter = $dataPost['customer_name_filter'];
}

if(isset($dataPost['to_date_filter'])){
	$to_date_filter = $dataPost['to_date_filter'];
}
if(isset($dataPost['status_filter'])){
	$status_filter = $dataPost['status_filter'];
}


$join= [
	'LEFT JOIN ' . get_db_prefix() . 'goods_delivery_detail as gdd ON gdd.goods_delivery_id = ' . get_db_prefix() . 'goods_delivery.id'
];

$where[] = 'AND guarantee_period is not null AND guarantee_period != ""';

if (isset($commodity_filter)) {
	$where_commodity_ft = '';
	foreach ($commodity_filter as $commodity_id) {
		if ($commodity_id != '') {
			if ($where_commodity_ft == '') {
				$where_commodity_ft .= ' AND (commodity_code = "' . $commodity_id . '"';
			} else {
				$where_commodity_ft .= ' or commodity_code = "' . $commodity_id . '"';
			}
		}
	}
	if ($where_commodity_ft != '') {
		$where_commodity_ft .= ')';
		array_push($where, $where_commodity_ft);
	}
}

if (isset($to_date_filter)) {
	array_push($where, "AND date_format(guarantee_period, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime(to_sql_date1($to_date_filter))) . "'");
}

if (isset($customer_name_filter)) {
	$where_customer_ft = '';
	foreach ($customer_name_filter as $client_id) {
		if ($client_id != '') {
			if ($where_customer_ft == '') {
				$where_customer_ft .= ' AND ('.get_db_prefix().'goods_delivery.customer_code = "' . $client_id . '"';
			} else {
				$where_customer_ft .= ' or '.get_db_prefix().'goods_delivery.customer_code = "' . $client_id . '"';
			}
		}
	}
	if ($where_customer_ft != '') {
		$where_customer_ft .= ')';
		array_push($where, $where_customer_ft);
	}
}

if (isset($status_filter) && $status_filter != '') {
	$status_arr = $status_filter;
	$status_ft = '';

	foreach ($status_arr as $value) {
		if($value == 1){
			if ($status_ft == '') {
				$status_ft .= " AND ( date_format(guarantee_period, '%Y-%m-%d') > '" . date('Y-m-d', strtotime(date('Y-m-d'))) . "'";
			}else{
				$status_ft .= " OR date_format(guarantee_period, '%Y-%m-%d') > '" . date('Y-m-d', strtotime(date('Y-m-d'))) . "'";
			}
		}elseif($value == 2){
			if ($status_ft == '') {
				$status_ft .= " AND ( date_format(guarantee_period, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime(date('Y-m-d'))) . "'";
			}else{
				$status_ft .= " OR date_format(guarantee_period, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime(date('Y-m-d'))) . "'";
			}
		}
	}
	if ($status_ft != '') {
		$status_ft .= ')';
		array_push($where, $status_ft);
	}
}

$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, ['unit_id', 'commodity_name', 'customer_code'], '', [], $dataPost);

$output = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
	$row = [];
	$text_color = '';
	if(strtotime($aRow['guarantee_period']) <= strtotime(date('Y-m-d'))){
		$text_color = 'text-danger';
	}

	$value = get_goods_delivery_code($aRow['goods_delivery_id']) != null ? get_goods_delivery_code($aRow['goods_delivery_id'])->goods_delivery_code : '';
	if($value != ''){
		$row[] = '<a href="' . site_url('warehouse/view_delivery/' . $aRow['goods_delivery_id']) . '" >'. $value.'</a>';
	}else{
		$row[] = '';
	}

	$company_name = '';
	if(is_numeric($aRow['customer_code']) && $aRow['customer_code'] != 0){
		$client_options = [
			'id' => $aRow['customer_code'],
		];
		$client = $Clients_model->get_details($client_options)->getRow();

		if($client){
			$company_name = $client->company_name;
		}

	}

	$row[] = $company_name;

	if(strlen($aRow['commodity_name']) == 0){
		$row[] = '<span class="'.$text_color.'">'. wh_get_item_variatiom($aRow['commodity_code']).'</span>';
	}else{
		$row[] = '<span class="'.$text_color.'">'.$aRow['commodity_name'].'</span>';
	}
	$row[] = '<span class="'.$text_color.'">'.$aRow['quantities'].' '.wh_get_unit_name($aRow['unit_id']).'</span>';
	$row[] = '<span class="'.$text_color.'">'.to_decimal_format((float)$aRow['unit_price']).'</span>';
	$row[] = '<span class="'.$text_color.'">'.$aRow['expiry_date'].'</span>';
	$row[] = '<span class="'.$text_color.'">'.$aRow['lot_number'].'</span>';
	$row[] = '<span class="'.$text_color.'">'.$aRow['serial_number'].'</span>';
	$row[] ='<span class="'.$text_color.'">'. format_to_date($aRow['guarantee_period']).'</span>';

	$output['aaData'][] = $row;
}

