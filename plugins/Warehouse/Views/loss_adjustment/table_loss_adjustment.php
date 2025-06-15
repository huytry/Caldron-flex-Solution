<?php

$aColumns = [
	'id',
	'loss_adjustment_title',
	'type',
	'time',
	'addfrom',
	'date_create',
	'reason', 
	'status',
	'5',
];
$sIndexColumn = 'id';
$sTable       = get_db_prefix().'wh_loss_adjustment';
$join         = [ ];
$where = [];

if(isset($dataPost['time_filter']) && $dataPost['time_filter'] != ''){
	$time_filter = to_sql_date1($dataPost['time_filter']);
}
if(isset($dataPost['date_create']) && $dataPost['date_create'] != ''){
	$date_create = to_sql_date1($dataPost['date_create']);
}
if(isset($dataPost['status_filter']) && $dataPost['status_filter'] != ''){

	$status_filter = $dataPost['status_filter'];
}
if(isset($dataPost['type_filter']) && $dataPost['type_filter'] != ''){

	$type_filter = $dataPost['type_filter'];
}

if (isset($time_filter)) {
	array_push($where, "AND date_format(time, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($time_filter)) . "'");
}
if (isset($date_create)) {
	array_push($where, "AND date_create <= '" . date('Y-m-d', strtotime($date_create)) . "'");
}

if (isset($type_filter)) {
	array_push($where, "AND type = '".$type_filter."'");
}

if (isset($status_filter)) {
	array_push($where, "AND status = '".$status_filter."'");
}


$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, ['id'], '', [], $dataPost);

$output  = $result['output'];
$rResult = $result['rResult'];


foreach ($rResult as $aRow) {
	$row = [];

	for ($i = 0; $i < count($aColumns); $i++) {

		$_data = $aRow[$aColumns[$i]];
		
		if($aColumns[$i] == 'addfrom'){
			$_data = get_staff_full_name1($aRow['addfrom']);
		}elseif($aColumns[$i] == 'time'){
			$_data = format_to_date($aRow['time'], false);

		}elseif($aColumns[$i] == 'date_create'){
			$_data = format_to_date($aRow['date_create'], false);

		}elseif($aColumns[$i] == 'loss_adjustment_title'){
			$name = '<a href="' . site_url('warehouse/view_lost_adjustment/' . $aRow['id'] ).'">' . $aRow['loss_adjustment_title'] . '</a>';

			$_data = $name;
		}elseif ($aColumns[$i] == 'type') {
			$_data = app_lang($aRow['type']);
		}elseif ($aColumns[$i] == 'reason') {
			$_data = $aRow['reason'];
		}elseif($aColumns[$i] == 'status') {

			if($aRow['status'] == 1){
				$_data = '<span class="label label-tag tag-id-1 label-tab1"><span class="badge bg-info large mt-0">'.app_lang('adjusted').'</span><span class="hide">, </span></span>&nbsp';
			}elseif($aRow['status'] == 0){
				$_data = '<span class="label label-tag tag-id-1 label-tab2"><span class="badge bg-primary large mt-0">'.app_lang('status_draft').'</span><span class="hide">, </span></span>&nbsp';
			}elseif($aRow['status'] == -1){
				$_data = '<span class="label label-tag tag-id-1 label-tab3"><span class="badge bg-danger large mt-0">'.app_lang('reject').'</span><span class="hide">, </span></span>&nbsp';
			}
		}elseif($aColumns[$i] == '5'){

			$view = '<li role="presentation"><a href="' . site_url('warehouse/view_lost_adjustment/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="eye" class="icon-16"></span> ' . _l('view') . '</a></li>';

			$edit = '';
			if((has_permission('warehouse', '', 'edit') || is_admin()) && ($aRow['status'] == 0)){
				$edit = '<li role="presentation"><a href="' . site_url('warehouse/add_loss_adjustment/' . $aRow['id'] ) .'" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> ' . _l('edit') . '</a></li>';
			}

			$delete = '';
			if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['status'] == 0)) {

				$delete = '<li role="presentation">' . modal_anchor(get_uri("warehouse/delete_loss_adjustment_modal_form"), "<i data-feather='x' class='icon-16'></i> " . app_lang('delete'), array("title" => app_lang('delete'). "?", "data-post-id" => $aRow['id'], "class" => "dropdown-item")) . '</li>';
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
