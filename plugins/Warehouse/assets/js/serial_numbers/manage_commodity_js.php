<script>
	$(document).ready(function () {
		$(".select2").select2();
	});

	var hidden_columns = [2,6];
	var sub_group_value ='';

	(function($) {
		"use strict";

		var ProposalServerParams = {
			"warehouse_ft": "[name='warehouse_filter[]']",
			"commodity_ft": "[name='commodity_filter[]']",
			"show_items_filter": "[name='show_items_filter[]']",
		};

		var table_commodity_list = $('table.table-table_commodity_list');
		var _table_api = initDataTable(table_commodity_list, "<?php  echo get_uri('warehouse/serial_number_table_commodity_list') ?>", [0], [0], ProposalServerParams,  [1, 'desc']);
		$.each(ProposalServerParams, function(i, obj) {
			$('select' + obj).on('change', function() {  
				table_commodity_list.DataTable().ajax.reload();
			});
		});

		$("body").on('change', '#mass_select_all', function () {
			var to, rows, checked;
			to = $(this).data('to-table');

			rows = $('.table-' + to).find('tbody tr');
			checked = $(this).prop('checked');
			$.each(rows, function () {
				$($(this).find('td').eq(0)).find('input').prop('checked', checked);
			});
		});

	})(jQuery); 



	function export_item(){
		"use strict";
		var ids = [];
		var data = {};

		data.mass_delete = true;
		data.rel_type = 'commodity_list';

		var rows = $('#table-table_commodity_list').find('tbody tr');
		$.each(rows, function() {
			var checkbox = $($(this).find('td').eq(0)).find('input');
			if (checkbox.prop('checked') === true) {
				ids.push(checkbox.val());
			}
		});

		data.ids = ids;
		if(ids.length > 0){
			$(event).addClass('disabled');
			setTimeout(function() {
				$.post("<?php  echo get_uri('warehouse/warehouse_export_item_serial_number_checked') ?>", data).done(function(response) {
					response = JSON.parse(response);
					if(response.success == true){
						appAlert.success("<?php echo _l('create_export_file_success') ?>");

						$('#dowload_items').removeClass('hide');

						$('#dowload_items').attr({target: '_blank', 
							href  : response.base_url+"\\"+response.filename});

					}else{
						appAlert.warning("<?php echo _l('create_export_file_false') ?>");

					}
				}).fail(function(data) {

				});
			}, 200);
		}else{
			appAlert.warning("<?php echo _l('please_choose_item') ?>");
		}

	}

	function uploadfilecsv(event){
		"use strict";

		if(($("#file_csv").val() != '') && ($("#file_csv").val().split('.').pop() == 'xlsx')){
			var formData = new FormData();
			formData.append("file_csv", $('#file_csv')[0].files[0]);
			formData.append("rise_csrf_token", $('input[name="rise_csrf_token"]').val());
			formData.append("leads_import", $('input[name="leads_import"]').val());

			//show box loading
			var html = '';
			html += '<div class="Box">';
			html += '<span>';
			html += '<span></span>';
			html += '</span>';
			html += '</div>';
			$('#box-loading').html(html);
			$(event).attr( "disabled", "disabled" );

			$.ajax({ 
				url: "<?php  echo get_uri('warehouse/import_serial_number_excel') ?>", 
				method: 'post', 
				data: formData, 
				contentType: false, 
				processData: false

			}).done(function(response) {
				response = JSON.parse(response);
			//hide boxloading
			$('#box-loading').html('');
			$(event).removeAttr('disabled')

			$("#file_csv").val(null);
			$("#file_csv").change();
			$("#page-content").find("#file_upload_response").html();

			if($("#page-content").find("#file_upload_response").html() != ''){
				$("#page-content").find("#file_upload_response").empty();
			};

			$( "#file_upload_response" ).append( "<h4><?php echo _l("_Result") ?></h4><h6><?php echo _l('import_line_number') ?> :"+response.total_rows+" </h6>" );
			$( "#file_upload_response" ).append( "<h6><?php echo _l('import_line_number_success') ?> :"+response.total_row_success+" </h6>" );
			$( "#file_upload_response" ).append( "<h6><?php echo _l('import_line_number_failed') ?> :"+response.total_row_false+" </h6>" );

			if((response.total_row_false > 0) || (response.total_rows_data_error > 0))
			{
				$( "#file_upload_response" ).append( '<a href="'+response.site_url+'\\'+response.filename+'" class="btn btn-warning text-white"  ><?php echo _l('download_file_error') ?></a>' );
			}
			if(response.total_rows < 1){
				appAlert.warning(response.message);
			}
			});

			return false;
		}else if($("#file_csv").val() != ''){
			appAlert.warning("<?php echo _l('_please_select_a_file') ?>");

		}

	}


	// Maybe items ajax search
	init_ajax_search('items','#commodity_filter.ajax-search',undefined,"<?php echo get_uri("warehouse/wh_commodity_code_search_all") ?>");
	init_ajax_search('items','#item_select_print_barcode.ajax-search',undefined,"<?php echo get_uri("warehouse/wh_commodity_code_search_all") ?>");

</script>