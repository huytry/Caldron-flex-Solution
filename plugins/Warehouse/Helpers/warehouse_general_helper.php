<?php
use App\Controllers\App_Controller;
use App\Controllers\Security_Controller;
use Warehouse\Controllers\Warehouse;
use App\Libraries\Pdf;
use App\Libraries\Clean_data;



/**
 * get the defined config value by a key
 * @param string $key
 * @return config value
 */
if (!function_exists('get_warehouse_setting')) {

	function get_warehouse_setting($key = "") {
		$config = new Warehouse\Config\Warehouse();

		$setting_value = get_array_value($config->app_settings_array, $key);
		if ($setting_value !== NULL) {
			return $setting_value;
		} else {
			return "";
		}
	}

}

/**
 * warehouse get source url
 * @param  string $warehouse_file 
 * @return [type]                 
 */
if (!function_exists('warehouse_get_source_url')) {
	function warehouse_get_source_url($warehouse_file = "") {
		$viewuri = current_url();

		if (!$warehouse_file) {
			return "";
		}

		try {
			$file = unserialize($warehouse_file);
			if (is_array($file)) {
				return get_source_url_of_file($file, get_warehouse_setting("warehouse_file_path"), "thumbnail", false, false, true);
			}
		} catch (\Exception $ex) {
			
		}
	}

}

/**
 * ajax on total items
 * @return [type] 
 */
if (!function_exists('ajax_on_total_items')) {
	function ajax_on_total_items()
	{
		return app_hooks()->apply_filters('ajax_on_total_items', 2000);
	}

}

if (!function_exists('has_permission')) {
	function has_permission($permission, $staffid = '', $can = '')
	{
	// return staff_can($can, $permission, $staffid);
		return true;
	}

}

if (!function_exists('prefixed_table_fields_wildcard')) {

	function prefixed_table_fields_wildcard($table, $alias, $field)
	{
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		$prefixed = $Warehouse_model->prefixed_table_fields_wildcard($table, $alias, $field);

		return $prefixed;
	}
}


if (!function_exists('get_unit_type')) {
	function get_unit_type($id = false)
	{
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'ware_unit_type');

		if (is_numeric($id)) {
			$builder->where('unit_type_id', $id);

			return $builder->get()->getRow();
		}
		if ($id == false) {
			return $builder->query('select * from '.get_db_prefix().'ware_unit_type')->getResultArray();
		}

	}
}

/**
 * get inventory by warehouse variation
 * @param  [type] $id 
 * @return [type]     
 */
function get_inventory_by_warehouse_variation($id)
{
	$Warehouse_model = model("Warehouse\Models\Warehouse_model");
	//get parent quantity
	$sql_where = "SELECT sum(inventory_number) as inventory_number, warehouse_id FROM ".db_prefix()."inventory_manage
	WHERE commodity_id IN ( select id FROM ".db_prefix()."items where parent_id = ".$id.") group by warehouse_id" ;

	$item_value = $Warehouse_model->warehouse_run_query($sql_where); 
	return $item_value;
}

/**
 * get warehouse name
 * @param  boolean $id 
 * @return [type]      
 */
function get_warehouse_name($id = false)
{
	$Warehouse_model = model("Warehouse\Models\Warehouse_model");

	if ($id != false) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'warehouse');
		$builder->where('warehouse_id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'warehouse');
	}

}

/**
 * get list inventory by ids
 * @param  [type] $ids 
 * @return [type]      
 */
function get_list_inventory_by_ids($ids)
{
	$Warehouse_model = model("Warehouse\Models\Warehouse_model");

	//get parent quantity
	$sql_where = "SELECT * from ".get_db_prefix()."inventory_manage as iv
	WHERE iv.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id IN (".implode(',', $ids).") OR tem_items.id IN (".implode(',', $ids)."))" ;
	$item_value = $Warehouse_model->warehouse_run_query($sql_where); 
	return $item_value;
}

/**
 * get list serial number by ids
 * @param  [type] $ids 
 * @return [type]      
 */
function get_list_serial_number_by_ids($ids)
{
	$Warehouse_model = model("Warehouse\Models\Warehouse_model");

	//get parent quantity
	$sql_where = "SELECT * from ".get_db_prefix()."wh_inventory_serial_numbers as snm
	WHERE snm.is_used = 'no' AND snm.commodity_id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id IN (".implode(',', $ids).") OR tem_items.id IN (".implode(',', $ids).") )" ;
	$item_value = $Warehouse_model->warehouse_run_query($sql_where); 
	return $item_value;
}

/**
 * get list by parent ids
 * @param  [type] $ids 
 * @return [type]      
 */
function get_list_items_by_parent_ids($ids)
{
	$Warehouse_model = model("Warehouse\Models\Warehouse_model");

	//get parent quantity
	$sql_where = "SELECT * from ".get_db_prefix()."items as iv
	WHERE iv.id IN ( select id from ".get_db_prefix()."items as tem_items where tem_items.parent_id IN (".implode(',', $ids).") OR tem_items.id IN (".implode(',', $ids)."))" ;
	$item_value = $Warehouse_model->warehouse_run_query($sql_where); 
	return $item_value;
}

/**
 * wh check approval setting
 * @param  integer $type 
 * @return [type]       
 */
function wh_check_approval_setting($type)
{   
	$Warehouse_model = model("Warehouse\Models\Warehouse_model");
	$check_appr = $Warehouse_model->get_approve_setting($type);

	return $check_appr;
}

/**
 * wh_get_unit_name
 * @param  boolean $id 
 * @return [type]      
 */
function wh_get_unit_name($id = false)
{
	$builder = db_connect('default');
	$builder = $builder->table(get_db_prefix().'ware_unit_type');

	if (is_numeric($id)) {
		$builder->where('unit_type_id', $id);
		$unit = $builder->get()->getRow();
		if($unit){
			return $unit->unit_name;
		}
		return '';
	}
}

/**
 * wh convert item taxes
 * @param  [type] $tax      
 * @param  [type] $tax_rate 
 * @param  [type] $tax_name 
 * @return [type]           
 */
function wh_convert_item_taxes($tax, $tax_rate, $tax_name)
{
	/*taxrate taxname
	5.00    TAX5
	id      rate        name
	2|1 ; 6.00|10.00 ; TAX5|TAX10%*/
	$Warehouse_model = model("Warehouse\Models\Warehouse_model");

	$taxes = [];
	if($tax != null && strlen($tax) > 0){
		$arr_tax_id = explode('|', $tax);
		if($tax_name != null && strlen($tax_name) > 0){
			$arr_tax_name = explode('|', $tax_name);
			$arr_tax_rate = explode('|', $tax_rate);
			foreach ($arr_tax_name as $key => $value) {
				$taxes[]['taxname'] = $value . '|' .  $arr_tax_rate[$key];
			}
		}elseif($tax_rate != null && strlen($tax_rate) > 0){
			$CI->load->model('warehouse/warehouse_model');
			$arr_tax_id = explode('|', $tax);
			$arr_tax_rate = explode('|', $tax_rate);
			foreach ($arr_tax_id as $key => $value) {
				$_tax_name = $Warehouse_model->get_tax_name($value);
				if(isset($arr_tax_rate[$key])){
					$taxes[]['taxname'] = $_tax_name . '|' .  $arr_tax_rate[$key];
				}else{
					$taxes[]['taxname'] = $_tax_name . '|' .  $Warehouse_model->tax_rate_by_id($value);

				}
			}
		}else{
			$CI->load->model('warehouse/warehouse_model');
			$arr_tax_id = explode('|', $tax);
			$arr_tax_rate = explode('|', $tax_rate);
			foreach ($arr_tax_id as $key => $value) {
				$_tax_name = $Warehouse_model->get_tax_name($value);
				$_tax_rate = $Warehouse_model->tax_rate_by_id($value);
				$taxes[]['taxname'] = $_tax_name . '|' .  $_tax_rate;
			} 
		}

	}

	return $taxes;
}

/**
 * get commodity name
 * @param  integer $id
 * @return array or row
 */
function get_commodity_name($id = false)
{

	if (is_numeric($id)) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'items');
		$builder->where('id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'items'); 
	}

}

/**
 * get status inventory
 * @param  integer $commodity, integer $inventory
 * @return boolean
 */
function get_status_inventory($commodity, $inventory)
{

	$status=false;
	$inventory_min=0;

	$builder = db_connect('default');
	$builder = $builder->table(get_db_prefix().'inventory_commodity_min');
	$builder->where('commodity_id', $commodity);
	$result = $builder->get()->getRow();
	if($result){
		$inventory_min = $result->inventory_number_min;
	}

	if((float)$inventory < (float)$inventory_min){
		$status = false;
	}else{
		$status = true;
	}
	return $status;

}

/**
 * get goods receipt code
 * @param  integer $id
 * @return array or row
 */
function get_goods_receipt_code($id = false)
{
	if (is_numeric($id)) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'goods_receipt');
		$builder->where('id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'goods_receipt'); 
	}

}

/**
 * warehouse process digital signature image
 * @param  string $partBase64
 * @param  string $path
 * @param  string $image_name
 * @return boolean
 */
function warehouse_process_digital_signature_image($partBase64, $path, $image_name)
{
	if (empty($partBase64)) {
		return false;
	}

	if (!file_exists($path)) {
		mkdir($path, 0755);
		fopen(rtrim($path, '/') . '/' . 'index.html', 'w');
	}

	$filename = unique_filename($path, $image_name.'.png');
	$decoded_image = base64_decode($partBase64);

	$retval = false;

	$path = rtrim($path, '/') . '/' . $filename;

	$fp = fopen($path, 'w+');

	if (fwrite($fp, $decoded_image)) {
		$retval                                 = true;
		$GLOBALS['processed_digital_signature'] = $filename;
	}

	fclose($fp);

	return $retval;
}

if (!function_exists('unique_filename')) {

	function unique_filename($dir, $filename)
	{
	// Separate the filename into a name and extension.
		$info     = pathinfo($filename);
		$ext      = !empty($info['extension']) ? '.' . $info['extension'] : '';

		$number   = '';
		// Change '.ext' to lower case.
		if ($ext && strtolower($ext) != $ext) {
			$ext2      = strtolower($ext);
			$filename2 = preg_replace('|' . preg_quote($ext) . '$|', $ext2, $filename);
		// Check for both lower and upper case extension or image sub-sizes may be overwritten.
			while (file_exists($dir . "/$filename") || file_exists($dir . "/$filename2")) {
				$filename = str_replace([
					"-$number$ext",
					"$number$ext",
				], "-$new_number$ext", $filename);
				$filename2 = str_replace([
					"-$number$ext2",
					"$number$ext2",
				], "-$new_number$ext2", $filename2);
				$number = $new_number;
			}

			return $filename2;
		}
		while (file_exists($dir . "/$filename")) {
			if ('' == "$number$ext") {
				$filename = "$filename-" . ++$number;
			} else {
				$filename = str_replace([
					"-$number$ext",
					"$number$ext",
				], '-' . ++$number . $ext, $filename);
			}
		}

		return $filename;
	}
}

if (!function_exists('wh_log_notification')) {

	function wh_log_notification($event, $options = array(), $user_id = 0, $to_user_id = 0) {
		$ci = new Security_Controller(false);

			//send direct notification to the url
		$data = array(
			"event" => $event
		);

		if ($user_id) {
			$data["user_id"] = $user_id;
		} else if ($user_id === "0") {
				$data["user_id"] = $user_id; //if user id is 0 (string) we'll assume that it's system bot 
		} else if (isset($ci->login_user->id)) {
			$data["user_id"] = $ci->login_user->id;
		}

		$data['to_user_id'] = $to_user_id;

		foreach ($options as $key => $value) {
			$value = urlencode($value);
			$data[$key] = $value;
		}

		$warehouse = new Warehouse();
		$warehouse->wh_create_notification($data);
	}
}


if (!function_exists('prepare_goods_receipt_pdf')) {

	function prepare_goods_receipt_pdf($goods_receipt, $mode = "download") {
		$pdf = new Pdf();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetCellPadding(1.5);
		$pdf->setImageScale(1.42);
		$pdf->AddPage();
		$pdf->SetFontSize(9);

		if ($goods_receipt) {

			$goods_receipt["mode"] = clean_data($mode);

			$html = view("Warehouse\Views\manage_goods_receipt\goods_receipt_pdf", $goods_receipt);

			if ($mode != "html") {
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			$pdf_file_name = '#'.$goods_receipt['goods_receipt']->goods_receipt_code . ".pdf";

			if ($mode === "download") {
				$pdf->Output($pdf_file_name, "D");
			} else if ($mode === "send_email") {
				$temp_download_path = getcwd() . "/" . get_setting("temp_file_path") . $pdf_file_name;
				$pdf->Output($temp_download_path, "F");
				return $temp_download_path;
			} else if ($mode === "view") {
				$pdf->SetTitle($pdf_file_name);
				$pdf->Output($pdf_file_name, "I");
				exit;
			} else if ($mode === "html") {
				return $html;
			}
		}
	}

}

/**
 * get goods delivery code
 * @param  integer $id
 * @return array or row
 */
function get_goods_delivery_code($id = false)
{
    if (is_numeric($id)) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'goods_delivery');
		$builder->where('id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'goods_delivery'); 
	}
}

/**
 * get internal delivery code
 * @param  boolean $id 
 * @return [type]      
 */
function get_internal_delivery_code($id = false)
{

	if (is_numeric($id)) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'internal_delivery_note');
		$builder->where('id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'internal_delivery_note'); 
	}

}

/**
 * wh get item variatiom
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_item_variatiom($id)
{

	$builder = db_connect('default');
	$builder = $builder->table(get_db_prefix().'items');
	$builder->where('id', $id);
	$item_value = $builder->get()->getRow();

	$name = '';
	if($item_value){
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		$new_item_value = $Warehouse_model->row_item_to_variation($item_value);

		$name .= $item_value->commodity_code.'_'.$new_item_value->new_description;
	}

	return $name;
}

if (!function_exists('prepare_internal_delivery_pdf')) {

	function prepare_internal_delivery_pdf($internal_delivery, $mode = "download") {
		$pdf = new Pdf();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetCellPadding(1.5);
		$pdf->setImageScale(1.42);
		$pdf->AddPage();
		$pdf->SetFontSize(9);

		if ($internal_delivery) {

			$internal_delivery["mode"] = clean_data($mode);

			$html = view("Warehouse\Views\manage_internal_delivery\internal_delivery_pdf", $internal_delivery);

			if ($mode != "html") {
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			$pdf_file_name = '#'.$internal_delivery['internal_delivery']->internal_delivery_code . ".pdf";

			if ($mode === "download") {
				$pdf->Output($pdf_file_name, "D");
			} else if ($mode === "send_email") {
				$temp_download_path = getcwd() . "/" . get_setting("temp_file_path") . $pdf_file_name;
				$pdf->Output($temp_download_path, "F");
				return $temp_download_path;
			} else if ($mode === "view") {
				$pdf->SetTitle($pdf_file_name);
				$pdf->Output($pdf_file_name, "I");
				exit;
			} else if ($mode === "html") {
				return $html;
			}
		}
	}
}

/**
 * wh get warehouse address
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_warehouse_address($id)
{
	$builder = db_connect('default');
	$builder = $builder->table(get_db_prefix().'warehouse');
	$builder->where('warehouse_id', $id);
	$warehouse_value = $builder->get()->getRow();

	$address='';

	if($warehouse_value){

		$warehouse_address = [];
		$warehouse_address[0] =  $warehouse_value->warehouse_address;
		$warehouse_address[1] = $warehouse_value->city;
		$warehouse_address[2] =  $warehouse_value->state;
		$warehouse_address[3] =  $warehouse_value->country;
		$warehouse_address[4] =  $warehouse_value->zip_code;

		foreach ($warehouse_address as $key => $add_value) {
			if(isset($add_value) && $add_value !=''){
				switch ($key) {
					case 0:
					$address .= $add_value;
					break;
					case 1:
					$address .= ', '.$add_value;
					break;
					case 2:
					$address .= ', '.$add_value;
					break;
					case 3:
					$address .= ', '.$add_value;
					break;
					case 4:
					$address .= ', '.$add_value;
					break;
					default:
					break;
				}
			}
		}

	}
	return $address;
}

function wh_app_generate_hash()
{
    return md5(rand() . microtime() . time() . uniqid());
}

/**
 * render delivery status html
 * @param  string $status 
 * @return [type]         
 */
function render_delivery_status_html($id, $type, $status_value = '', $ChangeStatus = true)
{
	$status          = get_delivery_status_by_id($status_value, $type);

	if($type == 'delivery'){
		$task_statuses = delivery_list_status();
	}else{
		$task_statuses = packing_list_status();
	}
	$outputStatus    = '';
	$canChangeStatus = (has_permission('warehouse', '', 'edit') || is_admin());

	if ($canChangeStatus && $ChangeStatus) {
		$outputStatus .= '<span class="dropdown inline-block " style="color:' . $status['color'] . ';border:1px solid ' . $status['color'] . '" task-status-table="' . $status_value . '">';
	}else{

		$outputStatus .= '<span class="dropdown inline-block label badge  large" style="color:' . $status['color'] . ';border:1px solid ' . $status['color'] . '" task-status-table="' . $status_value . '">';
	}

	if ($canChangeStatus && $ChangeStatus) {

		$outputStatus .= '<button id="tableTaskStatus-' . $id . '" class="btn text-white dropdown-toggle caret mt0 mb0" style="background-color:' . $status['color'] . ';border:1px solid ' . $status['color'] . '" type="button" data-bs-toggle="dropdown" aria-expanded="true">
								'.$status['name'].'
							';

		$outputStatus .= '<span data-toggle="tooltip" title="' . _l('ticket_single_change_status') . '"><i class="fa fa-caret-down" aria-hidden="true"></i></span>';
		$outputStatus .= '</button>';

		$outputStatus .= '<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="tableTaskStatus-' . $id . '">';
		foreach ($task_statuses as $taskChangeStatus) {
			if ($status_value != $taskChangeStatus['id']) {
				$outputStatus .= '<li role="presentation">
				<a class="dropdown-item" href="#" onclick="delivery_status_mark_as(\'' . $taskChangeStatus['id'] . '\',' . $id . ',\'' . $type . '\'); return false;">
				' . $taskChangeStatus['name'] . '
				</a>
				</li>';
			}
		}
		$outputStatus .= '</ul>';
	}else{
		$outputStatus    .= $status['name'];
	}

	$outputStatus .= '</span>';

	return $outputStatus;
}

function get_delivery_status_by_id($id, $type)
{
    $statuses = delivery_list_status();

    if($type == 'delivery'){
        $status = [
            'id'         => 0,
            'color'   => '#989898',
            'color' => '#989898',
            'name'       => _l('wh_ready_for_packing'),
            'order'      => 1,
        ];
    }else{
        $status = [
            'id'         => 0,
            'color'   => '#989898',
            'color' => '#989898',
            'name'       => _l('wh_ready_to_deliver'),
            'order'      => 1,
        ];
    }

    foreach ($statuses as $s) {
        if ($s['id'] == $id) {
            $status = $s;

            break;
        }
    }

    return $status;
}

/**
 * packing list status
 * @param  string $status 
 * @return [type]         
 */
function delivery_list_status($status='')
{

    $statuses = [
        [
            'id'             => 'ready_for_packing',
            'color'          => '#28b8daed',
            'name'           => _l('wh_ready_for_packing'),
            'order'          => 1,
            'filter_default' => true,
        ],
        [
            'id'             => 'ready_to_deliver',
            'color'          => '#03A9F4',
            'name'           => _l('wh_ready_to_deliver'),
            'order'          => 2,
            'filter_default' => true,
        ],
        [
            'id'             => 'delivery_in_progress',
            'color'          => '#2196f3',
            'name'           => _l('wh_delivery_in_progress'),
            'order'          => 3,
            'filter_default' => true,
        ],
        [
            'id'             => 'delivered',
            'color'          => '#3db8da',
            'name'           => _l('wh_delivered'),
            'order'          => 4,
            'filter_default' => true,
        ],
        [
            'id'             => 'received',
            'color'          => '#84c529',
            'name'           => _l('wh_received'),
            'order'          => 5,
            'filter_default' => false,
        ],
        [
            'id'             => 'returned',
            'color'          => '#d71a1a',
            'name'           => _l('wh_returned'),
            'order'          => 6,
            'filter_default' => false,
        ],
        [
            'id'             => 'not_delivered',
            'color'          => '#ffa500',
            'name'           => _l('wh_not_delivered'),
            'order'          => 7,
            'filter_default' => false,
        ],
    ];

    usort($statuses, function ($a, $b) {
        return $a['order'] - $b['order'];
    });

    return $statuses;
}


/**
 * packing list status
 * @param  string $status 
 * @return [type]         
 */
function packing_list_status($status='')
{

    $statuses = [

        [
            'id'             => 'ready_to_deliver',
            'color'          => '#03A9F4',
            'name'           => _l('wh_ready_to_deliver'),
            'order'          => 2,
            'filter_default' => true,
        ],
        [
            'id'             => 'delivery_in_progress',
            'color'          => '#2196f3',
            'name'           => _l('wh_delivery_in_progress'),
            'order'          => 3,
            'filter_default' => true,
        ],
        [
            'id'             => 'delivered',
            'color'          => '#3db8da',
            'name'           => _l('wh_delivered'),
            'order'          => 4,
            'filter_default' => true,
        ],
        [
            'id'             => 'received',
            'color'          => '#84c529',
            'name'           => _l('wh_received'),
            'order'          => 5,
            'filter_default' => false,
        ],
        [
            'id'             => 'returned',
            'color'          => '#d71a1a',
            'name'           => _l('wh_returned'),
            'order'          => 6,
            'filter_default' => false,
        ],
        [
            'id'             => 'not_delivered',
            'color'          => '#ffa500',
            'name'           => _l('wh_not_delivered'),
            'order'          => 7,
            'filter_default' => false,
        ],
    ];

    usort($statuses, function ($a, $b) {
        return $a['order'] - $b['order'];
    });

    return $statuses;
}

if (!function_exists('prepare_goods_delivery_pdf')) {

	function prepare_goods_delivery_pdf($goods_delivery, $mode = "download") {
		$pdf = new Pdf();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetCellPadding(1.5);
		$pdf->setImageScale(1.42);
		$pdf->AddPage();
		$pdf->SetFontSize(9);

		if ($goods_delivery) {

			$goods_delivery["mode"] = clean_data($mode);

			$html = view("Warehouse\Views\manage_goods_delivery\goods_delivery_pdf", $goods_delivery);

			if ($mode != "html") {
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			$pdf_file_name = '#'.$goods_delivery['goods_delivery']->goods_delivery_code . ".pdf";

			if ($mode === "download") {
				$pdf->Output($pdf_file_name, "D");
			} else if ($mode === "send_email") {
				$temp_download_path = getcwd() . "/" . get_setting("temp_file_path") . $pdf_file_name;
				$pdf->Output($temp_download_path, "F");
				return $temp_download_path;
			} else if ($mode === "view") {
				$pdf->SetTitle($pdf_file_name);
				$pdf->Output($pdf_file_name, "I");
				exit;
			} else if ($mode === "html") {
				return $html;
			}
		}
	}

}


/**
 * wh get delivery code
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_delivery_code($id)
{
    $goods_delivery_code = '';
    if (is_numeric($id)) {
    	$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'goods_delivery');
		$builder->where('id', $id);
        $goods_delivery = $builder->get()->getRow();
        if($goods_delivery){
            $goods_delivery_code = $goods_delivery->goods_delivery_code;
        }
    }
    return $goods_delivery_code;
}

/**
 * wh render taxes html
 * @param  [type] $item_tax 
 * @param  [type] $width    
 * @return [type]           
 */
function wh_render_taxes_html($item_tax, $width)
{
    $itemHTML = '';
    $itemHTML .= '<td align="right" width="' . $width . '%">';

    if(is_array($item_tax) && isset($item_tax)){
        if (count($item_tax) > 0) {
            foreach ($item_tax as $tax) {

                $item_tax = '';
                    $tmp      = explode('|', $tax['taxname']);
                    $item_tax = $tmp[0] . ' ' . to_decimal_format($tmp[1]) . '%<br />';
                $itemHTML .= $item_tax;
            }
        } else {
            $itemHTML .=  to_decimal_format(0) . '%';
        }
    }
    $itemHTML .= '</td>';

    return $itemHTML;
}

if (!function_exists('prepare_packing_list_pdf')) {

	function prepare_packing_list_pdf($packing_list, $mode = "download") {
		$pdf = new Pdf();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetCellPadding(1.5);
		$pdf->setImageScale(1.42);
		$pdf->AddPage();
		$pdf->SetFontSize(9);

		if ($packing_list) {

			$packing_list["mode"] = clean_data($mode);

			$html = view("Warehouse\Views\packing_lists\packing_list_pdf", $packing_list);

			if ($mode != "html") {
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			$pdf_file_name = '#'.$packing_list['packing_list']->packing_list_number .'_'.$packing_list['packing_list']->packing_list_name. ".pdf";

			if ($mode === "download") {
				$pdf->Output($pdf_file_name, "D");
			} else if ($mode === "send_email") {
				$temp_download_path = getcwd() . "/" . get_setting("temp_file_path") . $pdf_file_name;
				$pdf->Output($temp_download_path, "F");
				return $temp_download_path;
			} else if ($mode === "view") {
				$pdf->SetTitle($pdf_file_name);
				$pdf->Output($pdf_file_name, "I");
				exit;
			} else if ($mode === "html") {
				return $html;
			}
		}
	}

}


/**
 * wh get sales order code
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_sales_order_code($id)
{
	$sales_order_code = '';
	if (is_numeric($id)) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'cart');
		$builder->where('id', $id);
		$sales_order = $builder->get()->getRow();
		if($sales_order){
			$sales_order_code = $sales_order->order_number;
		}

	}
	return $sales_order_code;
}

/**
 * wh get purchase order code
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_purchase_order_code($id)
{
	$purchase_order_code = '';
	if (is_numeric($id)) {

		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'pur_orders');
		$builder->where('id', $id);
		$purchase_order = $builder->get()->getRow();
		if($purchase_order){
			$purchase_order_code = $purchase_order->pur_order_number;
		}


	}
	return $purchase_order_code;
}

/**
 * wh get order return code
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_order_return_code($id)
{
	$order_return_code = '';
	if (is_numeric($id)) {

		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'wh_order_returns');
		$builder->where('id', $id);
		$order_return = $builder->get()->getRow();
		if($order_return){
			$order_return_code = $order_return->order_return_number.' - '.$order_return->order_return_name;
		}

	}
	return $order_return_code;
}

if (!function_exists('prepare_order_return_pdf')) {

	function prepare_order_return_pdf($order_return, $mode = "download") {
		$pdf = new Pdf();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetCellPadding(1.5);
		$pdf->setImageScale(1.42);
		$pdf->AddPage();
		$pdf->SetFontSize(9);

		if ($order_return) {

			$order_return["mode"] = clean_data($mode);

			$html = view("Warehouse\Views\order_returns\order_return_pdf", $order_return);

			if ($mode != "html") {
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			$pdf_file_name = '#'.$order_return['order_return']->order_return_number .'_'.$order_return['order_return']->order_return_name. ".pdf";

			if ($mode === "download") {
				$pdf->Output($pdf_file_name, "D");
			} else if ($mode === "send_email") {
				$temp_download_path = getcwd() . "/" . get_setting("temp_file_path") . $pdf_file_name;
				$pdf->Output($temp_download_path, "F");
				return $temp_download_path;
			} else if ($mode === "view") {
				$pdf->SetTitle($pdf_file_name);
				$pdf->Output($pdf_file_name, "I");
				exit;
			} else if ($mode === "html") {
				return $html;
			}
		}
	}

}

/**
 * get tax rate
 * @param  boolean $id 
 * @return [type]      
 */
function get_tax_rate($id = false)
{
	if (is_numeric($id)) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'taxes');
		$builder->where('id', $id);
		return $builder->get()->getRow();

	}
	if ($id == false) {

		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'taxes');
	}
}

if (!function_exists('prepare_barcode_pdf')) {

	function prepare_barcode_pdf($barcode_data, $mode = "download") {
		$pdf = new Pdf();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetCellPadding(1.5);
		$pdf->setImageScale(1.42);
		$pdf->AddPage();
		$pdf->SetFontSize(9);

		if ($barcode_data) {

			$barcode_data["mode"] = clean_data($mode);

			$html = view("Warehouse\Views\items\barcode_pdf", $barcode_data);

			if ($mode != "html") {
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			$pdf_file_name = "barcode".date("YmdHis"). ".pdf";

			if ($mode === "download") {
				$pdf->Output($pdf_file_name, "D");
			} else if ($mode === "send_email") {
				$temp_download_path = getcwd() . "/" . get_setting("temp_file_path") . $pdf_file_name;
				$pdf->Output($temp_download_path, "F");
				return $temp_download_path;
			} else if ($mode === "view") {
				$pdf->SetTitle($pdf_file_name);
				$pdf->Output($pdf_file_name, "I");
				exit;
			} else if ($mode === "html") {
				return $html;
			}
		}
	}

}

/**
 * get color type
 * @param  integer $id, string $index_name
 * @return array, object
 */
function get_color_type($id = false)
{

	if (is_numeric($id)) {

		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'ware_color');
		$builder->where('color_id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'ware_color');
	}
}


/**
 * get style name
 * @param  integer $id
 * @return array or row
 */
function get_style_name($id = false)
{
    if (is_numeric($id)) {

        $builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'ware_style_type');
		$builder->where('style_type_id', $id);
		return $builder->get()->getRow();
    }
    if ($id == false) {
        $Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'ware_style_type');
    }
}

/**
 * get model name
 * @param  integer $id
 * @return array or row
 */
function get_model_name($id = false)
{
	if (is_numeric($id)) {

		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'ware_body_type');
		$builder->where('body_type_id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'ware_body_type');
	}

}


/**
 * get size name
 * @param  integer $id
 * @return array or row
 */
function get_size_name($id = false)
{

	if (is_numeric($id)) {
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'ware_size_type');
		$builder->where('size_type_id', $id);
		return $builder->get()->getRow();
	}
	if ($id == false) {
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'ware_size_type');
	}

}


/**
 * get group name
 * @param  integer $id
 * @return array or row
 */
function get_wh_group_name($id = false)
{

    if (is_numeric($id)) {

        $builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'item_categories');
		$builder->where('id', $id);
		return $builder->get()->getRow();

    }
    if ($id == false) {
        $Warehouse_model = model("Warehouse\Models\Warehouse_model");
		return $Warehouse_model->warehouse_run_query('select * from '.get_db_prefix().'item_categories');
    }

}

if (!function_exists('_l')) {
	function _l($key)
	{
		return app_lang($key);
	}
}

if (!function_exists('prepare_warranty_period_pdf')) {

	function prepare_warranty_period_pdf($warranty_period_data, $mode = "download") {
		$pdf = new Pdf();
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetCellPadding(1.5);
		$pdf->setImageScale(1.42);
		$pdf->AddPage();
		$pdf->SetFontSize(8);

		if ($warranty_period_data) {

			$warranty_period_data["mode"] = clean_data($mode);

			$html = view("Warehouse\Views\\reports\warranty_period_reports\warranty_period_report_pdf", $warranty_period_data);

			if ($mode != "html") {
				$pdf->writeHTML($html, true, false, true, false, '');
			}

			$pdf_file_name = mb_strtoupper('warranty_period_report'.'_'.get_my_local_time("YmdHi")). ".pdf";

			if ($mode === "download") {
				$pdf->Output($pdf_file_name, "D");
			} else if ($mode === "send_email") {
				$temp_download_path = getcwd() . "/" . get_setting("temp_file_path") . $pdf_file_name;
				$pdf->Output($temp_download_path, "F");
				return $temp_download_path;
			} else if ($mode === "view") {
				$pdf->SetTitle($pdf_file_name);
				$pdf->Output($pdf_file_name, "I");
				exit;
			} else if ($mode === "html") {
				return $html;
			}
		}
	}
}

if (!function_exists('wh_get_company_name')) {
	function wh_get_company_name($userid, $prevent_empty_company = false)
	{

		$_userid = $userid;

		$db = db_connect('default');
		$db_builder = $db->table(get_db_prefix() . 'clients');
		$client = $db_builder->select('company_name')
		->where('id', $_userid)
		->get()
		->getRow();
		if ($client) {
			return $client->company_name;
		}

		return '';
	}
}

/**
 * get item description
 * @param  boolean $id 
 * @return [type]      
 */
function get_item_description($id = false)
{
    $item_name = '';
    if (is_numeric($id)) {

    	$db = db_connect('default');
		$db_builder = $db->table(get_db_prefix() . 'items');
        $db_builder->where('id', $id);
        $item =  $db_builder->get()->getRow();
        if($item){
            $item_name = $item->title;
        }
    }
     return $item_name;
}