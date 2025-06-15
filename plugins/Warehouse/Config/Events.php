<?php

namespace Warehouse\Config;

use CodeIgniter\Events\Events;

Events::on('pre_system', function () {
	helper("warehouse_general");
	helper("warehouse_datatables");
	helper("warehouse_convert_field");
	helper("notifications_helper");
});