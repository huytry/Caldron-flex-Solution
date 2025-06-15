<?php
$Clients_model = model("Models\Clients_model");

$aColumns = [
	'id',
	'order_return_name',
	'company_id',
	'total_amount',
	'discount_total',
	'total_after_discount',
	'datecreated',
	'receipt_delivery_type',
	'approval',
];
$sIndexColumn = 'id';
$sTable       = get_db_prefix().'wh_order_returns';
$join         = [ ];

$where = [];

if(isset($dataPost['from_date'])){
	$day_vouchers = to_sql_date1($dataPost['from_date']);
	array_push($where, "AND date_format(datecreated, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($day_vouchers)) . "'");
}

if(isset($dataPost['to_date'])){
	$to_date = to_sql_date1($dataPost['to_date']);
	array_push($where, "AND date_format(datecreated, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($to_date)) . "'");
}

if(isset($dataPost['staff_id']) && $dataPost['staff_id'] != ''){
	$staff_id = $dataPost['staff_id'];
	array_push($where, 'AND staff_id IN (' . implode(', ', $staff_id) . ')');
}

array_push($where, 'AND rel_type IN ("manual","i_sales_return_order","i_purchasing_return_order")');


if(isset($dataPost['delivery_id']) && $dataPost['delivery_id'] != ''){
	$delivery_id = $dataPost['delivery_id'];
	array_push($where, 'AND delivery_note_id IN (' . implode(', ', $delivery_id) . ')');
}

if(isset($dataPost['status_id']) && $dataPost['status_id'] != ''){
	$status_arr = $dataPost['status_id'];
	if(in_array(5, $dataPost['status_id'])){
		$status_arr[] = 0;
	}
	array_push($where, 'AND approval IN (' . implode(', ', $status_arr) . ')');

}

if(isset($dataPost['receipt_delivery_type']) && $dataPost['receipt_delivery_type'] != ''){
	$receipt_delivery_arr = $dataPost['receipt_delivery_type'];
	array_push($where, 'AND receipt_delivery_type IN ("' . implode('","', $receipt_delivery_arr) . '")');
}

$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, ['id', 'order_return_name', 'additional_discount', 'approval', 'return_type', 'rel_id', 'rel_type', 'order_return_number', 'receipt_delivery_id'], '', [], $dataPost);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
	$row = [];

	$row[] = $aRow['id'];

		$name = '<a href="' . site_url('warehouse/view_order_return/' . $aRow['id'] ).'" >' . $aRow['order_return_number'] .' - '.$aRow['order_return_name']. '</a>';

	$row[] = $name;
	
	if($aRow['rel_type'] == 'sales_return_order' || $aRow['rel_type'] == 'manual'){

		$customer_name = '';
		if(is_numeric($aRow['company_id'])){
			$Clients_model = model("Models\Clients_model");

			$client_options = [
				'id' => $aRow['company_id'],
			];
			$customer_value = $Clients_model->get_details($client_options)->getRow();

			if($customer_value){
				$customer_name .= $customer_value->company_name;
			}
		}

		$row[] = $customer_name;
	}else{
		$row[] = wh_get_vendor_company_name($aRow['company_id']);
	}

	$row[] = to_decimal_format($aRow['total_amount']);
	$row[] = to_decimal_format($aRow['discount_total']);
	$row[] = to_decimal_format($aRow['total_after_discount']);
	$row[] = format_to_date($aRow['datecreated']);

	$receipt_delivery_type_data = '';
	if($aRow['receipt_delivery_type'] == 'inventory_receipt_voucher_returned_goods'){
		$receipt_delivery_type_data = '<span class="label label-tag tag-id-1 label-tab1"><span class="tag">'._l('wh_inventory_receipt_voucher_returned_goods').'</span><span class="hide">, </span></span>&nbsp';
	}elseif($aRow['receipt_delivery_type'] == 'inventory_delivery_voucher_returned_purchasing_goods'){
		$receipt_delivery_type_data = '<span class="label label-tag tag-id-1 label-tab4"><span class="tag">'._l('wh_inventory_delivery_voucher_returned_purchasing_goods').'</span><span class="hide">, </span></span>&nbsp';
	}
	$row[] = $receipt_delivery_type_data;

	$approve_data = '';
	if($aRow['approval'] == 1){
		$approve_data = '<span class="badge bg-info large mt-0">'._l('approved').'</span>';
	}elseif($aRow['approval'] == 0){
		$approve_data = '<span class="badge bg-primary large mt-0">'._l('not_yet_approve').'</span>';
	}elseif($aRow['approval'] == -1){
		$approve_data = '<span class="badge bg-danger large mt-0">'._l('reject').'</span>';
	}

	$row[] = $approve_data;

	$option = '';

	
	if($aRow['receipt_delivery_id'] != 0){
		if(($aRow['rel_type'] == 'manual' && $aRow['receipt_delivery_type'] == 'inventory_receipt_voucher_returned_goods') || $aRow['rel_type'] == 'i_sales_return_order'){

			$option .= '<a href="' . site_url('warehouse/goods_receipt_detail/' . $aRow['receipt_delivery_id'] ).'" class="btn btn-success pull-right text-white" title="'.app_lang('goods_receipt').'" ><span data-feather="eye" class="icon-16"></span></a>';

		}elseif(($aRow['rel_type'] == 'manual' && $aRow['receipt_delivery_type'] == 'inventory_delivery_voucher_returned_purchasing_goods') || $aRow['rel_type'] == 'i_purchasing_return_order'){

			$option .= '<a href="' . site_url('warehouse/view_delivery/' . $aRow['receipt_delivery_id'] ).'" class="btn btn-success pull-right text-white" title="'.app_lang('stock_export').'" ><span data-feather="eye" class="icon-16"></span></a>';
		}
	}

	$row[] = $option;


	$view = '<li role="presentation"><a href="' . site_url('warehouse/view_order_return/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="eye" class="icon-16"></span> ' . _l('view') . '</a></li>';

	$edit = '';
	if((has_permission('warehouse', '', 'edit') || is_admin()) && ($aRow['approval'] == 0)){
		$edit = '<li role="presentation"><a href="' . site_url('warehouse/order_return/'.$aRow['rel_type']. '/' . $aRow['id'] ) .'" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> ' . _l('edit') . '</a></li>';
	}

	$delete = '';
	if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['approval'] == 0)) {

		$delete = '<li role="presentation">' . modal_anchor(get_uri("warehouse/delete_order_return_modal_form"), "<i data-feather='x' class='icon-16'></i> " . app_lang('delete'), array("title" => app_lang('delete'). "?", "data-post-id" => $aRow['id'], "class" => "dropdown-item")) . '</li>';
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
