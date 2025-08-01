<?php echo form_open(get_uri("invoices/save"), array("id" => "invoice-form", "class" => "general-form", "role" => "form")); ?>
<div id="invoices-dropzone" class="post-dropzone">
    <div class="modal-body clearfix">
        <div class="container-fluid">

            <?php if ($is_clone || $estimate_id || $order_id || $contract_id || $proposal_id) { ?>
                <?php if ($is_clone) { ?>
                    <input type="hidden" name="is_clone" value="1" />
                <?php } ?>
                <input type="hidden" name="discount_amount" value="<?php echo $model_info->discount_amount; ?>" />
                <input type="hidden" name="discount_amount_type" value="<?php echo $model_info->discount_amount_type; ?>" />
                <input type="hidden" name="discount_type" value="<?php echo $model_info->discount_type; ?>" />
            <?php } ?>

            <?php if ($model_info->id && get_setting("enable_invoice_id_editing") && !$is_clone) { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="display_id" class=" col-md-3"><?php echo app_lang('invoice_id'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "display_id",
                                "name" => "display_id",
                                "value" => $model_info->display_id,
                                "class" => "form-control",
                                "placeholder" => app_lang('id')
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="row">
                    <label for="invoice_bill_date" class=" col-md-3"><?php echo app_lang('bill_date'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "invoice_bill_date",
                            "name" => "invoice_bill_date",
                            "value" => $model_info->bill_date ? $model_info->bill_date : get_my_local_time("Y-m-d"),
                            "class" => "form-control recurring_element",
                            "placeholder" => app_lang('bill_date'),
                            "autocomplete" => "off",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="invoice_due_date" class=" col-md-3"><?php echo app_lang('due_date'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "invoice_due_date",
                            "name" => "invoice_due_date",
                            "value" => $model_info->due_date,
                            "class" => "form-control",
                            "placeholder" => app_lang('due_date'),
                            "autocomplete" => "off",
                            "data-rule-required" => true,
                            "data-msg-required" => app_lang("field_required"),
                            "data-rule-greaterThanOrEqual" => "#invoice_bill_date",
                            "data-msg-greaterThanOrEqual" => app_lang("end_date_must_be_equal_or_greater_than_start_date")
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <?php if (count($companies_dropdown) > 1) { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="company_id" class=" col-md-3"><?php echo app_lang('company'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "company_id",
                                "name" => "company_id",
                                "value" => $model_info->company_id,
                                "class" => "form-control",
                                "placeholder" => app_lang('company')
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($client_id && !$project_id) { ?>
                <input type="hidden" name="invoice_client_id" value="<?php echo $client_id; ?>" />
            <?php } else { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="invoice_client_id" class=" col-md-3"><?php echo app_lang('client'); ?></label>
                        <div class="col-md-9">
                            <?php
                            echo form_input(array(
                                "id" => "invoice_client_id",
                                "name" => "invoice_client_id",
                                "value" => $model_info->client_id,
                                "class" => "form-control",
                                "placeholder" => app_lang('client')
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($project_id) { ?>
                <input type="hidden" name="invoice_project_id" value="<?php echo $project_id; ?>" />
            <?php } else { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="invoice_project_id" class=" col-md-3"><?php echo app_lang('project'); ?></label>
                        <div class="col-md-9" id="invoice-porject-dropdown-section">
                            <?php
                            echo form_input(array(
                                "id" => "invoice_project_id",
                                "name" => "invoice_project_id",
                                "value" => $model_info->project_id,
                                "class" => "form-control",
                                "placeholder" => app_lang('project')
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="row">
                    <label for="tax_id" class=" col-md-3"><?php echo app_lang('tax'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_dropdown("tax_id", $taxes_dropdown, array($model_info->tax_id), "class='select2 tax-select2'");
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="tax_id" class=" col-md-3"><?php echo app_lang('second_tax'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_dropdown("tax_id2", $taxes_dropdown, array($model_info->tax_id2), "class='select2 tax-select2'");
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="tax_id" class=" col-md-3"><?php echo app_lang('tax_deducted_at_source'); ?></label>
                    <div class="col-md-9">
                        <?php
                        echo form_dropdown("tax_id3", $taxes_dropdown, array($model_info->tax_id3), "class='select2 tax-select2'");
                        ?>
                    </div>
                </div>
            </div>

            <?php echo view("invoices/recurring_fields"); ?>

            <div class="form-group">
                <div class="row">
                    <label for="invoice_note" class=" col-md-3"><?php echo app_lang('note'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_textarea(array(
                            "id" => "invoice_note",
                            "name" => "invoice_note",
                            "value" => $model_info->note ? process_images_from_content($model_info->note, false) : "",
                            "class" => "form-control",
                            "placeholder" => app_lang('note'),
                            "data-rich-text-editor" => true
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="invoice_labels" class=" col-md-3"><?php echo app_lang('labels'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_input(array(
                            "id" => "invoice_labels",
                            "name" => "labels",
                            "value" => $model_info->labels,
                            "class" => "form-control",
                            "placeholder" => app_lang('labels')
                        ));
                        ?>
                    </div>
                </div>
            </div>

            <?php echo view("custom_fields/form/prepare_context_fields", array("custom_fields" => $custom_fields, "label_column" => "col-md-3", "field_column" => " col-md-9")); ?>

            <?php if ($estimate_id) { ?>
                <input type="hidden" name="estimate_id" value="<?php echo $estimate_id; ?>" />
                <div class="form-group">
                    <div class="row">
                        <label for="estimate_id_checkbox" class=" col-md-12">
                            <input type="hidden" name="copy_items_from_estimate" value="<?php echo $estimate_id; ?>" />
                            <?php
                            echo form_checkbox("estimate_id_checkbox", $estimate_id, true, " class='float-start form-check-input' disabled='disabled'");
                            ?>
                            <span class="float-start ml15"> <?php echo app_lang('include_all_items_of_this_estimate'); ?> </span>
                        </label>
                    </div>
                </div>
            <?php } ?>
            <?php if ($order_id) { ?>
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
                <div class="form-group">
                    <div class="row">
                        <label for="order_id_checkbox" class=" col-md-12">
                            <input type="hidden" name="copy_items_from_order" value="<?php echo $order_id; ?>" />
                            <?php
                            echo form_checkbox("order_id_checkbox", $order_id, true, " class='float-start form-check-input' disabled='disabled'");
                            ?>
                            <span class="float-start ml15"> <?php echo app_lang('include_all_items_of_this_order'); ?> </span>
                        </label>
                    </div>
                </div>
            <?php } ?>

            <?php if ($contract_id) { ?>
                <input type="hidden" name="contract_id" value="<?php echo $contract_id; ?>" />
                <div class="form-group">
                    <div class="row">
                        <label for="contract_id_checkbox" class=" col-md-12">
                            <input type="hidden" name="copy_items_from_contract" value="<?php echo $contract_id; ?>" />
                            <?php
                            echo form_checkbox("contract_id_checkbox", $contract_id, true, " class='float-start form-check-input' disabled='disabled'");
                            ?>
                            <span class="float-start ml15"> <?php echo app_lang('include_all_items_of_this_contract'); ?> </span>
                        </label>
                    </div>
                </div>
            <?php } ?>

            <?php if ($proposal_id) { ?>
                <input type="hidden" name="proposal_id" value="<?php echo $proposal_id; ?>" />
                <div class="form-group">
                    <div class="row">
                        <label for="proposal_id_checkbox" class=" col-md-12">
                            <input type="hidden" name="copy_items_from_proposal" value="<?php echo $proposal_id; ?>" />
                            <?php
                            echo form_checkbox("proposal_id_checkbox", $proposal_id, true, " class='float-start form-check-input' disabled='disabled'");
                            ?>
                            <span class="float-start ml15"> <?php echo app_lang('include_all_items_of_this_proposal'); ?> </span>
                        </label>
                    </div>
                </div>
            <?php } ?>

            <?php if ($is_clone) { ?>
                <div class="form-group">
                    <div class="row">
                        <label for="copy_items" class=" col-md-12">
                            <?php
                            echo form_checkbox("copy_items", "1", true, "id='copy_items' disabled='disabled' class='form-check-input float-start mr15'");
                            ?>
                            <?php echo app_lang('copy_items'); ?>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="copy_discount" class=" col-md-12">
                            <?php
                            echo form_checkbox("copy_discount", "1", true, "id='copy_discount' disabled='disabled' class='form-check-input float-start mr15'");
                            ?>
                            <?php echo app_lang('copy_discount'); ?>
                        </label>
                    </div>
                </div>
            <?php } ?>

            <div class="form-group">
                <div class="col-md-12 row">
                    <?php
                    echo view("includes/file_list", array("files" => $model_info->files));
                    ?>
                </div>
            </div>

            <?php echo view("includes/dropzone_preview"); ?>
        </div>
    </div>

    <div class="modal-footer">
        <?php echo view("includes/upload_button"); ?>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
        <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        if ("<?php echo $estimate_id; ?>" || "<?php echo $proposal_id; ?>" || "<?php echo $order_id; ?>" || "<?php echo $contract_id; ?>") {
            RELOAD_VIEW_AFTER_UPDATE = false; //go to related page
        }

        $("#invoice-form").appForm({
            onSuccess: function(result) {
                if (typeof RELOAD_VIEW_AFTER_UPDATE !== "undefined" && RELOAD_VIEW_AFTER_UPDATE) {
                    location.reload();
                } else {
                    window.location = "<?php echo site_url('invoices/view'); ?>/" + result.id;
                }
            },
            onAjaxSuccess: function(result) {
                if (!result.success && result.next_recurring_date_error) {
                    $("#next_recurring_date").val(result.next_recurring_date_value);
                    $("#next_recurring_date_container").removeClass("hide");

                    $("#invoice-form").data("validator").showErrors({
                        "next_recurring_date": result.next_recurring_date_error
                    });
                }
            }
        });
        $("#invoice-form .tax-select2").select2();

        $("#invoice_labels").select2({
            multiple: true,
            data: <?php echo json_encode($label_suggestions); ?>
        });
        $("#company_id").select2({
            data: <?php echo json_encode($companies_dropdown); ?>
        });

        setDatePicker("#invoice_bill_date, #invoice_due_date");

        $("#invoice_client_id").appDropdown({
            list_data: <?php echo $clients_dropdown; ?>,
            onChangeCallback: function(client_id) {
                if (client_id) {
                    $('#invoice_project_id').select2("destroy");
                    $("#invoice_project_id").hide();
                    appLoader.show({
                        container: "#invoice-porject-dropdown-section"
                    });
                     //load all projects of selected client
                    $.ajax({
                        url: "<?php echo get_uri("invoices/get_project_suggestion") ?>" + "/" + client_id,
                        dataType: "json",
                        success: function(result) {
                            $("#invoice_project_id").show().val("");
                            $('#invoice_project_id').select2({
                                data: result
                            });
                            appLoader.hide();
                        }
                    });
                }
            }
        });

        $('#invoice_project_id').select2({
            data: <?php echo json_encode($projects_suggestion); ?>
        });

        if ("<?php echo $project_id; ?>") {
            $("#invoice_client_id").select2("readonly", true);
        }

        //show/hide recurring fields
        $("#invoice_recurring").click(function() {
            if ($(this).is(":checked")) {
                $("#recurring_fields").removeClass("hide");
            } else {
                $("#recurring_fields").addClass("hide");
            }
        });

        var dynamicDates = getDynamicDates();
        setDatePicker("#next_recurring_date", {
            startDate: dynamicDates.tomorrow //set min date = tomorrow
        });


        var defaultDue = "<?php echo get_setting('default_due_date_after_billing_date'); ?>";
        var id = "<?php echo $model_info->id; ?>";

        //disable this operation in edit mode
        if (defaultDue && !id) {
            //for auto fill the due date based on bill date
            setDefaultDueDate = function() {
                var dateFormat = getJsDateFormat().toUpperCase();

                var billDate = $('#invoice_bill_date').val();
                var dueDate = moment(billDate, dateFormat).add(defaultDue, 'days').format(dateFormat);
                $("#invoice_due_date").val(dueDate);

            };

            $("#invoice_bill_date").change(function() {
                setDefaultDueDate();
            });

            setDefaultDueDate();
        }

    });
</script>