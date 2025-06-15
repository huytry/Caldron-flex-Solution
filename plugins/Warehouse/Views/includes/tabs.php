<?php
$settings_menu = array(
	"inventory_settings" => array(
		array("name" => "general", "url" => "warehouse/general"),
		array("name" => "commodity_type", "url" => "warehouse/commodity_types"),
		array("name" => "commodity_group", "url" => "warehouse/commodity_groups"),
		array("name" => "units", "url" => "warehouse/units"),
		array("name" => "colors", "url" => "warehouse/colors"),
		array("name" => "models", "url" => "warehouse/models"),
		array("name" => "sizes", "url" => "warehouse/sizes"),
		array("name" => "styles", "url" => "warehouse/styles"),
		array("name" => "inventory", "url" => "warehouse/inventory"),
		array("name" => "inventory_setting", "url" => "warehouse/inventory_settings"),
		array("name" => "approval_setting", "url" => "warehouse/approval_settings"),
	),

);

if($login_user->is_admin){
	array_push($settings_menu["inventory_settings"], array("name" => "reset_data", "url" => "warehouse/reset_datas"));
}

?>

<ul class="nav nav-tabs vertical settings d-block" role="tablist">
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

		<div class="clearfix settings-anchor <?php echo html_entity_decode($collapsed_class); ?>" data-bs-toggle="collapse" data-bs-target="#settings-tab-<?php echo html_entity_decode($key); ?>">
			<?php echo app_lang($key); ?>
		</div>

		<?php
		echo "<div id='settings-tab-$key' class='collapse $collapse_in'>";
		echo "<ul class='list-group help-catagory'>";

		foreach ($value as $sub_setting) {
			$active_class = "";
			$setting_name = get_array_value($sub_setting, "name");
			$setting_url = get_array_value($sub_setting, "url");

			if ($active_tab == $setting_name) {
				$active_class = "active";
			}

			echo "<a href='" . get_uri($setting_url) . "' class='list-group-item $active_class'>" . app_lang($setting_name) . "</a>";
		}

		echo "</ul>";
		echo "</div>";
	}
	?>

</ul>