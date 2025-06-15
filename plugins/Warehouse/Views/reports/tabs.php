<?php
$settings_menu = array(
	"inventory_settings" => array(
		array("name" => "stock_summary_report", "url" => "warehouse/stock_summary_report"),
		array("name" => "inventory_inside", "url" => "warehouse/inventory_analytics"),
		array("name" => "inventory_valuation_report", "url" => "warehouse/inventory_valuation_reports"),
		array("name" => "warranty_period_report", "url" => "warehouse/warranty_period_reports"),
	),

);

?>

	<?php
	foreach ($settings_menu as $key => $value) {

		//collapse the selected settings tab panel
		$collapse_in = "";
		$collapsed_class = "collapsed";
		if (in_array($active_tab, array_column($value, "name"))) {
			$collapse_in = "show";
			$collapsed_class = "";
		}
		?>

		<?php
		echo "<ul class='nav nav-tabs pb15 justify-content-left border-bottom-0'>";

		foreach ($value as $sub_setting) {
			$active_class = "";
			$setting_name = get_array_value($sub_setting, "name");
			$setting_url = get_array_value($sub_setting, "url");

			if ($active_tab == $setting_name) {
				$active_class = "active";
			}

			echo "<li class='nav-item' role='presentation'><a href='" . get_uri($setting_url) . "' class=' nav-link list-group-item $active_class'>" . app_lang($setting_name) . "</a></li>";
		}

		echo "</ul>";
	}
	?>
