<?php

defined('PLUGINPATH') or exit('No direct script access allowed');

/*
	Plugin Name: Warehouse
	Description: Module manage warehouse, stock imported, stock export, Loss and adjustment,report...
	Version: 1.0.0
	Requires at least: 3.0
	Author: GreenTech Solutions
  	Author URI: https://codecanyon.net/user/greentech_solutions
 */
	use App\Controllers\Security_Controller;
	
/**
 * Modules Path
 */
	if(!defined('APP_MODULES_PATH')){
		define('APP_MODULES_PATH', FCPATH . 'plugins/');
	}

	if(!defined('EXT')){
		define('EXT', '.php');
	}

	if(!defined('WAREHOUSE_REVISION')){
	    define('WAREHOUSE_REVISION', 100);    
	}
	if(!defined('WAREHOUSE_MODULE_NAME')){
	    define('WAREHOUSE_MODULE_NAME', 'Warehouse');    
	}
	if(!defined('WAREHOUSE_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads');    
	}
	if(!defined('WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/stock_import/');    
	}
	if(!defined('WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/stock_export/');    
	}
	if(!defined('WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/lost_adjustment/');    
	}
	if(!defined('WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/lost_adjustment/');    
	}
	if(!defined('WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/internal_delivery/');    
	}
	if(!defined('WAREHOUSE_PACKING_LIST_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_PACKING_LIST_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/packing_lists/');    
	}
	if(!defined('WAREHOUSE_ORDER_RETURN_MODULE_UPLOAD_FOLDER')){
	    define('WAREHOUSE_ORDER_RETURN_MODULE_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/order_returns/');    
	}
	if(!defined('WAREHOUSE_PROPOSAL_UPLOAD_FOLDER')){
	    define('WAREHOUSE_PROPOSAL_UPLOAD_FOLDER', 'plugins/Warehouse/Uploads/proposal/');    
	}
	if(!defined('WAREHOUSE_ITEM_UPLOAD')){
	    define('WAREHOUSE_ITEM_UPLOAD', 'plugins/Warehouse/Uploads/item_img/');    
	}
	if(!defined('WAREHOUSE_PRINT_ITEM')){
	    define('WAREHOUSE_PRINT_ITEM', 'plugins/Warehouse/Uploads/print_item/');    
	}
	if(!defined('WAREHOUSE_EXPORT_ITEM')){
	    define('WAREHOUSE_EXPORT_ITEM', 'plugins/Warehouse/Uploads/export_item/');    
	}
	if(!defined('WAREHOUSE_IMPORT_ITEM_ERROR')){
	    define('WAREHOUSE_IMPORT_ITEM_ERROR', 'plugins/Warehouse/Uploads/import_item_error/');    
	}	
	if(!defined('WAREHOUSE_IMPORT_OPENING_STOCK')){
	    define('WAREHOUSE_IMPORT_OPENING_STOCK', 'plugins/Warehouse/Uploads/import_opening_stock_error/');    
	}
	if(!defined('WAREHOUSE_PATH_LIBRARIES')){
	    define('WAREHOUSE_PATH_LIBRARIES', 'plugins/Warehouse/Libraries');    
	}
	if(!defined('WAREHOUSE_PATH')){
	    define('WAREHOUSE_PATH', 'plugins/Warehouse/Uploads/');    
	}
	if(!defined('COMMODITY_ERROR')){
	    define('COMMODITY_ERROR', FCPATH);    
	}
	if(!defined('COMMODITY_EXPORT')){
	    define('COMMODITY_EXPORT', FCPATH);    
	}	

	app_hooks()->add_filter('app_hook_head_extension', function () {
		$viewuri = $_SERVER['REQUEST_URI'];

		if (!(strpos($viewuri, '/warehouse') === false)) {  
				echo '<link href="' . base_url('plugins/Warehouse/assets/css/main.css') .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
				echo '<link href="' . base_url('plugins/Warehouse/assets/plugins/handsontable/handsontable.full.min.css') . '"  rel="stylesheet" type="text/css" />';
				echo '<link href="' . base_url('plugins/Warehouse/assets/plugins/handsontable/chosen.css') . '"  rel="stylesheet" type="text/css" />';
				echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/handsontable/handsontable.full.min.js') . '"></script>';
		}

		if (!(strpos($viewuri, '/warehouse/setting?group=bodys') === false)) { 

				echo '<link href="' . base_url('plugins/Warehouse/assets/css/body.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}

		if (!(strpos($viewuri, '/warehouse/setting?group=colors') === false)) { 

				echo '<link href="' . base_url('plugins/Warehouse/assets/css/body.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}

		if (!(strpos($viewuri, '/warehouse/setting?group=commodity_group') === false)) {     
				echo '<link href="' . base_url('plugins/Warehouse/assets/css/body.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}
		if (!(strpos($viewuri, '/warehouse/setting?group=commodity_type') === false)) {
				echo '<link href="' . base_url('plugins/Warehouse/assets/css/body.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}

		if (!(strpos($viewuri, '/warehouse/manage_report') === false)) {
				echo '<link href="' . base_url('plugins/Warehouse/assets/css/report.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}

		if (!(strpos($viewuri, '/warehouse/manage_report?group=inventory_valuation_report') === false)) {
				echo '<link href="' . base_url('plugins/Warehouse/assets/css/report.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}
		

		if (!(strpos($viewuri, '/warehouse/setting?group=approval_setting') === false)) {
				echo '<link href="' . base_url('plugins/Warehouse/assets/css/approval_setting.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}   
		
		 if (!(strpos($viewuri, '/warehouse/setting') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/body.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}   

		if (!(strpos($viewuri, '/warehouse/setting?group=rule_sale_price') === false) || !(strpos($viewuri, '/warehouse/setting') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/rule_sale_price.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}

		if (!(strpos($viewuri, '/warehouse/setting?group=inventory_setting') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/rule_sale_price.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		} 

		if (!(strpos($viewuri, '/proposals/proposal') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/proposal_add_new_lead.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}
		 if (!(strpos($viewuri, '/warehouse/setting?group=warehouse_custom_fields') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/warehouse_custom_fields.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}

		if (!(strpos($viewuri, '/warehouse/import_opening_stock') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/import_opening_stock.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />'; 
		}
		
		if (!(strpos($viewuri, '/warehouse/import_xlsx_commodity') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/import_opening_stock.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />'; 
		}
		
		if (!(strpos($viewuri, '/warehouse/goods_delivery') === false) || !(strpos($viewuri, '/warehouse/manage_goods_receipt') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/goods_delivery.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />'; 
		}
		 
		if (!(strpos($viewuri, '/warehouse/commodity_list') === false)) {
				echo '<link href="' . base_url('plugins/Warehouse/assets/css/items/item_modal.css') .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />';
		}

		if (!(strpos($viewuri, '/warehouse/shipment_detail') === false)) {
			 echo '<link href="' . base_url('plugins/Warehouse/assets/css/shipments/order_status.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />'; 
		}

		
		if (!(strpos($viewuri, '/warehouse/import_serial_number') === false)) {
			echo '<link href="' . base_url('plugins/Warehouse/assets/css/import_opening_stock.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />'; 
		}
		if (!(strpos($viewuri, '/warehouse/view_delivery') === false) || !(strpos($viewuri, '/warehouse/view_packing_list') === false)) {
			echo '<link href="' . base_url('plugins/Warehouse/assets/css/goods_delivery_detail/goods_delivery_detail.css')  .'?v=' . WAREHOUSE_REVISION. '"  rel="stylesheet" type="text/css" />'; 
		}
	});
	
	app_hooks()->add_filter('app_hook_head_extension', function () {
		$viewuri = $_SERVER['REQUEST_URI'];

		if (!(strpos($viewuri, '/warehouse') === false)) {   
				 echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/handsontable/chosen.jquery.js') . '"></script>';
				 echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/handsontable/handsontable-chosen-editor.js') . '"></script>';
				 echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/signature_pad.min.js') . '"></script>';
				 echo '<script src="' . base_url('plugins/Warehouse/assets/plugins/main/main.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}

		if (!(strpos($viewuri, '/warehouse/setting?group=approval_setting') === false)) {

				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/approval_setting.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/manage_setting.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}

		if (!(strpos($viewuri, '/warehouse/setting?group=approval_setting') === false)) {
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/manage_setting.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}

		if (!(strpos($viewuri, '/warehouse/setting?group=colors') === false)) {
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/color.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}

		if (!(strpos($viewuri, '/warehouse/manage_report') === false)) { 
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/stock_summary_report.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
				echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/inventory_valuation_report.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}

		if (!(strpos($viewuri, '/warehouse/manage_stock_take') === false)) { 
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/manage_stock_take.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}


		if (!(strpos($viewuri, '/warehouse/setting') === false)) { 
				echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/manage_setting.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}
		
		if (!(strpos($viewuri, '/warehouse/setting?group=brand') === false)) {
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/brand.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}
		if (!(strpos($viewuri, '/warehouse/setting?group=model') === false)) {
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/model.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}
		if (!(strpos($viewuri, '/warehouse/setting?group=series') === false)) {
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/series.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}
		if (!(strpos($viewuri, '/warehouse/setting?group=warehouse_custom_fields') === false)) {
				 echo '<script src="' . base_url(WAREHOUSE_MODULE_NAME, 'assets/js/warehouse_custom_fields.js').'?v=' . WAREHOUSE_REVISION.'"></script>';
		}
	});
	
	app_hooks()->add_filter('app_filter_notification_config', function ($events) {
		return $events;
	});
	app_hooks()->add_action('app_hook_role_permissions_extension', function ($permissions) {
		$ci = new Security_Controller(false);
	    $access_inventory = get_array_value($permissions, "inventory");
	    if (is_null($access_inventory)) {
	        $access_inventory = "";
	    }

	    echo '<li>
	        <span data-feather="key" class="icon-14 ml-20"></span>
	        <h5>'. app_lang("can_access_inventorys").'</h5>
	        <div>'.
	            form_radio(array(
	                "id" => "inventory_no",
	                "name" => "inventory_permission",
	                "value" => "",
	                "class" => "form-check-input"
	                    ), $access_inventory, ($access_inventory === "") ? true : false)
	            .'<label for="inventory_no">'. app_lang("no").' </label>
	        </div>
	        <div>
	            '. form_radio(array(
	                "id" => "inventory_yes",
	                "name" => "inventory_permission",
	                "value" => "all",
	                "class" => "form-check-input"
	                    ), $access_inventory, ($access_inventory === "all") ? true : false).'
	            <label for="inventory_yes">'. app_lang("yes").'</label>
	        </div>
	    </li>';
	});

	app_hooks()->add_filter('app_filter_role_permissions_save_data', function ($permissions,$data) {
		$inventory = $data['inventory_permission'];

	    $permissions = array_merge($permissions, ['inventory' => $inventory]);

	    return $permissions;
	});
	
	app_hooks()->add_filter('app_filter_notification_config', function ($events) {
		$inventory_receiving_link = function ($options) {
			$url = "";
			if (isset($options->inventory_goods_receiving_id)) {
				$url = get_uri("warehouse/goods_receipt_detail/" . $options->inventory_goods_receiving_id);
			}

			return array("url" => $url);
		};

		$inventory_delivery_link = function ($options) {
			$url = "";
			if (isset($options->inventory_goods_delivery_id)) {
				$url = get_uri("warehouse/view_delivery/" . $options->inventory_goods_delivery_id);
			}

			return array("url" => $url);
		};

		$loss_adjustment_link = function ($options) {
			$url = "";
			if (isset($options->loss_adjustment_is)) {
				$url = get_uri("warehouse/view_lost_adjustment/" . $options->loss_adjustment_is);
			}

			return array("url" => $url);
		};

		$internal_delivery_link = function ($options) {
			$url = "";
			if (isset($options->internal_delivery_note_id)) {
				$url = get_uri("warehouse/view_internal_delivery/" . $options->internal_delivery_note_id);
			}

			return array("url" => $url);
		};

		$packing_list_link = function ($options) {
			$url = "";
			if (isset($options->packing_list_id)) {
				$url = get_uri("warehouse/view_packing_list/" . $options->packing_list_id);
			}

			return array("url" => $url);
		};

		$order_return_link = function ($options) {
			$url = "";
			if (isset($options->receiving_exporting_return_order_id)) {
				$url = get_uri("warehouse/view_order_return/" . $options->receiving_exporting_return_order_id);
			}

			return array("url" => $url);
		};
		
		$events["notify_send_request_approve_stock_import"] = [
				"notify_to" => array("team_members"),
				"info" => $inventory_receiving_link
		];

		$events["notify_send_approve_stock_import"] = [
				"notify_to" => array("team_members"),
				"info" => $inventory_receiving_link
		];
		$events["notify_send_rejected_stock_import"] = [
				"notify_to" => array("team_members"),
				"info" => $inventory_receiving_link
		];

		$events["notify_send_request_approve_stock_export"] = [
				"notify_to" => array("team_members"),
				"info" => $inventory_delivery_link
		];
		$events["notify_send_approve_stock_export"] = [
				"notify_to" => array("team_members"),
				"info" => $inventory_delivery_link
		];

		$events["notify_send_rejected_stock_export"] = [
				"notify_to" => array("team_members"),
				"info" => $inventory_delivery_link
		];

		$events["notify_send_request_approve_loss_adjustment"] = [
				"notify_to" => array("team_members"),
				"info" => $loss_adjustment_link
		];

		$events["notify_send_approve_loss_adjustment"] = [
				"notify_to" => array("team_members"),
				"info" => $loss_adjustment_link
		];

		$events["notify_send_rejected_loss_adjustment"] = [
				"notify_to" => array("team_members"),
				"info" => $loss_adjustment_link
		];

		$events["notify_send_request_approve_internal_delivery_note"] = [
				"notify_to" => array("team_members"),
				"info" => $internal_delivery_link
		];
		$events["notify_send_approve_internal_delivery_note"] = [
				"notify_to" => array("team_members"),
				"info" => $internal_delivery_link
		];
		$events["notify_send_rejected_internal_delivery_note"] = [
				"notify_to" => array("team_members"),
				"info" => $internal_delivery_link
		];

		$events["notify_send_request_approve_packing_list"] = [
				"notify_to" => array("team_members"),
				"info" => $packing_list_link
		];
		$events["notify_send_approve_packing_list"] = [
				"notify_to" => array("team_members"),
				"info" => $packing_list_link
		];
		$events["notify_send_rejected_packing_list"] = [
				"notify_to" => array("team_members"),
				"info" => $packing_list_link
		];

		$events["notify_send_request_approve_order_return"] = [
				"notify_to" => array("team_members"),
				"info" => $order_return_link
		];
		$events["notify_send_approve_order_return"] = [
				"notify_to" => array("team_members"),
				"info" => $order_return_link
		];
		$events["notify_send_rejected_order_return"] = [
				"notify_to" => array("team_members"),
				"info" => $order_return_link
		];

		return $events;
	});
	
	if(!defined('VIEWPATH')){
	    define('VIEWPATH', 'plugins/Warehouse');    
	}


//add menu item to left menu
	app_hooks()->add_filter('app_filter_staff_left_menu', function ($sidebar_menu) {
		$warehouse_submenu = array();
		$ci = new Security_Controller(false);
		$permissions = $ci->login_user->permissions;

		if ($ci->login_user->is_admin || get_array_value($permissions, "inventory")) {
			$warehouse_submenu["commodity_list"] = array(
				"name" => "items", 
				"url" => "warehouse/commodity_list", 
				"class" => "users",
			);
			$warehouse_submenu["manage_purchase"] = array(
				"name" => "stock_import", 
				"url" => "warehouse/manage_purchase", 
				"class" => "users",
			);
			$warehouse_submenu["manage_delivery"] = array(
				"name" => "stock_export", 
				"url" => "warehouse/manage_delivery", 
				"class" => "users",
			);
			$warehouse_submenu["manage_packing_list"] = array(
				"name" => "wh_packing_lists", 
				"url" => "warehouse/manage_packing_list", 
				"class" => "users",
			);
			$warehouse_submenu["manage_internal_delivery"] = array(
				"name" => "internal_delivery_note", 
				"url" => "warehouse/manage_internal_delivery", 
				"class" => "users",
			);
			$warehouse_submenu["loss_adjustment"] = array(
				"name" => "loss_adjustment", 
				"url" => "warehouse/loss_adjustment", 
				"class" => "users",
			);
			$warehouse_submenu["manage_order_return"] = array(
				"name" => "inventory_receipt_inventory_delivery_returns_goods", 
				"url" => "warehouse/manage_order_return", 
				"class" => "users",
			);
			$warehouse_submenu["warehouses"] = array(
				"name" => "wh_warehouses", 
				"url" => "warehouse/warehouses", 
				"class" => "users",
			);
			$warehouse_submenu["warehouse_history"] = array(
				"name" => "warehouse_history", 
				"url" => "warehouse/warehouse_history", 
				"class" => "users",
			);
			$warehouse_submenu["manage_report"] = array(
				"name" => "report", 
				"url" => "warehouse/inventory_analytics", 
				"class" => "users",
			);
			$warehouse_submenu["general"] = array(
				"name" => "settings", 
				"url" => "warehouse/general", 
				"class" => "users",
			);


			$sidebar_menu["warehouse"] = array(
				"name" => "warehouse",
				"url" => "warehouse",
				"class" => "home",
				"submenu" => $warehouse_submenu,
				"position" => 6,

			);
		}

		return $sidebar_menu;

	});



//install dependencies
	register_installation_hook("Warehouse", function ($item_purchase_code) {
	/*
	 * you can verify the item puchase code from here if you want. 
	 * you'll get the inputted puchase code with $item_purchase_code variable
	 * use exit(); here if there is anything doesn't meet it's requirements
	 */	
	include PLUGINPATH . "Warehouse/lib/gtsverify.php";
	require_once(__DIR__ . '/install.php');
});

// Active action
	register_activation_hook("Warehouse", function ($item_purchase_code) {
		require_once(__DIR__ . '/install.php');
	});

//add setting link to the plugin setting
	app_hooks()->add_filter('app_filter_action_links_of_Warehouse', function () {
		$action_links_array = array(
		);

		return $action_links_array;
	});

//update plugin
	register_update_hook("Warehouse", function () {
		require_once __DIR__ . '/install.php';
	});

//uninstallation: remove data from database
	register_uninstallation_hook("Warehouse", function () {
		require_once __DIR__ . '/uninstall.php';
	});

app_hooks()->add_action('app_hook_inventory_init', function (){
    require_once __DIR__ .'/lib/gtsslib.php';
    $lic_inventory = new InventoryLic();
    $inventory_gtssres = $lic_inventory->verify_license(true);    
    if(!$inventory_gtssres || ($inventory_gtssres && isset($inventory_gtssres['status']) && !$inventory_gtssres['status'])){
        echo '<strong>YOUR INVENTORY PLUGIN FAILED ITS VERIFICATION. PLEASE <a href="/index.php/Plugins">REINSTALL</a> OR CONTACT SUPPORT</strong>';
        exit();
    } 
});
app_hooks()->add_action('app_hook_uninstall_plugin_Warehouse', function (){
    require_once __DIR__ .'/lib/gtsslib.php';
    $lic_inventory = new InventoryLic();
    $lic_inventory->deactivate_license();    
});


