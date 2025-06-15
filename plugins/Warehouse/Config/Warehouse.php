<?php

namespace Warehouse\Config;

use CodeIgniter\Config\BaseConfig;
use Warehouse\Models\Warehouse_model;

class Warehouse extends BaseConfig {

	public $app_settings_array = array(
		"warehouse_file_path" => PLUGIN_URL_PATH . "Warehouse/files/warehouse_files/"
	);

	public function __construct() {
		
	}

}
