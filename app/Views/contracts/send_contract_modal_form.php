<?php echo form_open(get_uri("contracts/send_contract"), array("id" => "send-contract-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $contract_info->id; ?>" />

        <div class="form-group">
            <div class="row">
                <label for="contact_id" class=" col-md-3"><?php echo app_lang('to'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_dropdown("contact_id", $contacts_dropdown, array(), "class='select2 validate-hidden' id='contact_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="contract_cc" class=" col-md-3">CC</label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "contract_cc",
                        "name" => "contract_cc",
                        "value" => "",
                        "class" => "form-control",
                        "placeholder" => "CC"
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="contract_bcc" class=" col-md-3">BCC</label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "contract_bcc",
                        "name" => "contract_bcc",
                        "value" => "",
                        "class" => "form-control",
                        "placeholder" => "BCC"
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="subject" class=" col-md-3"><?php echo app_lang("subject"); ?></label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "subject",
                        "name" => "subject",
                        "value" => $subject,
                        "class" => "form-control",
                        "placeholder" => app_lang("subject")
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class=" col-md-12">
                    <?php
                    echo form_textarea(array(
                        "id" => "message",
                        "name" => "message",
                        "value" => process_images_from_content($message, false),
                        "class" => "form-control",
                        "data-height" => 400,
                        "data-toolbar" => "no_toolbar",
                        "data-encode_ajax_post_data" => "1"
                    ));
                    ?>
                </div>
            </div>
        </div>

        <?php if ($has_pdf_access) { ?>
            <div class="form-group ml15">
                <?php
                echo form_checkbox("attach_pdf", "1", true, "id='attach_pdf' class='form-check-input'");
                ?>
                <label for="attach_pdf"><?php echo app_lang('attach_pdf') . ' ' . anchor(get_uri("contracts/download_pdf/" . $contract_info->id . "/download"), get_hyphenated_string(get_contract_id($contract_info->id)) . ".pdf", array("target" => "_blank", "id" => "attachment-url")); ?></label>
            </div>
        <?php } ?>

    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="send" class="icon-16"></span> <?php echo app_lang('send'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {

        $('#send-contract-form .select2').select2();
        $("#send-contract-form").appForm({
            onSuccess: function(result) {
                if (result.success) {
                    appAlert.success(result.message, {
                        duration: 10000
                    });
                } else {
                    appAlert.error(result.message);
                }
            }
        });

        initWYSIWYGEditor("#message");

        //load template view on changing of client contact
        $("#contact_id").select2().on("change", function() {
            var contact_id = $(this).val();
            if (contact_id) {
                appLoader.show();
                $.ajax({
                    url: "<?php echo get_uri('contracts/get_send_contract_template/' . $contract_info->id) ?>" + "/" + contact_id + "/json",
                    dataType: "json",
                    success: function(result) {
                        if (result.success) {
                            setWYSIWYGEditorHTML("#message", result.message_view);
                            appLoader.hide();
                        }
                    }
                });
            }
        });

    });
</script>