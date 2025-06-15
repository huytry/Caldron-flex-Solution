<?php
$Clients_model = model("Models\Clients_model");

$aColumns = [
    'id',
    'goods_delivery_code',
    'customer_code',
    'date_add',
    'invoice_id',
    'to_', 
    'address',
    'staff_id',
    'approval',
    'delivery_status',
    '5',
    ];
$sIndexColumn = 'id';
$sTable       = get_db_prefix().'goods_delivery';
$join         = [ ];

$where = [];

if(isset($dataPost['day_vouchers'])){
    $day_vouchers = to_sql_date1($dataPost['day_vouchers']);
}

if (isset($day_vouchers)) {
    $where[] = ' AND '.get_db_prefix().'goods_delivery.date_add <= "' . $day_vouchers . '"';
}



if(isset($dataPost['invoice_id'])){
    $invoice_id = $dataPost['invoice_id'];

    $where_invoice_id = '';
    $where_invoice_id .= ' where invoice_id = "'.$invoice_id. '"';

    array_push($where, $where_invoice_id);
}


$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, ['id','date_add','date_c','goods_delivery_code','total_money', 'type_of_delivery'], '', [], $dataPost);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];

   for ($i = 0; $i < count($aColumns); $i++) {

        $_data = $aRow[$aColumns[$i]];

        if($aColumns[$i] == 'customer_code'){
            $_data = '';
            if($aRow['customer_code']){
                $client_options = [
                    'id' => $aRow['customer_code'],
                ];
                $client = $Clients_model->get_details($client_options)->getRow();
               
                if($client){
                    $_data = $client->company_name;
                }

            }


        }elseif($aColumns[$i] == 'invoice_id'){
            $_data = '';
            if($aRow['invoice_id']){

                $type_of_delivery='';
                if($aRow['type_of_delivery'] == 'partial'){
                    $type_of_delivery .= '( <span class="text-danger">'._l($aRow['type_of_delivery']).'</span> )';
                }elseif($aRow['type_of_delivery'] == 'total'){
                    $type_of_delivery .= '( <span class="text-success">'._l($aRow['type_of_delivery']).'</span> )';
                }

               $_data = get_invoice_id($aRow['invoice_id']).$type_of_delivery;

            }


        }elseif($aColumns[$i] == 'date_add'){

            $_data = format_to_date($aRow['date_add'], false);

        }elseif($aColumns[$i] == 'staff_id'){
            $_data = get_staff_full_name1($aRow['staff_id']);
        }elseif($aColumns[$i] == 'department'){
            $_data = $aRow['name'];
        }elseif($aColumns[$i] == 'goods_delivery_code'){
            $name = '<a href="' . site_url('warehouse/view_delivery/' . $aRow['id'] ).'">' . $aRow['goods_delivery_code'] . '</a>';

            $_data = $name;
        }elseif ($aColumns[$i] == 'custumer_name') {
            $_data =$aRow['custumer_name'];
        }elseif ($aColumns[$i] == 'to_') {
            $_data =    $aRow['to_'];
        }elseif($aColumns[$i] == 'address') {
            $_data = $aRow['address'];
        }elseif($aColumns[$i] == 'approval') {
             
             if($aRow['approval'] == 1){
                $_data = '<span class="badge bg-info large mt-0">'._l('approved').'</span>';
             }elseif($aRow['approval'] == 0){
                $_data = '<span class="badge bg-primary large mt-0">'._l('not_yet_approve').'</span>';
             }elseif($aRow['approval'] == -1){
                $_data = '<span class="badge bg-danger large mt-0">'._l('reject').'</span>';
             }
        }elseif($aColumns[$i] == 'delivery_status'){
            $_data = render_delivery_status_html($aRow['id'], 'delivery', $aRow['delivery_status']);

        }elseif($aColumns[$i] == '5'){

            $view = '<li role="presentation"><a href="' . site_url('warehouse/view_delivery/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="eye" class="icon-16"></span> ' . _l('view') . '</a></li>';

            $edit = '';
            if((has_permission('warehouse', '', 'edit') || is_admin()) && ($aRow['approval'] == 0)){
                $edit = '<li role="presentation"><a href="' . site_url('warehouse/goods_delivery/' . $aRow['id'] ) .'" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> ' . _l('edit') . '</a></li>';
            }

            $edit_approval = '';
             if((is_admin()) && ($aRow['approval'] == 1)){
                $edit_approval = '<li role="presentation"><a href="' . site_url('warehouse/goods_delivery/' . $aRow['id'] ) .'/true" class="dropdown-item"><span data-feather="edit" class="icon-16"></span> ' . _l('edit') . '</a></li>';
            }

            $delete = '';
            if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['approval'] == 0)) {

                $delete = '<li role="presentation">' . modal_anchor(get_uri("warehouse/delete_goods_delivery_modal_form"), "<i data-feather='x' class='icon-16'></i> " . app_lang('delete'), array("title" => app_lang('delete'). "?", "data-post-id" => $aRow['id'], "class" => "dropdown-item")) . '</li>';
            }


            $delete_approval = '';
            if(get_setting('revert_goods_receipt_goods_delivery') == 1 ){
                if ((has_permission('warehouse', '', 'delete') || is_admin()) && ($aRow['approval'] == 1)) {

                    $delete_approval = '<li role="presentation"><a href="' . site_url('warehouse/revert_goods_delivery/' . $aRow['id'] ).'" class="dropdown-item"><span data-feather="x" class="icon-16"></span> ' . _l('delete_after_approval') . '</a></li>';
                }
            }

            $_data = '
            <span class="dropdown inline-block">
            <button class="btn btn-default dropdown-toggle caret mt0 mb0" type="button" data-bs-toggle="dropdown" aria-expanded="true" data-bs-display="static">
            <i data-feather="tool" class="icon-16"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" role="menu">'.$view . $edit .$edit_approval. $delete. $delete_approval. '</ul>
            </span>';
        }

        $row[] = $_data;
    }
    $output['aaData'][] = $row;

}
