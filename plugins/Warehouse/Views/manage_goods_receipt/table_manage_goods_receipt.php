<?php

$aColumns = [
	'id',
	'goods_receipt_code',
	'supplier_name',
	'buyer_id',
	'pr_order_id',
	'date_add',
	'total_tax_money', 
	'total_goods_money',
	'value_of_inventory',
	'total_money',
	'approval',
	'5',
];
$sIndexColumn = 'id';
$sTable       = get_db_prefix().'goods_receipt';
$join         = [ ];
$where = [];

if(isset($dataPost['day_vouchers'])){
	$day_vouchers = to_sql_date1($dataPost['day_vouchers']);
}

if (isset($day_vouchers)) {
	$where[] = 'AND '.get_db_prefix().'goods_receipt.date_add <= "' . $day_vouchers . '"';
}

$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, ['id','date_add','date_c','goods_receipt_code', 'supplier_code'], '', [], $dataPost);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
	$row = [];

	for ($i = 0; $i < count($aColumns); $i++) {

		$_data = $aRow[$aColumns[$i]];
		if($aColumns[$i] == 'supplier_name'){

			if (get_status_modules_wh('purchase') && ($aRow['supplier_code'] != '') && ($aRow['supplier_code'] != 0) ){
				$_data = wh_get_vendor_company_name($aRow['supplier_code']);
			}else{
				$_data = $aRow['supplier_name'];
			}

		}elseif($aColumns[$i] == 'buyer_id'){
			$_data = get_staff_full_name1($aRow['buyer_id']);
		}elseif($aColumns[$i] == 'date_add'){
			$_data = format_to_date($aRow['date_add'], false);
		}elseif ($aColumns[$i] == 'total_tax_money') {
			$_data = to_decimal_format((float)$aRow['total_tax_money']);
		}elseif($aColumns[$i] == 'goods_receipt_code'){
			$name = '<a href="' . site_url('warehouse/goods_receipt_detail/' . $aRow['id'] ).'" onclick="init_goods_receipt('.$aRow['id'].'); return false;">' . $aRow['goods_receipt_code'] . '</a>';

			$_data = $name;
		}elseif ($aColumns[$i] == 'total_goods_money') {
			$_data = to_decimal_format((float)$aRow['total_goods_money']);
		}elseif ($aColumns[$i] == 'total_money') {
			$_data = to_decimal_format((float)$aRow['total_money']);
		}elseif($aColumns[$i] == 'value_of_inventory') {
			$_data = to_decimal_format((float)$aRow['value_of_inventory']);
		}elseif($aColumns[$i] == 'approval') {

			if($aRow['approval'] == 1){
				$_data = '<span class="label label-tag tag-id-1 label-tab1"><span class="badge bg-info large mt-0">'.app_lang('approved').'</span><span class="hide">, </span></span>&nbsp';
			}elseif($aRow['approval'] == 0){
				$_data = '<span class="label label-tag tag-id-1 label-tab2"><span class="badge bg-primary large mt-0">'.app_lang('not_yet_approve').'</span><span class="hide">, </span></span>&nbsp';
			}elseif($aRow['approval'] == -1){
				$_data = '<span class="label label-tag tag-id-1 label-tab3"><span class="badge bg-danger large mt-0">'.app_lang('reject').'</span><span class="hide">, </span></span>&nbsp';
			}
		}elseif($aColumns[$i] == 'pr_order_id'){
			$get_pur_order_name ='';
			if (get_status_modules_wh('purchase')) {
				if( ($aRow['pr_order_id'] != '') && ($aRow['pr_order_id'] != 0) ){
					$get_pur_order_name .='<a href="'. site_url('purchase/purchase_order/'.$aRow['pr_order_id']) .'" >'. get_pur_order_name($aRow['pr_order_id']) .'</a>';
				}
			}

			$_data = $get_pur_order_name;

		}elseif($aColumns[$i] == '5'){

			$view = '<li role="presentation"><a href="' . site_url('warehouse/goods_receipt_detail/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="eye" class="icon-16"></span> ' . _l('view') . '</a></li>';

			$edit = '';
			if((has_permission('warehouse', '', 'edit') || is_admin()) && ($aRow['approval'] == 0)){
				$edit = '<li role="presentation"><a href="' . site_url('warehouse/manage_goods_receipt/' . $aRow['id'] ) .'" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> ' . _l('edit') . '</a></li>';
			}

			$delete = '';
			if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['approval'] == 0)) {

				$delete = '<li role="presentation">' . modal_anchor(get_uri("warehouse/delete_goods_receipt_modal_form"), "<i data-feather='x' class='icon-16'></i> " . app_lang('delete'), array("title" => app_lang('delete'). "?", "data-post-id" => $aRow['id'], "class" => "dropdown-item")) . '</li>';

			}

			$delete_approval = '';
			if(get_setting('revert_goods_receipt_goods_delivery') == 1 ){
				if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['approval'] == 1)) {

					$delete_approval = '<li role="presentation"><a href="' . site_url('warehouse/revert_goods_receipt/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="x" class="icon-16"></span> ' . _l('delete_after_approval') . '</a></li>';
				}
			}


			$_data = '
			<span class="dropdown inline-block">
			<button class="btn btn-default dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static">
			<i data-feather="tool" class="icon-16"></i>
			</button>
			<ul class="dropdown-menu dropdown-menu-end" role="menu">'.$view . $edit . $delete. $delete_approval. '</ul>
			</span>';
		}

		$row[] = $_data;
	}
	$output['aaData'][] = $row;

}
