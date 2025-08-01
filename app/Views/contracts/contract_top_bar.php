<div id="contract-top-bar" class="details-view-status-section mb20">
    <div class="page-title no-bg clearfix mb5 no-border">
        <h1 class="pl0">
            <span><i data-feather="file-plus" class='icon'></i></span>
            <?php echo get_contract_id($contract_info->id) . ": " . $contract_info->title; ?>
            <input type="" value="" class="hidden-input-field " />
        </h1>

        <div class="title-button-group mr0">
            <?php
            echo anchor(get_uri("contract/preview/" . $contract_info->id . "/" . $contract_info->public_key), "<i data-feather='external-link' class='icon-16'></i> " . app_lang('contract') . " " . app_lang("url"), array("target" => "_blank", "class" => "btn btn-default"));

            if ($contract_status == "draft" || $contract_status == "sent") {
                if ($client_info->is_lead) {
                    echo modal_anchor(get_uri("contracts/send_contract_modal_form/" . $contract_info->id), "<i data-feather='send' class='icon-16'></i> " . app_lang('send_to_lead'), array("title" => app_lang('send_to_lead'), "data-post-id" => $contract_info->id, "data-post-is_lead" => true, "role" => "menuitem", "tabindex" => "-1", "class" => "btn btn-primary mr0"));
                } else {
                    echo modal_anchor(get_uri("contracts/send_contract_modal_form/" . $contract_info->id), "<i data-feather='send' class='icon-16'></i> " . app_lang('send_to_client'), array("title" => app_lang('send_to_client'), "data-post-id" => $contract_info->id, "role" => "menuitem", "tabindex" => "-1", "class" => "btn btn-primary mr0"));
                }
            }
            ?>
        </div>
    </div>

    <?php
    echo "<span>$contract_status_label</span>";

    $last_email_sent_date = (is_date_exists($contract_info->last_email_sent_date)) ? format_to_date($contract_info->last_email_sent_date, FALSE) : app_lang("never");
    echo "<span class='badge rounded-pill large text-default b-a' title='" . app_lang("last_email_sent") . "'><i data-feather='mail' class='icon-14 text-off '></i> $last_email_sent_date</span>";
    ?>
</div>