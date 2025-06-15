<?php

namespace Warehouse\Controllers;

use App\Controllers\Security_Controller;
use App\Models\Crud_model;

class Warehouse extends Security_Controller {

	protected $warehouse_model;
	function __construct() {

		parent::__construct();
		$this->warehouse_model = new \Warehouse\Models\Warehouse_model();
		app_hooks()->do_action('app_hook_inventory_init');

	}

	public function commodity_list($id = '') {

		$data['units'] = $this->warehouse_model->get_unit_add_commodity();
		$data['commodity_types'] = $this->warehouse_model->get_commodity_type_add_commodity();
		$data['commodity_groups'] = $this->warehouse_model->get_commodity_group_add_commodity();
		$data['styles'] = $this->warehouse_model->get_style_add_commodity();
		$data['models'] = $this->warehouse_model->get_body_add_commodity();
		$data['sizes'] = $this->warehouse_model->get_size_add_commodity();
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['colors'] = $this->warehouse_model->get_color_add_commodity();
		$data['warehouses'] = [];
		$data['taxes'] = [];
		$data['sub_groups'] = [];
		$data['item_tags'] = [];

		$data['title'] = _l('commodity_list');

			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$data['proposal_id'] = $id;
		return $this->template->rander('Warehouse\Views\commodity_list', $data);
	}

	/**
	 * table commodity list
	 * @return [type] 
	 */
	public function table_commodity_list() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'table_commodity_list'), $dataPost);
	}

	/**
	 * modal form
	 * @return [type] 
	 */
	public function item_modal_form() {
		$this->access_only_team_members();
		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		$data['model_info'] = $this->Items_model->get_one($this->request->getPost('id'));
		$data['categories_dropdown'] = $this->Item_categories_model->get_dropdown_list(array("title"));
		$data['units'] = $this->warehouse_model->get_unit_add_commodity();


		$data['commodity_types'] = $this->warehouse_model->get_commodity_type_add_commodity();
		$data['commodity_groups'] = $this->warehouse_model->get_commodity_group_add_commodity();
		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();
		$data['styles'] = $this->warehouse_model->get_style_add_commodity();
		$data['models'] = $this->warehouse_model->get_body_add_commodity();
		$data['sizes'] = $this->warehouse_model->get_size_add_commodity();
		$data['colors'] = $this->warehouse_model->get_color_add_commodity();
		$data['warehouses'] = [];
		//filter
		$data['warehouse_filter'] = [];
		$data['sub_groups'] = [];
		$data['item_tags'] = [];

		$data['title'] = _l('commodity_list');

		$data['ajaxItems'] = false;

		if(!$this->request->getPost('id')){
			if ($this->warehouse_model->count_all_items('parent_id is null or parent_id = "" OR parent_id = 0') <= ajax_on_total_items()) {
				$data['items'] = $this->warehouse_model->get_parent_item_grouped();
			} else {
				$data['items']     = [];
				$data['ajaxItems'] = true;
			}

			/*for create*/
			$variation_html = $this->warehouse_model->get_variation_html('');
			$data['get_commodity_barcode'] = $this->warehouse_model->generate_commodity_barcode();
			$parent_data = $this->template->view('Warehouse\Views\item_include\item_select', ['ajaxItems' => $data['ajaxItems'], 'items' => $data['items'] , 'select_name' => 'parent_id', 'id_name' => 'parent_id', 'data_none_selected_text' => '', 'label_name' => 'parent_item']);
			$data['variation_html'] = $variation_html['html']; 
			$data['variation_index'] = $variation_html['index']; 
			$data['item_html'] = $parent_data;
			$data['parent_item_hide'] = false;

		}else{
			$id = $this->request->getPost('id');
			$data['item'] = $this->warehouse_model->get_commodity($id);

			//check have child item
			$flag_is_parent = false;
			$data['parent_item_hide'] = false;

			$builder = db_connect('default');
			$builder = $builder->table('items');
			$builder->where('parent_id', $id);
			$array_child_value = $builder->get()->getResultArray();

			if(count($array_child_value) > 0){
				$flag_is_parent = true;
				$data['parent_item_hide'] = true;
			}

			if($data['item']){
				$parent_id = $data['item']->parent_id;
			}else{
				$parent_id = '';
			}

			if ($this->warehouse_model->count_all_items('parent_id is null or parent_id = "" OR parent_id = 0') <= ajax_on_total_items()) {
				if(is_numeric($parent_id) && $parent_id != 0 ){
					$data['items'] = $this->warehouse_model->get_parent_item_grouped($parent_id);
				}else{
					$data['items'] = $this->warehouse_model->get_parent_item_grouped();
				}
			} else {
				if(is_numeric($parent_id) && $parent_id != 0 ){
					$data['items']     = $this->warehouse_model->get_parent_item_grouped($parent_id);
				}else{
					$data['items']     = [];
					$data['ajaxItems'] = true;
				}
			}

			$variation_html = $this->warehouse_model->get_variation_html($id);
			$parent_data = $this->template->view('Warehouse\Views\item_include\item_select', ['ajaxItems' => $data['ajaxItems'], 'items' => $data['items'] , 'select_name' => 'parent_id', 'id_name' => 'parent_id', 'data_none_selected_text' => '', 'label_name' => 'parent_item', 'item_id' => $parent_id ], true);
			$data['variation_html'] = $variation_html['html']; 
			$data['variation_index'] = $variation_html['index'];
			$data['item_html'] = $parent_data;

		}

		return $this->template->view('Warehouse\Views\items\item_modal', $data);
	}


	public function wh_commodity_code_search_all($type = 'rate', $can_be = '', $search_all = 'true')
	{
		if ($this->request->getPost()) {
			echo json_encode($this->warehouse_model->wh_commodity_code_search($this->request->getPost('q'), $type, $can_be, $search_all));
		}
	}

	/**
	 * general
	 * @return [type] 
	 */
	public function general() {
		$data['warehouses'] = $this->warehouse_model->get_warehouse();
		return $this->template->rander("Warehouse\Views\includes\\rule_sale_price", $data);
	}

	/**
	 * commodity types
	 * @return [type] 
	 */
	public function commodity_types() {
		$data['commodity_types'] = $this->warehouse_model->get_commodity_type();
		return $this->template->rander("Warehouse\Views\includes\commodity_type", $data);
	}
		
	/**
	 * list commodity type data
	 * @return [type] 
	 */
	public function list_commodity_type_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_commodity_type();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_commodity_type_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make commodity type row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_commodity_type_row($data) {

		return array(
			$data['commodity_type_id'],
			nl2br($data['commondity_code']),
			nl2br($data['commondity_name']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/commodity_type_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_commodity_type'), "data-post-id" => $data['commodity_type_id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['commodity_type_id'], "data-action-url" => get_uri("warehouse/delete_commodity_type/".$data['commodity_type_id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * commodity type modal form
	 * @return [type] 
	 */
	public function commodity_type_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$commodity_type_data = [];
		$max_row = 29;
		$min_row = 9;

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$commodity_type = $this->warehouse_model->get_commodity_type($id);
			if($commodity_type){
				$commodity_type_data[0] = [
					'commodity_type_id' => $commodity_type->commodity_type_id,
					'commondity_code' => $commodity_type->commondity_code,
					'commondity_name' => $commodity_type->commondity_name,
					'order' => $commodity_type->order,
					'display' => $commodity_type->display == 1 ? 'yes' : 'no',
					'note' => $commodity_type->note,
				];

			}
			$data['commodity_type_data'] = $commodity_type_data;
			$max_row = 1;
			$min_row = 1;
		}else{
			$id = '';
		}
		$data['max_row'] = $max_row;
		$data['min_row'] = $min_row;
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\includes\modal_forms\commodity_type_modal', $data);
	}

	/**
	 * commodity type
	 * @param  integer $id
	 * @return redirect
	 */
	public function commodity_type($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {

				$mess = $this->warehouse_model->add_commodity_type($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully").' '.app_lang("commodity_type"));

				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_commodity_type_false"));
				}
				app_redirect("warehouse/commodity_types");

			} else {
				
				$success = $this->warehouse_model->add_commodity_type($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully").' '.app_lang("commodity_type"));
				}
				app_redirect("warehouse/commodity_types");
			}
		}
	}

	/**
	 * delete commodity type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_commodity_type($id) {
		if (!$id) {
			app_redirect('warehouse/commodity_types');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_commodity_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			 echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			 echo json_encode(array("success" => true, "message" => app_lang('commodity_type_has_been_deleted')));
		} else {
			 echo json_encode(array("success" => false, "message" => app_lang('problem_deleting_commodity_type')));
		}
	}

	/**
	 * units
	 * @return [type] 
	 */
	public function units() {
		$data = [];
		return $this->template->rander("Warehouse\Views\includes\units", $data);
	}
		
	/**
	 * list commodity type data
	 * @return [type] 
	 */
	public function unit_type_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_unit_type();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_unit_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make commodity type row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_unit_row($data) {

		return array(
			$data['unit_type_id'],
			nl2br($data['unit_code']),
			nl2br($data['unit_name']),
			nl2br($data['unit_symbol']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/unit_type_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_unit_type'), "data-post-id" => $data['unit_type_id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['unit_type_id'], "data-action-url" => get_uri("warehouse/delete_unit_type/".$data['unit_type_id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * commodity type modal form
	 * @return [type] 
	 */
	public function unit_type_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$unit_data = [];
		$max_row = 29;
		$min_row = 9;

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$unit_type = $this->warehouse_model->get_unit_type($id);
			if($unit_type){
				$unit_data[0] = [
					'unit_type_id' => $unit_type->unit_type_id,
					'unit_code' => $unit_type->unit_code,
					'unit_name' => $unit_type->unit_name,
					'unit_symbol' => $unit_type->unit_symbol,
					'order' => $unit_type->order,
					'display' => $unit_type->display == 1 ? 'yes' : 'no',
					'note' => $unit_type->note,
				];

			}
			$data['unit_type_data'] = $unit_data;
			$max_row = 1;
			$min_row = 1;
		}else{
			$id = '';
		}
		$data['max_row'] = $max_row;
		$data['min_row'] = $min_row;
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\includes\modal_forms\unit_modal', $data);
	}

	/**
	 * unit type
	 * @param  integer $id
	 * @return redirect
	 */
	public function unit_type($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {

				$mess = $this->warehouse_model->add_unit_type($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully").' '.app_lang("unit_type"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_unit_type_false"));
				}
				app_redirect("warehouse/units");

			} else {
				
				$success = $this->warehouse_model->add_unit_type($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully").' '.app_lang("unit_type"));
				}
				app_redirect("warehouse/units");
			}
		}
	}

	/**
	 * delete unit type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_unit_type($id) {
		if (!$id) {
			app_redirect('warehouse/units');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_unit_type($id);
		
		if (is_array($response) && isset($response['referenced'])) {
			echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			echo json_encode(array("success" => true, "message" => app_lang('unit_type_has_been_deleted')));
		} else {
			echo json_encode(array("success" => false, "message" => app_lang('problem_deleting_unit_type')));
		}
	}

	/**
	 * sizes
	 * @return [type] 
	 */
	public function sizes() {
		$data['sizes'] = $this->warehouse_model->get_size_type();
		return $this->template->rander("Warehouse\Views\includes\sizes", $data);
	}
		
	/**
	 * list size type data
	 * @return [type] 
	 */
	public function list_size_type_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_size_type();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_size_type_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make_size_type_row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_size_type_row($data) {

		return array(
			$data['size_type_id'],
			nl2br($data['size_code']),
			nl2br($data['size_name']),
			nl2br($data['size_symbol']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/size_type_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_size_type'), "data-post-id" => $data['size_type_id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['size_type_id'], "data-action-url" => get_uri("warehouse/delete_size_type/".$data['size_type_id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * size_type_modal_form
	 * @return [type] 
	 */
	public function size_type_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$size_type_data = [];
		$max_row = 29;
		$min_row = 9;

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$size_type = $this->warehouse_model->get_size_type($id);
			if($size_type){
				$size_type_data[0] = [
					'size_type_id' => $size_type->size_type_id,
					'size_code' => $size_type->size_code,
					'size_name' => $size_type->size_name,
					'size_symbol' => $size_type->size_symbol,
					'order' => $size_type->order,
					'display' => $size_type->display == 1 ? 'yes' : 'no',
					'note' => $size_type->note,
				];

			}
			$data['size_type_data'] = $size_type_data;
			$max_row = 1;
			$min_row = 1;
		}else{
			$id = '';
		}
		$data['max_row'] = $max_row;
		$data['min_row'] = $min_row;
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\includes\modal_forms\size_type_modal', $data);
	}

	/**
	 * size type
	 * @param  integer $id
	 * @return redirect
	 */
	public function size_type($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {

				$mess = $this->warehouse_model->add_size_type($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_size_type_false"));
				}
				app_redirect("warehouse/sizes");
			} else {
				
				$success = $this->warehouse_model->add_size_type($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/sizes");
			}
		}
	}

	/**
	 * delete size type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_size_type($id) {
		if (!$id) {
			app_redirect('warehouse/sizes');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_size_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			echo json_encode(array("success" => true, "message" => app_lang('wh_deleted')));
		} else {
			echo json_encode(array("success" => false, "message" => app_lang('problem_deleting')));
		}
	}

	/**
	 * styles
	 * @return [type] 
	 */
	public function styles() {
		$data['style_types'] = $this->warehouse_model->get_style_type();
		return $this->template->rander("Warehouse\Views\includes\styles", $data);
	}
		
	/**
	 * list_style_type_data
	 * @return [type] 
	 */
	public function list_style_type_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_style_type();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_style_type_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make_style_type_row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_style_type_row($data) {

		return array(
			$data['style_type_id'],
			nl2br($data['style_code']),
			nl2br($data['style_barcode']),
			nl2br($data['style_name']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/style_type_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_style_type'), "data-post-id" => $data['style_type_id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['style_type_id'], "data-action-url" => get_uri("warehouse/delete_style_type/".$data['style_type_id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * style_type_modal_form
	 * @return [type] 
	 */
	public function style_type_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$style_type_data = [];
		$max_row = 29;
		$min_row = 9;

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$style_type = $this->warehouse_model->get_style_type($id);
			if($style_type){
				$style_type_data[0] = [
					'style_type_id' => $style_type->style_type_id,
					'style_code' => $style_type->style_code,
					'style_barcode' => $style_type->style_barcode,
					'style_name' => $style_type->style_name,
					'order' => $style_type->order,
					'display' => $style_type->display == 1 ? 'yes' : 'no',
					'note' => $style_type->note,
				];

			}
			$data['style_type_data'] = $style_type_data;
			$max_row = 1;
			$min_row = 1;
		}else{
			$id = '';
		}
		$data['max_row'] = $max_row;
		$data['min_row'] = $min_row;
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\includes\modal_forms\style_type_modal', $data);
	}

	/**
	 * style type
	 * @param  integer $id
	 * @return redirect
	 */
	public function style_type($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {
				$mess = $this->warehouse_model->add_style_type($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_style_type_false"));
				}
				app_redirect("warehouse/styles");

			} else {

				$success = $this->warehouse_model->add_style_type($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/styles");
			}
		}
	}
	/**
	 * delete style type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_style_type($id) {
		if (!$id) {
			app_redirect('warehouse/styles');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}


		$response = $this->warehouse_model->delete_style_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			echo json_encode(array("success" => true, "message" => app_lang('wh_deleted')));
		} else {
			echo json_encode(array("success" => false, "message" => app_lang('problem_deleting')));
		}
	}

	/**
	 * body_types
	 * @return [type] 
	 */
	public function models() {
		$data['body_types'] = $this->warehouse_model->get_body_type();
		return $this->template->rander("Warehouse\Views\includes\bodys", $data);
	}
	
	/**
	 * list body type data
	 * @return [type] 
	 */
	public function list_body_type_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_body_type();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_body_type_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * make body type row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_body_type_row($data) {

		return array(
			$data['body_type_id'],
			nl2br($data['body_code']),
			nl2br($data['body_name']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/body_type_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_body_type'), "data-post-id" => $data['body_type_id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['body_type_id'], "data-action-url" => get_uri("warehouse/delete_body_type/".$data['body_type_id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * body type modal form
	 * @return [type] 
	 */
	public function body_type_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$body_type_data = [];
		$max_row = 29;
		$min_row = 9;

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$body_type = $this->warehouse_model->get_body_type($id);
			if($body_type){
				$body_type_data[0] = [
					'body_type_id' => $body_type->body_type_id,
					'body_code' => $body_type->body_code,
					'body_name' => $body_type->body_name,
					'order' => $body_type->order,
					'display' => $body_type->display == 1 ? 'yes' : 'no',
					'note' => $body_type->note,
				];

			}
			$data['body_type_data'] = $body_type_data;
			$max_row = 1;
			$min_row = 1;
		}else{
			$id = '';
		}
		$data['max_row'] = $max_row;
		$data['min_row'] = $min_row;
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\includes\modal_forms\body_type_modal', $data);
	}

	/**
	 * body type
	 * @param  integer $id
	 * @return redirect
	 */
	public function body_type($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {

				$mess = $this->warehouse_model->add_body_type($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));

				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_body_type_false"));
				}
				app_redirect("warehouse/models");

			} else {
				$success = $this->warehouse_model->add_body_type($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/models");
			}
		}
	}

	/**
	 * delete body type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_body_type($id) {
		if (!$id) {
			app_redirect('warehouse/models');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_body_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			echo json_encode(array("success" => true, "message" => app_lang('wh_deleted')));
		} else {
			echo json_encode(array("success" => false, "message" => app_lang('problem_deleting')));
		}
	}

	/**
	 * commodity types
	 * @return [type] 
	 */
	public function commodity_groups() {
		$data['commodity_groups'] = $this->warehouse_model->get_commodity_group_type();
		return $this->template->rander("Warehouse\Views\includes\commodity_group", $data);
	}
		
	/**
	 * list commodity type data
	 * @return [type] 
	 */
	public function list_commodity_group_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_commodity_group_type();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_commodity_group_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make commodity type row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_commodity_group_row($data) {

		return array(
			$data['id'],
			nl2br($data['commodity_group_code']),
			nl2br($data['title']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/commodity_group_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_commodity_group_type'), "data-post-id" => $data['id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['id'], "data-action-url" => get_uri("warehouse/delete_commodity_group_type/".$data['id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * commodity type modal form
	 * @return [type] 
	 */
	public function commodity_group_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$commodity_group_data = [];
		$max_row = 29;
		$min_row = 9;

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$commodity_type = $this->warehouse_model->get_commodity_group_type($id);
			if($commodity_type){
				$commodity_group_data[0] = [
					'id' => $commodity_type->id,
					'commodity_group_code' => $commodity_type->commodity_group_code,
					'title' => $commodity_type->title,
					'order' => $commodity_type->order,
					'display' => $commodity_type->display == 1 ? 'yes' : 'no',
					'note' => $commodity_type->note,
				];

			}
			$data['commodity_group_data'] = $commodity_group_data;
			$max_row = 1;
			$min_row = 1;
		}else{
			$id = '';
		}
		$data['max_row'] = $max_row;
		$data['min_row'] = $min_row;
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\includes\modal_forms\commodity_group_modal', $data);
	}

	/**
	 * commodty group type
	 * @param  integer $id
	 * @return redirect
	 */
	public function commodity_group_type($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {

				$mess = $this->warehouse_model->add_commodity_group_type($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully").' '.app_lang("commodity_group_type"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_commodity_group_type_false"));
				}
				app_redirect("warehouse/commodity_groups");
			} else {
				
				$success = $this->warehouse_model->add_commodity_group_type($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully").' '.app_lang("commodity_group_type"));
				}
				app_redirect("warehouse/commodity_groups");
			}
		}
	}

	/**
	 * delete commodity group type
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_commodity_group_type($id) {
		if (!$id) {
			app_redirect('warehouse/commodity_groups');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}


		$response = $this->warehouse_model->delete_commodity_group_type($id);
		if (is_array($response) && isset($response['referenced'])) {
			echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			echo json_encode(array("success" => true, "message" => app_lang('commodity_type_has_been_deleted')));
		} else {
			echo json_encode(array("success" => false, "message" => app_lang('problem_deleting_commodity_type')));
		}
	}

	/**
	 * warehouses
	 * @return [type] 
	 */
	public function warehouses() {
		$data = [];
		return $this->template->rander("Warehouse\Views\warehouses\warehouse", $data);
	}
		
	/**
	 * list_warehouse_data
	 * @return [type] 
	 */
	public function list_warehouse_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_all_warehouse();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_warehouse_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make_warehouse_row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_warehouse_row($data) {

		return array(
			// $data['warehouse_id'],
			$data['warehouse_code'],
			nl2br($data['warehouse_name']),
			nl2br($data['warehouse_address']),
			nl2br($data['order']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/warehouse_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_commodity_type'), "data-post-id" => $data['warehouse_id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['warehouse_id'], "data-action-url" => get_uri("warehouse/delete_warehouse/".$data['warehouse_id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * commodity type modal form
	 * @return [type] 
	 */
	public function warehouse_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$warehouse_data = [];

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$warehouse = $this->warehouse_model->get_warehouse($id);
			$data['warehouse'] = $warehouse;
		}else{
			$id = '';
		}
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\warehouses\modal_form', $data);
	}

	/**
	 * warehouse_
	 * @param  integer $id
	 * @return redirect
	 */

	public function create_warehouse($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {

				$mess = $this->warehouse_model->add_one_warehouse($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setflashdata("error_message", app_lang("add_failed"));
				}
				app_redirect("warehouse/warehouses");

			} else {
				$success = $this->warehouse_model->update_one_warehouse($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/warehouses");
			}
		}
	}

	/**
	 * delete warehouse
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_warehouse($id) {
		if (!$id) {
			app_redirect('warehouse/warehouses');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_warehouse($id);
		if (is_array($response) && isset($response['referenced'])) {
			echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			echo json_encode(array("success" => true, "message" => app_lang('deleted')));
		} else {
			echo json_encode(array("success" => false, "message" => app_lang('problem_deleting')));
		}
	}

	/**
	 * get commodity data ajax
	 * @param  integer $id
	 * @return view
	 */
	public function get_commodity_data_ajax($id) {

		$data['id'] = $id;
		$data['commodites'] = $this->warehouse_model->get_commodity($id);
		$data['inventory_commodity'] = $this->warehouse_model->get_inventory_commodity($id);
		$data['commodity_file'] = $this->warehouse_model->get_warehourse_attachments($id);
		$this->load->view('commodity_detail', $data);
	}

	/**
	 * add commodity list
	 * @param  integer $id
	 * @return redirect
	 */
	public function add_commodity_list($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_commodity($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));

				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_commodity_list_false"));
				}
				app_redirect('warehouse/commodity_list');

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_warehouse($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("updated_commodity_list_false"));
				}

				app_redirect('warehouse/commodity_list');
			}
		}
	}

	/**
	 * delete commodity
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_commodity() {
		$id = $this->request->getPost('id');
		
		if (!$id) {
			app_redirect('warehouse/commodity_list');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_commodity($id);
		if (is_array($response) && isset($response['referenced'])) {
			$this->session->setFlashdata("error_message", app_lang("is_referenced"));
		} elseif ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("wh_deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect('warehouse/commodity_list');
	}

	/**
	 * table manage goods receipt
	 * @param  integer $id
	 * @return array
	 */
	public function table_manage_goods_receipt() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'manage_goods_receipt/table_manage_goods_receipt'), $dataPost);
	}

	/**
	 * manage purchase
	 * @param  integer $id
	 * @return view
	 */
	public function manage_purchase($id = '') {
		$data['title'] = _l('stock_received_manage');
		$data['purchase_id'] = $id;
		return $this->template->rander("Warehouse\Views\manage_goods_receipt\manage_purchase", $data);
	}

	/**
	 * manage goods receipt
	 * @param  integer $id
	 * @return view
	 */
	public function manage_goods_receipt($id = '') {
		$user_id = $this->login_user->id;
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();
			$id = $this->request->getPost('id');

			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_goods_receipt($data, $user_id);

				if ($mess) {
					if($data['save_and_send_request'] == 'true'){
						$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '1', 'addedfrom' => $user_id]);
					}
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_stock_received_docket_false"));
				}
				app_redirect("warehouse/manage_purchase");

			}else{

				$id = $this->request->getPost('id');
				$mess = $this->warehouse_model->update_goods_receipt($data, $user_id);

				if($data['save_and_send_request'] == 'true'){
					$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '1', 'addedfrom' => $user_id]);
				}

				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("update_stock_received_docket_false"));
				}
				app_redirect("warehouse/manage_purchase");
			}

		}

		$data['title'] = _l('goods_receipt');

		$data['warehouses'] = $this->warehouse_model->get_warehouse();
		if (get_status_modules_wh('purchase')) {
			$this->load->model('purchase/purchase_model');
			$this->load->model('departments_model');
			$this->load->model('staff_model');
			$this->load->model('projects_model');

			$data['pr_orders'] = get_pr_order();
			$data['pr_orders_status'] = true;

			$data['vendors'] = $this->purchase_model->get_vendor();

			$data['projects'] = $this->projects_model->get();
			$data['staffs'] = $this->staff_model->get();
			$data['departments'] = $this->departments_model->get();


		} else {
			$data['pr_orders'] = [];
			$data['pr_orders_status'] = false;
		}


		$data['goods_code'] = $this->warehouse_model->create_goods_code();

		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staff'] = $this->Users_model->get_details($options)->getResultArray();

		$data['current_day'] = (date('Y-m-d'));

		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();

		$data['ajaxItems'] = false;

		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('can_be_inventory');
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}

		$warehouse_data = $this->warehouse_model->get_warehouse();
		//sample
		$goods_receipt_row_template = $this->warehouse_model->create_goods_receipt_row_template();

		//check status module purchase
		if($id != ''){
			$goods_receipt = $this->warehouse_model->get_goods_receipt($id);
			if (!$goods_receipt) {
				blank_page('Stock received Not Found', 'danger');
			}
			$data['goods_receipt_detail'] = $this->warehouse_model->get_goods_receipt_detail($id);
			$data['goods_receipt'] = $goods_receipt;
			$data['tax_data'] = $this->warehouse_model->get_html_tax_receip($id);
			$data['total_item'] = count($data['goods_receipt_detail']);

			if (count($data['goods_receipt_detail']) > 0) {
				$index_receipt = 0;
				foreach ($data['goods_receipt_detail'] as $receipt_detail) {
					$index_receipt++;
					$unit_name = wh_get_unit_name($receipt_detail['unit_id']);
					$taxname = '';
					$date_manufacture = null;
					$expiry_date = null;
					$commodity_name = $receipt_detail['commodity_name'];
					if($receipt_detail['date_manufacture'] != null && $receipt_detail['date_manufacture'] != ''){
						$date_manufacture = format_to_date($receipt_detail['date_manufacture'], false);
					}
					if($receipt_detail['expiry_date'] != null && $receipt_detail['expiry_date'] != ''){
						$expiry_date = format_to_date($receipt_detail['expiry_date'], false);
					}
					if(strlen($commodity_name) == 0){
						$commodity_name = wh_get_item_variatiom($receipt_detail['commodity_code']);
					}

					$goods_receipt_row_template .= $this->warehouse_model->create_goods_receipt_row_template($warehouse_data, 'items[' . $index_receipt . ']', $commodity_name, $receipt_detail['warehouse_id'], $receipt_detail['quantities'], $unit_name, $receipt_detail['unit_price'], $taxname, $receipt_detail['lot_number'], $date_manufacture, $expiry_date, $receipt_detail['commodity_code'], $receipt_detail['unit_id'] , $receipt_detail['tax_rate'], $receipt_detail['tax_money'], $receipt_detail['goods_money'], $receipt_detail['note'], $receipt_detail['id'], $receipt_detail['sub_total'], $receipt_detail['tax_name'], $receipt_detail['tax'], true, $receipt_detail['serial_number']);
					
				}
			}

			$data['goods_receipt_detail'] = json_encode($this->warehouse_model->get_goods_receipt_detail($id));

		}

		$data['goods_receipt_row_template'] = $goods_receipt_row_template;
		$data['base_currency_id'] = 0;

		return $this->template->rander("Warehouse\Views\manage_goods_receipt\purchase", $data);
	}

	/**
	 * copy pur request
	 * @param  integer $pur request
	 * @return json encode
	 */
	public function coppy_pur_request($pur_request = '') {
		if(is_numeric($pur_request)){
			$pur_request_detail = $this->warehouse_model->get_pur_request($pur_request);

			echo json_encode([

				'result' => $pur_request_detail[0] ? $pur_request_detail[0] : '',
				'total_tax_money' => $pur_request_detail[1] ? $pur_request_detail[1] : '',
				'total_goods_money' => $pur_request_detail[2] ? $pur_request_detail[2] : '',
				'value_of_inventory' => $pur_request_detail[3] ? $pur_request_detail[3] : '',
				'total_money' => $pur_request_detail[4] ? $pur_request_detail[4] : '',
				'total_row' => $pur_request_detail[5] ? $pur_request_detail[5] : '',
				'list_item' => $pur_request_detail[6] ? $pur_request_detail[6] : '',
			]);
		}else{
			$list_item = $this->warehouse_model->create_goods_receipt_row_template();
			echo json_encode([
				'list_item' => $list_item,
			]);
		}
	}

	/**
	 * copy pur vender
	 * @param  integer $pủ request
	 * @return json encode
	 */
	public function copy_pur_vender($pur_request) {

		$pur_vendor = $this->warehouse_model->get_vendor_ajax($pur_request);

		echo json_encode([

			'userid' => $pur_vendor['id'] ? $pur_vendor['id'] : '',
			'buyer' => $pur_vendor['buyer'] ? $pur_vendor['buyer'] : '',
			'project' => $pur_vendor['project'] ? $pur_vendor['project'] : '',
			'type' => $pur_vendor['type'] ? $pur_vendor['type'] : '',
			'department' => $pur_vendor['department'] ? $pur_vendor['department'] : '',
			'requester' => $pur_vendor['requester'] ? $pur_vendor['requester'] : '',

		]);
	}

	/**
	 * view purchase
	 * @param  integer $id
	 * @return view
	 */
	public function goods_receipt_detail($id) {
		validate_numeric_value($id);

		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");
		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {

			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}
		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 1);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 1);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 1);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 1);

		$data['goods_receipt_detail'] = $this->warehouse_model->get_goods_receipt_detail($id);
		$data['goods_receipt'] = $this->warehouse_model->get_goods_receipt($id);
		$data['tax_data'] = $this->warehouse_model->get_html_tax_receip($id);
		$data['title'] = _l('stock_received_info');
		$check_appr = $this->warehouse_model->get_approve_setting('1');
		$data['check_appr'] = $check_appr;

		return $this->template->rander("Warehouse\Views\manage_goods_receipt\goods_receipt_detail", $data);
	}

	/**
	 * edit purchase
	 * @param  integer $id
	 * @return view
	 */
	public function edit_purchase($id) {

		//check exist
		$goods_receipt = $this->warehouse_model->get_goods_receipt($id);
		if (!$goods_receipt) {
			blank_page('Stock received Not Found', 'danger');
		}

		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");

		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {
			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 1);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 1);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 1);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 1);

		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$goods_receipt_data = $this->warehouse_model->get_goods_receipt_detail($id);
		$data['goods_receipt_detail'] = json_encode($goods_receipt_data);
		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();

		$data['goods_receipt'] = $goods_receipt;

		$data['tax_data'] = $this->warehouse_model->get_html_tax_receip($id);

		$data['title'] = _l('stock_received_info');

		$check_appr = $this->warehouse_model->get_approve_setting('1');
		$data['check_appr'] = $check_appr;
		$this->load->model('currencies_model');
		$base_currency = $this->currencies_model->get_base_currency();
		$data['base_currency'] = $base_currency;

		$this->load->view('manage_goods_receipt/edit_purchase', $data);

	}

	public function add_goods_receipt() {

	}

	/**
	 * commodity code change
	 * @param  integer $val
	 * @return json encode
	 */
	public function commodity_code_change($val='') {
		$data = $this->request->getPost();

		if($data['switch_barcode_scanners'] == 'true'){
			$value = $this->warehouse_model->get_commodity_hansometable_by_barcode($data['oldValue']);
		}else{
			$value = $this->warehouse_model->get_commodity_hansometable($data['oldValue']);
		}

		$value->tax1 = $value->tax;
		if($value->tax2 != '' && $value->tax2 != null){
			$tax2 = get_tax_rate($value->tax2);
			if($tax2 && !is_array($tax2)){
				$value->taxrate2 = $tax2->taxrate;
				$value->name_taxrate2 = $tax2->name;
				$value->tax = $value->tax.'|'.$value->tax2;
			}else{
				$value->taxrate2 = 0;
				$value->name_taxrate2 = '';
				$value->tax = $value->tax;
			}
		}

		echo json_encode([
			'value' => get_object_vars($value),
		]);
		die;
	}

	/**
	 * update inventory min
	 * @param  integer $id
	 * @return redirect
	 */
	public function update_inventory_min($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			$success = $this->warehouse_model->update_inventory_min($data);
			if ($success) {
				$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
			} else {
				$this->session->setFlashdata("error_message", app_lang("updated_false"));
			}
			app_redirect("warehouse/inventory");
		}
	}

	/**
	 * table warehouse history
	 *
	 * @return array
	 */
	public function table_warehouse_history() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'warehouse_histories/table_warehouse_history'), $dataPost);
	}

	/**
	 * warehouse history
	 *
	 * @return view
	 */
	public function warehouse_history() {
		$data['title'] = app_lang('warehouse_history');

		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		return $this->template->rander("Warehouse\Views\warehouse_histories\warehouse_history", $data);

	}

	/**
	 * approval setting
	 * @return redirect
	 */
	public function approval_setting($id = '') {
		if ($this->request->getPost()) {
			$data = $this->request->getPost();

			if (!is_numeric($id)) {
				$message = '';
				$success = $this->warehouse_model->add_approval_setting($data);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				}
				app_redirect("warehouse/approval_settings");
			} else {
				$success = $this->warehouse_model->edit_approval_setting($id, $data);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/approval_settings");
			}
		}
	}

	/**
	 * delete approval setting
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_approval_setting($id) {
		if (!$id) {
			app_redirect("warehouse/approval_settings");
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_approval_setting($id);
		if (is_array($response) && isset($response['referenced'])) {
			echo json_encode(array("success" => false, "message" => app_lang('is_referenced')));
		} elseif ($response == true) {
			echo json_encode(array("success" => true, "message" => app_lang('deleted')));
		} else {
			echo json_encode(array("success" => false, "message" => app_lang('problem_deleting')));
		}
	}

	/**
	 * get html approval setting
	 * @param  integer $id
	 * @return html
	 */
	public function get_html_approval_setting($id = '') {
		$index=0;
		$html = '';
		$staffs = $this->staff_model->get();
		$approver = [
			0 => ['id' => 'direct_manager', 'name' => _l('direct_manager')],
			1 => ['id' => 'department_manager', 'name' => _l('department_manager')],
			2 => ['id' => 'staff', 'name' => _l('staff')]];
			$action = [
				1 => ['id' => 'approve', 'name' => _l('approve')],
				0 => ['id' => 'sign', 'name' => _l('sign')],
			];
			if (is_numeric($id)) {
				$approval_setting = $this->warehouse_model->get_approval_setting($id);

				$setting = json_decode($approval_setting->setting);

				foreach ($setting as $key => $value) {
					$index++;
					if ($key == 0) {
						$html .= '<div id="item_approve">
						<div class="col-md-11">
						<div class="col-md-4 hide"> ' .
						render_select1('approver[' . $key . ']', $approver, array('id', 'name'), 'task_single_related', $value->approver) . '
						</div>
						<div class="col-md-8">
						' . render_select1('staff[' . $key . ']', $staffs, array('staffid', 'full_name'), 'staff', $value->staff) . '
						</div>
						<div class="col-md-4 ">
						' . render_select1('action[' . $key . ']', $action, array('id', 'name'), 'action_label', $value->action) . '
						</div>
						</div>
						<div class="col-md-1 button_class" >
						<span class="pull-bot">
						<button name="add" class="btn new_wh_approval btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
						</span>
						</div>
						</div>';
					} else {
						$html .= '<div id="item_approve">
						<div class="col-md-11">
						<div class="col-md-4 hide">
						' .
						render_select1('approver[' . $key . ']', $approver, array('id', 'name'), 'task_single_related', $value->approver) . '
						</div>
						<div class="col-md-8">
						' . render_select1('staff[' . $key . ']', $staffs, array('staffid', 'full_name'), 'staff', $value->staff) . '
						</div>
						<div class="col-md-4 ">
						' . render_select1('action[' . $key . ']', $action, array('id', 'name'), 'action_label', $value->action) . '
						</div>
						</div>
						<div class="col-md-1 button_class" >
						<span class="pull-bot">
						<button name="add" class="btn remove_wh_approval btn-danger" data-ticket="true" type="button"><i class="fa fa-minus"></i></button>
						</span>
						</div>
						</div>';
					}
				}
			} else {
				$html .= '<div id="item_approve">
				<div class="col-md-11">
				<div class="col-md-4 hide"> ' .
				render_select1('approver[0]', $approver, array('id', 'name'), 'task_single_related') . '
				</div>
				<div class="col-md-8">
				' . render_select1('staff[0]', $staffs, array('staffid', 'full_name'), 'staff') . '
				</div>
				<div class="col-md-4 ">
				' . render_select1('action[0]', $action, array('id', 'name'), 'action_label') . '
				</div>
				</div>
				<div class="col-md-1 button_class">
				<span class="pull-bot">
				<button name="add" class="btn new_wh_approval btn-success" data-ticket="true" type="button"><i class="fa fa-plus"></i></button>
				</span>
				</div>
				</div>';
			}

			echo json_encode([
				'html' => $html,
				'index' => $index,

			]);
		}

	/**
	 * send request approve
	 * @return json
	 */
	public function send_request_approve() {

		$data = $this->request->getPost();
		if($data['rel_type'] == '1'){
			$message = 'Send request approval fail';
			$success = $this->warehouse_model->send_request_approve($data);

		}elseif($data['rel_type'] == '2'){
			/*check send request with type =2 , inventory delivery voucher*/
			$check_r = $this->warehouse_model->check_inventory_delivery_voucher($data);

			if($check_r['flag_export_warehouse'] == 1){
				$message = 'Send request approval fail';
				$success = $this->warehouse_model->send_request_approve($data);

			}else{
				$message = $check_r['str_error'];
				$success = false;

				echo json_encode([
					'success' => $success,
					'message' => $message,
				]);
				die;

			}
		}elseif($data['rel_type'] == '3'){
			$message = 'Send request approval fail';
			$success = $this->warehouse_model->send_request_approve($data);

		}elseif($data['rel_type'] == '4'){
			/*check send request with type = 4 , internal delivery note*/
			$check_r = $this->warehouse_model->check_internal_delivery_note_send_request($data);

			if($check_r['flag_internal_delivery_warehouse'] == 1){
				$message = 'Send request approval fail';
				$success = $this->warehouse_model->send_request_approve($data);

			}else{
				$message = $check_r['str_error'];
				$success = false;

				echo json_encode([
					'success' => $success,
					'message' => $message,
				]);
				die;

			}

		}elseif($data['rel_type'] == '5'){
			// packing list
			//check before send request approval
			$check_packing_list_send_request = $this->warehouse_model->check_packing_list_send_request($data);

			if($check_packing_list_send_request['flag_update_status']){
				$success = $this->warehouse_model->send_request_approve($data);
			}else{
				$message = $check_packing_list_send_request['str_error'];
				$success = false;
				echo json_encode([
					'success' => $success,
					'message' => $message,
				]);
				die;
			}
		}elseif($data['rel_type'] == '6'){
			// order return

			$success = $this->warehouse_model->send_request_approve($data);
		}

		if ($success === true) {
			$message = 'Send request approval success';
			$data_new = [];
			$data_new['send_mail_approve'] = $data;

			$session = \Config\Services::session();
			$session->set($data_new);

		}elseif($success === false){
			$message = _l('no_matching_process_found');
			$success = false;

		} else {
			$message = _l('could_not_find_approver_with', _l($success));
			$success = false;
		}
		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}

	/**
	 * approve request
	 * @param  integer $id
	 * @return json
	 */
	public function approve_request() {
		$data = $this->request->getPost();

		$data['staff_approve'] = get_staff_user_id1();
		$success = false;
		$code = '';
		$signature = '';
		$open_warehouse_modal = false;
		$receipt_delivery_type = 'inventory_receipt_voucher_returned_goods';

		if (isset($data['signature'])) {
			$signature = $data['signature'];
			unset($data['signature']);
		}
		$status_string = 'status_' . $data['approve'];
		$check_approve_status = $this->warehouse_model->check_approval_details($data['rel_id'], $data['rel_type']);


		if (isset($data['approve']) && in_array(get_staff_user_id1(), $check_approve_status['staffid'])) {

			$success = $this->warehouse_model->update_approval_details($check_approve_status['id'], $data);

			$message = _l('approved_successfully');

			if ($success) {
				if ($data['approve'] == 1) {
					$message = _l('approved_successfully');
					$data_log = [];

					if ($signature != '') {
						$data_log['note'] = "signed_request";
					} else {
						$data_log['note'] = "approve_request";
					}
					if ($signature != '') {
						switch ($data['rel_type']) {
						// case 'stock_import 1':
							case 1:
							$path = WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;
						// case 'stock_export 2':
							case 2:
							$path = WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;

							case 3:
							$path = WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;

							case 4:
							$path = WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;

							case 5:
							$path = WAREHOUSE_PACKING_LIST_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;

							case 6:
							$path = WAREHOUSE_ORDER_RETURN_MODULE_UPLOAD_FOLDER . $data['rel_id'];
							break;
							


							default:
							$path = WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER;
							break;
						}
						warehouse_process_digital_signature_image($signature, $path, 'signature_' . $check_approve_status['id']);
						$message = _l('sign_successfully');
					}
					$data_log['rel_id'] = $data['rel_id'];
					$data_log['rel_type'] = $data['rel_type'];
					$data_log['staffid'] = get_staff_user_id1();
					$data_log['date'] = date('Y-m-d H:i:s');

					$this->warehouse_model->add_activity_log($data_log);

					$check_approve_status = $this->warehouse_model->check_approval_details($data['rel_id'], $data['rel_type']);

					if ($check_approve_status === true) {
						$this->warehouse_model->update_approve_request($data['rel_id'], $data['rel_type'], 1);
						$open_warehouse_modal = true; 
						if((int)$data['rel_type'] == 6){
							$get_order_return = $this->warehouse_model->get_order_return($data['rel_id']);
							$receipt_delivery_type = $get_order_return->receipt_delivery_type;
						}
					}
				} else {
					$message = app_lang('rejected_successfully');
					$data_log = [];
					$data_log['rel_id'] = $data['rel_id'];
					$data_log['rel_type'] = $data['rel_type'];
					$data_log['staffid'] = get_staff_user_id1();
					$data_log['date'] = date('Y-m-d H:i:s');
					$data_log['note'] = "rejected_request";
					$this->warehouse_model->add_activity_log($data_log);
					$this->warehouse_model->update_approve_request($data['rel_id'], $data['rel_type'], '-1');
				}
			}
		}

		$data_new = [];
		$data_new['send_mail_approve'] = $data;
		$session = \Config\Services::session();
		$session->set($data_new);


		echo json_encode([
			'success' => $success,
			'message' => $message,
			'open_warehouse_modal' => $open_warehouse_modal,
			'receipt_delivery_type' => $receipt_delivery_type,
		]);
		die();
	}

	/**
	 * stock import pdf
	 * @param  integer $id
	 * @return pdf file view
	 */
	public function stock_import_pdf($id) {
		if (!$id) {
			redirect(admin_url('warehouse/manage_goods_receipt/manage_purchase'));
		}

		$stock_import = $this->warehouse_model->get_stock_import_pdf_html($id);
		try {
			$pdf = $this->warehouse_model->stock_import_pdf($stock_import);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';
		ob_end_clean();

		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}

		$pdf->Output('goods_receipt_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);
	}

	/**
	 * send mail
	 * @param  integer $id
	 * @return json
	 */
	public function send_mail() {
		$data = $this->request->getGet();
		if ((isset($data)) && $data != '') {
			$this->warehouse_model->send_mail($data);

			$success = 'success';
			echo json_encode([
				'success' => $success,
			]);
		}
	}

	/**
	 * manage delivery
	 * @param  integer $id
	 * @return view
	 */
	public function manage_delivery($id = '') {
		$data['delivery_id'] = $id;
		$data['title'] = _l('stock_delivery_manage');
		return $this->template->rander("Warehouse\Views\manage_goods_delivery\manage_delivery", $data);
	}

	/**
	 * goods delivery
	 * @return view
	 */
	public function goods_delivery($id ='', $edit_approval = false) {

		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();
			$id = $this->request->getPost('id');

			if (!$this->request->getPost('id')) {
				$mess = $this->warehouse_model->add_goods_delivery($data);
				if ($mess) {

					if($data['save_and_send_request'] == 'true'){
						$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '2', 'addedfrom' => get_staff_user_id1()]);
					}
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("Add_stock_delivery_docket_false"));
				}
				app_redirect("warehouse/manage_delivery");

			}else{
				$id = $this->request->getPost('id');
				if($data['edit_approval'] == 'true'){
					$mess = $this->warehouse_model->update_goods_delivery_approval($data);

				}else{
					$mess = $this->warehouse_model->update_goods_delivery($data);
				}

				if($data['save_and_send_request'] == 'true'){
					$this->save_and_send_request_send_mail(['rel_id' => $id, 'rel_type' => '2', 'addedfrom' => get_staff_user_id1()]);
				}

				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				} 
				app_redirect("warehouse/manage_delivery");
			}

		}
	
		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();

		$data['title'] = _l('goods_delivery');

		$data['commodity_codes'] = $this->warehouse_model->get_commodity();
		$data['warehouses'] = $this->warehouse_model->get_warehouse();

		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('can_be_inventory');
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}

		$warehouse_data = $this->warehouse_model->get_warehouse();
		//sample
		$goods_delivery_row_template = $this->warehouse_model->create_goods_delivery_row_template();

		if (get_status_modules_wh('purchase')) {
			if ($this->db->field_exists('delivery_status' ,db_prefix() . 'pur_orders')) { 
				$this->load->model('purchase/purchase_model');
				$this->load->model('departments_model');
				$this->load->model('staff_model');
				$this->load->model('projects_model');

				$data['pr_orders'] = $this->warehouse_model->get_pr_order_delivered();
				$data['pr_orders_status'] = true;

				$data['vendors'] = $this->purchase_model->get_vendor();

				$data['projects'] = $this->projects_model->get();
				$data['staffs'] = $this->staff_model->get();
				$data['departments'] = $this->departments_model->get();
			}else{
				$data['pr_orders'] = [];
				$data['pr_orders_status'] = false;
			}

		} else {
			$data['pr_orders'] = [];
			$data['pr_orders_status'] = false;
		}
		
		$tax_options = array(
			"deleted" => 0,
		);
		$data['customer_code'] = $this->Clients_model->get_details($tax_options)->getResultArray();

		if($edit_approval){
			$invoices_data = $this->warehouse_model->warehouse_run_query('select *, iv.id as id from '.get_db_prefix().'invoices as iv left join '.get_db_prefix().'projects as pj on pj.id = iv.project_id left join '.get_db_prefix().'clients as cl on cl.id = iv.client_id  order by iv.id desc');
			$data['invoices'] = $invoices_data;
		}else{
			$data['invoices'] = $this->warehouse_model->get_invoices();
		}
		$data['goods_code'] = $this->warehouse_model->create_goods_delivery_code();
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staff'] = $this->Users_model->get_details($options)->getResultArray();
		$data['current_day'] = date('Y-m-d');

		if($id != ''){
			$is_purchase_order = false;
			$goods_delivery = $this->warehouse_model->get_goods_delivery($id);
			if (!$goods_delivery) {
				blank_page('Stock export Not Found', 'danger');
			}
			$data['goods_delivery_detail'] = $this->warehouse_model->get_goods_delivery_detail($id);
			$data['goods_delivery'] = $goods_delivery;

			if(isset($goods_delivery->pr_order_id ) && (float)$goods_delivery->pr_order_id > 0){
				$is_purchase_order = true;
			}

			if (count($data['goods_delivery_detail']) > 0) {
				$index_receipt = 0;
				foreach ($data['goods_delivery_detail'] as $delivery_detail) {
					$index_receipt++;
					$unit_name = wh_get_unit_name($delivery_detail['unit_id']);
					$taxname = '';
					$expiry_date = null;
					$lot_number = null;
					$commodity_name = $delivery_detail['commodity_name'];
					
					if(strlen($commodity_name) == 0){
						$commodity_name = wh_get_item_variatiom($delivery_detail['commodity_code']);
					}

					$goods_delivery_row_template .= $this->warehouse_model->create_goods_delivery_row_template($warehouse_data, 'items[' . $index_receipt . ']', $commodity_name, $delivery_detail['warehouse_id'], $delivery_detail['available_quantity'], $delivery_detail['quantities'], $unit_name, $delivery_detail['unit_price'], $taxname, $delivery_detail['commodity_code'], $delivery_detail['unit_id'] , $delivery_detail['tax_rate'], $delivery_detail['total_money'], $delivery_detail['discount'], $delivery_detail['discount_money'], $delivery_detail['total_after_discount'],$delivery_detail['guarantee_period'], $expiry_date, $lot_number, $delivery_detail['note'], $delivery_detail['sub_total'],$delivery_detail['tax_name'],$delivery_detail['tax_id'], $delivery_detail['id'], true, $is_purchase_order);
					
				}
			}
		}

		//edit note after approval
		$data['edit_approval'] = $edit_approval;
		$data['goods_delivery_row_template'] = $goods_delivery_row_template;

		return $this->template->rander("Warehouse\Views\manage_goods_delivery\delivery", $data);


	}

	/**
	 * commodity goods delivery change
	 * @param  integer $val
	 * @return json
	 */
	public function commodity_goods_delivery_change($val='') {

			$data = $this->request->getPost();
			if($data['switch_barcode_scanners'] == 'true'){
				$value = $this->warehouse_model->get_commodity_delivery_hansometable_by_barcode($data['oldValue']);
			}else{
				$value = $this->warehouse_model->commodity_goods_delivery_change($data['oldValue']);
			}


			echo json_encode([
				'value' => $value['commodity_value'],
				'warehouse_inventory' => $value['warehouse_inventory'],
				'guarantee_new' => $value['guarantee_new'],
			]);
			die;
		
	}

	/**
	 * table manage delivery
	 * @return array
	 */
	public function table_manage_delivery() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'manage_goods_delivery/table_manage_delivery'), $dataPost);
	}

	/**
	 * edit delivery
	 * @param  integer $id
	 * @return view
	 */
	public function edit_delivery($id) {
		//check exist
		$goods_delivery = $this->warehouse_model->get_goods_delivery($id);
		if (!$goods_delivery) {
			blank_page('Stock export Not Found', 'danger');
		}

		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");

		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {
			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 2);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 2);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 2);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 2);

		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['goods_delivery_detail'] = json_encode($this->warehouse_model->get_goods_delivery_detail($id));

		$data['goods_delivery'] = $goods_delivery;

		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();
		$data['tax_data'] = $this->warehouse_model->get_html_tax_delivery($id);

		$data['title'] = _l('stock_export_info');
		$check_appr = $this->warehouse_model->get_approve_setting('2');
		$data['check_appr'] = $check_appr;
		$this->load->model('currencies_model');
		$base_currency = $this->currencies_model->get_base_currency();
		$data['base_currency'] = $base_currency;

		$this->load->view('manage_goods_delivery/edit_delivery', $data);

	}

	/**
	 * stock export pdf
	 * @param  integer $id
	 * @return pdf file view
	 */
	public function stock_export_pdf($id) {
		if (!$id) {
			redirect(admin_url('warehouse/manage_goods_delivery/manage_delivery'));
		}

		$stock_export = $this->warehouse_model->get_stock_export_pdf_html($id);

		try {
			$pdf = $this->warehouse_model->stock_export_pdf($stock_export);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';
		ob_end_clean();

		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}

		$pdf->Output('goods_delivery_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);
	}

	/**
	 * manage report
	 * @return view
	 */
	public function manage_report() {
		$data['group'] = $this->request->getGet('group');

		$data['title'] = _l('als_report');
		$data['tab'][] = 'stock_summary_report';
		$data['tab'][] = 'inventory_inside';
		$data['tab'][] = 'inventory_valuation_report';
		$data['tab'][] = 'warranty_period_report';

		switch ($data['group']) {
			case 'stock_summary_report':
			$data['title'] = _l('stock_summary_report');

			break;
			case 'inventory_valuation_report':
			$data['title'] = _l('inventory_valuation_report');

			break;
			case 'inventory_inside':
			$data['title'] = _l('inventory_inside');

			break;

			case 'warranty_period_report':
			$data['title'] = _l('wh_warranty_period_report');

			break;


			default:
			$data['title'] = _l('stock_summary_report');
			$data['group'] = 'stock_summary_report';
			break;
		}
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();

		$data['tabs']['view'] = 'report/' . $data['group'];
		$data['period_to_date'] = '';
		$data['period_status_id'] = [1,2];
		$data['clients'] = $this->clients_model->get();

		$this->load->view('report/manage_report', $data);
	}

	/**
	 * get data stock summary report
	 * @return json
	 */
	public function get_data_stock_summary_report() {
		if ($this->request->getPost()) {
			$data = $this->request->getPost();

			$stock_summary_report = $this->warehouse_model->get_stock_summary_report_view($data);
		}

		echo json_encode([
			'value' => $stock_summary_report,
		]);
		die();
	}

	/**
	 * stock summary report pdf
	 * @return pdf view file
	 */
	public function stock_summary_report_pdf() {
		$data = $this->request->getPost();
		if (!$data) {
			redirect(admin_url('warehouse/report/manage_report'));
		}

		$stock_summary_report = $this->warehouse_model->get_stock_summary_report($data);

		try {
			$pdf = $this->warehouse_model->stock_summary_report_pdf($stock_summary_report);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';
		ob_end_clean();
		
		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}

		$pdf->Output('stock_summary_report.pdf', $type);
	}

	/**
	 * view delivery
	 * @param  integer $id
	 * @return view
	 */
	public function view_delivery($id) {
		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");

		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {
			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 2);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 2);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 2);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 2);

		$data['goods_delivery_detail'] = $this->warehouse_model->get_goods_delivery_detail($id);

		$data['goods_delivery'] = $this->warehouse_model->get_goods_delivery($id);
		$data['activity_log'] = $this->warehouse_model->wh_get_activity_log($id,'delivery');
		$data['packing_lists'] = $this->warehouse_model->get_packing_list_by_deivery_note($id);

		$data['title'] = _l('stock_export_info');
		$check_appr = $this->warehouse_model->get_approve_setting('2');
		$data['check_appr'] = $check_appr;
		$data['tax_data'] = $this->warehouse_model->get_html_tax_delivery($id);
		
		return $this->template->rander("Warehouse\Views\manage_goods_delivery/delivery_note_detail", $data);

	}

	/**
	 * check quantity inventory
	 * @return json
	 */
	public function check_quantity_inventory() {
		$data = $this->request->getPost();
		if ($data != 'null') {

			//switch_barcode_scanners
			if($data['switch_barcode_scanners'] == 'true'){
				$data['commodity_id'] = $this->warehouse_model->get_commodity_id_from_barcode($data['commodity_id']);
			}

			/*check without checking warehouse*/
			if($this->warehouse_model->check_item_without_checking_warehouse($data['commodity_id']) == true){
				//checking

				$value = $this->warehouse_model->get_quantity_inventory($data['warehouse_id'], $data['commodity_id']);

				$quantity = 0;
				if ($value != null) {

					if ((float) get_object_vars($value)['inventory_number'] < (float) $data['quantity']) {
						$message = _l('in_stock');
						$quantity = (float)get_object_vars($value)['inventory_number'];
					} else {
						$message = true;
						$quantity = (float)get_object_vars($value)['inventory_number'];
					}

				} else {
					$message = _l('Product_does_not_exist_in_stock');
				}

			}else{
				//without checking
				$message = true;
				$quantity = 0;

			}

			echo json_encode([
				'message' => $message,
				'value' => $quantity,
			]);
			die;
		}
	}

	/**
	 *  quantity inventory
	 * @return json
	 */
	public function quantity_inventory() {
		$data = $this->request->getPost();
		if ($data != 'null') {
			if(strlen($data['expiry_date']) > 0){
				$data['expiry_date'] = to_sql_date1($data['expiry_date']);
			}
			$value = $this->warehouse_model->get_adjustment_stock_quantity($data['warehouse_id'], $data['commodity_id'], $data['lot_number'], $data['expiry_date']);

			$quantity = 0;
			if ($value != null) {

				$message = _l('in_stock');
				$quantity = get_object_vars($value)['inventory_number'];

			} else {
				$message = _l('Product_does_not_exist_in_stock');
			}

			echo json_encode([
				'message' => $message,
				'value' => (float)$quantity,
				'unit' => 0,
			]);
			die;
		}
	}

	/**
	 * check quantity inventory onsubmit
	 * @return json
	 */
	public function check_quantity_inventory_onsubmit() {
		$data = $this->request->getPost();
		$flag = 0;
		$message = true;

		$str_error='';

		$arr_available_quantity=[];

		
		if ($data['hot_delivery'] != 'null') {
			foreach ($data['hot_delivery'] as $delivery_value) {
				
				//switch_barcode_scanners
				if($data['switch_barcode_scanners'] == 'true'){
					$delivery_value[0] = $this->warehouse_model->get_commodity_id_from_barcode($delivery_value[0]);
				}

				if ( $delivery_value[0] != '' ) {
					if($delivery_value[1] != '' || $data['warehouse_id'] != ''){
						//check without checking warehouse
						
						if($data['warehouse_id'] != ''){
							$delivery_value[1] = $data['warehouse_id'];
						}

						$commodity_name='';
						$item_value = $this->warehouse_model->get_commodity($delivery_value[0]);

						if($item_value){
							$commodity_name .= $item_value->commodity_code.'_'.$item_value->description;
						}

						if($this->warehouse_model->check_item_without_checking_warehouse($delivery_value[0]) == true){

							$value = $this->warehouse_model->get_quantity_inventory($delivery_value[1], $delivery_value[0]);

							if ($value != null) {
								array_push($arr_available_quantity, (float) get_object_vars($value)['inventory_number']);
								if ((float) get_object_vars($value)['inventory_number'] < (float) $delivery_value[4]) {
									$flag = 1;
									$str_error .= $commodity_name._l('not_enough_inventory').', '._l('available_quantity').': '.(float) get_object_vars($value)['inventory_number'].'<br/>';
								}
							} else {
								$flag = 1;
								$str_error .=$commodity_name. _l('Product_does_not_exist_in_stock').'<br/>';
							}
						}

					}else{
						$flag = 1;
						$str_error .= _l('please_choose_from_stock_name').'<br/>';
					}
				}

			}
			
			if ($flag == 1) {
				$message = false;

			} else {
				$message = true;
			}

			echo json_encode([
				'message' => $message,
				'str_error' => $str_error,
				'arr_available_quantity' => $arr_available_quantity,

			]);
			die;
		}
	}

	/**
	 * manage stock take
	 * @param  integer $id
	 * @return view
	 */
	public function manage_stock_take($id = '') {
		$data['stock_take_id'] = $id;
		$data['title'] = _l('stock_take');
		$this->load->view('manage_stock_take/manage', $data);
	}

	/**
	 * table manage stock table
	 * @return array
	 */
	public function table_manage_stock_take() {
		$this->app->get_table_data(module_views_path('Warehouse', 'manage_stock_take/table_manage_stock_take'));
	}

	/**
	 * stock take
	 * @param  integer $id
	 * @return view
	 */
	public function stock_take() {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_goods_receipt($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . _l('stock_take'));

				} else {
					set_alert('warning', _l('Add_stock_take_false'));
				}
				redirect(admin_url('warehouse/manage_stock_take'));

			}
		}
		//get vaule render dropdown select
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_code_name'] = $this->warehouse_model->get_units_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();

		$data['title'] = _l('inventory_goods_materials');

		$data['commodity_codes'] = $this->warehouse_model->get_commodity();

		$data['warehouses'] = $this->warehouse_model->get_warehouse();
		if (get_status_modules_wh('purchase')) {
			$data['pr_orders'] = get_pr_order();
		} else {
			$data['pr_orders'] = [];
		}

		$data['vendors'] = $this->warehouse_model->get_vendor();

		$data['goods_code'] = $this->warehouse_model->create_goods_code();
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staff'] = $this->Users_model->get_details($options)->getResultArray();

		$this->load->view('manage_stock_take/stock_take', $data);

	}

	/**
	 * commodity list add edit
	 * @param  integer $id
	 * @return json
	 */
	public function commodity_list_add_edit($id = '') {
		$data = $this->request->getPost();
		if ($data) {
			 $id = $this->request->getPost('id');

			$target_path = get_setting("timeline_file_path");
			$files_data = move_files_from_temp_dir_to_permanent_dir($target_path, "item");
			$new_files = unserialize($files_data);

			if ($id) {
				$item_info = $this->Items_model->get_one($id);
				$timeline_file_path = get_setting("timeline_file_path");

				$new_files = update_saved_files($timeline_file_path, $item_info->files, $new_files);
			}
			$data["files"] = serialize($new_files);

			if (!$id) {

				$result = $this->warehouse_model->add_commodity_one_item($data);
				if ($result) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("add_failed"));
				}
				app_redirect("warehouse/commodity_list");

			} else {

				$id = $data['id'];
				if(isset($data['id'])){
					unset($data['id']);
				}
				$result = $this->warehouse_model->update_commodity_one_item($data, $id);

				if ($result) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/commodity_list");
			}
		}

	}

	/**
	 * get commodity file url
	 * @param  integer $commodity_id
	 * @return json
	 */
	public function get_commodity_file_url($commodity_id) {
		$arr_commodity_file = $this->warehouse_model->get_warehourse_attachments($commodity_id);
		/*get images old*/
		$images_old_value = '';

		if (count($arr_commodity_file) > 0) {
			foreach ($arr_commodity_file as $key => $value) {
				$images_old_value .= '<div class="dz-preview dz-image-preview image_old' . $value["id"] . '">';
				$rel_type = '';

				$images_old_value .= '<div class="dz-image">';
				if (file_exists(WAREHOUSE_ITEM_UPLOAD . $value["rel_id"] . '/' . $value["file_name"])) {
					$images_old_value .= '<img class="image-w-h" data-dz-thumbnail alt="' . $value["file_name"] . '" src="' . site_url('modules/warehouse/uploads/item_img/' . $value["rel_id"] . '/' . $value["file_name"]) . '">';

					$rel_type = 'warehouse' ;
				} elseif(file_exists('modules/purchase/uploads/item_img/'. $value["rel_id"] . '/' . $value["file_name"])) {
					$images_old_value .= '<img class="image-w-h" data-dz-thumbnail alt="' . $value["file_name"] . '" src="' . site_url('modules/purchase/uploads/item_img/' . $value["rel_id"] . '/' . $value["file_name"]) . '">';

					$rel_type = 'purchase' ;
				}elseif(file_exists('modules/manufacturing/uploads/products/'. $value["rel_id"] . '/' . $value["file_name"])) {
					$images_old_value .= '<img class="image-w-h" data-dz-thumbnail alt="' . $value["file_name"] . '" src="' . site_url('modules/manufacturing/uploads/products/' . $value["rel_id"] . '/' . $value["file_name"]) . '">';

					$rel_type = 'manufacturing' ;
				}

				if ($rel_type != '') {
					$images_old_value .= '</div>';

					$images_old_value .= '<div class="dz-error-mark">';
					$images_old_value .= '<a class="dz-remove" data-dz-remove>Remove file';
					$images_old_value .= '</a>';
					$images_old_value .= '</div>';


					$images_old_value .= '<div class="remove_file">';
					$images_old_value .= '<a href="#" class="text-danger" onclick="delete_product_attachment(this,' . $value["id"] . ','.'\''.$rel_type.'\'); return false;"><i class="fa fa fa-times"></i></a>';
					$images_old_value .= '</div>';

					$images_old_value .= '</div>';
				}
			}
		}

		echo json_encode([
			'arr_images' => $images_old_value,
		]);
		die();

	}

	/**
	 * sub group
	 * @param  integer $id
	 * @return redirect
	 */
	public function sub_group($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_sub_group($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') . ' ' . _l('sub_group'));

				} else {
					set_alert('warning', _l('Add_sub_group_false'));
				}
				redirect(admin_url('warehouse/setting?group=sub_group'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->add_sub_group($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') . ' ' . _l('sub_group'));
				} else {
					set_alert('warning', _l('updated_sub_group_false'));
				}

				redirect(admin_url('warehouse/setting?group=sub_group'));
			}
		}
	}

	/**
	 * delete sub group
	 * @param  integer $id
	 * @return redirect
	 */
	public function delete_sub_group($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=sub_group'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}


		$response = $this->warehouse_model->delete_sub_group($id);
		if (is_array($response) && isset($response['referenced'])) {
			set_alert('warning', _l('is_referenced', _l('sub_group')));
		} elseif ($response == true) {
			set_alert('success', _l('deleted', _l('sub_group')));
		} else {
			set_alert('warning', _l('problem_deleting', _l('sub_group')));
		}
		redirect(admin_url('warehouse/setting?group=sub_group'));
	}

	/**
	 * add commodity attachment
	 * @param  integer $id
	 * @return json
	 */
	public function add_commodity_attachment($id, $add_variant='') {

		handle_commodity_attachments($id);
		echo json_encode([

			'url' => admin_url('warehouse/commodity_list'),
			'add_variant' => $add_variant,
			'id' => $id,
		]);
	}

	/**
	 * import xlsx commodity
	 * @param  integer $id
	 * @return view
	 */
	public function import_xlsx_commodity() {
		if (!$this->login_user->is_admin && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}

		$user_id = $this->login_user->id;

		$_personal_language = get_setting('user_' . $user_id . '_personal_language');
		if(strlen($_personal_language) == 0){
			$_personal_language = get_setting("language");
		}

		$data['active_language'] = $_personal_language;
		$data['title'] = _l('import_excel');
		$data['site_url'] = base_url();


		return $this->template->rander("Warehouse\Views\items\import_excel", $data);
	}

	/**
	 * import file xlsx commodity
	 * @return json
	 */
	public function import_file_xlsx_commodity() {
		if (!is_admin() && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}
		$user_id = $this->login_user->id;

		if(!class_exists('XLSXReader_fin')){
			require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXReader/XLSXReader.php');
		}
		require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXWriter/xlsxwriter.class.php');

		$total_row_false = 0;
		$total_rows_data = 0;
		$dataerror = 0;
		$total_row_success = 0;
		$total_rows_data_error = 0;
		$filename='';

		if ($this->request->getPost()) {

			/*delete file old before export file*/
			$path_before = COMMODITY_ERROR.'FILE_ERROR_COMMODITY'.$user_id.'.xlsx';
			if(file_exists($path_before)){
				unlink(COMMODITY_ERROR.'FILE_ERROR_COMMODITY'.$user_id.'.xlsx');
			}

			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {

					$temp_file_path = get_setting("temp_file_path");
					$tmpDir = getcwd() . '/' . $temp_file_path;
					if (!is_dir($tmpDir)) {
						if (!mkdir($tmpDir, 0777, true)) {
							die('Failed to create file folders.');
						}
					}

					// Setup our new file path
					$newFilePath = $tmpDir . $_FILES['file_csv']['name'];

					if (move_uploaded_file($tmpFilePath, $newFilePath)) {
						$import_result = true;
						$rows = [];

						//Writer file
						$writer_header = array(
							"(*)" ._l('commodity_code')          =>'string',
							"(*)" ._l('commodity_name')          =>'string',
							_l('commodity_barcode')          =>'string',
							_l('sku_code')          =>'string',
							_l('sku_name')          =>'string',
							_l('description')          =>'string',
							_l('commodity_type')          =>'string',
							_l('unit_id')          =>'string',
							"(*)" ._l('commodity_group')          =>'string',
							_l('_profit_rate'). "(%)"          =>'string',
							_l('purchase_price')          =>'string',
							"(*)" ._l('rate')          =>'string',
							_l('tax')          =>'string',
							_l('origin')          =>'string',
							_l('style_id')          =>'string',
							_l('model_id')          =>'string',
							_l('size_id')          =>'string',
							_l('_color')          =>'string',
							_l('guarantee_month')          =>'string',
							_l('minimum_inventory')          =>'string',
							_l('error')                     =>'string',
						);

						$widths_arr = array();
						for($i = 1; $i <= count($writer_header); $i++ ){
							$widths_arr[] = 40;
						}

						$writer = new \XLSXWriter();

						$col_style1 =[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
						$style1 = ['widths'=> $widths_arr, 'fill' => '#ff9800',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ];

						$writer->writeSheetHeader_v2('Sheet1', $writer_header,  $col_options = ['widths'=> $widths_arr, 'fill' => '#f44336',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ], $col_style1, $style1);

						//init file error end

						//Reader file
						$xlsx = new \XLSXReader_fin($newFilePath);
						$sheetNames = $xlsx->getSheetNames();
						$data = $xlsx->getSheetData($sheetNames[1]);

						// start row write 2
						$numRow = 2;
						$total_rows = 0;

						$total_rows_actualy = 0;

						$flag_insert_id = 0;
						
						//get data for compare

						for ($row = 1; $row < count($data); $row++) {

								$rd = array();
								$flag = 0;
								$flag2 = 0;
								$flag_mail = 0;
								$string_error = '';
								$flag_contract_form = 0;

								$flag_id_commodity_type;
								$flag_id_unit_id = 0;
								$flag_id_commodity_group;
								$flag_id_sub_group;
								$flag_id_warehouse_id;
								$flag_id_tax;
								$flag_id_style_id;
								$flag_id_model_id;
								$flag_id_size_id;


								$value_cell_commodity_code = isset($data[$row][0]) ? $data[$row][0] : null; //A
								$value_cell_description = isset($data[$row][1]) ? $data[$row][1] : null; //B
								$value_cell_commodity_barcode = isset($data[$row][2]) ? $data[$row][2] : ''; //A
								$value_cell_sku_code = isset($data[$row][3]) ? $data[$row][3] : ''; //A
								$value_cell_sku_name = isset($data[$row][4]) ? $data[$row][4] : ''; //A

								$value_cell_long_description = isset($data[$row][5]) ? $data[$row][5] : ''; //A
								$value_cell_commodity_type = isset($data[$row][6]) ? $data[$row][6] : '';
								$value_cell_unit_id = isset($data[$row][7]) ? $data[$row][7] : '';
								$value_cell_commodity_group = isset($data[$row][8]) ? $data[$row][8] : null;

								$value_cell_profit_rate = isset($data[$row][9]) ? $data[$row][9] : '';
								$value_cell_purchase_price = isset($data[$row][10]) ? $data[$row][10] : '';
								$value_cell_rate = isset($data[$row][11]) ? $data[$row][11] : '';
								$value_cell_tax = isset($data[$row][12]) ? $data[$row][12] : '';
								$value_cell_origin = isset($data[$row][13]) ? $data[$row][13] : '';
								$value_cell_style_id = isset($data[$row][14]) ? $data[$row][14] : '';
								$value_cell_model_id = isset($data[$row][15]) ? $data[$row][15] : '';
								$value_cell_size_id = isset($data[$row][16]) ? $data[$row][16] : '';
								$value_cell_color_id = isset($data[$row][17]) ? $data[$row][17] : '';
								$value_cell_warranty = isset($data[$row][18]) ? $data[$row][18] : null;
								$value_cell_minimum_inventory = isset($data[$row][19]) ? $data[$row][19] : '';


								$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';

								$reg_day = '#^(((1)[0-2]))(\/)\d{4}-(3)[0-1])(\/)(((0)[0-9])-[0-2][0-9]$#'; /*yyyy-mm-dd*/

								/*check null*/
								if (is_null($value_cell_commodity_code) == true) {
									$string_error .= _l('commodity_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_commodity_group) == true) {
									$string_error .= _l('commodity_group') . _l('not_yet_entered');
									$flag = 1;
								}


								if (is_null($value_cell_description) == true) {
									$string_error .= _l('commodity_name') . _l('not_yet_entered');
									$flag = 1;
								}

								//check commodity_type exist  (input: id or name contract)
								if (is_null($value_cell_commodity_type) != true && $value_cell_commodity_type != '0' && $value_cell_commodity_type != '') {
									/*case input  id*/
									if (is_numeric($value_cell_commodity_type)) {
										$builder = db_connect('default');
										$builder = $builder->table(get_db_prefix().'ware_commodity_type');
										$builder->where('commodity_type_id', $value_cell_commodity_type);
										$commodity_type_value = $builder->get()->getResultArray();

										if (count($commodity_type_value) == 0) {
											$string_error .= _l('commodity_type') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_type*/
											$flag_id_commodity_type = $value_cell_commodity_type;
										}

									} else {
										/*case input name*/
										$builder = db_connect('default');
										$builder = $builder->table(get_db_prefix().'ware_commodity_type');
										$builder->like('commondity_code', $value_cell_commodity_type);
										$commodity_type_value = $builder->get()->getResultArray();
										if (count($commodity_type_value) == 0) {
											$string_error .= _l('commodity_type') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_type*/

											$flag_id_commodity_type = $commodity_type_value[0]['commodity_type_id'];
										}
									}

								}

								//check unit_code exist  (input: id or name contract)
								if (is_null($value_cell_unit_id) != true && ( $value_cell_unit_id != '0')  && $value_cell_unit_id != '') {
									/*case input id*/
									if (is_numeric($value_cell_unit_id)) {
										
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_unit_type');
										$builder->where('unit_type_id', $value_cell_unit_id);
										$unit_id_value = $builder->get()->getResultArray();

										if (count($unit_id_value) == 0) {
											$string_error .= _l('unit_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id unit_id*/
											$flag_id_unit_id = $value_cell_unit_id;
										}

									} else {
										/*case input name*/
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_unit_type');
										$builder->like('unit_code', $value_cell_unit_id);

										$unit_id_value = $builder->get()->getResultArray();
										if (count($unit_id_value) == 0) {
											$string_error .= _l('unit_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get unit_id*/
											$flag_id_unit_id = $unit_id_value[0]['unit_type_id'];
										}
									}

								}

								//check commodity_group exist  (input: id or name contract)
								if (is_null($value_cell_commodity_group) != true && ($value_cell_commodity_group != '0') && $value_cell_commodity_group != '') {
									/*case input id*/
									if (is_numeric($value_cell_commodity_group)) {
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'item_categories');
										$builder->where('id', $value_cell_commodity_group);
										$commodity_group_value = $builder->get()->getResultArray();

										if (count($commodity_group_value) == 0) {
											$string_error .= _l('commodity_group') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_group*/
											$flag_id_commodity_group = $value_cell_commodity_group;
										}

									} else {
										/*case input name*/
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'item_categories');
										$builder->like('commodity_group_code', $value_cell_commodity_group);

										$commodity_group_value = $builder->get()->getResultArray();
										if (count($commodity_group_value) == 0) {
											$string_error .= _l('commodity_group') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id commodity_group*/

											$flag_id_commodity_group = $commodity_group_value[0]['id'];
										}
									}

								}

								//check commodity_group exist  (input: id or name contract)
								if (is_null($value_cell_warranty) != true) {
									/*case input id*/
									if (!is_numeric($value_cell_warranty)) {
										/*case input name*/
										$string_error .= _l('guarantee_month') . _l('_check_invalid');
										$flag2 = 1;
										
									}

								}


								//check taxes exist  (input: id or name contract)
								if (is_null($value_cell_tax) != true && ($value_cell_tax!= '0')  && $value_cell_tax != '') {
									/*case input id*/
									if (is_numeric($value_cell_tax)) {
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'taxes');
										$builder->where('id', $value_cell_tax);
										$cell_tax_value = $builder->get()->getResultArray();

										if (count($cell_tax_value) == 0) {
											$string_error .= _l('tax') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id cell_tax*/
											$flag_id_tax = $value_cell_tax;
										}

									} else {
										/*case input name*/
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'taxes');
										$builder->like('title', $value_cell_tax);

										$cell_tax_value = $builder->get()->getResultArray();
										if (count($cell_tax_value) == 0) {
											$string_error .= _l('tax') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id warehouse_id*/

											$flag_id_tax = $cell_tax_value[0]['id'];
										}
									}

								}

								//check commodity_group exist  (input: id or name contract)
								if (is_null($value_cell_style_id) != true && ($value_cell_style_id != '0')  && $value_cell_style_id != '' ) {
									/*case input id*/
									if (is_numeric($value_cell_style_id)) {
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_style_type');

										$builder->where('style_type_id', $value_cell_style_id);
										$style_id_value = $builder->get()->getResultArray();

										if (count($style_id_value) == 0) {
											$string_error .= _l('style_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id style_id*/
											$flag_id_style_id = $value_cell_style_id;
										}

									} else {
										/*case input  name*/
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_style_type');

										$builder->like(get_db_prefix() . 'ware_style_type.style_code', $value_cell_style_id);

										$style_id_value = $builder->get()->getResultArray();
										if (count($style_id_value) == 0) {
											$string_error .= _l('style_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id style_id*/

											$flag_id_style_id = $style_id_value[0]['style_type_id'];
										}
									}

								}

								//check body_code exist  (input: id or name contract)
								if (is_null($value_cell_model_id) != true && ($value_cell_model_id != '0') && $value_cell_model_id != '' ) {
									/*case input id*/
									if (is_numeric($value_cell_model_id)) {
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_body_type');

										$builder->where('body_type_id', $value_cell_model_id);
										$model_id_value = $builder->get()->getResultArray();

										if (count($model_id_value) == 0) {
											$string_error .= _l('model_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id model_id*/
											$flag_id_model_id = $value_cell_model_id;
										}

									} else {
										/*case input name*/
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_body_type');
										$builder->like(get_db_prefix() . 'ware_body_type.body_code', $value_cell_model_id);

										$model_id_value = $builder->get()->getResultArray();
										if (count($model_id_value) == 0) {
											$string_error .= _l('model_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id model_id*/

											$flag_id_model_id = $model_id_value[0]['body_type_id'];
										}
									}

								}

								//check size_code exist  (input: id or name contract)
								if (is_null($value_cell_size_id) != true && ($value_cell_size_id != '0') && $value_cell_size_id != '') {
									/*case input id*/
									if (is_numeric($value_cell_size_id)) {
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_size_type');
										$builder->where('size_type_id', $value_cell_size_id);
										$size_id_value = $builder->get()->getResultArray();

										if ($size_id_value == 0) {
											$string_error .= _l('size_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id size_id*/
											$flag_id_size_id = $value_cell_size_id;
										}

									} else {
										/*case input name*/
										$builder = db_connect('default');

										$builder = $builder->table(get_db_prefix().'ware_size_type');
										$builder->like(get_db_prefix() . 'ware_size_type.size_code', $value_cell_size_id);

										$size_id_value = $builder->get()->getResultArray();
										if (count($size_id_value) == 0) {
											$string_error .= _l('size_id') . _l('does_not_exist');
											$flag2 = 1;
										} else {
											/*get id size_id*/

											$flag_id_size_id = $size_id_value[0]['size_type_id'];
										}
									}

								}

								//check value_cell_rate input
								if (is_null($value_cell_rate) != true && $value_cell_rate != '') {
									if (!is_numeric($value_cell_rate)) {
										$string_error .= _l('cell_rate') . _l('_check_invalid');
										$flag = 1;

									}

								}

								//check value_cell_rate input
								if (is_null($value_cell_purchase_price) != true && $value_cell_purchase_price != '') {
									if (!is_numeric($value_cell_purchase_price)) {
										$string_error .= _l('purchase_price') . _l('_check_invalid');
										$flag = 1;

									}

								}

								//check commodity min input
								if (is_null($value_cell_minimum_inventory) != true && $value_cell_minimum_inventory != '') {
									if (!is_numeric($value_cell_minimum_inventory)) {
										$string_error .= _l('inventory_min') . _l('_check_invalid');
										$flag = 1;

									}

								}
								

								if (($flag == 0) && ($flag2 == 0)) {

									/*staff id is HR_code, input is HR_CODE, insert => staffid*/
									$rd['commodity_code'] = isset($data[$row][0]) ? $data[$row][0] : '';
									$rd['commodity_barcode'] = isset($data[$row][2]) ? $data[$row][2] : '';
									$rd['sku_code'] = isset($data[$row][3]) ? $data[$row][3] : '';
									$rd['sku_name'] = isset($data[$row][4]) ? $data[$row][4] : '';
									$rd['title'] = isset($data[$row][1]) ? $data[$row][1] : '';

									$rd['description'] = isset($data[$row][5]) ? $data[$row][5] : '';

									$rd['commodity_type'] = isset($flag_id_commodity_type) ? $flag_id_commodity_type : '';
									$rd['unit_id'] = isset($flag_id_unit_id) ? $flag_id_unit_id : '';
									$rd['category_id'] = isset($flag_id_commodity_group) ? $flag_id_commodity_group : '';

									$rd['guarantee'] = isset($data[$row][18]) ? $data[$row][18] : '';
									$rd['tax'] = isset($flag_id_tax) ? $flag_id_tax : '';

									$rd['origin'] = isset($data[$row][13]) ? $data[$row][13] : '';

									$rd['style_id'] = isset($flag_id_style_id) ? $flag_id_style_id : '';
									$rd['model_id'] = isset($flag_id_model_id) ? $flag_id_model_id : '';
									$rd['size_id'] = isset($flag_id_size_id) ? $flag_id_size_id : '';
									$rd['color_id'] = 0;
									$rd['warehouse_id'] = 0;

									$rd['profif_ratio'] = isset($data[$row][9]) ? $data[$row][9] : null;

									$rd['rate'] = isset($data[$row][11]) ? $data[$row][11] : null;
									$rd['purchase_price'] = isset($data[$row][10]) ? $data[$row][10] : null;
									$rd['minimum_inventory'] = isset($value_cell_minimum_inventory) ? $value_cell_minimum_inventory : 0;
									$rd['without_checking_warehouse'] =  0;

								}

								$flag_insert = false;

								if ($user_id != '' && $flag == 0 && $flag2 == 0) {
									$rows[] = $rd;
									$result_value = $this->warehouse_model->import_xlsx_commodity($rd, $flag_insert_id);
									if ($result_value['status']) {
										$total_rows_actualy++;
										$flag_insert = true;

										if(isset($result_value['insert_id'])){
											$flag_insert_id = $result_value['insert_id'];
										}else{
											$flag_insert_id = 0;
										}
									}else{
										$flag_insert_id = 0;
										$string_error .= $result_value['message'];
									}
								}

								if (($flag == 1) || ($flag2 == 1) || ($flag_insert == false)) {
									//write error file
									$writer->writeSheetRow('Sheet1', [
										$value_cell_commodity_code,
										$value_cell_description,
										$value_cell_commodity_barcode,
										$value_cell_sku_code,
										$value_cell_sku_name,

										$value_cell_long_description,
										$value_cell_commodity_type,
										$value_cell_unit_id,
										$value_cell_commodity_group,

										$value_cell_profit_rate,
										$value_cell_purchase_price,
										$value_cell_rate,
										$value_cell_tax,
										$value_cell_origin,
										$value_cell_style_id,
										$value_cell_model_id,
										$value_cell_size_id,
										$value_cell_color_id,
										$value_cell_warranty,
										$value_cell_minimum_inventory,
										$string_error,
									]);

									$numRow++;
									$total_rows_data_error++;
								}

								$total_rows++;
								$total_rows_data++;

						}

						if ($total_rows_actualy != $total_rows) {
							$total_rows = $total_rows_actualy;
						}


						$total_rows = $total_rows;
						$data['total_rows_post'] = count($rows);
						$total_row_success = $total_rows_actualy;
						$total_row_false = $total_rows - (int)$total_rows_actualy;
						$message = 'Not enought rows for importing';

						if(($total_rows_data_error > 0) || ($total_row_false != 0)){

							$filename = 'FILE_ERROR_COMMODITY' .$user_id.strtotime(date('Y-m-d H:i:s')). '.xlsx';
							$writer->writeToFile(str_replace($filename, WAREHOUSE_IMPORT_ITEM_ERROR.$filename, $filename));

							$filename = WAREHOUSE_IMPORT_ITEM_ERROR.$filename;
						}
						
						$import_result = true;
						delete_file_from_directory($newFilePath); //delete temp file

					}
					
				} else {
					set_alert('warning', _l('import_upload_failed'));
				}
			}

		}
		echo json_encode([
			'message' =>'Not enought rows for importing',
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_rows_data_error,
			'total_rows' => $total_rows_data,
			'site_url' => base_url(),
			'staff_id' => $user_id,
			'total_rows_data_error' => $total_rows_data_error,
			'filename' => $filename,
		]);

	}

	/**
	 * delete commodity file
	 * @param  integer $attachment_id
	 * @return json
	 */
	public function delete_commodity_file($attachment_id) {
		if (!has_permission('warehouse', '', 'delete') && !is_admin()) {
			app_redirect("forbidden");
		}

		$file = $this->misc_model->get_file($attachment_id);
		echo json_encode([
			'success' => $this->warehouse_model->delete_commodity_file($attachment_id),
		]);
	}

	/**
	 * colors
	 * @return [type] 
	 */
	public function colors() {
		$data['colors'] = $this->warehouse_model->get_color();
		return $this->template->rander("Warehouse\Views\includes\colors", $data);
	}
		
	/**
	 * list commodity type data
	 * @return [type] 
	 */
	public function list_color_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_color();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_color_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make commodity type row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_color_row($data) {

		return array(
			$data['color_id'],
			nl2br($data['color_code']),
			nl2br($data['color_name']),
			nl2br($data['color_hex']),
			$data['display'] == 1 ? app_lang("display_yes") : app_lang("display_no"),
			$data['note'],
			modal_anchor(get_uri("warehouse/color_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_commodity_type'), "data-post-id" => $data['color_id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['color_id'], "data-action-url" => get_uri("warehouse/delete_color/".$data['color_id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * commodity type modal form
	 * @return [type] 
	 */
	public function color_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$color_data = [];

		$id = $this->request->getPost('id');
		if($id && is_numeric($id)){
			$color = $this->warehouse_model->get_color($id);
			$data['color'] = $color;
		}else{
			$id = '';
		}
		$data['id'] = $id;

		return $this->template->view('Warehouse\Views\includes\modal_forms\color_modal', $data);
	}


	/**
	 * [colors_setting description]
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function colors_setting($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!is_numeric($id)) {

				$mess = $this->warehouse_model->add_color($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("add_failed"));
				}
				app_redirect("warehouse/colors");

			} else {
				$success = $this->warehouse_model->update_color($data, $id);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/colors");
			}
		}
	}

	/**
	 * [delete_color description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function delete_color($id) {
		if (!$id) {
			app_redirect('warehouse/colors');
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_color($id);
		if ($response) {
			echo json_encode(array("success" => true, "message" => app_lang('deleted')));
		} else {
			 echo json_encode(array("success" => false, "message" => app_lang('problem_deleting')));
		}

	}

	/**
	 * { loss adjustment }
	 */
	public function loss_adjustment() {
		$data['title'] = _l('loss_adjustment');
		return $this->template->rander("Warehouse\Views\loss_adjustment/manage", $data);
	}

	/**
	 * { loss adjustment table }
	 */
	public function loss_adjustment_table() {
		if ($this->input->is_ajax_request()) {
			if ($this->request->getPost()) {

				$time_filter = $this->request->getPost('time_filter');
				$date_create = $this->request->getPost('date_create');
				$type_filter = $this->request->getPost('type_filter');
				$status_filter = $this->request->getPost('status_filter');

				$query = '';
				if ($time_filter != '') {
					$query .= 'month(time) = month(\'' . $time_filter . '\') and day(time) = day(\'' . $time_filter . '\') and year(time) = year(\'' . $time_filter . '\') and ';
				}
				if ($date_create != '') {
					$query .= 'month(date_create) = month(\'' . $date_create . '\') and day(date_create) = day(\'' . $date_create . '\') and year(date_create) = year(\'' . $date_create . '\') and ';
				}
				if ($status_filter != '') {
					$query .= 'status = \'' . $status_filter . '\' and ';
				}
				$select = [

					'id',
					'id',
					'id',
					'id',
					'id',
					'id',
					'id',

				];
				$where = [(($query != '') ? ' where ' . rtrim($query, ' and ') : '')];

				$aColumns = $select;
				$sIndexColumn = 'id';
				$sTable = db_prefix() . 'wh_loss_adjustment';
				$join = [];

				$result = data_tables_init1($aColumns, $sIndexColumn, $sTable, $join, $where, [

					'time',
					'type',
					'reason',
					'addfrom',
					'status',
					'date_create',
				]);

				$output = $result['output'];
				$rResult = $result['rResult'];
				foreach ($rResult as $aRow) {
					$row = [];
					$allow_add = 0;
					if ($type_filter != '') {
						if ($type_filter == 'loss') {
							if ($aRow['type'] == 'loss') {
								$allow_add = 1;
							}
						}
						if ($type_filter == 'adjustment') {
							if ($aRow['type'] == 'adjustment') {
								$allow_add = 1;
							}
						}
						if ($type_filter == 'return') {
							if ($aRow['type'] == 'return') {
								$allow_add = 1;
							}
						}
					} else {
						$allow_add = 1;
					}

					$row[] = _l($aRow['type']);
					$row[] = _dt($aRow['time']);
					$row[] = format_to_date($aRow['date_create'], false);

					$status = '';
					if ((int) $aRow['status'] == 0) {
						$status = '<div class="btn btn-warning" >' . _l('draft') . '</div>';
					} elseif ((int) $aRow['status'] == 1) {
						$status = '<div class="btn btn-success" >' . _l('Adjusted') . '</div>';
					} elseif((int) $aRow['status'] == -1){

						$status = '<div class="btn btn-danger" >' . _l('reject') . '</div>';

					}

					$row[] = $status;

					$row[] = $aRow['reason'];
					$row[] = get_staff_full_name($aRow['addfrom']);

					$option = '';

					if (is_admin() || has_permission('warehouse', '', 'view')) {

						$option .= '<a href="' . admin_url('warehouse/view_lost_adjustment/' . $aRow['id']) . '" class="btn btn-default btn-icon" >';
						$option .= '<i class="fa fa-eye"></i>';
						$option .= '</a>';
					}

					if (is_admin() || has_permission('warehouse', '', 'edit')) { 

						if ((int) $aRow['status'] == 0) {
							$option .= '<a href="' . admin_url('warehouse/add_loss_adjustment/' . $aRow['id']) . '" class="btn btn-default btn-icon" >';
							$option .= '<i class="fa fa-pencil-square-o"></i>';
							$option .= '</a>';
						}
					}

					if (is_admin() || has_permission('warehouse', '', 'delete')) { 
						if ((int) $aRow['status'] == 0 || is_admin()) {
							$option .= '<a href="' . admin_url('warehouse/delete_loss_adjustment/' . $aRow['id']) . '" class="btn btn-danger btn-icon _delete">';
							$option .= '<i class="fa fa-remove"></i>';
							$option .= '</a>';
						}
					}

					$row[] = $option;
					if ($allow_add == 1) {
						$output['aaData'][] = $row;
					}
				}

				echo json_encode($output);
				die();
			}
		}
	}

	/**
	 * add loss adjustment
	 * @param string $id
	 * @return view 
	 */
	public function add_loss_adjustment($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();
			$data['date_create'] = to_sql_date1(get_my_local_time("Y-m-d H:i:s"), true);
			$data['addfrom'] = get_staff_user_id1();
			$id = $this->request->getPost('id');

			if (!$this->request->getPost('id')) {
				unset($data['id']);
				$id = $this->warehouse_model->add_loss_adjustment($data);
				if ($id) {
					$success = true;
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				}
				app_redirect("warehouse/loss_adjustment");
			} else {
				$success = $this->warehouse_model->update_loss_adjustment($data);
				if ($success) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/loss_adjustment");
			}
		}

		$data['warehouses'] = $this->warehouse_model->get_warehouse_code_name();
		$data['title'] = _l('loss_adjustment');
		$data['ajaxItems'] = false;

		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('can_be_inventory');
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$warehouse_data = $this->warehouse_model->get_warehouse();
		//sample
		$loss_adjustment_row_template = $this->warehouse_model->create_loss_adjustment_row_template();
		$data['internal_delivery_name_ex'] = 'LOSS_ADJUSTMENT' . date('YmdHi');

		if ($id != '') {
			$data['loss_adjustment'] = $this->warehouse_model->get_loss_adjustment($id);
			$loss_adjustments = $this->warehouse_model->get_loss_adjustment_detailt_by_masterid($id);

			if (count($loss_adjustments) > 0) {
				$index_internal_delivery = 0;
				foreach ($loss_adjustments as $loss_adjustment) {
					$index_internal_delivery++;
					$unit_name = wh_get_unit_name($loss_adjustment['unit']);
					$commodity_name = $loss_adjustment['commodity_name'];
					$expiry_date = null;
					
					if(strlen($commodity_name) == 0){
						$commodity_name = wh_get_item_variatiom($loss_adjustment['items']);
					}
					if($loss_adjustment['expiry_date'] != null && $loss_adjustment['expiry_date'] != ''){
						$expiry_date = format_to_date($loss_adjustment['expiry_date'], false);
					}
					
					$loss_adjustment_row_template .= $this->warehouse_model->create_loss_adjustment_row_template('items[' . $index_internal_delivery . ']', $commodity_name, $loss_adjustment['current_number'],$loss_adjustment['updates_number'], $unit_name, $expiry_date, $loss_adjustment['lot_number'],  $loss_adjustment['items'], $loss_adjustment['unit'] , $loss_adjustment['id'], true, $loss_adjustment['serial_number']);
				}
			}

			$data['title'] = _l('update_loss_adjustment');
		}

		$data['current_day'] = date('Y-m-d');
		$data['loss_adjustment_row_template'] = $loss_adjustment_row_template;

		return $this->template->rander("Warehouse\Views\loss_adjustment\add_loss_adjustment", $data);
	}

	/**
	 * adjust
	 * @param  [integer] $id 
	 * @return json     
	 */
	public function adjust($id) {
		$success = $this->warehouse_model->change_adjust($id);
		echo json_encode([
			'success' => $success,
		]);
		die;
	}

	/**
	 * { delete loss adjustment }
	 *
	 * @param      <type>  $id     The identifier
	 */
	public function delete_loss_adjustment() {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}
		$id = $this->request->getPost('id');
		$response = $this->warehouse_model->delete_loss_adjustment($id);
		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("wh_deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect('warehouse/loss_adjustment');

	}

	/**
	 * { get data inventory valuation report }
	 *
	 * @return json
	 */
	public function get_data_inventory_valuation_report() {
		if ($this->request->getPost()) {
			$data = $this->request->getPost();

			$inventory_valuation_report = $this->warehouse_model->get_inventory_valuation_report_view($data);
		}

		echo json_encode([
			'value' => $inventory_valuation_report,
		]);
		die();
	}

	/**
	 * table out of stock
	 * @return [type]
	 */
	public function table_out_of_stock() {

		$this->app->get_table_data(module_views_path('Warehouse', 'table_out_of_stock'));
	}

	/**
	 * table expired
	 * @return [type]
	 */
	public function table_expired() {

		$this->app->get_table_data(module_views_path('Warehouse', 'table_expired'));
	}

	/**
	 * view commodity detail
	 * @param  [integer] $commodity_id
	 * @return [type]
	 */
	public function view_commodity_detail($commodity_id) {
		$commodity_item = get_commodity_name($commodity_id);

		if (!$commodity_item) {
			blank_page('commodity item Not Found', 'danger');
		}

		//user for sub
		$data['units'] = $this->warehouse_model->get_unit_add_commodity();
		$data['commodity_types'] = $this->warehouse_model->get_commodity_type_add_commodity();
		$data['commodity_groups'] = $this->warehouse_model->get_commodity_group_add_commodity();
		$data['warehouses'] = $this->warehouse_model->get_warehouse_add_commodity();
		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();
		$data['styles'] = $this->warehouse_model->get_style_add_commodity();
		$data['models'] = $this->warehouse_model->get_body_add_commodity();
		$data['sizes'] = $this->warehouse_model->get_size_add_commodity();
		$data['sub_groups'] = [];
		$data['colors'] = $this->warehouse_model->get_color_add_commodity();
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$data['title'] = _l("item_detail");


		$data['commodity_item'] = $commodity_item;
		$data['commodity_file'] = [];

		$model_info = $this->Items_model->get_details(array("id" => $commodity_id, "login_user_id" => $this->login_user->id))->getRow();
        $data['model_info'] = $model_info;

		return $this->template->rander("Warehouse\Views\items\commodity_detail", $data);
	}

	/**
	 * table view commodity detail
	 * @return [type]
	 */
	public function table_view_commodity_detail() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'items/item_details/table_view_commodity_detail'), $dataPost);
	}

	/**
	 * delete goods receipt
	 * @param  [integer] $id
	 * @return redirect
	 */
	public function delete_goods_receipt() {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}
		$id = $this->request->getPost('id');
		$response = $this->warehouse_model->delete_goods_receipt($id);
		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("wh_deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect('warehouse/manage_purchase');
	}

	/**
	 * delete_goods_delivery
	 * @param  [integer] $id
	 * @return [redirect]
	 */
	public function delete_goods_delivery() {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}
		$id = $this->request->getPost('id');
		$response = $this->warehouse_model->delete_goods_delivery($id);
		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("wh_deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect('warehouse/manage_delivery');
	}

	/**
	 * Gets the commodity barcode.
	 */
	public function get_commodity_barcode() {
		$commodity_barcode = $this->warehouse_model->generate_commodity_barcode();

		echo json_encode([
			$commodity_barcode,
		]);
		die();
	}

	/**
	 * table inventory stock
	 * @return [type]
	 */
	public function table_inventory_stock() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'items/item_details/table_inventory_stock'), $dataPost);
	}

	 /**
	 * { tax change event }
	 *
	 * @param      <type>  $tax    The tax
	 * @return   json
	 */
	 public function tax_change($tax){
		$total_tax = $this->warehouse_model->get_taxe_value($tax);
		$tax_rate = 0;
		if($total_tax){
			$tax_rate = get_object_vars($total_tax)['taxrate'] + 0;
		}

		echo json_encode([
			'tax_rate' => $tax_rate,
		]);
	 }


	 /**
	  * tax change v2
	  * @param  [type] $tax 
	  * @return [type]
	  * this funtion used when $tax like 4|3      
	  */
	 public function tax_change_v2(){
		$tax_rate = 0;

		$tax = $this->request->getPost('tax_id');
		$tax = str_replace('|', ',', $tax);

		$total_tax = $this->warehouse_model->get_taxe_value_by_ids($tax);
		foreach ($total_tax as $tax_value) {
			$tax_rate += (float)$tax_value['taxrate'];
		}

		echo json_encode([
			'tax_rate' => $tax_rate,
		]);
	 }




	/**
	 * get invoices fill data
	 * @return json 
	 */
	public function get_invoices_fill_data()
	{
		$this->load->model('clients_model');
		$address='';

		$data = $this->request->getPost();
		$customer_value = $this->clients_model->get($data['customer_id']);

		if(isset($customer_value) && !is_array($customer_value)){
			$address .= $customer_value->shipping_street.', '.$customer_value->shipping_city.', '.$customer_value->shipping_state.', '.get_country_name($customer_value->shipping_country);
		}

		$invoices = $this->warehouse_model->get_invoices_by_customer($data['customer_id']);

		echo json_encode([
			'invoices' => $invoices,
			'address' => $address,

		]);

	}

	/**
	 * manage delivery filter
	 * @param  integer $id
	 * @return view
	 */
	public function manage_delivery_filter($id = '') {


		$data['invoice_id'] = $id;
		$data['delivery_id'] = '';

		$data['title'] = _l('stock_delivery_manage');
		$this->load->view('manage_goods_delivery/manage_delivery', $data);
	}


	/**
	 * warehouse delete bulk action
	 * @return
	 */
	public function warehouse_delete_bulk_action()
	{
		$this->access_only_team_members();

		$total_deleted = 0;
		$total_updated = 0;
		$total_cloned = 0;
		if ($this->request->getPost()) {

			$ids                   = $this->request->getPost('ids');
			$rel_type                   = $this->request->getPost('rel_type');

			/*check permission*/
			switch ($rel_type) {
				case 'commodity_list':
				if (!has_permission('warehouse', '', 'delete') && !$this->login_user->is_admin) {
					app_redirect("forbidden");
				}
				break;

				case 'change_item_selling_price':
				if (!has_permission('warehouse', '', 'edit') && !$this->login_user->is_admin) {
					app_redirect("forbidden");
				}
				break;

				case 'change_item_purchase_price':
				if (!has_permission('warehouse', '', 'edit') && !$this->login_user->is_admin) {
					app_redirect("forbidden");
				}
				break;

				


				default:
				break;
			}

			/*delete data*/
			if ( $this->request->getPost('mass_delete') && $this->request->getPost('mass_delete') == 'true' ) {
				if (is_array($ids)) {
					foreach ($ids as $id) {

						switch ($rel_type) {
							case 'commodity_list':
							if ($this->warehouse_model->delete_commodity($id)) {
								$total_deleted++;
								break;
							}else{
								break;
							}

							default:

							break;
						}


					}
				}

				/*return result*/
				switch ($rel_type) {
					case 'commodity_list':
					$this->session->setFlashdata("success_message", app_lang("total_commodity_list"). ": " .$total_deleted);

					break;

					default:
					break;

				}


			}

			// Clone items
			if ($this->request->getPost('clone_items') && $this->request->getPost('clone_items') == 'true') {
				if (is_array($ids)) {
					foreach ($ids as $id) {

							switch ($rel_type) {
								case 'commodity_list':
									if ($this->warehouse_model->clone_item($id)) {
										$total_cloned++;
										break;
									}else{
										break;
									}
								
								default:
								   
									break;
							}
						}
					}
				/*return result*/
				switch ($rel_type) {
					case 'commodity_list':
						$this->session->setFlashdata("success_message", app_lang("total_commodity_list"). ": " .$total_cloned);

						break;

					default:
						break;

				}
			}

			// update selling price, purchase price
			if ( ($this->request->getPost('change_item_selling_price') ) || ($this->request->getPost('change_item_purchase_price') )  )  {

				if (is_array($ids)) {
					foreach ($ids as $id) {

						switch ($rel_type) {
							case 'change_item_selling_price':
							if ($this->warehouse_model->commodity_udpate_profit_rate($id, $this->request->getPost('selling_price'), 'selling_percent' )) {
								$total_updated++;
								break;
							}else{
								break;
							}

							case 'change_item_purchase_price':
							if ($this->warehouse_model->commodity_udpate_profit_rate($id, $this->request->getPost('purchase_price'), 'purchase_percent' )) {
								$total_updated++;
								break;
							}else{
								break;
							}
							

							default:

							break;
						}


					}
				}

				/*return result*/
				switch ($rel_type) {
					case 'change_item_selling_price':
					$this->session->setFlashdata("success_message", app_lang("total_commodity_list"). ": " .$total_updated);
					break;

					case 'change_item_purchase_price':
					$this->session->setFlashdata("success_message", app_lang("total_commodity_list"). ": " .$total_updated);
					break;

					default:
					break;

				}

			}


		}


	}


	/**
	 * get subgroup fill data
	 * @return html 
	 */
	public function get_subgroup_fill_data()
	{
		$data = $this->request->getPost();

		$subgroup = $this->warehouse_model->list_subgroup_by_group($data['group_id']);

		echo json_encode([
			'subgroup' => $subgroup
		]);

	}

	/**
	 * warehouse selling price profif ratio
	 * @return boolean 
	 */
	public function warehouse_selling_price_profif_ratio(){
		$data = $this->request->getPost();

		if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
			$success = false;
			$message = _l('Not permission edit');

			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}

		if($data != 'null'){
			$value = $this->warehouse_model->update_warehouse_selling_price_profif_ratio($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

	/**
	 * warehouse the fractional part
	 * @return boolean 
	 */
	public function warehouse_the_fractional_part(){
		$data = $this->request->getPost();
		if($data != 'null'){
			$value = $this->warehouse_model->update_warehouse_the_fractional_part($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}
	
	/**
	 * warehouse integer part
	 * @return boolean 
	 */
	public function warehouse_integer_part(){
		$data = $this->request->getPost();
		if($data != 'null'){
			$value = $this->warehouse_model->update_warehouse_integer_part($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

	/**
	 * warehouse profit rate by purchase price sale
	 * @return boolean 
	 */
	public function warehouse_profit_rate_by_purchase_price_sale(){
		$data = $this->request->getPost();

		if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
			$success = false;
			$message = _l('Not permission edit');

			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}

		if($data != 'null'){
			$value = $this->warehouse_model->update_profit_rate_by_purchase_price_sale($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

	/**
	 * setting rules for rounding prices
	 * @return boolean 
	 */
	public function setting_rules_for_rounding_prices(){
		$data = $this->request->getPost();

		if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
			$success = false;
			$message = _l('Not permission edit');

			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}

		if($data != 'null'){
			$value = $this->warehouse_model->update_rules_for_rounding_prices($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

	/**
	 * caculator sale price
	 * @return float 
	 */
	public function caculator_sale_price()
	{
		$data = $this->request->getPost();
		$sale_price = 0;

		/*type : 0 purchase price, 1: sale price*/
		$profit_type = get_setting('profit_rate_by_purchase_price_sale');
		$the_fractional_part = get_setting('warehouse_the_fractional_part');
		$integer_part = get_setting('warehouse_integer_part');

		$profit_rate = $data['profit_rate'];
		$purchase_price = $data['purchase_price'];

		switch ($profit_type) {
			case '0':
				# Calculate the selling price based on the purchase price rate of profit
				# sale price = purchase price * ( 1 + profit rate)
			if( ($profit_rate =='') || ($profit_rate == '0')|| ($profit_rate == 'null') ){

				$sale_price = (float)$purchase_price;
			}else{
				$sale_price = (float)$purchase_price*(1+((float)$profit_rate/100));

			}
			break;

			case '1':
				# Calculate the selling price based on the selling price rate of profit
				# sale price = purchase price / ( 1 - profit rate)
			if( ($profit_rate =='') || ($profit_rate == '0')|| ($profit_rate == 'null') ){

				$sale_price = (float)$purchase_price;
			}else{
				$sale_price = (float)$purchase_price/(1-((float)$profit_rate/100));

			}
			break;
			
		}

		//round sale_price
		$sale_price = round($sale_price, (int)$the_fractional_part);

		if($integer_part != '0'){
			$integer_part = 0 - (int)($integer_part);
			$sale_price = round($sale_price, $integer_part);
		}

		echo json_encode([
			'sale_price' => $sale_price,
		]);
		die;

	}

	/**
	 * table inventory inside
	 *
	 * @return array
	 */
	public function table_inventory_inside() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'reports/inventory_analytics/table_inventory_inside'), $dataPost);
	}
	
	 /**
	 * { purchase order setting }
	 * @return  json
	 */
	 public function auto_create_goods_received_delivery_setting(){
		$data = $this->request->getPost();

		if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
			$success = false;
			$message = _l('Not permission edit');

			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}

		if($data != 'null'){
			$value = $this->warehouse_model->update_auto_create_received_delivery_setting($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	 }


	/**
	 * update goods receipt warehouse
	 * @return json 
	 */
	public function update_goods_receipt_warehouse(){
		$data = $this->request->getPost();

		if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
			$success = false;
			$message = _l('Not permission edit');

			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}

		if($data != 'null'){
			$value = $this->warehouse_model->update_goods_receipt_warehouse($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}


	/**
	 * coppy invoices
	 * @param  integer $invoice_id 
	 * @return json              
	 */
	public function copy_invoices($invoice_id = '') {

		$invoices_detail = $this->warehouse_model->copy_invoice($invoice_id);
		if($invoice_id != ''){
			$invoice_no = format_invoice_number($invoice_id);
		}else{
			$invoice_no = '';
		}
		echo json_encode([

			'result' => $invoices_detail['goods_delivery_detail'],
			'goods_delivery' => $invoices_detail['goods_delivery'],
			'status' => $invoices_detail['status'],
			'invoice_no' => $invoice_no,
		]);
	}

	/**
	 * caculator purchase price
	 * @return json 
	 */
	public function caculator_profit_rate()
	{
		$data = $this->request->getPost();
		$profit_rate = 0;

		/*type : 0 purchase price, 1: sale price*/
		$profit_type = get_setting('profit_rate_by_purchase_price_sale');
		$the_fractional_part = get_setting('warehouse_the_fractional_part');
		$integer_part = get_setting('warehouse_integer_part');

		$purchase_price = $data['purchase_price'];
		$sale_price = $data['sale_price'];


		switch ($profit_type) {
			case '0':
				# Calculate the selling price based on the purchase price rate of profit
				# sale price = purchase price * ( 1 + profit rate)

			if( ($purchase_price =='') || ($purchase_price == '0')|| ($purchase_price == 'null') ){
				$profit_rate = 0;

			}else{
				$profit_rate = (((float)$sale_price/(float)$purchase_price)-1)*100;

			}
			break;

			case '1':
				# Calculate the selling price based on the selling price rate of profit
				# sale price = purchase price / ( 1 - profit rate)

			$profit_rate = (1-((float)$purchase_price/(float)$sale_price))*100;

			break;

		}


		echo json_encode([
			'profit_rate' => $profit_rate,
		]);
		die;

	}

	/**
	 * warehouse delete bulk action
	 * @return
	 */
	public function warehouse_export_item_checked()
	{
		$this->access_only_team_members();
		$user_id = $this->login_user->id;

		if(!class_exists('XLSXReader_fin')){
			require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXReader/XLSXReader.php');
		}
		require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXWriter/xlsxwriter.class.php');

		if ($this->request->getPost()) {

			/*delete export file before export file*/
			$path_before = COMMODITY_EXPORT.'export_excel_'.$user_id.'.xlsx';
			if(file_exists($path_before)){
				unlink(COMMODITY_EXPORT.'export_excel_'.$user_id.'.xlsx');
			}

			$ids                   = $this->request->getPost('ids');

			//Writer file
			$writer_header = array(
				"(*)" ._l('commodity_code')          =>'string',
				"(*)" ._l('commodity_name')          =>'string',
				_l('commodity_barcode')          =>'string',
				_l('sku_code')          =>'string',
				_l('sku_name')          =>'string',

				_l('description')          =>'string',
				_l('commodity_type')          =>'string',
				_l('unit_id')          =>'string',
				"(*)" ._l('category_id')          =>'string',

				_l('_profit_rate'). "(%)"          =>'string',
				_l('purchase_price')          =>'string',
				"(*)" ._l('rate')          =>'string',
				_l('tax')          =>'string',
				_l('origin')          =>'string',
				_l('style_id')          =>'string',
				_l('model_id')          =>'string',
				_l('size_id')          =>'string',
				_l('_color')          =>'string',
				_l('guarantee_month')          =>'string',
				_l('minimum_inventory')          =>'string',
			);

			$widths_arr = array();
			for($i = 1; $i <= count($writer_header); $i++ ){
				$widths_arr[] = 40;
			}

			$writer = new \XLSXWriter();

			$col_style1 =[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
			$style1 = ['widths'=> $widths_arr, 'fill' => '#ff9800',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ];

			$writer->writeSheetHeader_v2('Inventory Items Import Excel', $writer_header,  $col_options = ['widths'=> $widths_arr, 'fill' => '#f44336',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ], $col_style1, $style1);


			// Add some data
			$x= 2;
			if(isset($ids)){
				if(count($ids) > 0){
					foreach ($ids as $value) {
						$inventory_min=0;

						$item = $this->warehouse_model->get_commodity($value);

						/*get inventory min*/
						$builder = db_connect('default');
						$builder = $builder->table(get_db_prefix().'inventory_commodity_min');
						$builder->where('commodity_id', $value);
						$inventory_value = $builder->get()->getRow();
						if($inventory_value){
							$inventory_min =  $inventory_value->inventory_number_min;
						}


						if($item){
							$writer->writeSheetRow('Inventory Items Import Excel', [
								$item->commodity_code,
								$item->title,
								$item->commodity_barcode,
								$item->sku_code,
								$item->sku_name,

								$item->description,
								$item->commodity_type,
								$item->unit_id,
								$item->category_id,
								$item->profif_ratio,
								$item->purchase_price,
								$item->rate,
								$item->tax,
								$item->origin,
								$item->style_id,
								$item->model_id,
								$item->size_id,
								$item->color,
								$item->guarantee,
								$inventory_min,
							]);
						}
					}

				}

			}

			// Rename worksheet

			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="inventory_items_sheet.xlsx"');
			header('Cache-Control: max-age=0');

			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$filename = 'export_excel_'.$user_id.strtotime(date('Y-m-d H:i:s')).'.xlsx';
			$writer->writeToFile(str_replace($filename, WAREHOUSE_EXPORT_ITEM.$filename, $filename));

			echo json_encode(['success' => true,
				'filename' => WAREHOUSE_EXPORT_ITEM.$filename,
				'base_url'          => base_url(),
			]);

			exit;
		}
	}

	/**
	 * get list job position training
	 * @param  integer $id 
	 * @return json     
	 */
	public function get_item_longdescriptions($id){
		$variation_html = $this->warehouse_model->get_variation_html($id);
		$list = $this->warehouse_model->get_item_longdescriptions($id);

		$custom_fields_html = render_custom_fields('items', $id, [], ['items_pr' => true]);
		$item_tags = $this->warehouse_model->get_list_item_tags($id);

		if((get_tags_in($id,'item_tags') != null)){
			$item_value = implode(',', get_tags_in($id,'item_tags')) ;
		}else{

			$item_value = '';
		}

		if(isset($list)){
			$long_descriptions = $list->long_descriptions;
			$description = $list->long_description;
		}else{
			$long_descriptions = '';
			$description = '';

		}

		//check have child item
		$flag_is_parent = false;    	
		$this->db->where('parent_id', $id);
		$array_child_value = $this->db->get(get_db_prefix().'items')->getResultArray();

		if(count($array_child_value) > 0){
			$flag_is_parent = true;
		}

		$this->db->where('id', $id);
		$item_value = $this->db->get(get_db_prefix().'items')->row();

		if($item_value){
			$parent_id = $item_value->parent_id;
		}else{
			$parent_id = '';
		}

		$data['ajaxItems'] = false;
		if (total_rows(get_db_prefix() . 'items', 'parent_id is null or parent_id = ""') <= ajax_on_total_items()) {
			if(is_numeric($parent_id) && $parent_id != 0 ){
				$data['items'] = $this->warehouse_model->get_parent_item_grouped($parent_id);
			}else{
				$data['items'] = $this->warehouse_model->get_parent_item_grouped();
			}
		} else {
			if(is_numeric($parent_id) && $parent_id != 0 ){
				$data['items']     = $this->warehouse_model->get_parent_item_grouped($parent_id);
			}else{
				$data['items']     = [];
				$data['ajaxItems'] = true;
			}
		}

		$parent_data = $this->load->view('item_include/item_select', ['ajaxItems' => $data['ajaxItems'], 'items' => $data['items'] , 'select_name' => 'parent_id', 'id_name' => 'parent_id', 'data_none_selected_text' => '', 'label_name' => 'parent_item', 'item_id' => $parent_id ], true);

		echo json_encode([ 
			'long_descriptions' => $long_descriptions,
			'description' => $description,
			'custom_fields_html' => $custom_fields_html,
			'item_tags' => $item_tags['htmltag'],
			'item_value' => $item_value,
			'variation_html' => $variation_html['html'],
			'variation_index' => $variation_html['index'],
			'item_html' => $parent_data,
			'flag_is_parent' => $flag_is_parent,

		]);
	}


	/**
	 * revert goods receipt
	 * @param  integer $id 
	 * @return redirect        
	 */
	public function revert_goods_receipt($id)
	{	
		$response = $this->warehouse_model->revert_goods_receipt($id);

		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect("warehouse/manage_purchase");
	}

	/**
	 * revert goods delivery
	 * @param  integer $id 
	 * @return redirect    
	 */
	public function revert_goods_delivery($id)
	{	
		$response = $this->warehouse_model->revert_goods_delivery($id);

		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect("warehouse/manage_delivery");

	}

	/**
	 * import xlsx opening stock
	 * @param  integer $id
	 * @return view
	 */
	public function import_opening_stock() {
		if (!is_admin() && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}
		
		$user_id = $this->login_user->id;

		$_personal_language = get_setting('user_' . $user_id . '_personal_language');
		if(strlen($_personal_language) == 0){
			$_personal_language = get_setting("language");
		}

		$data['active_language'] = $_personal_language;
		$data['title'] = _l('import_opening_stock');
		$data['site_url'] = base_url();

		return $this->template->rander("Warehouse\Views\items\import_excel_opening_stock", $data);
	}


	/**
	 * import file xlsx opening stock
	 * @return json 
	 */
	public function import_file_xlsx_opening_stock() {
		if (!is_admin() && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}

		$user_id = $this->login_user->id;

		if(!class_exists('XLSXReader_fin')){
			require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXReader/XLSXReader.php');
		}
		require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXWriter/xlsxwriter.class.php');

		$total_row_false = 0;
		$total_rows_data = 0;
		$dataerror = 0;
		$total_row_success = 0;
		$total_rows_data_error = 0;
		$filename='';

		if ($this->request->getPost()) {

			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
					$temp_file_path = get_setting("temp_file_path");
					$tmpDir = getcwd() . '/' . $temp_file_path;
					if (!is_dir($tmpDir)) {
						if (!mkdir($tmpDir, 0777, true)) {
							die('Failed to create file folders.');
						}
					}

					// Setup our new file path
					$newFilePath = $tmpDir . $_FILES['file_csv']['name'];

					if (move_uploaded_file($tmpFilePath, $newFilePath)) {
						$import_result = true;
						$rows = [];

						//Writer file
						$writer_header = array(
							"(*)" ._l('commodity_code')          =>'string',
							"(*)" ._l('warehouse_code')          =>'string',
							_l('lot_number')          =>'string',
							_l('expiry_date').'(yyyy-mm-dd)'          =>'string',
							"(*)" ._l('inventory_number')          =>'string',
							_l('error')                     =>'string',
						);

						$widths_arr = array();
						for($i = 1; $i <= count($writer_header); $i++ ){
							$widths_arr[] = 40;
						}

						$writer = new \XLSXWriter();

						$col_style1 =[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
						$style1 = ['widths'=> $widths_arr, 'fill' => '#ff9800',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ];

						$writer->writeSheetHeader_v2('Sheet1', $writer_header,  $col_options = ['widths'=> $widths_arr, 'fill' => '#f44336',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ], $col_style1, $style1);

						//init file error end

						//Reader file
						$xlsx = new \XLSXReader_fin($newFilePath);
						$sheetNames = $xlsx->getSheetNames();
						$data = $xlsx->getSheetData($sheetNames[1]);

						// start row write 2
						$numRow = 2;
						$total_rows = 0;

						$total_rows_actualy = 0;
						
						//get data for compare

						for ($row = 1; $row < count($data); $row++) {
								$rd = array();
								$flag = 0;
								$flag2 = 0;
								$flag_mail = 0;
								$string_error = '';
								$flag_contract_form = 0;

								$flag_id_commodity_code;
								$flag_id_warehouse_code;

								$value_cell_commodity_code = isset($data[$row][0]) ? $data[$row][0] : null ;
								$value_cell_warehouse_code = isset($data[$row][1]) ? $data[$row][1] : null ;
								$value_cell_lot_number = isset($data[$row][2]) ? $data[$row][2] : '' ;
								$value_cell_expiry_date = isset($data[$row][3]) ? $data[$row][3] : '' ;
								$value_cell_inventory_number = isset($data[$row][4]) ? $data[$row][4] : null ;

								$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';

								$reg_day = '#^(((1)[0-2]))(\/)\d{4}-(3)[0-1])(\/)(((0)[0-9])-[0-2][0-9]$#'; /*yyyy-mm-dd*/

								/*check null*/
								if (is_null($value_cell_commodity_code) == true) {
									$string_error .= _l('commodity_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_warehouse_code) == true) {
									$string_error .= _l('warehouse_code') . _l('not_yet_entered');
									$flag = 1;
								}

								if (is_null($value_cell_inventory_number) == true) {
									$string_error .= _l('inventory_number') . _l('not_yet_entered');
									$flag = 1;
								}
								

								//check commodity_code exist  (input: code or name item)
								if (is_null($value_cell_commodity_code) != true && $value_cell_commodity_code != '0' ) {
									/*case input  id*/
									$builder = db_connect('default');
									$builder = $builder->table(get_db_prefix().'items');
									$builder->where('commodity_code', trim($value_cell_commodity_code, " "));
									$builder->orWhere('description', trim($value_cell_commodity_code, " "));
									$item_value =  $builder->get()->getRow();

									if ($item_value) {
										/*get id commodity_type*/
										$flag_id_commodity_code = $item_value->id;
									} else {
										$string_error .= _l('commodity_code') . _l('does_not_exist');
										$flag2 = 1;
									}


								}

								//check warehouse exist  (input: id or name warehouse)
								if (is_null($value_cell_warehouse_code) != true && ( $value_cell_warehouse_code != '0')) {
									/*case input id*/
									$builder = db_connect('default');
									$builder = $builder->table(get_db_prefix().'warehouse');
									$builder->where('warehouse_code', trim($value_cell_warehouse_code, " "));
									$builder->orWhere('warehouse_name', trim($value_cell_warehouse_code, " "));
									$warehouse_value = $builder->get()->getRow();

									if ($warehouse_value) {
										/*get id unit_id*/
										$flag_id_warehouse_code = $warehouse_value->warehouse_id;

									} else {
										$string_error .= _l('_warehouse') . _l('does_not_exist');
										$flag2 = 1;
									}

								}

								if (is_null($value_cell_expiry_date) != true && $value_cell_expiry_date != '') {

									if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", trim($value_cell_expiry_date, " "))) {
										$test = true;

									} else {
										$flag2 = 1;
										$string_error .= _l('expiry_date') . _l('invalid');

									}
								}


								// check inventory number
								if (!is_numeric(trim($value_cell_inventory_number, " "))) {

									$string_error .=_l('inventory_number'). _l('_not_a_number');
									$flag2 = 1; 	

								} 


								

								if (($flag == 1) || ($flag2 == 1)) {
									//write error file
									$writer->writeSheetRow('Sheet1', [
										$value_cell_commodity_code,
										$value_cell_warehouse_code,
										$value_cell_lot_number,
										$value_cell_expiry_date,
										$value_cell_inventory_number,
										$string_error,
									]);

									$numRow++;
									$total_rows_data_error++;
								}

								if (($flag == 0) && ($flag2 == 0)) {

									/*staff id is HR_code, input is HR_CODE, insert => staffid*/
									$rd['commodity_code'] = $flag_id_commodity_code;
									$rd['warehouse_id'] = $flag_id_warehouse_code;
									$rd['lot_number'] 	  = isset($data[$row][2]) ? $data[$row][2] : '' ;

									$rd['expiry_date'] = (trim($value_cell_expiry_date, " "));
									if(isset($rd['expiry_date']) && $rd['expiry_date'] !=''){
										$rd['expiry_date'] = $rd['expiry_date'];
									}else{
										$rd['expiry_date'] = null;
									}

									$rd['quantities'] = isset($data[$row][4]) ? $data[$row][4] : '' ;
									$rd['date_manufacture'] = null;

								}

								if ($user_id != '' && $flag == 0 && $flag2 == 0) {
									$rows[] = $rd;
									$result_value = $this->warehouse_model->add_inventory_manage($rd, 1);
									if ($result_value) {
										//add transaction log
										$transaction_data=[];
										$purchase_price = $this->warehouse_model->get_purchase_price_from_commodity_code($rd['commodity_code']);
										$transaction_data['goods_receipt_id'] = 0;
										$transaction_data['purchase_price'] = (float)$purchase_price;
										$transaction_data['expiry_date'] = $rd['expiry_date'];
										$transaction_data['lot_number'] = $rd['lot_number'];
										/*get old quantity by item, warehouse*/
										$inventory_value = $this->warehouse_model->get_quantity_inventory($rd['warehouse_id'], $rd['commodity_code']);
										$old_quantity =  null;
										if($inventory_value){
											$old_quantity = $inventory_value->inventory_number;
										}

										$transaction_data['goods_id'] = 0;
										$transaction_data['old_quantity'] = (float)$old_quantity - (float)$rd['quantities'];
										$transaction_data['commodity_id'] = $rd['commodity_code'];
										$transaction_data['quantity'] = (float)$rd['quantities'];
										$transaction_data['date_add'] = date('Y-m-d H:i:s');
										$transaction_data['warehouse_id'] = $rd['warehouse_id'];
										$transaction_data['note'] = _l('import_opening_stock');
										$transaction_data['status'] = 1;
										
										$builder = db_connect('default');
										$builder = $builder->table(get_db_prefix().'goods_transaction_detail');
										$builder->insert($transaction_data);


										$total_rows_actualy++;
									}
								}

								$total_rows++;
								$total_rows_data++;

						}

						if ($total_rows_actualy != $total_rows) {
							$total_rows = $total_rows_actualy;
						}


						$total_rows = $total_rows;
						$data['total_rows_post'] = count($rows);
						$total_row_success = count($rows);
						$total_row_false = $total_rows - (int) count($rows);
						$message = 'Not enought rows for importing';

						if(($total_rows_data_error > 0) || ($total_row_false != 0)){

							$filename = 'FILE_ERROR_IMPORT_OPENING_STOCK' .$user_id.strtotime(date('Y-m-d H:i:s')). '.xlsx';
							$writer->writeToFile(str_replace($filename, WAREHOUSE_IMPORT_OPENING_STOCK.$filename, $filename));

							$filename = WAREHOUSE_IMPORT_OPENING_STOCK.$filename;


						}
						
						$import_result = true;
						delete_file_from_directory($newFilePath); //delete temp file
					}
					
				} else {
					set_alert('warning', _l('import_opening_stock_failed'));
				}
			}

		}
		echo json_encode([
			'message' =>'Not enought rows for importing',
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_rows_data_error,
			'total_rows' => $total_rows_data,
			'site_url' => base_url(),
			'staff_id' => $user_id,
			'total_rows_data_error' => $total_rows_data_error,
			'filename' => $filename,
		]);

	}

	/**
	 * unserializeForm
	 * @param  [type] $str 
	 * @return [type]      
	 */
	public	function unserializeForm($str) {
		$strArray = explode("&", $str);
		foreach($strArray as $item) {
			$array = explode("=", $item);
			$returndata[] = $array;
		}
		return $returndata;
	}

	/**
	 * delete item tags
	 * @param  integer $tag_id 
	 * @return [type]         
	 */
	public function delete_item_tags($tag_id){

		$result = $this->warehouse_model->delete_tag_item($tag_id);
		if($result == 'true'){
			$message = _l('deleted');
			$status = 'true';
		}else{
			$message = _l('problem_deleting');
			$status = 'fasle';
		}

		echo json_encode([ 
			'message' => $message,
			'status' => $status,
		]);
	}

	/**
	 * check warehouse onsubmit
	 *  
	 */
	public function check_warehouse_onsubmit() {
		$data = $this->request->getPost();
		$flag = 0;
		$message = true;

		if ($data['hot_delivery'] != 'null') {
			foreach ($data['hot_delivery'] as $delivery_value) {
				if ( $delivery_value[0] != '' ) {

					/*case select warehouse handsome table*/
					if($data['warehouse_id'] == ''){
						if ( $delivery_value[1] == '' ) {
							$flag = 1;
						}
					}
				}

			}
			if ($flag == 1) {
				$message = false;

			} else {
				$message = true;
			}
			echo json_encode([
				'message' => $message,

			]);
			die;
		}
	}

	/**
	 * view lost adjustment
	 * @param  integer $id 
	 * @return view
	 */
	public function view_lost_adjustment($id) {

		$data['loss_adjustment'] = $this->warehouse_model->get_loss_adjustment($id);

		if(!$data['loss_adjustment']){
			blank_page('Not Found', 'danger');
		}
		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");
		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {

			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 3);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 3);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 3);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 3);

		//get vaule render dropdown select

		$data['loss_adjustment_detail']= $this->warehouse_model->get_loss_adjustment_detailt_by_masterid($id);

		$data['title'] = _l('loss_adjustment');


		$check_appr = $this->warehouse_model->get_approve_setting('3');
		$data['check_appr'] = $check_appr;

		return $this->template->rander("Warehouse\Views\loss_adjustment\loss_adjustment_detail", $data);

	}


	/**
	 * check lost adjustment before save
	 * @return json 
	 */
	public function check_lost_adjustment_before_save() {
		$data = $this->request->getPost();

		$result = $this->warehouse_model->check_lost_adjustment_before_save($data);
		if($result['flag_check'] == 1){
			$success = false;
			$message = $result['str_error'];
		}else{
			$success = true;
			$message = $result['str_error'];

		}

		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}

	/**
	 * [inventory_setting
	 * @return redirect 
	 */
	public function inventory_setting()
	{
		$data = $this->request->getPost();
		if ($data) {
			$success = $this->warehouse_model->update_inventory_setting($data);

			if ($success == true) {
				$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
			}
			app_redirect("warehouse/inventory_settings");

			redirect(admin_url('warehouse/setting?group=inventory_setting'));
		}
	}

	/**
	 * manage internal delivery
	 * @param  string $id 
	 * @return view     
	 */
	public function manage_internal_delivery($id = '')
	{
		$data['internal_id'] = $id;
		$data['title'] = _l('internal_delivery_note');
		return $this->template->rander("Warehouse\Views\manage_internal_delivery\manage", $data);
	}


	/**
	 * table internal delivery
	 * @return table 
	 */
	public function table_internal_delivery()
	{
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'manage_internal_delivery/table_internal_delivery_note'), $dataPost);
	}


	/**
	 * add update internal delivery
	 * @param string $id 
	 */
	public function add_update_internal_delivery($id ='') {
		
		$user_id = $this->login_user->id;
		if ($this->request->getPost()) {

			$data = $this->request->getPost();
			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_internal_delivery($data);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("add_internal_delivery_note_false"));
				}
				app_redirect("warehouse/manage_internal_delivery");
			}else{
				$id = $data['id'];
				unset($data['id']);

				$mess = $this->warehouse_model->update_internal_delivery($data,$id);
				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("update_internal_delivery_note_false"));
				}
				app_redirect("warehouse/manage_internal_delivery");
			}

		}

		//get vaule render dropdown select
		$data['title'] = _l('internal_delivery_note');
		$data['internal_delivery_name_ex'] = 'INTERNAL_DELIVERY' . date('YmdHi');
		$data['goods_code'] = $this->warehouse_model->create_goods_delivery_code();
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staff'] = $this->Users_model->get_details($options)->getResultArray();

		$data['current_day'] = date('Y-m-d');
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('can_be_inventory');
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$warehouse_data = $this->warehouse_model->get_warehouse();
		//sample
		$internal_delivery_row_template = $this->warehouse_model->create_internal_delivery_row_template();

		if($id != ''){
			$internal_delivery = $this->warehouse_model->get_internal_delivery($id);
			if (!$internal_delivery) {
				blank_page('Internal delivery note Not Found', 'danger');
			}

			$internal_delivery_details = $this->warehouse_model->get_internal_delivery_detail($id);
			if (count($internal_delivery_details) > 0) {
				$index_internal_delivery = 0;
				foreach ($internal_delivery_details as $internal_delivery_detail) {
					$index_internal_delivery++;
					$unit_name = wh_get_unit_name($internal_delivery_detail['unit_id']);
					$commodity_name = $internal_delivery_detail['commodity_name'];
					
					if(strlen($commodity_name) == 0){
						$commodity_name = wh_get_item_variatiom($internal_delivery_detail['commodity_code']);
					}

					$internal_delivery_row_template .= $this->warehouse_model->create_internal_delivery_row_template($warehouse_data, 'items[' . $index_internal_delivery . ']', $commodity_name, $internal_delivery_detail['from_stock_name'],$internal_delivery_detail['to_stock_name'], $internal_delivery_detail['available_quantity'], $internal_delivery_detail['quantities'], $unit_name, $internal_delivery_detail['unit_price'], $internal_delivery_detail['commodity_code'], $internal_delivery_detail['unit_id'] , $internal_delivery_detail['into_money'],  $internal_delivery_detail['note'], $internal_delivery_detail['id'], true, $internal_delivery_detail['serial_number']);
				}
			}

			$data['internal_delivery'] = $internal_delivery;
		}
		$data['internal_delivery_row_template'] = $internal_delivery_row_template;
		return $this->template->rander("Warehouse\Views\manage_internal_delivery\add_internal_delivery", $data);
	}


	/**
	 * get quantity inventory
	 * @return [type] 
	 */
	public function get_quantity_inventory() {
		$data = $this->request->getPost();
		if ($data != 'null') {

			$value = $this->warehouse_model->get_quantity_inventory($data['warehouse_id'], $data['commodity_id']);

			$quantity = 0;
			if ($value != null) {
				$message = true;
				$quantity = get_object_vars($value)['inventory_number'];
			} else {
				$message = app_lang('Product_does_not_exist_in_stock');
			}
			
			echo json_encode([
				'message' => $message,
				'value' => $quantity,
			]);
			die;
		}
	}

	public function get_quantity_inventory_t() {
		$data = $this->request->getPost();
		if ($data != 'null') {

			$value = $this->warehouse_model->get_quantity_inventory($data['warehouse_id'], $data['commodity_id']);

			$quantity = 0;
			if ($value != null) {

				if ((float) get_object_vars($value)['inventory_number'] < (float) $data['quantity_export']) {
					$message = _l('not_enough_inventory');
					$quantity = get_object_vars($value)['inventory_number'];

				} else {
					$message = true;
					$quantity = get_object_vars($value)['inventory_number'];
				}

			} else {
				$message = _l('Product_does_not_exist_in_stock');
			}

			
			echo json_encode([
				'message' => $message,
				'value' => $quantity,
			]);
			die;
		}
	}


	/**
	 * delete internal delivery
	 * @param  interger $id 
	 * @return redirect    
	 */
	public function delete_internal_delivery() {
		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$id = $this->request->getPost('id');
		$response = $this->warehouse_model->delete_internal_delivery($id);
		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("wh_deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect('warehouse/manage_internal_delivery');

	}

	/**
	 * view internal delivery
	 * @param  integer $id 
	 * @return view     
	 */
	public function view_internal_delivery($id) {
		validate_numeric_value($id);
		
		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");
		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {

			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 4);

		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 4);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 4);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 4);

		$data['internal_delivery'] = $this->warehouse_model->get_internal_delivery($id);
		$data['internal_delivery_detail'] = $this->warehouse_model->get_internal_delivery_detail($id);

		$data['title'] = _l('internal_delivery_note');
		$check_appr = $this->warehouse_model->get_approve_setting('4');
		$data['check_appr'] = $check_appr;

		return $this->template->rander("Warehouse\Views\manage_internal_delivery\internal_delivery_detail", $data);
	}


	/**
	 * check internal delivery onsubmit
	 * 
	 * @return view     
	 */
	public function check_internal_delivery_onsubmit() {
		$data = $this->request->getPost();
		$flag = 0;
		$message = true;
		$str_error = '';

		if ($data['intenal_delivery'] != 'null') {
			foreach ($data['intenal_delivery'] as $intenal_delivery_value) {

				if ( $intenal_delivery_value[0] != '' ) {
					if($intenal_delivery_value[1] != ''){
						//check without checking warehouse
						$commodity_name='';
						$item_value = $this->warehouse_model->get_commodity($intenal_delivery_value['0']);

						if($item_value){
							$commodity_name .= $item_value->commodity_code.'_'.$item_value->description;
						}

						$value = $this->warehouse_model->get_quantity_inventory($intenal_delivery_value['1'], $intenal_delivery_value['0']);


						$quantity = 0;
						if ($value != null) {

							if ((float) get_object_vars($value)['inventory_number'] < (float) $intenal_delivery_value['5']) {
								$flag = 1;
								$str_error .= $commodity_name._l('not_enough_inventory').'<br/>';

							}

						} else {
							$flag = 1;
							$str_error .=$commodity_name. _l('Product_does_not_exist_in_stock').'<br/>';
						}

					}else{
						$flag = 1;
						$str_error .= _l('please_choose_from_stock_name').'<br/>';
					}

					if($intenal_delivery_value[2] == ''){
						$flag = 1;
						$str_error .= _l('please_choose_to_stock_name').'<br/>';
					}

					if($intenal_delivery_value[5] == '' || $intenal_delivery_value[5] == '0'){
						$flag = 1;
						$str_error .= _l('please_choose_quantity_export').'<br/>';
					}

				}

			}
			
			if ($flag == 1) {
				$message = false;

			} else {
				$message = true;
			}

			echo json_encode([
				'message' => $message,
				'str_error' => $str_error,

			]);
			die;
		}
	}

	/**
	 * check approval sign
	 * @return json 
	 */
	public function check_approval_sign() 
	{
		$data = $this->request->getPost();

		$success = true;
		$message = '';

		if($data['rel_type'] == '2'){
			/*check send request with type =2 , inventory delivery voucher*/
			$check_r = $this->warehouse_model->check_inventory_delivery_voucher($data);

			if($check_r['flag_export_warehouse'] == 1){
				$message = 'approval success';

			}else{
				$message = $check_r['str_error'];
				$success = false;

			}
		}elseif($data['rel_type'] == '4'){
			/*check send request with type = 4 , internal delivery note*/
			$check_r = $this->warehouse_model->check_internal_delivery_note_send_request($data);

			if($check_r['flag_internal_delivery_warehouse'] == 1){
				$message = 'approval success';

			}else{
				$message = $check_r['str_error'];
				$success = false;

			}

		}


		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}


	/**
	 * manage warehouse
	 * @param  string $id 
	 * @return [type]     
	 */
	public function warehouse_mange($id = '') {

		$data['title'] = _l('warehouse_manage');
		$data['warehouse_types'] = $this->warehouse_model->get_warehouse();

		$this->db->where('fieldto', 'warehouse_name');
		$data['wh_custom_fields_display'] = $this->db->get(get_db_prefix().'customfields')->getResultArray();


		$data['proposal_id'] = $id;

		$this->load->view('includes/warehouse', $data);
	}

	/**
	 * table warehouse name
	 *
	 * @return array
	 */
	public function table_warehouse_name() {
		$this->app->get_table_data(module_views_path('Warehouse', 'manage_warehouse/table_warehouse_name'));
	}


	/**
	 * warehouse setting
	 * @param  string $id 
	 * @return [type]     
	 */
	public function add_warehouse($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_one_warehouse($data);
				if ($mess) {
					set_alert('success', _l('added_successfully') .' '. _l('warehouse'));

				} else {
					set_alert('warning', _l('Add_warehouse_false'));
				}
				redirect(admin_url('warehouse/warehouse_mange'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->update_one_warehouse($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully') .' '. _l('warehouse'));
				} else {
					set_alert('warning', _l('updated_warehouse_false'));
				}

				redirect(admin_url('warehouse/warehouse_mange'));
			}
		}
	}


	/**
	 * get item by id ajax
	 * @param  integer $id 
	 * @return [type]     
	 */
	public function get_warehouse_by_id($id)
	{
		if ($this->input->is_ajax_request()) {

			$warehouse_value                     = $this->warehouse_model->get_warehouse($id);

			$warehouse_value->warehouse_code   	= $warehouse_value->warehouse_code;
			$warehouse_value->warehouse_name   	= $warehouse_value->warehouse_name;
			$warehouse_value->warehouse_address   = nl2br($warehouse_value->warehouse_address);
			$warehouse_value->note   = nl2br($warehouse_value->note);

			$warehouse_value->custom_fields      = [];

			$warehouse_value->custom_fields_html = wh_render_custom_fields('warehouse_name', $id, []);

			$cf = get_custom_fields('warehouse_name');

			foreach ($cf as $custom_field) {
				$val = get_custom_field_value($id, $custom_field['id'], 'warehouse_name');
				if ($custom_field['type'] == 'textarea') {
					$val = clear_textarea_breaks($val);
				}
				$custom_field['value'] = $val;
				$warehouse_value->custom_fields[] = $custom_field;
			}

			echo json_encode($warehouse_value);
		}
	}

	/**
	 * get warehouse custom fields html
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function get_warehouse_custom_fields_html($id)
	{
		if ($this->input->is_ajax_request()) {

			$warehouse_value =[];
			$warehouse_value['custom_fields_html'] = wh_render_custom_fields('warehouse_name', $id, []);

			echo json_encode($warehouse_value);
		}
	}


	/**
	 * view warehouse detail
	 * @param  integer $warehouse_id 
	 * @return view               
	 */
	public function view_warehouse_detail($warehouse_id) {
		$warehouse_item = get_warehouse_name($warehouse_id);

		if (!$warehouse_item) {
			blank_page('Warehouse Not Found', 'danger');
		}

		$data['warehouse_item'] = $warehouse_item;
		$data['warehouse_inventory'] = $this->warehouse_model->get_inventory_by_warehouse($warehouse_id);

		$this->load->view('manage_warehouse/warehouse_view_detail', $data);

	}

	/**
	 * goods delivery copy pur order
	 * @param  integer $pur request
	 * @return json encode
	 */
	public function goods_delivery_copy_pur_order($pur_order = '') {

		$pur_request_detail = $this->warehouse_model->goods_delivery_get_pur_order($pur_order);

		echo json_encode([
			'result' => $pur_request_detail['result'] ? $pur_request_detail['result'] : '',
			'additional_discount' => $pur_request_detail['additional_discount'] ? $pur_request_detail['additional_discount'] : '',
		]);
	}

	 /**
	 * Uploads a proposal attachment.
	 *
	 * @param      string  $id  The purchase order
	 * @return redirect
	 */
	 public function wh_proposal_attachment($id){

		wh_handle_propsal_file($id);

		redirect(admin_url('proposals/list_proposals/'.$id));
	 }

	/**
	 * { preview obgy partograph file }
	 *
	 * @param      <type>  $id      The identifier
	 * @param      <type>  $rel_id  The relative identifier
	 * @return  view
	 */
	public function file_proposal($id, $rel_id)
	{
		$data['discussion_user_profile_image_url'] = staff_profile_image_url(get_staff_user_id1());
		$data['current_user_is_admin']             = is_admin();
		$data['file'] = $this->warehouse_model->get_file($id, $rel_id);
		if (!$data['file']) {
			header('HTTP/1.0 404 Not Found');
			die;
		}

		$this->load->view('proposal/_file', $data);
	}

	/**
	 * { delete proposal attachment }
	 *
	 * @param      <type>  $id     The identifier
	 */
	public function delete_proposal_attachment($id)
	{
		$this->load->model('misc_model');
		$file = $this->misc_model->get_file($id);
		if ($file->staffid == get_staff_user_id1() || is_admin()) {
			echo html_entity_decode($this->warehouse_model->delete_wh_proposal_attachment($id));
		} else {
			header('HTTP/1.0 400 Bad error');
			echo _l('access_denied');
			die;
		}
	}

	/**
	 * brands setting
	 * @param  string $id 
	 * @return [type]     
	 */
	public function brands_setting($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_brand($data);
				if ($mess) {
					set_alert('success', _l('added_successfully'));

				} else {
					set_alert('warning', _l('Add_brand_name_false'));
				}
				redirect(admin_url('warehouse/setting?group=brand'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->update_brand($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully'));
				} else {
					set_alert('warning', _l('updated_brand_name_false'));
				}

				redirect(admin_url('warehouse/setting?group=brand'));
			}
		}
	}

	/**
	 * [delete_color
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_brand($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=brand'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_brand($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=brand'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=brand'));
		}

	}

		/**
	 * brands setting
	 * @param  string $id 
	 * @return [type]     
	 */
		public function models_setting($id = '') {
			if ($this->request->getPost()) {
				$message = '';
				$data = $this->request->getPost();

				if (!$this->request->getPost('id')) {

					$mess = $this->warehouse_model->add_model($data);
					if ($mess) {
						set_alert('success', _l('added_successfully'));

					} else {
						set_alert('warning', _l('Add_model_name_false'));
					}
					redirect(admin_url('warehouse/setting?group=model'));

				} else {
					$id = $data['id'];
					unset($data['id']);
					$success = $this->warehouse_model->update_model($data, $id);
					if ($success) {
						set_alert('success', _l('updated_successfully'));
					} else {
						set_alert('warning', _l('updated_model_name_false'));
					}

					redirect(admin_url('warehouse/setting?group=model'));
				}
			}
		}

	/**
	 * [delete_color
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_model($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=model'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_model($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=model'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=model'));
		}

	}

	public function custom_fields_setting($id = '') {
		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();

			if (!$this->request->getPost('id')) {

				$mess = $this->warehouse_model->add_custom_fields_warehouse($data);
				if ($mess) {
					set_alert('success', _l('added_successfully'));

				} else {
					set_alert('warning', _l('Add_commodity_type_false'));
				}
				redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));

			} else {
				$id = $data['id'];
				unset($data['id']);
				$success = $this->warehouse_model->update_custom_fields_warehouse($data, $id);
				if ($success) {
					set_alert('success', _l('updated_successfully'));
				} else {
					set_alert('warning', _l('updated_commodity_type_false'));
				}

				redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
			}
		}
	}

	/**
	 * [delete_color description]
	 * @param  [type] $id  
	 * @return [type]      
	 */
	public function delete_custom_fields_warehouse($id) {
		if (!$id) {
			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
		}

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$response = $this->warehouse_model->delete_custom_fields_warehouse($id);
		if ($response) {
			set_alert('success', _l('deleted'));
			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
		} else {
			set_alert('warning', _l('problem_deleting'));
			redirect(admin_url('warehouse/setting?group=warehouse_custom_fields'));
		}

	}


	/**
	 * check warehouse custom fields
	 * @param  [type] $id
	 * @return [type]    
	 */
	public function check_warehouse_custom_fields() {
		$data = $this->request->getPost();

		$success = $this->warehouse_model->check_warehouse_custom_fields($data);
		if($success){

			$message = _l('custom_fields');
		}else{
			$message = _l('custom_fields_have_been_created');
		}
		echo json_encode([
			'success' => $success,
			'message' => $message,
		]);
		die;
	}

	/**
	 * send goods delivery
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function get_delivery_ajax() {

		if(!has_permission('warehouse', '', 'create')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$id = $this->request->getPost('id');
		$data_result = $this->warehouse_model->delivery_note_get_data_send_mail($id);

		echo json_encode([
			'options' => $data_result['options'],
			'primary_email' => $data_result['primary_email'],
		]);
		die;

	}

	/**
	 * get primary contact
	 * @return [type] 
	 */
	public function get_primary_contact()
	{	
		$primary_email ='';

		$userid = $this->request->getPost('userid');

		$options = array(
			"client_id" => $userid,
			"is_primary_contact" => 1,
			"user_type" => "client",
		);
		$contact_value = $this->Users_model->get_details($options)->getRow();
		if($contact_value){
			$primary_email 	= $contact_value->email;
		}

		echo json_encode([
			'primary_email' => $primary_email,
		]);
		die;

	}

	/**
	 * send_goods_delivery
	 * @return [type] 
	 */
	public function send_goods_delivery(){
		if($this->request->getPost()){
			$data = $this->request->getPost();

			if(isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != ''){

				if(file_exists(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/send_delivery_note/'. $data['goods_delivery'])){
					$delete_old = delete_dir(WAREHOUSE_MODULE_UPLOAD_FOLDER .'/send_delivery_note/'. $data['goods_delivery']);
				}else{
					$delete_old = true;
				}

				if($delete_old == true){
					handle_send_delivery_note($data['goods_delivery']);
				}   
			}

			$send = $this->warehouse_model->send_delivery_note($data);
			if($send){
				set_alert('success',_l('send_delivery_note_by_email_successfully'));

			}else{
				set_alert('warning',_l('send_delivery_note_by_email_fail'));
			}
			redirect(admin_url('warehouse/manage_delivery/'.$data['goods_delivery']));

		}
	}


	/**
	 * check sku duplicate
	 * @return [type] 
	 */
	public function check_sku_duplicate()
	{
		$data = $this->request->getPost();
		$result = $this->warehouse_model->check_sku_duplicate($data);

		echo json_encode([
			'message' => $result
		]);
		die;	
	}

	/**
	 * stock internal delivery pdf
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function stock_internal_delivery_pdf($id) {
		if (!$id) {
			redirect(admin_url('warehouse/manage_goods_delivery/manage_delivery'));
		}

		$stock_export = $this->warehouse_model->get_stock_internal_delivery_pdf_html($id);

		try {
			$pdf = $this->warehouse_model->stock_internal_delivery_pdf($stock_export);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';
		ob_end_clean();

		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}

		$pdf->Output('goods_delivery_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);
	}


	/**
	 * item print barcode
	 * @return [type] 
	 */
	public function item_print_barcode()
	{
		$data = $this->request->getPost();

		$stock_export = $this->warehouse_model->get_print_barcode_pdf_html($data);

		try {
			$pdf = $this->warehouse_model->print_barcode_pdf($stock_export);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'I';
		ob_end_clean();

		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}


		$pdf->Output('print_barcode_'.strtotime(date('Y-m-d H:i:s')).'.pdf', $type);

	}

	/**
	 * save and send request send mail
	 * @return [type] 
	 */
	public function save_and_send_request_send_mail($data ='') {
		if ((isset($data)) && $data != '') {
			$this->warehouse_model->send_mail($data);

			$success = 'success';
			echo json_encode([
				'success' => $success,
			]);
		}
	}

	public function reset_datas() {
		$data = [];
		return $this->template->rander("Warehouse\Views\includes/reset_data", $data);
	}
	
	/**
	 * reset data
	 * @return [type] 
	 */
	public function reset_data()
	{

		if ( !is_admin()) {
			app_redirect("forbidden");
		}
		$builder = db_connect('default');

			$inventory_manage = $builder->table(get_db_prefix().'inventory_manage');
			//delete inventory_manage
			$inventory_manage->truncate();
			//delete goods_receipt
			
			$goods_receipt = $builder->table(get_db_prefix().'goods_receipt');
			$goods_receipt->truncate();
			//delete goods_receipt_detail
			
			$goods_receipt_detail = $builder->table(get_db_prefix().'goods_receipt_detail');
			$goods_receipt_detail->truncate();

			//delete goods_delivery
			$goods_delivery = $builder->table(get_db_prefix().'goods_delivery');
			$goods_delivery->truncate();
			//delete goods_delivery_detail
			$goods_delivery_detail = $builder->table(get_db_prefix().'goods_delivery_detail');
			$goods_delivery_detail->truncate();
			//delete goods_delivery_invoices_pr_orders
			$goods_delivery_invoices_pr_orders = $builder->table(get_db_prefix().'goods_delivery_invoices_pr_orders');
			$goods_delivery_invoices_pr_orders->truncate();
			//delete goods_transaction_detail
			$goods_transaction_detail = $builder->table(get_db_prefix().'goods_transaction_detail');
			$goods_transaction_detail->truncate();
			//delete internal_delivery_note
			$internal_delivery_note = $builder->table(get_db_prefix().'internal_delivery_note');
			$internal_delivery_note->truncate();
			//delete internal_delivery_note_detail
			$internal_delivery_note_detail = $builder->table(get_db_prefix().'internal_delivery_note_detail');
			$internal_delivery_note_detail->truncate();
			//delete wh_loss_adjustment
			$wh_loss_adjustment = $builder->table(get_db_prefix().'wh_loss_adjustment');
			$wh_loss_adjustment->truncate();
			//delete wh_loss_adjustment_detail
			$wh_loss_adjustment_detail = $builder->table(get_db_prefix().'wh_loss_adjustment_detail');
			$wh_loss_adjustment_detail->truncate();
			//delete wh_approval_details
			$wh_approval_details = $builder->table(get_db_prefix().'wh_approval_details');
			$wh_approval_details->truncate();
			//delete wh_activity_log
			$wh_activity_log = $builder->table(get_db_prefix().'wh_activity_log');
			$wh_activity_log->truncate();
			//delete wh_inventory_serial_numbers
			$wh_inventory_serial_numbers = $builder->table(get_db_prefix().'wh_inventory_serial_numbers');
			$wh_inventory_serial_numbers->truncate();
			//delete wh_omni_shipments
			$wh_omni_shipments = $builder->table(get_db_prefix().'wh_omni_shipments');
			$wh_omni_shipments->truncate();
			//delete wh_packing_lists
			$wh_packing_lists = $builder->table(get_db_prefix().'wh_packing_lists');
			$wh_packing_lists->truncate();
			//delete wh_packing_list_details
			$wh_packing_list_details = $builder->table(get_db_prefix().'wh_packing_list_details');
			$wh_packing_list_details->truncate();
			//delete wh_goods_delivery_activity_log
			$wh_goods_delivery_activity_log = $builder->table(get_db_prefix().'wh_goods_delivery_activity_log');
			$wh_goods_delivery_activity_log->truncate();

			$wh_order_returns = $builder->table(get_db_prefix().'wh_order_returns');
			$wh_order_returns->where('rel_type', 'manual');
			$wh_order_returns->groupStart();
			$wh_order_returns->where('receipt_delivery_type', 'inventory_receipt_voucher_returned_goods');
			$wh_order_returns->orwhere('receipt_delivery_type', 'inventory_delivery_voucher_returned_purchasing_goods');
			$wh_order_returns->groupEnd();
			$wh_order_returns->delete();


			//delete sub folder STOCK_EXPORT
			foreach(glob(WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

				if(is_dir($file)) {
					delete_dir(WAREHOUSE_STOCK_EXPORT_MODULE_UPLOAD_FOLDER.$filename);
				}
			}

			//delete sub folder STOCK_IMPORT
			foreach(glob(WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

				if(is_dir($file)) {
					delete_dir(WAREHOUSE_STOCK_IMPORT_MODULE_UPLOAD_FOLDER.$filename);
				}
			}

			//delete sub folder LOSS
			foreach(glob(WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

				if(is_dir($file)) {
					delete_dir(WAREHOUSE_LOST_ADJUSTMENT_MODULE_UPLOAD_FOLDER.$filename);
				}
			}
			
			//delete sub folder INTERNAL
			foreach(glob(WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

				if(is_dir($file)) {
					delete_dir(WAREHOUSE_INTERNAL_DELIVERY_MODULE_UPLOAD_FOLDER.$filename);
				}
			}
			
			//delete sub folder send delivery note
			foreach(glob('modules/warehouse/uploads/send_delivery_note/' . '*') as $file) { 
				$file_arr = explode("/",$file);
				$filename = array_pop($file_arr);

				if(is_dir($file)) {
					delete_dir('modules/warehouse/uploads/send_delivery_note/'.$filename);
				}
			}
			
			echo json_encode(array("success" => true, "message" => app_lang('reset_data_successful')));
		}

	/**
	 * get variation html add
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function get_variation_html_add(){
		$variation_html = $this->warehouse_model->get_variation_html('');

		$data['ajaxItems'] = false;
		if (total_rows(get_db_prefix() . 'items', 'parent_id is null or parent_id = ""') <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->get_parent_item_grouped();
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}

		$parent_data = $this->load->view('item_include/item_select', ['ajaxItems' => $data['ajaxItems'], 'items' => $data['items'] , 'select_name' => 'parent_id', 'id_name' => 'parent_id', 'data_none_selected_text' => '', 'label_name' => 'parent_item'], true);

		echo json_encode([ 
			'variation_html' => $variation_html['html'],
			'variation_index' => $variation_html['index'],
			'item_html' => $parent_data,

		]);
	}

	/**
	 * get variation from parent item
	 * @return [type] 
	 */
	public function get_variation_from_parent_item()
	{
		$data = $this->request->getPost();
		$variation_html = $this->warehouse_model->get_variation_from_parent_item($data);

		$parent_value = '';
		$custom_fields_html = '';
		
		if($data['item_id'] == '' && $data['parent_id'] != ''){
			$parent_value = $this->warehouse_model->get_commodity($data['parent_id']);
		}

		echo json_encode([ 
			'variation_html' => $variation_html['html'],
			'variation_index' => $variation_html['index'],
			'check_is_parent' => $variation_html['check_is_parent'],
			'parent_value' => $parent_value,

		]);
	}


	/**
	 * update unchecked inventory numbers
	 * @return [type] 
	 */
	public function update_unchecked_inventory_numbers()
	{
		if ( !is_admin()) {
			app_redirect("forbidden");
		}

		$data = array(
			'without_checking_warehouse' => 0
		);
		$builder = db_connect('default');
		$builder = $builder->table(get_db_prefix().'items');
		$builder->where('id != ', 0);
		$builder->update($data); 

		$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
		app_redirect('warehouse/general');
	}

	/**
	 * maximum minimum inventory filter
	 * @param  [type] $data 
	 * @return [type]       
	 */
	public function maximum_minimum_inventory_filter()
	{
		$data = $this->request->getPost();

		if(strlen($data['inventory_filter']) > 0){
			$sql = "SELECT *, im.id as inventory_min_id FROM ".get_db_prefix()."inventory_commodity_min as im
			left join ".get_db_prefix()."items as i on im.commodity_id = i.id 
			where  i.commodity_code like  '%".$data['inventory_filter']."%'  OR  i.description like  '%".$data['inventory_filter']."%'  OR i.sku_code like  '%".$data['inventory_filter']."%'  
			";
		}else{
			$sql = "SELECT *, im.id as inventory_min_id FROM ".get_db_prefix()."inventory_commodity_min as im
			left join ".get_db_prefix()."items as i on im.commodity_id = i.id  
			";
		}

		$items = $this->warehouse_model->warehouse_run_query($sql);

		$data_filter=[];
		foreach ($items as $key => $value) {
			array_push($data_filter, [
				'id' => $value['inventory_min_id'],
				'commodity_id' => $value['commodity_id'],
				'commodity_code' => $value['commodity_code'],
				'commodity_name' => $value['title'],
				'inventory_number_min' => $value['inventory_number_min'],
				'inventory_number_max' => $value['inventory_number_max'],
				'sku_code' => $value['sku_code'],
			]);
		}

		echo json_encode([ 
			'data_object' => $data_filter,
		]);
	}

	/**
	 * { warehouse setting }
	 * @return  json
	 */
	public function show_item_cf_on_pdf(){
		$data = $this->request->getPost();
		if($data != 'null'){
			$value = $this->warehouse_model->update_pc_options_setting($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

	/*ADD opening stock*/
	/**
	 * add opening stock modal
	 */
	public function add_opening_stock_modal()
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		$id = $this->request->getPost('id');

		$data=[];
		


		$item_name='';
		$item = $this->warehouse_model->get_commodity($id);
		if($item){
			$item_name = $item->description;
		}

		$data['title'] = _l('add_opening_stock').' ( '.$item_name.' )';
		$data['item_name'] =  $item_name;
		$data['opening_stock_data'] = $this->warehouse_model->get_inventory_quantity_by_warehouse_variant($id);
		$data['min_row'] =  count($data['opening_stock_data']);
		$data['commodity_code_name'] = $this->warehouse_model->get_commodity_code_name();
		$data['units_warehouse_name'] = $this->warehouse_model->get_warehouse_code_name();
		
		$this->load->view('item_add_opening_stock', $data);
	}

	/**
	 * add opening stock
	 */
	public function add_opening_stock()
	{
		if ($this->request->getPost()) {
			$data = $this->request->getPost();

			$result = $this->warehouse_model->add_opening_stock($data);
			if ($result) {
				set_alert('success', _l('updated_successfully'));
			}

			redirect(admin_url('warehouse/commodity_list'));
		}

	}

	/**
	 * add activity
	 */
	public function wh_add_activity()
	{
		$goods_delivery_id = $this->request->getPost('goods_delivery_id');
		if (!has_permission('warehouse', '', 'edit') && !is_admin() && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}

		if ($this->request->getPost()) {
			$description = $this->request->getPost('activity');
			$rel_type = $this->request->getPost('rel_type');
			$aId     = $this->warehouse_model->log_wh_activity($goods_delivery_id, $rel_type, $description);

			$activity_log_html = '';
			$activity_log_html .='<div class="feed-item">
			<div class="date">
			<span class="text-has-action" data-toggle="tooltip" data-title="'.format_to_datetime(get_my_local_time("Y-m-d H:i:s"), false).'">
			'.format_to_datetime(get_my_local_time("Y-m-d H:i:s"), false).'															</span>
			<a href="#" class="pull-right text-danger" onclick="delete_wh_activitylog(this,6);return false;"><i class="fa fa fa-times"></i></a>
			</div>
			<div class="text">'.get_staff_full_name1().' - '.$description.'</div>
			</div>';
			
			if($aId){
				$status = true;
				$message = _l('added_successfully');
			}else{
				$status = false;
				$message = _l('added_failed');
			}

			echo json_encode([
				'status' => $status,
				'message' => $message,
				'activity_log_html' => $activity_log_html,
			]);
		}
	}

	/**
	 * delete activitylog
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_activitylog($id)
	{
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
		
		$delete = $this->warehouse_model->delete_activitylog($id);
		if($delete){
			$status = true;
		}else{
			$status = false;
		}

		echo json_encode([
			'success' => $status,
		]);
	}

	/**
	 * copy product image
	 * @param  [type] $id       
	 * @param  [type] $rel_type 
	 * @return [type]           
	 */
	public function copy_product_image($id)
	{

		$this->warehouse_model->copy_product_image($id);
		
		$url = admin_url('warehouse/commodity_list');

		echo json_encode([
			'url' => $url,
		]);
	}

	/**
	 * delete product attachment
	 * @param  [type] $attachment_id 
	 * @param  [type] $rel_type      
	 * @return [type]                
	 */
	public function delete_product_attachment($attachment_id, $rel_type)
	{
		if (!has_permission('warehouse', '', 'delete') && !is_admin()) {
			app_redirect("forbidden");
		}

		$folder_name = '';

		switch ($rel_type) {
			case 'manufacturing':
				$folder_name = module_dir_path('manufacturing', 'uploads/products/');
				break;
			case 'warehouse':
				$folder_name = module_dir_path('warehouse', 'uploads/item_img/');
				break;
			case 'purchase':
				$folder_name = module_dir_path('purchase', 'uploads/item_img/');
				break;
		}

		echo json_encode([
			'success' => $this->warehouse_model->delete_attachment_file($attachment_id, $folder_name),
		]);
	}

	/**
	 * caculator purchase price
	 * @return [type] 
	 */
	public function caculator_purchase_price()
	{
		$data = $this->request->getPost();

		$purchase_price = $this->warehouse_model->caculator_purchase_price_model($data['profit_rate'], $data['sale_price']);

		echo json_encode([
			'purchase_price' => $purchase_price,
		]);
		die;

	}

	/**
	 * wh parent item search
	 * @return [type] 
	 */
	public function wh_parent_item_search()
	{
		if ($this->request->getPost() && $this->input->is_ajax_request()) {
			echo json_encode($this->warehouse_model->wh_parent_item_search($this->request->getPost('q')));
		}
	}

	/**
	 * wh commodity code search
	 * @return [type] 
	 */
	public function wh_commodity_code_search($type = 'purchase_price', $can_be = 'can_be_inventory')
	{
		if ($this->request->getPost() && $this->input->is_ajax_request()) {
			echo json_encode($this->warehouse_model->wh_commodity_code_search($this->request->getPost('q'), $type, $can_be));
		}
	}

	/* Get item by id / ajax */
	public function get_item_by_id($id, $get_warehouse = false, $warehouse_id = false)
	{
			$item                     = $this->warehouse_model->get_item_v2($id);
			$item->description   = nl2br($item->description);
			$guarantee_new = '';
			if(($item->guarantee != '') && (($item->guarantee != null))){
				$guarantee_new = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$item->guarantee.' months'));
			}
			$item->guarantee_new = $guarantee_new;
			$html = '<option value=""></option>';
			if((int)$get_warehouse ==  1){
				$get_available_quantity = $this->warehouse_model->get_adjustment_stock_quantity($warehouse_id, $id, null, null);
				if($get_available_quantity){
					$item->available_quantity = (float)$get_available_quantity->inventory_number;
				}else{
					$item->available_quantity = 0;
				}
			}elseif($get_warehouse){
				$arr_warehouse_id = [];
				$warehouses = $this->warehouse_model->get_commodity_warehouse($id);
				if (count($warehouses) > 0) {
					foreach ($warehouses as $warehouse) {
						if(!in_array($warehouse['warehouse_id'], $arr_warehouse_id)){
							$arr_warehouse_id[] = $warehouse['warehouse_id'];
							if((float)$warehouse['inventory_number'] > 0){
								$html .= '<option value="' . $warehouse['warehouse_id'] . '">' . $warehouse['warehouse_name'] . '</option>';
							}
						}
					}
				}
			}
			$item->warehouses_html = $html;

			echo json_encode($item);
	}

	/**
	 * get receipt note row template
	 * @return [type] 
	 */
	public function get_good_receipt_row_template()
	{
		$name = $this->request->getPost('name');
		$commodity_name = $this->request->getPost('commodity_name');
		$warehouse_id = $this->request->getPost('warehouse_id');
		$quantities = $this->request->getPost('quantities');
		$unit_name = $this->request->getPost('unit_name');
		$unit_price = $this->request->getPost('unit_price');
		$taxname = $this->request->getPost('taxname');
		$lot_number = $this->request->getPost('lot_number');
		$date_manufacture = format_to_date($this->request->getPost('date_manufacture'));
		$expiry_date = $this->request->getPost('expiry_date');
		$commodity_code = $this->request->getPost('commodity_code');
		$unit_id = $this->request->getPost('unit_id');
		$tax_rate = $this->request->getPost('tax_rate');
		$tax_money = $this->request->getPost('tax_money');
		$goods_money = $this->request->getPost('goods_money');
		$note = $this->request->getPost('note');
		$item_key = $this->request->getPost('item_key');

		echo       $this->warehouse_model->create_goods_receipt_row_template([], $name, $commodity_name, $warehouse_id, $quantities, $unit_name, $unit_price, $taxname, $lot_number, $date_manufacture, $expiry_date, $commodity_code, $unit_id, $tax_rate, $tax_money, $goods_money, $note, $item_key);

	}

	/**
	 * get internal delivery row template
	 * @return [type] 
	 */
	public function get_internal_delivery_row_template()
	{
		$name = $this->request->getPost('name');
		$commodity_name = $this->request->getPost('commodity_name');
		$from_stock_name = $this->request->getPost('from_stock_name');
		$to_stock_name = $this->request->getPost('to_stock_name');
		$available_quantity = $this->request->getPost('available_quantity');
		$quantities = $this->request->getPost('quantities');
		$unit_name = $this->request->getPost('unit_name');
		$unit_price = $this->request->getPost('unit_price');
		$commodity_code = $this->request->getPost('commodity_code');
		$unit_id = $this->request->getPost('unit_id');
		$into_money = $this->request->getPost('into_money');
		$note = $this->request->getPost('note');
		$item_key = $this->request->getPost('item_key');
		$item_index = $this->request->getPost('item_index');

		$internal_delivery_row_template = '';
		$temporaty_quantity = $quantities;
		$temporaty_available_quantity = $available_quantity;
		$list_temporaty_serial_numbers = $this->warehouse_model->get_list_temporaty_serial_numbers($commodity_code, $from_stock_name, $quantities);

		foreach ($list_temporaty_serial_numbers as $value) {
			$temporaty_commodity_name = $commodity_name.' SN: '.$value['serial_number'];
			$quantities = 1;
			$name = 'newitems['.$item_index.']';

			$internal_delivery_row_template .= $this->warehouse_model->create_internal_delivery_row_template([], $name, $temporaty_commodity_name, $from_stock_name, $to_stock_name, $temporaty_available_quantity, $quantities, $unit_name, $unit_price, $commodity_code, $unit_id, $into_money, $note, $item_key, false,  $value['serial_number']);

			$temporaty_quantity--;
			$temporaty_available_quantity--;
			$item_index ++;
		}

		if($temporaty_quantity > 0){
			$quantities = $temporaty_quantity;
			$available_quantity = $temporaty_available_quantity;
			$name = 'newitems['.$item_index.']';

			$internal_delivery_row_template .= $this->warehouse_model->create_internal_delivery_row_template([], $name, $commodity_name, $from_stock_name, $to_stock_name, $available_quantity, $quantities, $unit_name, $unit_price, $commodity_code, $unit_id, $into_money, $note, $item_key );
		}

		echo $internal_delivery_row_template;

	}

	/**
	 * get loss adjustment row template
	 * @return [type] 
	 */
	public function get_loss_adjustment_row_template()
	{
		$name = $this->request->getPost('name');
		$commodity_name = $this->request->getPost('commodity_name');
		$expiry_date = $this->request->getPost('expiry_date');
		$lot_number = $this->request->getPost('lot_number');
		$available_quantity = $this->request->getPost('available_quantity');
		$quantities = $this->request->getPost('quantities');
		$unit_name = $this->request->getPost('unit_name');
		$commodity_code = $this->request->getPost('commodity_code');
		$unit_id = $this->request->getPost('unit_id');
		$item_key = $this->request->getPost('item_key');

		echo $this->warehouse_model->create_loss_adjustment_row_template( $name, $commodity_name, $available_quantity, $quantities, $unit_name, $expiry_date, $lot_number, $commodity_code, $unit_id, $item_key);

	}

	/**
	 * get good delivery row template
	 * @return [type] 
	 */
	public function get_good_delivery_row_template()
	{
		$name = $this->request->getPost('name');
		$commodity_name = $this->request->getPost('commodity_name');
		$warehouse_id = $this->request->getPost('warehouse_id');
		$available_quantity = $this->request->getPost('available_quantity');
		$quantities = $this->request->getPost('quantities');
		$unit_name = $this->request->getPost('unit_name');
		$unit_price = $this->request->getPost('unit_price');
		$taxname = $this->request->getPost('taxname');
		$lot_number = $this->request->getPost('lot_number');
		$expiry_date = $this->request->getPost('expiry_date');
		$commodity_code = $this->request->getPost('commodity_code');
		$unit_id = $this->request->getPost('unit_id');
		$tax_rate = $this->request->getPost('tax_rate');
		$discount = $this->request->getPost('discount');
		$note = $this->request->getPost('note');
		$guarantee_period = $this->request->getPost('guarantee_period');
		$item_key = $this->request->getPost('item_key');
		$item_index = $this->request->getPost('item_index');

		$goods_delivery_row_template = '';
		$temporaty_quantity = $quantities;
		$temporaty_available_quantity = $available_quantity;
		$list_temporaty_serial_numbers = $this->warehouse_model->get_list_temporaty_serial_numbers($commodity_code, $warehouse_id, $quantities);

		foreach ($list_temporaty_serial_numbers as $value) {
			$temporaty_commodity_name = $commodity_name.' SN: '.$value['serial_number'];
			$quantities = 1;
			$name = 'newitems['.$item_index.']';

			$goods_delivery_row_template .= $this->warehouse_model->create_goods_delivery_row_template([], $name, $temporaty_commodity_name, $warehouse_id, $temporaty_available_quantity, $quantities, $unit_name, $unit_price, $taxname, $commodity_code, $unit_id, $tax_rate, '', $discount, '', '', $guarantee_period, $expiry_date, $lot_number, $note, '', '', '', $item_key, false, false, $value['serial_number'] );
			$temporaty_quantity--;
			$temporaty_available_quantity--;
			$item_index ++;
		}

		if($temporaty_quantity > 0){
			$quantities = $temporaty_quantity;
			$available_quantity = $temporaty_available_quantity;
			$name = 'newitems['.$item_index.']';

			$goods_delivery_row_template .= $this->warehouse_model->create_goods_delivery_row_template([], $name, $commodity_name, $warehouse_id, $available_quantity, $quantities, $unit_name, $unit_price, $taxname, $commodity_code, $unit_id, $tax_rate, '', $discount, '', '', $guarantee_period, $expiry_date, $lot_number, $note, '', '', '', $item_key);
		}

		echo $goods_delivery_row_template;
	}

	/**
	 * manage packing list
	 * @param  string $id 
	 * @return [type]     
	 */
	public function manage_packing_list($id = '')
	{
		$data['delivery_id'] = $id;
		$data['title'] = _l('wh_packing_list_management');

		$data['from_date'] = format_to_date(date('Y-m-d', strtotime( date('Y-m-d') . "-15 day")), false);
		$data['to_date'] = format_to_date(get_my_local_time("Y-m-d"));
		$data['get_goods_delivery'] = $this->warehouse_model->get_goods_delivery(false);

		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staffs'] = $this->Users_model->get_details($options)->getResultArray();
		//display packing list not yet approval
		$data['status_id'] = [1,5,-1];

		return $this->template->rander("Warehouse\Views\packing_lists\manage_packing_list", $data);
	}

	/**
	 * packing list
	 * @return view
	 */
	public function packing_list($id ='', $edit_approval = false) {

		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();
			$id = $this->request->getPost('id');

			if (!$this->request->getPost('id')) {
				$mess = $this->warehouse_model->add_packing_list($data);
				if ($mess) {
					if($data['save_and_send_request'] == 'true'){
						$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '5', 'addedfrom' => get_staff_user_id1()]);
					}
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("wh_add_packing_list_failed"));
				}
				app_redirect("warehouse/manage_packing_list");

			}else{
				$id = $this->request->getPost('id');
				$mess = $this->warehouse_model->update_packing_list($data);

				if($data['save_and_send_request'] == 'true'){
					$this->save_and_send_request_send_mail(['rel_id' => $id, 'rel_type' => '5', 'addedfrom' => get_staff_user_id1()]);
				}

				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/manage_packing_list");
			}

		}
		//get vaule render dropdown select
		$data['packing_list_name_ex'] = 'PACKING_LIST' . date('YmdHi');
		$data['title'] = _l('wh_add_packing_list');

		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();

		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('can_be_inventory');
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}

		//sample
		$packing_list_row_template = $this->warehouse_model->create_packing_list_row_template();

		$data['goods_deliveries'] = $this->warehouse_model->packing_list_get_goods_delivery();
		$tax_options = array(
			"deleted" => 0,
		);
		$data['clients'] = $this->Clients_model->get_details($tax_options)->getResultArray();
		
		$data['goods_code'] = $this->warehouse_model->create_packing_list_code();
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staffs'] = $this->Users_model->get_details($options)->getResultArray();
		$data['current_day'] = date('Y-m-d');

		if($id != ''){
			$data['title'] = _l('wh_edit_packing_list');

			$packing_list = $this->warehouse_model->get_packing_list($id);
			if (!$packing_list) {
				blank_page('Packing list Not Found', 'danger');
			}
			$data['packing_list_detail'] = $this->warehouse_model->get_packing_list_detail($id);
			$data['packing_list'] = $packing_list;

			$client_options = [
				'id' => $data['packing_list']->clientid,
			];
			$client = $this->Clients_model->get_details($client_options)->getRow();
			if($client){
				$data['billing_shipping'] = $this->template->view('invoices/invoice_parts/bill_to', ['client_info' => $client]);
			}


			if (count($data['packing_list_detail']) > 0) {
				$index_receipt = 0;
				foreach ($data['packing_list_detail'] as $packing_list_detail) {
					$index_receipt++;
					$unit_name = wh_get_unit_name($packing_list_detail['unit_id']);
					$taxname = '';
					$expiry_date = null;
					$lot_number = null;
					$commodity_name = $packing_list_detail['commodity_name'];
					
					if(strlen($commodity_name) == 0){
						$commodity_name = wh_get_item_variatiom($packing_list_detail['commodity_code']);
					}

					$packing_list_row_template .= $this->warehouse_model->create_packing_list_row_template($packing_list_detail['delivery_detail_id'], 'items[' . $index_receipt . ']', $commodity_name, $packing_list_detail['quantity'], $unit_name, $packing_list_detail['unit_price'], $taxname, $packing_list_detail['commodity_code'], $packing_list_detail['unit_id'] , $packing_list_detail['tax_rate'], $packing_list_detail['total_amount'], $packing_list_detail['discount'], $packing_list_detail['discount_total'], $packing_list_detail['total_after_discount'], $packing_list_detail['sub_total'],$packing_list_detail['tax_name'],$packing_list_detail['tax_id'], $packing_list_detail['id'], true, $packing_list_detail['serial_number']);
					
				}
			}
		}

		//edit note after approval
		$data['edit_approval'] = $edit_approval;
		$data['packing_list_row_template'] = $packing_list_row_template;

		return $this->template->rander("Warehouse\Views\packing_lists\add_edit_packing_list", $data);

	}

	/**
	 * table manage packing list
	 * @return [type] 
	 */
	public function table_manage_packing_list()
	{
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'packing_lists/table_packing_list'), $dataPost);
	}

	/**
	 * get packing list row template
	 * @return [type] 
	 */
	public function get_packing_list_row_template()
	{
		$name = $this->request->getPost('name');
		$commodity_name = $this->request->getPost('commodity_name');
		$quantity = $this->request->getPost('quantity');
		$unit_name = $this->request->getPost('unit_name');
		$unit_price = $this->request->getPost('unit_price');
		$taxname = $this->request->getPost('taxname');
		$commodity_code = $this->request->getPost('commodity_code');
		$unit_id = $this->request->getPost('unit_id');
		$tax_rate = $this->request->getPost('tax_rate');
		$discount = $this->request->getPost('discount');
		$item_key = $this->request->getPost('item_key');

		echo $this->warehouse_model->create_packing_list_row_template('', $name, $commodity_name, $quantity, $unit_name, $unit_price, $taxname, $commodity_code, $unit_id, $tax_rate, '', $discount, '', '', '', '', '', $item_key );
	}

	/**
	 * packing list copy delivery note
	 * @param  string $delivery_id 
	 * @return [type]              
	 */
	public function packing_list_copy_delivery_note($delivery_id = 0)
	{
		$delivery_note_detail = $this->warehouse_model->packing_list_get_delivery_note($delivery_id);
		echo json_encode([
			'result' => $delivery_note_detail['result'] ? $delivery_note_detail['result'] : '',
			'additional_discount' => $delivery_note_detail['additional_discount'] ? $delivery_note_detail['additional_discount'] : '',
			'billing_shipping' => $delivery_note_detail['billing_shipping'],
			'customer_id' => $delivery_note_detail['customer_id'],
			'shipping_fee' => $delivery_note_detail['shipping_fee'],
		]);
	}

	/**
	 * wh client change data
	 * @param  [type] $customer_id     
	 * @param  string $current_invoice 
	 * @return [type]                  
	 */
	public function wh_client_change_data($customer_id = '', $current_invoice = '')
	{

		$data                     = [];
		$data['billing_shipping'] = '';

		if(is_numeric($customer_id)){
			$client_options = [
				'id' => $customer_id,
			];
			$client = $this->Clients_model->get_details($client_options)->getRow();
			if($client){
				$data['billing_shipping'] = $this->template->view('invoices/invoice_parts/bill_to', ['client_info' => $client]);
			}
		}

		echo json_encode($data);
	}

	/**
	 * delete packing list
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_packing_list() {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$id = $this->request->getPost('id');
		$response = $this->warehouse_model->delete_packing_list($id);
		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("wh_deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect('warehouse/manage_packing_list');
	}

	/**
	 * view packing list
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function view_packing_list($id)
	{
		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");
		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {

			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}


		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 5);
		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 5);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 5);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 5);

		//get vaule render dropdown select
		$data['packing_list_detail'] = $this->warehouse_model->get_packing_list_detail($id);
		$data['packing_list'] = $this->warehouse_model->get_packing_list($id);

		$client_options = array(
			'id' => $data['packing_list']->clientid,
			"deleted" => 0,
		);
		$client = $this->Clients_model->get_details($client_options)->getRow();
		$data['packing_list']->client = $client;
		$data['activity_log'] = $this->warehouse_model->wh_get_activity_log($id,'packing_list');
		if($client){
			$data['billing_shipping'] = $this->template->view('invoices/invoice_parts/bill_to', ['client_info' => $client]);
		}

		$data['title'] = _l('wh_packing_list');
		$check_appr = $this->warehouse_model->get_approve_setting('5');
		$data['check_appr'] = $check_appr;
		$data['tax_data'] = $this->warehouse_model->get_html_tax_packing_list($id);

		return $this->template->rander("Warehouse\Views\packing_lists\packing_list_detail", $data);
	}

	/**
	 * packing list check before approval
	 * @return [type] 
	 */
	public function packing_list_check_before_approval()
	{
		$data = $this->request->getPost();
			// packing list
			//check before send request approval
		$check_packing_list_send_request = $this->warehouse_model->check_packing_list_send_request($data);
		if($check_packing_list_send_request['flag_update_status']){
			echo json_encode([
				'success' => true,
				'message' => '',
			]);
			die;
		}else{
			$message = $check_packing_list_send_request['str_error'];
			$success = false;
			echo json_encode([
				'success' => $success,
				'message' => $message,
			]);
			die;
		}
	}

	/**
	 * packing list pdf
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function packing_list_pdf($id)
	{
		if (!$id) {
			redirect(admin_url('warehouse/packing_lists/manage_packing_list'));
		}
		$this->load->model('clients_model');
		$this->load->model('currencies_model');

		$packing_list_number = '';
		$packing_list = $this->warehouse_model->get_packing_list($id);
		$packing_list->client = $this->clients_model->get($packing_list->clientid);
		$packing_list->packing_list_detail = $this->warehouse_model->get_packing_list_detail($id);
		$packing_list->base_currency = $this->currencies_model->get_base_currency();
		$packing_list->tax_data = $this->warehouse_model->get_html_tax_packing_list($id);


		if($packing_list){
			$packing_list_number .= $packing_list->packing_list_number.' - '.$packing_list->packing_list_name;
		}
		try {
			$pdf = $this->warehouse_model->packing_list_pdf($packing_list);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';
		ob_end_clean();

		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}

		$pdf->Output(mb_strtoupper(slug_it($packing_list_number)).'.pdf', $type);
	}

	/**
	 * delivery status mark as
	 * @param  [type] $status 
	 * @param  [type] $id     
	 * @param  [type] $type   
	 * @return [type]         
	 */
	public function delivery_status_mark_as($status, $id, $type)
	{
		$success = $this->warehouse_model->delivery_status_mark_as($status, $id, $type);
		$message = '';

		if ($success) {
			$message = _l('wh_change_delivery_status_successfully');
		}
		echo json_encode([
			'success'  => $success,
			'message'  => $message
		]);
	}

	/**
	 * shipment detail
	 * @param  string $id 
	 * @return [type]     
	 */
	public function shipment_detail($id = '')
	{

		$this->load->model('omni_sales/omni_sales_model');
		$cart = $this->omni_sales_model->get_cart($id);
		$cart_detailts = $this->omni_sales_model->get_cart_detailt_by_master($id);
		if (!$cart) {
			blank_page(_l('shipment_not_found'));
		}
		$shipment = $this->warehouse_model->get_shipment_by_order($id);
		if (!$shipment) {
			blank_page(_l('shipment_not_found'));
		}
		$data = [];
		$data['cart'] = $cart;
		$data['cart_detailts'] = $cart_detailts;
		$data['title']          = $data['cart']->order_number;
		$data['shipment']          = $shipment;
		$data['order_id']          = $id;

		if($data['cart']->number_invoice != ''){
			$data['invoice'] = $this->omni_sales_model->get_invoice($data['cart']->number_invoice);
		}
		 
		//get activity log
		$data['arr_activity_logs'] = $this->warehouse_model->wh_get_shipment_activity_log($shipment->id);
		$wh_shipment_status = wh_shipment_status();
		$shipment_staus_order='';
		foreach ($wh_shipment_status as $shipment_status) {
			if($shipment_status['name'] ==  $data['shipment']->shipment_status){
				$shipment_staus_order = $shipment_status['order'];
			}
		}

		foreach ($wh_shipment_status as $shipment_status) {
			if((int)$shipment_status['order'] <= (int)$shipment_staus_order){
				$data[$shipment_status['name']] = ' completed';
			}else{
				$data[$shipment_status['name']] = '';
			}
		}
		$data['shipment_staus_order'] = $shipment_staus_order;

		//get delivery note
		if(is_numeric($data['cart']->stock_export_number)){
			$this->db->where('id', $data['cart']->stock_export_number);
			$data['goods_delivery'] = $this->db->get(get_db_prefix() . 'goods_delivery')->getResultArray();
			$data['packing_lists'] = $this->warehouse_model->get_packing_list_by_deivery_note($data['cart']->stock_export_number);

			//update goods delivery id
			$this->db->where('cart_id', $data['cart']->id);
			$this->db->update(get_db_prefix().'wh_omni_shipments', ['goods_delivery_id' => $data['cart']->stock_export_number]);
		}

		$this->load->view('shipments/shipment_detail', $data);
	}

	/**
	 * shipment activity log modal
	 * @return [type] 
	 */
	public function shipment_activity_log_modal()
	{
		if ($this->input->is_ajax_request()) {
			$request_data = $this->request->getGet();

			$data=[];
			$data['shipment_id'] = $request_data['shipment_id'];
			$data['id'] = $request_data['id'];
			$data['cart_id'] = $request_data['cart_id'];

			if($request_data['id'] != ''){
				$data['activity_log'] = $this->warehouse_model->wh_get_activity_log_by_id($request_data['id']);
			}

			$response = $this->load->view('shipments/modals/add_edit_activity_log_modal', $data, true);
			echo json_encode([
				'data' => $response,
			]);
		}
	}

	/**
	 * shipment add edit activity log
	 * @return [type] 
	 */
	public function shipment_add_edit_activity_log()
	{
		if($this->request->getPost()){
			$data = $this->request->getPost();
			if (!has_permission('warehouse', '', 'edit') && !is_admin() && !has_permission('warehouse', '', 'create')) {
				app_redirect("forbidden");
			}

			$cart_id = '';
			if($data['id'] == ''){
				unset($data['id']);
				$cart_id = $data['cart_id'];
				unset($data['cart_id']);
				$date = to_sql_date($data['date'], true);
				$result =  $this->warehouse_model->log_wh_activity($data['rel_id'], 'shipment', $data['description'], $date);
				if($result){
					set_alert('success', _l('added_successfully'));
				}else{
					set_alert('danger', _l('wh_add_shipment_log_failed'));					
				}
				redirect(admin_url('warehouse/shipment_detail/'.$cart_id));
			}
			else{
				$cart_id = $data['cart_id'];
				unset($data['cart_id']);
				$data['date'] = to_sql_date($data['date'], true);
				$result =  $this->warehouse_model->update_activity_log($data['id'], $data);
				if($result){
					set_alert('success', _l('updated_successfully'));
				}
				redirect(admin_url('warehouse/shipment_detail/'.$cart_id));
			}
		}
	}

	/**
	 * update shipment status
	 * @param  [type] $status      
	 * @param  [type] $shipment_id 
	 * @param  [type] $cart_id     
	 * @return [type]              
	 */
	public function update_shipment_status($status, $shipment_id, $cart_id)
	{	
		$this->db->where('id', $shipment_id);
		$this->db->update(get_db_prefix().'wh_omni_shipments', ['shipment_status' => $status]);

		//update delivery note
		$this->load->model('omni_sales/omni_sales_model');
		$cart = $this->omni_sales_model->get_cart($cart_id);
		if($cart){
			if(is_numeric($cart->stock_export_number)){
				$arr_packing_list_id = [];
				$new_status = 'delivery_in_progress';
				//get packing list
				$packing_lists = $this->warehouse_model->get_packing_list_by_deivery_note($cart->stock_export_number);
				if(count($packing_lists) > 0){
					foreach ($packing_lists as $value) {
						$arr_packing_list_id[] = $value['id'];
					}
				}

				if($status == 'product_dispatched'){
					$new_status = 'delivery_in_progress';
				}elseif($status == 'product_delivered'){
					$new_status = 'delivered';
				}

				$this->db->where('id', $cart->stock_export_number);
				$this->db->update(get_db_prefix().'goods_delivery', ['delivery_status' => $new_status]);

				if(count($arr_packing_list_id) > 0){
					$this->db->where('id IN ('.implode(',', $arr_packing_list_id).')');
					$this->db->update(get_db_prefix().'wh_packing_lists', ['delivery_status' => $new_status]);
				}
			}
		}

		//create activity log for shipment
		$shipment_log = _l($status);
		$this->warehouse_model->log_wh_activity($shipment_id, 'shipment', $shipment_log);

		set_alert('success', _l('updated_successfully'));
		redirect(admin_url('warehouse/shipment_detail/'.$cart_id));
	}

	/**
	 * update return policies information
	 * @return [type] 
	 */
	public function update_return_policies_information()
	{
		$data = $this->request->getGet();

		if ((isset($data)) && $data != '') {
			$myContent = $this->request->getGet('myContent');
			$status = $this->warehouse_model->update_warehouse_return_polices(['wh_return_policies_information' => $myContent]);

			if($status){
				$message = _l('updated_successfully');
			}else{
				$message = _l('updated_failed');
			}

			echo json_encode([
				'message' => $message,
				'status' =>$status,
			]);
		}
	}

	/**
	 * manage order return
	 * @param  string $id 
	 * @return [type]     
	 */
	public function manage_order_return($id = '')
	{
		$data['delivery_id'] = $id;
		$data['title'] = _l('management_receiving_exporting_goods_returning_goods');

		$data['from_date'] = format_to_date(date('Y-m-d', strtotime( date('Y-m-d') . "-15 day")), false);
		$data['to_date'] = format_to_date(get_my_local_time("Y-m-d"));
		$data['get_goods_delivery'] = $this->warehouse_model->get_goods_delivery(false);
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staffs'] = $this->Users_model->get_details($options)->getResultArray();
		//display packing list not yet approval
		$data['rel_type'] = 'all';

		return $this->template->rander("Warehouse\Views\order_returns\manage_order_return", $data);
	}

	/**
	 * sales order manage order return
	 * @param  string $id 
	 * @return [type]     
	 */
	public function sales_order_manage_order_return($id = '')
	{
		$data['delivery_id'] = $id;
		$data['title'] = _l('wh_order_return_management');

		$data['from_date'] = format_to_date(date('Y-m-d', strtotime( date('Y-m-d') . "-15 day")), false);
		$data['to_date'] = format_to_date(date('Y-m-d'), false);
		$data['get_goods_delivery'] = $this->warehouse_model->get_goods_delivery(false);
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staffs'] = $this->Users_model->get_details($options)->getResultArray();
		//display packing list not yet approval
		$data['rel_type'] = 'sales_return_order';
		return $this->template->rander("Warehouse\Views\order_returns\manage_order_return", $data);
	}

	/**
	 * purchasing manage order return
	 * @param  string $id 
	 * @return [type]     
	 */
	public function purchasing_manage_order_return($id = '')
	{
		$data['delivery_id'] = $id;
		$data['title'] = _l('wh_order_return_management');

		$data['from_date'] = format_to_date(date('Y-m-d', strtotime( date('Y-m-d') . "-15 day")), false);
		$data['to_date'] = format_to_date(date('Y-m-d'), false);
		$data['get_goods_delivery'] = $this->warehouse_model->get_goods_delivery(false);
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staffs'] = $this->Users_model->get_details($options)->getResultArray();
		//display packing list not yet approval
		$data['rel_type'] = 'purchasing_return_order';

		return $this->template->rander("Warehouse\Views\order_returns\manage_order_return", $data);
	}

	/**
	 * order return
	 * @param  string $id                
	 * @param  string $order_retrun_type : have 3 type "manual"; "sales_return_order"; "purchasing_return_order"
	 * @return [type]                    
	 */
	public function order_return($receipt_delivery_type = 'manual', $id ='') {
		$order_return_type = 'manual';

		if ($this->request->getPost()) {
			$message = '';
			$data = $this->request->getPost();
			$id = $this->request->getPost('id');

			if (!$this->request->getPost('id')) {
				if($order_return_type == 'manual'){
					$mess = $this->warehouse_model->add_order_return($data, $data['rel_type']);
				}elseif($order_return_type == 'sales_return_order'){
					$mess = $this->warehouse_model->add_order_return($data, $data['rel_type']);
				}elseif($order_return_type == 'purchasing_return_order'){
					$mess = $this->warehouse_model->add_order_return($data, $data['rel_type']);
				}

				if ($mess) {
					if($data['save_and_send_request'] == 'true'){
						$this->save_and_send_request_send_mail(['rel_id' => $mess, 'rel_type' => '6', 'addedfrom' => get_staff_user_id1()]);
					}
					$this->session->setFlashdata("success_message", app_lang("added_successfully"));
				} else {
					$this->session->setFlashdata("error_message", app_lang("wh_add_order_return_failed"));
				}
				app_redirect("warehouse/manage_order_return");

			}else{
				$id = $this->request->getPost('id');

				if($order_return_type == 'manual'){
					$mess = $this->warehouse_model->update_order_return($data, $data['rel_type'], $id);
				}elseif($order_return_type == 'sales_return_order'){
					$mess = $this->warehouse_model->update_order_return($data, $data['rel_type'], $id);
				}elseif($order_return_type == 'purchasing_return_order'){
					$mess = $this->warehouse_model->update_order_return($data, $data['rel_type'], $id);
				}

				if($data['save_and_send_request'] == 'true'){
					$this->save_and_send_request_send_mail(['rel_id' => $id, 'rel_type' => '6', 'addedfrom' => get_staff_user_id1()]);
				}

				if ($mess) {
					$this->session->setFlashdata("success_message", app_lang("updated_successfully"));
				}
				app_redirect("warehouse/manage_order_return");

			}

		}
		//get value render dropdown select
		if($receipt_delivery_type == 'inventory_receipt'){

			$data['order_return_name_ex'] = 'RECEIPT_RETURN' . date('YmdHi');
			$data['goods_code'] = $this->warehouse_model->create_order_return_code();
		}else{
			$data['order_return_name_ex'] = 'DELIVERY_RETURN' . date('YmdHi');
			$data['goods_code'] = $this->warehouse_model->create_delivery_order_return_code();
			if(get_status_modules_wh('purchase')){
				$data['vendor_data'] = $this->warehouse_model->get_vendor();
			}else{
				$data['vendor_data'] = [];
			}
		}

		$tax_options = array(
			"deleted" => 0,
		);
		$data['taxes'] = $this->Taxes_model->get_details($tax_options)->getResultArray();
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('can_be_inventory');
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}

		//sample
		$order_return_row_template = $this->warehouse_model->create_order_return_row_template($receipt_delivery_type);
		$data['goods_deliveries'] = $this->warehouse_model->packing_list_get_goods_delivery();
		$tax_options = array(
			"deleted" => 0,
		);
		$data['clients'] = $this->Clients_model->get_details($tax_options)->getResultArray();

		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$data['staffs'] = $this->Users_model->get_details($options)->getResultArray();
		$data['current_day'] = date('Y-m-d');

		if($id != ''){
			$order_return = $this->warehouse_model->get_order_return($id);

			if($order_return->receipt_delivery_type == 'inventory_receipt_voucher_returned_goods'){
				$receipt_delivery_type = 'inventory_receipt_voucher_returned_goods';
				$data['title'] = _l('wh_edit_inventory_receipt_voucher_returned_goods');

				//get related data

				$data['order_return_get_inventory_delivery'] = $this->warehouse_model->order_return_get_inventory_delivery(); 
				$data['order_return_get_sale_order'] = $this->warehouse_model->order_return_get_sale_order(); 

			}else{
				$receipt_delivery_type = 'inventory_delivery_voucher_returned_purchasing_goods';
				$data['title'] = _l('wh_edit_inventory_delivery_voucher_returned_purchasing_goods');

				//get related data
				$data['order_return_get_inventory_receipt'] = $this->warehouse_model->order_return_get_inventory_receipt(); 
				$data['order_return_get_purchasing_order'] = $this->warehouse_model->order_return_get_purchasing_order(); 
			}


			if (!$order_return) {
				blank_page('Order Return Not Found', 'danger');
			}
			$data['order_return_detail'] = $this->warehouse_model->get_order_return_detail($id);
			$data['order_return'] = $order_return;

			if (count($data['order_return_detail']) > 0) {
				$index_receipt = 0;
				foreach ($data['order_return_detail'] as $order_return_detail) {
					$index_receipt++;
					$unit_name = wh_get_unit_name($order_return_detail['unit_id']);
					$taxname = '';
					$expiry_date = null;
					$lot_number = null;
					$commodity_name = $order_return_detail['commodity_name'];
					
					if(strlen($commodity_name) == 0){
						$commodity_name = wh_get_item_variatiom($order_return_detail['commodity_code']);
					}

					$order_return_row_template .= $this->warehouse_model->create_order_return_row_template($order_return->rel_type, $order_return_detail['rel_type_detail_id'], 'items[' . $index_receipt . ']', $commodity_name, $order_return_detail['quantity'], $unit_name, $order_return_detail['unit_price'], $taxname, $order_return_detail['commodity_code'], $order_return_detail['unit_id'] , $order_return_detail['tax_rate'], $order_return_detail['total_amount'], $order_return_detail['discount'], $order_return_detail['discount_total'], $order_return_detail['total_after_discount'], $order_return_detail['reason_return'], $order_return_detail['sub_total'],$order_return_detail['tax_name'],$order_return_detail['tax_id'], $order_return_detail['id'], true);
					
				}
			}
		}else{
			if($receipt_delivery_type == 'inventory_receipt'){
				$receipt_delivery_type = 'inventory_receipt_voucher_returned_goods';
				$data['title'] = _l('wh_add_inventory_receipt_voucher_returned_goods');

				//get related data

				$data['order_return_get_inventory_delivery'] = $this->warehouse_model->order_return_get_inventory_delivery(); 

				$data['order_return_get_sale_order'] = $this->warehouse_model->order_return_get_sale_order(); 
				
			}else{
				$receipt_delivery_type = 'inventory_delivery_voucher_returned_purchasing_goods';
				$data['title'] = _l('wh_add_inventory_delivery_voucher_returned_purchasing_goods');

				//get related data
				$data['order_return_get_inventory_receipt'] = $this->warehouse_model->order_return_get_inventory_receipt(); 
				$data['order_return_get_purchasing_order'] = $this->warehouse_model->order_return_get_purchasing_order(); 
			}
		}

		//edit note after approval
		$data['order_return_row_template'] = $order_return_row_template;
		$data['order_return_type'] = $order_return_type;
		$data['receipt_delivery_type'] = $receipt_delivery_type;

		return $this->template->rander("Warehouse\Views\order_returns\add_edit_order_return", $data);

	}

	/**
	 * table manage packing list
	 * @return [type] 
	 */
	public function table_manage_order_return()
	{
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'order_returns/table_order_return'), $dataPost);
	}

	/**
	 * get order return row template
	 * @return [type] 
	 */
	public function get_order_return_row_template()
	{
		$name = $this->request->getPost('name');
		$commodity_name = $this->request->getPost('commodity_name');
		$quantity = $this->request->getPost('quantity');
		$unit_name = $this->request->getPost('unit_name');
		$unit_price = $this->request->getPost('unit_price');
		$taxname = $this->request->getPost('taxname');
		$commodity_code = $this->request->getPost('commodity_code');
		$unit_id = $this->request->getPost('unit_id');
		$tax_rate = $this->request->getPost('tax_rate');
		$discount = $this->request->getPost('discount');
		$item_key = $this->request->getPost('item_key');

		echo $this->warehouse_model->create_order_return_row_template('manual', '', $name, $commodity_name, $quantity, $unit_name, $unit_price, $taxname, $commodity_code, $unit_id, $tax_rate, '', $discount, '', '','', '', '', '', $item_key );

	}

	/**
	 * wh client data
	 * @param  [type] $customer_id 
	 * @return [type]              
	 */
	public function wh_client_data($customer_id, $rel_type)
	{

		$phonenumber = '';
		$email = '';
		if($rel_type == 'inventory_delivery_voucher_returned_purchasing_goods'){
			if(get_status_modules_wh('purchase')){
				$this->load->model('purchase/purchase_model');
				$vendor = $this->purchase_model->get_vendor($customer_id);
				if($vendor){
					$phonenumber = $vendor->phonenumber;
					$contacts = $this->purchase_model->get_contacts($customer_id);
					if(count($contacts) > 0){
						$email = $contacts[0]['email'];
					}
				}
			}
		}else{

			$contact_options = array(
				"id" => $customer_id,
			);
			$client = $this->Clients_model->get_details($contact_options)->getRow();

			if($client){
				$phonenumber = $client->phone;
				$options = array(
					"user_type" => "client",
					"client_id" => $customer_id,
					"is_primary_contact" => 1,
				);
				$contact = $this->Users_model->get_details($options)->getRow();

				if($contact){
					$email = $contact->email;
				}
			}
		}

		echo json_encode([
			'phonenumber' => $phonenumber,
			'email' => $email,
		]);
	}


	/**
	 * order return get item data
	 * @param  string $delivery_id 
	 * @return [type]              
	 */
	public function order_return_get_item_data()
	{
		$data = $this->request->getPost();
		$results = $this->warehouse_model->order_return_get_related_data_detail($data);
		
		echo json_encode($results);
	}

	/**
	 * delete order return
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function delete_order_return() {

		if(!has_permission('warehouse', '', 'delete')  &&  !is_admin()) {
			app_redirect("forbidden");
		}

		$id = $this->request->getPost('id');
		$response = $this->warehouse_model->delete_order_return($id);
		if ($response == true) {
			$this->session->setFlashdata("success_message", app_lang("wh_deleted"));
		} else {
			$this->session->setFlashdata("error_message", app_lang("problem_deleting"));
		}
		app_redirect('warehouse/manage_order_return');
	}

	/**
	 * view order return
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function view_order_return($id)
	{
		//approval
		$session = \Config\Services::session();
		$send_mail_approve = $session->has("send_mail_approve");
		if (($send_mail_approve) && $session->get("send_mail_approve") != '') {

			$data['send_mail_approve'] = $session->get("send_mail_approve");
			$session->remove("send_mail_approve");
		}

		$data['get_staff_sign'] = $this->warehouse_model->get_staff_sign($id, 6);
		$data['check_approve_status'] = $this->warehouse_model->check_approval_details($id, 6);
		$data['list_approve_status'] = $this->warehouse_model->get_list_approval_details($id, 6);
		$data['payslip_log'] = $this->warehouse_model->get_activity_log($id, 6);

		$data['order_return_detail'] = $this->warehouse_model->get_order_return_detail($id);
		$data['order_return'] = $this->warehouse_model->get_order_return($id);
		$data['activity_log'] = $this->warehouse_model->wh_get_activity_log($id,'order_return');

		$data['title'] = _l('wh_order_return');
		$check_appr = $this->warehouse_model->get_approve_setting('6');
		$data['check_appr'] = $check_appr;
		$data['tax_data'] = $this->warehouse_model->get_html_tax_order_return($id);

		return $this->template->rander("Warehouse\Views\order_returns/order_return_detail", $data);
	}

	/**
	 * order return check before approval
	 * @return [type] 
	 */
	public function order_return_check_before_approval()
	{
		$data = $this->request->getPost();
			// packing list
			//check before send request approval
		if( $data['order_rel_type'] == 'manual'){
			echo json_encode([
				'success' => true,
				'message' => '',
			]);
			die;
		}

	}

	/**
	 * order return pdf
	 * @param  [type] $id 
	 * @return [type]     
	 */
	public function order_return_pdf($id)
	{
		if (!$id) {
			redirect(admin_url('warehouse/order_returns/manage_order_return'));
		}
		$this->load->model('clients_model');
		$this->load->model('currencies_model');

		$order_return_number = '';
		$order_return = $this->warehouse_model->get_order_return($id);
		$order_return->client = $this->clients_model->get($order_return->company_id);
		$order_return->order_return_detail = $this->warehouse_model->get_order_return_detail($id);
		$order_return->base_currency = $this->currencies_model->get_base_currency();
		$order_return->tax_data = $this->warehouse_model->get_html_tax_order_return($id);
		$order_return->clientid = $order_return->company_id;


		if($order_return){
			$order_return_number .= $order_return->order_return_number.' - '.$order_return->order_return_name;
		}
		try {
			$pdf = $this->warehouse_model->order_return_pdf($order_return);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';
		ob_end_clean();

		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}

		$pdf->Output(mb_strtoupper(slug_it($order_return_number)).'.pdf', $type);
	}

	/**
	 * wh get item by barcode
	 * @param  [type] $barcode 
	 * @return [type]          
	 */
	public function wh_get_item_by_barcode($barcode)
	{
		$id = 0;
		$status = false;
		$message = '';
		$value = $this->warehouse_model->get_commodity_hansometable_by_barcode($barcode);
		if(isset($value)){
			$id = $value->id;
			$status = true;
			$message = $value->commodity_barcode.': '.$value->commodity_code.' - '.$value->description;
		}
		echo json_encode([
			"id" => $id,
			"status" => $status,
			"message" => $message,
		]);
	}

	/**
	 * order return create import stock
	 * @param  [type] $order_return_id 
	 * @return [type]                  
	 */
	public function order_return_create_stock_import_export($order_return_id)
	{
		if (!has_permission('warehouse', '', 'edit') && !is_admin() && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}
		$order_return = $this->warehouse_model->get_order_return($order_return_id);
		if (!$order_return) {
			blank_page('Order Return Not Found', 'danger');
		}

		//check warehouse receive return order, if not set => create new warehouse, set default receive return order
		if(!get_option('warehouse_receive_return_order')){
			$warehouse = [];
			$warehouse = [
				'warehouse_code' => 'WH_RECEIVE',
				'warehouse_name' => 'Warehouse receive return order',
				'order' => 10,
				'warehouse_address' => '',
				'city' => '',
				'state' => '',
				'zip_code' => '',
				'country' => '',
				'note' => '',
				'display' => 'on',
			];
			$warehouse_id = $this->warehouse_model->add_one_warehouse($warehouse);
			$this->warehouse_model->update_goods_receipt_warehouse(['input_name' => 'warehouse_receive_return_order', 'input_name_status' => $warehouse_id]);
		}

		if($order_return->rel_type == 'manual'){
			$receipt_id = $this->warehouse_model->order_return_create_stock_import($order_return_id);
			redirect(admin_url('warehouse/manage_purchase/'.$receipt_id));

		}elseif($order_return->rel_type == 'sales_return_order'){
			$receipt_id = $this->warehouse_model->sales_return_order_create_stock_import($order_return_id);
			redirect(admin_url('warehouse/manage_purchase/'.$receipt_id));

		}elseif($order_return->rel_type == 'purchasing_return_order'){
			$data = $this->request->getPost();
			$warehouse_id = $data['warehouse_id'];
			
			$delivery_id = $this->warehouse_model->purchasing_return_order_create_stock_export($order_return_id, $warehouse_id);
			redirect(admin_url('warehouse/manage_delivery/'.$delivery_id));
		}
	}
	
	/**
	 * order return get related data
	 * @return [type] 
	 */
	public function order_return_get_related_data()
	{
		if ($this->input->is_ajax_request()) {
			$related_data = '';
			$data = $this->request->getGet();
			if ((isset($data)) && $data != '') {
				$related_data = $this->warehouse_model->order_return_get_related_data($data);

				echo json_encode([
					'related_data' => $related_data,
				]);
			}
		}
	}

	/**
	 * open warehouse modal
	 * @return [type] 
	 */
	public function open_warehouse_modal()
	{

		$id = $this->request->getPost('order_return_id');

		$data = [];
		$data['title'] = _l('select_warehouse_to_create_inventory_delivery');
		$data['id'] = $id;
		$data['warehouses'] = $this->warehouse_model->get_warehouse();
		$data['html'] = $this->warehouse_model->order_return_render_warehouse_modal($id);

		return $this->template->view('Warehouse\Views\order_returns\select_warehouse_modal', $data);

	}

	/**
	 * order return create stock export
	 * @param  [type] $order_return_id 
	 * @return [type]                  
	 */
	public function order_return_create_stock_export()
	{
		if (!has_permission('warehouse', '', 'edit') && !is_admin() && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}

		$order_return_id = $this->request->getPost('id');
		$order_return = $this->warehouse_model->get_order_return($order_return_id);
		if (!$order_return) {
			app_redirect('inventory_receipt_inventory_delivery_returns_goods');
		}

		$data = $this->request->getPost();
		if(!isset($data['newitems'])){
			app_redirect("warehouse/view_order_return/".$order_return_id);
		}

		$delivery_id = $this->warehouse_model->purchasing_return_order_create_stock_export($order_return_id, $data);

		app_redirect("warehouse/view_delivery/".$delivery_id);
	}

	/**
	 * fill multiple serial number modal
	 * @return [type] 
	 */
	public function fill_multiple_serial_number_modal()
	{
		
		$data = [];
		$data['title'] = _l('wh_enter_the_serial_number');
		$slug = $this->request->getPost('slug');

		if($slug == 'add'){
			$quantity = $this->request->getPost('quantity');
			$prefix_name = $this->request->getPost('prefix_name');

		}else{
			$serial_data = [];
			$serial_input_value = $this->request->getPost('serial_input_value');
			$serial_input_value = explode(',', $serial_input_value);

			if(count($serial_input_value) > 0){
				foreach ($serial_input_value as $value) {
					if($value != 'null'){
						$serial_data[] = ['serial_number' => $value];
					}else{
						$serial_data[] = ['serial_number' => ''];
					}
				}
			}
			$prefix_name = $this->request->getPost('prefix_name');
			$data['edit_serial_number_data'] = $serial_data;
			$quantity = count($serial_input_value);
		}


		$data['min_row'] = $quantity;
		$data['max_row'] = $quantity;
		$data['prefix_name'] = $prefix_name;

		return $this->template->view('Warehouse\Views\manage_goods_receipt\serial_modal', $data);
	}

	/**
	 * loss fill multiple serial number modal
	 * @return [type] 
	 */
	public function loss_fill_multiple_serial_number_modal()
	{
		
		$data = [];
		$data['title'] = _l('Enter_the_serial_number_of_the_damaged_or_lost_product_otherwise_the_system_will_automatically_get_a_random_serial_number');
		$slug = $this->request->getPost('slug');

		if($slug == 'add'){
			$quantity = $this->request->getPost('quantity');
			$prefix_name = $this->request->getPost('prefix_name');

		}else{
			$serial_data = [];
			$serial_input_value = $this->request->getPost('serial_input_value');
			$serial_input_value = explode(',', $serial_input_value);

			if(count($serial_input_value) > 0){
				foreach ($serial_input_value as $value) {
					if($value != 'null'){
						$serial_data[] = ['serial_number' => $value];
					}else{
						$serial_data[] = ['serial_number' => ''];
					}
				}
			}
			$prefix_name = $this->request->getPost('prefix_name');
			$data['edit_serial_number_data'] = $serial_data;
			$quantity = count($serial_input_value);
		}


		$data['min_row'] = $quantity;
		$data['max_row'] = $quantity;
		$data['prefix_name'] = $prefix_name;

		return $this->template->view('Warehouse\Views\loss_adjustment\delete_serial_modal', $data);

	}


	/**
	 * adjustment fill multiple serial number modal
	 * @return [type] 
	 */
	public function adjustment_fill_multiple_serial_number_modal()
	{
		
		$data = [];
		$data['title'] = _l('wh_enter_the_serial_number');
		$slug = $this->request->getPost('slug');

		if($slug == 'add'){
			$quantity = $this->request->getPost('quantity');
			$prefix_name = $this->request->getPost('prefix_name');

		}else{
			$serial_data = [];
			$serial_input_value = $this->request->getPost('serial_input_value');
			$serial_input_value = explode(',', $serial_input_value);

			if(count($serial_input_value) > 0){
				foreach ($serial_input_value as $value) {
					if($value != 'null'){
						$serial_data[] = ['serial_number' => $value];
					}else{
						$serial_data[] = ['serial_number' => ''];
					}
				}
			}
			$prefix_name = $this->request->getPost('prefix_name');
			$data['edit_serial_number_data'] = $serial_data;
			$quantity = count($serial_input_value);
		}


		$data['min_row'] = $quantity;
		$data['max_row'] = $quantity;
		$data['prefix_name'] = $prefix_name;

		return $this->template->view('Warehouse\Views\loss_adjustment\add_serial_modal', $data);
	}

	/**
	 * import_serial_number
	 * @return [type] 
	 */
	public function import_serial_number()
	{

		//filter
		$data['title'] = _l('wh_serial_numbers');
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();

		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}

		return $this->template->rander("Warehouse\Views\serial_numbers/manage_commodity", $data);
	}

	/**
	 * serial number table commodity list
	 * @return [type] 
	 */
	public function serial_number_table_commodity_list()
	{
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'serial_numbers/table_commodity_list'), $dataPost);
	}

	/**
	 * warehouse export item serial number checked
	 * @return [type] 
	 */
	public function warehouse_export_item_serial_number_checked()
	{
		$this->access_only_team_members();
		$user_id = $this->login_user->id;

		if(!class_exists('XLSXReader_fin')){
			require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXReader/XLSXReader.php');
		}
		require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXWriter/xlsxwriter.class.php');

		if ($this->request->getPost()) {

			/*delete export file before export file*/
			$path_before = COMMODITY_EXPORT.'item_serial_numbers'.$user_id.'.xlsx';
			if(file_exists($path_before)){
				unlink(COMMODITY_EXPORT.'item_serial_numbers'.$user_id.'.xlsx');
			}

			$ids                   = $this->request->getPost('ids');

			//Writer file
			$writer_header = array(
				"(*)" .app_lang('id')         =>'string',
				"(*)" .app_lang('commodity_id')          =>'string',
				"(*)" .app_lang('warehouse_id')          =>'string',
				"(*)" .app_lang('inventory_manage_id')          =>'string',
				"(*)" .app_lang('commodity_name')          =>'string',
				"(*)" .app_lang('wh_serial_number')          =>'string',
			);

			$widths_arr = array();
			for($i = 1; $i <= count($writer_header); $i++ ){
				$widths_arr[] = 40;
			}

			$writer = new \XLSXWriter();

			$col_style1 =[0,1,2,3,4];
			$style1 = ['widths'=> $widths_arr, 'fill' => '#ff9800',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ];

			$writer->writeSheetHeader_v2('Item Serial Numbers', $writer_header,  $col_options = ['widths'=> $widths_arr, 'fill' => '#03a9f46b',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ], $col_style1, $style1);


			// Add some data
			$x= 2;
			if(isset($ids)){
				if(count($ids) > 0){
					//get item serial number by parent id
					$arr_serial_numbers = [];
					$arr_items = [];
					$list_inventory = get_list_inventory_by_ids($ids);
					$list_serial_numbers = get_list_serial_number_by_ids($ids);
					$list_items = get_list_items_by_parent_ids($ids);
					foreach ($list_items as $value) {
						$arr_items[$value['id']] = $value['title'];
					}

					foreach ($list_serial_numbers as $value) {
						$arr_serial_numbers[$value['inventory_manage_id']][$value['commodity_id']][$value['warehouse_id']][] = [
							'serial_number' => $value['serial_number'],
							'id' => $value['id'],
						];
					}

					foreach ($list_inventory as $value) {
						for ($i=0; $i < (int)$value['inventory_number'] ; $i++) { 
							if(isset($arr_serial_numbers[$value['id']][$value['commodity_id']][$value['warehouse_id']]) && count($arr_serial_numbers[$value['id']][$value['commodity_id']][$value['warehouse_id']]) > 0){

								$first_key = array_key_first($arr_serial_numbers[$value['id']][$value['commodity_id']][$value['warehouse_id']]);
								$first_value = $arr_serial_numbers[$value['id']][$value['commodity_id']][$value['warehouse_id']][$first_key];
								$serial_number = $first_value['serial_number'];
								$id = $first_value['id'];
								unset($arr_serial_numbers[$value['id']][$value['commodity_id']][$value['warehouse_id']][$first_key]);

							}else{
								$serial_number = '';
								$id = 0;
							}

							$writer->writeSheetRow('Item Serial Numbers', [
								$id,
								$value['commodity_id'],
								$value['warehouse_id'],
								$value['id'],
								isset($arr_items[$value['commodity_id']]) ? $arr_items[$value['commodity_id']] : get_item_description($value['commodity_id']),
								$serial_number,
							]);
						}
					}
				}

			}

			// Rename worksheet

			// Redirect output to a client’s web browser (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="inventory_items_sheet.xlsx"');
			header('Cache-Control: max-age=0');

			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$filename = 'item_serial_numbers'.$user_id.strtotime(date('Y-m-d H:i:s')).'.xlsx';
			$writer->writeToFile(str_replace($filename, WAREHOUSE_EXPORT_ITEM.$filename, $filename));

			echo json_encode(['success' => true,
				'filename' => WAREHOUSE_EXPORT_ITEM.$filename,
				'base_url'          => base_url(),
			]);

			exit;
		}
	}

	/**
	 * import_serial_number
	 * @return [type] 
	 */
	public function import_serial_number_excel() {
		if (!is_admin() && !has_permission('warehouse', '', 'create')) {
			app_redirect("forbidden");
		}

		$user_id = $this->login_user->id;

		if(!class_exists('XLSXReader_fin')){
			require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXReader/XLSXReader.php');
		}
		require_once(module_dir_path(WAREHOUSE_MODULE_NAME).'/assets/plugins/XLSXWriter/xlsxwriter.class.php');

		$total_row_false = 0;
		$total_rows_data = 0;
		$dataerror = 0;
		$total_row_success = 0;
		$total_rows_data_error = 0;
		$filename='';

		if ($this->request->getPost()) {

			if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

				// Get the temp file path
				$tmpFilePath = $_FILES['file_csv']['tmp_name'];
				// Make sure we have a filepath
				if (!empty($tmpFilePath) && $tmpFilePath != '') {
					$temp_file_path = get_setting("temp_file_path");
					$tmpDir = getcwd() . '/' . $temp_file_path;
					if (!is_dir($tmpDir)) {
						if (!mkdir($tmpDir, 0777, true)) {
							die('Failed to create file folders.');
						}
					}

					// Setup our new file path
					$newFilePath = $tmpDir . $_FILES['file_csv']['name'];

					if (move_uploaded_file($tmpFilePath, $newFilePath)) {
						$import_result = true;
						$row_inserts = [];
						$row_updates = [];

						//Writer file
						$writer_header = array(
							"(*)" .app_lang('id')          =>'string',
							"(*)" .app_lang('commodity_id')          =>'string',
							"(*)" .app_lang('warehouse_id')          =>'string',
							"(*)" .app_lang('inventory_manage_id')          =>'string',
							"(*)" .app_lang('commodity_name')          =>'string',
							"(*)" .app_lang('wh_serial_number')          =>'string',
							app_lang('error')                     =>'string',
						);

						$widths_arr = array();
						for($i = 1; $i <= count($writer_header); $i++ ){
							$widths_arr[] = 40;
						}

						$writer = new \XLSXWriter();

						$col_style1 =[0,1,2,3,4,5,6];
						$style1 = ['widths'=> $widths_arr, 'fill' => '#ff9800',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ];

						$writer->writeSheetHeader_v2('Item Serial Numbers', $writer_header,  $col_options = ['widths'=> $widths_arr, 'fill' => '#03a9f46b',  'font-style'=>'bold', 'color' => '#0a0a0a', 'border'=>'left,right,top,bottom', 'border-color' => '#0a0a0a', 'font-size' => 13 ], $col_style1, $style1);

						//init file error end

						//Reader file
						$xlsx = new \XLSXReader_fin($newFilePath);
						$sheetNames = $xlsx->getSheetNames();
						$data = $xlsx->getSheetData($sheetNames[1]);

						// start row write 2
						$numRow = 2;
						$total_rows = 0;

						$total_rows_actualy = 0;
						
						//get data for compare

						for ($row = 1; $row < count($data); $row++) {
							$rd = array();
							$flag = 0;
							$flag2 = 0;
							$flag_mail = 0;
							$string_error = '';
							$flag_contract_form = 0;

							$flag_id_commodity_code;
							$flag_id_warehouse_code;

							$value_cell_id = isset($data[$row][0]) ? $data[$row][0] : null ;
							$value_cell_commodity_id = isset($data[$row][1]) ? $data[$row][1] : null ;
							$value_cell_warehouse_id = isset($data[$row][2]) ? $data[$row][2] : '' ;
							$value_cell_inventory_manage_id = isset($data[$row][3]) ? $data[$row][3] : '' ;
							$value_cell_commodity_name = isset($data[$row][4]) ? $data[$row][4] : null ;
							$value_cell_serial_number = isset($data[$row][5]) ? $data[$row][5] : null ;

							$pattern = '#^[a-z][a-z0-9\._]{2,31}@[a-z0-9\-]{3,}(\.[a-z]{2,4}){1,2}$#';

							$reg_day = '#^(((1)[0-2]))(\/)\d{4}-(3)[0-1])(\/)(((0)[0-9])-[0-2][0-9]$#'; /*yyyy-mm-dd*/

							/*check null*/
							if (is_null($value_cell_commodity_id) == true) {
								$string_error .= app_lang('commodity_code') . app_lang('not_yet_entered');
								$flag = 1;
							}

							if (is_null($value_cell_warehouse_id) == true) {
								$string_error .= app_lang('warehouse_code') . app_lang('not_yet_entered');
								$flag = 1;
							}

							if (is_null($value_cell_serial_number) == true) {
								$string_error .= app_lang('wh_serial_number') . app_lang('not_yet_entered');
								$flag = 1;
							}


								//check commodity_code exist  (input: code or name item)
							if (is_null($value_cell_commodity_id) != true && $value_cell_commodity_id != '0' ) {
								/*case input  id*/
								$builder = db_connect('default');
								$builder = $builder->table(get_db_prefix().'items');
								$builder->where('id', trim($value_cell_commodity_id, " "));
								$item_value =  $builder->get()->getRow();

								if ($item_value) {
									/*get id commodity_type*/
									$flag_id_commodity_code = $item_value->id;
								} else {
									$string_error .= app_lang('commodity_code') . app_lang('does_not_exist');
									$flag2 = 1;
								}
							}

								//check warehouse exist  (input: id or name warehouse)
							if (is_null($value_cell_warehouse_id) != true && ( $value_cell_warehouse_id != '0')) {
								/*case input id*/
								$builder = db_connect('default');
								$builder = $builder->table(get_db_prefix().'warehouse');
								$builder->where('warehouse_id', trim($value_cell_warehouse_id, " "));
								$warehouse_value = $builder->get()->getRow();

								if ($warehouse_value) {
									/*get id unit_id*/
									$flag_id_warehouse_code = $warehouse_value->warehouse_id;

								} else {
									$string_error .= app_lang('_warehouse') . app_lang('does_not_exist');
									$flag2 = 1;
								}

							}

							if (($flag == 1) || ($flag2 == 1)) {
									//write error file
								$writer->writeSheetRow('Item Serial Numbers', [
									$value_cell_id,
									$value_cell_commodity_id,
									$value_cell_warehouse_id,
									$value_cell_inventory_manage_id,
									$value_cell_commodity_name,
									$value_cell_serial_number,
									$string_error,
								]);

								$numRow++;
								$total_rows_data_error++;
							}

							if (($flag == 0) && ($flag2 == 0)) {

								if((int)$value_cell_id == 0){
									$row_inserts[] = [
										'commodity_id' => $value_cell_commodity_id,
										'warehouse_id' => $value_cell_warehouse_id,
										'inventory_manage_id' => $value_cell_inventory_manage_id,
										'serial_number' => $value_cell_serial_number,
									];

								}else{
									$row_updates[] = [
										'id' => $value_cell_id,
										'commodity_id' => $value_cell_commodity_id,
										'warehouse_id' => $value_cell_warehouse_id,
										'inventory_manage_id' => $value_cell_inventory_manage_id,
										'serial_number' => $value_cell_serial_number,
									];
								}
								
							}

							$total_rows++;
							$total_rows_data++;

						}

						if(count($row_inserts) != 0){
							$builder = db_connect('default');
							$builder = $builder->table(get_db_prefix().'wh_inventory_serial_numbers');
							$affected_rows = $builder->insertBatch($row_inserts);
							if($affected_rows > 0){
								$total_rows_actualy += $affected_rows;
							}
						}

						if(count($row_updates) != 0){
							$builder = db_connect('default');
							$builder = $builder->table(get_db_prefix().'wh_inventory_serial_numbers');
							$affected_rows = $builder->updateBatch($row_updates, 'id');
							if($affected_rows > 0){
								$total_rows_actualy += $affected_rows;
							}
						}


						if ($total_rows_actualy != $total_rows) {
							$total_rows = $total_rows_actualy;
						}

						$rows = count($row_inserts) + count($row_updates);
						$total_rows = $total_rows;
						$data['total_rows_post'] = $rows;
						$total_row_success = $rows;
						$total_row_false = $total_rows - (int)$rows;
						$message = 'Not enought Serial number for importing';

						if(($total_rows_data_error > 0) || ($total_row_false != 0)){

							$filename = 'FILE_ERROR_IMPORT_SERIAL_NUMBERS' .$user_id.strtotime(date('Y-m-d H:i:s')). '.xlsx';
							$writer->writeToFile(str_replace($filename, WAREHOUSE_IMPORT_OPENING_STOCK.$filename, $filename));

							$filename = WAREHOUSE_IMPORT_OPENING_STOCK.$filename;
						}
						
						$import_result = true;
						delete_file_from_directory($newFilePath); //delete temp file
					}
					
				} else {
					$this->session->setFlashdata("error_message", app_lang("import_serial_number_failed"));
				}
			}

		}
		echo json_encode([
			'message' =>'Not enought Serial number for importing',
			'total_row_success' => $total_row_success,
			'total_row_false' => $total_rows_data_error,
			'total_rows' => $total_rows_data,
			'site_url' => base_url(),
			'staff_id' => $user_id,
			'total_rows_data_error' => $total_rows_data_error,
			'filename' => $filename,
		]);

	}

	/**
	 * table warranty period
	 * @return [type] 
	 */
	public function table_warranty_period()
	{
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'reports/warranty_period_reports/table_warranty_period'), $dataPost);
	}

	/**
	 * warranty period pdf
	 * @return [type] 
	 */
	public function warranty_period_pdf()
	{
		$data = $this->request->getPost();
		if (!$data) {
			redirect(admin_url('warehouse/report/manage_report?group=warranty_period_report'));
		}

		$this->load->model('clients_model');
		$this->load->model('currencies_model');

		$warranty_period = $this->warehouse_model->get_warranty_period_data($data);

		try {
			$pdf = $this->warehouse_model->warranty_period_pdf($warranty_period);

		} catch (Exception $e) {
			echo html_entity_decode($e->getMessage());
			die;
		}

		$type = 'D';
		ob_end_clean();

		if ($this->request->getGet('output_type')) {
			$type = $this->request->getGet('output_type');
		}

		if ($this->request->getGet('print')) {
			$type = 'I';
		}

		$pdf->Output(mb_strtoupper(slug_it('warranty_period_report').'_'.date('YmdHi')).'.pdf', $type);
	}

	/**
	 * inventory
	 * @return [type] 
	 */
	public function inventory()
	{
		$data['inventory_min_data'] = $this->warehouse_model->setting_get_inventory_min();
		return $this->template->rander("Warehouse\Views\includes\inventory", $data);

	}

	/**
	 * inventory_settings
	 * @return [type] 
	 */
	public function inventory_settings()
	{
		$data = [];
		return $this->template->rander("Warehouse\Views\includes\inventory_setting", $data);
	}

	/**
	 * colors
	 * @return [type] 
	 */
	public function approval_settings() {
		$data  = [];
		return $this->template->rander("Warehouse\Views\includes\approval_setting", $data);
	}
		
	/**
	 * list commodity type data
	 * @return [type] 
	 */
	public function list_approval_setting_data() {
		$this->access_only_team_members();

		$list_data = $this->warehouse_model->get_approval_setting();

		$result = array();
		foreach ($list_data as $data) {
			$result[] = $this->_make_approval_setting_row($data);
		}
		echo json_encode(array("data" => $result));
	}

	/**
	 * _make commodity type row
	 * @param  [type] $data 
	 * @return [type]       
	 */
	private function _make_approval_setting_row($data) {
		$related ='';
		if($data['related'] == 1){
			$related = app_lang('stock_import');
		}elseif($data['related'] == 2){
			$related = app_lang('stock_export');

		}elseif($data['related'] == 3){
			$related = app_lang('loss_adjustment');
		}elseif($data['related'] == 4){
			$related = app_lang('internal_delivery_note');
		}elseif($data['related'] == 5){
			$related = app_lang('wh_packing_list');
		}elseif($data['related'] == 6){
			$related = app_lang('inventory_receipt_inventory_delivery_returns_goods');
		}
		return array(
			$data['id'],
			nl2br($data['name']),
			$related,
			modal_anchor(get_uri("warehouse/approval_setting_modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => app_lang('edit_approval_setting'), "data-post-id" => $data['id']))
			. js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete'), "class" => "delete", "data-id" => $data['id'], "data-action-url" => get_uri("warehouse/delete_approval_setting/".$data['id']), "data-action" => "delete-confirmation"))
		);
	}

	/**
	 * commodity type modal form
	 * @return [type] 
	 */
	public function approval_setting_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));
		$data = [];
		$color_data = [];

		$id = $this->request->getPost('id');

		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$staffs = $this->Users_model->get_details($options)->getResultArray();
		$create_approval_setting_row_template = '';
		$create_approval_setting_row_template .= $this->warehouse_model->create_approval_setting_row_template($staffs);
		$data['key_number'] = 0;

		if($id && is_numeric($id)){
			$approval_setting = $this->warehouse_model->get_approval_setting($id);
			$data['approval_setting'] = $approval_setting;
			if($approval_setting && strlen($approval_setting->setting) > 0){
				$setting = json_decode($approval_setting->setting);
				$data['key_number'] = count($setting);
				$item_index = 1;
				foreach ($setting as $index => $value) {
					$name = 'newitems['.$item_index.']';
					$item_key  = $item_index;
					$approver = $value->approver;
					$staff = $value->staff;
					$action = $value->action;
					$create_approval_setting_row_template .= $this->warehouse_model->create_approval_setting_row_template($staffs, $name, $approver, $staff, $action, $item_key);
					$item_index++;
					
				}
			}
			// $create_approval_setting_row_template
		}else{
			$id = '';
		}
		$data['id'] = $id;

		$data['create_approval_setting_row_template'] = $create_approval_setting_row_template;

		return $this->template->view('Warehouse\Views\includes\modal_forms\approval_setting_modal', $data);
	}

	public function get_approval_setting_row_template()
	{
		$name = $this->request->getPost('name');
		$approver = $this->request->getPost('approver');
		$staff = $this->request->getPost('staff');
		$action = $this->request->getPost('action');
		$item_key = $this->request->getPost('item_key');
		$options = array(
			"status" => "active",
			"user_type" => "staff",
		);
		$staffs = $this->Users_model->get_details($options)->getResultArray();

		echo $this->warehouse_model->create_approval_setting_row_template($staffs, $name, $approver, $staff, $action, $item_key );
	}

	/**
	 * delete modal form
	 * @return [type] 
	 */
	public function delete_modal_form() {
		$this->access_only_team_members();
		// $this->validate_access_to_items();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		if($this->request->getPost('id')){
			$data['function'] = 'delete_commodity';
			$data['id'] = $this->request->getPost('id');
			return $this->template->view('Warehouse\Views\items\delete_modal_form', $data);
		}
	}

	/**
	 * delete goods receipt modal form
	 * @return [type] 
	 */
	public function delete_goods_receipt_modal_form() {
		$this->access_only_team_members();
		// $this->validate_access_to_items();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		if($this->request->getPost('id')){
			$data['function'] = 'delete_goods_receipt';
			$data['id'] = $this->request->getPost('id');
			return $this->template->view('Warehouse\Views\manage_goods_receipt\delete_modal_form', $data);
		}
	}

	/**
	 * wh_create_notification
	 * @param  array  $data 
	 * @return [type]       
	 */
	public function wh_create_notification($data = array()) {

		ini_set('max_execution_time', 300); //300 seconds 
		//validate notification request

		$event = '';
		$event = get_array_value($data, "event");

		$user_id = get_array_value($data, "user_id");
		$activity_log_id = get_array_value($data, "activity_log_id");

		$options = array(
			"project_id" => get_array_value($data, "project_id"),
			"task_id" => get_array_value($data, "task_id"),
			"project_comment_id" => get_array_value($data, "project_comment_id"),
			"ticket_id" => get_array_value($data, "ticket_id"),
			"ticket_comment_id" => get_array_value($data, "ticket_comment_id"),
			"project_file_id" => get_array_value($data, "project_file_id"),
			"leave_id" => get_array_value($data, "leave_id"),
			"post_id" => get_array_value($data, "post_id"),
			"to_user_id" => get_array_value($data, "to_user_id"),
			"activity_log_id" => get_array_value($data, "activity_log_id"),
			"client_id" => get_array_value($data, "client_id"),
			"invoice_payment_id" => get_array_value($data, "invoice_payment_id"),
			"invoice_id" => get_array_value($data, "invoice_id"),
			"estimate_id" => get_array_value($data, "estimate_id"),
			"order_id" => get_array_value($data, "order_id"),
			"estimate_request_id" => get_array_value($data, "estimate_request_id"),
			"actual_message_id" => get_array_value($data, "actual_message_id"),
			"parent_message_id" => get_array_value($data, "parent_message_id"),
			"event_id" => get_array_value($data, "event_id"),
			"announcement_id" => get_array_value($data, "announcement_id"),
			"exclude_ticket_creator" => get_array_value($data, "exclude_ticket_creator"),
			"notification_multiple_tasks" => get_array_value($data, "notification_multiple_tasks"),
			"contract_id" => get_array_value($data, "contract_id"),
			"lead_id" => get_array_value($data, "lead_id"),
			"proposal_id" => get_array_value($data, "proposal_id"),
			"estimate_comment_id" => get_array_value($data, "estimate_comment_id"),

			"inventory_goods_receiving_id" => get_array_value($data, "inventory_goods_receiving_id"),
			"inventory_goods_delivery_id" => get_array_value($data, "inventory_goods_delivery_id"),
			"packing_list_id" => get_array_value($data, "packing_list_id"),
			"internal_delivery_note_id" => get_array_value($data, "internal_delivery_note_id"),
			"loss_adjustment_is" => get_array_value($data, "loss_adjustment_is"),
			"receiving_exporting_return_order_id" => get_array_value($data, "receiving_exporting_return_order_id"),

		);

		//get data from plugin by persing 'plugin_'
		foreach ($data as $key => $value) {
			if (strpos($key, 'plugin_') !== false) {
				$options[$key] = $value;
			}
		}

		$this->warehouse_model->wh_create_notification($event, $user_id, $options, $data['to_user_id']);
	}

	/**
	 * print goods receipt
	 * @param  integer $goods_receipt_id 
	 * @return [type]                    
	 */
	function print_goods_receipt($goods_receipt_id = 0) {
		if ($goods_receipt_id) {
			validate_numeric_value($goods_receipt_id);
			/*Making data*/
			$view_data = [];
			$view_data['goods_receipt'] = $this->warehouse_model->get_goods_receipt($goods_receipt_id);
			$view_data['goods_receipt_details'] = $this->warehouse_model->get_goods_receipt_detail($goods_receipt_id);
			$view_data['tax_data'] = $this->warehouse_model->get_html_tax_receip($goods_receipt_id);

			$view_data['goods_receipt_preview'] = prepare_goods_receipt_pdf($view_data, "html");

			echo json_encode(array("success" => true, "print_view" => $this->template->view("Warehouse\Views\manage_goods_receipt\print_goods_receipt", $view_data)));
		} else {
			echo json_encode(array("success" => false, app_lang('error_occurred')));
		}
	}

	/**
	 * download pdf
	 * @param  integer $goods_receipt_id 
	 * @param  string  $mode             
	 * @return [type]                    
	 */
	function download_goods_receipt_pdf($goods_receipt_id = 0, $mode = "download") {
		if ($goods_receipt_id) {
			validate_numeric_value($goods_receipt_id);

			/*Making data*/
			$goods_receipt_data = [];
			$goods_receipt_data['goods_receipt'] = $this->warehouse_model->get_goods_receipt($goods_receipt_id);
			$goods_receipt_data['goods_receipt_details'] = $this->warehouse_model->get_goods_receipt_detail($goods_receipt_id);
			$goods_receipt_data['tax_data'] = $this->warehouse_model->get_html_tax_receip($goods_receipt_id);
			
			prepare_goods_receipt_pdf($goods_receipt_data, $mode);
		} else {
			show_404();
		}
	}
	
		/**
	 * print goods receipt
	 * @param  integer $goods_receipt_id 
	 * @return [type]                    
	 */
	function print_internal_delivery($internal_delivery_id = 0) {
		if ($internal_delivery_id) {
			validate_numeric_value($internal_delivery_id);
			/*Making data*/
			$view_data = [];
			$view_data['internal_delivery'] = $this->warehouse_model->get_internal_delivery($internal_delivery_id);
			$view_data['internal_delivery_details'] = $this->warehouse_model->get_internal_delivery_detail($internal_delivery_id);

			$view_data['internal_delivery_preview'] = prepare_internal_delivery_pdf($view_data, "html");

			echo json_encode(array("success" => true, "print_view" => $this->template->view("Warehouse\Views\manage_internal_delivery\print_internal_delivery", $view_data)));
		} else {
			echo json_encode(array("success" => false, app_lang('error_occurred')));
		}
	}

	/**
	 * download pdf
	 * @param  integer $internal_delivery_id 
	 * @param  string  $mode             
	 * @return [type]                    
	 */
	function download_internal_delivery_pdf($internal_delivery_id = 0, $mode = "download") {
		if ($internal_delivery_id) {
			validate_numeric_value($internal_delivery_id);

			/*Making data*/
			$internal_delivery_data = [];
			$internal_delivery_data['internal_delivery'] = $this->warehouse_model->get_internal_delivery($internal_delivery_id);
			$internal_delivery_data['internal_delivery_details'] = $this->warehouse_model->get_internal_delivery_detail($internal_delivery_id);
			
			prepare_internal_delivery_pdf($internal_delivery_data, $mode);
		} else {
			show_404();
		}
	}

	/**
	 * table_loss_adjustment
	 * @return [type] 
	 */
	public function table_loss_adjustment() {
		$dataPost = $this->request->getPost();
		$this->warehouse_model->get_table_data(module_views_path('Warehouse', 'loss_adjustment/table_loss_adjustment'), $dataPost);
	}

	/**
	 * delete loss adjustment modal form
	 * @return [type] 
	 */
	public function delete_loss_adjustment_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		if($this->request->getPost('id')){
			$data['function'] = 'delete_loss_adjustment';
			$data['id'] = $this->request->getPost('id');
			return $this->template->view('Warehouse\Views\manage_goods_receipt\delete_modal_form', $data);
		}
	}

	/**
	 * get serial number
	 * @return [type] 
	 */
	public function get_serial_number()
	{
		$table_serial_number = '';
		$data = $this->request->getPost();
		$commodity_name = $data['commodity_name'];

		$arr_serial_numbers = [];
		$arr_list_temporaty_serial_number = [];

		$list_serial_numbers = $this->warehouse_model->get_list_temporaty_serial_numbers($data['commodity_id'], $data['warehouse_id']);

		$list_temporaty_serial_numbers = $this->warehouse_model->get_list_temporaty_serial_numbers($data['commodity_id'], $data['warehouse_id'], $data['quantity']);

		foreach ($list_temporaty_serial_numbers as $list_temporaty_serial_number) {
			$arr_list_temporaty_serial_number[$list_temporaty_serial_number['serial_number']] = $list_temporaty_serial_number['serial_number'];
		}

		foreach ($list_serial_numbers as $list_serial_number) {
			if(!isset($arr_list_temporaty_serial_number[$list_serial_number['serial_number']])){
				$arr_serial_numbers[$list_serial_number['serial_number']] = [
					'name' => $list_serial_number['serial_number'],
				];
			}
		}

		foreach ($list_temporaty_serial_numbers as $index => $serial_number) {

			$arr_serial_numbers = array_merge(array($serial_number['serial_number'] => array('name' => $serial_number['serial_number']) ), $arr_serial_numbers);

			$table_serial_number .= '<tr class="sortable serial_number_item">';
			$table_serial_number .= '<td class="">' . $commodity_name . '</td>';
			$table_serial_number .= '<td class="serial_number">' . render_select1('serial_number['.$index.']', $arr_serial_numbers,array('name','name'),'',$serial_number['serial_number'],[], ["data-none-selected-text" => _l('wh_serial_number')], 'no-margin', '', false) . '</td>';
			$table_serial_number .= '</tr>';


			if(isset($arr_serial_numbers[$serial_number['serial_number']])){
				unset($arr_serial_numbers[$serial_number['serial_number']]);
			}
		}

		echo json_encode([
			'table_serial_number' => $table_serial_number,
			'status' => strlen($table_serial_number) > 0 ? true : false,
		]);
	}

	/**
	 * load serial number modal
	 * @return [type] 
	 */
	public function load_serial_number_modal()
	{
		
		$table_serial_number = $this->request->getPost('table_serial_number');
		$data = [];
		$data['title'] = _l('wh_select_the_serial_number');
		$data['table_serial_number'] = $table_serial_number;

		return $this->template->view('Warehouse\Views\manage_goods_delivery\serial_modal', $data);

	}

	/**
	 * load change serial number modal
	 * @return [type] 
	 */
	public function load_change_serial_number_modal()
	{
		
		$table_serial_number = $this->request->getPost('table_serial_number');
		$data = [];
		$data['title'] = _l('wh_select_the_serial_number');
		$data['table_serial_number'] = $table_serial_number;
		$data['name_commodity_name'] = $this->request->getPost('name_commodity_name');
		$data['name_serial_number'] = $this->request->getPost('name_serial_number');

		return $this->template->view('Warehouse\Views\manage_goods_delivery\change_serial_modal', $data);
	}

	public function get_serial_number_for_change_modal()
	{
		$table_serial_number = '';
		$data = $this->request->getPost();
		$commodity_name = $data['commodity_name'];
		$_serial_number = $data['serial_number'];
		if(isset($data['serial_number_array'])){
			$serial_number_array  = $data['serial_number_array'];
		}else{
			$serial_number_array  = [];
		}


		$arr_serial_numbers = [];
		$list_serial_numbers = $this->warehouse_model->get_list_temporaty_serial_numbers($data['commodity_id'], $data['warehouse_id'], '', $serial_number_array);


		foreach ($list_serial_numbers as $list_serial_number) {
			$arr_serial_numbers[$list_serial_number['serial_number']] = [
				'name' => $list_serial_number['serial_number'],
			];
		}

		$arr_serial_numbers = array_merge(array($_serial_number => array('name' => $_serial_number) ), $arr_serial_numbers);

		$table_serial_number .= '<tr class="sortable serial_number_item">';
		$table_serial_number .= '<td class="">' . $commodity_name . '</td>';
		$table_serial_number .= '<td class="serial_number">' . render_select('change_serial_number', $arr_serial_numbers,array('name','name'),'',$_serial_number,[], ["data-none-selected-text" => _l('wh_serial_number')], 'no-margin', '', false) . '</td>';
		$table_serial_number .= '</tr>';


		if(isset($arr_serial_numbers[$_serial_number])){
			unset($arr_serial_numbers[$_serial_number]);
		}

		echo json_encode([
			'table_serial_number' => $table_serial_number,
			'status' => strlen($table_serial_number) > 0 ? true : false,
		]);
	}

	/**
	 * delete goods receipt modal form
	 * @return [type] 
	 */
	public function delete_goods_delivery_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		if($this->request->getPost('id')){
			$data['function'] = 'delete_goods_delivery';
			$data['id'] = $this->request->getPost('id');
			return $this->template->view('Warehouse\Views\manage_goods_receipt\delete_modal_form', $data);
		}
	}

	/**
	 * print goods receipt
	 * @param  integer $goods_receipt_id 
	 * @return [type]                    
	 */
	function print_goods_delivery($goods_delivery_id = 0) {
		if ($goods_delivery_id) {
			validate_numeric_value($goods_delivery_id);
			/*Making data*/
			$view_data = [];
			$view_data['goods_delivery'] = $this->warehouse_model->get_goods_delivery($goods_delivery_id);
			$view_data['goods_delivery_details'] = $this->warehouse_model->get_goods_delivery_detail($goods_delivery_id);
			$view_data['tax_data'] = $this->warehouse_model->get_html_tax_delivery($goods_delivery_id);
			$client_options = [
				'id' => $view_data['goods_delivery']->customer_code,
			];
			$view_data['client_info'] = $this->Clients_model->get_details($client_options)->getRow();

			$view_data['goods_delivery_preview'] = prepare_goods_delivery_pdf($view_data, "html");

			echo json_encode(array("success" => true, "print_view" => $this->template->view("Warehouse\Views\manage_goods_delivery\print_goods_delivery", $view_data)));
		} else {
			echo json_encode(array("success" => false, app_lang('error_occurred')));
		}
	}

	/**
	 * download pdf
	 * @param  integer $goods_delivery_id 
	 * @param  string  $mode             
	 * @return [type]                    
	 */
	function download_goods_delivery_pdf($goods_delivery_id = 0, $mode = "download") {
		if ($goods_delivery_id) {
			validate_numeric_value($goods_delivery_id);

			/*Making data*/
			$goods_delivery_data = [];
			$goods_delivery_data['goods_delivery'] = $this->warehouse_model->get_goods_delivery($goods_delivery_id);
			$goods_delivery_data['goods_delivery_details'] = $this->warehouse_model->get_goods_delivery_detail($goods_delivery_id);
			$goods_delivery_data['tax_data'] = $this->warehouse_model->get_html_tax_delivery($goods_delivery_id);
			$client_options = [
				'id' => $goods_delivery_data['goods_delivery']->customer_code,
			];

			$goods_delivery_data['client_info'] = $this->Clients_model->get_details($client_options)->getRow();

			prepare_goods_delivery_pdf($goods_delivery_data, $mode);
		} else {
			show_404();
		}
	}

	/**
	 * delete packing list modal form
	 * @return [type] 
	 */
	public function delete_packing_list_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		if($this->request->getPost('id')){
			$data['function'] = 'delete_packing_list';
			$data['id'] = $this->request->getPost('id');
			return $this->template->view('Warehouse\Views\manage_goods_receipt\delete_modal_form', $data);
		}
	}

	/**
	 * print goods receipt
	 * @param  integer $goods_receipt_id 
	 * @return [type]                    
	 */
	function print_packing_list($packing_list_id = 0) {
		if ($packing_list_id) {
			validate_numeric_value($packing_list_id);
			/*Making data*/
			$view_data = [];
			$view_data['packing_list'] = $this->warehouse_model->get_packing_list($packing_list_id);
			$view_data['packing_list_details'] = $this->warehouse_model->get_packing_list_detail($packing_list_id);
			$view_data['tax_data'] = $this->warehouse_model->get_html_tax_packing_list($packing_list_id);
			$client_options = [
				'id' => $view_data['packing_list']->clientid,
			];
			$view_data['client_info'] = $this->Clients_model->get_details($client_options)->getRow();

			$view_data['packing_list_preview'] = prepare_packing_list_pdf($view_data, "html");

			echo json_encode(array("success" => true, "print_view" => $this->template->view("Warehouse\Views\packing_lists\print_packing_list", $view_data)));
		} else {
			echo json_encode(array("success" => false, app_lang('error_occurred')));
		}
	}

	/**
	 * download pdf
	 * @param  integer $packing_list_id 
	 * @param  string  $mode             
	 * @return [type]                    
	 */
	function download_packing_list_pdf($packing_list_id = 0, $mode = "download") {
		if ($packing_list_id) {
			validate_numeric_value($packing_list_id);

			/*Making data*/
			$packing_list_data = [];
			$packing_list_data['packing_list'] = $this->warehouse_model->get_packing_list($packing_list_id);
			$packing_list_data['packing_list_details'] = $this->warehouse_model->get_packing_list_detail($packing_list_id);
			$packing_list_data['tax_data'] = $this->warehouse_model->get_html_tax_packing_list($packing_list_id);
			$client_options = [
				'id' => $packing_list_data['packing_list']->clientid,
			];

			$packing_list_data['client_info'] = $this->Clients_model->get_details($client_options)->getRow();

			prepare_packing_list_pdf($packing_list_data, $mode);
		} else {
			show_404();
		}
	}

		/**
	 * print goods receipt
	 * @param  integer $goods_receipt_id 
	 * @return [type]                    
	 */
	function print_order_return($order_return_id = 0) {
		if ($order_return_id) {
			validate_numeric_value($order_return_id);
			/*Making data*/
			$view_data = [];
			$view_data['order_return'] = $this->warehouse_model->get_order_return($order_return_id);
			$view_data['order_return_details'] = $this->warehouse_model->get_order_return_detail($order_return_id);
			$view_data['tax_data'] = $this->warehouse_model->get_html_tax_order_return($order_return_id);

			if($view_data['order_return']->company_id != null && is_numeric($view_data['order_return']->company_id) && $view_data['order_return']->company_id != 0){
				$client_options = [
					'id' => $view_data['order_return']->company_id,
				];
				$view_data['client_info'] = $this->Clients_model->get_details($client_options)->getRow();
			}

			$view_data['order_return_preview'] = prepare_order_return_pdf($view_data, "html");

			echo json_encode(array("success" => true, "print_view" => $this->template->view("Warehouse\Views\order_returns\print_order_return", $view_data)));
		} else {
			echo json_encode(array("success" => false, app_lang('error_occurred')));
		}
	}

	/**
	 * download pdf
	 * @param  integer $order_return_id 
	 * @param  string  $mode             
	 * @return [type]                    
	 */
	function download_order_return_pdf($order_return_id = 0, $mode = "download") {
		if ($order_return_id) {
			validate_numeric_value($order_return_id);

			/*Making data*/
			$order_return_data = [];
			$order_return_data['order_return'] = $this->warehouse_model->get_order_return($order_return_id);
			$order_return_data['order_return_details'] = $this->warehouse_model->get_order_return_detail($order_return_id);
			$order_return_data['tax_data'] = $this->warehouse_model->get_html_tax_order_return($order_return_id);

			if($order_return_data['order_return']->company_id != null && is_numeric($order_return_data['order_return']->company_id) && $order_return_data['order_return']->company_id != 0){
				$client_options = [
					'id' => $order_return_data['order_return']->company_id,
				];
				$order_return_data['client_info'] = $this->Clients_model->get_details($client_options)->getRow();
			}

			prepare_order_return_pdf($order_return_data, $mode);
		} else {
			show_404();
		}
	}

	/**
	 * delete order return modal form
	 * @return [type] 
	 */
	public function delete_order_return_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		if($this->request->getPost('id')){
			$data['function'] = 'delete_order_return';
			$data['id'] = $this->request->getPost('id');
			return $this->template->view('Warehouse\Views\manage_goods_receipt\delete_modal_form', $data);
		}
	}

	/**
	 * download_barcode
	 * @return [type] 
	 */
	function download_barcode() {
		$mode = "download";
		$select_item = $this->request->getPost('select_item');
		$item_select_print_barcode = $this->request->getPost('item_select_print_barcode');

		/*Making data*/
		$goods_receipt_data = [];
		$goods_receipt_data['select_item'] = (int)$select_item;
		$goods_receipt_data['item_select_print_barcode'] = $item_select_print_barcode;

		prepare_barcode_pdf($goods_receipt_data, $mode);
	}

	/**
	 * print_barcode
	 * @return [type] 
	 */
	function print_barcode() {
		$select_item = $this->request->getPost('select_item');
		$item_select_print_barcode = $this->request->getPost('item_select_print_barcode');

		/*Making data*/
		$view_data = [];
		$view_data['select_item'] = (int)$select_item;
		$view_data['item_select_print_barcode'] = $item_select_print_barcode;

		$view_data['barcode_preview'] = prepare_barcode_pdf($view_data, "html");

		echo json_encode(array("success" => true, "print_view" => $this->template->view("Warehouse\Views\items\print_barcode", $view_data)));
		
	}

	/**
	 * stock summary report
	 * @return [type] 
	 */
	public function stock_summary_report() {
		$data['title'] = app_lang('stock_summary_report');
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['period_to_date'] = '';
		$data['period_status_id'] = [1,2];
		$client_options = array(
			"deleted" => 0,
		);
		$data['clients'] = $this->Clients_model->get_details($client_options)->getResultArray();

		return $this->template->rander("Warehouse\Views\\reports\stock_summary_reports\stock_summary_report", $data);
	}

	/**
	 * delete internal delivery modal form
	 * @return [type] 
	 */
	public function delete_internal_delivery_modal_form() {
		$this->access_only_team_members();

		$this->validate_submitted_data(array(
			"id" => "numeric"
		));

		if($this->request->getPost('id')){
			$data['function'] = 'delete_internal_delivery';
			$data['id'] = $this->request->getPost('id');
			return $this->template->view('Warehouse\Views\manage_goods_receipt\delete_modal_form', $data);
		}
	}

	/**
	 * warehouse fee return order
	 * @return [type] 
	 */
	public function warehouse_fee_return_order(){
		$data = $this->request->getPost();

		if (!has_permission('warehouse', '', 'edit') && !is_admin()) {
			$success = false;
			$message = _l('Not permission edit');

			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}

		if($data != 'null'){
			$value = $this->warehouse_model->update_fee_return_order($data);
			if($value){
				$success = true;
				$message = _l('updated_successfully');
			}else{
				$success = false;
				$message = _l('updated_false');
			}
			echo json_encode([
				'message' => $message,
				'success' => $success,
			]);
			die;
		}
	}

	/**
	* stock summary report
	* @return [type] 
	*/
	public function inventory_analytics() {
		$data['title'] = app_lang('stock_summary_report');
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['period_to_date'] = '';
		$data['period_status_id'] = [1,2];
		$client_options = array(
			"deleted" => 0,
		);
		$data['clients'] = $this->Clients_model->get_details($client_options)->getResultArray();

		return $this->template->rander("Warehouse\Views\\reports\inventory_analytics\manage", $data);
	}

	/**
	 * warranty period reports
	 * @return [type] 
	 */
	public function warranty_period_reports() {
		$data['title'] = app_lang('warranty_period_report');
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['period_to_date'] = '';
		$data['period_status_id'] = [1,2];
		$client_options = array(
			"deleted" => 0,
		);
		$data['clients'] = $this->Clients_model->get_details($client_options)->getResultArray();

		return $this->template->rander("Warehouse\Views\\reports\warranty_period_reports\warranty_period_report", $data);
	}

	/**
	 * download warranty period pdf
	 * @param  string $mode 
	 * @return [type]       
	 */
	public function download_warranty_period_pdf($mode = "view") {
		$data = $this->request->getPost();

		$warranty_period = $this->warehouse_model->get_warranty_period_data($data);

		/*Making data*/
		$warranty_period_data = [];
		$warranty_period_data['warranty_period'] = $warranty_period;

		prepare_warranty_period_pdf($warranty_period_data, $mode);
	}

	/**
	 * inventory valuation reports
	 * @return [type] 
	 */
	public function inventory_valuation_reports() {
		$data['title'] = app_lang('warranty_period_report');
		$data['ajaxItems'] = false;
		if ($this->warehouse_model->count_all_items() <= ajax_on_total_items()) {
			$data['items'] = $this->warehouse_model->wh_get_grouped('', true);
		} else {
			$data['items']     = [];
			$data['ajaxItems'] = true;
		}
		$data['warehouse_filter'] = $this->warehouse_model->get_warehouse();
		$data['period_to_date'] = '';
		$data['period_status_id'] = [1,2];
		$client_options = array(
			"deleted" => 0,
		);
		$data['clients'] = $this->Clients_model->get_details($client_options)->getResultArray();

		return $this->template->rander("Warehouse\Views\\reports\inventory_valuation_reports\inventory_valuation_report", $data);
	}

/*end*/
}
