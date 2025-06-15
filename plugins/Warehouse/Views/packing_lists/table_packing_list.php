<?php

$Clients_model = model("Models\Clients_model");

$aColumns = [
	'id',
	'packing_list_number',
	'clientid',
	'width',
	'volume',
	'total_amount',
	'discount_total',
	'total_after_discount',
	'datecreated',
	'approval',
	'delivery_status',
	'5',
];
$sIndexColumn = 'id';
$sTable       = get_db_prefix().'wh_packing_lists';
$join         = [ ];

$where = [];

if (isset($dataPost['from_date'])) {
	array_push($where, "AND date_format(datecreated, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime(to_sql_date1($dataPost['from_date']))) . "'");
}

if (isset($dataPost['to_date'])) {
	array_push($where, "AND date_format(datecreated, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime(to_sql_date1($dataPost['to_date']))) . "'");
}
if (isset($dataPost['staff_id']) && isset($dataPost['staff_id']) != '') {
	array_push($where, 'AND staff_id IN (' . implode(', ', $dataPost['staff_id']) . ')');
}

if (isset($dataPost['status_id']) && isset($dataPost['status_id']) != '') {
	$status_arr = $dataPost['status_id'];
	if(in_array(5, $dataPost['status_id'])){
		$status_arr[] = 0;
	}
	array_push($where, 'AND approval IN (' . implode(', ', $status_arr) . ')');

}

if (isset($dataPost['delivery_id']) && isset($dataPost['delivery_id']) != '') {
	array_push($where, 'AND delivery_note_id IN (' . implode(', ', $dataPost['delivery_id']) . ')');
}

$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, ['id', 'packing_list_name', 'width', 'height', 'lenght', 'volume', 'additional_discount'], '', [], $dataPost);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
	$row = [];

	$row[] = $aRow['id'];

	$name = '<a href="' . site_url('warehouse/view_packing_list/' . $aRow['id'] ).'" >' . $aRow['packing_list_number'] .' - '.$aRow['packing_list_name']. '</a>';

	$row[] = $name;

	$company_name = '';
	$client_options = [
		'id' => $aRow['clientid'],
	];
	$client = $Clients_model->get_details($client_options)->getRow();
	if($client){
		$company_name = $client->company_name;
	}

	$row[] = $company_name;
	$row[] = $aRow['width'].' x '.$aRow['height'].' x '.$aRow['lenght'];
	$row[] = to_decimal_format($aRow['volume']);
	$row[] = to_decimal_format($aRow['total_amount']);
	$row[] = to_decimal_format($aRow['discount_total']+$aRow['additional_discount']);
	$row[] = to_decimal_format($aRow['total_after_discount']);
	$row[] = format_to_datetime($aRow['datecreated'], false);

	$approve_data = '';
	if($aRow['approval'] == 1){
		$approve_data = '<span class="badge bg-info large mt-0">'._l('approved').'</span>';
	}elseif($aRow['approval'] == 0){
		$approve_data = '<span class="badge bg-primary large mt-0">'._l('not_yet_approve').'</span>';
	}elseif($aRow['approval'] == -1){
		$approve_data = '<span class="badge bg-danger large mt-0">'._l('reject').'</span>';
	}

	$row[] = $approve_data;

	$row[] = render_delivery_status_html($aRow['id'], 'packing_list', $aRow['delivery_status']);

	/*Option*/
	$view = '<li role="presentation"><a href="' . site_url('warehouse/view_packing_list/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="eye" class="icon-16"></span> ' . _l('view') . '</a></li>';

	$edit = '';
	if((has_permission('warehouse', '', 'edit') || is_admin()) && ($aRow['approval'] == 0)){
		$edit = '<li role="presentation"><a href="' . site_url('warehouse/packing_list/' . $aRow['id'] ) .'" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> ' . _l('edit') . '</a></li>';
	}

	$delete = '';
	if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['approval'] == 0)) {

		$delete = '<li role="presentation">' . modal_anchor(get_uri("warehouse/delete_packing_list_modal_form"), "<i data-feather='x' class='icon-16'></i> " . app_lang('delete'), array("title" => app_lang('delete'). "?", "data-post-id" => $aRow['id'], "class" => "dropdown-item")) . '</li>';
	}


	$row[] = '
	<span class="dropdown inline-block">
	<button class="btn btn-default dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static">
	<i data-feather="tool" class="icon-16"></i>
	</button>
	<ul class="dropdown-menu dropdown-menu-end" role="menu">'.$view . $edit . $delete. '</ul>
	</span>';

	
	$output['aaData'][] = $row;

}
