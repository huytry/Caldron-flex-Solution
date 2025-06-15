<div id="accordion">
  <div class="card">
    <table class="tree">
      <tbody>
        <tr>
          <td colspan="7">
              <h3 class="text-center no-margin-top-20 no-margin-left-24"><?php echo get_setting('companyname'); ?></h3>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="7">
            <h4 class="text-center no-margin-top-20 no-margin-left-24"><?php echo app_lang('accounts_receivable_ageing_summary'); ?></h4>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="7">
            <p class="text-center no-margin-top-20 no-margin-left-24"><?php echo html_entity_decode($data_report['to_date']); ?></p>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="tr_header">
          <td></td>
          <td class="th_total_width_auto text-bold"><?php echo app_lang('current'); ?></td>
          <td class="th_total_width_auto text-bold">1 - 30</td>
          <td class="th_total_width_auto text-bold">31 - 60</td>
          <td class="th_total_width_auto text-bold">61 - 90</td>
          <td class="th_total_width_auto text-bold">91 AND OVER</td>
          <td class="th_total_width_auto text-bold"><?php echo app_lang('total'); ?></td>
        </tr>
        <?php
         $row_index = 1; 
         $parent_index = 1; 
         $total = 0; 
         $total_current = 0; 
         $total_1_30 = 0; 
         $total_31_60 = 0; 
         $total_61_90 = 0; 
         $total_91_and_over = 0; 
         ?>
         <?php foreach ($data_report['data'] as $customer => $val) {
              $row_index += 1;
              $total_current += $val['current'];
              $total_1_30 += $val['1_30_days_past_due'];
              $total_31_60 += $val['31_60_days_past_due'];
              $total_61_90 += $val['61_90_days_past_due'];
              $total_91_and_over += $val['91_and_over'];
              $total += $val['total'];
            ?>
            <tr class="treegrid-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 ">
              <td>
              <?php echo get_company_name($customer); ?> 
              </td>
              <td class="total_amount">
              <?php echo to_currency($val['current'], $currency_symbol); ?> 
              </td>
              <td class="total_amount">
              <?php echo to_currency($val['1_30_days_past_due'], $currency_symbol); ?> 
              </td>
              <td class="total_amount">
              <?php echo to_currency($val['31_60_days_past_due'], $currency_symbol); ?> 
              </td>
              <td class="total_amount">
              <?php echo to_currency($val['61_90_days_past_due'], $currency_symbol); ?> 
              </td>
              <td class="total_amount">
              <?php echo to_currency($val['91_and_over'], $currency_symbol); ?> 
              </td>
              <td class="total_amount">
              <?php echo to_currency($val['total'], $currency_symbol); ?> 
              </td>
            </tr>
          <?php }
            $row_index += 1;
           ?>
          
           <tr class="treegrid-total-<?php echo html_entity_decode($row_index); ?> treegrid-parent-10000 parent-node expanded tr_total">
            <td class="parent"><?php echo app_lang('total'); ?></td>
            <td class="total_amount"><?php echo to_currency($total_current, $currency_symbol); ?></td>
            <td class="total_amount"><?php echo to_currency($total_1_30, $currency_symbol); ?></td>
            <td class="total_amount"><?php echo to_currency($total_31_60, $currency_symbol); ?></td>
            <td class="total_amount"><?php echo to_currency($total_61_90, $currency_symbol); ?></td>
            <td class="total_amount"><?php echo to_currency($total_91_and_over, $currency_symbol); ?></td>
            <td class="total_amount"><?php echo to_currency($total, $currency_symbol); ?></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>