<?php

$aColumns = [

	'internal_delivery_code',
	'staff_id',
	'addedfrom',
	'datecreated',
	'total_amount',
	'approval',
	'5',
];
$sIndexColumn = 'id';
$sTable       = get_db_prefix().'internal_delivery_note';
$join         = [ ];

$where = [];

if(isset($dataPost['day_vouchers'])){
	$day_vouchers = to_sql_date1($dataPost['day_vouchers']);
}

if (isset($day_vouchers)) {
	$where[] = ' AND '.get_db_prefix().'goods_delivery.date_add <= "' . $day_vouchers . '"';
}


$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, ['id','date_add','internal_delivery_name','internal_delivery_code','description','date_c','date_add','datecreated'], '', [], $dataPost);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
	$row = [];


	for ($i = 0; $i < count($aColumns); $i++) {

		if($aColumns[$i] == 'internal_delivery_code'){

			$name = '<a href="' . site_url('warehouse/view_internal_delivery/' . $aRow['id'] ).'" >' . $aRow['internal_delivery_code'] .' - '.$aRow['internal_delivery_name']. '</a>';
			$_data = $name;

		}elseif($aColumns[$i] == 'date_add'){
			$_data = format_to_date($aRow['date_add'], false);

		}elseif($aColumns[$i] == 'staff_id'){
			$_data = get_staff_full_name1($aRow['staff_id']);
		}elseif($aColumns[$i] == 'addedfrom'){
			$_data = get_staff_full_name1($aRow['addedfrom']);
		}elseif($aColumns[$i] == 'datecreated'){
			$_data = format_to_datetime($aRow['datecreated'], false);

		}elseif($aColumns[$i] == 'total_amount'){
			$_data = to_decimal_format((float)$aRow['total_amount']);
			
		}elseif($aColumns[$i] == 'approval') {

			if($aRow['approval'] == 1){
				$_data = '<span class="badge bg-info large mt-0">'.app_lang('approved').'</span>';
			}elseif($aRow['approval'] == 0){
				$_data = '<span class="badge bg-primary large mt-0">'.app_lang('not_yet_approve').'</span>';
			}elseif($aRow['approval'] == -1){
				$_data = '<span class="badge bg-danger large mt-0">'.app_lang('reject').'</span>';
			}
		}elseif($aColumns[$i] == '5'){

			$view = '<li role="presentation"><a href="' . site_url('warehouse/view_internal_delivery/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="eye" class="icon-16"></span> ' . _l('view') . '</a></li>';

			$edit = '';
			if((has_permission('warehouse', '', 'edit') || is_admin()) && ($aRow['approval'] == 0)){
				$edit = '<li role="presentation"><a href="' . site_url('warehouse/add_update_internal_delivery/' . $aRow['id'] ) .'" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> ' . _l('edit') . '</a></li>';
			}

			$delete = '';
			if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['approval'] == 0)) {

				$delete = '<li role="presentation">' . modal_anchor(get_uri("warehouse/delete_internal_delivery_modal_form"), "<i data-feather='x' class='icon-16'></i> " . app_lang('delete'), array("title" => app_lang('delete'). "?", "data-post-id" => $aRow['id'], "class" => "dropdown-item")) . '</li>';
			}


			$row[] = '
			<span class="dropdown inline-block">
			<button class="btn btn-default dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static">
			<i data-feather="tool" class="icon-16"></i>
			</button>
			<ul class="dropdown-menu dropdown-menu-end" role="menu">'.$view . $edit . $delete. '</ul>
			</span>';
		}



		$row[] = $_data;
	}
	$output['aaData'][] = $row;

}
