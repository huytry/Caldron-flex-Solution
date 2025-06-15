<?php


/**
 * Add setting
 *
 * @since  Version 1.0.0
 *
 * @param string  $name      Option name (required|unique)
 * @param string  $value     Option value
 *
 */

if (!function_exists('add_setting')) {

	function add_setting($name, $value = '')
	{
		if (!setting_exists($name)) {
			$db = db_connect('default');
			$db_builder = $db->table(get_db_prefix() . 'settings');
			$newData = [
				'setting_name'  => $name,
				'setting_value' => $value,
			];

			$db_builder->insert($newData);

			$insert_id = $db->insertID();

			if ($insert_id) {
				return true;
			}

			return false;
		}

		return false;
	}
}

/**
 * @since  1.0.0
 * Check whether an setting exists
 *
 * @param  string $name setting name
 *
 * @return boolean
 */
if (!function_exists('setting_exists')) {

	function setting_exists($name)
	{ 
		
		$db = db_connect('default');
		$db_builder = $db->table(get_db_prefix() . 'settings');

		$count = $db_builder->where('setting_name', $name)->countAllResults();

		return $count > 0;
	}
}


$this_is_required = true;
if (!$this_is_required) {
	echo json_encode(array("success" => false, "message" => "This is required!"));
	exit();
}

//run installation sql
$db = db_connect('default');
$dbprefix = get_db_prefix();

$sql_query = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "ware_commodity_type` (

	`commodity_type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`commondity_code` varchar(100) NULL,
	`commondity_name` text NULL,
	`order` int(10) NULL,
	`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
	`note` text NULL,
	PRIMARY KEY (`commodity_type_id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$db->query($sql_query);


$sql_query = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "ware_unit_type` (
	`unit_type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`unit_code` varchar(100) NULL,
	`unit_name` text NULL,
	`unit_symbol` text NULL,
	`order` int(10) NULL,
	`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
	`note` text NULL,
	PRIMARY KEY (`unit_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$db->query($sql_query);

$sql_query = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "ware_size_type` (
	`size_type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`size_code` varchar(100) NULL,
	`size_name` text NULL,
	`size_symbol` text NULL,
	`order` int(10) NULL,
	`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
	`note` text NULL,
	PRIMARY KEY (`size_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$db->query($sql_query);


$sql_query = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "ware_style_type` (
	`style_type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`style_code` varchar(100) NULL,
	`style_barcode` text NULL,
	`style_name` text NULL,
	`order` int(10) NULL,
	`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
	`note` text NULL,
	PRIMARY KEY (`style_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$db->query($sql_query);

$sql_query = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "ware_body_type` (
	`body_type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`body_code` varchar(100) NULL,
	`body_name` text NULL,
	`order` int(10) NULL,
	`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
	`note` text NULL,
	PRIMARY KEY (`body_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$db->query($sql_query);

if (!$db->fieldExists('commodity_group_code', $dbprefix.'item_categories')) {
	$db->query('ALTER TABLE `' . $dbprefix . "item_categories`
		ADD COLUMN `commodity_group_code` varchar(100) NULL,
		ADD COLUMN `order` int(10) NULL,
		ADD COLUMN 	`display` int(1)  NULL DEFAULT '1',
		ADD COLUMN 	`note` text NULL
		;");
}

$sql_query = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "inventory_manage` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`warehouse_id` int(11) NOT NULL ,
	`commodity_id` int(11) NOT NULL,
	`inventory_number` varchar(100) NULL,
	`date_manufacture` date NULL,
	`expiry_date` date NULL,
	`lot_number` varchar(100),
	`purchase_price` DECIMAL(15,2) NULL DEFAULT '0.00',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$db->query($sql_query);

if (!$db->fieldExists('tax', $dbprefix.'items')) {
	$db->query('ALTER TABLE `' . $dbprefix . "items`
		ADD COLUMN `tax` int(11) NULL,
		ADD COLUMN `tax2` int(11) NULL
		;");
}

if (!$db->fieldExists('commodity_code', $dbprefix.'items')) {
	$db->query('ALTER TABLE `' . $dbprefix . "items`
		ADD COLUMN `commodity_code` varchar(100) NULL,
		ADD COLUMN `commodity_barcode` text NULL,
		ADD COLUMN `commodity_type` int(11) NULL,
		ADD COLUMN `warehouse_id` int(11) NULL,
		ADD COLUMN `origin` varchar(100) NULL,
		ADD COLUMN `color_id` int(11) NULL,
		ADD COLUMN `style_id` int(11) NULL,
		ADD COLUMN `model_id` int(11) NULL,
		ADD COLUMN `size_id` int(11) NULL,
		ADD COLUMN `unit_id` int(11) NULL,
		ADD COLUMN `sku_code` varchar(200)  NULL,
		ADD COLUMN `sku_name` varchar(200)  NULL,
		ADD COLUMN `purchase_price` decimal(15,2)  NULL DEFAULT '0.00',
		ADD COLUMN `sub_group` varchar(200)  NULL,
		ADD COLUMN `commodity_name` varchar(200) NOT NULL,
		ADD COLUMN `color` text NULL,
		ADD COLUMN `guarantee` text  NULL,
		ADD COLUMN `profif_ratio` text  NULL,
		ADD COLUMN `parent_id` int(11)  NULL  DEFAULT NULL,
		ADD COLUMN `attributes` LONGTEXT  NULL,
		ADD COLUMN `parent_attributes` LONGTEXT  NULL,
		ADD COLUMN `can_be_sold` VARCHAR(100) NULL DEFAULT 'can_be_sold',
		ADD COLUMN `can_be_purchased` VARCHAR(100) NULL DEFAULT 'can_be_purchased', 
		ADD COLUMN `can_be_manufacturing` VARCHAR(100) NULL DEFAULT 'can_be_manufacturing',
		ADD COLUMN `can_be_inventory` VARCHAR(100) NULL DEFAULT 'can_be_inventory' 
		;");
}

if (!$db->fieldExists('without_checking_warehouse', $dbprefix.'items')) {
	$db->query('ALTER TABLE `' . $dbprefix . "items`
		ADD COLUMN `without_checking_warehouse` int(11) NULL default 0
		;");
}

if (!$db->tableExists($dbprefix . 'warehouse')) {
	$db->query('CREATE TABLE `' . $dbprefix . "warehouse` (
		`warehouse_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`warehouse_code` varchar(100) NULL,
		`warehouse_name` text NULL,
		`warehouse_address` text NULL,
		`order` int(10) NULL,
		`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
		`note` text NULL,
		`city` TEXT  NULL,
		`state` TEXT  NULL,
		`zip_code` TEXT  NULL,
		`country` TEXT  NULL,
		PRIMARY KEY (`warehouse_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	}

	if (!$db->tableExists($dbprefix . 'goods_receipt')) {
		$db->query('CREATE TABLE `' . $dbprefix . "goods_receipt` (
			`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`supplier_code` varchar(100) NULL,
			`supplier_name` text NULL,
			`deliver_name` text NULL,
			`buyer_id` int(11) NULL,
			`description` text NULL,
			`pr_order_id` int(11) NULL COMMENT 'code puchase request agree',
			`date_c` date NULL ,
			`date_add` date NULL,
			`goods_receipt_code` varchar(100) NULL,
			`total_tax_money` decimal(15,2)  NULL DEFAULT '0.00',
			`total_goods_money` decimal(15,2)  NULL DEFAULT '0.00',
			`value_of_inventory` decimal(15,2)  NULL DEFAULT '0.00',
			`total_money` decimal(15,2)  NULL DEFAULT '0.00' COMMENT 'total_money = total_tax_money +total_goods_money ',
			`approval` INT(11) NULL DEFAULT 0,
			`addedfrom` INT(11) NULL,
			`warehouse_id` int(11) NULL,
			`project` TEXT  NULL,
			`type` TEXT  NULL,
			`department` int(11)  NULL,
			`requester` int(11)  NULL,
			`expiry_date` DATE NULL,
			`invoice_no` text NULL,

			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	}

	if (!$db->tableExists($dbprefix . 'goods_receipt_detail')) {
		$db->query('CREATE TABLE `' . $dbprefix . "goods_receipt_detail` (
		`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`goods_receipt_id` int(11) NOT NULL,
		`commodity_code` varchar(100) NULL,
		`commodity_name` text NULL,
		`warehouse_id` text NULL,
		`unit_id` text NULL,
		`quantities` text NULL,
		`unit_price` decimal(15,2)  NULL DEFAULT '0.00',
		`tax` varchar(100) NULL,
		`tax_money` varchar(100) NULL,
		`goods_money` decimal(15,2)  NULL DEFAULT '0.00' ,
		`note` text NULL ,
		`date_manufacture` date NULL,
		`expiry_date` date NULL,
		`discount` decimal(15,2)  NULL DEFAULT '0.00',
		`discount_money` decimal(15,2)  NULL DEFAULT '0.00',
		`lot_number` varchar(100),
		`tax_rate` TEXT NULL,
		`sub_total` DECIMAL(15,2) NULL DEFAULT '0.00',
		`tax_name` TEXT NULL,
		`serial_number` VARCHAR(255) NULL,

		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	}

	if (!$db->tableExists($dbprefix . 'goods_transaction_detail')) {
		$db->query('CREATE TABLE `' . $dbprefix . "goods_transaction_detail` (
		`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`goods_receipt_id` int(11)  NULL COMMENT 'id_goods_receipt_id or goods_delivery_id',
		`goods_id` int(11) NOT NULL COMMENT ' is id commodity',
		`quantity` varchar(100) NULL,
		`date_add` DATETIME NULL,
		`commodity_id` int(11) NOT NULL,
		`warehouse_id` int(11) NOT NULL,
		`note`  text null,
		`status` int(2) NULL COMMENT '1:Goods receipt note 2:Goods delivery note',
		`old_quantity` varchar(100) NULL,
		`purchase_price` DECIMAL(15,2) NULL DEFAULT '0.00',
		`price` DECIMAL(15,2) NULL DEFAULT '0.00',
		`expiry_date` text NULL ,
		`lot_number` text NULL,
		`from_stock_name` int(11),
		`to_stock_name` int(11),
		`serial_number` VARCHAR(255) NULL,

		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	}

	if (!$db->tableExists($dbprefix . 'inventory_manage')) {
		$db->query('CREATE TABLE `' . $dbprefix . "inventory_manage` (
			`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`warehouse_id` int(11) NOT NULL ,
			`commodity_id` int(11) NOT NULL,
			`inventory_number` DECIMAL(15,2) NULL DEFAULT '0.00',
			`date_manufacture` date NULL,
			`expiry_date` date NULL,
			`lot_number` varchar(100),
			`purchase_price` DECIMAL(15,2) NULL DEFAULT '0.00',

			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	}

	if (!$db->tableExists($dbprefix . 'inventory_commodity_min')) {
		$db->query('CREATE TABLE `' . $dbprefix . "inventory_commodity_min` (
		`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`commodity_id` int(11) NOT NULL,
		`commodity_code` varchar(100) NULL,
		`commodity_name` varchar(100) NULL,
		`inventory_number_min` DECIMAL(15,2) NULL DEFAULT '0.00',
		`inventory_number_max` DECIMAL(15,2) NULL DEFAULT '0.00',

		PRIMARY KEY (`id`, `commodity_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
	}

if (!$db->tableExists($dbprefix . 'wh_approval_setting')) {
	$db->query('CREATE TABLE `' . $dbprefix ."wh_approval_setting` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`related` VARCHAR(255) NOT NULL,
	`setting` LONGTEXT NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_approval_details')) {
	$db->query('CREATE TABLE `' . $dbprefix ."wh_approval_details` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`rel_id` INT(11) NOT NULL,
	`rel_type` VARCHAR(45) NOT NULL,
	`staffid` VARCHAR(45) NULL,
	`approve` VARCHAR(45) NULL,
	`note` TEXT NULL,
	`date` DATETIME NULL,
	`approve_action` VARCHAR(255) NULL,
	`reject_action` VARCHAR(255) NULL,
	`approve_value` VARCHAR(255) NULL,
	`reject_value` VARCHAR(255) NULL,
	`staff_approve` INT(11) NULL,
	`action` VARCHAR(45) NULL,
	`sender` INT(11) NULL,
	`date_send` DATETIME NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}



if (!$db->tableExists($dbprefix . 'goods_delivery')) {
	$db->query('CREATE TABLE `' . $dbprefix . "goods_delivery` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`rel_type` int(11) NULL COMMENT 'type goods delivery',
	`rel_document` int(11) NULL COMMENT 'document id of goods delivery',
	`customer_code` text NULL,
	`customer_name` varchar(100) NULL,
	`to_` varchar(100) NULL,
	`address` varchar(100) NULL,
	`description` text NULL COMMENT 'the reason delivery',
	`staff_id` int(11) NULL COMMENT 'salesman',
	`date_c` date NULL ,
	`date_add` date NULL,
	`goods_delivery_code` varchar(100) NULL ,
	`approval` INT(11) NULL DEFAULT 0 COMMENT 'status approval ',
	`addedfrom` INT(11) ,
	`total_money` DECIMAL(15,2) NULL DEFAULT '0.00',
	`warehouse_id` int(11) NULL,
	`total_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`after_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`invoice_id` varchar(100),
	`project` TEXT  NULL,
	`type` TEXT  NULL,
	`department` int(11)  NULL,
	`requester` int(11)  NULL,
	`invoice_no` text NULL,
	`pr_order_id` int(11) NULL,
	`type_of_delivery` VARCHAR(100)  NULL DEFAULT 'total',
	`additional_discount` DECIMAL(15,2) NULL DEFAULT '0',
	`sub_total` DECIMAL(15,2) NULL DEFAULT '0',
	`delivery_status` VARCHAR(100)  NULL DEFAULT 'ready_for_packing',
	`shipping_fee` DECIMAL(15,2) NULL DEFAULT '0.00',


	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'goods_delivery_detail')) {
	$db->query('CREATE TABLE `' . $dbprefix . "goods_delivery_detail` (
		`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`goods_delivery_id` int(11) NOT NULL,
		`commodity_code` varchar(100) NULL,
		`commodity_name` text NULL,
		`warehouse_id` text NULL,
		`unit_id` text NULL,
		`quantities` text NULL,
		`unit_price` varchar(100) NULL,
		`note` text NULL ,
		`discount` varchar(100),
		`discount_money` varchar(100),
		`available_quantity` varchar(100),
		`tax_id` varchar(100),
		`total_after_discount` varchar(100),
		`expiry_date` text  NULL,
		`lot_number` text NULL,
		`guarantee_period` text  NULL,
		`tax_rate` TEXT NULL,
		`tax_name` TEXT NULL,
		`sub_total` DECIMAL(15,2) NULL DEFAULT '0',
		`packing_qty` DECIMAL(15,2) NULL DEFAULT '0.00',
		`total_money` DECIMAL(15,2) NULL DEFAULT '0.00',
		`serial_number` VARCHAR(255) NULL,

		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_sub_group')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_sub_group` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`sub_group_code` varchar(100) NULL,
	`sub_group_name` text NULL,
	`order` int(10) NULL,
	`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
	`note` text NULL,
	`group_id` int(11)  NULL,

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'ware_color')) {
	$db->query('CREATE TABLE `' . $dbprefix . "ware_color` (
	`color_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`color_code` varchar(100) NULL,
	`color_name` varchar(100) NULL,
	`color_hex` text NULL,
	`order` int(10) NULL,
	`display` int(1) NULL COMMENT  'display 1: display (yes)  0: not displayed (no)',
	`note` text NULL,
	PRIMARY KEY (`color_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_loss_adjustment')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_loss_adjustment` (
		`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,     
		`type` varchar(15) NULL,     
		`addfrom` int(11) NULL,    
		`reason` LONGTEXT NULL,   
		`time` datetime NULL,
		`date_create` date NOT NULL,
		`status` int NOT NULL,  
		`warehouses` int(11) NULL, 
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_loss_adjustment_detail')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_loss_adjustment_detail` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`items` int(11) NULL, 
	`unit` int(11) NULL,
	`current_number` int(15) NULL,     
	`updates_number` int(15) NULL, 
	`loss_adjustment` INT(11) NULL,
	`expiry_date` text NULL ,
	`lot_number` text NULL,
	`commodity_name` TEXT NULL,
	`serial_number` VARCHAR(255) NULL,

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if ($db->tableExists($dbprefix . 'pur_order_detail')) {
	if (!$db->fieldExists('wh_quantity_received', $dbprefix.'pur_order_detail')) {
		$db->query('ALTER TABLE `' . $dbprefix . "pur_order_detail`
		ADD COLUMN `wh_quantity_received` varchar(200)  NULL
		;");
	}
}

if (!$db->tableExists($dbprefix . 'internal_delivery_note')) {
	$db->query('CREATE TABLE `' . $dbprefix . "internal_delivery_note` (
		`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

		`internal_delivery_name` text NULL ,
		`description` text NULL ,
		`staff_id` int(11) NULL ,
		`date_c` date NULL ,
		`date_add` date NULL,
		`internal_delivery_code` varchar(100) NULL ,
		`approval` INT(11) NULL DEFAULT 0 COMMENT 'status approval ',
		`addedfrom` INT(11) null,
		`total_amount` decimal(15,2) null ,
		`datecreated` datetime null ,

		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'internal_delivery_note_detail')) {
	$db->query('CREATE TABLE `' . $dbprefix . "internal_delivery_note_detail` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`internal_delivery_id` int(11) NOT NULL,
	`commodity_code` varchar(100) NULL,
	`from_stock_name` text NULL,
	`to_stock_name` text NULL,
	`unit_id` text NULL,
	`available_quantity` text NULL,
	`quantities` text NULL,
	`unit_price` varchar(100) NULL,
	`into_money` varchar(100) NULL,
	`note` text NULL ,
	`commodity_name` TEXT NULL,
	`serial_number` VARCHAR(255) NULL,

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}


if (!$db->tableExists($dbprefix . 'goods_delivery_invoices_pr_orders')) {
	$db->query('CREATE TABLE `' . $dbprefix . "goods_delivery_invoices_pr_orders` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`rel_id` int(11) NULL COMMENT  'goods_delivery_id',
	`rel_type` int(11) NULL COMMENT 'invoice_id or purchase order id',

	`type` varchar(100) NULL COMMENT'invoice,  purchase_orders',

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_goods_delivery_activity_log')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_goods_delivery_activity_log` (
		`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`rel_id` int NULL ,
		`rel_type` varchar(100) NULL ,
		`description` mediumtext NULL,
		`additional_data` text NULL,
		`date` datetime NULL,
		`staffid` int(11) NULL,
		`full_name` varchar(100) NULL,

		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->fieldExists('wh_delivered_quantity' ,$dbprefix . 'invoice_items')) { 
	$db->query('ALTER TABLE `' . $dbprefix . "invoice_items`
	ADD COLUMN `wh_delivered_quantity` DECIMAL(15,2)  DEFAULT '0'
	;");
}

if (!$db->tableExists($dbprefix . 'wh_packing_lists')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_packing_lists` (

	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`delivery_note_id` INT(11) NULL,
	`packing_list_number` VARCHAR(100) NULL,
	`packing_list_name` VARCHAR(200) NULL,
	`width` DECIMAL(15,2) NULL DEFAULT '0.00',
	`height` DECIMAL(15,2) NULL DEFAULT '0.00',
	`lenght` DECIMAL(15,2) NULL DEFAULT '0.00',
	`weight` DECIMAL(15,2) NULL DEFAULT '0.00',
	`volume` DECIMAL(15,2) NULL DEFAULT '0.00',
	`clientid` INT(11) NULL,
	`subtotal` DECIMAL(15,2) NULL DEFAULT '0.00',
	`total_amount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`discount_total` DECIMAL(15,2) NULL DEFAULT '0.00',
	`additional_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`total_after_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`billing_street` varchar(200) DEFAULT NULL,
	`billing_city` varchar(100) DEFAULT NULL,
	`billing_state` varchar(100) DEFAULT NULL,
	`billing_zip` varchar(100) DEFAULT NULL,
	`billing_country` int(11) DEFAULT NULL,
	`shipping_street` varchar(200) DEFAULT NULL,
	`shipping_city` varchar(100) DEFAULT NULL,
	`shipping_state` varchar(100) DEFAULT NULL,
	`shipping_zip` varchar(100) DEFAULT NULL,
	`shipping_country` int(11) DEFAULT NULL,
	`client_note` TEXT NULL,
	`admin_note` TEXT NULL,
	`approval` INT(11) NULL DEFAULT '0',
	`datecreated` DATETIME NULL,
	`staff_id` INT(11) NULL,
	`type_of_packing_list` VARCHAR(100)  NULL DEFAULT 'total',
	`delivery_status` VARCHAR(100)  NULL DEFAULT 'wh_ready_to_deliver',
	`shipping_fee` DECIMAL(15,2) NULL DEFAULT '0.00',

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_packing_list_details')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_packing_list_details` (

		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`packing_list_id` INT(11) NOT NULL,
		`delivery_detail_id` INT(11) NULL,
		`commodity_code` INT(11) NULL,
		`commodity_name` TEXT NULL,
		`quantity` DECIMAL(15,2) NULL DEFAULT '0.00',
		`unit_id` INT(11) NULL,
		`unit_price` DECIMAL(15,2) NULL DEFAULT '0.00',
		`sub_total` DECIMAL(15,2) NULL DEFAULT '0.00',
		`tax_id`  TEXT NULL,
		`tax_rate`  TEXT NULL,
		`tax_name`  TEXT NULL,
		`total_amount` DECIMAL(15,2) NULL DEFAULT '0.00',
		`discount` DECIMAL(15,2) NULL DEFAULT '0.00',
		`discount_total` DECIMAL(15,2) NULL DEFAULT '0.00',
		`total_after_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
		`serial_number` VARCHAR(255) NULL,

		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

//add shipment on Omnisales module
if (!$db->tableExists($dbprefix . 'wh_omni_shipments')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_omni_shipments` (

	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`cart_id` INT(11) NULL,
	`shipment_number` VARCHAR(100) NULL,
	`planned_shipping_date` DATETIME NULL,
	`shipment_status` VARCHAR(50) NULL,
	`datecreated` DATETIME NULL,
	`goods_delivery_id` INT(11) NULL,
	`shipment_hash` VARCHAR(32) NULL,

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_order_returns')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_order_returns` (

	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`rel_id` INT(11) NULL,
	`rel_type` VARCHAR(50) NOT NULL COMMENT'manual, sales_return_order, purchasing_return_order',
	`return_type` VARCHAR(50) NULL COMMENT'manual, partially, fully',
	`company_id` INT(11) NULL,
	`company_name` VARCHAR(500) NULL,
	`email` VARCHAR(100) NULL,
	`phonenumber` VARCHAR(20) NULL,
	`order_number` VARCHAR(500) NULL,
	`order_date` DATETIME NULL,
	`number_of_item` DECIMAL(15,2) NULL DEFAULT '0.00',
	`order_total` DECIMAL(15,2) NULL DEFAULT '0.00',
	`order_return_number` VARCHAR(200) NULL,
	`order_return_name` VARCHAR(500) NULL,
	`fee_return_order` DECIMAL(15,2) NULL DEFAULT '0.00',
	`refund_loyaty_point` INT(11) NULL DEFAULT '0',
	`subtotal` DECIMAL(15,2) NULL DEFAULT '0.00',
	`total_amount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`discount_total` DECIMAL(15,2) NULL DEFAULT '0.00',
	`additional_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`adjustment_amount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`total_after_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
	`return_policies_information` TEXT NULL,
	`admin_note` TEXT NULL,
	`approval` INT(11) NULL DEFAULT 0,
	`datecreated` DATETIME NULL,
	`staff_id` INT(11) NULL,
	`receipt_delivery_id` INT(1) NULL DEFAULT 0,
	`currency` INT(11) NULL,
	`return_reason` longtext NULL,
	`receipt_delivery_type` VARCHAR(100) NULL,

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_order_return_details')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_order_return_details` (

		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`order_return_id` INT(11) NOT NULL,
		`rel_type_detail_id` INT(11) NULL,
		`commodity_code` INT(11) NULL,
		`commodity_name` TEXT NULL,
		`quantity` DECIMAL(15,2) NULL DEFAULT '0.00',
		`unit_id` INT(11) NULL,
		`unit_price` DECIMAL(15,2) NULL DEFAULT '0.00',
		`sub_total` DECIMAL(15,2) NULL DEFAULT '0.00',
		`tax_id`  TEXT NULL,
		`tax_rate`  TEXT NULL,
		`tax_name`  TEXT NULL,
		`total_amount` DECIMAL(15,2) NULL DEFAULT '0.00',
		`discount` DECIMAL(15,2) NULL DEFAULT '0.00',
		`discount_total` DECIMAL(15,2) NULL DEFAULT '0.00',
		`total_after_discount` DECIMAL(15,2) NULL DEFAULT '0.00',
		`reason_return` VARCHAR(200) NULL,

		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

if (!$db->tableExists($dbprefix . 'wh_inventory_serial_numbers')) {
	$db->query('CREATE TABLE `' . $dbprefix . "wh_inventory_serial_numbers` (

	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`commodity_id` INT(11) NOT NULL,
	`warehouse_id` INT(11) NULL,
	`inventory_manage_id` INT(11) NULL,
	`serial_number` VARCHAR(255) NULL,
	`is_used` VARCHAR(20) NULL DEFAULT 'no',

	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
}

add_setting('warehouse_selling_price_rule_profif_ratio', 0, 1);
  /*value 0 purchase price, 1 selling price*/
  add_setting('profit_rate_by_purchase_price_sale', 0, 1);
  add_setting('warehouse_the_fractional_part', 0, 1);
  add_setting('warehouse_integer_part', 0, 1);
  add_setting('auto_create_goods_received', 0, 1);
  add_setting('auto_create_goods_delivery', 0, 1);
  add_setting('goods_receipt_warehouse', 0, 1);
  add_setting('barcode_with_sku_code', 0, 0);
  add_setting('revert_goods_receipt_goods_delivery', 0, 1);
  add_setting('cancelled_invoice_reverse_inventory_delivery_voucher', 0, 1);
  add_setting('uncancelled_invoice_create_inventory_delivery_voucher', 0, 1);
  add_setting('inventory_auto_operations_hour', 0, 1);
  add_setting('automatically_send_items_expired_before', 0, 1);
  add_setting('inventorys_cronjob_active', 0, 1);
  add_setting('inventory_cronjob_notification_recipients', '', 1);

  // create_email_template('Inventory warning', 'Hi {staff_name}! <br /><br />This is a inventory warning<br />{<span 12pt="">notification_content</span>}. <br /><br />Regards.', 'inventory_warning', 'Inventory warning (Sent to staff)', 'inventory-warning-to-staff');

  add_setting('inventory_received_number_prefix', 'NK', 1);
  add_setting('next_inventory_received_mumber', 1, 1);
  add_setting('inventory_delivery_number_prefix', 'XK', 1);
  add_setting('next_inventory_delivery_mumber', 1, 1);
  add_setting('internal_delivery_number_prefix', 'ID', 1);
  add_setting('next_internal_delivery_mumber', 1, 1);
  add_setting('item_sku_prefix', '', 1);
  add_setting('goods_receipt_required_po', 0, 1);
  add_setting('goods_delivery_required_po', 0, 1);
  add_setting('goods_delivery_pdf_display', 0, 1);
  add_setting('display_product_name_when_print_barcode', 0, 1);
  add_setting('show_item_cf_on_pdf', 0, 1);
  add_setting('goods_delivery_pdf_display_outstanding', 0, 1);
  add_setting('goods_delivery_pdf_display_warehouse_lotnumber_bottom_infor', 0, 1);
  add_setting('packing_list_number_prefix', 'PL', 1);
  add_setting('next_packing_list_number', 1, 1);
// return request must be placed within X days after the delivery date
  add_setting('wh_return_request_within_x_day', 30, 1);
  add_setting('wh_fee_for_return_order', 0, 1);
  add_setting('wh_return_policies_information', '', 1);
  add_setting('wh_refund_loyaty_point', '1', 1);
  add_setting('order_return_number_prefix', 'ReReturn', 1);
  add_setting('next_order_return_number', 1, 1);
  add_setting('e_order_return_number_prefix', 'DEReturn', 1);
  add_setting('e_next_order_return_number', 1, 1);
  add_setting('warehouse_receive_return_order', 0, 1);
  add_setting('wh_display_shipment_on_client_portal', 1, 1);

  if (!$db->tableExists($dbprefix . 'wh_activity_log')) {
  	$db->query('CREATE TABLE `' . $dbprefix . "wh_activity_log` (

  	`id` INT(11) NOT NULL AUTO_INCREMENT,
  	`rel_id` INT(11) NOT NULL,
  	`rel_type` VARCHAR(45) NOT NULL,
  	`staffid` INT(11) NULL,
  	`date` DATETIME NULL,
  	`note` TEXT NULL,

  	PRIMARY KEY (`id`)
  	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
  }
  
  if (!$db->fieldExists('long_descriptions', $dbprefix.'items')) {
	$db->query('ALTER TABLE `' . $dbprefix . "items`
        ADD COLUMN `long_descriptions` LONGTEXT NULL
    ;");
  }

  if (!$db->fieldExists('inventory_goods_receiving_id', $dbprefix.'notifications')) {
  	$db->query('ALTER TABLE `' . $dbprefix . "notifications`

  	ADD COLUMN `inventory_goods_receiving_id` int(1) NOT NULL DEFAULT '0',
  	ADD COLUMN `inventory_goods_delivery_id` int(1) NOT NULL DEFAULT '0',
  	ADD COLUMN `packing_list_id` int(1) NOT NULL DEFAULT '0',
  	ADD COLUMN `internal_delivery_note_id` int(1) NOT NULL DEFAULT '0',
  	ADD COLUMN `loss_adjustment_is` int(1) NOT NULL DEFAULT '0',
  	ADD COLUMN `receiving_exporting_return_order_id` int(1) NOT NULL DEFAULT '0'

  	;");
  }

  if (!$db->fieldExists('loss_adjustment_title', $dbprefix.'wh_loss_adjustment')) {
  	$db->query('ALTER TABLE `' . $dbprefix . "wh_loss_adjustment`
  	ADD COLUMN `loss_adjustment_title` VARCHAR(200) NULL
  	;");
  }
