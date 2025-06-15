<?php
use App\Controllers\Security_Controller;


/**
 * Function that renders input for admin area based on passed arguments
 * @param  string $name             input name
 * @param  string $label            label name
 * @param  string $value            default value
 * @param  string $type             input type eq text,number
 * @param  array  $input_attrs      attributes on <input
 * @param  array  $form_group_attr  <div class="form-group"> html attributes
 * @param  string $form_group_class additional form group class
 * @param  string $input_class      additional class on input
 * @return string
 */
if (!function_exists('render_input1')) {
	function render_input1($name, $label = '', $value = '', $type = 'text', array $input_attrs = [], array $form_group_attr = [], $form_group_class = '', $input_class = '', $data_required = false, $data_required_msg = '', $placeholder = false)
	{
		if($value == null){
			$value = '';
		}

		$input            = '';
		$_form_group_attr = '';

		$form_group_attr['app-field-wrapper'] = $name;

		foreach ($form_group_attr as $key => $val) {
		// tooltips
			if ($key == 'title') {
				$val = _l($val);
			}
			$_form_group_attr .= $key . '=' . '"' . $val . '" ';
		}

		$_form_group_attr = rtrim($_form_group_attr);

		if (!empty($form_group_class)) {
			$form_group_class = ' ' . $form_group_class;
		}
		if (!empty($input_class)) {
			$input_class = ' ' . $input_class;
		}
		$input .= '<div class="form-group' . $form_group_class . '" ' . $_form_group_attr . '>';
		if ($label != '') {
			if($data_required){
				$input .= '<small class="req text-danger">* </small><label for="' . $name . '" class="control-label">' . _l($label, '', false) . '</label>';
			}else{
				$input .= '<label for="' . $name . '" class="control-label">' . _l($label, '', false) . '</label>';
			}
		}

		if($data_required){
			$arr_required = [];
			$arr_required = [
				"data-rule-required" => $data_required,
				"data-msg-required" => $data_required_msg == '' ? app_lang('field_required') : app_lang($data_required_msg),
				"required" => true,
			];
			$input_attrs = array_merge($input_attrs, $arr_required );
		}
		$input .= form_input(array_merge(array(
			"id" => $name,
			"name" => $name,
			"value" => $value,
			"class" => "form-control".$input_class,
			"placeholder" => $placeholder == true ? app_lang($label) : '',
			"autocomplete" => "off",
			
		), $input_attrs), $value, '', $type);

		$input .= '</div>';

		return $input;
	}
}

if (!function_exists('render_textarea1')) {
	function render_textarea1($name, $label = '', $value = '', $textarea_attrs = [], $form_group_attr = [], $form_group_class = '', $textarea_class = '', $placeholder = false)
	{
		if($value == null){
			$value = '';
		}

		$textarea         = '';
		$_form_group_attr = '';
		$_textarea_attrs  = '';
		if (!isset($textarea_attrs['rows'])) {
			$textarea_attrs['rows'] = 4;
		}

		if (isset($textarea_attrs['class'])) {
			$textarea_class .= ' ' . $textarea_attrs['class'];
			unset($textarea_attrs['class']);
		}

		foreach ($textarea_attrs as $key => $val) {
			// tooltips
			if ($key == 'title') {
				$val = _l($val);
			}
			$_textarea_attrs .= $key . '=' . '"' . $val . '" ';
		}

		$_textarea_attrs = rtrim($_textarea_attrs);

		$form_group_attr['app-field-wrapper'] = $name;

		foreach ($form_group_attr as $key => $val) {
			if ($key == 'title') {
				$val = _l($val);
			}
			$_form_group_attr .= $key . '=' . '"' . $val . '" ';
		}

		$_form_group_attr = rtrim($_form_group_attr);

		if (!empty($textarea_class)) {
			$textarea_class = trim($textarea_class);
			$textarea_class = ' ' . $textarea_class;
		}
		if (!empty($form_group_class)) {
			$form_group_class = ' ' . $form_group_class;
		}
		$textarea .= '<div class="form-group' . $form_group_class . '" ' . $_form_group_attr . '>';
		if ($label != '') {
			$textarea .= '<label for="' . $name . '" class="control-label">' . _l($label, '', false) . '</label>';
		}

		$textarea .=  form_textarea(array_merge(array(
			"id" => $name,
			"name" => $name,
			"value" => $value,
			"class" => "form-control". $textarea_class,
			"placeholder" => $placeholder == true ? app_lang($label) : '',
			"data-rich-text-editor" => true
		), $textarea_attrs), $value );

		$textarea .= '</div>';

		return $textarea;
	}
}

if (!function_exists('render_select1')) {

	function render_select1($name, $options, $option_attrs = [], $label = '', $selected = '', $select_attrs = [], $form_group_attr = [], $form_group_class = '', $select_class = '', $include_blank = true, $data_required = false, $data_required_msg = '')
	{
		$callback_translate = '';
		if (isset($options['callback_translate'])) {
			$callback_translate = $options['callback_translate'];
			unset($options['callback_translate']);
		}
		$select           = '';
		$_form_group_attr = '';
		$_select_attrs    = '';
		if (!isset($select_attrs['data-width'])) {
			$select_attrs['data-width'] = '100%';
		}

		if($data_required){
			$arr_required = [];
			$arr_required = [
				"data-rule-required" => $data_required,
				"data-msg-required" => $data_required_msg == '' ? app_lang('field_required') : app_lang($data_required_msg),
				"required" => true,
			];
			$select_attrs = array_merge($select_attrs, $arr_required );
		}
		
		if (!isset($select_attrs['data-none-selected-text'])) {
			$select_attrs['data-none-selected-text'] = app_lang('dropdown_non_selected_tex');
		}
		foreach ($select_attrs as $key => $val) {
		// tooltips
			if ($key == 'title') {
				$val = app_lang($val);
			}
			$_select_attrs .= $key . '=' . '"' . $val . '" ';
		}

		$_select_attrs = rtrim($_select_attrs);

		$form_group_attr['app-field-wrapper'] = $name;
		foreach ($form_group_attr as $key => $val) {
		// tooltips
			if ($key == 'title') {
				$val = app_lang($val);
			}
			$_form_group_attr .= $key . '=' . '"' . $val . '" ';
		}
		$_form_group_attr = rtrim($_form_group_attr);
		if (!empty($select_class)) {
			$select_class = ' ' . $select_class;
		}
		if (!empty($form_group_class)) {
			$form_group_class = ' ' . $form_group_class;
		}
		$select .= '<div class="select-placeholder form-group' . $form_group_class . '" ' . $_form_group_attr . '>';
		if ($label != '') {
			if($data_required){
				$select .= '<small class="req text-danger">* </small><label for="' . $name . '" class="control-label">' . _l($label, '', false) . '</label>';
			}else{
				$select .= '<label for="' . $name . '" class="control-label">' . app_lang($label, '', false) . '</label>';
			}
		}
		$select .= '<select id="' . $name . '" name="' . $name . '" class="select2 validate-hidden' . $select_class . '" ' . $_select_attrs . ' data-live-search="true">';
		if ($include_blank == true) {
			$select .= '<option value="">-</option>';
		}
		foreach ($options as $option) {
			$val       = '';
			$_selected = '';
			$key       = '';
			if (isset($option[$option_attrs[0]]) && !empty($option[$option_attrs[0]])) {
				$key = $option[$option_attrs[0]];
			}
			if (!is_array($option_attrs[1])) {
				$val = $option[$option_attrs[1]];
			} else {
				foreach ($option_attrs[1] as $_val) {
					$val .= $option[$_val] . ' ';
				}
			}
			$val = trim($val);

			if ($callback_translate != '') {
				if (function_exists($callback_translate) && is_callable($callback_translate)) {
					$val = call_user_func($callback_translate, $key);
				}
			}

			$data_sub_text = '';
			if (!is_array($selected)) {
				if ($selected != '') {
					if ($selected == $key) {
						$_selected = ' selected="selected"';
					}
				}
			} else {
				foreach ($selected as $id) {
					if ($key == $id) {
						$_selected = ' selected="selected"';
					}
				}
			}

			if (isset($option_attrs[2])) {
				if (strpos($option_attrs[2], ',') !== false) {
					$sub_text = '';
					$_temp    = explode(',', $option_attrs[2]);
					foreach ($_temp as $t) {
						if (isset($option[$t])) {
							$sub_text .= $option[$t] . ' ';
						}
					}
				} else {
					if (isset($option[$option_attrs[2]])) {
						$sub_text = $option[$option_attrs[2]];
					} else {
						$sub_text = $option_attrs[2];
					}
				}
				$data_sub_text = ' data-subtext=' . '"' . $sub_text . '"';
			}
			$data_content = '';
			if (isset($option['option_attributes'])) {
				foreach ($option['option_attributes'] as $_opt_attr_key => $_opt_attr_val) {
					$data_content .= $_opt_attr_key . '=' . '"' . $_opt_attr_val . '"';
				}
				if ($data_content != '') {
					$data_content = ' ' . $data_content;
				}
			}
			$select .= '<option value="' . $key . '"' . $_selected . $data_content . $data_sub_text . '>' . $val . '</option>';
		}
		$select .= '</select>';
		$select .= '</div>';

		return $select;
	}
}

function get_status_modules_wh($module_name){
		return false;
}

if (!function_exists('render_color_picker1')) {
	function render_color_picker1($name, $label = '', $value = '', $input_attrs = [])
	{
		$_input_attrs = '';
		foreach ($input_attrs as $key => $val) {
        // tooltips
			if ($key == 'title') {
				$val = _l($val);
			}
			$_input_attrs .= $key . '=' . '"' . $val . '"';
		}

		$picker = '';
		$picker .= '<div class="form-group" app-field-wrapper="' . $name . '">';
		$picker .= '<label for="' . $name . '" class="control-label">' . $label . '</label>';
		$picker .= '<div class="input-group mbot15 colorpicker-input">
		<input type="color" value="' . set_value($name, $value) . '" name="' . $name . '" id="' . $name . '" class="form-control form-control-color" ' . $_input_attrs . ' />
		<span class="input-group-addon"><i></i></span>
		</div>';
		$picker .= '</div>';

		return $picker;
	}
}

if (!function_exists('render_date_input1')) {

	function render_date_input1($name, $label = '', $value = '', array $input_attrs = [], array $form_group_attr = [], $form_group_class = '', $input_class = '', $data_required = false, $data_required_msg = '', $placeholder = false)
	{
		if($value == null){
			$value = '';
		}

		$type = 'text';
		$input            = '';
		$_form_group_attr = '';

		$form_group_attr['app-field-wrapper'] = $name;

		foreach ($form_group_attr as $key => $val) {
		// tooltips
			if ($key == 'title') {
				$val = _l($val);
			}
			$_form_group_attr .= $key . '=' . '"' . $val . '" ';
		}

		$_form_group_attr = rtrim($_form_group_attr);

		if (!empty($form_group_class)) {
			$form_group_class = ' ' . $form_group_class;
		}
		if (!empty($input_class)) {
			$input_class = ' ' . $input_class;
		}
		$input .= '<div class="form-group' . $form_group_class . '" ' . $_form_group_attr . '>';
		if ($label != '') {
			if($data_required){
				$input .= '<small class="req text-danger">* </small><label for="' . $name . '" class="control-label">' . _l($label, '', false) . '</label>';
			}else{
				$input .= '<label for="' . $name . '" class="control-label">' . _l($label, '', false) . '</label>';
			}
		}

		if($data_required){
			$arr_required = [];
			$arr_required = [
				"data-rule-required" => $data_required,
				"data-msg-required" => $data_required_msg == '' ? app_lang('field_required') : app_lang($data_required_msg),
				"required" => true,
			];
			$input_attrs = array_merge($input_attrs, $arr_required );
		}
		$input .= form_input(array_merge(array(
			"id" => $name,
			"name" => $name,
			"value" => $value,
			"class" => "form-control datePickerInput".$input_class,
			"placeholder" => $placeholder == true ? app_lang($label) : '',
			"autocomplete" => "off",
			
		), $input_attrs), $value, '', $type);

		$input .= '</div>';

		return $input;
	}
}

if (!function_exists('get_tax_by_name')) {
	function get_tax_by_name($name)
	{
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'taxes');
		$builder->where('id', $id);
		$CI->db->where('title', $name);
		return $builder->get()->getRow();
	}
}

if (!function_exists('valueExistsByKey')) {
	function valueExistsByKey($array, $key, $val)
	{
		foreach ($array as $item) {
			if (isset($item[$key]) && $item[$key] == $val) {
				return true;
			}
		}

		return false;
	}
}


if (!function_exists('get_current_date_format1')) {
	function get_current_date_format1($php = false)
	{
		$format = get_setting('date_format');
		$format = explode('|', $format);

		if ($php == false) {
			return $format[1];
		}

		return $format[0];
	}
}

if (!function_exists('to_sql_date1')) {

	function to_sql_date1($date, $datetime = false)
	{
		if ($date == '' || $date == null) {
			return null;
		}

		$to_date     = 'Y-m-d';
		$from_format = get_current_date_format1(true);

		$date = app_hooks()->apply_filters('before_sql_date_format', $date, [
			'from_format' => $from_format,
			'is_datetime' => $datetime,
		]);

		if ($datetime == false) {
			return app_hooks()->apply_filters('to_sql_date_formatted', date_format(date_create_from_format($from_format, $date), $to_date));
		}

		if (strpos($date, ' ') === false) {
			$date .= ' 00:00:00';
		} else {
			$hour12 = (get_setting('time_format') == 24 ? false : true);
			if ($hour12 == false) {
				$_temp = explode(' ', $date);
				$time  = explode(':', $_temp[1]);
				if (count($time) == 2) {
					$date .= ':00';
				}
			} else {
				$tmp  = _simplify_date_fix($date, $from_format);
				$time = date('G:i', strtotime($tmp));
				$tmp  = explode(' ', $tmp);
				$date = $tmp[0] . ' ' . $time . ':00';
			}
		}

		$date = _simplify_date_fix($date, $from_format);
		$d    = strftime('%Y-%m-%d %H:%M:%S', strtotime($date));

		return $d;
	}
}


if (!function_exists('module_views_path')) {

	function module_views_path($module, $concat = '')
	{
		return module_dir_path($module) . 'Views/' . $concat;
	}
}

if (!function_exists('module_dir_path')) {

	function module_dir_path($module, $concat = '')
	{
		return APP_MODULES_PATH . $module . '/' . $concat;
	}
}

if (!function_exists('endsWith')) {
	/**
	* String ends with
	* @param  string $haystack
	* @param  string $needle
	* @return boolean
	*/
	function endsWith($haystack, $needle)
	{
		return $needle === '' || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
}

if (!function_exists('escape_str')) {

	function escape_str($str, $like = FALSE)
	{
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = $this->escape_str($val, $like);
			}

			return $str;
		}

		$str = _escape_str($str);

		// escape LIKE condition wildcards
		if ($like === TRUE)
		{
			return str_replace(
				array($this->_like_escape_chr, '%', '_'),
				array($this->_like_escape_chr.$this->_like_escape_chr, $this->_like_escape_chr.'%', $this->_like_escape_chr.'_'),
				$str
			);
		}

		return $str;
	}
}

if (!function_exists('startsWith1')) {
	/**
	* String ends with
	* @param  string $haystack
	* @param  string $needle
	* @return boolean
	*/
	function startsWith1($haystack, $needle)
	{
		return $needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}
}

if (!function_exists('strbefore1')) {
	function strbefore1($string, $substring)
	{
		$pos = strpos($string, $substring);
		if ($pos === false) {
			return $string;
		}

		return (substr($string, 0, $pos));
	}
}

if (!function_exists('strafter')) {
	function strafter($string, $substring)
	{
		$pos = strpos($string, $substring);
		if ($pos === false) {
			return $string;
		}

		return (substr($string, $pos + strlen($substring)));
	}
}

if (!function_exists('_escape_str')) {
	function _escape_str($str)
	{
		return str_replace("'", "''", remove_invisible_characters($str, FALSE));
	}
}


/**
 * _l
 * @param  string $lang 
 * @return [type]       
 */
if (!function_exists('_l')) {
	function _l($lang = "") {
		if (!$lang) {
			return false;
		}

		//first check if the key is exists in custom lang
		$language_result = lang("custom_lang.$lang");
		if ($language_result === "custom_lang.$lang") {
			//this key doesn't exists in custom language, get from default language
			$language_result = lang("default_lang.$lang");
		}

		return $language_result;
	}

}

/**
 * db prefix
 * @return [type] 
 */
if (!function_exists('db_prefix')) {
	function db_prefix() {
		$db = db_connect('default');
		return $db->getPrefix();
	}

}

if (!function_exists('is_admin')) {
	function is_admin($staffid = '')
	{
		$ci = new Security_Controller(false);
		if ($ci->login_user->is_admin) {
            return true;
		}
		return false;
	}
}

if (!function_exists('get_staff_user_id1')) {
	function get_staff_user_id1()
	{

        $Users_model = model("Models\Users_model");
		return $Users_model->login_user_id();
	}
}

if (!function_exists('get_staff_full_name1')) {

	function get_staff_full_name1($userid = '')
	{
		$Users_model = model("Models\Users_model");

		if ($userid == '' || !is_numeric($userid)) {
			$userid = get_staff_user_id1();
		}

		$options = array(
			"id" => $userid,
		);
		$staff = $Users_model->get_details($options)->getRow();
		return $staff ? $staff->first_name . ' ' . $staff->last_name : '';
	}
}

/**
 * Function that will check the date before formatting and replace the date places
 * This function is custom developed because for some date formats converting to y-m-d format is not possible
 * @param  string $date        the date to check
 * @param  string $from_format from format
 * @return string
 */
if (!function_exists('_simplify_date_fix')) {

	function _simplify_date_fix($date, $from_format)
	{
		if ($from_format == 'd/m/Y') {
			$date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$2-$1 $4', $date);
		} elseif ($from_format == 'm/d/Y') {
			$date = preg_replace('#(\d{2})/(\d{2})/(\d{4})\s(.*)#', '$3-$1-$2 $4', $date);
		} elseif ($from_format == 'm.d.Y') {
			$date = preg_replace('#(\d{2}).(\d{2}).(\d{4})\s(.*)#', '$3-$1-$2 $4', $date);
		} elseif ($from_format == 'm-d-Y') {
			$date = preg_replace('#(\d{2})-(\d{2})-(\d{4})\s(.*)#', '$3-$1-$2 $4', $date);
		}

		return $date;
	}
}