<div id="page-content" class="page-wrapper clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "units";
            echo view("Warehouse\Views\includes/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="card">
                <div class="page-title clearfix">
                    <h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo app_lang('unit_type'); ?></h4>
                    <div class="title-button-group">
                        <?php if (has_permission('warehouse', '', 'create') || is_admin() ) { ?>
                            
                            <?php echo modal_anchor(get_uri("warehouse/unit_type_modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_unit_type'), array("class" => "btn btn-default", "title" => app_lang('add_unit_type'))); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="unit_type-table" class="display" cellspacing="0" width="100%">            
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'plugins/Warehouse/assets/js/settings/unit_js.php';?>
</body>
</html>
