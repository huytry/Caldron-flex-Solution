<?php

use App\Controllers\Security_Controller;
use App\Controllers\App_Controller;
use CodeIgniter\HTTP\IncomingRequest;


/**
 * Render table used for datatables
 * @param  array   $headings
 * @param  string  $class              table class / add prefix eq.table-$class
 * @param  array   $additional_classes additional table classes
 * @param  array   $table_attributes   table attributes
 * @param  boolean $tfoot              includes blank tfoot
 * @return string
 */
if (!function_exists('render_datatable1')) {
	function render_datatable1($headings = [], $class = '', $additional_classes = [''], $table_attributes = [])
	{
		$_additional_classes = '';
		$_table_attributes   = ' ';
		if (count($additional_classes) > 0) {
			$_additional_classes = ' ' . implode(' ', $additional_classes);
		}

		$browser = '';
		$IEfix   = '';
		if ($browser == 'Internet Explorer') {
			$IEfix = 'ie-dt-fix';
		}

		foreach ($table_attributes as $key => $val) {
			$_table_attributes .= $key . '=' . '"' . $val . '" ';
		}

		$table = '<div class="' . $IEfix . '"><table' . $_table_attributes . 'class="dt-table-loading table table-' . $class . '' . $_additional_classes . '">';
		$table .= '<thead>';
		$table .= '<tr>';
		foreach ($headings as $heading) {
			if (!is_array($heading)) {
				$table .= '<th>' . $heading . '</th>';
			} else {
				$th_attrs = '';
				if (isset($heading['th_attrs'])) {
					foreach ($heading['th_attrs'] as $key => $val) {
						$th_attrs .= $key . '=' . '"' . $val . '" ';
					}
				}
				$th_attrs = ($th_attrs != '' ? ' ' . $th_attrs : $th_attrs);
				$table .= '<th' . $th_attrs . '>' . $heading['name'] . '</th>';
			}
		}
		$table .= '</tr>';
		$table .= '</thead>';
		$table .= '<tbody></tbody>';
		$table .= '</table></div>';
		echo            $table;
	}
}


/**
 * Get table last order
 * @param  string $tableID table unique identifier id
 * @return string
 */
if (!function_exists('get_table_last_order')) {

	function get_table_last_order($tableID)
	{
		return htmlentities(get_staff_meta(get_staff_user_id(), $tableID . '-table-last-order'));
	}
}

/**
 * General function for all datatables, performs search,additional select,join,where,orders
 * @param  array $aColumns           table columns
 * @param  mixed $sIndexColumn       main column in table for bettter performing
 * @param  string $sTable            table name
 * @param  array  $join              join other tables
 * @param  array  $where             perform where in query
 * @param  array  $additionalSelect  select additional fields
 * @param  string $sGroupBy group results
 * @return array
 */
if (!function_exists('data_tables_init1')) {

	function data_tables_init1($aColumns, $sIndexColumn, $sTable, $join = [], $where = [], $additionalSelect = [], $sGroupBy = '', $searchAs = [], $dataPost = [])
	{
		$Warehouse_model = model("Warehouse\Models\Warehouse_model");;

		$__post      =  $dataPost;
		$havingCount = '';
	/*
	 * Paging
	 */
	$sLimit = '';
	if ((is_numeric($dataPost['start'])) && $dataPost['length'] != '-1') {
		$sLimit = 'LIMIT ' . intval($dataPost['start']) . ', ' . intval($dataPost['length']);
	}
	$_aColumns = [];
	foreach ($aColumns as $column) {
		// if found only one dot
		if (substr_count($column, '.') == 1 && strpos($column, ' as ') === false) {
			$_column = explode('.', $column);
			if (isset($_column[1])) {
				if (startsWith1($_column[0], db_prefix())) {
					$_prefix = prefixed_table_fields_wildcard($_column[0], $_column[0], $_column[1]);
					array_push($_aColumns, $_prefix);
				} else {
					array_push($_aColumns, $column);
				}
			} else {
				array_push($_aColumns, $_column[0]);
			}
		} else {
			array_push($_aColumns, $column);
		}
	}

	/*
	 * Ordering
	 */
	$nullColumnsAsLast = [];

	$sOrder = '';
	if ($dataPost['order']) {
		$sOrder = 'ORDER BY ';
		foreach ($dataPost['order'] as $key => $val) {
			$columnName = $aColumns[intval($__post['order'][$key]['column'])];
			$dir        = strtoupper($__post['order'][$key]['dir']);

			if (strpos($columnName, ' as ') !== false) {
				$columnName = strbefore1($columnName, ' as');
			}

			// first checking is for eq tablename.column name
			// second checking there is already prefixed table name in the column name
			// this will work on the first table sorting - checked by the draw parameters
			// in future sorting user must sort like he want and the duedates won't be always last
			if ((in_array($sTable . '.' . $columnName, $nullColumnsAsLast)
				|| in_array($columnName, $nullColumnsAsLast))
		) {
				$sOrder .= $columnName . ' IS NULL ' . $dir . ', ' . $columnName;
		} else {
			$sOrder .= app_hooks()->apply_filters('datatables_query_order_column', $columnName, $sTable);
		}
		$sOrder .= ' ' . $dir . ', ';
	}
	if (trim($sOrder) == 'ORDER BY') {
		$sOrder = '';
	}
	$sOrder = rtrim($sOrder, ', ');

}
	/*
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = '';
	if ((isset($__post['search'])) && $__post['search']['value'] != '') {
		$search_value = $__post['search']['value'];
		$search_value = trim($search_value);

		$sWhere             = 'WHERE (';
		$sMatchCustomFields = [];
		// Not working, do not use it
		$useMatchForCustomFieldsTableSearch = app_hooks()->apply_filters('use_match_for_custom_fields_table_search', 'false');

		for ($i = 0; $i < count($aColumns); $i++) {
			$columnName = $aColumns[$i];
			if (strpos($columnName, ' as ') !== false) {
				$columnName = strbefore1($columnName, ' as');
			}

			if (stripos($columnName, 'AVG(') !== false || stripos($columnName, 'SUM(') !== false) {
			} else {
				if (($__post['columns'][$i]) && $__post['columns'][$i]['searchable'] == 'true') {
					if (isset($searchAs[$i])) {
						$columnName = $searchAs[$i];
					}
					// Custom fields values are FULLTEXT and should be searched with MATCH
					// Not working ATM
					if ($useMatchForCustomFieldsTableSearch === 'true' && startsWith1($columnName, 'ctable_')) {
						$sMatchCustomFields[] = $columnName;
					} else {
						$sWhere .= 'convert(' . $columnName . ' USING utf8)' . " LIKE '%" . escape_str($search_value) . "%' OR ";
					}
				}
			}
		}

		if (count($sMatchCustomFields) > 0) {
			$s = escape_str($search_value);
			foreach ($sMatchCustomFields as $matchCustomField) {
				$sWhere .= "MATCH ({$matchCustomField}) AGAINST (CONVERT(BINARY('{$s}') USING utf8)) OR ";
			}
		}

		if (count($additionalSelect) > 0) {
			foreach ($additionalSelect as $searchAdditionalField) {
				if (strpos($searchAdditionalField, ' as ') !== false) {
					$searchAdditionalField = strbefore1($searchAdditionalField, ' as');
				}
				if (stripos($columnName, 'AVG(') !== false || stripos($columnName, 'SUM(') !== false) {
				} else {
					// Use index
					$sWhere .= 'convert(' . $searchAdditionalField . ' USING utf8)' . " LIKE '%" . escape_str($search_value) . "%' OR ";
				}
			}
		}
		$sWhere = substr_replace($sWhere, '', -3);
		$sWhere .= ')';
	} else {
		// Check for custom filtering
		$searchFound = 0;
		$sWhere      = 'WHERE (';
		for ($i = 0; $i < count($aColumns); $i++) {
			if (($__post['columns'][$i]) && $__post['columns'][$i]['searchable'] == 'true') {
				$search_value = $__post['columns'][$i]['search']['value'];

				$columnName = $aColumns[$i];
				if (strpos($columnName, ' as ') !== false) {
					$columnName = strbefore1($columnName, ' as');
				}
				if ($search_value != '') {
					$sWhere .= 'convert(' . $columnName . ' USING utf8)' . " LIKE '%" . escape_str($search_value) . "%' OR ";
					if (count($additionalSelect) > 0) {
						foreach ($additionalSelect as $searchAdditionalField) {
							$sWhere .= 'convert(' . $searchAdditionalField . ' USING utf8)' . " LIKE '" . escape_str($search_value) . "%' OR ";
						}
					}
					$searchFound++;
				}
			}
		}
		if ($searchFound > 0) {
			$sWhere = substr_replace($sWhere, '', -3);
			$sWhere .= ')';
		} else {
			$sWhere = '';
		}
	}

	/*
	 * SQL queries
	 * Get data to display
	 */
	$_additionalSelect = '';
	if (count($additionalSelect) > 0) {
		$_additionalSelect = ',' . implode(',', $additionalSelect);
	}
	$where = implode(' ', $where);
	if ($sWhere == '') {
		$where = trim($where);
		if (startsWith1($where, 'AND') || startsWith1($where, 'OR')) {
			if (startsWith1($where, 'OR')) {
				$where = substr($where, 2);
			} else {
				$where = substr($where, 3);
			}
			$where = 'WHERE ' . $where;
		}
	}

	$join = implode(' ', $join);

	$sQuery = '
	SELECT SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $_aColumns)) . ' ' . $_additionalSelect . "
	FROM $sTable
	" . $join . "
	$sWhere
	" . $where . "
	$sGroupBy
	$sOrder
	$sLimit
	";

	$rResult = $Warehouse_model->warehouse_run_query($sQuery);

	$rResult = app_hooks()->apply_filters('datatables_sql_query_results', $rResult, [
		'table' => $sTable,
		'limit' => $sLimit,
		'order' => $sOrder,
	]);

	/* Data set length after filtering */
	$sQuery = '
	SELECT FOUND_ROWS()
	';
	$_query         = $Warehouse_model->warehouse_run_query($sQuery);
	$iFilteredTotal = $_query[0]['FOUND_ROWS()'];
	if (startsWith1($where, 'AND')) {
		$where = 'WHERE ' . substr($where, 3);
	}
	/* Total data set length */
	$sQuery = '
	SELECT COUNT(' . $sTable . '.' . $sIndexColumn . ")
	FROM $sTable " . $join . ' ' . $where;

	$_query = $Warehouse_model->warehouse_run_query($sQuery);
	$iTotal = $_query[0]['COUNT(' . $sTable . '.' . $sIndexColumn . ')'];
	/*
	 * Output
	 */
	$output = [
		'draw'                 => $__post['draw'] ? intval($__post['draw']) : 0,
		'iTotalRecords'        => $iTotal,
		'iTotalDisplayRecords' => $iFilteredTotal,
		'aaData'               => [],
	];

	return [
		'rResult' => $rResult,
		'output'  => $output,
	];
}
}