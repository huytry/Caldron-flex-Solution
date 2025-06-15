<?php

namespace Accounting\Models;

use App\Models\Crud_model;
use Config\Services;

class Accounting_model extends Crud_model {
    protected $table = null;
    protected $db_builder = null;

    function __construct() {
        $this->table = 'demo_settings';
        parent::__construct($this->table);
    }

    /**
     * get account types
     * @param  integer $id    member group id
     * @param  array  $where
     * @return object
     */
    public function get_account_types()
    {
        $account_types = app_hooks()->apply_filters('before_get_account_types', [
            [
                'id'             => 1,
                'name'           => app_lang('acc_accounts_receivable'),
                'order'          => 1,
                ],
            [
                'id'             => 2,
                'name'           => app_lang('acc_current_assets'),
                'order'          => 2,
                ],
            [
                'id'             => 3,
                'name'           => app_lang('acc_cash_and_cash_equivalents'),
                'order'          => 3,
                ],
            [
                'id'             => 4,
                'name'           => app_lang('acc_fixed_assets'),
                'order'          => 4,
                ],
            [
                'id'             => 5,
                'name'           => app_lang('acc_non_current_assets'),
                'order'          => 5,
                ],
            [
                'id'             => 6,
                'name'           => app_lang('acc_accounts_payable'),
                'order'          => 6,
                ],
            [
                'id'             => 7,
                'name'           => app_lang('acc_credit_card'),
                'order'          => 7,
                ],
            [
                'id'             => 8,
                'name'           => app_lang('acc_current_liabilities'),
                'order'          => 8,
                ],
            [
                'id'             => 9,
                'name'           => app_lang('acc_non_current_liabilities'),
                'order'          => 9,
                ],
            [
                'id'             => 10,
                'name'           => app_lang('acc_owner_equity'),
                'order'          => 10,
                ],
            [
                'id'             => 11,
                'name'           => app_lang('acc_income'),
                'order'          => 11,
                ],
            [
                'id'             => 12,
                'name'           => app_lang('acc_other_income'),
                'order'          => 12,
                ],
            [
                'id'             => 13,
                'name'           => app_lang('acc_cost_of_sales'),
                'order'          => 13,
                ],
            [
                'id'             => 14,
                'name'           => app_lang('acc_expenses'),
                'order'          => 14,
                ],
            [
                'id'             => 15,
                'name'           => app_lang('acc_other_expense'),
                'order'          => 15,
                ],
            ]);

        usort($account_types, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        return $account_types;
    }
    
    /**
     * get account type details
     * @param  integer $id    member group id
     * @param  array  $where
     * @return object
     */
    public function get_account_type_details()
    {
        $account_type_details = app_hooks()->apply_filters('before_get_account_type_details', [
            [
                'id'                => 1,
                'account_type_id'   => 1,
                'name'              => app_lang('acc_accounts_receivable'),
                'note'              => app_lang('acc_accounts_receivable_note'),
                'order'             => 1,
                ],
            [
                'id'                => 2,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_allowance_for_bad_debts'),
                'note'              => app_lang('acc_allowance_for_bad_debts_note'),
                'order'             => 2,
                ],
            [
                'id'                => 3,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_assets_available_for_sale'),
                'note'              => app_lang('acc_assets_available_for_sale_note'),
                'order'             => 3,
                ],
            [
                'id'                => 4,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_development_costs'),
                'note'              => app_lang('acc_development_costs_note'),
                'order'             => 4,
                ],
            [
                'id'                => 141,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_employee_cash_advances'),
                'note'              => app_lang('acc_employee_cash_advances_note'),
                'order'             => 5,
                ],
            [
                'id'                => 5,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_inventory'),
                'note'              => app_lang('acc_inventory_note'),
                'order'             => 5,
                ],
            [
                'id'                => 6,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_investments_other'),
                'note'              => app_lang('acc_investments_other_note'),
                'order'             => 6,
                ],
            [
                'id'                => 7,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_loans_to_officers'),
                'note'              => app_lang('acc_loans_to_officers_note'),
                'order'             => 7,
                ],
            [
                'id'                => 8,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_loans_to_others'),
                'note'              => app_lang('acc_loans_to_others_note'),
                'order'             => 8,
                ],
            [
                'id'                => 9,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_loans_to_shareholders'),
                'note'              => app_lang('acc_loans_to_shareholders_note'),
                'order'             => 9,
                ],
            [
                'id'                => 10,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_other_current_assets'),
                'note'              => app_lang('acc_other_current_assets_note'),
                'order'             => 10,
                ],
            [
                'id'                => 11,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_prepaid_expenses'),
                'note'              => app_lang('acc_prepaid_expenses_note'),
                'order'             => 11,
                ],
            [
                'id'                => 12,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_retainage'),
                'note'              => app_lang('acc_retainage_note'),
                'order'             => 12,
                ],
            [
                'id'                => 13,
                'account_type_id'   => 2,
                'name'              => app_lang('acc_undeposited_funds'),
                'note'              => app_lang('acc_undeposited_funds_note'),
                'order'             => 13,
                ],
            [
                'id'                => 14,
                'account_type_id'   => 3,
                'name'              => app_lang('acc_bank'),
                'note'              => app_lang('acc_bank_note'),
                'order'             => 14,
                ],
            [
                'id'                => 15,
                'account_type_id'   => 3,
                'name'              => app_lang('acc_cash_and_cash_equivalents'),
                'note'              => app_lang('acc_cash_and_cash_equivalents_note'),
                'order'             => 15,
                ],
            [
                'id'                => 16,
                'account_type_id'   => 3,
                'name'              => app_lang('acc_cash_on_hand'),
                'note'              => app_lang('acc_cash_on_hand_note'),
                'order'             => 16,
                ],
            [
                'id'                => 17,
                'account_type_id'   => 3,
                'name'              => app_lang('acc_client_trust_account'),
                'note'              => app_lang('acc_client_trust_account_note'),
                'order'             => 17,
                ],
            [
                'id'                => 18,
                'account_type_id'   => 3,
                'name'              => app_lang('acc_money_market'),
                'note'              => app_lang('acc_money_market_note'),
                'order'             => 18,
                ],
            [
                'id'                => 19,
                'account_type_id'   => 3,
                'name'              => app_lang('acc_rents_held_in_trust'),
                'note'              => app_lang('acc_rents_held_in_trust_note'),
                'order'             => 19,
                ],
            [
                'id'                => 20,
                'account_type_id'   => 3,
                'name'              => app_lang('acc_savings'),
                'note'              => app_lang('acc_savings_note'),
                'order'             => 20,
                ],
            [
                'id'                => 21,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_accumulated_depletion'),
                'note'              => app_lang('acc_accumulated_depletion_note'),
                'order'             => 21,
                ],
            [
                'id'                => 22,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_accumulated_depreciation_on_property_plant_and_equipment'),
                'note'              => app_lang('acc_accumulated_depreciation_on_property_plant_and_equipment_note'),
                'order'             => 22,
                ],
            [
                'id'                => 23,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_buildings'),
                'note'              => app_lang('acc_buildings_note'),
                'order'             => 23,
                ],
            [
                'id'                => 24,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_depletable_assets'),
                'note'              => app_lang('acc_depletable_assets_note'),
                'order'             => 24,
                ],
            [
                'id'                => 25,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_furniture_and_fixtures'),
                'note'              => app_lang('acc_furniture_and_fixtures_note'),
                'order'             => 25,
                ],
            [
                'id'                => 26,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_land'),
                'note'              => app_lang('acc_land_note'),
                'order'             => 26,
                ],
            [
                'id'                => 27,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_leasehold_improvements'),
                'note'              => app_lang('acc_leasehold_improvements_note'),
                'order'             => 27,
                ],
            [
                'id'                => 28,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_machinery_and_equipment'),
                'note'              => app_lang('acc_machinery_and_equipment_note'),
                'order'             => 28,
                ],
            [
                'id'                => 29,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_other_fixed_assets'),
                'note'              => app_lang('acc_other_fixed_assets_note'),
                'order'             => 29,
                ],
            [
                'id'                => 30,
                'account_type_id'   => 4,
                'name'              => app_lang('acc_vehicles'),
                'note'              => app_lang('acc_vehicles_note'),
                'order'             => 30,
                ],
            [
                'id'                => 31,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_accumulated_amortisation_of_non_current_assets'),
                'note'              => app_lang('acc_accumulated_amortisation_of_non_current_assets_note'),
                'order'             => 31,
                ],
            [
                'id'                => 32,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_assets_held_for_sale'),
                'note'              => app_lang('acc_assets_held_for_sale_note'),
                'order'             => 32,
                ],
            [
                'id'                => 33,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_deferred_tax'),
                'note'              => app_lang('acc_deferred_tax_note'),
                'order'             => 33,
                ],
            [
                'id'                => 34,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_goodwill'),
                'note'              => app_lang('acc_goodwill_note'),
                'order'             => 34,
                ],
            [
                'id'                => 35,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_intangible_assets'),
                'note'              => app_lang('acc_intangible_assets_note'),
                'order'             => 35,
                ],
            [
                'id'                => 36,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_lease_buyout'),
                'note'              => app_lang('acc_lease_buyout_note'),
                'order'             => 36,
                ],
            [
                'id'                => 37,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_licences'),
                'note'              => app_lang('acc_licences_note'),
                'order'             => 37,
                ],
            [
                'id'                => 38,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_long_term_investments'),
                'note'              => app_lang('acc_long_term_investments_note'),
                'order'             => 38,
                ],
            [
                'id'                => 39,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_organisational_costs'),
                'note'              => app_lang('acc_organisational_costs_note'),
                'order'             => 39,
                ],
            [
                'id'                => 40,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_other_non_current_assets'),
                'note'              => app_lang('acc_other_non_current_assets_note'),
                'order'             => 40,
                ],
            [
                'id'                => 41,
                'account_type_id'   => 5,
                'name'              => app_lang('acc_security_deposits'),
                'note'              => app_lang('acc_security_deposits_note'),
                'order'             => 41,
                ],
            [
                'id'                => 42,
                'account_type_id'   => 6,
                'name'              => app_lang('acc_accounts_payable'),
                'note'              => app_lang('acc_accounts_payable_note'),
                'order'             => 42,
                ],
            [
                'id'                => 43,
                'account_type_id'   => 7,
                'name'              => app_lang('acc_credit_card'),
                'note'              => app_lang('acc_credit_card_note'),
                'order'             => 43,
                ],
            [
                'id'                => 44,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_accrued_liabilities'),
                'note'              => app_lang('acc_accrued_liabilities_note'),
                'order'             => 44,
                ],
            [
                'id'                => 45,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_client_trust_accounts_liabilities'),
                'note'              => app_lang('acc_client_trust_accounts_liabilities_note'),
                'order'             => 45,
                ],
            [
                'id'                => 46,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_current_tax_liability'),
                'note'              => app_lang('acc_current_tax_liability_note'),
                'order'             => 46,
                ],
            [
                'id'                => 47,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_current_portion_of_obligations_under_finance_leases'),
                'note'              => app_lang('acc_current_portion_of_obligations_under_finance_leases_note'),
                'order'             => 47,
                ],
            [
                'id'                => 48,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_dividends_payable'),
                'note'              => app_lang('acc_dividends_payable_note'),
                'order'             => 48,
                ],
            [
                'id'                => 50,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_income_tax_payable'),
                'note'              => app_lang('acc_income_tax_payable_note'),
                'order'             => 50,
                ],
            [
                'id'                => 51,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_insurance_payable'),
                'note'              => app_lang('acc_insurance_payable_note'),
                'order'             => 51,
                ],
            [
                'id'                => 52,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_line_of_credit'),
                'note'              => app_lang('acc_line_of_credit_note'),
                'order'             => 52,
                ],
            [
                'id'                => 53,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_loan_payable'),
                'note'              => app_lang('acc_loan_payable_note'),
                'order'             => 53,
                ],
            [
                'id'                => 54,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_other_current_liabilities'),
                'note'              => app_lang('acc_other_current_liabilities_note'),
                'order'             => 54,
                ],
            [
                'id'                => 55,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_payroll_clearing'),
                'note'              => app_lang('acc_payroll_clearing_note'),
                'order'             => 55,
                ],
            [
                'id'                => 56,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_payroll_liabilities'),
                'note'              => app_lang('acc_payroll_liabilities_note'),
                'order'             => 56,
                ],
            [
                'id'                => 58,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_prepaid_expenses_payable'),
                'note'              => app_lang('acc_prepaid_expenses_payable_note'),
                'order'             => 58,
                ],
            [
                'id'                => 59,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_rents_in_trust_liability'),
                'note'              => app_lang('acc_rents_in_trust_liability_note'),
                'order'             => 59,
                ],
            [
                'id'                => 60,
                'account_type_id'   => 8,
                'name'              => app_lang('acc_sales_and_service_tax_payable'),
                'note'              => app_lang('acc_sales_and_service_tax_payable_note'),
                'order'             => 60,
                ],
            [
                'id'                => 61,
                'account_type_id'   => 9,
                'name'              => app_lang('acc_accrued_holiday_payable'),
                'note'              => app_lang('acc_accrued_holiday_payable_note'),
                'order'             => 61,
                ],
            [
                'id'                => 62,
                'account_type_id'   => 9,
                'name'              => app_lang('acc_accrued_non_current_liabilities'),
                'note'              => app_lang('acc_accrued_non_current_liabilities_note'),
                'order'             => 62,
                ],
            [
                'id'                => 63,
                'account_type_id'   => 9,
                'name'              => app_lang('acc_liabilities_related_to_assets_held_for_sale'),
                'note'              => app_lang('acc_liabilities_related_to_assets_held_for_sale_note'),
                'order'             => 63,
                ],
            [
                'id'                => 64,
                'account_type_id'   => 9,
                'name'              => app_lang('acc_long_term_debt'),
                'note'              => app_lang('acc_long_term_debt_note'),
                'order'             => 64,
                ],
            [
                'id'                => 65,
                'account_type_id'   => 9,
                'name'              => app_lang('acc_notes_payable'),
                'note'              => app_lang('acc_notes_payable_note'),
                'order'             => 65,
                ],
            [
                'id'                => 66,
                'account_type_id'   => 9,
                'name'              => app_lang('acc_other_non_current_liabilities'),
                'note'              => app_lang('acc_other_non_current_liabilities_note'),
                'order'             => 66,
                ],
            [
                'id'                => 67,
                'account_type_id'   => 9,
                'name'              => app_lang('acc_shareholder_potes_payable'),
                'note'              => app_lang('acc_shareholder_potes_payable_note'),
                'order'             => 67,
                ],
            [
                'id'                => 68,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_accumulated_adjustment'),
                'note'              => app_lang('acc_accumulated_adjustment_note'),
                'order'             => 68,
                ],
            [
                'id'                => 69,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_dividend_disbursed'),
                'note'              => app_lang('acc_dividend_disbursed_note'),
                'order'             => 69,
                ],
            [
                'id'                => 70,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_equity_in_earnings_of_subsidiaries'),
                'note'              => app_lang('acc_equity_in_earnings_of_subsidiaries_note'),
                'order'             => 70,
                ],
            [
                'id'                => 71,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_opening_balance_equity'),
                'note'              => app_lang('acc_opening_balance_equity_note'),
                'order'             => 71,
                ],
            [
                'id'                => 72,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_ordinary_shares'),
                'note'              => app_lang('acc_ordinary_shares_note'),
                'order'             => 72,
                ],
            [
                'id'                => 73,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_other_comprehensive_income'),
                'note'              => app_lang('acc_other_comprehensive_income_note'),
                'order'             => 73,
                ],
            [
                'id'                => 74,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_owner_equity'),
                'note'              => app_lang('acc_owner_equity_note'),
                'order'             => 74,
                ],
            [
                'id'                => 75,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_paid_in_capital_or_surplus'),
                'note'              => app_lang('acc_paid_in_capital_or_surplus_note'),
                'order'             => 75,
                ],
            [
                'id'                => 76,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_partner_contributions'),
                'note'              => app_lang('acc_partner_contributions_note'),
                'order'             => 76,
                ],
            [
                'id'                => 77,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_partner_distributions'),
                'note'              => app_lang('acc_partner_distributions_note'),
                'order'             => 77,
                ],
            [
                'id'                => 78,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_partner_equity'),
                'note'              => app_lang('acc_partner_equity_note'),
                'order'             => 78,
                ],
            [
                'id'                => 79,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_preferred_shares'),
                'note'              => app_lang('acc_preferred_shares_note'),
                'order'             => 79,
                ],
            [
                'id'                => 80,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_retained_earnings'),
                'note'              => app_lang('acc_retained_earnings_note'),
                'order'             => 80,
                ],
            [
                'id'                => 81,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_share_capital'),
                'note'              => app_lang('acc_share_capital_note'),
                'order'             => 81,
                ],
            [
                'id'                => 82,
                'account_type_id'   => 10,
                'name'              => app_lang('acc_treasury_shares'),
                'note'              => app_lang('acc_treasury_shares_note'),
                'order'             => 82,
                ],
            [
                'id'                => 83,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_discounts_refunds_given'),
                'note'              => app_lang('acc_discounts_refunds_given_note'),
                'order'             => 83,
                ],
            [
                'id'                => 84,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_non_profit_income'),
                'note'              => app_lang('acc_non_profit_income_note'),
                'order'             => 84,
                ],
            [
                'id'                => 85,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_other_primary_income'),
                'note'              => app_lang('acc_other_primary_income_note'),
                'order'             => 85,
                ],
            [
                'id'                => 86,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_revenue_general'),
                'note'              => app_lang('acc_revenue_general_note'),
                'order'             => 86,
                ],
            [
                'id'                => 87,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_sales_retail'),
                'note'              => app_lang('acc_sales_retail_note'),
                'order'             => 87,
                ],
            [
                'id'                => 88,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_sales_wholesale'),
                'note'              => app_lang('acc_sales_wholesale_note'),
                'order'             => 88,
                ],
            [
                'id'                => 89,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_sales_of_product_income'),
                'note'              => app_lang('acc_sales_of_product_income_note'),
                'order'             => 89,
                ],
            [
                'id'                => 90,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_service_fee_income'),
                'note'              => app_lang('acc_service_fee_income_note'),
                'order'             => 90,
                ],
            [
                'id'                => 91,
                'account_type_id'   => 11,
                'name'              => app_lang('acc_unapplied_cash_payment_income'),
                'note'              => app_lang('acc_unapplied_cash_payment_income_note'),
                'order'             => 91,
                ],
            [
                'id'                => 92,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_dividend_income'),
                'note'              => app_lang('acc_dividend_income_note'),
                'order'             => 92,
                ],
            [
                'id'                => 93,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_interest_earned'),
                'note'              => app_lang('acc_interest_earned_note'),
                'order'             => 93,
                ],
            [
                'id'                => 94,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_loss_on_disposal_of_assets'),
                'note'              => app_lang('acc_loss_on_disposal_of_assets_note'),
                'order'             => 94,
                ],
            [
                'id'                => 95,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_other_investment_income'),
                'note'              => app_lang('acc_other_investment_income_note'),
                'order'             => 95,
                ],
            [
                'id'                => 96,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_other_miscellaneous_income'),
                'note'              => app_lang('acc_other_miscellaneous_income_note'),
                'order'             => 96,
                ],
            [
                'id'                => 97,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_other_operating_income'),
                'note'              => app_lang('acc_other_operating_income_note'),
                'order'             => 97,
                ],
            [
                'id'                => 98,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_tax_exempt_interest'),
                'note'              => app_lang('acc_tax_exempt_interest_note'),
                'order'             => 98,
                ],
            [
                'id'                => 99,
                'account_type_id'   => 12,
                'name'              => app_lang('acc_unrealised_loss_on_securities_net_of_tax'),
                'note'              => app_lang('acc_unrealised_loss_on_securities_net_of_tax_note'),
                'order'             => 99,
                ],
            [
                'id'                => 100,
                'account_type_id'   => 13,
                'name'              => app_lang('acc_cost_of_labour_cos'),
                'note'              => app_lang('acc_cost_of_labour_cos_note'),
                'order'             => 100,
                ],
            [
                'id'                => 101,
                'account_type_id'   => 13,
                'name'              => app_lang('acc_equipment_rental_cos'),
                'note'              => app_lang('acc_equipment_rental_cos_note'),
                'order'             => 101,
                ],
            [
                'id'                => 102,
                'account_type_id'   => 13,
                'name'              => app_lang('acc_freight_and_delivery_cos'),
                'note'              => app_lang('acc_freight_and_delivery_cos_note'),
                'order'             => 102,
                ],
            [
                'id'                => 103,
                'account_type_id'   => 13,
                'name'              => app_lang('acc_other_costs_of_sales_cos'),
                'note'              => app_lang('acc_other_costs_of_sales_cos_note'),
                'order'             => 103,
                ],
            [
                'id'                => 104,
                'account_type_id'   => 13,
                'name'              => app_lang('acc_supplies_and_materials_cos'),
                'note'              => app_lang('acc_supplies_and_materials_cos_note'),
                'order'             => 104,
                ],
            [
                'id'                => 105,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_advertising_promotional'),
                'note'              => app_lang('acc_advertising_promotional_note'),
                'order'             => 105,
                ],
            [
                'id'                => 106,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_amortisation_expense'),
                'note'              => app_lang('acc_amortisation_expense_note'),
                'order'             => 106,
                ],
            [
                'id'                => 107,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_auto'),
                'note'              => app_lang('acc_auto_note'),
                'order'             => 107,
                ],
            [
                'id'                => 108,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_bad_debts'),
                'note'              => app_lang('acc_bad_debts_note'),
                'order'             => 108,
                ],
            [
                'id'                => 109,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_bank_charges'),
                'note'              => app_lang('acc_bank_charges_note'),
                'order'             => 109,
                ],
            [
                'id'                => 110,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_charitable_contributions'),
                'note'              => app_lang('acc_charitable_contributions_note'),
                'order'             => 110,
                ],
            [
                'id'                => 111,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_commissions_and_fees'),
                'note'              => app_lang('acc_commissions_and_fees_note'),
                'order'             => 111,
                ],
            [
                'id'                => 112,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_cost_of_labour'),
                'note'              => app_lang('acc_cost_of_labour_note'),
                'order'             => 112,
                ],
            [
                'id'                => 113,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_dues_and_subscriptions'),
                'note'              => app_lang('acc_dues_and_subscriptions_note'),
                'order'             => 113,
                ],
            [
                'id'                => 114,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_equipment_rental'),
                'note'              => app_lang('acc_equipment_rental_note'),
                'order'             => 114,
                ],
            [
                'id'                => 115,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_finance_costs'),
                'note'              => app_lang('acc_finance_costs_note'),
                'order'             => 115,
                ],
            [
                'id'                => 116,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_income_tax_expense'),
                'note'              => app_lang('acc_income_tax_expense_note'),
                'order'             => 116,
                ],
            [
                'id'                => 117,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_insurance'),
                'note'              => app_lang('acc_insurance_note'),
                'order'             => 117,
                ],
            [
                'id'                => 118,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_interest_paid'),
                'note'              => app_lang('acc_interest_paid_note'),
                'order'             => 118,
                ],
            [
                'id'                => 119,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_legal_and_professional_fees'),
                'note'              => app_lang('acc_legal_and_professional_fees_note'),
                'order'             => 119,
                ],
            [
                'id'                => 120,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_loss_on_discontinued_operations_net_of_tax'),
                'note'              => app_lang('acc_loss_on_discontinued_operations_net_of_tax_note'),
                'order'             => 120,
                ],
            [
                'id'                => 121,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_management_compensation'),
                'note'              => app_lang('acc_management_compensation_note'),
                'order'             => 121,
                ],
            [
                'id'                => 122,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_meals_and_entertainment'),
                'note'              => app_lang('acc_meals_and_entertainment_note'),
                'order'             => 122,
                ],
            [
                'id'                => 123,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_office_general_administrative_expenses'),
                'note'              => app_lang('acc_office_general_administrative_expenses_note'),
                'order'             => 123,
                ],
            [
                'id'                => 124,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_other_miscellaneous_service_cost'),
                'note'              => app_lang('acc_other_miscellaneous_service_cost_note'),
                'order'             => 124,
                ],
            [
                'id'                => 125,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_other_selling_expenses'),
                'note'              => app_lang('acc_other_selling_expenses_note'),
                'order'             => 125,
                ],
            [
                'id'                => 126,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_payroll_expenses'),
                'note'              => app_lang('acc_payroll_expenses_note'),
                'order'             => 126,
                ],
            [
                'id'                => 127,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_rent_or_lease_of_buildings'),
                'note'              => app_lang('acc_rent_or_lease_of_buildings_note'),
                'order'             => 127,
                ],
            [
                'id'                => 128,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_repair_and_maintenance'),
                'note'              => app_lang('acc_repair_and_maintenance_note'),
                'order'             => 128,
                ],
            [
                'id'                => 129,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_shipping_and_delivery_expense'),
                'note'              => app_lang('acc_shipping_and_delivery_expense_note'),
                'order'             => 129,
                ],
            [
                'id'                => 130,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_supplies_and_materials'),
                'note'              => app_lang('acc_supplies_and_materials_note'),
                'order'             => 130,
                ],
            [
                'id'                => 131,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_taxes_paid'),
                'note'              => app_lang('acc_taxes_paid_note'),
                'order'             => 131,
                ],
            [
                'id'                => 132,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_travel_expenses_general_and_admin_expenses'),
                'note'              => app_lang('acc_travel_expenses_general_and_admin_expenses_note'),
                'order'             => 132,
                ],
            [
                'id'                => 133,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_travel_expenses_selling_expense'),
                'note'              => app_lang('acc_travel_expenses_selling_expense_note'),
                'order'             => 133,
                ],
            [
                'id'                => 134,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_unapplied_cash_bill_payment_expense'),
                'note'              => app_lang('acc_unapplied_cash_bill_payment_expense_note'),
                'order'             => 134,
                ],
            [
                'id'                => 135,
                'account_type_id'   => 14,
                'name'              => app_lang('acc_utilities'),
                'note'              => app_lang('acc_utilities_note'),
                'order'             => 135,
                ],
            [
                'id'                => 136,
                'account_type_id'   => 15,
                'name'              => app_lang('acc_amortisation'),
                'note'              => app_lang('acc_amortisation_note'),
                'order'             => 136,
                ],
            [
                'id'                => 137,
                'account_type_id'   => 15,
                'name'              => app_lang('acc_depreciation'),
                'note'              => app_lang('acc_depreciation_note'),
                'order'             => 137,
                ],
            [
                'id'                => 138,
                'account_type_id'   => 15,
                'name'              => app_lang('acc_exchange_gain_or_loss'),
                'note'              => app_lang('acc_exchange_gain_or_loss_note'),
                'order'             => 138,
                ],
            [
                'id'                => 139,
                'account_type_id'   => 15,
                'name'              => app_lang('acc_other_expense'),
                'note'              => app_lang('acc_other_expense_note'),
                'order'             => 139,
                ],
            [
                'id'                => 140,
                'account_type_id'   => 15,
                'name'              => app_lang('acc_penalties_and_settlements'),
                'note'              => app_lang('acc_penalties_and_settlements_note'),
                'order'             => 140,
                ],
            ]);

        usort($account_type_details, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        $db_builder = $this->db->table(get_db_prefix().'acc_account_type_details');

        $account_type_details_2 = $db_builder->get()->getResultArray();

        return array_merge($account_type_details, $account_type_details_2);
    }

    /**
     * add default account
     */
    public function add_default_account(){

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');

        if($db_builder->countAllResults() > 1){
            return false;
        }

        $accounts = [
            [
                'name' => '',
                'key_name' => 'acc_accounts_receivable',
                'account_type_id' => 1,
                'account_detail_type_id' => 1,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_accrued_holiday_payable',
                'account_type_id' => 9,
                'account_detail_type_id' => 61,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_accrued_liabilities',
                'account_type_id' => 8,
                'account_detail_type_id' => 44,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_accrued_non_current_liabilities',
                'account_type_id' => 9,
                'account_detail_type_id' => 62,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_accumulated_depreciation_on_property_plant_and_equipment',
                'account_type_id' => 4,
                'account_detail_type_id' => 22,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_allowance_for_bad_debts',
                'account_type_id' => 2,
                'account_detail_type_id' => 2,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_amortisation_expense',
                'account_type_id' => 14,
                'account_detail_type_id' => 106,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_assets_held_for_sale',
                'account_type_id' => 5,
                'account_detail_type_id' => 32,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_available_for_sale_assets_short_term',
                'account_type_id' => 2,
                'account_detail_type_id' => 3,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_bad_debts',
                'account_type_id' => 14,
                'account_detail_type_id' => 108,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_bank_charges',
                'account_type_id' => 14,
                'account_detail_type_id' => 109,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_billable_expense_income',
                'account_type_id' => 11,
                'account_detail_type_id' => 89,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_cash_and_cash_equivalents',
                'account_type_id' => 3,
                'account_detail_type_id' => 15,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_change_in_inventory_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_commissions_and_fees',
                'account_type_id' => 14,
                'account_detail_type_id' => 111,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_cost_of_sales',
                'account_type_id' => 13,
                'account_detail_type_id' => 104,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_deferred_tax_assets',
                'account_type_id' => 5,
                'account_detail_type_id' => 33,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_direct_labour_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_discounts_given_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_dividend_disbursed',
                'account_type_id' => 10,
                'account_detail_type_id' => 69,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_dividend_income',
                'account_type_id' => 12,
                'account_detail_type_id' => 92,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_dividends_payable',
                'account_type_id' => 8,
                'account_detail_type_id' => 48,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_dues_and_subscriptions',
                'account_type_id' => 14,
                'account_detail_type_id' => 113,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_equipment_rental',
                'account_type_id' => 14,
                'account_detail_type_id' => 114,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_equity_in_earnings_of_subsidiaries',
                'account_type_id' => 10,
                'account_detail_type_id' => 70,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_freight_and_delivery_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_goodwill',
                'account_type_id' => 5,
                'account_detail_type_id' => 34,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_income_tax_expense',
                'account_type_id' => 14,
                'account_detail_type_id' => 116,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_income_tax_payable',
                'account_type_id' => 8,
                'account_detail_type_id' => 50,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_insurance_disability',
                'account_type_id' => 14,
                'account_detail_type_id' => 117,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_insurance_general',
                'account_type_id' => 14,
                'account_detail_type_id' => 117,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_insurance_liability',
                'account_type_id' => 14,
                'account_detail_type_id' => 117,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_intangibles',
                'account_type_id' => 5,
                'account_detail_type_id' => 35,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_interest_expense',
                'account_type_id' => 14,
                'account_detail_type_id' => 118,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_interest_income',
                'account_type_id' => 12,
                'account_detail_type_id' => 93,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_inventory',
                'account_type_id' => 2,
                'account_detail_type_id' => 5,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_inventory_asset',
                'account_type_id' => 2,
                'account_detail_type_id' => 5,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_legal_and_professional_fees',
                'account_type_id' => 14,
                'account_detail_type_id' => 119,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_liabilities_related_to_assets_held_for_sale',
                'account_type_id' => 9,
                'account_detail_type_id' => 63,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_long_term_debt',
                'account_type_id' => 9,
                'account_detail_type_id' => 64,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_long_term_investments',
                'account_type_id' => 5,
                'account_detail_type_id' => 38,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_loss_on_discontinued_operations_net_of_tax',
                'account_type_id' => 14,
                'account_detail_type_id' => 120,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_loss_on_disposal_of_assets',
                'account_type_id' => 12,
                'account_detail_type_id' => 94,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_management_compensation',
                'account_type_id' => 14,
                'account_detail_type_id' => 121,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_materials_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_meals_and_entertainment',
                'account_type_id' => 14,
                'account_detail_type_id' => 122,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_office_expenses',
                'account_type_id' => 14,
                'account_detail_type_id' => 123,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_other_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_other_comprehensive_income',
                'account_type_id' => 10,
                'account_detail_type_id' => 73,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_other_general_and_administrative_expenses',
                'account_type_id' => 14,
                'account_detail_type_id' => 123,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_other_operating_income_expenses',
                'account_type_id' => 12,
                'account_detail_type_id' => 97,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_other_selling_expenses',
                'account_type_id' => 14,
                'account_detail_type_id' => 125,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_other_type_of_expenses_advertising_expenses',
                'account_type_id' => 14,
                'account_detail_type_id' => 105,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_overhead_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_payroll_clearing',
                'account_type_id' => 8,
                'account_detail_type_id' => 55,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_payroll_expenses',
                'account_type_id' => 14,
                'account_detail_type_id' => 126,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_payroll_liabilities',
                'account_type_id' => 8,
                'account_detail_type_id' => 56,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_prepaid_expenses',
                'account_type_id' => 2,
                'account_detail_type_id' => 11,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_property_plant_and_equipment',
                'account_type_id' => 4,
                'account_detail_type_id' => 26,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_purchases',
                'account_type_id' => 14,
                'account_detail_type_id' => 130,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_reconciliation_discrepancies',
                'account_type_id' => 15,
                'account_detail_type_id' => 139,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_rent_or_lease_payments',
                'account_type_id' => 14,
                'account_detail_type_id' => 127,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_repair_and_maintenance',
                'account_type_id' => 14,
                'account_detail_type_id' => 128,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_retained_earnings',
                'account_type_id' => 10,
                'account_detail_type_id' => 80,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_revenue_general',
                'account_type_id' => 11,
                'account_detail_type_id' => 86,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_sales',
                'account_type_id' => 11,
                'account_detail_type_id' => 89,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_sales_retail',
                'account_type_id' => 11,
                'account_detail_type_id' => 87,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_sales_wholesale',
                'account_type_id' => 11,
                'account_detail_type_id' => 88,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_sales_of_product_income',
                'account_type_id' => 11,
                'account_detail_type_id' => 89,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_share_capital',
                'account_type_id' => 10,
                'account_detail_type_id' => 81,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_shipping_and_delivery_expense',
                'account_type_id' => 14,
                'account_detail_type_id' => 129,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_short_term_debit',
                'account_type_id' => 8,
                'account_detail_type_id' => 54,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_stationery_and_printing',
                'account_type_id' => 14,
                'account_detail_type_id' => 123,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_subcontractors_cos',
                'account_type_id' => 13,
                'account_detail_type_id' => 100,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_supplies',
                'account_type_id' => 14,
                'account_detail_type_id' => 130,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_travel_expenses_general_and_admin_expenses',
                'account_type_id' => 14,
                'account_detail_type_id' => 132,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_travel_expenses_selling_expense',
                'account_type_id' => 14,
                'account_detail_type_id' => 133,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_unapplied_cash_payment_income',
                'account_type_id' => 11,
                'account_detail_type_id' => 91,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_uncategorised_asset',
                'account_type_id' => 2,
                'account_detail_type_id' => 10,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_uncategorised_expense',
                'account_type_id' => 14,
                'account_detail_type_id' => 124,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_uncategorised_income',
                'account_type_id' => 11,
                'account_detail_type_id' => 89,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_undeposited_funds',
                'account_type_id' => 2,
                'account_detail_type_id' => 13,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_unrealised_loss_on_securities_net_of_tax',
                'account_type_id' => 12,
                'account_detail_type_id' => 99,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_utilities',
                'account_type_id' => 14,
                'account_detail_type_id' => 135,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_wage_expenses',
                'account_type_id' => 14,
                'account_detail_type_id' => 126,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_credit_card',
                'account_type_id' => 7,
                'account_detail_type_id' => 43,
                'default_account' => 1
            ],
            [
                'name' => '',
                'key_name' => 'acc_accounts_payable',
                'account_type_id' => 6,
                'account_detail_type_id' => 42,
                'default_account' => 1
            ],
        ];

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $affectedRows = $db_builder->insertBatch($accounts);

        if ($affectedRows > 0) {

            $db_builder = $this->db->table(get_db_prefix().'settings');


            $db_builder->where('setting_name', 'acc_add_default_account');
            $db_builder->update([
                    'setting_value' => 1,
                ]);

            return true;
        }

        return false;
    }

    /**
     * update general setting
     *
     * @param      array   $data   The data
     *
     * @return     boolean 
     */
    public function update_general_setting($data){
        $affectedRows = 0;
        if(!isset($data['acc_close_the_books'])){
            $data['acc_close_the_books'] = 0;
        }
        if(!isset($data['acc_enable_account_numbers'])){
            $data['acc_enable_account_numbers'] = 0;
        }
        if(!isset($data['acc_show_account_numbers'])){
            $data['acc_show_account_numbers'] = 0;
        }
       
        if($data['acc_closing_date'] != ''){
            $data['acc_closing_date'] = $data['acc_closing_date'];
        }

        $db_builder = $this->db->table(get_db_prefix() . 'settings');
        foreach ($data as $key => $value) {
            $db_builder->where('setting_name', $key);
            if ($db_builder->update(['setting_value' => $value])) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * update automatic conversion
     *
     * @param      array   $data   The data
     *
     * @return     boolean 
     */
    public function update_automatic_conversion($data){
        $affectedRows = 0;
        
        if(!isset($data['acc_invoice_automatic_conversion'])){
            $data['acc_invoice_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_payment_automatic_conversion'])){
            $data['acc_payment_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_credit_note_automatic_conversion'])){
            $data['acc_credit_note_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_expense_automatic_conversion'])){
            $data['acc_expense_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_tax_automatic_conversion'])){
            $data['acc_tax_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_payment_expense_automatic_conversion'])){
            $data['acc_payment_expense_automatic_conversion'] = 0;
        }

        foreach ($data as $key => $value) {
            $db_builder = $this->db->table(get_db_prefix() . 'settings');
            $db_builder->where('setting_name', $key);
            $db_builder->update([
                    'setting_value' => $value,
                ]);
            if ($this->db->affectedRows() > 0) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * get accounts
     * @param  integer $id    member group id
     * @param  array  $where
     * @return object
     */
    public function get_accounts($id = '', $where = [])
    {
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');

        if (is_numeric($id)) {
            $db_builder->where('id', $id);
            return $db_builder->get()->getRow();
        }

        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $db_builder->where($where);
        $db_builder->where('active', 1);
        $db_builder->orderBy('account_type_id,account_detail_type_id', 'desc');
        $accounts = $db_builder->get()->getResultArray();

        $account_types = $this->get_account_types();
        $detail_types = $this->get_account_type_details();

        $account_type_name = [];
        $detail_type_name = [];

        foreach ($account_types as $key => $value) {
            $account_type_name[$value['id']] = $value['name'];
        }

        foreach ($detail_types as $key => $value) {
            $detail_type_name[$value['id']] = $value['name'];
        }

        foreach ($accounts as $key => $value) {
            if($acc_show_account_numbers == 1 && $value['number'] != ''){
                $accounts[$key]['name'] = $value['name'] != '' ? $value['number'].' - '.$value['name'] : $value['number'].' - '.app_lang($value['key_name']);
            }else{
                $accounts[$key]['name'] = $value['name'] != '' ? $value['name'] : app_lang($value['key_name']);
            }
            
            $_account_type_name = isset($account_type_name[$value['account_type_id']]) ? $account_type_name[$value['account_type_id']] : '';
            $_detail_type_name = isset($detail_type_name[$value['account_detail_type_id']]) ? $detail_type_name[$value['account_detail_type_id']] : '';
            $accounts[$key]['account_type_name'] = $_account_type_name;
            $accounts[$key]['detail_type_name'] = $_detail_type_name;
        }

        return $accounts;
    }

    /**
     * add new account
     * @param array $data
     * @return integer
     */
    public function add_account($data)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        if($data['balance_as_of'] != ''){
            $data['balance_as_of'] = $data['balance_as_of'];
        }else{
            if($data['balance'] != 0 && $data['balance'] != ''){
                $data['balance_as_of'] = date('Y-m-d');
            }else{
                unset($data['balance_as_of']);
            }
        }

        if(isset($data['update_balance'])){
            unset($data['update_balance']);
        }

        $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
        $data['balance'] = str_replace(',', '', $data['balance']);

        $db_builder->insert($data);

        $insert_id = $this->db->insertID();

        if ($insert_id) {
            $users_model = model("App\Models\Users_model", false);
            $created_by = $users_model->login_user_id();

            if($data['balance'] != 0 && $data['balance'] != ''){
                $node = [];
                $node['account'] = $insert_id;
                $node['ending_balance'] = $data['balance'];
                $node['beginning_balance'] = 0;
                $node['finish'] = 1;
                if($data['balance_as_of'] != ''){
                    $node['ending_date'] = $data['balance_as_of'];
                }else{
                    $node['ending_date'] = date('Y-m-d');
                }
            
                $db_builder = $this->db->table(get_db_prefix() . 'acc_reconciles');
                $db_builder->insert($node);
                $reconcile_id = $this->db->insertID();

                $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
                $db_builder->where('account_type_id', 10);
                $db_builder->where('account_detail_type_id', 71);
                $account = $db_builder->get()->getRow();

                if($account){
                    $node = [];

                    if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                        if($data['balance'] > 0){
                            $node['debit'] = $data['balance'];
                            $node['credit'] = 0;
                        }else{
                            $node['debit'] = 0;
                            $node['credit'] = abs($data['balance']);
                        }
                    }else{
                        if($data['balance'] > 0){
                            $node['debit'] = 0;
                            $node['credit'] = $data['balance'];
                        }else{
                            $node['debit'] = abs($data['balance']);
                            $node['credit'] = 0;
                        }
                    }

                    $node['split'] = $insert_id;
                    $node['account'] = $account->id;
                    $node['rel_id'] = 0;
                    $node['rel_type'] = 'deposit';
                    if($data['balance_as_of'] != ''){
                        $node['date'] = $data['balance_as_of'];
                    }else{
                        $node['date'] = date('Y-m-d');
                    }
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;

                    $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                    $db_builder->insert($node);

                    $node = [];
                    if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                        if($data['balance'] > 0){
                            $node['debit'] = 0;
                            $node['credit'] = $data['balance'];
                        }else{
                            $node['debit'] = abs($data['balance']);
                            $node['credit'] = 0;
                        }
                    }else{
                        if($data['balance'] > 0){
                            $node['debit'] = $data['balance'];
                            $node['credit'] = 0;
                        }else{
                            $node['debit'] = 0;
                            $node['credit'] = abs($data['balance']);
                        }
                    }

                    $node['reconcile'] = $reconcile_id;
                    $node['split'] = $account->id;
                    $node['account'] = $insert_id;
                    $node['rel_id'] = 0;
                    $node['rel_type'] = 'deposit';
                    if($data['balance_as_of'] != ''){
                        $node['date'] = $data['balance_as_of'];
                    }else{
                        $node['date'] = date('Y-m-d');
                    }
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;

                    $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                    $db_builder->insert($node);
                }else{
                    $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
                    $db_builder->insert([
                        'name' => '',
                        'key_name' => 'acc_opening_balance_equity',
                        'account_type_id' => 10,
                        'account_detail_type_id' => 71,
                    ]);

                    $account_id = $this->db->insertID();

                    if ($account_id) {
                        $node = [];
                        if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                            if($data['balance'] > 0){
                                $node['debit'] = $data['balance'];
                                $node['credit'] = 0;
                            }else{
                                $node['debit'] = 0;
                                $node['credit'] = abs($data['balance']);
                            }
                        }else{
                            if($data['balance'] > 0){
                                $node['debit'] = 0;
                                $node['credit'] = $data['balance'];
                            }else{
                                $node['debit'] = abs($data['balance']);
                                $node['credit'] = 0;
                            }
                        }
                        
                        $node['split'] = $insert_id;
                        $node['account'] = $account_id;
                        if($data['balance_as_of'] != ''){
                            $node['date'] = $data['balance_as_of'];
                        }else{
                            $node['date'] = date('Y-m-d');
                        }
                        $node['rel_id'] = 0;
                        $node['rel_type'] = 'deposit';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;

                        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                        $db_builder->insert($node);

                        $node = [];
                        if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                            if($data['balance'] > 0){
                                $node['debit'] = 0;
                                $node['credit'] = $data['balance'];
                            }else{
                                $node['debit'] = abs($data['balance']);
                                $node['credit'] = 0;
                            }
                        }else{
                            if($data['balance'] > 0){
                                $node['debit'] = $data['balance'];
                                $node['credit'] = 0;
                            }else{
                                $node['debit'] = 0;
                                $node['credit'] = abs($data['balance']);
                            }
                        }
                        
                        $node['reconcile'] = $reconcile_id;
                        $node['split'] = $account_id;
                        $node['account'] = $insert_id;
                        if($data['balance_as_of'] != ''){
                            $node['date'] = $data['balance_as_of'];
                        }else{
                            $node['date'] = date('Y-m-d');
                        }
                        $node['rel_id'] = 0;
                        $node['rel_type'] = 'deposit';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;

                        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                        $db_builder->insert($node);
                    }
                }
            }

           
            return $insert_id;
        }

        return false;
    }

    /**
     * update account
     * @param array $data
     * @param integer $id
     * @return integer
     */
    public function update_account($data, $id)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        if($data['balance_as_of'] != ''){
            $data['balance_as_of'] = to_sql_date($data['balance_as_of']);
        }
        $update_balance = 0;
        if(isset($data['update_balance'])){
            $update_balance = $data['update_balance'];
            unset($data['update_balance']);
        }

        $data['balance'] = str_replace(',', '', $data['balance']);

        $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            $users_model = model("App\Models\Users_model", false);
            $created_by = $users_model->login_user_id();

            if($data['balance'] > 0 && $update_balance == 1){
                $node = [];
                $node['account'] = $id;
                $node['ending_balance'] = $data['balance'];
                $node['beginning_balance'] = 0;
                $node['finish'] = 1;
                if($data['balance_as_of'] != ''){
                    $node['ending_date'] = $data['balance_as_of'];
                }else{
                    $node['ending_date'] = date('Y-m-d');
                }
            
                $db_builder = $this->db->table(get_db_prefix() . 'acc_reconciles');
                $db_builder->insert($node);
                $reconcile_id = $this->db->insertID();

                $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
                $db_builder->where('account_type_id', 10);
                $db_builder->where('account_detail_type_id', 71);
                $account = $db_builder->get()->getRow();

                if($account){
                    $node = [];

                    if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                        $node['debit'] = $data['balance'];
                        $node['credit'] = 0;

                    }else{
                        $node['debit'] = 0;
                        $node['credit'] = $data['balance'];
                    }

                    $node['split'] = $id;
                    $node['account'] = $account->id;

                    if($data['balance_as_of'] != ''){
                        $node['date'] = $data['balance_as_of'];
                    }else{
                        $node['date'] = date('Y-m-d');
                    }

                    $node['rel_id'] = 0;
                    $node['rel_type'] = 'deposit';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                    $db_builder->insert($node);

                    $node = [];
                    if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                        $node['debit'] = 0;
                        $node['credit'] = $data['balance'];
                    }else{
                        $node['debit'] = $data['balance'];
                        $node['credit'] = 0;
                    }

                    $node['reconcile'] = $reconcile_id;
                    $node['split'] = $account->id;
                    $node['account'] = $id;
                    $node['rel_id'] = 0;

                    if($data['balance_as_of'] != ''){
                        $node['date'] = $data['balance_as_of'];
                    }else{
                        $node['date'] = date('Y-m-d');
                    }
                    $node['rel_type'] = 'deposit';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;

                    $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                    $db_builder->insert($node);
                }else{
                    $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
                    $db_builder->insert([
                        'name' => '',
                        'key_name' => 'acc_opening_balance_equity',
                        'account_type_id' => 10,
                        'account_detail_type_id' => 71,
                    ]);

                    $account_id = $this->db->insertID();

                    if ($account_id) {
                        $node = [];
                        if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                            $node['debit'] = $data['balance'];
                            $node['credit'] = 0;
                        }else{
                            $node['debit'] = 0;
                            $node['credit'] = $data['balance'];
                        }
                        
                        $node['split'] = $id;
                        $node['account'] = $account_id;
                        $node['rel_id'] = 0;
                        if($data['balance_as_of'] != ''){
                            $node['date'] = $data['balance_as_of'];
                        }else{
                            $node['date'] = date('Y-m-d');
                        }
                        $node['rel_type'] = 'deposit';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;

                        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                        $db_builder->insert($node);

                        $node = [];
                        if($data['account_type_id'] == 7 || $data['account_type_id'] == 15 || $data['account_type_id'] == 8 || $data['account_type_id'] == 9){
                            $node['debit'] = 0;
                            $node['credit'] = $data['balance'];
                        }else{
                            $node['debit'] = $data['balance'];
                            $node['credit'] = 0;
                        }
                        
                        $node['reconcile'] = $reconcile_id;
                        $node['split'] = $account_id;
                        $node['account'] = $id;
                        $node['rel_id'] = 0;
                        if($data['balance_as_of'] != ''){
                            $node['date'] = $data['balance_as_of'];
                        }else{
                            $node['date'] = date('Y-m-d');
                        }
                        $node['rel_type'] = 'deposit';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;

                        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                        $db_builder->insert($node);
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Get the data account to choose from.
     *
     * @return     array  The product group select.
     */
    public function get_data_account_to_select() {

        $accounts = $this->get_accounts();
        $list_accounts = [];

        $account_types = $this->get_account_types();
        $account_type_name = [];

        foreach ($account_types as $key => $value) {
            $account_type_name[$value['id']] = $value['name'];
        }

        foreach ($accounts as $key => $account) {
            $note = [];
            $note['id'] = $account['id'];

            $_account_type_name = isset($account_type_name[$account['account_type_id']]) ? $account_type_name[$account['account_type_id']] : '';
           
            $note['label'] = $account['name'].' - '.$_account_type_name;

            $list_accounts[] = $note;
        }
        return $list_accounts;
    }

    /**
     * add account history
     * @param array $data
     * @return boolean
     */
    public function add_account_history($data){
        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');

        $db_builder->where('rel_id', $data['id']);
        $db_builder->where('rel_type', $data['type']);
        $db_builder->delete();

        $data['amount'] = str_replace(',', '', $data['amount']);

        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        $data_insert = [];
        if($data['type'] == 'invoice'){
            if(!isset($data['payment_account'])){
                return false;
            }
            $Invoices_model = model('Invoices_model');
            $invoice = $Invoices_model->get_one($data['id']);
            $invoice_summary = $Invoices_model->get_invoice_total_summary($data['id']);

            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($invoice->bill_date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return 'close_the_book';
                }
            }

            $paid = 0;

            if($invoice_summary->balance_due == 0){
                $paid = 1;
            }else{
                $paid = 0;
            }

            $currency_converter = 0;

            

            $payment_account = $data['payment_account'];
            $deposit_to = $data['deposit_to'];
            $invoice_payment_account = get_setting('acc_invoice_payment_account');
            $invoice_deposit_to = get_setting('acc_invoice_deposit_to');
            $item_amount = $data['item_amount'];

            $Invoice_items_model = model('Invoice_items_model');
            $items = $Invoice_items_model->get_details(array("invoice_id" => $data['id']))->getResultArray();

            foreach ($items as $value) {
                $item = $this->get_item_by_name($value['description']);
                $item_id = 0;
                if(isset($item->id)){
                    $item_id = $item->id;
                }

                $item_total = $value['quantity'] * $value['rate'];

                if(isset($payment_account[$value['id']])) {
                    $node = [];
                    $node['itemable_id'] = $value['id'];
                    $node['split'] = $payment_account[$value['id']];
                    $node['account'] = $deposit_to[$value['id']];
                    $node['debit'] = $item_total;
                    $node['paid'] = $paid;
                    $node['date'] = $invoice->bill_date;
                    $node['item'] = $item_id;
                    $node['customer'] = $invoice->client_id;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['itemable_id'] = $value['id'];
                    $node['split'] = $deposit_to[$value['id']];
                    $node['paid'] = $paid;
                    $node['date'] = $invoice->bill_date;
                    $node['item'] = $item_id;
                    $node['account'] = $payment_account[$value['id']];
                    $node['customer'] = $invoice->client_id;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['itemable_id'] = $value['id'];
                    $node['split'] = $invoice_payment_account;
                    $node['account'] = $invoice_deposit_to;
                    $node['date'] = $invoice->bill_date;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['customer'] = $invoice->client_id;
                    $node['paid'] = $paid;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['itemable_id'] = $value['id'];
                    $node['split'] = $invoice_deposit_to;
                    $node['customer'] = $invoice->client_id;
                    $node['account'] = $invoice_payment_account;
                    $node['date'] = $invoice->bill_date;
                    $node['item'] = $item_id;
                    $node['paid'] = $paid;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }
            }

            if(get_setting('acc_tax_automatic_conversion') == 1){
                $tax_payment_account = get_setting('acc_tax_payment_account');
                $tax_deposit_to = get_setting('acc_tax_deposit_to');

                $tax_array = [];
                $tax_array[] = ['tax_name' => $invoice_summary->tax_name, 
                                'tax' => $invoice_summary->tax, 
                                'tax_rate' => $invoice_summary->tax_percentage];

                $tax_array[] = ['tax_name' => $invoice_summary->tax_name2, 
                                'tax' => $invoice_summary->tax2, 
                                'tax_rate' => $invoice_summary->tax_percentage2];

                $tax_array[] = ['tax_name' => $invoice_summary->tax_name3, 
                                'tax' => $invoice_summary->tax3, 
                                'tax_rate' => $invoice_summary->tax_percentage3];

                foreach($tax_array as $tax){
                    if($tax['tax'] == ''){
                        continue;
                    }
                    $tax_name = $tax['tax_name'];
                    $tax_rate = $tax['tax_rate'];

                    $db_builder = $this->db->table(get_db_prefix().'taxes');

                    $db_builder->where('title', $tax_name);
                    $db_builder->where('percentage', $tax_rate);
                    $_tax = $db_builder->get()->getRow();

                    $total_tax = $tax['tax'];
                    if($currency_converter == 1){
                        $total_tax = round($this->currency_converter($invoice->currency_name, $currency->name, $tax['total_tax']), 2);
                    }

                    if($_tax){
                        $tax_mapping = $this->get_tax_mapping($_tax->id);
                        if($tax_mapping){
                            $node = [];
                            $node['itemable_id'] = 0;
                            $node['split'] = $tax_mapping->payment_account;
                            $node['account'] = $tax_mapping->deposit_to;
                            $node['tax'] = $_tax->id;
                            $node['item'] = 0;
                            $node['paid'] = $paid;
                            $node['debit'] = $total_tax;
                            $node['credit'] = 0;
                            $node['customer'] = $invoice->client_id;
                            $node['date'] = $invoice->bill_date;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'invoice';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;

                            $node = [];
                            $node['itemable_id'] = 0;
                            $node['split'] = $tax_mapping->deposit_to;
                            $node['customer'] = $invoice->client_id;
                            $node['account'] = $tax_mapping->payment_account;
                            $node['tax'] = $_tax->id;
                            $node['item'] = 0;
                            $node['paid'] = $paid;
                            $node['date'] = $invoice->bill_date;
                            $node['debit'] = 0;
                            $node['credit'] = $total_tax;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'invoice';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;
                        }else{
                            $node = [];
                            $node['itemable_id'] = 0;
                            $node['split'] = $tax_payment_account;
                            $node['account'] = $tax_deposit_to;
                            $node['tax'] = $_tax->id;
                            $node['item'] = 0;
                            $node['date'] = $invoice->bill_date;
                            $node['paid'] = $paid;
                            $node['debit'] = $total_tax;
                            $node['customer'] = $invoice->client_id;
                            $node['credit'] = 0;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'invoice';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;

                            $node = [];
                            $node['itemable_id'] = 0;
                            $node['split'] = $tax_deposit_to;
                            $node['customer'] = $invoice->client_id;
                            $node['account'] = $tax_payment_account;
                            $node['date'] = $invoice->bill_date;
                            $node['tax'] = $_tax->id;
                            $node['item'] = 0;
                            $node['paid'] = $paid;
                            $node['debit'] = 0;
                            $node['credit'] = $total_tax;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'invoice';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;
                        }
                    }else{
                        $node = [];
                        $node['itemable_id'] = 0;
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = 0;
                        $node['item'] = 0;
                        $node['date'] = $invoice->bill_date;
                        $node['paid'] = $paid;
                        $node['debit'] = $total_tax;
                        $node['customer'] = $invoice->client_id;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = 'invoice';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['itemable_id'] = 0;
                        $node['split'] = $tax_deposit_to;
                        $node['customer'] = $invoice->client_id;
                        $node['account'] = $tax_payment_account;
                        $node['date'] = $invoice->bill_date;
                        $node['tax'] = 0;
                        $node['item'] = 0;
                        $node['paid'] = $paid;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = 'invoice';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }
                }
            }
        }elseif($data['type'] == 'loss_adjustment'){

            $this->load->model('warehouse/warehouse_model');
            $loss_adjustment = $this->warehouse_model->get_loss_adjustment($data['id']);
            $loss_adjustment_detail = $this->warehouse_model->get_loss_adjustment_detailt_by_masterid($data['id']);

            $this->load->model('currencies_model');
            $currency = $this->currencies_model->get_base_currency();

            $payment_account = $data['payment_account'];
            $deposit_to = $data['deposit_to'];
            $item_amount = $data['item_amount'];

            $decrease_payment_account = get_setting('acc_wh_decrease_payment_account');
            $decrease_deposit_to = get_setting('acc_wh_decrease_deposit_to');
            $increase_payment_account = get_setting('acc_wh_increase_payment_account');
            $increase_deposit_to = get_setting('acc_wh_increase_deposit_to');


            foreach ($loss_adjustment_detail as $value) {
                if($value['current_number'] < $value['loss_adjustment']){
                    $loss_adjustment_payment_account = $increase_payment_account;
                    $loss_adjustment_deposit_to = $increase_deposit_to;
                }else{
                    $loss_adjustment_payment_account = $decrease_payment_account;
                    $loss_adjustment_deposit_to = $decrease_deposit_to;
                }

                $item_id = $value['items'];
                $item_total = $item_amount[$item_id];

                if(isset($payment_account[$item_id])) {
                    $node = [];
                    $node['split'] = $payment_account[$item_id];
                    $node['account'] = $deposit_to[$item_id];
                    $node['debit'] = $item_total;
                    $node['date'] = date('Y-m-d', strtotime($loss_adjustment->time));
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to[$item_id];
                    $node['date'] = date('Y-m-d', strtotime($loss_adjustment->time));
                    $node['item'] = $item_id;
                    $node['account'] = $payment_account[$item_id];
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['split'] = $loss_adjustment_payment_account;
                    $node['account'] = $loss_adjustment_deposit_to;
                    $node['date'] = date('Y-m-d', strtotime($loss_adjustment->time));
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $loss_adjustment_deposit_to;
                    $node['account'] = $loss_adjustment_payment_account;
                    $node['date'] = date('Y-m-d', strtotime($loss_adjustment->time));
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }
            }
        }elseif($data['type'] == 'stock_export'){

            $this->load->model('warehouse/warehouse_model');
            $goods_delivery = $this->warehouse_model->get_goods_delivery($data['id']);
            $goods_delivery_detail = $this->warehouse_model->get_goods_delivery_detail($data['id']);

            $this->load->model('currencies_model');
            $currency = $this->currencies_model->get_base_currency();

            $payment_account = $data['payment_account'];
            $deposit_to = $data['deposit_to'];
            $stock_export_payment_account = get_setting('acc_wh_stock_export_payment_account');
            $stock_export_deposit_to = get_setting('acc_wh_stock_export_deposit_to');
            $item_amount = $data['item_amount'];

            foreach ($goods_delivery_detail as $value) {
                $item_id = $value['commodity_code'];
                $item_total = $item_amount[$item_id];

                if(isset($payment_account[$item_id])) {
                    $node = [];
                    $node['split'] = $payment_account[$item_id];
                    $node['account'] = $deposit_to[$item_id];
                    $node['debit'] = $item_total;
                    $node['date'] = $goods_delivery->date_c;
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to[$item_id];
                    $node['date'] = $goods_delivery->date_c;
                    $node['item'] = $item_id;
                    $node['account'] = $payment_account[$item_id];
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['split'] = $stock_export_payment_account;
                    $node['account'] = $stock_export_deposit_to;
                    $node['date'] = $goods_delivery->date_c;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $stock_export_deposit_to;
                    $node['account'] = $stock_export_payment_account;
                    $node['date'] = $goods_delivery->date_c;
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }
                if(get_setting('acc_tax_automatic_conversion') == 1 && $value['tax_id'] != 0){
                    $tax_payment_account = get_setting('acc_expense_tax_payment_account');
                    $tax_deposit_to = get_setting('acc_expense_tax_deposit_to');

                    $total_tax = $value['total_money'] - $item_total;

                    $tax_mapping = $this->get_tax_mapping($value['tax_id']);

                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->payment_account;
                        $node['account'] = $tax_mapping->deposit_to;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['date'] = $goods_delivery->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->deposit_to;
                        $node['account'] = $tax_mapping->payment_account;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['date'] = $goods_delivery->date_c;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['date'] = $goods_delivery->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['date'] = $goods_delivery->date_c;
                        $node['account'] = $tax_payment_account;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }
                }
            }
        }elseif($data['type'] == 'stock_import'){

            $this->load->model('warehouse/warehouse_model');
            $goods_receipt = $this->warehouse_model->get_goods_receipt($data['id']);
            $goods_receipt_detail = $this->warehouse_model->get_goods_receipt_detail($data['id']);

            $this->load->model('currencies_model');
            $currency = $this->currencies_model->get_base_currency();

            $payment_account = $data['payment_account'];
            $deposit_to = $data['deposit_to'];
            $stock_import_payment_account = get_setting('acc_wh_stock_import_payment_account');
            $stock_import_deposit_to = get_setting('acc_wh_stock_import_deposit_to');
            $item_amount = $data['item_amount'];

            foreach ($goods_receipt_detail as $value) {
                $item_id = $value['commodity_code'];
                $item_total = $item_amount[$item_id];

                if(isset($payment_account[$item_id])) {
                    $node = [];
                    $node['split'] = $payment_account[$item_id];
                    $node['account'] = $deposit_to[$item_id];
                    $node['debit'] = $item_total;
                    $node['date'] = $goods_receipt->date_c;
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to[$item_id];
                    $node['date'] = $goods_receipt->date_c;
                    $node['item'] = $item_id;
                    $node['account'] = $payment_account[$item_id];
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['split'] = $stock_import_payment_account;
                    $node['account'] = $stock_import_deposit_to;
                    $node['date'] = $goods_receipt->date_c;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $stock_import_deposit_to;
                    $node['account'] = $stock_import_payment_account;
                    $node['date'] = $goods_receipt->date_c;
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }
                if(get_setting('acc_tax_automatic_conversion') == 1 && $value['tax'] != 0){
                    $tax_payment_account = get_setting('acc_expense_tax_payment_account');
                    $tax_deposit_to = get_setting('acc_expense_tax_deposit_to');

                    $total_tax = $value['tax_money'];

                    $tax_mapping = $this->get_tax_mapping($value['tax']);

                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->payment_account;
                        $node['account'] = $tax_mapping->deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $goods_receipt->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->deposit_to;
                        $node['account'] = $tax_mapping->payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $goods_receipt->date_c;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $goods_receipt->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['date'] = $goods_receipt->date_c;
                        $node['account'] = $tax_payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }
                }
            }
        }elseif($data['type'] == 'purchase_order'){
            $this->load->model('purchase/purchase_model');
            $purchase_order = $this->purchase_model->get_pur_order($data['id']);
            $purchase_order_detail = $this->purchase_model->get_pur_order_detail($data['id']);

            $this->load->model('currencies_model');
            $currency = $this->currencies_model->get_base_currency();

            $payment_account = $data['payment_account'];
            $deposit_to = $data['deposit_to'];
            
            $expense_payment_account = get_setting('acc_pur_order_payment_account');
            $expense_deposit_to = get_setting('acc_pur_order_deposit_to');

            $item_amount = $data['item_amount'];
            foreach ($purchase_order_detail as $value) {
                $item_id = $value['item_code'];
                $item_total = $item_amount[$item_id];

                if(isset($payment_account[$item_id])) {

                    $node = [];
                    $node['split'] = $payment_account[$item_id];
                    $node['account'] = $deposit_to[$item_id];
                    $node['debit'] = $item_total;
                    $node['date'] = $purchase_order->order_date;
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to[$item_id];
                    $node['date'] = $purchase_order->order_date;
                    $node['item'] = $item_id;
                    $node['account'] = $payment_account[$item_id];
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['split'] = $expense_payment_account;
                    $node['account'] = $expense_deposit_to;
                    $node['date'] = $purchase_order->order_date;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $expense_deposit_to;
                    $node['account'] = $expense_payment_account;
                    $node['date'] = $purchase_order->order_date;
                    $node['item'] = $item_id;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $data['id'];
                    $node['rel_type'] = $data['type'];
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }
                if(get_setting('acc_tax_automatic_conversion') == 1 && $value['tax'] > 0){
                    $tax_payment_account = get_setting('acc_expense_tax_payment_account');
                    $tax_deposit_to = get_setting('acc_expense_tax_deposit_to');

                    $total_tax = $value['total'] - $value['into_money'];

                    $tax_mapping = $this->get_tax_mapping($value['tax']);

                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->payment_account;
                        $node['account'] = $tax_mapping->deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $purchase_order->order_date;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->deposit_to;
                        $node['account'] = $tax_mapping->payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $purchase_order->order_date;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $purchase_order->order_date;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['date'] = $purchase_order->order_date;
                        $node['account'] = $tax_payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $data['id'];
                        $node['rel_type'] = $data['type'];
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }
                }
            }

        }elseif ($data['type'] == 'payslip') {
            $date = date('Y-m-d');

                $node = [];
                $node['split'] = $data['payment_account_insurance'];
                $node['account'] = $data['deposit_to_insurance'];
                $node['debit'] = $data['total_insurance'];
                $node['date'] = $date;
                $node['credit'] = 0;
                $node['tax'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $data['id'];
                $node['rel_type'] = $data['type'];
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $node['payslip_type'] = 'total_insurance';
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $data['deposit_to_insurance'];
                $node['account'] = $data['payment_account_insurance'];
                $node['date'] = $date;
                $node['tax'] = 0;
                $node['debit'] = 0;
                $node['credit'] = $data['total_insurance'];
                $node['description'] = '';
                $node['rel_id'] = $data['id'];
                $node['rel_type'] = $data['type'];
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $node['payslip_type'] = 'total_insurance';
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $data['payment_account_tax_paye'];
                $node['account'] = $data['deposit_to_tax_paye'];
                $node['debit'] = $data['tax_paye'];
                $node['date'] = $date;
                $node['credit'] = 0;
                $node['tax'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $data['id'];
                $node['rel_type'] = $data['type'];
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $node['payslip_type'] = 'tax_paye';
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $data['deposit_to_tax_paye'];
                $node['account'] = $data['payment_account_tax_paye'];
                $node['date'] = $date;
                $node['tax'] = 0;
                $node['debit'] = 0;
                $node['credit'] = $data['tax_paye'];
                $node['description'] = '';
                $node['rel_id'] = $data['id'];
                $node['rel_type'] = $data['type'];
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $node['payslip_type'] = 'tax_paye';
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $data['payment_account_net_pay'];
                $node['account'] = $data['deposit_to_net_pay'];
                $node['debit'] = $data['net_pay'];
                $node['date'] = $date;
                $node['credit'] = 0;
                $node['tax'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $data['id'];
                $node['rel_type'] = $data['type'];
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $node['payslip_type'] = 'net_pay';
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $data['deposit_to_net_pay'];
                $node['account'] = $data['payment_account_net_pay'];
                $node['date'] = $date;
                $node['tax'] = 0;
                $node['debit'] = 0;
                $node['credit'] = $data['net_pay'];
                $node['description'] = '';
                $node['rel_id'] = $data['id'];
                $node['rel_type'] = $data['type'];
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $node['payslip_type'] = 'net_pay';
                $data_insert[] = $node;

        }elseif($data['type'] == 'opening_stock'){
            $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

            $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));

            $date = date('Y-m-d');

            $node = [];
            $node['split'] = $data['payment_account'];
            $node['account'] = $data['deposit_to'];
            $node['debit'] = $data['amount'];
            $node['date'] = $date;
            $node['credit'] = 0;
            $node['tax'] = 0;
            $node['description'] = '';
            $node['rel_id'] = $data['id'];
            $node['rel_type'] = $data['type'];
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = get_staff_user_id();
            $data_insert[] = $node;

            $node = [];
            $node['split'] = $data['deposit_to'];
            $node['account'] = $data['payment_account'];
            $node['date'] = $date;
            $node['tax'] = 0;
            $node['debit'] = 0;
            $node['credit'] = $data['amount'];
            $node['description'] = '';
            $node['rel_id'] = $data['id'];
            $node['rel_type'] = $data['type'];
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = get_staff_user_id();
            $data_insert[] = $node;
        }else{
            $customer = 0;
            $date = date('Y-m-d');
            $description = '';
            
            if($data['type'] == 'payment'){
                $Invoice_payments_model = model('Invoice_payments_model');
                $Invoices_model = model('Invoices_model');

                $payment = $Invoice_payments_model->get_one($data['id']);
                $date = $payment->payment_date;
                $invoice = $Invoices_model->get_one($payment->invoice_id);

                if(get_setting('acc_close_the_books') == 1){
                    if(strtotime($payment->payment_date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                        return 'close_the_book';
                    }
                }

                $this->automatic_invoice_conversion($payment->invoice_id);
                
                $customer = $invoice->client_id;
            }elseif ($data['type'] == 'expense') {
                $Expenses_model = model('Expenses_model');
                $expense = $Expenses_model->get_details(['id' =>$data['id']])->getRow();
                $date = $expense->expense_date;
                $customer = $expense->client_id;

                if(get_setting('acc_close_the_books') == 1){
                    if(strtotime($expense->expense_date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                        return 'close_the_book';
                    }
                }

                if(get_setting('acc_tax_automatic_conversion') == 1){
                    $tax_payment_account = get_setting('acc_tax_payment_account');
                    $tax_deposit_to = get_setting('acc_tax_deposit_to');

                    if($expense->tax_id > 0){

                        $total_tax = $expense->amount * ($expense->tax_percentage / 100);

                        $tax_mapping = $this->get_tax_mapping($expense->tax_id);
                        if($tax_mapping){
                            $node = [];
                            $node['split'] = $tax_mapping->expense_payment_account;
                            $node['account'] = $tax_mapping->expense_deposit_to;
                            $node['tax'] = $expense->tax_id;
                            $node['debit'] = $total_tax;
                            $node['credit'] = 0;
                            $node['customer'] = $expense->client_id;
                            $node['date'] = $expense->expense_date;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;

                            $node = [];
                            $node['split'] = $tax_mapping->expense_deposit_to;
                            $node['customer'] = $expense->client_id;
                            $node['account'] = $tax_mapping->expense_payment_account;
                            $node['tax'] = $expense->tax_id;
                            $node['date'] = $expense->expense_date;
                            $node['debit'] = 0;
                            $node['credit'] = $total_tax;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;
                        }else{
                            $node = [];
                            $node['split'] = $tax_payment_account;
                            $node['account'] = $tax_deposit_to;
                            $node['tax'] = $expense->tax_id;
                            $node['date'] = $expense->expense_date;
                            $node['debit'] = $total_tax;
                            $node['customer'] = $expense->client_id;
                            $node['credit'] = 0;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;

                            $node = [];
                            $node['split'] = $tax_deposit_to;
                            $node['customer'] = $expense->client_id;
                            $node['account'] = $tax_payment_account;
                            $node['date'] = $expense->expense_date;
                            $node['tax'] = $expense->tax_id;
                            $node['debit'] = 0;
                            $node['credit'] = $total_tax;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;
                        }
                    }

                    if($expense->tax_id2 > 0){
                        $total_tax = $expense->amount * ($expense->tax_percentage2 / 100);

                        $tax_mapping = $this->get_tax_mapping($expense->tax_id2);
                        if($tax_mapping){
                            $node = [];
                            $node['split'] = $tax_mapping->expense_payment_account;
                            $node['account'] = $tax_mapping->expense_deposit_to;
                            $node['tax'] = $expense->tax_id2;
                            $node['debit'] = $total_tax;
                            $node['credit'] = 0;
                            $node['customer'] = $expense->client_id;
                            $node['date'] = $expense->expense_date;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;

                            $node = [];
                            $node['split'] = $tax_mapping->expense_deposit_to;
                            $node['customer'] = $expense->client_id;
                            $node['account'] = $tax_mapping->expense_payment_account;
                            $node['tax'] = $expense->tax_id2;
                            $node['date'] = $expense->expense_date;
                            $node['debit'] = 0;
                            $node['credit'] = $total_tax;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;
                        }else{
                            $node = [];
                            $node['split'] = $tax_payment_account;
                            $node['account'] = $tax_deposit_to;
                            $node['tax'] = $expense->tax_id2;
                            $node['date'] = $expense->expense_date;
                            $node['debit'] = $total_tax;
                            $node['customer'] = $expense->client_id;
                            $node['credit'] = 0;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;

                            $node = [];
                            $node['split'] = $tax_deposit_to;
                            $node['customer'] = $expense->client_id;
                            $node['account'] = $tax_payment_account;
                            $node['date'] = $expense->expense_date;
                            $node['tax'] = $expense->tax_id2;
                            $node['debit'] = 0;
                            $node['credit'] = $total_tax;
                            $node['description'] = '';
                            $node['rel_id'] = $data['id'];
                            $node['rel_type'] = 'expense';
                            $node['datecreated'] = date('Y-m-d H:i:s');
                            $node['addedfrom'] = $created_by;
                            $data_insert[] = $node;
                        }
                    }
                }
            }elseif($data['type'] == 'banking'){
                $banking = $this->get_transaction_banking($data['id']);
                if($banking){
                    $date = $banking->date;
                    $description = $banking->description;
                }
            }elseif($data['type'] == 'purchase_payment'){
                $this->load->model('purchase/purchase_model');
                $payment = $this->purchase_model->get_payment_pur_invoice($data['id']);
                $date = $payment->date;
                $data['amount'] = $payment->amount;
            }

            $node = [];
            $node['split'] = $data['payment_account'];
            $node['account'] = $data['deposit_to'];
            $node['debit'] = $data['amount'];
            $node['customer'] = $customer;
            $node['date'] = $date;
            $node['credit'] = 0;
            $node['tax'] = 0;
            $node['description'] = $description;
            $node['rel_id'] = $data['id'];
            $node['rel_type'] = $data['type'];
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = $created_by;
            $data_insert[] = $node;

            $node = [];
            $node['split'] = $data['deposit_to'];
            $node['account'] = $data['payment_account'];
            $node['customer'] = $customer;
            $node['date'] = $date;
            $node['tax'] = 0;
            $node['debit'] = 0;
            $node['credit'] = $data['amount'];
            $node['description'] = $description;
            $node['rel_id'] = $data['id'];
            $node['rel_type'] = $data['type'];
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = $created_by;
            $data_insert[] = $node;
        }
        $db = db_connect('default');

        $db_builder = $db->table(get_db_prefix().'acc_account_history');
        $affectedRows = $db_builder->insertBatch($data_insert);

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    /**
     * add transfer
     * @param array $data
     * @return boolean
     */
    public function add_transfer($data){

        if(isset($data['id'])){
            unset($data['id']);
        }
        if(get_setting('acc_close_the_books') == 1){
            if(strtotime($data['date']) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                return 'close_the_book';
            }
        }
        $data['transfer_amount'] = str_replace(',', '', $data['transfer_amount']);
        $data['datecreated'] = date('Y-m-d H:i:s');
        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        $data['addedfrom'] = $created_by;
        $db_builder = $this->db->table(get_db_prefix().'acc_transfers');
        $db_builder->insert($data);
        $insert_id = $this->db->insertID();
        
        if($insert_id){
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');

            $node = [];
            $node['split'] = $data['transfer_funds_to'];
            $node['account'] = $data['transfer_funds_from'];
            $node['debit'] = 0;
            $node['date'] = $data['date'];
            $node['credit'] = $data['transfer_amount'];
            $node['rel_id'] = $insert_id;
            $node['rel_type'] = 'transfer';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = $created_by;

            $db_builder->insert($node);

            $node = [];
            $node['split'] = $data['transfer_funds_from'];
            $node['account'] = $data['transfer_funds_to'];
            $node['debit'] = $data['transfer_amount'];
            $node['date'] = $data['date'];
            $node['credit'] = 0;
            $node['rel_id'] = $insert_id;
            $node['rel_type'] = 'transfer';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = $created_by;

            $db_builder->insert($node);

            return true;
        }

        return false;
    }

    /**
     * add journal entry
     * @param array $data 
     * @return boolean
     */
    public function add_journal_entry($data){
        $journal_entry = json_decode($data['journal_entry']);
        unset($data['journal_entry']);

        if(get_setting('acc_close_the_books') == 1){
            if(strtotime($data['journal_date']) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                return 'close_the_book';
            }
        }
        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = $created_by;

        $db_builder = $this->db->table(get_db_prefix().'acc_journal_entries');
        
        $db_builder->insert($data);
        $insert_id = $this->db->insertID();
        
        if($insert_id){
            $data_insert = [];

            foreach ($journal_entry as $key => $value) {
                if($value[0] != ''){
                    $node = [];
                    $node['account'] = $value[0];
                    $node['date'] = $data['journal_date'];
                    $node['debit'] = $value[1];
                    $node['credit'] = $value[2];
                    $node['description'] = $value[3];
                    $node['rel_id'] = $insert_id;
                    $node['rel_type'] = 'journal_entry';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;

                    $data_insert[] = $node;
                }
            }
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            
            $db_builder->insertBatch($data_insert);

            return true;
        }

        return false;
    }

    /**
     * get data balance sheet
     * @param  array $data_filter
     * @return array           
     */
    public function get_data_balance_sheet($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_balance_sheet_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $child_account];
                        $total += $credits - $debits;
                    }else{
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $child_account];
                        $total += $debits - $credits;
                    }

                }
            }
            $data_total[$data_key] = $total;
        }

        $data_total_2 = [];
        foreach ($data_accounts as $data_key => $data_account) {
            if($data_key != 'income' && $data_key != 'other_income' && $data_key != 'cost_of_sales' && $data_key != 'expenses' && $data_key != 'other_expenses'){
                continue;
            }
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }


                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7){
                        $total += $credits - $debits;
                    }else{
                        $total += $debits - $credits;
                    }

                }
            }
            $data_total_2[$data_key] = $total;
        }

        $income = $data_total_2['income'] + $data_total_2['other_income'];
        $expenses = $data_total_2['expenses'] + $data_total_2['other_expenses'] + $data_total_2['cost_of_sales'];
        $net_income = $income - $expenses;

        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date, 'net_income' => $net_income];
        
    }

    /**
     * get data balance sheet comparison
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_balance_sheet_comparison($data_filter){
        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $last_from_date = date('Y-m-d', strtotime($from_date.' - 1 year'));
        $last_to_date = date('Y-m-d', strtotime($to_date.' - 1 year'));
        $this_year = date('Y', strtotime($to_date));
        $last_year = date('Y', strtotime($last_to_date));

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }
        
        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            $py_total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date_format(datecreated, \'%Y-%m-%d\') >= "' . $last_from_date . '" and date_format(datecreated, \'%Y-%m-%d\') <= "' . $last_to_date . '")');
                    $py_account_history = $db_builder->get()->getRow();
                    $py_credits = $py_account_history->credit != '' ? $py_account_history->credit : 0;
                    $py_debits = $py_account_history->debit != '' ? $py_account_history->debit : 0;

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_balance_sheet_comparison_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers);
                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                        $data_report[$data_key][] = ['name' => $name, 'amount' => ($credits - $debits), 'py_amount' => ($py_credits - $py_debits), 'child_account' => $child_account];
                        $total += $credits - $debits;
                        $py_total += $py_credits - $py_debits;
                    }else{
                        $data_report[$data_key][] = ['name' => $name, 'amount' => ($debits - $credits), 'py_amount' => ($py_debits - $py_credits), 'child_account' => $child_account];
                        $total += $debits - $credits;
                        $py_total += $py_debits - $py_credits;
                    }
                }
            }
            $data_total[$data_key] = ['this_year' => $total, 'last_year' => $py_total];
        }

        $data_total_2 = [];
        foreach ($data_accounts as $data_key => $data_account) {
            if($data_key != 'income' && $data_key != 'other_income' && $data_key != 'cost_of_sales' && $data_key != 'expenses' && $data_key != 'other_expenses'){
                continue;
            }
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date_format(datecreated, \'%Y-%m-%d\') >= "' . $last_from_date . '" and date_format(datecreated, \'%Y-%m-%d\') <= "' . $last_to_date . '")');
                    $py_account_history = $db_builder->get()->getRow();
                    $py_credits = $py_account_history->credit != '' ? $py_account_history->credit : 0;
                    $py_debits = $py_account_history->debit != '' ? $py_account_history->debit : 0;

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7){
                        $total += $credits - $debits;
                        $py_total += $py_credits - $py_debits;
                    }else{
                        $total += $debits - $credits;
                        $py_total += $py_debits - $py_credits;
                    }

                }
            }
            $data_total_2[$data_key] = ['this_year' => $total, 'last_year' => $py_total];
        }
        
        $this_income = $data_total_2['income']['this_year'] + $data_total_2['other_income']['this_year'];
        $this_expenses = $data_total_2['expenses']['this_year'] + $data_total_2['other_expenses']['this_year'] + $data_total_2['cost_of_sales']['this_year'];
        $this_net_income = $this_income - $this_expenses;

        $last_income = $data_total_2['income']['last_year'] + $data_total_2['other_income']['last_year'];
        $last_expenses = $data_total_2['expenses']['last_year'] + $data_total_2['other_expenses']['last_year'] + $data_total_2['cost_of_sales']['last_year'];
        $last_net_income = $last_income - $last_expenses;

        return ['data' => $data_report, 'total' => $data_total, 'this_year' => $this_year, 'last_year' => $last_year, 'from_date' => $from_date, 'to_date' => $to_date, 'this_net_income' => $this_net_income, 'last_net_income' => $last_net_income];
    }

    /**
     * get data balance sheet detail
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_balance_sheet_detail($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }
        
        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            if($data_key != 'income' && $data_key != 'other_income' && $data_key != 'cost_of_sales' && $data_key != 'expenses' && $data_key != 'other_expenses'){
            $data_report[$data_key] = [];
            $total = 0;
            $balance_total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }

                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->orderBy('date', 'asc');
                    $account_history = $db_builder->get()->getResultArray();
                    $node = [];
                    $balance = 0;
                    $amount = 0;
                    foreach ($account_history as $v) {
                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 10 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                            $am = $v['credit'] - $v['debit'];
                        }else{
                            $am = $v['debit'] - $v['credit'];
                        }

                        $node[] =   [
                                        'date' => date('Y-m-d', strtotime($v['date'])),
                                        'type' => app_lang($v['rel_type']),
                                        'description' => $v['description'],
                                        'debit' => $v['debit'],
                                        'credit' => $v['credit'],
                                        'amount' => $am,
                                        'balance' => $balance + $am,
                                    ];
                            $amount += $am;
                            $balance += $am;
                    }

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_balance_sheet_detail_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);
                    
                    $data_report[$data_key][] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' => $child_account];


                    $total += $amount;
                    $balance_total += $balance;
                }
            }
            $data_total[$data_key] = ['amount' => $total, 'balance' => $balance_total];
            }
        }
        $data_total_2 = [];
        foreach ($data_accounts as $data_key => $data_account) {
            if($data_key != 'income' && $data_key != 'other_income' && $data_key != 'cost_of_sales' && $data_key != 'expenses' && $data_key != 'other_expenses'){
                continue;
            }
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7){
                        $total += $credits - $debits;
                    }else{
                        $total += $debits - $credits;
                    }

                }
            }
            $data_total_2[$data_key] = $total;
        }

        $income = $data_total_2['income'] + $data_total_2['other_income'];
        $expenses = $data_total_2['expenses'] + $data_total_2['other_expenses'] + $data_total_2['cost_of_sales'];
        $net_income = $income - $expenses;

        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date, 'net_income' => $net_income];
        
    }

    /**
     * get data balance sheet summary
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_balance_sheet_summary($data_filter){
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }
        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_balance_sheet_summary_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);
                    
                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $child_account];
                        $total += $credits - $debits;
                    }else{
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $child_account];
                        $total += $debits - $credits;
                    }
                }
            }
            $data_total[$data_key] = $total;
        }

        $income = $data_total['income'] + $data_total['other_income'];
        $expenses = $data_total['expenses'] + $data_total['other_expenses'] + $data_total['cost_of_sales'];
        $net_income = $income - $expenses;

        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date, 'net_income' => $net_income];
        
    }

    /**
     * get data custom summary report
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_custom_summary_report($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $display_rows_by = 'income_statement';
        $display_columns_by = 'total_only';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['display_rows_by'])){
            $display_rows_by = $data_filter['display_rows_by'];
        }

        if(isset($data_filter['display_columns_by'])){
            $display_columns_by = $data_filter['display_columns_by'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        $headers = [];
        if($display_rows_by == 'total_only'){
            $headers[] = app_lang('total');
        }elseif ($display_rows_by == 'months') {
            $start = $month = strtotime($from_date);
            $end = strtotime($to_date);

            while($month < $end)
            {
                $headers[] = date('', $month);
                $month = strtotime("+1 month", $month);
            }
        }

        if($display_rows_by == 'income_statement'){
            foreach ($account_type_details as $key => $value) {
                if($value['account_type_id'] == 11){
                    $data_accounts['income'][] = $value;
                }

                if($value['account_type_id'] == 12){
                    $data_accounts['other_income'][] = $value;
                }

                if($value['account_type_id'] == 13){
                    $data_accounts['cost_of_sales'][] = $value;
                }

                if($value['account_type_id'] == 14){
                    $data_accounts['expenses'][] = $value;
                }

                if($value['account_type_id'] == 15){
                    $data_accounts['other_expenses'][] = $value;
                }
            }

            foreach ($data_accounts as $data_key => $data_account) {
                $data_report[$data_key] = [];
                foreach ($data_account as $key => $value) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                    $db_builder->where('active', 1);
                    $db_builder->where('(parent_account is null or parent_account = 0)');
                    $db_builder->where('account_detail_type_id', $value['id']);
                    $accounts = $db_builder->get()->getResultArray();
                    foreach ($accounts as $val) {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }


                        $child_account = $this->get_data_custom_summary_recursive([
                            'child_account' => [],
                            'account_id' => $val['id'],
                            'account_type_id' => $value['account_type_id'],
                            'from_date' => $from_date,
                            'to_date' => $to_date,
                            'accounting_method' => $accounting_method,
                            'acc_show_account_numbers' => $acc_show_account_numbers,
                            'display_rows_by' => $display_rows_by,
                            'display_columns_by' => $display_columns_by,
                        ]);

                        if($display_columns_by == 'total_only'){
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                $data_report[$data_key][] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $child_account];
                            }else{
                                $data_report[$data_key][] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $child_account];
                            }
                        }
                    }
                }
            }
        }elseif ($display_rows_by == 'customers') {
            $clients = $this->clients_model->get();
            $headers = [];

            foreach ($clients as $key => $value) {
                $columns = [];
                if($display_columns_by == 'total_only'){
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('customer', $value['userid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    $columns[] = $debits - $credits;
                }elseif ($display_columns_by == 'months') {
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('customer', $value['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        $columns[] = $debits - $credits;
                        $month = strtotime("+1 month", $month);
                    }
                }

                $data_report[] = ['name' => $value['company'], 'columns' => $columns];
            }
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'display_rows_by' => $display_rows_by, 'display_columns_by' => $display_columns_by];
        
    }

    /**
     * get data profit and loss as of total income
     * @param  array $data_filter
     * @return array             
     */
    public function get_data_profit_and_loss_as_of_total_income($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_percent = [];

        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        $total = 0;
        foreach ($data_accounts['income'] as $value) {
            $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
            $db_builder->where('active', 1);
            $db_builder->where('account_detail_type_id', $value['id']);
            $accounts = $db_builder->get()->getResultArray();
            foreach ($accounts as $val) {
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                $db_builder->where('account', $val['id']);
                if($accounting_method == 'cash'){
                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                }
                $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                $account_history = $db_builder->get()->getRow();
                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                    $total += $credits - $debits;
                }else{
                    $total += $debits - $credits;
                }
            }
        }
        $data_total['income'] = $total;

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            $percent = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $r_am = $credits - $debits;
                        $total += $credits - $debits;
                    }else{
                        $r_am = $debits - $credits;
                        $total += $debits - $credits;
                    }

                    $child_account = $this->get_data_profit_and_loss_as_of_total_income_recursive([], $data_total['income'], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    if($data_total['income'] != 0){
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $r_am, 'percent' => round((($r_am) / $data_total['income']) * 100, 2), 'child_account' => $child_account];
                    }else{
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $r_am, 'percent' => 0, 'child_account' => $child_account];
                    }
                }
            }
            $data_total[$data_key] = $total;
            if($data_total['income'] != 0){
                $data_percent[$data_key] = round(($total / $data_total['income']) * 100, 2);
            }else{
                $data_percent[$data_key] = 0;
            }
        }

        return ['data' => $data_report, 'total' => $data_total, 'percent' => $data_percent, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data profit and loss comparison
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss_comparison($data_filter){
        $this_year = date('Y');
        $last_year = $this_year - 1;
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $last_from_date = date('Y-m-d', strtotime($from_date.' - 1 year'));
        $last_to_date = date('Y-m-d', strtotime($to_date.' - 1 year'));
        $this_year = date('Y', strtotime($to_date));
        $last_year = date('Y', strtotime($last_to_date));

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_this_year = [];
        $data_last_year = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            $py_total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date_format(datecreated, \'%Y-%m-%d\') >= "' . $last_from_date . '" and date_format(datecreated, \'%Y-%m-%d\') <= "' . $last_to_date . '")');
                    $py_account_history = $db_builder->get()->getRow();
                    $py_credits = $py_account_history->credit != '' ? $py_account_history->credit : 0;
                    $py_debits = $py_account_history->debit != '' ? $py_account_history->debit : 0;

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_profit_and_loss_comparison_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers);

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $data_report[$data_key][] = ['name' => $name, 'this_year' => $credits - $debits, 'last_year' => $py_credits - $py_debits, 'child_account' => $child_account];
                    }else{
                        $data_report[$data_key][] = ['name' => $name, 'this_year' => $debits - $credits, 'last_year' => $py_debits - $py_credits, 'child_account' => $child_account];
                    }
                }
            }
        }

        return ['data' => $data_report, 'this_year_header' => $this_year, 'last_year_header' => $last_year, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data profit and loss detail
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss_detail($data_filter){
        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            $balance_total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->orderBy('date', 'asc');
                    $account_history = $db_builder->get()->getResultArray();
                    $node = [];
                    $balance = 0;
                    $amount = 0;
                    foreach ($account_history as $v) {
                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                            $am = $v['credit'] - $v['debit'];
                        }else{
                            $am = $v['debit'] - $v['credit'];
                        }
                        $node[] =   [
                                        'date' => date('Y-m-d', strtotime($v['date'])),
                                        'type' => app_lang($v['rel_type']),
                                        'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                                        'description' => $v['description'],
                                        'customer' => $v['customer'],
                                        'amount' => $am,
                                        'balance' => $balance + $am,
                                    ];
                        $amount += $am;
                        $balance += $am;
                    }

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    $child_account = $this->get_data_profit_and_loss_detail_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    $data_report[$data_key][] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' => $child_account];

                    $total += $amount;
                    $balance_total += $balance;
                }
            }
            $data_total[$data_key] = ['amount' => $total, 'balance' => $balance_total];
        }
        
        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data profit and loss year to date comparison
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss_year_to_date_comparison($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        if($acc_first_month_of_financial_year <= date('m')){
            $last_from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));
        }else{
            $last_from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.(date('Y') - 1)));
        }
        $last_to_date = $to_date;

        

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date_format(datecreated, \'%Y-%m-%d\') >= "' . $last_from_date . '" and date_format(datecreated, \'%Y-%m-%d\') <= "' . $last_to_date . '")');
                    $py_account_history = $db_builder->get()->getRow();
                    $py_credits = $py_account_history->credit != '' ? $py_account_history->credit : 0;
                    $py_debits = $py_account_history->debit != '' ? $py_account_history->debit : 0;

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_profit_and_loss_year_to_date_comparison_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers);
                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $data_report[$data_key][] = ['name' => $name, 'this_year' => $credits - $debits, 'last_year' => $py_credits - $py_debits, 'child_account' => $child_account];
                    }else{
                        $data_report[$data_key][] = ['name' => $name, 'this_year' => $debits - $credits, 'last_year' => $py_debits - $py_credits, 'child_account' => $child_account];
                    }
                }
            }
        }
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'last_from_date' => $last_from_date, 'last_to_date' => $last_to_date];
        
    }

    /**
     * get data profit and loss
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss($data_filter){
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }
        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();
                   
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_profit_and_loss_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $child_account];
                    }else{
                        $data_report[$data_key][] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $child_account];
                    }
                }
            }
        }
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data statement of cash flows
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_statement_of_cash_flows($data_filter){
        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        $data_accounts['cash_flows_from_operating_activities'] = [];
        $data_accounts['cash_flows_from_financing_activities'] = [];
        $data_accounts['cash_flows_from_investing_activities'] = [];
        $data_accounts['cash_and_cash_equivalents_at_beginning_of_year'] = [];

        foreach ($account_type_details as $key => $value) {
            if(isset($value['statement_of_cash_flows'])){
                $data_accounts[$value['statement_of_cash_flows']][] = $value;
                continue;
            }

            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                if($value['id'] == 13){
                    $data_accounts['current_assets_3'][] = $value;
                }elseif($value['id'] == 3 || $value['id'] == 6){
                    $data_accounts['current_assets_2'][] = $value;
                }else{
                    $data_accounts['current_assets_1'][] = $value;
                }
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                if($value['id'] == 21 || $value['id'] == 26){
                    $data_accounts['fixed_assets_2'][] = $value;
                }else{
                    $data_accounts['fixed_assets_1'][] = $value;
                }
            }
            if($value['account_type_id'] == 5){
                if($value['id'] != 31){
                    $data_accounts['non_current_assets_2'][] = $value;
                }else{
                    $data_accounts['non_current_assets_1'][] = $value;
                }
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                if($value['id'] != 63 && $value['id'] != 64){
                    $data_accounts['non_current_liabilities_2'][] = $value;
                }else{
                    $data_accounts['non_current_liabilities_1'][] = $value;
                }
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    if($val['id'] == 13){
                        $db_builder->where('(rel_type != "invoice" and rel_type != "expense" and rel_type != "payment")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('account', $val['id']);
                    
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_statement_of_cash_flows_recursive([], $val['id'], $value['account_type_id'], $value['id'], $from_date, $to_date, $acc_show_account_numbers);

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 10 || $value['account_type_id'] == 8 || $value['account_type_id'] == 7 || $value['account_type_id'] == 4 || $value['account_type_id'] == 5 || $value['account_type_id'] == 6 || $value['account_type_id'] == 2 || $value['account_type_id'] == 9 || $value['account_type_id'] == 1){
                        $data_report[$data_key][] = ['account_detail_type_id' => $value['id'], 'name' => $name, 'amount' => $credits - $debits, 'child_account' => $child_account];
                        $total += $credits - $debits;
                    }else{
                        $data_report[$data_key][] = ['account_detail_type_id' => $value['id'], 'name' => $name, 'amount' => $debits - $credits, 'child_account' => $child_account];
                        $total += $debits - $credits;
                    }
                }
            }
            $data_total[$data_key] = $total;
        }



        $income = $data_total['income'] + $data_total['other_income'];
        $expenses = $data_total['expenses'] + $data_total['other_expenses'] + $data_total['cost_of_sales'];
        $net_income = $income - $expenses;

        return ['data' => $data_report, 'total' => $data_total, 'net_income' => $net_income, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }
    
    /**
     * get data statement of changes in equity
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_statement_of_changes_in_equity($data_filter){
        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }

                    
                    $child_account = $this->get_data_statement_of_changes_in_equity_recursive([], $val['id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    $data_report[$data_key][] = ['account_detail_type_id' => $value['id'], 'name' => $name, 'amount' => $credits - $debits, 'child_account' => $child_account];
                    $total += $credits - $debits;

                }
            }
            $data_total[$data_key] = $total;
        }

        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data deposit detail
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_deposit_detail($data_filter){
        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            $balance_total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('((rel_type = "payment" and debit > 0) or (rel_type = "deposit"  and credit > 0))');
                    $db_builder->orderBy('date', 'asc');
                    $account_history = $db_builder->get()->getResultArray();
                    $node = [];
                    $balance = 0;
                    $amount = 0;
                    foreach ($account_history as $v) {
                        if($value['account_type_id'] == 10 || $value['account_type_id'] == 9 || $value['account_type_id'] == 8 || $value['account_type_id'] == 7){
                            $amount += $v['credit'] - $v['debit'];
                            $am = ($v['credit'] - $v['debit']);
                        }else{
                            $amount += $v['debit'] - $v['credit'];
                            $am = ($v['debit'] - $v['credit']);
                        }

                        $node[] =   [
                                        'date' => date('Y-m-d', strtotime($v['date'])),
                                        'type' => app_lang($v['rel_type']),
                                        'description' => $v['description'],
                                        'customer' => $v['customer'],
                                        'debit' => $v['debit'],
                                        'credit' => $v['credit'],
                                        'amount' =>  $am,
                                    ];
                    }

                    $child_account = $this->get_data_deposit_detail_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $acc_show_account_numbers);

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    $data_report[$data_key][] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'details' => $node, 'child_account' => $child_account];

                    $total += $amount;
                    $balance_total += $balance;
                }
            }
            $data_total[$data_key] = ['amount' => $total, 'balance' => $balance_total];
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data income by customer summary
     * @return array
     */
    public function get_data_income_by_customer_summary($data_filter){
        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }
        $list_customer = [];
        foreach ($data_accounts as $data_key => $data_account) {
            $total = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit, customer');
                    $db_builder->groupBy('customer');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('(customer != 0)');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }

                    $account_history = $db_builder->get()->getResultArray();

                    foreach ($account_history as $v) {
                        $credits = $v['credit'] != '' ? $v['credit'] : 0;
                        $debits = $v['debit'] != '' ? $v['debit'] : 0;

                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                            $amount = $credits - $debits;
                        }else{
                            $amount = $debits - $credits;
                        }

                        if(isset($total[$v['customer']])){
                            $total[$v['customer']] += $amount;
                        }else{
                            $total[$v['customer']] = $amount;
                        }

                        if(!in_array($v['customer'], $list_customer)){
                            $list_customer[] = $v['customer'];
                        }
                    }
                }
            }
            $data_total[$data_key] = $total;
        }

        return ['list_customer' => $list_customer, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data check detail
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_check_detail($data_filter){
        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('rel_type', 'expense');
                    $db_builder->orderBy('date', 'asc');
                    $account_history = $db_builder->get()->getResultArray();

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    $data_report[$data_key][] = ['account_detail_type_id' => $value['id'], 'name' => $name, 'details' => $account_history];
                }
            }
        }
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data account list
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_account_list($data_filter){
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $account_types = $this->get_account_types();
        $detail_types = $this->get_account_type_details();

        $account_type_name = [];
        $detail_type_name = [];

        foreach ($account_types as $key => $value) {
            $account_type_name[$value['id']] = $value['name'];
        }

        foreach ($detail_types as $key => $value) {
            $detail_type_name[$value['id']] = $value['name'];
        }


        

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_account_list_recursive([], $val['id'], $value['account_type_id'], $account_type_name, $detail_type_name, $acc_show_account_numbers);

                    $_account_type_name = isset($account_type_name[$val['account_type_id']]) ? $account_type_name[$val['account_type_id']] : '';
                    $_detail_type_name = isset($detail_type_name[$val['account_detail_type_id']]) ? $detail_type_name[$val['account_detail_type_id']] : '';
                    
                    $data_report[$data_key][] = ['description' => $val['description'], 'type' => $_account_type_name, 'detail_type' => $_detail_type_name, 'name' => $name, 'amount' => $debits - $credits, 'child_account' => $child_account];
                    $total += $debits - $credits;
                }
            }
            $data_total[$data_key] = $total;
        }

        return ['data' => $data_report, 'total' => $data_total];
    }
    
    /**
     * get data general ledger 
     * @return array
     */
    public function get_data_general_ledger($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            $balance_total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->orderBy('date', 'asc');
                    $account_history = $db_builder->get()->getResultArray();
                    $node = [];
                    $balance = 0;
                    $amount = 0;
                    foreach ($account_history as $v) {
                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 10 || $value['account_type_id'] == 9 || $value['account_type_id'] == 8 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                            $am = $v['credit'] - $v['debit'];
                        }else{
                            $am = $v['debit'] - $v['credit'];
                        }

                        $node[] =   [
                                        'date' => date('Y-m-d', strtotime($v['date'])),
                                        'type' => app_lang($v['rel_type']),
                                        'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                                        'description' => $v['description'],
                                        'customer' => $v['customer'],
                                        'debit' => $v['debit'],
                                        'credit' => $v['credit'],
                                        'amount' => $am,
                                        'balance' => $balance + $am,
                                    ];


                        $amount += $am;
                        $balance += $am;
                    }
                    $child_account = $this->get_data_general_ledger_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    $data_report[$data_key][] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' => $child_account];

                    $total += $amount;
                    $balance_total += $balance;
                }
            }
            $data_total[$data_key] = ['amount' => $total, 'balance' => $balance_total];
        }
        
        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data journal
     * @return array 
     */
    public function get_data_journal($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        $data_report = [];

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
        $db_builder->orderBy('date', 'asc');
        
        $account_history = $db_builder->get()->getResultArray();
        $balance = 0;
        $amount = 0;
        foreach ($account_history as $v) {
            $data_report[] =   [
                            'date' => date('Y-m-d', strtotime($v['date'])),
                            'type' => app_lang($v['rel_type']),
                            'name' => (isset($account_name[$v['account']]) ? $account_name[$v['account']] : ''),
                            'description' => $v['description'],
                            'customer' => $v['customer'],
                            'debit' => $v['debit'],
                            'credit' => $v['credit'],
                        ];
        }
                
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }
    
    /**
     * get data recent transactions
     * @return array
     */
    public function get_data_recent_transactions($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();

                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    
                    $db_builder->where('((debit > 0 and (rel_type != "expense" and rel_type != "transfer")) or (credit > 0 and (rel_type = "expense" or rel_type = "transfer")))');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->orderBy('rel_type,date', 'asc');
                    $account_history = $db_builder->get()->getResultArray();

                    foreach ($account_history as $v) {
                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 10 || $value['account_type_id'] == 9 || $value['account_type_id'] == 8 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                            $am = $v['credit'] - $v['debit'];
                        }else{
                            $am = $v['debit'] - $v['credit'];
                        }

                        $data_report[$v['rel_type']][] =   [
                                        'date' => date('Y-m-d', strtotime($v['date'])),
                                        'type' => app_lang($v['rel_type']),
                                        'name' => (isset($account_name[$v['account']]) ? $account_name[$v['account']] : ''),
                                        'description' => $v['description'],
                                        'customer' => $v['customer'],
                                        'amount' => $am,
                                    ];
                    }
                }
            }
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data transaction detail by account
     * @return array
     */
    public function get_data_transaction_detail_by_account($data_filter){
        
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }
        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            $balance_total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->orderBy('date', 'asc');
                    $account_history = $db_builder->get()->getResultArray();
                    $node = [];
                    $balance = 0;
                    $amount = 0;
                    foreach ($account_history as $v) {
                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 10 || $value['account_type_id'] == 9 || $value['account_type_id'] == 8 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                            $am = $v['credit'] - $v['debit'];
                        }else{
                            $am = $v['debit'] - $v['credit'];
                        }
                        $node[] =   [
                                        'date' => date('Y-m-d', strtotime($v['date'])),
                                        'type' => app_lang($v['rel_type']),
                                        'description' => $v['description'],
                                        'customer' => $v['customer'],
                                        'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                                        'debit' => $v['debit'],
                                        'credit' => $v['credit'],
                                        'amount' => $am,
                                        'balance' => $balance + ($am),
                                    ];
                        $amount += $am;
                        $balance += $am;
                    }

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    $child_account = $this->get_data_transaction_detail_by_account_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    $data_report[$data_key][] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' => $child_account];

                    $total += $amount;
                    $balance_total += $balance;
                }
            }
            $data_total[$data_key] = ['amount' => $total, 'balance' => $balance_total];
        }
        
        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data transaction list by date
     * @return array
     */
    public function get_data_transaction_list_by_date($data_filter){
        

        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];
        $account_type = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
            $account_type[$value['id']] = $value['account_type_id'];
        }


        $data_report = [];
        
        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
        $db_builder->where('((debit > 0 and (rel_type != "expense" and rel_type != "transfer")) or (credit > 0 and (rel_type = "expense" or rel_type = "transfer")))');
        $db_builder->orderBy('date', 'asc');
        $account_history = $db_builder->get()->getResultArray();
        $balance = 0;
        $amount = 0;
        foreach ($account_history as $v) {
            $account_type_id = (isset($account_type[$v['account']]) ? $account_type[$v['account']] : '');
            if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                $am = $v['credit'] - $v['debit'];
            }else{
                $am = $v['debit'] - $v['credit'];
            }
            $data_report[] =   [
                            'date' => date('Y-m-d', strtotime($v['date'])),
                            'type' => app_lang($v['rel_type']),
                            'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                            'name' => isset($account_name[$v['account']]) ? $account_name[$v['account']] : '',
                            'description' => $v['description'],
                            'customer' => $v['customer'],
                            'amount' => $am,
                            'debit' => $v['debit'],
                            'credit' => $v['credit'],
                        ];
        }
        
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data trial balance
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_trial_balance($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }
        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($credits > $debits){
                        $credits = $credits - $debits;
                        $debits = 0;
                    }else{
                        $debits = $debits - $credits;
                        $credits = 0;
                    }
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_trial_balance_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    $data_report[$data_key][] = ['name' => $name, 'debit' => $debits, 'credit' => $credits, 'child_account' => $child_account];
                }
            }
            $data_total[$data_key] = $total;
        }
        return ['data' => $data_report, 'total' => $data_total, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * import xlsx banking
     * @param  array $data
     * @return integer or boolean      
     */
    public function import_xlsx_banking($data){
        $data['datecreated'] = date('Y-m-d H:i:s');
        $data['addedfrom'] = get_staff_user_id();
        $data['date'] = str_replace('/', '-', $data['date']);
        $data['date'] = date("Y-m-d", strtotime($data['date']));
        $db_builder->insert(get_db_prefix() . 'acc_transaction_bankings', $data);

        $insert_id = $this->db->insertID();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    /**
     * get transaction banking
     * @param  string $id
     * @param  array  $where
     * @return array or object
     */
    public function get_transaction_banking($id = '', $where = [])
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_transaction_bankings');

        if (is_numeric($id)) {
            $db_builder->where('id', $id);
            return $db_builder->get()->getRow();
        }

        $db_builder->where($where);
        $db_builder->orderBy('id', 'desc');
        return $db_builder->get()->getResultArray();
    }
    /**
     * get journal entry
     * @param  integer $id 
     * @return object     
     */
    public function get_journal_entry($id){
        $db_builder = $this->db->table(get_db_prefix() . 'acc_journal_entries');
        $db_builder->where('id', $id);
        $journal_entrie = $db_builder->get()->getRow();

        if($journal_entrie){
            $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
            $db_builder->where('rel_id', $id);
            $db_builder->where('rel_type', 'journal_entry');
            $details = $db_builder->get()->getResultArray();

            $data_details =[];
            foreach ($details as $key => $value) {
                $data_details[] = [
                    "account" => $value['account'],
                    "debit" => floatval($value['debit']),
                    "credit" => floatval($value['credit']),
                    "description" => $value['description']];
            }
            if(count($data_details) < 10){

            }
            $journal_entrie->details = $data_details;
        }

        return $journal_entrie;
    }

    /**
     * delete journal entry
     * @param integer $id
     * @return boolean
     */

    public function delete_journal_entry($id)
    {   
        $db_builder = $this->db->table(get_db_prefix() . 'acc_journal_entries');
        $db_builder->where('id', $id);
        if ($db_builder->delete()) {
            $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');

            $db_builder->where('rel_id', $id);
            $db_builder->where('rel_type', 'journal_entry');
            $db_builder->delete();

            return true;
        }
        return false;
    }

    /**
     * update journal entry
     * @param  array $data 
     * @param  integer $id 
     * @return boolean       
     */
    public function update_journal_entry($data, $id){
        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        $journal_entry = json_decode($data['journal_entry']);
        unset($data['journal_entry']);

        $data['journal_date'] = to_sql_date($data['journal_date']);
        if(get_setting('acc_close_the_books') == 1){
            if(strtotime($data['journal_date']) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                return 'close_the_book';
            }
        }

        $db_builder = $this->db->table(get_db_prefix() . 'acc_journal_entries');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
        $db_builder->where('rel_id', $id);
        $db_builder->where('rel_type', 'journal_entry');
        $db_builder->delete();

        $data_insert = [];

        foreach ($journal_entry as $key => $value) {
            if($value[0] != ''){
                $node = [];
                $node['account'] = $value[0];
                $node['debit'] = $value[1];
                $node['credit'] = $value[2];
                $node['date'] = $data['journal_date'];
                $node['description'] = $value[3];
                $node['rel_id'] = $id;
                $node['rel_type'] = 'journal_entry';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $data_insert[] = $node;
            }
        }
        
        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
        $db_builder->insertBatch($data_insert);

        return true;
    }

    /**
     * check format date Y-m-d
     *
     * @param      String   $date   The date
     *
     * @return     boolean
     */
    public function check_format_date($date)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get transfer
     * @param  integer $id 
     * @return object    
     */
    public function get_transfer($id){
        $db_builder = $this->db->table(get_db_prefix() . 'acc_transfers');
        $db_builder->where('id', $id);
        return $db_builder->get()->getRow();
    }

    /**
     * update transfer
     * @param array $data
     * @param  integer $id 
     * @return boolean
     */
    public function update_transfer($data, $id){
        if(isset($data['id'])){
            unset($data['id']);
        }

        if(get_setting('acc_close_the_books') == 1){
            if(strtotime($data['date']) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                return 'close_the_book';
            }
        }

        $data['transfer_amount'] = str_replace(',', '', $data['transfer_amount']);

        $db_builder = $this->db->table(get_db_prefix().'acc_transfers');
        $db_builder->where('id', $id);
        $db_builder->update($data);
        
        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('rel_id', $id);
        $db_builder->where('rel_type', 'transfer');
        $db_builder->delete();

        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        $node = [];
        $node['account'] = $data['transfer_funds_from'];
        $node['debit'] = 0;
        $node['credit'] = $data['transfer_amount'];
        $node['date'] = $data['date'];
        $node['rel_id'] = $id;
        $node['rel_type'] = 'transfer';
        $node['datecreated'] = date('Y-m-d H:i:s');
        $node['addedfrom'] = $created_by;

        $db_builder->insert($node);

        $node = [];
        $node['account'] = $data['transfer_funds_to'];
        $node['debit'] = $data['transfer_amount'];
        $node['credit'] = 0;
        $node['date'] = $data['date'];
        $node['rel_id'] = $id;
        $node['rel_type'] = 'transfer';
        $node['datecreated'] = date('Y-m-d H:i:s');
        $node['addedfrom'] = $created_by;

        $db_builder->insert($node);

        return true;
    }

    /**
     * delete transfer
     * @param integer $id
     * @return boolean
     */

    public function delete_transfer($id)
    {   
        $db_builder = $this->db->table(get_db_prefix() . 'acc_transfers');
        $db_builder->where('id', $id);
        if ($db_builder->delete()) {
            $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
            $db_builder->where('rel_id', $id);
            $db_builder->where('rel_type', 'transfer');
            $db_builder->delete();

            return true;
        }
        return false;
    }

    /**
     * delete account
     * @param integer $id
     * @return boolean
     */

    public function delete_account($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
        $db_builder->where('(account = '. $id .' or split = '. $id.')');
        $count = $db_builder->countAllResults();

        if($count > 0){
            return 'have_transaction';
        }

        $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
        $db_builder->where('id', $id);
        $db_builder->where('default_account', 0);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
            $db_builder->where('account', $id);
            $db_builder->delete();

            return true;
        }
        return false;
    }

    /**
     * delete convert
     * @param integer $id
     * @return boolean
     */
    public function delete_convert($id, $type)
    {   
        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
        if($type == 'opening_stock'){
            $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

            $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));

            $db_builder->where('rel_id', $id);
            $db_builder->where('rel_type', $type);
            $db_builder->where('date >= "'.$date_financial_year.'"');
            $db_builder->delete();
        }else{
            $db_builder->where('rel_id', $id);
            $db_builder->where('rel_type', $type);
            $db_builder->delete();
        }
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }
    
    /**
     * Gets the invoice without commission.
     * 
     * @param      bool        $old_invoice 
     * 
     * @return     array  The invoice without commission.
     */
    public function get_data_invoices_for_select($where = []){
        $db_builder->where($where);
        $invoices = $db_builder->get(get_db_prefix() . 'invoices')->getResultArray();

        $invoice_return = [];

        foreach ($invoices as $key => $value) {
            $payments_amount = sum_from_table(get_db_prefix() . 'invoice_payments', array('field' => 'amount', 'where' => array('invoiceid' => $value['id'])));

            if($payments_amount > 0){
                $node = [];
                $node['id'] = $value['id'];
                $node['name'] = get_invoice_id($value['id']);
                $invoice_return[] = $node;
            }
        }

        return $invoice_return;
    }

    /**
     * get reconcile by account
     * @param  integer $account 
     * @return object or boolean          
     */
    public function get_reconcile_by_account($account){
        $db_builder = $this->db->table(get_db_prefix() . 'acc_reconciles');
        $db_builder->where('account', $account);
        $db_builder->orderBy('id', 'desc');
        $reconcile = $db_builder->get()->getRow();

        if($reconcile){
            return $reconcile;
        }

        return false;
    }

    /**
     * add reconcile
     * @param array $data 
     * @return  integer or boolean
     */
    public function add_reconcile($data){
        if($data['ending_date'] != ''){
            $data['ending_date'] = $data['ending_date'];
        }

        if($data['income_date'] != ''){
            $data['income_date'] = $data['income_date'];
        }

        if($data['expense_date'] != ''){
            $data['expense_date'] = $data['expense_date'];
        }

        $data['service_charge'] = str_replace(',', '', $data['service_charge']);
        $data['interest_earned'] = str_replace(',', '', $data['interest_earned']);
        $data['ending_balance'] = str_replace(',', '', $data['ending_balance']);
        $data['beginning_balance'] = str_replace(',', '', $data['beginning_balance']);
        
        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->insert($data);
        $insert_id = $this->db->insertId();
        
        if($insert_id){
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');

            $users_model = model("App\Models\Users_model", false);
            $created_by = $users_model->login_user_id();
            
            if($data['service_charge'] > 0){

                $node = [];
                $node['split'] = $data['account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['expense_account'];
                $node['debit'] = $data['service_charge'];
                $node['credit'] = 0;
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['description'] = app_lang('service_charge');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);

                $node = [];
                $node['split'] = $data['expense_account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['account'];
                
                $node['debit'] = 0;
                $node['credit'] = $data['service_charge'];
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['description'] = app_lang('service_charge');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);
            }
            if($data['interest_earned'] > 0){
                $node = [];
                $node['split'] = $data['account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['income_account'];
                $node['debit'] = 0;
                $node['credit'] = $data['interest_earned'];
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['description'] = app_lang('interest_earned');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);

                $node = [];
                $node['split'] = $data['income_account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['account'];
                $node['debit'] = $data['interest_earned'];
                $node['credit'] = 0;
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['description'] = app_lang('interest_earned');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);
            }

            return $insert_id;
        }

        return false;
    }

    /**
     * update reconcile
     * @param array $data 
     * @param integer $id 
     * @return  boolean
     */
    public function update_reconcile($data, $id){
        if($data['ending_date'] != ''){
            $data['ending_date'] = $data['ending_date'];
        }

        if($data['income_date'] != ''){
            $data['income_date'] = $data['income_date'];
        }

        if($data['expense_date'] != ''){
            $data['expense_date'] = $data['expense_date'];
        }

        $account = 0;
        if(isset($data['expense_date'])){
            $account = $data['account'];
            unset($data['account']);
        }

        $data['service_charge'] = str_replace(',', '', $data['service_charge']);
        $data['interest_earned'] = str_replace(',', '', $data['interest_earned']);
        $data['ending_balance'] = str_replace(',', '', $data['ending_balance']);
        $data['beginning_balance'] = str_replace(',', '', $data['beginning_balance']);

        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->where('id', $id);
        $db_builder->update($data);
        
        if ($this->db->affectedRows() > 0) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('rel_id', 0);
            $db_builder->where('rel_type', 'cheque_expense');
            $db_builder->where('reconcile', $id);
            $db_builder->delete();

            $db_builder->where('rel_id', 0);
            $db_builder->where('rel_type', 'deposit');
            $db_builder->where('reconcile', $id);
            $db_builder->delete();

            $users_model = model("App\Models\Users_model", false);
            $created_by = $users_model->login_user_id();

            if($data['service_charge'] > 0){
                $node = [];
                $node['split'] = $account;
                $node['reconcile'] = 0;
                $node['account'] = $data['expense_account'];
                $node['debit'] = $data['service_charge'];
                $node['credit'] = 0;
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['description'] = app_lang('service_charge');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);

                $node = [];
                $node['split'] = $data['expense_account'];
                $node['reconcile'] = $id;
                $node['account'] = $account;
                $node['debit'] = 0;
                $node['credit'] = $data['service_charge'];
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['description'] = app_lang('service_charge');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);
            }
            if($data['interest_earned'] > 0){
                $node = [];
                $node['split'] = $account;
                $node['reconcile'] = 0;
                $node['account'] = $data['income_account'];
                $node['debit'] = 0;
                $node['credit'] = $data['interest_earned'];
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['description'] = app_lang('interest_earned');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);

                $node = [];
                $node['split'] = $data['income_account'];
                $node['reconcile'] = $id;
                $node['account'] = $account;
                $node['debit'] = $data['interest_earned'];
                $node['credit'] = 0;
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['description'] = app_lang('interest_earned');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);
            }

            return true;
        }

        return false;
    }

    /**
     * add adjustment
     * @param array $data 
     * @return  integer or boolean
     */
    public function add_adjustment($data){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');

        $db_builder->where('account_type_id', 15);
        $db_builder->where('account_detail_type_id', 139);
        $account = $db_builder->get()->getRow();
        $data['adjustment_date'] = $data['adjustment_date'];

        if(get_setting('acc_close_the_books') == 1){
            if(strtotime($data['adjustment_date']) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                return 'close_the_book';
            }
        }
        if($account){

            $users_model = model("App\Models\Users_model", false);
            $created_by = $users_model->login_user_id();

            $data['adjustment_amount'] = str_replace(',', '', $data['adjustment_amount']);

            $node = [];

            $node['account'] = $account->id;
            if($data['adjustment_amount'] < 0){
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['debit'] = $data['adjustment_amount'];
                $node['credit'] = 0;
            }else{
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['debit'] = 0;
                $node['credit'] = $data['adjustment_amount'];
            }
            $node['split'] = $data['account'];
            $node['reconcile'] = $data['reconcile'];
            $node['description'] = app_lang('reconcile_adjustment');
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['date'] = $data['adjustment_date'];
            $node['addedfrom'] = $created_by;

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->insert($node);

            $node = [];
            $node['account'] = $data['account'];
            if($data['adjustment_amount'] < 0){
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['debit'] = 0;
                $node['credit'] = $data['adjustment_amount'];
            }else{
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['debit'] = $data['adjustment_amount'];
                $node['credit'] = 0;
            }

            $node['split'] = $account->id;
            $node['reconcile'] = $data['reconcile'];
            $node['description'] = app_lang('reconcile_adjustment');
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['date'] = $data['adjustment_date'];
            $node['addedfrom'] = $created_by;

            $db_builder->insert($node);

            $insert_id = $this->db->insertID();
            if ($insert_id) {
                $this->finish_reconcile_account($data);
                return $insert_id;
            }
        }else{
            $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
            $db_builder->insert([
                'name' => '',
                'key_name' => 'acc_reconciliation_discrepancies',
                'account_type_id' => 15,
                'account_detail_type_id' => 139,
            ]);

            $account_id = $this->db->insertID();

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            if ($account_id) {
                $node = [];
                $node['split'] = $data['account'];
                $node['account'] = $account_id;
                if($data['adjustment_amount'] < 0){
                    $node['rel_id'] = $id;
                    $node['rel_type'] = 'deposit';
                    $node['debit'] = $data['adjustment_amount'];
                    $node['credit'] = 0;
                }else{
                    $node['rel_id'] = $id;
                    $node['rel_type'] = 'cheque_expense';
                    $node['debit'] = 0;
                    $node['credit'] = $data['adjustment_amount'];
                }

                $node['reconcile'] = $data['reconcile'];
                $node['description'] = app_lang('reconcile_adjustment');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['date'] = $data['adjustment_date'];
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);

                $node = [];
                $node['account'] = $data['account'];
                if($data['adjustment_amount'] < 0){
                    $node['rel_id'] = 0;
                    $node['rel_type'] = 'deposit';
                    $node['debit'] = 0;
                    $node['credit'] = $data['adjustment_amount'];
                }else{
                    $node['rel_id'] = 0;
                    $node['rel_type'] = 'cheque_expense';
                    $node['debit'] = $data['adjustment_amount'];
                    $node['credit'] = 0;
                }

                $node['split'] = $account_id;
                $node['reconcile'] = $data['reconcile'];
                $node['description'] = app_lang('reconcile_adjustment');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['date'] = $data['adjustment_date'];
                $node['addedfrom'] = $created_by;

                $db_builder->insert($node);

                $insert_id = $this->db->insertID();

                if ($insert_id) {
                    $this->finish_reconcile_account($data);

                    return $insert_id;
                }
            }
        }

        return false;
    }

    /**
     * finish reconcile account
     * @param  array $data 
     * @return boolean       
     */
    public function finish_reconcile_account($data){
        $affectedRows = 0;

        if($data['history_ids'] != ''){
            $history_ids = explode(', ', $data['history_ids']);

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            foreach ($history_ids as $key => $value) {
                $db_builder->where('id', $value);
                $db_builder->update(['reconcile' => $data['reconcile']]);

                if ($this->db->affectedRows() > 0) {
                    $affectedRows++;
                }
            }
        }

        if($data['finish'] == 1){
            $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
            $db_builder->where('id', $data['reconcile']);
            $db_builder->update(['finish' => 1]);

            if ($this->db->affectedRows() > 0) {
                $affectedRows++;
            }

        }

        if ($affectedRows > 0) {
            return true;
        }

        return true;
    }

    /**
     * reconcile save for later
     * @param  array $data 
     * @return boolean       
     */
    
    public function reconcile_save_for_later($data){
        $affectedRows = 0;
        if($data['history_ids'] != ''){
            $history_ids = explode(', ', $data['history_ids']);

            foreach ($history_ids as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                $db_builder->where('id', $value);
                $db_builder->update(['reconcile' => $data['reconcile']]);

                if ($this->db->affectedRows() > 0) {
                    $affectedRows++;
                }
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return true;
    }

    /**
     * get data bank accounts dashboard
     * @param  array $data_filter 
     * @return array 
     */
    public function get_data_bank_accounts_dashboard($data_filter){
        $currency_symbol = get_setting("currency_symbol");
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $where = $this->get_where_report_period();

        $account_type_details = $this->get_account_type_details();
        $data_return = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
        }
        $html = '<ul class="list-group">
            <li class="list-group-item bold">'. app_lang('bank_accounts_uppercase').'<span class="badge">'. app_lang('balance').'</span></li>';
        foreach ($data_accounts as $data_key => $data_account) {
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($where != ''){
                        $db_builder->where($where);
                    }
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    if($value['account_type_id'] == 10 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 7){
                        $html .= '<li class="list-group-item">'.$name.'<span class="badge">'.to_currency($credits - $debits, $currency_symbol).'</span></li>';
                    }else{
                        $html .= '<li class="list-group-item">'.$name.'<span class="badge">'.to_currency($debits - $credits, $currency_symbol).'</span></li>';
                    }

                    $data_return[] = ['name' => $name, 'balance' => $debits - $credits];
                }
            }
        }
        $html .= '</ul>';
        
        return $html;
    }

    /**
     * get data convert status dashboard
     * @param  array $data_filter 
     * @return array 
     */
    public function get_data_convert_status_dashboard($data_filter){
        
        $data_currency = '';
        $currency_symbol = get_setting("currency_symbol");

        $where_invoice = $this->get_where_report_period('bill_date');
        $db_builder = $this->db->table(get_db_prefix().'invoices');
        $db_builder->selectSum('id');
        if($where_invoice != ''){
            $db_builder->where($where_invoice);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'invoices.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "invoice") = 0)');
        $invoice = $db_builder->get()->getRow();

        $where_expense = $this->get_where_report_period('expense_date');
        $db_builder = $this->db->table(get_db_prefix().'expenses');
        $db_builder->selectSum('amount');
        if($where_expense != ''){
            $db_builder->where($where_expense);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'expenses.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "expense") = 0)');
        $expense = $db_builder->get()->getRow();

        $db_builder = $this->db->table(get_db_prefix().'invoice_payments');
        $where_payment = $this->get_where_report_period(get_db_prefix() . 'invoice_payments.payment_date');
        $db_builder->selectSum('amount');
        if($where_payment != ''){
            $db_builder->where($where_payment);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'invoice_payments.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "payment") = 0)');
        $db_builder->join(get_db_prefix() . 'invoices', get_db_prefix() . 'invoices.id=' . get_db_prefix() . 'invoice_payments.invoice_id', 'left');
        $payment = $db_builder->get()->getRow();


        $html = '<table class="table border table-striped no-margin">
                      <tbody>
                        <tr class="project-overview">
                            <td colspan="3" class="text-center"><h4>'. app_lang('transaction_not_yet_converted').'</h4></td>
                        </tr>
                        <tr class="project-overview">
                            <td class="bold" width="30%">'. app_lang('transaction').'</td>
                            <td class="bold" width="30%">'. app_lang('quantity').'</td>
                            <td class="bold">'. app_lang('acc_amount').'</td>
                        </tr>
                        <tr class="project-overview '. ($invoice->id > 0 ? 'text-danger' : '').'">
                            <td class="bold" width="30%"><a href="'.get_uri('accounting/transaction?group=sales&tab=invoice&status=has_not_been_converted').'">'. app_lang('invoice').'</a></td>
                            <td width="30%">'. $this->count_invoice_not_convert_yet($data_currency, $where_invoice) .'</td>
                            <td>'. to_currency($invoice->id, $currency_symbol)  .'</td>
                        </tr>
                        <tr class="project-overview '. ($payment->amount > 0 ? 'text-danger' : '').'">
                            <td class="bold" width="30%"><a href="'.get_uri('accounting/transaction?group=sales&tab=payment&status=has_not_been_converted').'">'. app_lang('payment').'</a></td>
                            <td width="30%">'. $this->count_payment_not_convert_yet($data_currency, $where_payment)  .'</td>
                            <td>'. to_currency($payment->amount, $currency_symbol)  .'</td>
                         </tr>
                         <tr class="project-overview '. ($expense->amount > 0 ? 'text-danger' : '').'">
                            <td class="bold" width="30%"><a href="'.get_uri('accounting/transaction?group=expenses&status=has_not_been_converted').'">'. app_lang('expense').'</a></td>
                            <td width="30%">'. $this->count_expense_not_convert_yet($data_currency, $where_expense)  .'</td>
                            <td>'. to_currency($expense->amount, $currency_symbol)  .'</td>
                         </tr>
                        </tbody>
                  </table>';
        return $html;
    }

    /**
     * get data profit and loss chart
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss_chart(){
        $accounting_method = get_setting('acc_accounting_method');

        $where = $this->get_where_report_period();
        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }
        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    if($where != ''){
                        $db_builder->where($where);
                    }
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $total += $credits - $debits;
                    }else{
                        $total += $debits - $credits;
                    }
                }
            }
            $data_total[$data_key] = $total;
        }

        $income = $data_total['income'] + $data_total['other_income'];
        $expenses = $data_total['expenses'] + $data_total['other_expenses'] + $data_total['cost_of_sales'];
        $net_income = $income - $expenses;

        return [$net_income, $income, $expenses];
    }

    /**
     * get data expenses chart
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_expenses_chart($data_filter){
        $where = $this->get_where_report_period();
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }
        $total = 0;

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        if($where != ''){
            $db_builder->select('*, (SELECT (sum(debit) - sum(credit)) as balance FROM '.get_db_prefix().'acc_account_history where account = '.get_db_prefix().'acc_accounts.id and '.$where.') as amount');
        }else{
            $db_builder->select('*, (SELECT (sum(debit) - sum(credit)) as balance FROM '.get_db_prefix().'acc_account_history where account = '.get_db_prefix().'acc_accounts.id) as amount');
        }

        $db_builder->where('(account_type_id = 13 or account_type_id = 14 or account_type_id = 15)');
        $db_builder->where('active', 1);

        $db_builder->orderBy('amount', 'desc');
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $k => $val) {
            if($k > 2){
                $total += $val['amount'];
            }else{
                if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }

                if($val['amount'] < 0){
                    $data_return[] = ['name' => $name, 'y' => floatval(-$val['amount']), 'amount' => ''.floatval($val['amount'])];
                }else{
                    $data_return[] = ['name' => $name, 'y' => floatval($val['amount']), 'amount' => ''.floatval($val['amount'])];
                }
            }
        }
        if($total < 0){
            $data_return[] = ['name' => app_lang('everything_else'), 'y' => floatval(-$total), 'amount' => ''.$total];
        }else{
            $data_return[] = ['name' => app_lang('everything_else'), 'y' => floatval($total), 'amount' => ''.$total];
        }
        return $data_return;
    }

    /**
     * get data income chart
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_income_chart($data_filter){
        $accounting_method = get_setting('acc_accounting_method');
        $where = $this->get_where_report_period('bill_date');

        $last_30_days = date('Y-m-d', strtotime('today - 30 days'));

        $db_builder = $this->db->table(get_db_prefix().'invoices');
        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->select('*, (SELECT sum(amount) as amount FROM '.get_db_prefix().'invoice_payments where invoice_id = '.get_db_prefix().'invoices.id and bill_date >= "'.$last_30_days.'") as amount');
        $invoices = $db_builder->get()->getResultArray();
        $mapped = 0;
        $open_invoice = 0;
        $overdue_invoices = 0;
        $paid_last_30_days = 0;
        $list_invoice = '0';

        foreach ($invoices as $key => $value) {
            $list_invoice .= ','.$value['id'];

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit');
            $db_builder->where('rel_id', $value['id']);
            $db_builder->where('rel_type', 'invoice');
            $db_builder->where('tax < 1');
            $db_builder->where('paid', 1);
            $count = $db_builder->get()->getRow();
            if(isset($count->credit) && $count->credit > 0){
                $mapped += $count->credit;
            }else{
                if($value['status'] == 1){
                    $open_invoice += $value['subtotal'];
                }elseif ($value['status'] == 2 && $value['amount'] > 0) {
                    $paid_last_30_days += $value['subtotal'];
                }elseif ($value['status'] == 4) {
                    $overdue_invoices += $value['subtotal'];
                }
            }
        }

        $data_return = [];
        $data_return[] = ['name' => app_lang('open_invoice'), 'data' => [floatval($open_invoice)]];
        $data_return[] = ['name' => app_lang('overdue_invoices'), 'data' => [floatval($overdue_invoices)]];
        $data_return[] = ['name' => app_lang('paid_last_30_days'), 'data' => [floatval($paid_last_30_days)]];

        $where = $this->get_where_report_period();
        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_total = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                foreach ($accounts as $val) {
                    $db_builder->where('account', $val['id']);
                    if($where != ''){
                        $db_builder->where($where);
                    }
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    if($where != ''){
                        $db_builder->where($where);
                    }
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $total += $credits - $debits;
                    }else{
                        $total += $debits - $credits;
                    }
                }
            }
            $data_total[$data_key] = $total;
        }

        $income = $data_total['income'] + $data_total['other_income'];
        $data_return[] = ['name' => app_lang('has_been_mapping'), 'data' => [floatval($data_total['income'] + $data_total['other_income'])]];
        return $data_return;
    }

    /**
     * get data sales chart
     * @param  array $data_filter
     * @return array
     */
    public function get_data_sales_chart($data_filter){
        
        $where = $this->get_where_report_period('bill_date');

        $db_builder = $this->db->table(get_db_prefix().'invoices');
        if($where != ''){
            $db_builder->where($where);
        }

        $invoices = $db_builder->get()->getResultArray();

        $where = $this->get_where_report_period('expense_date');
        $db_builder = $this->db->table(get_db_prefix().'expenses');

        if($where != ''){
            $db_builder->where($where);
        }
        $expenses = $db_builder->get()->getResultArray();

        $data_return = [];
        $data_date = [];

        $list_invoice = '0';
        foreach ($invoices as $key => $value) {
            $list_invoice .= ','.$value['id'];
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('rel_id', $value['id']);
            $db_builder->where('rel_type', 'invoice');
            $db_builder->where('paid', 1);
            $count = $db_builder->countAllResults();

            if($count == 0){
                if(isset($data_date[$value['bill_date']])){
                    $data_date[$value['bill_date']]['payment'] += floatval($value['id']);
                }else{
                    $data_date[$value['bill_date']] = [];
                    $data_date[$value['bill_date']]['payment'] = floatval($value['id']);
                    $data_date[$value['bill_date']]['expense'] = 0;
                    $data_date[$value['bill_date']]['invoice_have_been_mapping'] = 0;
                    $data_date[$value['bill_date']]['expense_have_been_mapping'] = 0;
                }
            }
        }

        $list_expense = '0';

        foreach ($expenses as $key => $value) {
            $list_expense .= ','.$value['id'];

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('rel_id', $value['id']);
            $db_builder->where('rel_type', 'expense');
            $count = $db_builder->countAllResults();
            if($count == 0){
                if(isset($data_date[$value['expense_date']])){
                    $data_date[$value['expense_date']]['expense'] += floatval($value['amount']);
                }else{
                    $data_date[$value['expense_date']] = [];
                    $data_date[$value['expense_date']]['expense'] = floatval($value['amount']);
                    $data_date[$value['expense_date']]['payment'] = 0;
                    $data_date[$value['expense_date']]['invoice_have_been_mapping'] = 0;
                    $data_date[$value['expense_date']]['expense_have_been_mapping'] = 0;
                }
            }
        }

        $account_type_details = $this->get_account_type_details();

        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        $where = $this->get_where_report_period('date');

        foreach ($data_accounts as $data_key => $data_account) {
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    $db_builder->select('credit, debit, date, datecreated');
                    
                    if($where != ''){
                        $db_builder->where($where);
                    }
                    $account_history = $db_builder->get()->getResultArray();

                    foreach ($account_history as $val) {
                        $credits = $val['credit'] != '' ? $val['credit'] : 0;
                        $debits = $val['debit'] != '' ? $val['debit'] : 0;
                        $date = $val['date'] != '' ? $val['date'] : date('Y-m-d', strtotime($val['datecreated']));

                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                            $total = $credits - $debits;
                            if(isset($data_date[$date])){
                                $data_date[$date]['invoice_have_been_mapping'] += floatval($total);

                            }else{
                                $data_date[$date] = [];
                                $data_date[$date]['invoice_have_been_mapping'] = floatval($total);
                                $data_date[$date]['expense_have_been_mapping'] = 0;
                                $data_date[$date]['payment'] = 0;
                                $data_date[$date]['expense'] = 0;
                            }
                        }else{
                            $total = $debits - $credits;
                            if(isset($data_date[$date])){
                                $data_date[$date]['expense_have_been_mapping'] += floatval($total);
                            }else{
                                $data_date[$date] = [];
                                $data_date[$date]['expense_have_been_mapping'] = floatval($total);
                                $data_date[$date]['invoice_have_been_mapping'] = 0;
                                $data_date[$date]['payment'] = 0;
                                $data_date[$date]['expense'] = 0;
                            }
                        }
                    }

                }
            }
        }

        $sales = [];
        $invoice_have_been_mapping = [];
        $expense_have_been_mapping = [];
        $expenses = [];
        $categories = [];
        $date_array = [];

        foreach ($data_date as $d => $val) {
            $_date = $d;
            foreach ($data_date as $date => $value) {
                if(strtotime($_date) > (strtotime($date)) && !in_array($date,$date_array)){
                    $_date = $date;
                }elseif(!in_array($date,$date_array) && in_array($_date,$date_array)){
                    $_date = $date;
                }
            }

            $date_array[] = $_date;

        }

        foreach ($date_array as $date) {
            if(isset($data_date[$date])){
                $sales[] = $data_date[$date]['payment'];
                $expenses[] = $data_date[$date]['expense'];
                $invoice_have_been_mapping[] = $data_date[$date]['invoice_have_been_mapping'];
                $expense_have_been_mapping[] = $data_date[$date]['expense_have_been_mapping'];
                $categories[] = format_to_date($date);
            }
        }

        $data_return = [
            'data' => [
                ['name' => app_lang('sales'), 'data' => $sales],
                ['name' => app_lang('sales_have_been_mapping'), 'data' => $invoice_have_been_mapping],
                ['name' => app_lang('expenses'), 'data' => $expenses],
                ['name' => app_lang('expenses_have_been_mapping'), 'data' => $expense_have_been_mapping],
            ],
            'categories' => $categories
        ];
        return $data_return;
    }

    /**
     * add rule
     * @param array $data 
     */
    public function add_rule($data){
        if(isset($data['type'])){
            $type = $data['type'];
            unset($data['type']);
        }

        if(isset($data['subtype'])){
            $subtype = $data['subtype'];
            unset($data['subtype']);
        }

        if(isset($data['text'])){
            $text = $data['text'];
            unset($data['text']);
        }

        if(isset($data['subtype_amount'])){
            $subtype_amount = $data['subtype_amount'];
            unset($data['subtype_amount']);
        }

        if(!isset($data['auto_add'])){
            $data['auto_add'] = 0;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_banking_rules');
        $db_builder->insert($data);

        $insert_id = $this->db->insertID();

        if ($insert_id) {
            if(isset($type)){
                foreach ($type as $key => $value) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_banking_rule_details');
                    $db_builder->insert([
                        'rule_id' => $insert_id,
                        'type' => $value,
                        'subtype' => $subtype[$key],
                        'subtype_amount' => $subtype_amount[$key],
                        'text' => $text[$key],
                    ]);
                }
            }

            return $insert_id;
        }

        return false;
    }

    /**
     * update rule
     * @param array $data 
     */
    public function update_rule($data, $id){
        $affectedRows = 0;

        if(isset($data['type'])){
            $type = $data['type'];
            unset($data['type']);
        }

        if(isset($data['subtype'])){
            $subtype = $data['subtype'];
            unset($data['subtype']);
        }

        if(isset($data['text'])){
            $text = $data['text'];
            unset($data['text']);
        }

        if(isset($data['subtype_amount'])){
            $subtype_amount = $data['subtype_amount'];
            unset($data['subtype_amount']);
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_banking_rules');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            $affectedRows++;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_banking_rule_details');
        $db_builder->where('rule_id', $id);
        $db_builder->delete();

        if ($this->db->affectedRows() > 0) {
            $affectedRows++;
        }

        if(isset($type)){
            $db_builder = $this->db->table(get_db_prefix().'acc_banking_rule_details');
            foreach ($type as $key => $value) {
                $db_builder->insert([
                    'rule_id' => $id,
                    'type' => $value,
                    'subtype_amount' => $subtype_amount[$key],
                    'subtype' => $subtype[$key],
                    'text' => $text[$key],
                ]);
            }

            if ($this->db->affectedRows() > 0) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    /**
     * get rule
     * @param  integer $id 
     * @param  array $where 
     * @return object     
     */
    public function get_rule($id = '', $where = []){
        if($id != ''){
            $db_builder = $this->db->table(get_db_prefix().'acc_banking_rules');
            $db_builder->where('id', $id);
            $rule = $db_builder->get()->getRow();

            if($rule){
                $db_builder = $this->db->table(get_db_prefix().'acc_banking_rule_details');
                $db_builder->where('rule_id', $id);
                $rule->details = $db_builder->get()->getResultArray();
            }
            return $rule;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_banking_rules');
        $db_builder->where($where);
        $rule = $db_builder->get()->getResultArray();
        if($rule){
            foreach ($rule as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_banking_rule_details');
                $db_builder->where('rule_id', $value['id']);
                $rule[$key]['details'] = $db_builder->get()->getResultArray();
            }
        }
            
        return $rule;
    }

    /**
     * delete journal entry
     * @param integer $id
     * @return boolean
     */

    public function delete_rule($id)
    {
        $db_builder = $this->db->table(get_db_prefix().'acc_banking_rules');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            $db_builder = $this->db->table(get_db_prefix().'acc_banking_rule_details');
            $db_builder->where('rule_id', $id);
            $db_builder->delete();

            return true;
        }
        return false;
    }

    /**
     * insert batch banking
     * @param  array $data_insert 
     * @return boolean              
     */
    public function insert_batch_banking($data_insert){
        $rule = $this->get_rule();
        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        foreach ($data_insert as $value) {
            $value['date'] = str_replace('/', '-', $value['date']);
            $value['date'] = date('Y-m-d', strtotime($value['date']));

            $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
            $db_builder->insert($value);

            $insert_id = $this->db->insertID();

            if (!$insert_id) {
                continue;
            }

            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($value['date']) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    continue;
                }
            }

            $amount = $value['deposits'];
            if($value['withdrawals'] > 0){
                $amount = $value['withdrawals'];
            }
            foreach ($rule as $val) {
                if($this->check_rule($val, $value)){
                    if($val['then'] == 'exclude'){
                        break;
                    }elseif($val['auto_add'] == 0){
                        continue;
                    }

                    $data = [];
                    $node = [];
                    $node['split'] = $val['payment_account'];
                    $node['account'] = $val['deposit_to'];
                    $node['debit'] = $amount;
                    $node['date'] = $value['date'];
                    $node['credit'] = 0;
                    $node['description'] = app_lang('banking_rule');
                    $node['rel_id'] = $insert_id;
                    $node['rel_type'] = 'banking';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data[] = $node;

                    $node = [];
                    $node['split'] = $val['deposit_to'];
                    $node['account'] = $val['payment_account'];
                    $node['date'] = $value['date'];
                    $node['debit'] = 0;
                    $node['credit'] = $amount;
                    $node['description'] = app_lang('banking_rule');
                    $node['rel_id'] = $insert_id;
                    $node['rel_type'] = 'banking';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data[] = $node;

                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $affectedRows = $db_builder->insertBatch($data);

                    break;
                }
            }
        }

        return true;
    }

    /**
     * check rule
     * @param  array $rule 
     * @param  array $data 
     * @return boolean       
     */
    public function check_rule($rule, $data){
        $check = false;
        $amount = $data['deposits'];
        if($data['withdrawals'] > 0){
            $amount = $data['withdrawals'];
        }

        if(($rule['transaction'] == 'money_out' && $data['withdrawals'] > 0) || ($rule['transaction'] == 'money_in' && $data['deposits'] > 0)){
            if($rule['following'] == 'any'){
                foreach ($rule['details'] as $v) {
                    if ($v['type'] == 'amount') {
                        switch ($v['subtype_amount']) {
                            case 'does_not_equal':
                                if(floatval($v['text']) != $amount){
                                    return true;
                                }
                                break;
                            case 'equals':
                                if(floatval($v['text']) == $amount){
                                    return true;
                                }
                                break;
                            case 'is_greater_than':
                                if(floatval($v['text']) < $amount){
                                    return true;
                                }
                                break;
                            case 'is_loss_than':
                                if(floatval($v['text']) > $amount){
                                    return true;
                                }
                                break;
                            default:
                                break;
                        }
                    }elseif($v['type'] == 'description'){
                        switch ($v['subtype']) {
                            case 'contains':
                                if (strpos($data['description'], $v['text']) !== false) {
                                    return true;
                                }
                                break;
                            case 'does_not_contain':
                                if (strpos($data['description'], $v['text']) == false) {
                                    return true;
                                }
                                break;
                            case 'is_exactly':
                                if ($data['description'] == $v['text']) { 
                                    return true;
                                }
                                break;
                            default:
                                break;
                        }
                    }                      
                }
            }else{
                foreach ($rule['details'] as $v) {
                    if ($v['type'] == 'amount') {
                        switch ($v['subtype_amount']) {
                            case 'does_not_equal':
                                if(floatval($v['text']) == $amount){
                                    return false;
                                }
                                break;
                            case 'equals':
                                if(floatval($v['text']) != $amount){
                                    return false;
                                }
                                break;
                            case 'is_greater_than':
                                if(floatval($v['text']) > $amount){
                                    return false;
                                }
                                break;
                            case 'is_loss_than':
                                if(floatval($v['text']) < $amount){
                                    return false;
                                }
                                break;
                            default:
                                break;
                        }
                    }elseif($v['type'] == 'description'){
                        switch ($v['subtype']) {
                            case 'contains':
                                if (strpos($data['description'], $v['text']) == false) {
                                    return false;
                                }
                                break;
                            case 'does_not_contain':
                                if (strpos($data['description'], $v['text']) !== false) {
                                    return false;
                                }
                                break;
                            case 'is_exactly':
                                if ($data['description'] != $v['text']) { 
                                    return false;
                                }
                                break;
                            default:
                                break;
                        }
                    } 
                    $check = true;                     
                }

                return true;
            }
        }

        return $check;
    }

    /**
     * get data journal
     * @return array 
     */
    public function get_data_account_history($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $account = 0;

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['account'])){
            $account = $data_filter['account'];
        }

        $info_account = $this->get_accounts($account);

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        $data_report = [];
        
        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
        if($account != ''){
            $db_builder->where('account', $account);
        }
        $db_builder->orderBy('date', 'asc');
        
        $account_history = $db_builder->get()->getResultArray();
        $balance = 0;
        $amount = 0;
        foreach ($account_history as $v) {
            $decrease = 0;
            $increase = 0;
            if($info_account->account_type_id == 7 || $info_account->account_type_id == 8){
                $increase = $v['credit'];
                $decrease = $v['debit'];
                $balance += ($v['credit'] - $v['debit']);
            }elseif($info_account->account_type_id == 1){
                $increase = $v['credit'];
                $decrease = $v['debit'];
                $balance += ($v['debit'] - $v['credit']);
            }else{
                $increase = $v['debit'];
                $decrease = $v['credit'];
                $balance += ($v['debit'] - $v['credit']);
            }
            $data_report[] =   [
                            'date' => date('Y-m-d', strtotime($v['date'])),
                            'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                            'type' => app_lang($v['rel_type']),
                            'name' => (isset($account_name[$v['account']]) ? $account_name[$v['account']] : ''),
                            'description' => $v['description'],
                            'customer' => $v['customer'],
                            'decrease' => $decrease,
                            'increase' => $increase,
                            'balance' => $balance,
                        ];
        }
                
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'account_type' => $info_account->account_type_id];
    }

    /**
     * Gets the where report period.
     *
     * @param      string  $field  The field
     *
     * @return     string  The where report period.
     */
    private function get_where_report_period($field = 'date')
    {
        $request = Services::request();

        $months_report      = $request->getGet('date_filter');
        
        $custom_date_select = '';
        if ($months_report != '') {
            if (is_numeric($months_report)) {
                // Last month
                if ($months_report == '1') {
                    $beginMonth = date('Y-m-01', strtotime('first day of last month'));
                    $endMonth   = date('Y-m-t', strtotime('last day of last month'));
                } else {
                    $months_report = (int) $months_report;
                    $months_report--;
                    $beginMonth = date('Y-m-01', strtotime("-$months_report MONTH"));
                    $endMonth   = date('Y-m-t');
                }

                $custom_date_select = '(' . $field . ' BETWEEN "' . $beginMonth . '" AND "' . $endMonth . '")';
            } elseif ($months_report == 'last_30_days') {
                $custom_date_select = '(' . $field . ' BETWEEN "' . date('Y-m-d', strtotime('today - 30 days')) . '" AND "' . date('Y-m-d') . '")';
            } elseif ($months_report == 'this_month') {
                $custom_date_select = '(' . $field . ' BETWEEN "' . date('Y-m-01') . '" AND "' . date('Y-m-t') . '")';
            } elseif ($months_report == 'last_month') {
                $this_month = date('m') - 1;
                $custom_date_select = '(' . $field . ' BETWEEN "' . date("Y-m-d", strtotime("first day of previous month")) . '" AND "' . date("Y-m-d", strtotime("last day of previous month")) . '")';
            }elseif ($months_report == 'this_quarter') {
                $current_month = date('m');
                  $current_year = date('Y');
                  if($current_month>=1 && $current_month<=3)
                  {
                    $start_date = date('Y-m-d', strtotime('1-January-'.$current_year));  // timestamp or 1-Januray 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-April-'.$current_year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                  }
                  else  if($current_month>=4 && $current_month<=6)
                  {
                    $start_date = date('Y-m-d', strtotime('1-April-'.$current_year));  // timestamp or 1-April 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-July-'.$current_year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                  }
                  else  if($current_month>=7 && $current_month<=9)
                  {
                    $start_date = date('Y-m-d', strtotime('1-July-'.$current_year));  // timestamp or 1-July 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-October-'.$current_year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                  }
                  else  if($current_month>=10 && $current_month<=12)
                  {
                    $start_date = date('Y-m-d', strtotime('1-October-'.$current_year));  // timestamp or 1-October 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-January-'.($current_year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                  }
                $custom_date_select = '(' . $field . ' BETWEEN "' .
                $start_date .
                '" AND "' .
                $end_date . '")';

            }elseif ($months_report == 'last_quarter') {
                $current_month = date('m');
                    $current_year = date('Y');

                  if($current_month>=1 && $current_month<=3)
                  {
                    $start_date = date('Y-m-d', strtotime('1-October-'.($current_year-1)));  // timestamp or 1-October Last Year 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-January-'.$current_year));  // // timestamp or 1-January  12:00:00 AM means end of 31 December Last year
                  } 
                  else if($current_month>=4 && $current_month<=6)
                  {
                    $start_date = date('Y-m-d', strtotime('1-January-'.$current_year));  // timestamp or 1-Januray 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-April-'.$current_year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                  }
                  else  if($current_month>=7 && $current_month<=9)
                  {
                    $start_date = date('Y-m-d', strtotime('1-April-'.$current_year));  // timestamp or 1-April 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-July-'.$current_year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                  }
                  else  if($current_month>=10 && $current_month<=12)
                  {
                    $start_date = date('Y-m-d', strtotime('1-July-'.$current_year));  // timestamp or 1-July 12:00:00 AM
                    $end_date = date('Y-m-d', strtotime('1-October-'.$current_year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                  }
                $custom_date_select = '(' . $field . ' BETWEEN "' .
                $start_date .
                '" AND "' .
                $end_date . '")';

            }elseif ($months_report == 'this_year') {
                $custom_date_select = '(' . $field . ' BETWEEN "' .
                date('Y-m-d', strtotime(date('Y-01-01'))) .
                '" AND "' .
                date('Y-m-d', strtotime(date('Y-12-31'))) . '")';
            } elseif ($months_report == 'last_year') {
                $custom_date_select = '(' . $field . ' BETWEEN "' .
                date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-01-01'))) .
                '" AND "' .
                date('Y-m-d', strtotime(date(date('Y', strtotime('last year')) . '-12-31'))) . '")';
            } elseif ($months_report == 'custom') {
                $from_date = to_sql_date($this->input->post('report_from'));
                $to_date   = to_sql_date($this->input->post('report_to'));
                if ($from_date == $to_date) {
                    $custom_date_select = '' . $field . ' = "' . $from_date . '"';
                } else {
                    $custom_date_select = '(' . $field . ' BETWEEN "' . $from_date . '" AND "' . $to_date . '")';
                }
            } elseif(!(strpos($months_report, 'financial_year') === false)){
                $year = explode('financial_year_', $months_report);

                $first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

                $month = date('m', strtotime($first_month_of_financial_year));
                $custom_date_select = '(' . $field . ' BETWEEN "' . date($year[1].'-'.$month.'-01') . '" AND "' . date(($year[1]+1).'-'.$month.'-01') . '")';
            }
        }

        return $custom_date_select;
    }


    /**
     * Change account status / active / inactive
     * @param  mixed $id     staff id
     * @param  mixed $status status(0/1)
     */
    public function change_account_status($id, $status)
    {
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('id', $id);
        $db_builder->update([
            'active' => $status,
        ]);

        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Automatic invoice conversion
     * @param  integer $invoice_id 
     * @return boolean
     */
    public function automatic_invoice_conversion($invoice_id = '', $invoice_item_id = ''){
        if(get_setting('acc_invoice_automatic_conversion') == 0){
            return false;
        }

        if($invoice_id == ''){
            $Invoice_items_model = model('Invoice_items_model');
            $invoice_item = $Invoice_items_model->get_one($invoice_item_id);
            $invoice_id = $invoice_item->invoice_id;
        }

        $this->delete_convert($invoice_id, 'invoice');

        $affectedRows = 0;

        $Invoices_model = model('Invoices_model');
        $invoice = $Invoices_model->get_one($invoice_id);
        $invoice_summary = $Invoices_model->get_invoice_total_summary($invoice_id);

        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        $currency_converter = 0;

        $payment_account = get_setting('acc_invoice_payment_account');
        $deposit_to = get_setting('acc_invoice_deposit_to');
        $tax_payment_account = get_setting('acc_tax_payment_account');
        $tax_deposit_to = get_setting('acc_tax_deposit_to');

        if($invoice){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($invoice->bill_date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }

            $paid = 0;


            if($invoice_summary->balance_due == 0){
                $paid = 1;
            }else{
                $paid = 0;
            }

            $data_insert = [];
            
            $Invoice_items_model = model('Invoice_items_model');
            $items = $Invoice_items_model->get_details(array("invoice_id" => $invoice_id))->getResult();

            $tax_array = [];
            $tax_array[] = ['tax_name' => $invoice_summary->tax_name, 
                            'tax' => $invoice_summary->tax, 
                            'tax_rate' => $invoice_summary->tax_percentage];

            $tax_array[] = ['tax_name' => $invoice_summary->tax_name2, 
                            'tax' => $invoice_summary->tax2, 
                            'tax_rate' => $invoice_summary->tax_percentage2];

            $tax_array[] = ['tax_name' => $invoice_summary->tax_name3, 
                            'tax' => $invoice_summary->tax3, 
                            'tax_rate' => $invoice_summary->tax_percentage3];
            foreach($tax_array as $tax){
                if($tax['tax'] == ''){
                    continue;
                }
                
                $tax_name = $tax['tax_name'];
                $tax_rate = $tax['tax_rate'];

                $db_builder = $this->db->table(get_db_prefix().'taxes');

                $db_builder->where('title', $tax_name);
                $db_builder->where('percentage', $tax_rate);
                $_tax = $db_builder->get()->getRow();

                $total_tax = $tax['tax'];
                if($currency_converter == 1){
                    $total_tax = round($this->currency_converter($invoice->currency_name, $currency->name, $tax['total_tax']), 2);
                }

                if($_tax){
                    $tax_mapping = $this->get_tax_mapping($_tax->id);
                    if($tax_mapping){
                        $node = [];
                        $node['itemable_id'] = 0;
                        $node['split'] = $tax_mapping->payment_account;
                        $node['account'] = $tax_mapping->deposit_to;
                        $node['tax'] = $_tax->id;
                        $node['item'] = 0;
                        $node['paid'] = $paid;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['customer'] = $invoice->client_id;
                        $node['date'] = $invoice->bill_date;
                        $node['description'] = '';
                        $node['rel_id'] = $invoice_id;
                        $node['rel_type'] = 'invoice';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['itemable_id'] = 0;
                        $node['split'] = $tax_mapping->deposit_to;
                        $node['customer'] = $invoice->client_id;
                        $node['account'] = $tax_mapping->payment_account;
                        $node['tax'] = $_tax->id;
                        $node['item'] = 0;
                        $node['paid'] = $paid;
                        $node['date'] = $invoice->bill_date;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $invoice_id;
                        $node['rel_type'] = 'invoice';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['itemable_id'] = 0;
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $_tax->id;
                        $node['item'] = 0;
                        $node['date'] = $invoice->bill_date;
                        $node['paid'] = $paid;
                        $node['debit'] = $total_tax;
                        $node['customer'] = $invoice->client_id;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $invoice_id;
                        $node['rel_type'] = 'invoice';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['itemable_id'] = 0;
                        $node['split'] = $tax_deposit_to;
                        $node['customer'] = $invoice->client_id;
                        $node['account'] = $tax_payment_account;
                        $node['date'] = $invoice->bill_date;
                        $node['tax'] = $_tax->id;
                        $node['item'] = 0;
                        $node['paid'] = $paid;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $invoice_id;
                        $node['rel_type'] = 'invoice';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }
                }else{
                    $node = [];
                    $node['itemable_id'] = 0;
                    $node['split'] = $tax_payment_account;
                    $node['account'] = $tax_deposit_to;
                    $node['tax'] = 0;
                    $node['item'] = 0;
                    $node['date'] = $invoice->bill_date;
                    $node['paid'] = $paid;
                    $node['debit'] = $total_tax;
                    $node['customer'] = $invoice->client_id;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $invoice_id;
                    $node['rel_type'] = 'invoice';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['itemable_id'] = 0;
                    $node['split'] = $tax_deposit_to;
                    $node['customer'] = $invoice->client_id;
                    $node['account'] = $tax_payment_account;
                    $node['date'] = $invoice->bill_date;
                    $node['tax'] = 0;
                    $node['item'] = 0;
                    $node['paid'] = $paid;
                    $node['debit'] = 0;
                    $node['credit'] = $total_tax;
                    $node['description'] = '';
                    $node['rel_id'] = $invoice_id;
                    $node['rel_type'] = 'invoice';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }
            }

            foreach ($items as $value) {
                $item = $this->get_item_by_name($value->title);
                $item_id = 0;
                if(isset($item->id)){
                    $item_id = $item->id;
                }

                $item_total = $value->quantity * $value->rate;
                if($currency_converter == 1){
                    $item_total = round($this->currency_converter($invoice->currency_name, $currency->name, $value->qty * $value->rate), 2);
                }

                $item_automatic = $this->get_item_automatic($item_id);

                if($item_automatic){
                    $node = [];
                    $node['itemable_id'] = $value->id;
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['item'] = $item_id;
                    $node['date'] = $invoice->bill_date;
                    $node['paid'] = $paid;
                    $node['debit'] = $item_total;
                    $node['customer'] = $invoice->client_id;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $invoice_id;
                    $node['rel_type'] = 'invoice';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['itemable_id'] = $value->id;
                    $node['split'] = $deposit_to;
                    $node['customer'] = $invoice->client_id;
                    $node['account'] = $item_automatic->income_account;
                    $node['item'] = $item_id;
                    $node['paid'] = $paid;
                    $node['date'] = $invoice->bill_date;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $invoice_id;
                    $node['rel_type'] = 'invoice';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['itemable_id'] = $value->id;
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['customer'] = $invoice->client_id;
                    $node['paid'] = $paid;
                    $node['date'] = $invoice->bill_date;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $invoice_id;
                    $node['rel_type'] = 'invoice';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['itemable_id'] = $value->id;
                    $node['split'] = $deposit_to;
                    $node['customer'] = $invoice->client_id;
                    $node['account'] = $payment_account;
                    $node['item'] = $item_id;
                    $node['date'] = $invoice->bill_date;
                    $node['paid'] = $paid;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $invoice_id;
                    $node['rel_type'] = 'invoice';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }
            }
            if($data_insert != []){
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                $affectedRows = $db_builder->insertBatch($data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Automatic payment conversion
     * @param  integer $payment_id 
     * @return boolean
     */
    public function automatic_payment_conversion($payment_id){
        $this->delete_convert($payment_id, 'payment');

        $Invoice_payments_model = model('Invoice_payments_model');
        $payment = $Invoice_payments_model->get_one($payment_id);

        if($payment->invoice_id == ''){
            return false;
        }

        $payment_account = get_setting('acc_payment_payment_account');
        $deposit_to = get_setting('acc_payment_deposit_to');
        $affectedRows = 0;

        $this->automatic_invoice_conversion($payment->invoice_id);

        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        if($payment){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($payment->payment_date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }
            $Invoices_model = model('Invoices_model');
            $invoice = $Invoices_model->get_one($payment->invoice_id);

            $payment_total = $payment->amount;

            if(get_setting('acc_active_payment_mode_mapping') == 1){
                $payment_mode_mapping = $this->get_payment_mode_mapping($payment->payment_method_id);
                $data_insert = [];
                if($payment_mode_mapping){
                    $node = [];
                    $node['split'] = $payment_mode_mapping->payment_account;
                    $node['account'] = $payment_mode_mapping->deposit_to;
                    $node['date'] = $payment->payment_date;
                    $node['debit'] = $payment_total;
                    $node['customer'] = $invoice->client_id;
                    $node['credit'] = 0;
                    $node['tax'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $payment_id;
                    $node['rel_type'] = 'payment';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $payment_mode_mapping->deposit_to;
                    $node['customer'] = $invoice->client_id;
                    $node['account'] = $payment_mode_mapping->payment_account;
                    $node['date'] = $payment->payment_date;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $payment_total;
                    $node['description'] = '';
                    $node['rel_id'] = $payment_id;
                    $node['rel_type'] = 'payment';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }

                if(count($data_insert) == 0){   
                    if(get_setting('acc_payment_automatic_conversion') == 1){
                        $node = [];
                        $node['split'] = $payment_account;
                        $node['account'] = $deposit_to;
                        $node['customer'] = $invoice->client_id;
                        $node['debit'] = $payment_total;
                        $node['credit'] = 0;
                        $node['date'] = $payment->payment_date;
                        $node['description'] = '';
                        $node['rel_id'] = $payment_id;
                        $node['rel_type'] = 'payment';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $deposit_to;
                        $node['customer'] = $invoice->client_id;
                        $node['account'] = $payment_account;
                        $node['date'] = $payment->payment_date;
                        $node['debit'] = 0;
                        $node['credit'] = $payment_total;
                        $node['description'] = '';
                        $node['rel_id'] = $payment_id;
                        $node['rel_type'] = 'payment';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }
                }
            }else{
                if(get_setting('acc_payment_automatic_conversion') == 1){
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['customer'] = $invoice->client_id;
                    $node['debit'] = $payment_total;
                    $node['credit'] = 0;
                    $node['date'] = $payment->payment_date;
                    $node['description'] = '';
                    $node['rel_id'] = $payment_id;
                    $node['rel_type'] = 'payment';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to;
                    $node['customer'] = $invoice->client_id;
                    $node['account'] = $payment_account;
                    $node['date'] = $payment->payment_date;
                    $node['debit'] = 0;
                    $node['credit'] = $payment_total;
                    $node['description'] = '';
                    $node['rel_id'] = $payment_id;
                    $node['rel_type'] = 'payment';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }
            }

            if($data_insert != []){
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                $affectedRows = $db_builder->insertBatch($data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Automatic expense conversion
     * @param  integer $expense_id 
     * @return boolean
     */
    public function automatic_expense_conversion($expense_id){
    
        $this->delete_convert($expense_id, 'expense');

        $expenses_model = model('Expenses_model');
        $expense = $expenses_model->get_details($expense_id)->getRow();

        $payment_account = get_setting('acc_expense_payment_account');
        $deposit_to = get_setting('acc_expense_deposit_to');
        $tax_payment_account = get_setting('acc_tax_payment_account');
        $tax_deposit_to = get_setting('acc_tax_deposit_to');
        $payment_mode_payment_account = get_setting('acc_expense_payment_payment_account');
        $payment_mode_deposit_to = get_setting('acc_expense_payment_deposit_to');
        $affectedRows = 0;
        $users_model = model("App\Models\Users_model", false);
        $created_by = $users_model->login_user_id();

        if($expense){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($expense->expense_date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }

            $expense_total = $expense->amount;

            $data_insert = [];

            if(get_setting('acc_active_expense_category_mapping') == 1){
                $expense_category_mapping = $this->get_expense_category_mapping($expense->category_id);
                if($expense_category_mapping){
                    if($expense_category_mapping->preferred_payment_method == 1 && $expense->paymentmode > 0){
                        $payment_mode_mapping = $this->get_payment_mode_mapping($expense->paymentmode);

                        if($payment_mode_mapping){
                            if(get_setting('acc_active_payment_mode_mapping') == 1){
                                $node = [];
                                $node['split'] = $payment_mode_mapping->expense_payment_account;
                                $node['account'] = $payment_mode_mapping->expense_deposit_to;
                                $node['tax'] = 0;
                                $node['debit'] = $expense_total;
                                $node['credit'] = 0;
                                $node['customer'] = $expense->client_id;
                                $node['date'] = $expense->expense_date;
                                $node['description'] = '';
                                $node['rel_id'] = $expense_id;
                                $node['rel_type'] = 'expense';
                                $node['datecreated'] = date('Y-m-d H:i:s');
                                $node['addedfrom'] = $created_by;
                                $data_insert[] = $node;

                                $node = [];
                                $node['split'] = $payment_mode_mapping->expense_deposit_to;
                                $node['customer'] = $expense->client_id;
                                $node['account'] = $payment_mode_mapping->expense_payment_account;
                                $node['tax'] = 0;
                                $node['date'] = $expense->expense_date;
                                $node['debit'] = 0;
                                $node['credit'] = $expense_total;
                                $node['description'] = '';
                                $node['rel_id'] = $expense_id;
                                $node['rel_type'] = 'expense';
                                $node['datecreated'] = date('Y-m-d H:i:s');
                                $node['addedfrom'] = $created_by;
                                $data_insert[] = $node;
                            }
                        }
                    }

                    if(count($data_insert) == 0){   
                        $node = [];
                        $node['split'] = $expense_category_mapping->payment_account;
                        $node['account'] = $expense_category_mapping->deposit_to;
                        $node['date'] = $expense->expense_date;
                        $node['debit'] = $expense_total;
                        $node['customer'] = $expense->client_id;
                        $node['credit'] = 0;
                        $node['tax'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $expense_category_mapping->deposit_to;
                        $node['customer'] = $expense->client_id;
                        $node['account'] = $expense_category_mapping->payment_account;
                        $node['date'] = $expense->expense_date;
                        $node['tax'] = 0;
                        $node['debit'] = 0;
                        $node['credit'] = $expense_total;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }

                }

                if(count($data_insert) == 0 && get_setting('acc_expense_automatic_conversion') == 1){   
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['debit'] = $expense_total;
                    $node['customer'] = $expense->client_id;
                    $node['date'] = $expense->expense_date;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $expense_id;
                    $node['rel_type'] = 'expense';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to;
                    $node['account'] = $payment_account;
                    $node['customer'] = $expense->client_id;
                    $node['date'] = $expense->expense_date;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $expense_total;
                    $node['description'] = '';
                    $node['rel_id'] = $expense_id;
                    $node['rel_type'] = 'expense';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }
            }else{

                if(get_setting('acc_expense_automatic_conversion') == 1){
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['debit'] = $expense_total;
                    $node['customer'] = $expense->client_id;
                    $node['date'] = $expense->expense_date;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $expense_id;
                    $node['rel_type'] = 'expense';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to;
                    $node['account'] = $payment_account;
                    $node['customer'] = $expense->client_id;
                    $node['date'] = $expense->expense_date;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $expense_total;
                    $node['description'] = '';
                    $node['rel_id'] = $expense_id;
                    $node['rel_type'] = 'expense';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = $created_by;
                    $data_insert[] = $node;
                }
            }

            if(get_setting('acc_tax_automatic_conversion') == 1){
                if($expense->tax_id > 0){

                    $total_tax = $expense_info->amount * ($expense_info->tax_percentage / 100);
                   
                    $tax_mapping = $this->get_tax_mapping($expense->tax_id);
                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->expense_payment_account;
                        $node['account'] = $tax_mapping->expense_deposit_to;
                        $node['tax'] = $expense->tax_id;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['customer'] = $expense->client_id;
                        $node['date'] = $expense->expense_date;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->expense_deposit_to;
                        $node['customer'] = $expense->client_id;
                        $node['account'] = $tax_mapping->expense_payment_account;
                        $node['tax'] = $expense->tax_id;
                        $node['date'] = $expense->expense_date;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $expense->tax_id;
                        $node['date'] = $expense->expense_date;
                        $node['debit'] = $total_tax;
                        $node['customer'] = $expense->client_id;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['customer'] = $expense->client_id;
                        $node['account'] = $tax_payment_account;
                        $node['date'] = $expense->expense_date;
                        $node['tax'] = $expense->tax_id;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }
                }

                if($expense->tax_id2 > 0){
                    $total_tax = $expense_info->amount * ($expense_info->tax_percentage2 / 100);
                   
                    $tax_mapping = $this->get_tax_mapping($expense->tax_id2);
                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->expense_payment_account;
                        $node['account'] = $tax_mapping->expense_deposit_to;
                        $node['tax'] = $expense->tax_id2;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['customer'] = $expense->client_id;
                        $node['date'] = $expense->expense_date;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->expense_deposit_to;
                        $node['customer'] = $expense->client_id;
                        $node['account'] = $tax_mapping->expense_payment_account;
                        $node['tax'] = $expense->tax_id2;
                        $node['date'] = $expense->expense_date;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $expense->tax_id2;
                        $node['date'] = $expense->expense_date;
                        $node['debit'] = $total_tax;
                        $node['customer'] = $expense->client_id;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['customer'] = $expense->client_id;
                        $node['account'] = $tax_payment_account;
                        $node['date'] = $expense->expense_date;
                        $node['tax'] = $expense->tax_id2;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $expense_id;
                        $node['rel_type'] = 'expense';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = $created_by;
                        $data_insert[] = $node;
                    }
                }
            }

            if($data_insert != []){
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                $affectedRows = $db_builder->insertBatch($data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    
    /**
     * count invoice not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object          
     */
    public function count_invoice_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';

        $db_builder = $this->db->table(get_db_prefix().'invoices');
        $db_builder->where('deleted', 0);

        if($where != ''){
            $db_builder->where($where);
        }


        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'invoices.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "invoice") = 0) '.$where_currency);
        return $db_builder->countAllResults();
    }

    /**
     * count payment not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object
     */
    public function count_payment_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';

        $db_builder = $this->db->table(get_db_prefix().'invoice_payments');
        $db_builder->where('deleted', 0);

        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'invoice_payments.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "payment") = 0) '.$where_currency);
        return $db_builder->countAllResults();
    }

    /**
     * count expense not convert yet
     * @param  string $where
     * @param  integer $currency
     * @return object
     */
    public function count_expense_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';
        if($currency != ''){
            $where_currency = 'and currency = '.$currency;
        }

        $db_builder = $this->db->table(get_db_prefix().'expenses');
        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'expenses.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "expense") = 0) '.$where_currency);
        return $db_builder->countAllResults();
    }

    /**
     * delete invoice convert
     * @param  integer $invoice_id 
     * @return boolean            
     */
    public function delete_invoice_convert($invoice_id){
        $affectedRows = 0;

        $check = $this->delete_convert($invoice_id,'invoice');
        if($check){
            $affectedRows++;
        }

        $db_builder = $this->db->table(get_db_prefix() . 'invoice_payments');
        $db_builder->where('invoiceid', $invoice_id);
        $payments = $db_builder->get()->getResultArray();

        foreach ($payments as $key => $value) {
            $check = $this->delete_convert($value['id'],'payment');
            if($check){
                $affectedRows++;
            }
        }

        if($affectedRows > 0){
            return true;
        }

        return false;
    }

    /**
     * invoice status changed
     * @param  array $data 
     * @return boolean       
     */
    public function invoice_status_changed($data){
        if(isset($data['invoice_id']) && isset($data['status'])){
            if($data['status'] == 2){
                $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
                $db_builder->where('rel_id', $data['invoice_id']);
                $db_builder->where('rel_type', 'invoice');
                $db_builder->update(['paid' => 1]);
                if ($this->db->affectedRows() > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * get items are not yet auto
     * @return array
     */
    public function get_items_not_yet_auto(){
        $db_builder = $this->db->table(get_db_prefix().'items');
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_item_automatics where ' . get_db_prefix() . 'acc_item_automatics.item_id = ' . get_db_prefix() . 'items.id) = 0)');
        return $db_builder->get()->getResultArray();
    }

    /**
     * add item automatic
     * @param array $data
     * @return boolean
     */
    public function add_item_automatic($data){
        if(isset($data['id'])){
            unset($data['id']);
        }
        $items = [];
        if(isset($data['item'])){
            $items = $data['item'];
            unset($data['item']);
        }
        $data_insert = [];
        $db_builder = $this->db->table(get_db_prefix() . 'acc_item_automatics');

        foreach ($items as $value) {
            $db_builder->where('item_id', $value);
            $count = $db_builder->countAllResults();

            if($count == 0 && $value != ''){
                $node = [];
                $node['item_id'] = $value;
                $node['inventory_asset_account'] = $data['inventory_asset_account'];
                $node['income_account'] = $data['income_account'];
                $node['expense_account'] = $data['expense_account'];

                $data_insert[] = $node;
            }

        }

        $affectedRows = $db_builder->insertBatch($data_insert);

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    /**
     * update item automatic
     * @param array $data
     * @param  integer $id 
     * @return boolean
     */
    public function update_item_automatic($data, $id){
        $db_builder = $this->db->table(get_db_prefix() . 'acc_item_automatics');
        $db_builder->where('id', $id);
        $db_builder->update($data);
       
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * delete item automatic
     * @param integer $id
     * @return boolean
     */

    public function delete_item_automatic($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_item_automatics');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Gets the item by name.
     *
     * @param      string  $item_name  The itemid
     *
     * @return     object  The item.
     */
    public function get_item_by_name($item_name) {
        $db_builder = $this->db->table(get_db_prefix() . 'items');

        $db_builder->where('title', $item_name);
        return $db_builder->get()->getRow();
    }

    /**
     * Gets the item automatic
     *
     * @param      string  $item_id  The itemid
     *
     * @return     object  The item automatic.
     */
    public function get_item_automatic($item_id) {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_item_automatics');
        $db_builder->where('item_id', $item_id);
        return $db_builder->get()->getRow();
    }

    /**
     * delete banking
     * @param integer $id
     * @return boolean
     */

    public function delete_banking($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_transaction_bankings');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
            $db_builder->where('rel_id', $id);
            $db_builder->where('rel_type', 'banking');
            $db_builder->delete();

            return true;
        }
        return false;
    }

    /**
     * add tax mapping
     * @param array $data
     * @return boolean
     */
    public function add_tax_mapping($data){
        if(isset($data['id'])){
            unset($data['id']);
        }
        $taxs = [];
        if(isset($data['tax'])){
            $taxs = $data['tax'];
            unset($data['tax']);
        }

        $data_insert = [];

        $db_builder = $this->db->table(get_db_prefix() . 'acc_tax_mappings');
        foreach ($taxs as $value) {
            $db_builder->where('tax_id', $value);
            $count = $db_builder->countAllResults();

            if($count == 0 && $value != ''){
                $node = [];
                $node['tax_id'] = $value;
                $node['payment_account'] = $data['payment_account'];
                $node['deposit_to'] = $data['deposit_to'];
                $node['expense_payment_account'] = $data['expense_payment_account'];
                $node['expense_deposit_to'] = $data['expense_deposit_to'];

                $data_insert[] = $node;
            }

        }

        $affectedRows = $db_builder->insertBatch($data_insert);

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    /**
     * update tax mapping
     * @param array $data
     * @param  integer $id 
     * @return boolean
     */
    public function update_tax_mapping($data, $id){
        $db_builder = $this->db->table(get_db_prefix() . 'acc_tax_mappings');
        $db_builder->where('id', $id);
        $db_builder->update($data);
       
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * delete tax mapping
     * @param integer $id
     * @return boolean
     */

    public function delete_tax_mapping($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_tax_mappings');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * get taxes are not yet auto
     * @return array
     */
    public function get_taxes_not_yet_auto(){
        $db_builder = $this->db->table(get_db_prefix().'taxes');
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_tax_mappings where ' . get_db_prefix() . 'acc_tax_mappings.tax_id = ' . get_db_prefix() . 'taxes.id) = 0)');
        return $db_builder->get()->getResultArray();
    }

    /**
     * Gets the tax mapping
     *
     * @param      string  $tax_id  The tax id
     *
     * @return     object  The tax mapping.
     */
    public function get_tax_mapping($tax_id) {

        $db_builder = $this->db->table(get_db_prefix() . 'acc_tax_mappings');
        $db_builder->where('tax_id', $tax_id);
        return $db_builder->get()->getRow();
    }

    /**
     * [currency_converter description]
     * @param  string $from   Currency Code
     * @param  string $to     Currency Code
     * @param  float $amount
     * @return float        
     */
    public function currency_converter($from,$to,$amount)
    {
        $url = "https://api.frankfurter.app/latest?amount=$amount&from=$from&to=$to"; 

        $response = json_decode($this->api_get($url));

        if(isset($response->rates->$to)){
            return $response->rates->$to;
        }

        return false;
    }

    /**
     * api get
     * @param  string $url
     * @return string    
     */
    public function api_get($url) {
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        
        return curl_exec($curl);
    }

    /**
     * get expense category are not yet auto
     * @return array
     */
    public function get_expense_category_not_yet_auto(){
        $db_builder = $this->db->table(get_db_prefix().'expense_categories');
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_expense_category_mappings where ' . get_db_prefix() . 'acc_expense_category_mappings.category_id = ' . get_db_prefix() . 'expense_categories.id) = 0)');
        return $db_builder->get()->getResultArray();
    }

    /**
     * add expense category mapping
     * @param array $data
     * @return boolean
     */
    public function add_expense_category_mapping($data){
        if(isset($data['id'])){
            unset($data['id']);
        }
        $categorys = [];
        if(isset($data['category'])){
            $categorys = $data['category'];
            unset($data['category']);
        }
        
        if (!isset($data['preferred_payment_method'])) {
            $data['preferred_payment_method'] = 0;
        }

        $data_insert = [];
        $db_builder = $this->db->table(get_db_prefix().'acc_expense_category_mappings');

        foreach ($categorys as $value) {
            $db_builder->where('category_id', $value);
            $count = $db_builder->countAllResults();

            if($count == 0 && $value != ''){
                $node = [];
                $node['category_id'] = $value;
                $node['payment_account'] = $data['payment_account'];
                $node['deposit_to'] = $data['deposit_to'];

                $data_insert[] = $node;
            }

        }
        $affectedRows = $db_builder->insertBatch($data_insert);

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    /**
     * update expense category mapping
     * @param array $data
     * @param  integer $id 
     * @return boolean
     */
    public function update_expense_category_mapping($data, $id){
        if (!isset($data['preferred_payment_method'])) {
            $data['preferred_payment_method'] = 0;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_expense_category_mappings');
        $db_builder->where('id', $id);
        $db_builder->update($data);
       
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * delete expense category mapping
     * @param integer $id
     * @return boolean
     */

    public function delete_expense_category_mapping($id)
    {
        $db_builder = $this->db->table(get_db_prefix().'acc_expense_category_mappings');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Gets the expense category mappings
     *
     * @param      string  $category_id  The expense category id
     *
     * @return     object  The expense category mapping.
     */
    public function get_expense_category_mapping($category_id) {

        $db_builder = $this->db->table(get_db_prefix().'acc_expense_category_mappings');
        $db_builder->where('category_id', $category_id);
        return $db_builder->get()->getRow();
    }

    /**
     * get data tax detail report
     * @return array 
     */
    public function get_data_tax_detail_report($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        $data_report = [];
        $data_report['tax_collected_on_sales'] = [];
        $data_report['total_taxable_sales_in_period_before_tax'] = [];

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '") and tax > 0 and rel_type = "invoice" and debit > 0');
        if($accounting_method == 'cash'){
            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
        }
        $db_builder->orderBy('date', 'asc');
        
        $account_history = $db_builder->get()->getResultArray();
        
        $list_invoice = [];        
        $Invoices_model = model('Invoices_model');
        foreach ($account_history as $v) {

            if(!in_array($v['rel_id'], $list_invoice)){
                $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['rel_id']);

                $list_invoice[] = $v['rel_id'];

                $data_report['total_taxable_sales_in_period_before_tax'][] = [
                                'date' => date('Y-m-d', strtotime($v['date'])),
                                'type' => app_lang($v['rel_type']),
                                'description' => $v['description'],
                                'customer' => $v['customer'],
                                'amount' => $invoice_total_summary->invoice_subtotal,
                            ];
            }

            $db_builder = $this->db->table(get_db_prefix().'taxes');
            $db_builder->where('id', $v['tax']);
            $_tax = $db_builder->get()->getRow();

            $data_report['tax_collected_on_sales'][] = [
                            'date' => date('Y-m-d', strtotime($v['date'])),
                            'type' => app_lang($v['rel_type']),
                            'tax_name' => $_tax->title,
                            'tax_rate' => $_tax->percentage,
                            'description' => $v['description'],
                            'customer' => $v['customer'],
                            'amount' => $v['debit'],
                        ];
        }

        $data_report['tax_reclaimable_on_purchases'] = [];
        $data_report['total_taxable_purchases_in_period_before_tax'] = [];

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '") and tax > 0 and rel_type = "expense" and credit > 0');
        if($accounting_method == 'cash'){
            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
        }
        $db_builder->orderBy('date', 'asc');
        
        $account_history = $db_builder->get()->getResultArray();

        $list_expense = [];        
        $Expenses_model = model('Expenses_model');
        foreach ($account_history as $v) {

            if(!in_array($v['rel_id'], $list_expense)){
                $list_expense[] = $v['rel_id'];

                $expense = $Expenses_model->get_one($v['rel_id']);

                $data_report['total_taxable_purchases_in_period_before_tax'][] = [
                                'date' => date('Y-m-d', strtotime($v['date'])),
                                'type' => app_lang($v['rel_type']),
                                'description' => $v['description'],
                                'customer' => $v['customer'],
                                'amount' => $expense->amount,
                            ];
            }

            $db_builder = $this->db->table(get_db_prefix().'taxes');
            $db_builder->where('id', $v['tax']);
            $_tax = $db_builder->get()->getRow();

            $data_report['tax_reclaimable_on_purchases'][] = [
                            'date' => date('Y-m-d', strtotime($v['date'])),
                            'type' => app_lang($v['rel_type']),
                            'tax_name' => $_tax->title,
                            'tax_rate' => $_tax->percentage,
                            'description' => $v['description'],
                            'customer' => $v['customer'],
                            'amount' => $v['credit'],
                        ];
        }
                
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data tax summary report
     * @return array 
     */
    public function get_data_tax_summary_report($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $tax = 0;
        if(isset($data_filter['tax'])){
            $tax = $data_filter['tax'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        $data_report = [];
        $data_report['tax_collected_on_sales'] = 0;
        $data_report['total_taxable_sales_in_period_before_tax'] = 0;
        $data_report['adjustments_to_tax_on_sales'] = 0;
        $data_report['total_taxable_purchases_in_period_before_tax'] = 0;
        $data_report['tax_reclaimable_on_purchases'] = 0;
        $data_report['other_adjustments'] = 0;
        $data_report['tax_due_or_credit_from_previous_periods'] = 0;
        $data_report['tax_payments_made_this_period'] = 0;
        $data_report['adjustments_to_reclaimable_tax_on_purchases'] = 0;

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');

        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '") and tax = '.$tax.' and rel_type = "invoice" and debit > 0');

        if($accounting_method == 'cash'){
            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
        }
        $db_builder->orderBy('date', 'asc');
        
        $account_history = $db_builder->get()->getResultArray();
        
        $Invoices_model = model('Invoices_model');
        $list_invoice = [];        
        foreach ($account_history as $v) {

            if(!in_array($v['rel_id'], $list_invoice)){
                $list_invoice[] = $v['rel_id'];
                $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['rel_id']);
                $data_report['total_taxable_sales_in_period_before_tax'] += $invoice_total_summary->invoice_subtotal;
            }

            $data_report['tax_collected_on_sales'] += $v['debit'];
        }

        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '") and tax = '.$tax.' and rel_type = "expense" and credit > 0');
        if($accounting_method == 'cash'){
            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
        }
        $db_builder->orderBy('date', 'asc');
        
        $account_history = $db_builder->get()->getResultArray();
        $Expenses_model = model('Expenses_model');

        $list_expense = [];        
        foreach ($account_history as $v) {

            if(!in_array($v['rel_id'], $list_expense)){
                $list_expense[] = $v['rel_id'];
                $expense = $Expenses_model->get_one($v['rel_id']);

                $data_report['total_taxable_purchases_in_period_before_tax'] += $expense->amount;
            }

            $data_report['tax_reclaimable_on_purchases'] += $v['credit'];
        }
                
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data tax liability report
     * @return array 
     */
    public function get_data_tax_liability_report($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $accounts = $this->get_accounts();

        $account_name = [];

        foreach ($accounts as $key => $value) {
            $account_name[$value['id']] = $value['name'];
        }

        $data_report = [];

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '") and tax > 0 and (rel_type = "invoice" or rel_type = "expense") and debit > 0');
        if($accounting_method == 'cash'){
            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
        }
        $db_builder->orderBy('tax, rel_type', 'asc');
        $account_history = $db_builder->get()->getResultArray();
        
        $list_invoice = [];        
        foreach ($account_history as $v) {
            if(isset($data_report[$v['tax'].'_'.$v['rel_type']])){
                $data_report[$v['tax'].'_'.$v['rel_type']]['amount'] += $v['debit'];
            }else{
                $db_builder->where('id', $v['tax']);
                $db_builder = $this->db->table(get_db_prefix().'taxes');
                $_tax = $db_builder->get()->getRow();

                $data_report[$v['tax'].'_'.$v['rel_type']] = [];
                $data_report[$v['tax'].'_'.$v['rel_type']]['name'] = $_tax->title.' ('.app_lang($v['rel_type']).')('.$_tax->percentage.'%)';
                $data_report[$v['tax'].'_'.$v['rel_type']]['amount'] = $v['debit'];
            }

        }
                
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get journal entry next number
     * @return integer
     */
    public function get_journal_entry_next_number()
    {
        $db_builder = $this->db->table(get_db_prefix().'acc_journal_entries');

        $db_builder->select('max(number) as max_number');
        $max = $db_builder->get()->getRow();
        if(is_numeric($max->max_number)){
            return $max->max_number + 1;
        }
        return 1;
    }

    /**
     * add payment mode mapping
     * @param array $data
     * @return boolean
     */
    public function add_payment_mode_mapping($data){
        if(isset($data['id'])){
            unset($data['id']);
        }
        $payment_modes = [];
        if(isset($data['payment_mode'])){
            $payment_modes = $data['payment_mode'];
            unset($data['payment_mode']);
        }
        $data_insert = [];
        $db_builder = $this->db->table(get_db_prefix().'acc_payment_mode_mappings');
        foreach ($payment_modes as $value) {
            $db_builder->where('payment_mode_id', $value);
            $count = $db_builder->countAllResults();

            if($count == 0 && $value != ''){
                $node = [];
                $node['payment_mode_id'] = $value;
                $node['payment_account'] = $data['payment_account'];
                $node['deposit_to'] = $data['deposit_to'];
                $node['expense_payment_account'] = $data['expense_payment_account'];
                $node['expense_deposit_to'] = $data['expense_deposit_to'];
                
                $data_insert[] = $node;
            }

        }

        $affectedRows = $db_builder->insertBatch($data_insert);

        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    /**
     * update payment mode mapping
     * @param array $data
     * @param  integer $id 
     * @return boolean
     */
    public function update_payment_mode_mapping($data, $id){
        $db_builder = $this->db->table(get_db_prefix().'acc_payment_mode_mappings');
        $db_builder->where('id', $id);
        $db_builder->update($data);
       
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * delete payment mode mapping
     * @param integer $id
     * @return boolean
     */

    public function delete_payment_mode_mapping($id)
    {   
        $db_builder = $this->db->table(get_db_prefix() . 'acc_payment_mode_mappings');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * get payment mode are not yet auto
     * @return array
     */
    public function get_payment_mode_not_yet_auto(){
        $db_builder = $this->db->table(get_db_prefix() . 'payment_methods');
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_payment_mode_mappings where ' . get_db_prefix() . 'acc_payment_mode_mappings.payment_mode_id = ' . get_db_prefix() . 'payment_methods.id) = 0)');
        return $db_builder->get()->getResultArray();
    }

    /**
     * Gets the payment mode mappings
     *
     * @param      string  $payment_mode_id  The payment mode id
     *
     * @return     object  The expense category mapping.
     */
    public function get_payment_mode_mapping($payment_mode_id) {

        $db_builder = $this->db->table(get_db_prefix() . 'acc_payment_mode_mappings');
        $db_builder->where('payment_mode_id', $payment_mode_id);
        return $db_builder->get()->getRow();
    }

    /**
     * Change payment mode mapping active
     * @param  mixed $status status(0/1)
     */
    public function change_active_payment_mode_mapping($status)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'settings');
        $db_builder->where('setting_name', 'acc_active_payment_mode_mapping');
        $db_builder->update([
            'setting_value' => $status,
        ]);

        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Change expense category mapping active
     * @param  mixed $status status(0/1)
     */
    public function change_active_expense_category_mapping($status)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'settings');
        $db_builder->where('setting_name', 'acc_active_expense_category_mapping');
        $db_builder->update([
            'setting_value' => $status,
        ]);

        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * get account data tables
     * @param  array $aColumns           table columns
     * @param  mixed $sIndexColumn       main column in table for bettter performing
     * @param  string $sTable            table name
     * @param  array  $join              join other tables
     * @param  array  $where             perform where in query
     * @param  array  $additionalSelect  select additional fields
     * @param  string $sGroupBy group results
     * @return array
     */
    function get_account_data_tables($aColumns, $sIndexColumn, $sTable, $join = [], $where = [], $additionalSelect = [], $sGroupBy = '', $searchAs = [])
    {

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');

        $where = implode(' ', $where);
        $where = trim($where);
        if (startsWith($where, 'AND') || startsWith($where, 'OR')) {
            if (startsWith($where, 'OR')) {
                $where = substr($where, 2);
            } else {
                $where = substr($where, 3);
            }

            $db_builder->where($where);
        }

        $accounting_method = get_setting('acc_accounting_method');

        if($accounting_method == 'cash'){
            $debit = '(SELECT sum(debit) as debit FROM '.get_db_prefix().'acc_account_history where (account = '.get_db_prefix().'acc_accounts.id or parent_account = '.get_db_prefix().'acc_accounts.id) AND (('.get_db_prefix().'acc_account_history.rel_type = "invoice" AND '.get_db_prefix().'acc_account_history.paid = 1) or rel_type != "invoice")) as debit';
            $credit = '(SELECT sum(credit) as credit FROM '.get_db_prefix().'acc_account_history where (account = '.get_db_prefix().'acc_accounts.id or parent_account = '.get_db_prefix().'acc_accounts.id) AND (('.get_db_prefix().'acc_account_history.rel_type = "invoice" AND '.get_db_prefix().'acc_account_history.paid = 1) or rel_type != "invoice")) as credit';
        }else{
            $debit = '(SELECT sum(debit) as debit FROM '.get_db_prefix().'acc_account_history where (account = '.get_db_prefix().'acc_accounts.id or parent_account = '.get_db_prefix().'acc_accounts.id)) as debit';
            $credit = '(SELECT sum(credit) as credit FROM '.get_db_prefix().'acc_account_history where (account = '.get_db_prefix().'acc_accounts.id or parent_account = '.get_db_prefix().'acc_accounts.id)) as credit';
        }


        $db_builder->select('id, number, name, parent_account, account_type_id, account_detail_type_id, balance, key_name, active, number, description, balance_as_of, '.$debit.', '.$credit.', default_account');
        $db_builder->orderBy('id', 'desc');

        $accounts = $db_builder->get()->getResultArray();

        $rResult = [];

        foreach ($accounts as $key => $value) {
            $rResult[] = $value;
            $rResult = $this->get_recursive_account($rResult, $value['id'], $where, 1);
        }

        /* Data set length after filtering */
        $sQuery = '
        SELECT FOUND_ROWS()
        ';
        $_query         = $this->db->query($sQuery)->getResultArray();
        $iFilteredTotal = $_query[0]['FOUND_ROWS()'];
        
        /* Total data set length */
        $sQuery = '
        SELECT COUNT(' . $sTable . '.' . $sIndexColumn . ")
        FROM $sTable " . ($where != '' ? 'WHERE '.$where : $where). ' AND (parent_account IS NULL OR parent_account = 0)';
       
        /*
         * Output
         */
        $output = [
            'draw'                 => 0,
            'iTotalRecords'        => 0,
            'iTotalDisplayRecords' => 0,
            'data'               => [],
            ];

        return [
            'rResult' => $rResult,
            'output'  => $output,
            ];
    }

    /**
     * get recursive account
     * @param  array $accounts  
     * @param  integer $account_id
     * @param  string $where     
     * @param  integer $number    
     * @return array            
     */
    public function get_recursive_account($accounts, $account_id, $where, $number){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->select('id, number, name, parent_account, account_type_id, account_detail_type_id, balance, key_name, active, number, description, balance_as_of, (SELECT sum(debit) as debit FROM '.get_db_prefix().'acc_account_history where (account = '.get_db_prefix().'acc_accounts.id or parent_account = '.get_db_prefix().'acc_accounts.id)) as debit, (SELECT sum(credit) as credit FROM '.get_db_prefix().'acc_account_history where (account = '.get_db_prefix().'acc_accounts.id or parent_account = '.get_db_prefix().'acc_accounts.id)) as credit, default_account');
        if($where != ''){
            $db_builder->where($where);
        }

        $db_builder->where('parent_account', $account_id);
        $db_builder->orderBy('number,name', 'asc');
        $account_list = $db_builder->get()->getResultArray();

        if($account_list){
            foreach ($account_list as $key => $value) {
                foreach ($accounts as $k => $val) {
                    if($value['id'] == $val['id']){
                        unset($accounts[$k]);
                    }
                }

                $value['level'] = $number;
                array_push($accounts, $value);
                $accounts = $this->get_recursive_account($accounts, $value['id'], $where, $number + 1);
            }
        }

        return $accounts;
    }

    /**
     * get data balance sheet comparison recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $last_from_date  
     * @param  string $last_to_date    
     * @param  string $accounting_method    
     * @return array                 
     */
    public function get_data_balance_sheet_comparison_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;

            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date_format(datecreated, \'%Y-%m-%d\') >= "' . $last_from_date . '" and date_format(datecreated, \'%Y-%m-%d\') <= "' . $last_to_date . '")');
            $py_account_history = $db_builder->get()->getRow();

            $py_credits = $py_account_history->credit != '' ? $py_account_history->credit : 0;
            $py_debits = $py_account_history->debit != '' ? $py_account_history->debit : 0;

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                $child_account[] = ['name' => $name, 'amount' => ($credits - $debits), 'py_amount' => ($py_credits - $py_debits), 'child_account' => $this->get_data_balance_sheet_comparison_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers)];
            }else{
                $child_account[] = ['name' => $name, 'amount' => ($debits - $credits), 'py_amount' => ($py_debits - $py_credits), 'child_account' => $this->get_data_balance_sheet_comparison_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers)];
            }
        }

        return $child_account; 
    }

    /**
     * get html balance sheet comparision
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_balance_sheet_comparision($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $total_py_amount = 0;
        $data_return['total_amount'] = 0;
        $data_return['total_py_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $total_py_amount = $val['py_amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['py_amount'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $t_py = $data_return['total_py_amount'];
                $data_return = $this->get_html_balance_sheet_comparision($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                $total_py_amount += $data_return['total_py_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_py_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
                $data_return['total_py_amount'] += $t_py;
            }

            $data_return['total_amount'] += $val['amount'];
            $data_return['total_py_amount'] += $val['py_amount'];
        }
        return $data_return; 
    }

    /**
     * get data balance sheet detail recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $accounting_method         
     * @return array                 
     */
    public function get_data_balance_sheet_detail_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->orderBy('date', 'asc');
            $account_history = $db_builder->get()->getResultArray();
            $node = [];
            $balance = 0;
            $amount = 0;
            foreach ($account_history as $v) {
                if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 10 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 7 || $account_type_id == 6){
                    $am = $v['credit'] - $v['debit'];
                }else{
                    $am = $v['debit'] - $v['credit'];
                }

                $node[] =   [
                                'date' => date('Y-m-d', strtotime($v['date'])),
                                'type' => app_lang($v['rel_type']),
                                'description' => $v['description'],
                                'debit' => $v['debit'],
                                'credit' => $v['credit'],
                                'amount' => $am,
                                'balance' => $balance + $am,
                            ];

                $amount += $am;
                $balance += $am;
            }

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            $child_account[] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' => $this->get_data_balance_sheet_detail_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
        }

        return $child_account; 
    }

    /**
     * get html balance sheet detail
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_balance_sheet_detail($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $value) {
            $amount = 0;
            $data_return['row_index']++;
            $_parent_index = $data_return['row_index'];
            if(count($value['details']) > 0 || count($value['child_account']) > 0){
                $data_return['html'] .= '<tr class="treegrid-'.$_parent_index.' treegrid-parent-'.$parent_index.' parent-node expanded">
                    <td class="parent">'.$value['name'].'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>';
            }

            foreach ($value['details'] as $val) { 
            $data_return['row_index']++;
                $amount += $val['amount'];
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' treegrid-parent-'.$_parent_index.'">
                  <td>
                  '. format_to_date($val['date']).'
                  </td>
                  <td>
                  '. html_entity_decode($val['type']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['description']).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['debit'], $currency).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['credit'], $currency).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['amount'], $currency).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['balance'], $currency).' 
                  </td>
                </tr>';
               }
            $total_amount = $amount;
            $data_return['row_index']++;
           
            if(count($value['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_balance_sheet_detail($value['child_account'], $data_return, $_parent_index, $currency);
                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '
                  <tr class="treegrid-'.$data_return['row_index'].' treegrid-parent-'.$parent_index.' tr_total">
                      <td>
                      '.app_lang('total_for', $value['name']).'
                      </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                    <td></td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $amount;
        }
        return $data_return; 
    }

    /**
     * get data balance sheet summary recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $accounting_method         
     * @return array                 
     */
    public function get_data_balance_sheet_summary_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('account', $val['id']);
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $node = [];
            $balance = 0;
            $amount = 0;

            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                $child_account[] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $this->get_data_balance_sheet_summary_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];

            }else{
                $child_account[] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $this->get_data_balance_sheet_summary_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
            }
        }

        return $child_account;
    }

    /**
     * get html balance sheet summary
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_balance_sheet_summary($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_balance_sheet_summary($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $val['amount'];
        }
        return $data_return; 
    }

    /**
     * get data balance sheet summary recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $accounting_method         
     * @return array                 
     */
    public function get_data_balance_sheet_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('account', $val['id']);
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $node = [];
            $balance = 0;
            $amount = 0;

            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                $child_account[] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $this->get_data_balance_sheet_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];

            }else{
                $child_account[] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $this->get_data_balance_sheet_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
            }

        }

        return $child_account;
    }

    /**
     * get html balance sheet
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_balance_sheet($child_account, $data_return, $parent_index, $currency_symbol){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency_symbol).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_balance_sheet($val['child_account'], $data_return, $data_return['row_index'], $currency_symbol);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency_symbol).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $val['amount'];
        }
        return $data_return; 
    }

    /**
     * get data custom summary recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $accounting_method 
     * @return array                 
     */
    public function get_data_custom_summary_recursive($data){
        $child_account = $data['child_account'];
        $account_id = $data['account_id'];
        $account_type_id = $data['account_type_id'];
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $accounting_method = $data['accounting_method'];
        $acc_show_account_numbers = $data['acc_show_account_numbers'];
        $display_rows_by = $data['display_rows_by'];
        $display_columns_by = $data['display_columns_by'];

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
       
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            if($account_type_id == 11 || $account_type_id == 12){
                $child_account[] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $this->get_data_custom_summary_recursive([
                            'child_account' => [],
                            'account_id' => $val['id'],
                            'account_type_id' => $account_type_id,
                            'from_date' => $from_date,
                            'to_date' => $to_date,
                            'accounting_method' => $accounting_method,
                            'acc_show_account_numbers' => $acc_show_account_numbers,
                            'display_rows_by' => $display_rows_by,
                            'display_columns_by' => $display_columns_by,
                        ])];
            }else{
                $child_account[] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $this->get_data_custom_summary_recursive([
                            'child_account' => [],
                            'account_id' => $val['id'],
                            'account_type_id' => $account_type_id,
                            'from_date' => $from_date,
                            'to_date' => $to_date,
                            'accounting_method' => $accounting_method,
                            'acc_show_account_numbers' => $acc_show_account_numbers,
                            'display_rows_by' => $display_rows_by,
                            'display_columns_by' => $display_columns_by,
                        ])];
            }
        }

        return $child_account;
    }

    /**
     * get html custom summary
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_custom_summary($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency->name).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_custom_summary($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency->name).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $val['amount'];
        }
        return $data_return; 
    }

    /**
     * get data profit and loss as of total income recursive
     * @param  array $child_account         
     * @param  integer $income      
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @return array                 
     */
    public function get_data_profit_and_loss_as_of_total_income_recursive($child_account, $income, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }


            if($account_type_id == 11 || $account_type_id == 12){
                $r_am = $credits - $debits;
            }else{
                $r_am = $debits - $credits;
            }

            if($income != 0){
                $child_account[] = ['name' => $name, 'amount' => $r_am, 'percent' => round((($r_am) / $income) * 100, 2), 'child_account' => $this->get_data_profit_and_loss_as_of_total_income_recursive([], $income, $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
            }else{
                $child_account[] = ['name' => $name, 'amount' => $r_am, 'percent' => 0, 'child_account' => $this->get_data_profit_and_loss_as_of_total_income_recursive([], $income, $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
            }
        }

        return $child_account;
    }

    /**
     * get html profit and loss as of total income
     * @param  array $child_account 
     * @param  integer $income 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss_as_of_total_income($child_account, $income, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        $data_return['percent'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
              <td class="total_amount">
              '. html_entity_decode($val['percent']).'% 
              </td>
            </tr>';
            

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $p = $data_return['percent'];
                $data_return = $this->get_html_profit_and_loss_as_of_total_income($val['child_account'], $income, $data_return, $data_return['row_index'], $currency);
                $total_amount += $data_return['total_amount'];

                if($income != 0){
                    $percent = round((($total_amount) / $income) * 100, 2);
                }else{
                    $percent = 0;
                }

                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '. html_entity_decode($percent).'% 
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
                $data_return['percent'] += $p;
            }

            $data_return['total_amount'] += $val['amount'];
            $data_return['percent'] += $val['percent'];
        }
        return $data_return; 
    }

    /**
     * get data profit and loss comparison recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date 
     * @param  string $last_from_date       
     * @param  string $last_to_date         
     * @param  string $accounting_method         
     * @return array                 
     */
    public function get_data_profit_and_loss_comparison_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
       
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;

            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date_format(datecreated, \'%Y-%m-%d\') >= "' . $last_from_date . '" and date_format(datecreated, \'%Y-%m-%d\') <= "' . $last_to_date . '")');
            $py_account_history = $db_builder->get()->getRow();
            $py_credits = $py_account_history->credit != '' ? $py_account_history->credit : 0;
            $py_debits = $py_account_history->debit != '' ? $py_account_history->debit : 0;

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            if($account_type_id == 11 || $account_type_id == 12){
                $child_account[] = ['name' => $name, 'this_year' => $credits - $debits, 'last_year' => $py_credits - $py_debits, 'child_account' => $this->get_data_profit_and_loss_comparison_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers)];
            }else{
                $child_account[] = ['name' => $name, 'this_year' => $debits - $credits, 'last_year' => $py_debits - $py_credits, 'child_account' => $this->get_data_profit_and_loss_comparison_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers)];
            }
        }

        return $child_account;
    }

    /**
     * get html profit and loss comparison
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss_comparison($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $total_py_amount = 0;
        $data_return['total_amount'] = 0;
        $data_return['total_py_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['this_year'];
            $total_py_amount = $val['last_year'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['this_year'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['last_year'], $currency).'
              </td>
            </tr>';
            

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $p = $data_return['total_py_amount'];
                $data_return = $this->get_html_profit_and_loss_comparison($val['child_account'], $data_return, $data_return['row_index'], $currency);
                $total_amount += $data_return['total_amount'];
                $total_py_amount += $data_return['total_py_amount'];

                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_py_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
                $data_return['total_py_amount'] += $p;
            }

            $data_return['total_amount'] += $val['this_year'];
            $data_return['total_py_amount'] += $val['last_year'];
        }
        return $data_return; 
    }

    /**
     * get data profit and loss detail recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $accounting_method         
     * @return array                 
     */
    public function get_data_profit_and_loss_detail_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->orderBy('date', 'asc');
            $account_history = $db_builder->get()->getResultArray();
            $node = [];
            $balance = 0;
            $amount = 0;
            foreach ($account_history as $v) {
                if($account_type_id == 11 || $account_type_id == 12){
                    $am = $v['credit'] - $v['debit'];
                }else{
                    $am = $v['debit'] - $v['credit'];
                }
                $node[] =   [
                                'date' => date('Y-m-d', strtotime($v['date'])),
                                'type' => app_lang($v['rel_type']),
                                'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                                'description' => $v['description'],
                                'customer' => $v['customer'],
                                'amount' => $am,
                                'balance' => $balance + $am,
                            ];
                $amount += $am;
                $balance += $am;
            }

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            
            $child_account[] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' =>  $this->get_data_profit_and_loss_detail_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
        }

        return $child_account;
    }
    
    /**
     * get html profit and loss detail
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss_detail($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $value) {
            $amount = 0;
            $data_return['row_index']++;
            $_parent_index = $data_return['row_index'];
            if(count($value['details']) > 0 || count($value['child_account']) > 0){
                $data_return['html'] .= '<tr class="treegrid-'.$_parent_index.' treegrid-parent-'.$parent_index.' parent-node expanded">
                    <td class="parent">'.$value['name'].'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
            }

            foreach ($value['details'] as $val) { 
            $data_return['row_index']++;
                $amount += $val['amount'];
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' treegrid-parent-'.$_parent_index.'">
                  <td>
                  '. format_to_date($val['date']).'
                  </td>
                  <td>
                  '. html_entity_decode($val['type']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['description']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['split']).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['amount'], $currency).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['balance'], $currency).' 
                  </td>
                </tr>';
               }
            $total_amount = $amount;
            $data_return['row_index']++;
           
            if(count($value['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_profit_and_loss_detail($value['child_account'], $data_return, $_parent_index, $currency);
                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '
                  <tr class="treegrid-'.$data_return['row_index'].' treegrid-parent-'.$parent_index.' tr_total">
                      <td>
                      '.app_lang('total_for', $value['name']).'
                      </td>
                    <td></td>
                    <td></td>
                    <td></td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                    <td></td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $amount;
        }
        return $data_return; 
    }

    /**
     * get data profit and loss year to date comparison recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $last_from_date       
     * @param  string $last_to_date         
     * @param  string $accounting_method         
     * @return array                 
     */
    public function get_data_profit_and_loss_year_to_date_comparison_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;

            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date_format(datecreated, \'%Y-%m-%d\') >= "' . $last_from_date . '" and date_format(datecreated, \'%Y-%m-%d\') <= "' . $last_to_date . '")');
            $py_account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
            $py_credits = $py_account_history->credit != '' ? $py_account_history->credit : 0;
            $py_debits = $py_account_history->debit != '' ? $py_account_history->debit : 0;

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            if($account_type_id == 11 || $account_type_id == 12){
                $child_account[] = ['name' => $name, 'this_year' => $credits - $debits, 'last_year' => $py_credits - $py_debits, 'child_account' => $this->get_data_profit_and_loss_year_to_date_comparison_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers)];
            }else{
                $child_account[] = ['name' => $name, 'this_year' => $debits - $credits, 'last_year' => $py_debits - $py_credits, 'child_account' => $this->get_data_profit_and_loss_year_to_date_comparison_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $last_from_date, $last_to_date, $accounting_method, $acc_show_account_numbers)];
            }
        }

        return $child_account;
    }

    /**
     * get html profit and loss year to date comparison
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss_year_to_date_comparison($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $total_py_amount = 0;
        $data_return['total_amount'] = 0;
        $data_return['total_py_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['this_year'];
            $total_py_amount = $val['last_year'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['this_year'], $currency->name).'
              </td>
              <td class="total_amount">
              '.to_currency($val['last_year'], $currency->name).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $p = $data_return['total_py_amount'];
                $data_return = $this->get_html_profit_and_loss_year_to_date_comparison($val['child_account'], $data_return, $data_return['row_index'], $currency);
                $total_amount += $data_return['total_amount'];
                $total_py_amount += $data_return['total_py_amount'];

                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency->name).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_py_amount, $currency->name).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
                $data_return['total_py_amount'] += $p;
            }

            $data_return['total_amount'] += $val['this_year'];
            $data_return['total_py_amount'] += $val['last_year'];
        }
        return $data_return; 
    }

    /**
     * get data profit and loss recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $accounting_method   
     * @return array                 
     */
    public function get_data_profit_and_loss_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();
           
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            if($account_type_id == 11 || $account_type_id == 12){
                $child_account[] = ['name' => $name, 'amount' => $credits - $debits, 'child_account' => $this->get_data_profit_and_loss_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
            }else{
                $child_account[] = ['name' => $name, 'amount' => $debits - $credits, 'child_account' => $this->get_data_profit_and_loss_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
            }
        }

        return $child_account;
    }

    /**
     * get html profit and loss
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_custom_summary($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $val['amount'];
        }
        return $data_return; 
    }

    /**
     * get data statement of cash flows recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  integer $account_detail_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @return array                 
     */
    public function get_data_statement_of_cash_flows_recursive($child_account, $account_id, $account_type_id, $account_detail_type_id, $from_date, $to_date, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            if($val['id'] == 13){
                $db_builder->where('(rel_type != "invoice" and rel_type != "expense" and rel_type != "payment")');
            }
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->where('account', $val['id']);
            
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 10 || $account_type_id == 8 || $account_type_id == 7 || $account_type_id == 4 || $account_type_id == 5 || $account_type_id == 6 || $account_type_id == 2 || $account_type_id == 9 || $account_type_id == 1){
                $child_account[] = ['account_detail_type_id' => $account_detail_type_id, 'name' => $name, 'amount' => $credits - $debits, 'child_account' => $this->get_data_statement_of_cash_flows_recursive([], $val['id'], $account_type_id, $account_detail_type_id, $from_date, $to_date, $acc_show_account_numbers)];
            }else{
                $child_account[] = ['account_detail_type_id' => $account_detail_type_id, 'name' => $name, 'amount' => $debits - $credits, 'child_account' => $this->get_data_statement_of_cash_flows_recursive([], $val['id'], $account_type_id, $account_detail_type_id, $from_date, $to_date, $acc_show_account_numbers)];
            }
        }

        return $child_account;
    }

    /**
     * get html statement of cash flows
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_statement_of_cash_flows($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_statement_of_cash_flows($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $val['amount'];
        }
        return $data_return; 
    }

    /**
     * get data statement of changes in equity recursive recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  integer $account_detail_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $accounting_method   
     * @return array                 
     */
    public function get_data_statement_of_changes_in_equity_recursive($child_account, $account_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            
            $child_account[] = ['account_detail_type_id' => $value['id'], 'name' => $name, 'amount' => $credits - $debits, 'child_account' => $this->get_data_statement_of_changes_in_equity_recursive([], $val['id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
        }

        return $child_account;
    }

    /**
     * get html statement of changes in equity
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_statement_of_changes_in_equity($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_statement_of_changes_in_equity($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $val['amount'];
        }
        return $data_return; 
    }

    /**
     * get data account list recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  array $account_type_name 
     * @param  array $detail_type_name 
     * @return array                 
     */
    public function get_data_account_list_recursive($child_account, $account_id, $account_type_id, $account_type_name, $detail_type_name, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            $_account_type_name = isset($account_type_name[$val['account_type_id']]) ? $account_type_name[$val['account_type_id']] : '';
            $_detail_type_name = isset($detail_type_name[$val['account_detail_type_id']]) ? $detail_type_name[$val['account_detail_type_id']] : '';

            $child_account[] = ['description' => $val['description'], 'type' => $_account_type_name, 'detail_type' => $_detail_type_name, 'name' => $name, 'amount' => $debits - $credits, 'child_account' => $this->get_data_account_list_recursive([], $val['id'], $account_type_id, $account_type_name, $detail_type_name, $acc_show_account_numbers)];
        }

        return $child_account;
    }

    /**
     * get html account list
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_account_list($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $total_amount = $val['amount'];
            
            $name = '';

            $name .= $val['name'];

            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$name.'
              </td>
              <td>
              '.$val['type'].'
              </td>
              <td>
              '.$val['detail_type'].'
              </td>
              <td>
              '.$val['description'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_account_list($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                $data_return['row_index']++;
                
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $val['amount'];
        }
        return $data_return; 
    }


    /**
     * get data general ledger recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $accounting_method   
     * @return array                 
     */
    public function get_data_general_ledger_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->orderBy('date', 'asc');
            $account_history = $db_builder->get()->getResultArray();
            $node = [];
            $balance = 0;
            $amount = 0;
            foreach ($account_history as $v) {
                if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 10 || $account_type_id == 9 || $account_type_id == 8 || $account_type_id == 7 || $account_type_id == 6){
                    $am = $v['credit'] - $v['debit'];
                }else{
                    $am = $v['debit'] - $v['credit'];
                }

                $node[] =   [
                                'date' => date('Y-m-d', strtotime($v['date'])),
                                'type' => app_lang($v['rel_type']),
                                'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                                'description' => $v['description'],
                                'customer' => $v['customer'],
                                'debit' => $v['debit'],
                                'credit' => $v['credit'],
                                'amount' => $am,
                                'balance' => $balance + $am,
                            ];

                $amount += $am;
                $balance += $am;
            }

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            $child_account[] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' => $this->get_data_general_ledger_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
        }

        return $child_account;
    }

    /**
     * get html general ledger
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_general_ledger($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $value) {
            $amount = 0;
            $data_return['row_index']++;
            $_parent_index = $data_return['row_index'];
            if(count($value['details']) > 0 || count($value['child_account']) > 0){
                $data_return['html'] .= '<tr class="treegrid-'.$_parent_index.' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' parent-node expanded">
                    <td class="parent">'.$value['name'].'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
            }
            
            foreach ($value['details'] as $val) { 
            $data_return['row_index']++;
                $amount += $val['amount'];
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' treegrid-parent-'.$_parent_index.'">
                  <td>
                  '. format_to_date($val['date']).'
                  </td>
                  <td>
                  '. html_entity_decode($val['type']).' 
                  </td>
                  <td>
                  '. get_company_name($val['customer']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['description']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['split']).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['amount'], $currency).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['balance'], $currency).' 
                  </td>
                </tr>';
               }
            $total_amount = $amount;
            $data_return['row_index']++;
            $t = 0;
            if(count($value['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_general_ledger($value['child_account'], $data_return, $_parent_index, $currency);
                $total_amount += $data_return['total_amount'];
            }

            if(count($value['details']) > 0 || count($value['child_account']) > 0){
                $data_return['row_index']++;
                $data_return['html'] .= '
                  <tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                      <td>'.app_lang('total_for', $value['name']).'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                    <td></td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $amount;
        }
        return $data_return; 
    }
    
    /**
     * get data trial balance recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $accounting_method   
     * @return array                 
     */
    public function get_data_trial_balance_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($credits > $debits){
                $credits = $credits - $debits;
                $debits = 0;
            }else{
                $debits = $debits - $credits;
                $credits = 0;
            }
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            $child_account[] = ['name' => $name, 'debit' => $debits, 'credit' => $credits, 'child_account' => $this->get_data_trial_balance_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
        }

        return $child_account;
    }
    
    /**
     * get html trial balance
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_trial_balance($child_account, $data_return, $parent_index, $currency){
        $total_debit = 0;
        $total_credit = 0;
        $data_return['total_debit'] = 0;
        $data_return['total_credit'] = 0;
        foreach ($child_account as $val) {
            $data_return['row_index']++;
            $total_debit = $val['debit'];
            $total_credit = $val['credit'];
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['debit'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['credit'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $d = $data_return['total_debit'];
                $c = $data_return['total_credit'];
                $data_return = $this->get_html_trial_balance($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_debit += $data_return['total_debit'];
                $total_credit += $data_return['total_credit'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_debit, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_credit, $currency).'
                  </td>
                </tr>';
                $data_return['total_debit'] += $d;
                $data_return['total_credit'] += $c;
            }

            $data_return['total_debit'] += $val['debit'];
            $data_return['total_credit'] += $val['credit'];
        }
        return $data_return; 
    }

    /**
     * get data transaction detail by account recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $accounting_method   
     * @return array                 
     */
    public function get_data_transaction_detail_by_account_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->orderBy('date', 'asc');
            $account_history = $db_builder->get()->getResultArray();
            $node = [];
            $balance = 0;
            $amount = 0;
            foreach ($account_history as $v) {
                if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 10 || $account_type_id == 9 || $account_type_id == 8 || $account_type_id == 7 || $account_type_id == 6){
                    $am = $v['credit'] - $v['debit'];
                }else{
                    $am = $v['debit'] - $v['credit'];
                }
                $node[] =   [
                                'date' => date('Y-m-d', strtotime($v['date'])),
                                'type' => app_lang($v['rel_type']),
                                'description' => $v['description'],
                                'customer' => $v['customer'],
                                'split' => $v['split'] != 0 ? (isset($account_name[$v['split']]) ? $account_name[$v['split']] : '') : '-Split-',
                                'debit' => $v['debit'],
                                'credit' => $v['credit'],
                                'amount' => $am,
                                'balance' => $balance + ($am),
                            ];
                $amount += $am;
                $balance += $am;
            }

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            $child_account[] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'balance' => $balance, 'details' => $node, 'child_account' => $this->get_data_transaction_detail_by_account_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
        }

        return $child_account;
    }
    
    /**
     * get html transaction detail by account
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_transaction_detail_by_account($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $value) {
            $amount = 0;
            $data_return['row_index']++;
            $_parent_index = $data_return['row_index'];
            if(count($value['details']) > 0 || count($value['child_account']) > 0){
                $data_return['html'] .= '<tr class="treegrid-'.$_parent_index.' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' parent-node expanded">
                    <td class="parent">'.$value['name'].'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
            }
            
            foreach ($value['details'] as $val) { 
            $data_return['row_index']++;
                $amount += $val['amount'];
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' treegrid-parent-'.$_parent_index.'">
                  <td>
                  '. format_to_date($val['date']).'
                  </td>
                  <td>
                  '. html_entity_decode($val['type']).' 
                  </td>
                  <td>
                  '. get_company_name($val['customer']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['description']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['split']).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['amount'], $currency).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['balance'], $currency).' 
                  </td>
                </tr>';
               }
            $total_amount = $amount;
            $data_return['row_index']++;
           
            if(count($value['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_transaction_detail_by_account($value['child_account'], $data_return, $_parent_index, $currency);
                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '
                  <tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                      <td>
                      '.app_lang('total_for', $value['name']).'
                      </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                    <td></td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $amount;
        }
        return $data_return; 
    }

    /**
     * get data deposit detail recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @return array                 
     */
    public function get_data_deposit_detail_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $db_builder->where('account', $val['id']);
            $db_builder->where('((rel_type = "payment" and debit > 0) or (rel_type = "deposit"  and credit > 0))');
            $db_builder->orderBy('date', 'asc');
            $account_history = $db_builder->get()->getResultArray();
            $node = [];
            $balance = 0;
            $amount = 0;
            foreach ($account_history as $v) {
                if($account_type_id == 10 || $account_type_id == 9 || $account_type_id == 8 || $account_type_id == 7){
                    $amount += $v['credit'] - $v['debit'];
                    $am = ($v['credit'] - $v['debit']);
                }else{
                    $amount += $v['debit'] - $v['credit'];
                    $am = ($v['debit'] - $v['credit']);
                }

                $node[] =   [
                                'date' => date('Y-m-d', strtotime($v['date'])),
                                'type' => app_lang($v['rel_type']),
                                'description' => $v['description'],
                                'customer' => $v['customer'],
                                'debit' => $v['debit'],
                                'credit' => $v['credit'],
                                'amount' =>  $am,
                            ];
            }

            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            $child_account[] = ['account' => $val['id'], 'name' => $name, 'amount' => $amount, 'details' => $node, 'child_account' => $this->get_data_deposit_detail_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $acc_show_account_numbers)];
            
        }

        return $child_account;
    }

    /**
     * get html transaction detail by account
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_deposit_detail($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $value) {
            $amount = 0;
            $data_return['row_index']++;
            $_parent_index = $data_return['row_index'];
            if(count($value['details']) > 0 || count($value['child_account']) > 0){
                $data_return['html'] .= '<tr class="treegrid-'.$_parent_index.' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' parent-node expanded">
                    <td class="parent">'.$value['name'].'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
            }
            
            foreach ($value['details'] as $val) { 
            $data_return['row_index']++;
                $amount += $val['amount'];
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' treegrid-parent-'.$_parent_index.'">
                  <td>
                  '. format_to_date($val['date']).'
                  </td>
                  <td>
                  '. html_entity_decode($val['type']).' 
                  </td>
                  <td>
                  '. get_company_name($val['customer']).' 
                  </td>
                  <td>
                  '. html_entity_decode($val['description']).' 
                  </td>
                  <td class="total_amount">
                  '. to_currency($val['amount'], $currency).' 
                  </td>
                </tr>';
               }
            $total_amount = $amount;
            $data_return['row_index']++;
           
            if(count($value['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_deposit_detail($value['child_account'], $data_return, $_parent_index, $currency);
                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '
                  <tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                      <td>
                      '.app_lang('total_for', $value['name']).'
                      </td>
                    <td></td>
                    <td></td>
                    <td></td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $amount;
        }
        return $data_return; 
    }
    

    /**
     * add new account type detail
     * @param array $data
     * @return integer
     */
    public function add_account_type_detail($data)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_type_details');
        $db_builder->insert($data);

        $insert_id = $this->db->insertID();

        if ($insert_id) {
            return true;
        }

        return false;
    }

    /**
     * update account type detail
     * @param array $data
     * @param integer $id
     * @return integer
     */
    public function update_account_type_detail($data, $id)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }
        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_type_details');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }

        return false;
    }

    /**
     * delete account type detail
     * @param integer $id
     * @return boolean
     */

    public function delete_account_type_detail($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
        $db_builder->where('account_detail_type_id',$id);
        $count = $db_builder->countAllResults();

        if($count > 0){
            return 'have_account';
        }

        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_type_details');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    /**
     * get account type details
     * @param  integer $id    member group id
     * @param  array  $where
     * @return object
     */
    public function get_data_account_type_details($id = '', $where = [])
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_account_type_details');
        if (is_numeric($id)) {
            $db_builder->where('id', $id);
            return $db_builder->get()->getRow();
        }

        $db_builder->where($where);
        $db_builder->orderBy('account_type_id', 'desc');
        $account_type_details = $db_builder->get()->getResultArray();

        $account_types = $this->get_account_types();

        $account_type_name = [];

        foreach ($account_types as $key => $value) {
            $account_type_name[$value['id']] = $value['name'];
        }

        foreach ($account_type_details as $key => $value) {
            $_account_type_name = isset($account_type_name[$value['account_type_id']]) ? $account_type_name[$value['account_type_id']] : '';
            $account_type_details[$key]['account_type_name'] = $_account_type_name;
        }

        return $account_type_details;
    }

    /**
     * Change preferred payment method status / on / off
     * @param  mixed $id     staff id
     * @param  mixed $status status(0/1)
     */
    public function change_preferred_payment_method($id, $status)
    {
        $db_builder->where('id', $id);
        $db_builder->update(get_db_prefix() . 'acc_expense_category_mappings', [
            'preferred_payment_method' => $status,
        ]);
    }

    /**
     * count stock import not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object          
     */
    public function count_stock_import_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';
        if($currency != ''){
            $where_currency = 'and currency = '.$currency;
        }

        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'goods_receipt.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "stock_import") = 0) '.$where_currency);
        return $this->db->countAllResults(get_db_prefix().'goods_receipt');
    }

    /**
     * count stock export not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object          
     */
    public function count_stock_export_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';
        if($currency != ''){
            $where_currency = 'and currency = '.$currency;
        }

        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'goods_delivery.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "stock_export") = 0) '.$where_currency);
        return $this->db->countAllResults(get_db_prefix().'goods_delivery');
    }

    /**
     * count loss adjustment not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object          
     */
    public function count_loss_adjustment_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';
        if($currency != ''){
            $where_currency = 'and currency = '.$currency;
        }

        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'wh_loss_adjustment.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "loss_adjustment") = 0) '.$where_currency);
        return $this->db->countAllResults(get_db_prefix().'wh_loss_adjustment');
    }

    /**
     * count opening stock not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object          
     */
    public function count_opening_stock_not_convert_yet($currency = '', $where = ''){
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));

        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'items.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "opening_stock" and date = "'.$date_financial_year.'") = 0)');
        return $this->db->countAllResults(get_db_prefix().'items');
    }

    /**
     * update payslip automatic conversion
     *
     * @param      array   $data   The data
     *
     * @return     boolean 
     */
    public function update_payslip_automatic_conversion($data){
        $affectedRows = 0;
        
        if(!isset($data['acc_pl_total_insurance_automatic_conversion'])){
            $data['acc_pl_total_insurance_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_pl_tax_paye_automatic_conversion'])){
            $data['acc_pl_tax_paye_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_pl_net_pay_automatic_conversion'])){
            $data['acc_pl_net_pay_automatic_conversion'] = 0;
        }

        foreach ($data as $key => $value) {
            $db_builder->where('name', $key);
            $db_builder->update(get_db_prefix() . 'options', [
                    'value' => $value,
                ]);
            if ($this->db->affectedRows() > 0) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * get opening stock data tables
     * @param  array $aColumns           table columns
     * @param  mixed $sIndexColumn       main column in table for bettter performing
     * @param  string $sTable            table name
     * @param  array  $join              join other tables
     * @param  array  $where             perform where in query
     * @param  array  $additionalSelect  select additional fields
     * @param  string $sGroupBy group results
     * @return array
     */
    function get_opening_stock_data_tables($aColumns, $sIndexColumn, $sTable, $join = [], $where = [], $additionalSelect = [], $sGroupBy = '', $searchAs = [])
    {
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));

        $CI          = & get_instance();
        $__post      = $CI->input->post();
        $where = implode(' ', $where);
        $where = trim($where);
        if (startsWith($where, 'AND') || startsWith($where, 'OR')) {
            if (startsWith($where, 'OR')) {
                $where = substr($where, 2);
            } else {
                $where = substr($where, 3);
            }

            $db_builder->where($where);
        }
        
        $db_builder->select('*, (select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'items.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "opening_stock" and ' . get_db_prefix() . 'acc_account_history.date = "'.$date_financial_year.'") as count_account_historys');
        $this->db->limit(intval($CI->input->post('length')), intval($CI->input->post('start')));
        $db_builder->orderBy('id', 'desc');

        $items = $db_builder->get(get_db_prefix().'items')->getResultArray();

        $rResult = [];

        foreach ($items as $key => $value) {
            $value['opening_stock'] = $this->calculate_opening_stock($value['id'], $date_financial_year);
            $rResult[] = $value;
        }

        /* Data set length after filtering */
        $sQuery = '
        SELECT FOUND_ROWS()
        ';
        $_query         = $CI->db->query($sQuery)->getResultArray();
        $iFilteredTotal = $_query[0]['FOUND_ROWS()'];
        
        /* Total data set length */
        $sQuery = '
        SELECT COUNT(' . $sTable . '.' . $sIndexColumn . ")
        FROM $sTable " . ($where != '' ? 'WHERE '.$where : $where);
        $_query = $CI->db->query($sQuery)->getResultArray();

        $iTotal = $_query[0]['COUNT(' . $sTable . '.' . $sIndexColumn . ')'];
        /*
         * Output
         */
        $output = [
            'draw'                 => $__post['draw'] ? intval($__post['draw']) : 0,
            'iTotalRecords'        => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData'               => [],
            ];

        return [
            'rResult' => $rResult,
            'output'  => $output,
            ];
    }

    /**
     * calculate opening stock
     * @param  integer $item_id             
     * @param  date $date_financial_year 
     * @return float                     
     */
    public function calculate_opening_stock($item_id, $date_financial_year){
        

        $db_builder->where('(' . get_db_prefix() . 'goods_receipt.date_c >= "' . $date_financial_year.'" and ' . get_db_prefix() . 'goods_receipt_detail.commodity_code = ' . $item_id.')');
        $this->db->join(get_db_prefix() . 'goods_receipt', get_db_prefix() . 'goods_receipt.id=' . get_db_prefix() . 'goods_receipt_detail.goods_receipt_id', 'left');
        $goods_receipt_detail = $db_builder->get(get_db_prefix().'goods_receipt_detail')->getResultArray();

        $db_builder->where('(' . get_db_prefix() . 'goods_delivery.date_c >= "' . $date_financial_year.'" and ' . get_db_prefix() . 'goods_delivery_detail.commodity_code = ' . $item_id.')');
        $this->db->join(get_db_prefix() . 'goods_delivery', get_db_prefix() . 'goods_delivery.id=' . get_db_prefix() . 'goods_delivery_detail.goods_delivery_id', 'left');
        $goods_delivery_detail = $db_builder->get(get_db_prefix().'goods_delivery_detail')->getResultArray();

        $db_builder->where('(date_format(' . get_db_prefix() . 'wh_loss_adjustment.time, \'%Y-%m-%d\') >= "' . $date_financial_year.'" and ' . get_db_prefix() . 'wh_loss_adjustment_detail.items = ' . $item_id.')');
        $this->db->join(get_db_prefix() . 'wh_loss_adjustment', get_db_prefix() . 'wh_loss_adjustment.id=' . get_db_prefix() . 'wh_loss_adjustment_detail.loss_adjustment', 'left');
        $wh_loss_adjustment_detail = $db_builder->get(get_db_prefix().'wh_loss_adjustment_detail')->getResultArray();

        $db_builder->where('commodity_id', $item_id);
        $inventory_manage = $db_builder->get(get_db_prefix().'inventory_manage')->getResultArray();

        $amount = 0;

        foreach($goods_receipt_detail as $value){
            $amount -= ($value['quantities'] * $value['unit_price']);
        }

        foreach($goods_delivery_detail as $value){
            if($value['lot_number'] != ''){
                $db_builder->where('lot_number', $value['lot_number']);
                $db_builder->where('expiry_date', $value['expiry_date']);
                $receipt_detail = $db_builder->get(get_db_prefix().'goods_receipt_detail')->getRow();
                if($receipt_detail){
                    $price = $receipt_detail->unit_price;
                }else{
                    $db_builder->where('id' ,$item_id);
                    $item = $db_builder->get(get_db_prefix().'items')->getRow();
                    if($item){
                        $price = $item->purchase_price;
                    }
                }
            }else{
                $db_builder->where('id' ,$item_id);
                $item = $db_builder->get(get_db_prefix().'items')->getRow();
                if($item){
                    $price = $item->purchase_price;
                }
            }

            $amount += ($value['quantities'] * $price);
        }

        foreach($wh_loss_adjustment_detail as $value){
            $price = 0;
            if($value['lot_number'] != ''){
                $db_builder->where('lot_number', $value['lot_number']);
                $db_builder->where('expiry_date', $value['expiry_date']);
                $receipt_detail = $db_builder->get(get_db_prefix().'goods_receipt_detail')->getRow();
                if($receipt_detail){
                    $price = $receipt_detail->unit_price;
                }else{
                    $db_builder->where('id' ,$item_id);
                    $item = $db_builder->get(get_db_prefix().'items')->getRow();
                    if($item){
                        $price = $item->purchase_price;
                    }
                }
            }else{
                $db_builder->where('id' ,$item_id);
                $item = $db_builder->get(get_db_prefix().'items')->getRow();
                if($item){
                    $price = $item->purchase_price;
                }
            }

            if($value['current_number'] > $value['updates_number']){
                $amount -= ($value['current_number'] - $value['updates_number']) * $price;
            }else{
                $amount += ($value['updates_number'] - $value['current_number']) * $price;
            }
        }
        foreach($inventory_manage as $value){
            $price = 0;
            if($value['lot_number'] != ''){
                $db_builder->where('lot_number', $value['lot_number']);
                $db_builder->where('expiry_date', $value['expiry_date']);
                $receipt_detail = $db_builder->get(get_db_prefix().'goods_receipt_detail')->getRow();
                if($receipt_detail){
                    $price = $receipt_detail->unit_price;
                }else{
                    $db_builder->where('id' ,$item_id);
                    $item = $db_builder->get(get_db_prefix().'items')->getRow();
                    if($item){
                        $price = $item->purchase_price;
                    }
                }
            }else{
                $db_builder->where('id' ,$item_id);
                $item = $db_builder->get(get_db_prefix().'items')->getRow();
                if($item){
                    $price = $item->purchase_price;
                }
            }

            $amount += $value['inventory_number'] * $price;
        }

        return $amount;
    }

    /**
     * get opening stock data
     * @param  integer $item_id 
     * @return object         
     */
    public function get_opening_stock_data($item_id){
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));

        $db_builder->where('id' ,$item_id);
        $item = $db_builder->get(get_db_prefix().'items')->getRow();

        $item->opening_stock = $this->calculate_opening_stock($item_id, $date_financial_year);

        return $item;
    }

    /**
     * update warehouse automatic conversion
     *
     * @param      array   $data   The data
     *
     * @return     boolean 
     */
    public function update_warehouse_automatic_conversion($data){
        $affectedRows = 0;
        
        if(!isset($data['acc_wh_stock_import_automatic_conversion'])){
            $data['acc_wh_stock_import_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_wh_stock_export_automatic_conversion'])){
            $data['acc_wh_stock_export_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_wh_loss_adjustment_automatic_conversion'])){
            $data['acc_wh_loss_adjustment_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_wh_opening_stock_automatic_conversion'])){
            $data['acc_wh_opening_stock_automatic_conversion'] = 0;
        }

        foreach ($data as $key => $value) {
            $db_builder->where('name', $key);
            $db_builder->update(get_db_prefix() . 'options', [
                    'value' => $value,
                ]);
            if ($this->db->affectedRows() > 0) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Automatic payslip conversion
     * @param  integer $payslip_id 
     * @return boolean
     */
    public function automatic_payslip_conversion($payslips_id){
        $db_builder->where('rel_id', $payslips_id);
        $db_builder->where('rel_type', 'payslip');
        $count = $this->db->countAllResults(get_db_prefix() . 'acc_account_history');

        if($count > 0){
            return false;
        }

        $db_builder->where('id', $payslips_id);
        $payslip = $db_builder->get(get_db_prefix(). 'hrp_payslips')->getRow();

        $db_builder->where('payslip_id', $payslips_id);
        $payslip_details = $db_builder->get(get_db_prefix(). 'hrp_payslip_details')->getResultArray();

        $insurance_payment_account = get_setting('acc_pl_total_insurance_payment_account');
        $insurance_deposit_to = get_setting('acc_pl_total_insurance_deposit_to');

        $tax_paye_payment_account = get_setting('acc_pl_tax_paye_payment_account');
        $tax_paye_deposit_to = get_setting('acc_pl_tax_paye_deposit_to');

        $net_pay_payment_account = get_setting('acc_pl_net_pay_payment_account');
        $net_pay_deposit_to = get_setting('acc_pl_net_pay_deposit_to');

        $affectedRows = 0;

        if($payslip){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($payslip->payslip_month) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }

            $this->load->model('currencies_model');
            $currency = $this->currencies_model->get_base_currency();

            $total_insurance = 0;
            $net_pay = 0;
            $income_tax_paye = 0;
            foreach ($payslip_details as $key => $value) {
                if(is_numeric($value['total_insurance'])){
                    $total_insurance += $value['total_insurance'];
                }

                if(is_numeric($value['net_pay'])){
                    $net_pay += $value['net_pay'];
                }

                if(is_numeric($value['income_tax_paye'])){
                    $income_tax_paye += $value['income_tax_paye'];
                }
            }

            $data_insert = [];

            if(get_setting('acc_pl_total_insurance_automatic_conversion') == 1){
                $node = [];
                $node['split'] = $insurance_payment_account;
                $node['account'] = $insurance_deposit_to;
                $node['date'] = $payslip->payslip_month;
                $node['debit'] = $total_insurance;
                $node['credit'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $payslips_id;
                $node['rel_type'] = 'payslip';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $insurance_deposit_to;
                $node['account'] = $insurance_payment_account;
                $node['date'] = $payslip->payslip_month;
                $node['debit'] = 0;
                $node['credit'] = $total_insurance;
                $node['description'] = '';
                $node['rel_id'] = $payslips_id;
                $node['rel_type'] = 'payslip';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;
            }

            if(get_setting('acc_pl_tax_paye_automatic_conversion') == 1){
                $node = [];
                $node['split'] = $tax_paye_payment_account;
                $node['account'] = $tax_paye_deposit_to;
                $node['date'] = $payslip->payslip_month;
                $node['debit'] = $income_tax_paye;
                $node['credit'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $payslips_id;
                $node['rel_type'] = 'payslip';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $tax_paye_deposit_to;
                $node['account'] = $tax_paye_payment_account;
                $node['date'] = $payslip->payslip_month;
                $node['debit'] = 0;
                $node['credit'] = $income_tax_paye;
                $node['description'] = '';
                $node['rel_id'] = $payslips_id;
                $node['rel_type'] = 'payslip';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;
            }

            if(get_setting('acc_pl_net_pay_automatic_conversion') == 1){
                $node = [];
                $node['split'] = $net_pay_payment_account;
                $node['account'] = $net_pay_deposit_to;
                $node['date'] = $payslip->payslip_month;
                $node['debit'] = $net_pay;
                $node['credit'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $payslips_id;
                $node['rel_type'] = 'payslip';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $net_pay_deposit_to;
                $node['account'] = $net_pay_payment_account;
                $node['date'] = $payslip->payslip_month;
                $node['debit'] = 0;
                $node['credit'] = $net_pay;
                $node['description'] = '';
                $node['rel_id'] = $payslips_id;
                $node['rel_type'] = 'payslip';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;
            }

            if($data_insert != []){
                $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Automatic purchase order conversion
     * @param  integer $purchase_order_id 
     * @return boolean
     */
    public function automatic_purchase_order_conversion($purchase_order_id){
        $db_builder->where('rel_id', $purchase_order_id);
        $db_builder->where('rel_type', 'purchase_orde');
        $count = $this->db->countAllResults(get_db_prefix() . 'acc_account_history');
        $affectedRows = 0;
        
        if($count > 0){
            return false;
        }

        $this->load->model('purchase/purchase_model');
        $purchase_order = $this->purchase_model->get_pur_order($purchase_order_id);
        $purchase_order_detail = $this->purchase_model->get_pur_order_detail($purchase_order_id);


        

        $payment_account = get_setting('acc_pur_order_payment_account');
        $deposit_to = get_setting('acc_pur_order_deposit_to');
        $tax_payment_account = get_setting('acc_expense_tax_payment_account');
        $tax_deposit_to = get_setting('acc_expense_tax_deposit_to');

        if($purchase_order){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($purchase_order->order_date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }
            
            $data_insert = [];

            foreach ($invoice->items as $value) {
                
            }

            foreach ($purchase_order_detail as $value) {

                $item = get_item_hp($value['item_code']);

                $item_id = 0;
                if(isset($item->id)){
                    $item_id = $item->id;
                }

                $item_total = $value['into_money'];

                $item_automatic = $this->get_item_automatic($item_id);

                if($item_automatic){
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $item_automatic->expence_account;
                    $node['item'] = $item_id;
                    $node['date'] = $purchase_order->order_date;
                    $node['debit'] = $item_total;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $purchase_order_id;
                    $node['rel_type'] = 'purchase_order';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $item_automatic->expence_account;
                    $node['account'] = $payment_account;
                    $node['item'] = $item_id;
                    $node['date'] = $purchase_order->order_date;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $purchase_order_id;
                    $node['rel_type'] = 'purchase_order';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['date'] = $purchase_order->order_date;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $purchase_order_id;
                    $node['rel_type'] = 'purchase_order';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to;
                    $node['account'] = $payment_account;
                    $node['item'] = $item_id;
                    $node['date'] = $purchase_order->order_date;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $purchase_order_id;
                    $node['rel_type'] = 'purchase_order';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }

                if(get_setting('acc_tax_automatic_conversion') == 1 && $value['tax'] > 0){
                    $tax_payment_account = get_setting('acc_expense_tax_payment_account');
                    $tax_deposit_to = get_setting('acc_expense_tax_deposit_to');

                    $total_tax = $value['total'] - $value['into_money'];

                    $tax_mapping = $this->get_tax_mapping($value['tax']);

                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->payment_account;
                        $node['account'] = $tax_mapping->deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $purchase_order->order_date;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $purchase_order_id;
                        $node['rel_type'] = 'purchase_order';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->deposit_to;
                        $node['account'] = $tax_mapping->payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $purchase_order->order_date;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $purchase_order_id;
                        $node['rel_type'] = 'purchase_order';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $purchase_order->order_date;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $purchase_order_id;
                        $node['rel_type'] = 'purchase_order';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['date'] = $purchase_order->order_date;
                        $node['account'] = $tax_payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $purchase_order_id;
                        $node['rel_type'] = 'purchase_order';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }
                }
            }

            if($data_insert != []){
                $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Automatic stock import conversion
     * @param  integer $stock_import_id 
     * @return boolean
     */
    public function automatic_stock_import_conversion($stock_import_id){
        $db_builder->where('rel_id', $stock_import_id);
        $db_builder->where('rel_type', 'stock_import');
        $count = $this->db->countAllResults(get_db_prefix() . 'acc_account_history');
        $affectedRows = 0;
        
        if($count > 0 || get_setting('acc_wh_stock_import_automatic_conversion') == 0){
            return false;
        }

        $this->load->model('warehouse/warehouse_model');
        $goods_receipt = $this->warehouse_model->get_goods_receipt($stock_import_id);
        $goods_receipt_detail = $this->warehouse_model->get_goods_receipt_detail($stock_import_id);


        

        $payment_account = get_setting('acc_wh_stock_import_payment_account');
        $deposit_to = get_setting('acc_wh_stock_import_deposit_to');

        $tax_payment_account = get_setting('acc_expense_tax_payment_account');
        $tax_deposit_to = get_setting('acc_expense_tax_deposit_to');

        if($goods_receipt){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($goods_receipt->date_c) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }
            
            $data_insert = [];

            foreach ($invoice->items as $value) {
                
            }

            foreach ($goods_receipt_detail as $value) {

                $db_builder->where('id', $value['commodity_code']);
                $item = $db_builder->get(get_db_prefix().'items')->getRow();

                $item_id = 0;
                if(isset($item->id)){
                    $item_id = $item->id;
                }

                $item_total = $value['goods_money'];

                $item_automatic = $this->get_item_automatic($item_id);

                if($item_automatic){
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $item_automatic->inventory_asset_account;
                    $node['item'] = $item_id;
                    $node['date'] = $goods_receipt->date_c;
                    $node['debit'] = $item_total;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_import_id;
                    $node['rel_type'] = 'stock_import';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $item_automatic->inventory_asset_account;
                    $node['account'] = $payment_account;
                    $node['item'] = $item_id;
                    $node['date'] = $goods_receipt->date_c;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_import_id;
                    $node['rel_type'] = 'stock_import';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['date'] = $goods_receipt->date_c;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_import_id;
                    $node['rel_type'] = 'stock_import';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to;
                    $node['account'] = $payment_account;
                    $node['item'] = $item_id;
                    $node['date'] = $goods_receipt->date_c;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_import_id;
                    $node['rel_type'] = 'stock_import';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }

                if(get_setting('acc_tax_automatic_conversion') == 1 && $value['tax'] > 0){
                    $tax_payment_account = get_setting('acc_expense_tax_payment_account');
                    $tax_deposit_to = get_setting('acc_expense_tax_deposit_to');

                    $total_tax = $value['tax_money'];

                    $tax_mapping = $this->get_tax_mapping($value['tax']);

                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->payment_account;
                        $node['account'] = $tax_mapping->deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $goods_receipt->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_import_id;
                        $node['rel_type'] = 'stock_import';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->deposit_to;
                        $node['account'] = $tax_mapping->payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $goods_receipt->date_c;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_import_id;
                        $node['rel_type'] = 'stock_import';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['date'] = $goods_receipt->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_import_id;
                        $node['rel_type'] = 'stock_import';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['date'] = $goods_receipt->date_c;
                        $node['account'] = $tax_payment_account;
                        $node['tax'] = $value['tax'];
                        $node['item'] = 0;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_import_id;
                        $node['rel_type'] = 'stock_import';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }
                }
            }

            if($data_insert != []){
                $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Automatic stock export conversion
     * @param  integer $stock_export_id 
     * @return boolean
     */
    public function automatic_stock_export_conversion($stock_export_id){
        $db_builder->where('rel_id', $stock_export_id);
        $db_builder->where('rel_type', 'stock_export');
        $count = $this->db->countAllResults(get_db_prefix() . 'acc_account_history');
        $affectedRows = 0;
        
        if($count > 0 || get_setting('acc_wh_stock_export_automatic_conversion') == 0){
            return false;
        }

        $this->load->model('warehouse/warehouse_model');
        $goods_delivery = $this->warehouse_model->get_goods_delivery($stock_export_id);
        $goods_delivery_detail = $this->warehouse_model->get_goods_delivery_detail($stock_export_id);


        

        $payment_account = get_setting('acc_wh_stock_export_payment_account');
        $deposit_to = get_setting('acc_wh_stock_export_deposit_to');

        $tax_payment_account = get_setting('acc_tax_payment_account');
        $tax_deposit_to = get_setting('acc_tax_deposit_to');

        if($goods_delivery){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($goods_delivery->date_c) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }
            
            $data_insert = [];

            foreach ($invoice->items as $value) {
                
            }

            foreach ($goods_delivery_detail as $value) {

                $db_builder->where('id', $value['commodity_code']);
                $item = $db_builder->get(get_db_prefix().'items')->getRow();

                $item_id = 0;
                if(isset($item->id)){
                    $item_id = $item->id;
                }

                $item_total = ($value['quantities'] * $value['unit_price']);

                $item_automatic = $this->get_item_automatic($item_id);

                if($item_automatic){
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $item_automatic->inventory_asset_account;
                    $node['item'] = $item_id;
                    $node['date'] = $goods_delivery->date_c;
                    $node['debit'] = $item_total;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_export_id;
                    $node['rel_type'] = 'stock_export';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $item_automatic->inventory_asset_account;
                    $node['account'] = $payment_account;
                    $node['item'] = $item_id;
                    $node['date'] = $goods_delivery->date_c;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_export_id;
                    $node['rel_type'] = 'stock_export';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }else{
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['item'] = $item_id;
                    $node['debit'] = $item_total;
                    $node['date'] = $goods_delivery->date_c;
                    $node['tax'] = 0;
                    $node['credit'] = 0;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_export_id;
                    $node['rel_type'] = 'stock_export';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to;
                    $node['account'] = $payment_account;
                    $node['item'] = $item_id;
                    $node['date'] = $goods_delivery->date_c;
                    $node['tax'] = 0;
                    $node['debit'] = 0;
                    $node['credit'] = $item_total;
                    $node['description'] = '';
                    $node['rel_id'] = $stock_export_id;
                    $node['rel_type'] = 'stock_export';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }

                if(get_setting('acc_tax_automatic_conversion') == 1 && $value['tax'] > 0){
                    $tax_payment_account = get_setting('acc_tax_payment_account');
                    $tax_deposit_to = get_setting('acc_tax_deposit_to');

                    $total_tax = $value['total_money'] - $item_total;

                    $tax_mapping = $this->get_tax_mapping($value['tax']);

                    if($tax_mapping){
                        $node = [];
                        $node['split'] = $tax_mapping->payment_account;
                        $node['account'] = $tax_mapping->deposit_to;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['date'] = $goods_delivery->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_export_id;
                        $node['rel_type'] = 'stock_export';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_mapping->deposit_to;
                        $node['account'] = $tax_mapping->payment_account;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['date'] = $goods_delivery->date_c;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_export_id;
                        $node['rel_type'] = 'stock_export';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }else{
                        $node = [];
                        $node['split'] = $tax_payment_account;
                        $node['account'] = $tax_deposit_to;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['date'] = $goods_delivery->date_c;
                        $node['debit'] = $total_tax;
                        $node['credit'] = 0;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_export_id;
                        $node['rel_type'] = 'stock_export';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;

                        $node = [];
                        $node['split'] = $tax_deposit_to;
                        $node['date'] = $goods_delivery->date_c;
                        $node['account'] = $tax_payment_account;
                        $node['tax'] = $value['tax_id'];
                        $node['item'] = 0;
                        $node['debit'] = 0;
                        $node['credit'] = $total_tax;
                        $node['description'] = '';
                        $node['rel_id'] = $stock_export_id;
                        $node['rel_type'] = 'stock_export';
                        $node['datecreated'] = date('Y-m-d H:i:s');
                        $node['addedfrom'] = get_staff_user_id();
                        $data_insert[] = $node;
                    }
                }
            }

            if($data_insert != []){
                $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Automatic loss adjustment conversion
     * @param  integer $loss_adjustment_id 
     * @return boolean
     */
    public function automatic_loss_adjustment_conversion($loss_adjustment_id){
        $db_builder->where('rel_id', $loss_adjustment_id);
        $db_builder->where('rel_type', 'loss_adjustment');
        $count = $this->db->countAllResults(get_db_prefix() . 'acc_account_history');
        $affectedRows = 0;
        
        if($count > 0 || get_setting('acc_wh_loss_adjustment_automatic_conversion') == 0){
            return false;
        }

        $this->load->model('warehouse/warehouse_model');
        $loss_adjustment = $this->warehouse_model->get_loss_adjustment($loss_adjustment_id);
        $loss_adjustment_detail = $this->warehouse_model->get_loss_adjustment_detailt_by_masterid($loss_adjustment_id);

        $decrease_payment_account = get_setting('acc_wh_decrease_payment_account');
        $decrease_deposit_to = get_setting('acc_wh_decrease_deposit_to');
        $increase_payment_account = get_setting('acc_wh_increase_payment_account');
        $increase_deposit_to = get_setting('acc_wh_increase_deposit_to');

        

        if($loss_adjustment){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime(date('Y-m-d', strtotime($loss_adjustment->time))) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }
            
            $data_insert = [];

            foreach ($loss_adjustment_detail as $value) {
                

                $db_builder->where('id', $value['items']);
                $item = $db_builder->get(get_db_prefix().'items')->getRow();

                $item_id = 0;
                if(isset($item->id)){
                    $item_id = $item->id;
                }

                $price = 0;
                if($value['lot_number'] != ''){
                    $db_builder->where('lot_number', $value['lot_number']);
                    $db_builder->where('expiry_date', $value['expiry_date']);
                    $receipt_detail = $db_builder->get(get_db_prefix().'goods_receipt_detail')->getRow();
                    if($receipt_detail){
                        $price = $receipt_detail->unit_price;
                    }else{
                        $db_builder->where('id' ,$item_id);
                        $item = $db_builder->get(get_db_prefix().'items')->getRow();
                        if($item){
                            $price = $item->purchase_price;
                        }
                    }
                }else{
                    $db_builder->where('id' ,$item_id);
                    $item = $db_builder->get(get_db_prefix().'items')->getRow();
                    if($item){
                        $price = $item->purchase_price;
                    }
                }


                $item_automatic = $this->get_item_automatic($item_id);

                if($item_automatic){
                    if($value['current_number'] < $value['updates_number']){
                        $number = $value['updates_number'] - $value['current_number'];
                        $loss_adjustment_payment_account = $increase_payment_account;
                        $loss_adjustment_deposit_to = $item_automatic->inventory_asset_account;
                    }else{
                        $number = $value['current_number'] - $value['updates_number'];
                        $loss_adjustment_payment_account = $item_automatic->inventory_asset_account;
                        $loss_adjustment_deposit_to = $increase_deposit_to;
                    }
                }else{
                    if($value['current_number'] < $value['updates_number']){
                        $number = $value['updates_number'] - $value['current_number'];
                        $loss_adjustment_payment_account = $increase_payment_account;
                        $loss_adjustment_deposit_to = $increase_deposit_to;
                    }else{
                        $number = $value['current_number'] - $value['updates_number'];
                        $loss_adjustment_payment_account = $decrease_payment_account;
                        $loss_adjustment_deposit_to = $decrease_deposit_to;
                    }
                }

                $item_total = $number * $price;

                $node = [];
                $node['split'] = $loss_adjustment_payment_account;
                $node['account'] = $loss_adjustment_deposit_to;
                $node['item'] = $item_id;
                $node['debit'] = $item_total;
                $node['date'] = date('Y-m-d', strtotime($loss_adjustment->time));
                $node['tax'] = 0;
                $node['credit'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $loss_adjustment_id;
                $node['rel_type'] = 'loss_adjustment';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $loss_adjustment_deposit_to;
                $node['account'] = $loss_adjustment_payment_account;
                $node['item'] = $item_id;
                $node['date'] = date('Y-m-d', strtotime($loss_adjustment->time));
                $node['tax'] = 0;
                $node['debit'] = 0;
                $node['credit'] = $item_total;
                $node['description'] = '';
                $node['rel_id'] = $loss_adjustment_id;
                $node['rel_type'] = 'loss_adjustment';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;
            }

            if($data_insert != []){
                $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Automatic opening stock conversion
     * @param  integer $loss_adjustment_id 
     * @return boolean
     */
    public function automatic_opening_stock_conversion($opening_stock_id){
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));

        $db_builder->where('rel_id', $opening_stock_id);
        $db_builder->where('rel_type', 'opening_stock');
        $db_builder->where('date', $date_financial_year);
        $count = $this->db->countAllResults(get_db_prefix() . 'acc_account_history');
        $affectedRows = 0;
        
        if($count > 0 || get_setting('acc_wh_opening_stock_automatic_conversion') == 0){
            return false;
        }

        $opening_stock = $this->get_opening_stock_data($opening_stock_id);

        $deposit_to = get_setting('acc_wh_opening_stock_deposit_to');
        $payment_account = get_setting('acc_wh_opening_stock_payment_account');


        

        if($opening_stock){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($date_financial_year) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }
            
            $data_insert = [];

            $node = [];
            $node['split'] = $payment_account;
            $node['account'] = $deposit_to;
            $node['debit'] = $opening_stock->opening_stock;
            $node['date'] = $date_financial_year;
            $node['credit'] = 0;
            $node['tax'] = 0;
            $node['description'] = '';
            $node['rel_id'] = $opening_stock_id;
            $node['rel_type'] = 'opening_stock';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = get_staff_user_id();
            $data_insert[] = $node;

            $node = [];
            $node['split'] = $deposit_to;
            $node['account'] = $payment_account;
            $node['date'] = $date_financial_year;
            $node['tax'] = 0;
            $node['debit'] = 0;
            $node['credit'] = $opening_stock->opening_stock;
            $node['description'] = '';
            $node['rel_id'] = $opening_stock_id;
            $node['rel_type'] = 'opening_stock';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = get_staff_user_id();
            $data_insert[] = $node;

            if($data_insert != []){
                $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * update purchase automatic conversion
     *
     * @param      array   $data   The data
     *
     * @return     boolean 
     */
    public function update_purchase_automatic_conversion($data){
        $affectedRows = 0;
        
        if(!isset($data['acc_pur_order_automatic_conversion'])){
            $data['acc_pur_order_automatic_conversion'] = 0;
        }

        if(!isset($data['acc_pur_payment_automatic_conversion'])){
            $data['acc_pur_payment_automatic_conversion'] = 0;
        }

        foreach ($data as $key => $value) {
            $db_builder->where('name', $key);
            $db_builder->update(get_db_prefix() . 'options', [
                    'value' => $value,
                ]);
            if ($this->db->affectedRows() > 0) {
                $affectedRows++;
            }
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * count purchase order not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object          
     */
    public function count_purchase_order_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';
        if($currency != ''){
            $where_currency = 'and currency = '.$currency;
        }

        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'pur_orders.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "purchase_order") = 0) '.$where_currency);
        return $this->db->countAllResults(get_db_prefix().'pur_orders');
    }

    /**
     * count purchase payment not convert yet
     * @param  integer $currency
     * @param  string $where
     * @return object          
     */
    public function count_purchase_payment_not_convert_yet($currency = '', $where = ''){
        $where_currency = '';
        if($currency != ''){
            $where_currency = 'and currency = '.$currency;
        }

        if($where != ''){
            $db_builder->where($where);
        }
        $db_builder->where('((select count(*) from ' . get_db_prefix() . 'acc_account_history where ' . get_db_prefix() . 'acc_account_history.rel_id = ' . get_db_prefix() . 'pur_invoice_payment.id and ' . get_db_prefix() . 'acc_account_history.rel_type = "purchase_payment") = 0) AND (' . get_db_prefix() . 'pur_invoices.pur_order is not null) '.$where_currency);
        $this->db->join(get_db_prefix().'pur_invoices', get_db_prefix() . 'pur_invoices.id = ' . get_db_prefix() . 'pur_invoice_payment.pur_invoice', 'left');
        return $this->db->countAllResults(get_db_prefix().'pur_invoice_payment');
    }

    /**
     * Automatic payment conversion
     * @param  integer $payment_id 
     * @return boolean
     */
    public function automatic_purchase_payment_conversion($payment_id){
        $db_builder->where('rel_id', $payment_id);
        $db_builder->where('rel_type', 'purchase_payment');
        $count = $this->db->countAllResults(get_db_prefix() . 'acc_account_history');

        if($count > 0){
            return false;
        }

        $this->load->model('purchase/purchase_model');
        $payment = $this->purchase_model->get_payment_pur_invoice($payment_id);

        $payment_account = get_setting('acc_pur_payment_payment_account');
        $deposit_to = get_setting('acc_pur_payment_deposit_to');
        $affectedRows = 0;
        $data_insert = [];

        if($payment){
            if(get_setting('acc_close_the_books') == 1){
                if(strtotime($payment->date) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                    return false;
                }
            }

            $payment_total = $payment->amount;

            $payment_mode_mapping = $this->get_payment_mode_mapping($payment->paymentmode);

            if($payment_mode_mapping && get_setting('acc_active_payment_mode_mapping') == 1){
                $node = [];
                $node['split'] = $payment_mode_mapping->expense_payment_account;
                $node['account'] = $payment_mode_mapping->expense_deposit_to;
                $node['date'] = $payment->date;
                $node['debit'] = $payment_total;
                $node['credit'] = 0;
                $node['tax'] = 0;
                $node['description'] = '';
                $node['rel_id'] = $payment_id;
                $node['rel_type'] = 'purchase_payment';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;

                $node = [];
                $node['split'] = $payment_mode_mapping->expense_deposit_to;
                $node['account'] = $payment_mode_mapping->expense_payment_account;
                $node['date'] = $payment->date;
                $node['tax'] = 0;
                $node['debit'] = 0;
                $node['credit'] = $payment_total;
                $node['description'] = '';
                $node['rel_id'] = $payment_id;
                $node['rel_type'] = 'purchase_payment';
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = get_staff_user_id();
                $data_insert[] = $node;
            }else{
                if(get_setting('acc_pur_payment_automatic_conversion') == 1){
                    $node = [];
                    $node['split'] = $payment_account;
                    $node['account'] = $deposit_to;
                    $node['debit'] = $payment_total;
                    $node['credit'] = 0;
                    $node['date'] = $payment->date;
                    $node['description'] = '';
                    $node['rel_id'] = $payment_id;
                    $node['rel_type'] = 'purchase_payment';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;

                    $node = [];
                    $node['split'] = $deposit_to;
                    $node['account'] = $payment_account;
                    $node['date'] = $payment->date;
                    $node['debit'] = 0;
                    $node['credit'] = $payment_total;
                    $node['description'] = '';
                    $node['rel_id'] = $payment_id;
                    $node['rel_type'] = 'purchase_payment';
                    $node['datecreated'] = date('Y-m-d H:i:s');
                    $node['addedfrom'] = get_staff_user_id();
                    $data_insert[] = $node;
                }
            }

            if($data_insert != []){
                $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
            }
                
            if ($affectedRows > 0) {
                return true;
            }
        }

        return false;
    }
    
    public function get_budgets($id = '', $where = []){
        $db_builder = $this->db->table(get_db_prefix().'acc_budgets');
        if (is_numeric($id)) {
            $db_builder->where('id', $id);
            $budget = $db_builder->get()->getRow();

            if($budget){
                $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
                $db_builder->where('budget_id', $id);
                $budget->details = $db_builder->get()->getResultArray();
            }
            
            return $budget;
        }

        $db_builder->where($where);
        $db_builder->orderBy('id', 'desc');
        return $db_builder->get()->getResultArray();
    }

    /**
     * Adds a budget.
     */
    public function add_budget($data){
        $data['name'] = $data['year'].' - '. app_lang($data['type']);

        $db_builder = $this->db->table(get_db_prefix().'acc_budgets');
        $db_builder->insert($data);
        $insert_id = $this->db->insertID();

        if($insert_id){
            return $insert_id;
        }
        return false;
    }

    /**
     * add journal entry
     * @param array $data 
     * @return boolean
     */
    public function update_budget_detail($data){

        $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
        $db_builder->where('budget_id', $data['budget']);
        $db_builder->delete();

        $budget_data = json_decode($data['budget_data']);
        unset($data['budget_data']);

        $columns = $this->get_columns_budget($data['budget'], $data['view_type'], true);
        

        $data_insert = [];
        foreach($budget_data as $row){
            $data_details = array_combine($columns, $row);
            $account_id = '';
            $month = '';
            foreach($data_details as $key => $value){
                if($key == 'account_id'){
                    $account_id = $value;
                }

                if($key != 'account_name' && $key != 'account_id' && $key != 'total' && $value != null){
                    if($data['view_type'] == 'monthly'){
                        $month = explode('_', $key);
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => $month[0], 'year' => $month[1], 'account' => $account_id, 'amount' => $value];
                    }elseif($data['view_type'] == 'quarterly'){
                        $month = explode('_', $key);

                        if($month[0] == 'q1')
                        {
                            $value_1 = round($value/3);
                            $value_2 = round($value/3);
                            $value_3 = $value - $value_2 - $value_1;
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 1, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 2, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_2];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 3, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_3];
                        }
                        else  if($month[0] == 'q2')
                        {
                            $value_1 = round($value/3);
                            $value_2 = round($value/3);
                            $value_3 = $value - $value_2 - $value_1;
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 4, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 5, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_2];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 6, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_3];
                        }
                        else  if($month[0] == 'q3')
                        {
                            $value_1 = round($value/3);
                            $value_2 = round($value/3);
                            $value_3 = $value - $value_2 - $value_1;
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 7, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 8, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_2];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 9, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_3];
                        }
                        else  if($month[0] == 'q4')
                        {
                            $value_1 = round($value/3);
                            $value_2 = round($value/3);
                            $value_3 = $value - $value_2 - $value_1;
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 10, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 11, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_2];
                            $data_insert[] = ['budget_id' => $data['budget'], 'month' => 12, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_3];
                        }
                    }else{
                        $month = explode('_', $key);

                        $value_1 = round($value/12);
                        $value_2 = $value - ($value_1*11);

                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 1, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 2, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 3, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 4, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 5, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 6, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 7, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 8, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 9, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 10, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 11, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_1];
                        $data_insert[] = ['budget_id' => $data['budget'], 'month' => 12, 'year' => $month[1], 'account' => $account_id, 'amount' => $value_2];
                    }
                }
            }
        }

        if(count($data_insert) > 0){
            $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
            $affectedRows = $db_builder->insertBatch($data_insert);
        }

        return true;
    }

    /**
     * check budget.
     */
    public function check_budget($data){
        $db_builder = $this->db->table(get_db_prefix() . 'acc_budgets');
        $db_builder->where('year', $data['year']);
        $db_builder->where('type', $data['type']);
        $budget = $db_builder->get()->getRow();

        if($budget){
            return $budget->id;
        }
        return true;
    }

    /**
     * get data budget
     * @param  array  $data_fill 
     * @param  boolean $only_data 
     * @return object             
     */
    public function get_data_budget($data_fill, $only_data = false)
    {
        if(isset($data_fill['view_type'])){
            switch ($data_fill['view_type']) {
                case 'quarterly':
                $data = $this->get_data_budget_quarterly($data_fill, $only_data);
                break;
                case 'yearly':
                $data = $this->get_data_budget_yearly($data_fill, $only_data);
                break;
                case 'monthly':
                $data = $this->get_data_budget_monthly($data_fill, $only_data);
                break;
                default:
                $data = $this->get_data_budget_monthly($data_fill, $only_data);
                break;
            }
        }else{
            $data = $this->get_data_budget_monthly($data_fill, $only_data);
        }

        return $data;
    }

    /**
     * Gets the data budget.
     *
     * @param      object  $data_fill  The data fill
     *
     * @return     array   The data budget.
     */
    public function get_data_budget_monthly($data_fill, $only_data = false)
    {
        if(isset($data_fill['budget']) && $data_fill['budget'] != 0){
            $budget = $this->get_budgets($data_fill['budget']);            
            if($budget){
                $year = $budget->year;
            }else{
                $year = date('Y');
            }
        }elseif(isset($data_fill['year'])){
            $year = $data_fill['year'];
        }else{
            $year = date('Y');
        }

        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.($year + 1)));


        $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
        $db_builder->where('active', 1);
        if(isset($budget)){
            if($budget->type == 'profit_and_loss_accounts'){
                $db_builder->where('find_in_set(account_type_id, "11,12,13,14,15")');
            }elseif($budget->type == 'balance_sheet_accounts'){
                $db_builder->where('account_type_id not in (11,12,13,14,15)');
            }
        }
        $db_builder->where('(parent_account is null or parent_account = 0)');

        $db_builder->orderBy('id', 'asc');

        $accounts = $db_builder->get()->getResultArray();

        $data_return = [];
        $rResult = [];

        foreach ($accounts as $key => $value) {
            $rResult[] = $value;
            $rResult = $this->get_recursive_account($rResult, $value['id'], [], 1);
        }

        $data = [];
        if (isset($budget) && !isset($data_fill['clear'])) {
            foreach($budget->details as $detail){
                if($detail['month'] < 10){
                    $detail['month'] = '0'.$detail['month'];
                }
                if(isset($data[$detail['account']])){
                    $data[$detail['account']][$detail['month'].'_'.$detail['year']] = $detail['amount'];
                    $data[$detail['account']]['total'] += $detail['amount'];
                }else{
                    $data[$detail['account']] = [];
                    $data[$detail['account']][$detail['month'].'_'.$detail['year']] = $detail['amount'];
                    $data[$detail['account']]['total'] = $detail['amount'];
                }
            }
        }

        foreach($rResult as $account){
            $name = '';
            if($account['number'] != ''){
                $name = $account['number'].' - ';
            }

            if (isset($account['level'])) {
                for ($i = 0; $i < $account['level']; $i++) {
                    $name .= '          ';
                }
            }

            if ($account['name'] == '') {
                $name .= _l($account['key_name']);
            } else {
                $name .= $account['name'];
            }

            if(isset($data[$account['id']])){
                $data_return[] = array_merge($data[$account['id']], ['account_name' => $name,'account_id' => $account['id']]);
            }else{
                $data_return[] = ['account_name' => $name,'account_id' => $account['id']];
            }
        }

        return $data_return;
    }

    /**
     * Gets the data budget.
     *
     * @param      object  $data_fill  The data fill
     *
     * @return     array   The data budget.
     */
    public function get_data_budget_quarterly($data_fill, $only_data = false)
    {

        if(isset($data_fill['budget']) && $data_fill['budget'] != 0){
            $budget = $this->get_budgets($data_fill['budget']);
            if($budget){
                $year = $budget->year;
            }else{
                $year = date('Y');
            }
        }elseif(isset($data_fill['year'])){
            $year = $data_fill['year'];
        }else{
            $year = date('Y');
        }

        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.($year + 1)));


        $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
        $db_builder->where('active', 1);
        if(isset($budget)){
            if($budget->type == 'profit_and_loss_accounts'){
                $db_builder->where('find_in_set(account_type_id, "11,12,13,14,15")');
            }elseif($budget->type == 'balance_sheet_accounts'){
                $db_builder->where('account_type_id not in (11,12,13,14,15)');
            }
        }
        $db_builder->where('(parent_account is null or parent_account = 0)');

        $db_builder->orderBy('id', 'asc');

        $accounts = $db_builder->get()->getResultArray();

        $data_return = [];
        $rResult = [];

        foreach ($accounts as $key => $value) {
            $rResult[] = $value;
            $rResult = $this->get_recursive_account($rResult, $value['id'], [], 1);
        }

        $data = [];
        if (isset($budget) && !isset($data_fill['clear'])) {
            foreach($budget->details as $detail){
                if($detail['month'] < 10){
                    $detail['month'] = '0'.$detail['month'];
                }

                if($detail['month']>=1 && $detail['month']<=3)
                {
                    $t = 'q1_'.$detail['year'];
                }
                else  if($detail['month']>=4 && $detail['month']<=6)
                {
                    $t = 'q2_'.$detail['year'];
                }
                else  if($detail['month']>=7 && $detail['month']<=9)
                {
                    $t = 'q3_'.$detail['year'];
                }
                else  if($detail['month']>=10 && $detail['month']<=12)
                {
                    $t = 'q4_'.$detail['year'];
                }
                
                if(isset($data[$detail['account']])){
                    if(isset($data[$detail['account']][$t])){
                        $data[$detail['account']][$t] += $detail['amount'];
                    }else{
                        $data[$detail['account']][$t] = $detail['amount'];
                    }

                    if(isset($data[$detail['account']]['total'])){
                        $data[$detail['account']]['total'] += $detail['amount'];
                    }else{
                        $data[$detail['account']]['total'] = $detail['amount'];
                    }

                }else{
                    $data[$detail['account']] = [];
                    $data[$detail['account']][$t] = $detail['amount'];
                    $data[$detail['account']]['total'] = $detail['amount'];
                }
            }
        }

        foreach($rResult as $account){
            $name = '';
            if($account['number'] != ''){
                $name = $account['number'].' - ';
            }

            if (isset($account['level'])) {
                for ($i = 0; $i < $account['level']; $i++) {
                    $name .= '          ';
                }
            }

            if ($account['name'] == '') {
                $name .= _l($account['key_name']);
            } else {
                $name .= $account['name'];
            }

            if(isset($data[$account['id']])){
                $data_return[] = array_merge($data[$account['id']], ['account_name' => $name,'account_id' => $account['id']]);
            }else{
                $data_return[] = ['account_name' => $name,'account_id' => $account['id']];
            }
        }

        return $data_return;

    }

    /**
     * Gets the data budget.
     *
     * @param      object  $data_fill  The data fill
     *
     * @return     array   The data budget.
     */
    public function get_data_budget_yearly($data_fill, $only_data = false)
    {
        if(isset($data_fill['budget']) && $data_fill['budget'] != 0){
            $budget = $this->get_budgets($data_fill['budget']);
            if($budget){
                $year = $budget->year;
            }else{
                $year = date('Y');
            }
        }elseif(isset($data_fill['year'])){
            $year = $data_fill['year'];
        }else{
            $year = date('Y');
        }

        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.($year + 1)));

        $db_builder = $this->db->table(get_db_prefix() . 'acc_accounts');
        $db_builder->where('active', 1);
        if(isset($budget)){
            if($budget->type == 'profit_and_loss_accounts'){
                $db_builder->where('find_in_set(account_type_id, "11,12,13,14,15")');
            }elseif($budget->type == 'balance_sheet_accounts'){
                $db_builder->where('account_type_id not in (11,12,13,14,15)');
            }
        }
        $db_builder->where('(parent_account is null or parent_account = 0)');

        $db_builder->orderBy('id', 'asc');

        $accounts = $db_builder->get()->getResultArray();

        $data_return = [];
        $rResult = [];

        foreach ($accounts as $key => $value) {
            $rResult[] = $value;
            $rResult = $this->get_recursive_account($rResult, $value['id'], [], 1);
        }

        $data = [];
        if (isset($budget) && !isset($data_fill['clear'])) {
            foreach($budget->details as $detail){

                if(isset($data[$detail['account']])){
                    if(isset($data[$detail['account']]['_'.$detail['year']])){
                        $data[$detail['account']]['_'.$detail['year']] += $detail['amount'];
                    }else{
                        $data[$detail['account']]['_'.$detail['year']] = $detail['amount'];
                    }

                    $data[$detail['account']]['total'] += $detail['amount'];
                }else{
                    $data[$detail['account']] = [];
                    $data[$detail['account']]['_'.$detail['year']] = $detail['amount'];
                    $data[$detail['account']]['total'] = $detail['amount'];
                }
            }
        }

        foreach($rResult as $account){
            $name = '';
            if($account['number'] != ''){
                $name = $account['number'].' - ';
            }

            if (isset($account['level'])) {
                for ($i = 0; $i < $account['level']; $i++) {
                    $name .= '          ';
                }
            }

            if ($account['name'] == '') {
                $name .= _l($account['key_name']);
            } else {
                $name .= $account['name'];
            }
            if(isset($data[$account['id']])){
                $data_return[] = array_merge(['account_name' => $name,'account_id' => $account['id']], $data[$account['id']]);
            }else{
                $data_return[] = ['account_name' => $name,'account_id' => $account['id']];
            }
        }

        return $data_return;
    }

    public function get_nestedheaders_budget($budget_id, $budget_type)
    {

        $budget = $this->get_budgets($budget_id);

        $year = $budget->year;
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.($year + 1)));

        $nestedheaders    = [];
        $nestedheaders[] = _l('acc_account');
        $nestedheaders[] = _l('account_id');

        switch ($budget_type) {
            case 'yearly':
                $nestedheaders[] = $year;
                if($acc_first_month_of_financial_year != 'January'){
                    $nestedheaders[] = $year+1;
                    $nestedheaders[] = _l('total');
                }
            break;
            case 'quarterly':
            while (strtotime($from_date) < strtotime($to_date)) {
                $month = date('m', strtotime($from_date));
                $year = date('Y', strtotime($from_date));
                if($month>=1 && $month<=3)
                {
                    $t = 'Q1 - '.$year;
                }
                else  if($month>=4 && $month<=6)
                {
                    $t = 'Q2 - '.$year;
                }
                else  if($month>=7 && $month<=9)
                {
                    $t = 'Q3 - '.$year;
                }
                else  if($month>=10 && $month<=12)
                {
                    $t = 'Q4 - '.$year;
                }

                if(!in_array($t, $nestedheaders)){
                    $nestedheaders[] = $t;
                }

                $from_date = date('Y-m-d', strtotime('+1 month', strtotime($from_date)));
            }
            $nestedheaders[] = _l('total');

            break;
            case 'monthly':
            while (strtotime($from_date) < strtotime($to_date)) {

                $month = date('M - Y', strtotime($from_date));

                $nestedheaders[] = $month;

                $from_date = date('Y-m-d', strtotime('+1 month', strtotime($from_date)));

                if(strtotime($from_date) > strtotime($to_date)){
                    $month_2 = date('M - Y', strtotime($to_date));

                    if($month != $month_2){
                        $nestedheaders[] = $month_2;
                    }
                }
            }

            $nestedheaders[] = _l('total');

            break;
            default:
            break;
        }

        return $nestedheaders;
    }

    /**
     * Gets the columns budget.
     *
     * @param      integer  $budget_id 
     * @param      string  $budget_type    day or week or month
     *
     * @return     array   The columns budget.
     */
    public function get_columns_budget($budget_id, $budget_type, $only_data = false)
    {
        $budget = $this->get_budgets($budget_id);

        $year = $budget->year;

        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-t', strtotime($from_date . '  - 1 month + 1 year '));

       
        if($only_data){
            $columns = ['account_name', 'account_id'];
        }else{
            $columns = [['data' => 'account_name', 'type' => 'text', 'readOnly' => true],
                ['data' => 'account_id', 'type' => 'text', 'readOnly' => true]
            ];
        }

        switch ($budget_type) {
            case 'yearly':
                if($acc_first_month_of_financial_year != 'January'){
                    if($only_data){
                        array_push($columns, '_'.$year);
                        array_push($columns, '_'.($year+1));
                    }else{
                        array_push($columns, ['data' => '_'.$year, 'type' => 'numeric', 'numericFormat' => [
                            'pattern' => '0.00',
                        ]]);
                        array_push($columns, ['data' => '_'.($year+1), 'type' => 'numeric', 'numericFormat' => [
                            'pattern' => '0.00',
                        ]]);
                    }

                    if($only_data){
                        array_push($columns, 'total');
                    }else{
                        array_push($columns, ['data' => 'total', 'type' => 'numeric', 'numericFormat' => [
                            'pattern' => '0.00'
                        ],'readOnly' => true]);
                    }
                }else{
                    if($only_data){
                        array_push($columns, '_'.$year);
                    }else{
                        array_push($columns, ['data' => '_'.$year, 'type' => 'numeric', 'numericFormat' => [
                            'pattern' => '0.00',
                        ]]);
                    }
                }


            break;
            case 'quarterly':
            $nestedheaders = [];
            while (strtotime($from_date) < strtotime($to_date)) {
                $month = date('m', strtotime($from_date));
                $year = date('Y', strtotime($from_date));

                if($month>=1 && $month<=3)
                {
                    $t = 'q1_'.$year;
                }
                else  if($month>=4 && $month<=6)
                {
                    $t = 'q2_'.$year;
                }
                else  if($month>=7 && $month<=9)
                {
                    $t = 'q3_'.$year;
                }
                else  if($month>=10 && $month<=12)
                {
                    $t = 'q4_'.$year;
                }

                if(!in_array($t, $nestedheaders)){
                    $nestedheaders[] = $t;

                    if($only_data){
                        array_push($columns, $t);
                    }else{
                        array_push($columns, ['data' => $t, 'type' => 'numeric', 'numericFormat' => [
                            'pattern' => '0.00',
                        ]]);
                    }
                }

                $from_date = date('Y-m-d', strtotime('+1 month', strtotime($from_date)));
            }

            if($only_data){
                array_push($columns, 'total');
            }else{
                array_push($columns, ['data' => 'total', 'type' => 'numeric', 'numericFormat' => [
                    'pattern' => '0.00'
                ],'readOnly' => true]);
            }

            break;
            case 'monthly':

            while (strtotime($from_date) < strtotime($to_date)) {
                $month = date('m_Y', strtotime($from_date));

                if($only_data){
                    array_push($columns, $month);
                }else{
                    array_push($columns, ['data' => $month, 'type' => 'numeric', 'numericFormat' => [
                        'pattern' => '0.00',
                    ]]);
                }
                $from_date = date('Y-m-d', strtotime('+1 month', strtotime($from_date)));

                if(strtotime($from_date) > strtotime($to_date)){
                    $month_2 = date('m_Y', strtotime($to_date));

                    if($month != $month_2){
                        if($only_data){
                            array_push($columns, $month_2);
                        }else{
                            array_push($columns, ['data' => $month_2, 'type' => 'numeric', 'numericFormat' => [
                                'pattern' => '0.00',
                            ]]);
                        }
                    }
                }
            }

            if($only_data){
                array_push($columns, 'total');
            }else{
                array_push($columns, ['data' => 'total', 'type' => 'numeric', 'numericFormat' => [
                    'pattern' => '0.00'
                ],'readOnly' => true]);
            }

            break;
            default:
            break;
        }

        return $columns;
    }

    /**
     * Gets the columns budget.
     *
     * @param      string  $from_date  The from date format dd/mm/YYYY
     * @param      string  $to_date    To date format dd/mm/YYYY
     *
     * @return     array   The columns budget.
     */
    public function get_columns_budget_by_month($from_date, $to_date)
    {
        $visible = [];
        $visible[1] = get_setting('staff_workload_monday_visible');
        $visible[2] = get_setting('staff_workload_tuesday_visible');
        $visible[3] = get_setting('staff_workload_thursday_visible');
        $visible[4] = get_setting('staff_workload_wednesday_visible');
        $visible[5] = get_setting('staff_workload_friday_visible');
        $visible[6] = get_setting('staff_workload_saturday_visible');
        $visible[7] = get_setting('staff_workload_sunday_visible');
        
        
        if (!$this->check_format_date($from_date)) {
            $from_date = to_sql_date($from_date);
        }
        if (!$this->check_format_date($to_date)) {
            $to_date = to_sql_date($to_date);
        }
        $columns = [['data' => 'staff_name', 'type' => 'text', 'readOnly' => true],
        ['data' => 'staff_id', 'type' => 'text', 'readOnly' => true],
        ['data' => 'capacity', 'type' => 'text', 'readOnly' => true],
        ['data' => 'remainCapacityEstimated', 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => ['pattern' => '0.00']],
        ['data' => 'remainCapacity', 'type' => 'numeric', 'readOnly' => true, 'numericFormat' => ['pattern' => '0.00']],
        ['data' => 'staff_department', 'type' => 'text', 'readOnly' => true],
        ['data' => 'staff_role', 'type' => 'text', 'readOnly' => true]];
        while (strtotime($from_date) < strtotime($to_date)) {
            if($visible[date('N', strtotime($from_date))] == 1){
                array_push($columns, ['data' => date('d_m_Y', strtotime($from_date)) . '_e', 'type' => 'numeric', 'numericFormat' => [
                    'pattern' => '0.00',
                ]]);
                array_push($columns, ['data' => date('d_m_Y', strtotime($from_date)) . '_s', 'type' => 'numeric', 'numericFormat' => [
                    'pattern' => '0.00',
                ]]);
            }
            $from_date = date('Y-m-d', strtotime('+1 day', strtotime($from_date)));
        }
        return $columns;
    }

    /**
     * update a budget.
     */
    public function update_budget($data, $id){
        $db_builder = $this->db->table(get_db_prefix() . 'acc_budgets');
        $db_builder->where('id', $id);
        $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

        /**
     * check reconcile restored
     * @param  [type] $account 
     * @param  [type] $company 
     * @return [type]          
     */
    public function check_reconcile_restored($account){
        $restored = false;

        $db_builder = $this->db->table(get_db_prefix() . 'acc_reconciles');
        $db_builder->where('account', $account);
        $db_builder->where('finish', 1);
        $db_builder->where('opening_balance', 0);
        $db_builder->orderBy('id', 'desc');
        $reconcile = $db_builder->get()->getResultArray();

        if(count($reconcile) > 0){
            $reconcile = true;
        }

        return $reconcile;
    }

    /**
     * reconcile restored
     * @param  [type] $account 
     * @return [type]          
     */
    public function reconcile_restored($account)
    {
        $affected_rows=0;
        //get reconcile
        $db_builder = $this->db->table(get_db_prefix() . 'acc_reconciles');
        $db_builder->where('account', $account);
        $db_builder->where('finish', 1);
        $db_builder->where('opening_balance', 0);
        $db_builder->orderBy('ending_date', 'desc');

        $reconcile = $db_builder->get()->getRow();

        if($reconcile){
            $db_builder = $this->db->table(get_db_prefix() . 'acc_account_history');
            $db_builder->where('reconcile', $reconcile->id);
            $db_builder->update(['reconcile' => 0]);
 
            if ($this->db->affectedRows() > 0) {
                $affected_rows++;
            }

            $db_builder = $this->db->table(get_db_prefix() . 'acc_reconciles');
            $db_builder->where('id', $reconcile->id);
            $db_builder->delete();

            if ($this->db->affectedRows() > 0) {
                $affected_rows++;
            }
        }

        if($affected_rows > 0){
            return true;
        }
        return false;
    }

    /**
     * get data accounts receivable ageing detail
     * @return array 
     */
    public function get_data_accounts_receivable_ageing_detail($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $Invoices_model = model('Invoices_model');


        $data_report = [];
        $data_report['current'] = [];
        $data_report['1_30_days_past_due'] = [];
        $data_report['31_60_days_past_due'] = [];
        $data_report['61_90_days_past_due'] = [];
        $data_report['91_and_over'] = [];

        $db_builder = $this->db->table(get_db_prefix() . 'invoices');
        $db_builder->select('*, (select sum(amount) from '.get_db_prefix() . 'invoice_payments where invoice_id = '.get_db_prefix().'invoices.id) as total_payments');
        $db_builder->where('IF(due_date IS NOT NULL,(bill_date <= "' . $to_date . '" and due_date >= "' . $to_date . '"),(bill_date = "' .  $to_date . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();
        
        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;

            if($total_payments <= 0){
                continue;
            }

            $data_report['current'][] = [
                'date' => $v['bill_date'],
                'due_date' => $v['due_date'],
                'type' => app_lang('invoice'),
                'number' => get_invoice_id($v['id']),
                'customer' => $v['client_id'],
                'amount' => $total_payments,
            ];
        }

        $db_builder->select('*, (select sum(amount) from '.get_db_prefix() . 'invoice_payments where invoice_id = '.get_db_prefix().'invoices.id) as total_payments');
        $db_builder->where('IF(due_date IS NOT NULL,(due_date >=  "' . date('Y-m-d', strtotime($to_date.' - 30 days')) . '" and due_date <= "' . date('Y-m-d', strtotime($to_date.' - 1 days')) . '"),(bill_date >=  "' . date('Y-m-d', strtotime($to_date.' - 30 days')) . '" and bill_date <= "' . date('Y-m-d', strtotime($to_date.' - 1 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();
        
        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }

            $data_report['1_30_days_past_due'][] = [
                'date' => $v['bill_date'],
                'due_date' => $v['due_date'],
                'type' => app_lang('invoice'),
                'number' => get_invoice_id($v['id']),
                'customer' => $v['client_id'],
                'amount' => $total_payments,
            ];
        }

        $db_builder->select('*, (select sum(amount) from '.get_db_prefix() . 'invoice_payments where invoice_id = '.get_db_prefix().'invoices.id) as total_payments');
        $db_builder->where('IF(due_date IS NOT NULL,(due_date >=  "' . date('Y-m-d', strtotime($to_date.' - 60 days')) . '" and due_date <= "' . date('Y-m-d', strtotime($to_date.' - 31 days')) . '"),(bill_date >=  "' . date('Y-m-d', strtotime($to_date.' - 60 days')) . '" and bill_date <= "' . date('Y-m-d', strtotime($to_date.' - 31 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();
        
        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            $data_report['31_60_days_past_due'][] = [
                'date' => $v['bill_date'],
                'due_date' => $v['due_date'],
                'type' => app_lang('invoice'),
                'number' => get_invoice_id($v['id']),
                'customer' => $v['client_id'],
                'amount' => $total_payments,
            ];
        }

        $db_builder->select('*, (select sum(amount) from '.get_db_prefix() . 'invoice_payments where invoice_id = '.get_db_prefix().'invoices.id) as total_payments');
        $db_builder->where('IF(due_date IS NOT NULL,(due_date >=  "' . date('Y-m-d', strtotime($to_date.' - 90 days')) . '" and due_date <= "' . date('Y-m-d', strtotime($to_date.' - 61 days')) . '"),(bill_date >=  "' . date('Y-m-d', strtotime($to_date.' - 90 days')) . '" and bill_date <= "' . date('Y-m-d', strtotime($to_date.' - 61 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();
        
        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            $data_report['61_90_days_past_due'][] = [
                'date' => $v['bill_date'],
                'due_date' => $v['due_date'],
                'type' => app_lang('invoice'),
                'number' => get_invoice_id($v['id']),
                'customer' => $v['client_id'],
                'amount' => $total_payments,
            ];
        }

        $db_builder->select('*, (select sum(amount) from '.get_db_prefix() . 'invoice_payments where invoice_id = '.get_db_prefix().'invoices.id) as total_payments');
        $db_builder->where('IF(due_date IS NOT NULL,(due_date <=  "' . date('Y-m-d', strtotime($to_date.' - 91 days')) . '"),(bill_date <=  "' . date('Y-m-d', strtotime($to_date.' - 91 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();
        
        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            $data_report['91_and_over'][] = [
                'date' => $v['bill_date'],
                'due_date' => $v['due_date'],
                'type' => app_lang('invoice'),
                'number' => get_invoice_id($v['id']),
                'customer' => $v['client_id'],
                'amount' => $total_payments,
            ];
        }
        
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data accounts payable ageing detail
     * @return array 
     */
    public function get_data_accounts_payable_ageing_detail($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }


        $db_builder = $this->db->table(get_db_prefix() . 'invoices');
        $db_builder->where('paymentmode', '');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();

        $list_expenses = [];
        foreach ($expenses as $key => $value) {
            $list_expenses[] = $value['id'];
        }
        $list_expenses = implode(',', $list_expenses);

        $db_builder->where('account_detail_type_id', 1004);
        $accounts = $db_builder->get(get_db_prefix().'acc_accounts')->getResultArray();

        $list_accounts = [];
        foreach ($accounts as $key => $value) {
            $list_accounts[] = $value['id'];
        }
        $list_accounts = implode(',', $list_accounts);

        $data_report = [];
        $data_report['current'] = [];
        $data_report['1_30_days_past_due'] = [];
        $data_report['31_60_days_past_due'] = [];
        $data_report['61_90_days_past_due'] = [];
        $data_report['91_and_over'] = [];

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('date = "' .  $to_date . '" and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {
            $total = $v['amount'];

            if($v['tax'] != 0){
                $total += ($total / 100 * $v['taxrate']);
            }
            if($v['tax2'] != 0){
                $total += ($v['amount'] / 100 * $v['taxrate2']);
            }

            $data_report['current'][] = [
                'date' => $v['date'],
                'duedate' => $v['date'],
                'type' => app_lang('expenses'),
                'number' => '#'.$v['expense_id'],
                'vendor' => $v['vendor'],
                'customer' => $v['clientid'],
                'amount' => $total,
            ];
        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('(date >= "' .  date('Y-m-d', strtotime($to_date.' - 30 days')) . '" and date <= "' . date('Y-m-d', strtotime($to_date.' - 1 days')) . '") and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {
            $total = $v['amount'];

            if($v['tax'] != 0){
                $total += ($total / 100 * $v['taxrate']);
            }
            if($v['tax2'] != 0){
                $total += ($v['amount'] / 100 * $v['taxrate2']);
            }

            $data_report['1_30_days_past_due'][] = [
                'date' => $v['date'],
                'duedate' => $v['date'],
                'type' => app_lang('expenses'),
                'number' => '#'.$v['expense_id'],
                'vendor' => $v['vendor'],
                'customer' => $v['clientid'],
                'amount' => $total,
            ];
        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('(date >= "' .  date('Y-m-d', strtotime($to_date.' - 60 days')) . '" and date <= "' . date('Y-m-d', strtotime($to_date.' - 31 days')) . '") and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {
            $total = $v['amount'];

            if($v['tax'] != 0){
                $total += ($total / 100 * $v['taxrate']);
            }
            if($v['tax2'] != 0){
                $total += ($v['amount'] / 100 * $v['taxrate2']);
            }

            $data_report['31_60_days_past_due'][] = [
                'date' => $v['date'],
                'duedate' => $v['date'],
                'type' => app_lang('expenses'),
                'number' => '#'.$v['expense_id'],
                'vendor' => $v['vendor'],
                'customer' => $v['clientid'],
                'amount' => $total,
            ];
        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('(date >= "' .  date('Y-m-d', strtotime($to_date.' - 90 days')) . '" and date <= "' . date('Y-m-d', strtotime($to_date.' - 61 days')) . '") and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {
            $total = $v['amount'];

            if($v['tax'] != 0){
                $total += ($total / 100 * $v['taxrate']);
            }
            if($v['tax2'] != 0){
                $total += ($v['amount'] / 100 * $v['taxrate2']);
            }

            $data_report['61_90_days_past_due'][] = [
                'date' => $v['date'],
                'duedate' => $v['date'],
                'type' => app_lang('expenses'),
                'number' => '#'.$v['expense_id'],
                'vendor' => $v['vendor'],
                'customer' => $v['clientid'],
                'amount' => $total,
            ];
        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('date <= "' .  date('Y-m-d', strtotime($to_date.' - 91 days')) . '" and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {
            $total = $v['amount'];

            if($v['tax'] != 0){
                $total += ($total / 100 * $v['taxrate']);
            }
            if($v['tax2'] != 0){
                $total += ($v['amount'] / 100 * $v['taxrate2']);
            }

            $data_report['91_and_over'][] = [
                'date' => $v['date'],
                'duedate' => $v['date'],
                'type' => app_lang('expenses'),
                'number' => '#'.$v['expense_id'],
                'vendor' => $v['vendor'],
                'customer' => $v['clientid'],
                'amount' => $total,
            ];
        }
        
        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data accounts receivable ageing summary
     * @return array 
     */
    public function get_data_accounts_receivable_ageing_summary($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $tax = 0;
        if(isset($data_filter['tax'])){
            $tax = $data_filter['tax'];
        }

        $Invoices_model = model('Invoices_model');

        $data_report = [];

        $db_builder = $this->db->table(get_db_prefix().'invoices');
        $db_builder->where('deleted', 0);
        $db_builder->where('IF(due_date IS NOT NULL,(bill_date <= "' . $to_date . '" and due_date >= "' . $to_date . '"),(bill_date = "' .  $to_date . '")) and (status = "not_paid")');

        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();

        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            if(!isset($data_report[$v['client_id']])){
                $data_report[$v['client_id']]['current'] = 0;
                $data_report[$v['client_id']]['1_30_days_past_due'] = 0;
                $data_report[$v['client_id']]['31_60_days_past_due'] = 0;
                $data_report[$v['client_id']]['61_90_days_past_due'] = 0;
                $data_report[$v['client_id']]['91_and_over'] = 0;
                $data_report[$v['client_id']]['total'] = 0;
            }

            $data_report[$v['client_id']]['current'] += $total_payments;
            $data_report[$v['client_id']]['total'] += $total_payments;
        }

        $db_builder->where('IF(due_date IS NOT NULL,(due_date >=  "' . date('Y-m-d', strtotime($to_date.' - 30 days')) . '" and due_date <= "' . date('Y-m-d', strtotime($to_date.' - 1 days')) . '"),(bill_date >=  "' . date('Y-m-d', strtotime($to_date.' - 30 days')) . '" and bill_date <= "' . date('Y-m-d', strtotime($to_date.' - 1 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();

        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            if(!isset($data_report[$v['client_id']])){
                $data_report[$v['client_id']]['current'] = 0;
                $data_report[$v['client_id']]['1_30_days_past_due'] = 0;
                $data_report[$v['client_id']]['31_60_days_past_due'] = 0;
                $data_report[$v['client_id']]['61_90_days_past_due'] = 0;
                $data_report[$v['client_id']]['91_and_over'] = 0;
                $data_report[$v['client_id']]['total'] = 0;
            }

            $data_report[$v['client_id']]['1_30_days_past_due'] += $total_payments;
            $data_report[$v['client_id']]['total'] += $total_payments;

        }

        $db_builder->where('IF(due_date IS NOT NULL,(due_date >=  "' . date('Y-m-d', strtotime($to_date.' - 60 days')) . '" and due_date <= "' . date('Y-m-d', strtotime($to_date.' - 31 days')) . '"),(bill_date >=  "' . date('Y-m-d', strtotime($to_date.' - 60 days')) . '" and bill_date <= "' . date('Y-m-d', strtotime($to_date.' - 31 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();

        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            if(!isset($data_report[$v['client_id']])){
                $data_report[$v['client_id']]['current'] = 0;
                $data_report[$v['client_id']]['1_30_days_past_due'] = 0;
                $data_report[$v['client_id']]['31_60_days_past_due'] = 0;
                $data_report[$v['client_id']]['61_90_days_past_due'] = 0;
                $data_report[$v['client_id']]['91_and_over'] = 0;
                $data_report[$v['client_id']]['total'] = 0;
            }

            $data_report[$v['client_id']]['31_60_days_past_due'] += $total_payments;
            $data_report[$v['client_id']]['total'] += $total_payments;

        }

        $db_builder->where('IF(due_date IS NOT NULL,(due_date >=  "' . date('Y-m-d', strtotime($to_date.' - 90 days')) . '" and due_date <= "' . date('Y-m-d', strtotime($to_date.' - 61 days')) . '"),(bill_date >=  "' . date('Y-m-d', strtotime($to_date.' - 90 days')) . '" and bill_date <= "' . date('Y-m-d', strtotime($to_date.' - 61 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();

        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            if(!isset($data_report[$v['client_id']])){
                $data_report[$v['client_id']]['current'] = 0;
                $data_report[$v['client_id']]['1_30_days_past_due'] = 0;
                $data_report[$v['client_id']]['31_60_days_past_due'] = 0;
                $data_report[$v['client_id']]['61_90_days_past_due'] = 0;
                $data_report[$v['client_id']]['91_and_over'] = 0;
                $data_report[$v['client_id']]['total'] = 0;
            }

            $data_report[$v['client_id']]['61_90_days_past_due'] += $total_payments;
            $data_report[$v['client_id']]['total'] += $total_payments;

        }
        
        $db_builder->where('IF(due_date IS NOT NULL,(due_date <=  "' . date('Y-m-d', strtotime($to_date.' - 91 days')) . '"),(bill_date <=  "' . date('Y-m-d', strtotime($to_date.' - 91 days')) . '")) and (status = "not_paid")');

        $db_builder->where('deleted', 0);
        $db_builder->orderBy('bill_date', 'asc');
        
        $invoices = $db_builder->get()->getResultArray();

        foreach ($invoices as $v) {
            $invoice_total_summary = $Invoices_model->get_invoice_total_summary($v['id']);
            $total_payments = $invoice_total_summary->balance_due;
            if($total_payments <= 0){
                continue;
            }
            
            if(!isset($data_report[$v['client_id']])){
                $data_report[$v['client_id']]['current'] = 0;
                $data_report[$v['client_id']]['1_30_days_past_due'] = 0;
                $data_report[$v['client_id']]['31_60_days_past_due'] = 0;
                $data_report[$v['client_id']]['61_90_days_past_due'] = 0;
                $data_report[$v['client_id']]['91_and_over'] = 0;
                $data_report[$v['client_id']]['total'] = 0;
            }

            $data_report[$v['client_id']]['91_and_over'] += $total_payments;
            $data_report[$v['client_id']]['total'] += $total_payments;

        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

     /**
     * get data accounts payable ageing summary
     * @return array 
     */
     public function get_data_accounts_payable_ageing_summary($data_filter){
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $tax = 0;
        if(isset($data_filter['tax'])){
            $tax = $data_filter['tax'];
        }


        $data_report = [];

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('date = "' .  $to_date . '" and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {

            if($v['clientid'] != ''){

                $total = $v['amount'];

                if($v['tax'] != 0){
                    $total += ($total / 100 * $v['taxrate']);
                }
                if($v['tax2'] != 0){
                    $total += ($v['amount'] / 100 * $v['taxrate2']);
                }

                if(!isset($data_report[$v['clientid']])){
                    $data_report[$v['clientid']]['current'] = 0;
                    $data_report[$v['clientid']]['1_30_days_past_due'] = 0;
                    $data_report[$v['clientid']]['31_60_days_past_due'] = 0;
                    $data_report[$v['clientid']]['61_90_days_past_due'] = 0;
                    $data_report[$v['clientid']]['91_and_over'] = 0;
                    $data_report[$v['clientid']]['total'] = 0;
                }

                $data_report[$v['clientid']]['current'] += $total;
                $data_report[$v['clientid']]['total'] += $total;
            }

        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('(date >= "' .  date('Y-m-d', strtotime($to_date.' - 30 days')) . '" and date <= "' . date('Y-m-d', strtotime($to_date.' - 1 days')) . '") and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();

        foreach ($expenses as $v) {
            if($v['clientid'] != ''){
                $total = $v['amount'];

                if($v['tax'] != 0){
                    $total += ($total / 100 * $v['taxrate']);
                }
                if($v['tax2'] != 0){
                    $total += ($v['amount'] / 100 * $v['taxrate2']);
                }

                if(!isset($data_report[$v['clientid']])){
                    $data_report[$v['clientid']]['current'] = 0;
                    $data_report[$v['clientid']]['1_30_days_past_due'] = 0;
                    $data_report[$v['clientid']]['31_60_days_past_due'] = 0;
                    $data_report[$v['clientid']]['61_90_days_past_due'] = 0;
                    $data_report[$v['clientid']]['91_and_over'] = 0;
                    $data_report[$v['clientid']]['total'] = 0;
                }

                $data_report[$v['clientid']]['1_30_days_past_due'] += $total;
                $data_report[$v['clientid']]['total'] += $total;
            }

        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('(date >= "' .  date('Y-m-d', strtotime($to_date.' - 60 days')) . '" and date <= "' . date('Y-m-d', strtotime($to_date.' - 31 days')) . '") and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();

        foreach ($expenses as $v) {
            if($v['clientid'] != ''){
                $total = $v['amount'];

                if($v['tax'] != 0){
                    $total += ($total / 100 * $v['taxrate']);
                }
                if($v['tax2'] != 0){
                    $total += ($v['amount'] / 100 * $v['taxrate2']);
                }

                if(!isset($data_report[$v['clientid']])){
                    $data_report[$v['clientid']]['current'] = 0;
                    $data_report[$v['clientid']]['1_30_days_past_due'] = 0;
                    $data_report[$v['clientid']]['31_60_days_past_due'] = 0;
                    $data_report[$v['clientid']]['61_90_days_past_due'] = 0;
                    $data_report[$v['clientid']]['91_and_over'] = 0;
                    $data_report[$v['clientid']]['total'] = 0;
                }

                $data_report[$v['clientid']]['31_60_days_past_due'] += $total;
                $data_report[$v['clientid']]['total'] += $total;
            }

        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('(date >= "' .  date('Y-m-d', strtotime($to_date.' - 90 days')) . '" and date <= "' . date('Y-m-d', strtotime($to_date.' - 61 days')) . '") and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {
            if($v['clientid'] != ''){
                $total = $v['amount'];

                if($v['tax'] != 0){
                    $total += ($total / 100 * $v['taxrate']);
                }
                if($v['tax2'] != 0){
                    $total += ($v['amount'] / 100 * $v['taxrate2']);
                }

                if(!isset($data_report[$v['clientid']])){
                    $data_report[$v['clientid']]['current'] = 0;
                    $data_report[$v['clientid']]['1_30_days_past_due'] = 0;
                    $data_report[$v['clientid']]['31_60_days_past_due'] = 0;
                    $data_report[$v['clientid']]['61_90_days_past_due'] = 0;
                    $data_report[$v['clientid']]['91_and_over'] = 0;
                    $data_report[$v['clientid']]['total'] = 0;
                }

                $data_report[$v['clientid']]['61_90_days_past_due'] += $total;
                $data_report[$v['clientid']]['total'] += $total;
            }

        }

        $db_builder->select('*, ' . get_db_prefix() . 'expenses.id as expense_id, ' . get_db_prefix() . 'taxes.taxrate as taxrate, ' . get_db_prefix() . 'taxes_2.taxrate as taxrate2');
        $db_builder->where('date <= "' .  date('Y-m-d', strtotime($to_date.' - 91 days')) . '" and paymentmode = ""');
        $this->db->join(get_db_prefix() . 'taxes', '' . get_db_prefix() . 'taxes.id = ' . get_db_prefix() . 'expenses.tax', 'left');
        $this->db->join('' . get_db_prefix() . 'taxes as ' . get_db_prefix() . 'taxes_2', '' . get_db_prefix() . 'taxes_2.id = ' . get_db_prefix() . 'expenses.tax2', 'left');
        $db_builder->orderBy('date', 'asc');
        $expenses = $db_builder->get(get_db_prefix().'expenses')->getResultArray();
        
        foreach ($expenses as $v) {
            if($v['clientid'] != ''){
                $total = $v['amount'];

                if($v['tax'] != 0){
                    $total += ($total / 100 * $v['taxrate']);
                }
                if($v['tax2'] != 0){
                    $total += ($v['amount'] / 100 * $v['taxrate2']);
                }

                if(!isset($data_report[$v['clientid']])){
                    $data_report[$v['clientid']]['current'] = 0;
                    $data_report[$v['clientid']]['1_30_days_past_due'] = 0;
                    $data_report[$v['clientid']]['31_60_days_past_due'] = 0;
                    $data_report[$v['clientid']]['61_90_days_past_due'] = 0;
                    $data_report[$v['clientid']]['91_and_over'] = 0;
                    $data_report[$v['clientid']]['total'] = 0;
                }

                $data_report[$v['clientid']]['91_and_over'] += $total;
                $data_report[$v['clientid']]['total'] += $total;
            }

        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
    }

    /**
     * get data profit and loss 12 months
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss_12_months($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'accrual';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $row = [];
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);
                    $name = '';
                    while($month < $end)
                    {
                        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get()->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }


                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                            $row[date('m-Y', $month)] = $credits - $debits;
                        }else{
                            $row[date('m-Y', $month)] = $debits - $credits;
                        }

                        $month = strtotime("+1 month", $month);
                    }
                    $child_account = $this->get_data_profit_and_loss_12_months_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $acc_show_account_numbers);

                    $data_report[$data_key][] = ['name' => $name, 'amount' => $row, 'child_account' => $child_account];
                        
                }
            }
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data profit and loss recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $accounting_method   
     * @return array                 
     */
    public function get_data_profit_and_loss_12_months_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $row = [];
            $start = $month = strtotime($from_date);
            $end = strtotime($to_date);
            while($month < $end)
            {
                $db_builder->where('account', $val['id']);
                if($accounting_method == 'cash'){
                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                }
                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                if($acc_show_account_numbers == 1 && $val['number'] != ''){
                    $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                }else{
                    $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                }


                if($val['account_type_id'] == 11 || $val['account_type_id'] == 12){
                    $row[date('m-Y', $month)] = $credits - $debits;
                }else{
                    $row[date('m-Y', $month)] = $debits - $credits;
                }

                $month = strtotime("+1 month", $month);
            }

            $child_account[] = ['name' => $name, 'amount' => $row, 'child_account' => $this->get_data_profit_and_loss_12_months_recursive([], $val['id'], $account_type_id, $from_date, $to_date, $accounting_method, $acc_show_account_numbers)];
                
        }

        return $child_account;
    }

    /**
     * get html profit and loss
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss_12_months($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {
            $data_return['row_index']++;
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
            <td>
            '.$val['name'].'
            </td>';
            $total = 0;
            foreach($val['amount'] as $amount){
                $data_return['html'] .= '
                <td class="total_amount">
                '.to_currency($amount, $currency).'
                </td>';
                $total += $amount;

            }
            $total_amount = $total;
            $data_return['html'] .= '
            <td class="total_amount">
            '.to_currency($total_amount, $currency).'
            </td>';
            $data_return['html'] .= '</tr>';
            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_profit_and_loss_12_months($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                <td>
                '.app_lang('total_for', $val['name']).'
                </td>';
                foreach($val['amount'] as $amount){
                    $data_return['html'] .= '
                    <td class="total_amount"></td>';

                }
                $data_return['html'] .= '<td class="total_amount">
                '.to_currency($total_amount, $currency).'
                </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $total;
        }
        return $data_return; 
    }

    /**
     * get data budget overview
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_budget_overview($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $budget_id = 0;
      
        if(isset($data_filter['budget'])){
            $budget_id = $data_filter['budget'];
        }

        if($budget_id == 0){
            return ['type' => '','data' => []];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        $budget = $this->get_budgets($budget_id);
        
        if($budget->type == 'profit_and_loss_accounts'){
            foreach ($account_type_details as $key => $value) {
                if($value['account_type_id'] == 11){
                    $data_accounts['income'][] = $value;
                }

                if($value['account_type_id'] == 12){
                    $data_accounts['other_income'][] = $value;
                }

                if($value['account_type_id'] == 13){
                    $data_accounts['cost_of_sales'][] = $value;
                }

                if($value['account_type_id'] == 14){
                    $data_accounts['expenses'][] = $value;
                }

                if($value['account_type_id'] == 15){
                    $data_accounts['other_expenses'][] = $value;
                }
            }
        }else{
            foreach ($account_type_details as $key => $value) {
                if($value['account_type_id'] == 1){
                    $data_accounts['accounts_receivable'][] = $value;
                }
                if($value['account_type_id'] == 2){
                    $data_accounts['current_assets'][] = $value;
                }
                if($value['account_type_id'] == 3){
                    $data_accounts['cash_and_cash_equivalents'][] = $value;
                }
                if($value['account_type_id'] == 4){
                    $data_accounts['fixed_assets'][] = $value;
                }
                if($value['account_type_id'] == 5){
                    $data_accounts['non_current_assets'][] = $value;
                }
                if($value['account_type_id'] == 6){
                    $data_accounts['accounts_payable'][] = $value;
                }
                if($value['account_type_id'] == 7){
                    $data_accounts['credit_card'][] = $value;
                }
                if($value['account_type_id'] == 8){
                    $data_accounts['current_liabilities'][] = $value;
                }
                if($value['account_type_id'] == 9){
                    $data_accounts['non_current_liabilities'][] = $value;
                }
                if($value['account_type_id'] == 10){
                    $data_accounts['owner_equity'][] = $value;
                }
            }
        }

        $year = $budget->year;
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-t', strtotime('-1 month', strtotime($acc_first_month_of_financial_year . ' 01 '.($year + 1))));

        $_from_date = $from_date;

        $headers = [];
        while (strtotime($_from_date) < strtotime($to_date)) {

            $month = date('M - Y', strtotime($_from_date));

            $headers[] = $month;

            $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));

            if(strtotime($_from_date) > strtotime($to_date)){
                $month_2 = date('M - Y', strtotime($to_date));

                if($month != $month_2){
                    $headers[] = $month_2;
                }
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $row = [];
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
                        $db_builder->select('sum(amount) as amount');
                        $db_builder->where('account', $val['id']);
                        $db_builder->where('budget_id', $budget_id);
                        $db_builder->where('month', date('m',$month));
                        $db_builder->where('year', date('Y',$month));

                        $budget_data = $db_builder->get()->getRow();

                        if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }

                        $row[date('m-Y', $month)] = $budget_data->amount;
                        
                        $month = strtotime("+1 month", $month);
                    }
                    $child_account = $this->get_data_budget_overview_recursive([], $val['id'], $from_date, $to_date, $budget_id, $acc_show_account_numbers);

                    $data_report[$data_key][] = ['name' => $name, 'amount' => $row, 'child_account' => $child_account];
                        
                }
            }
        }

        return ['type' => $budget->type,'data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'headers' => $headers];
        
    }

    /**
     * get data profit and loss recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date   
     * @param  string $accounting_method   
     * @return array                 
     */
    public function get_data_budget_overview_recursive($child_account, $account_id, $from_date, $to_date, $budget_id, $acc_show_account_numbers){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        foreach ($accounts as $val) {
            $row = [];
            $start = $month = strtotime($from_date);
            $end = strtotime($to_date);
            while($month < $end)
            {
                $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
                $db_builder->select('sum(amount) as amount');
                $db_builder->where('account', $val['id']);
                $db_builder->where('budget_id', $budget_id);
                $db_builder->where('month', date('m',$month));
                $db_builder->where('year', date('Y',$month));

                $budget_data = $db_builder->get()->getRow();
                if($acc_show_account_numbers == 1 && $val['number'] != ''){
                    $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                }else{
                    $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                }

                $row[date('m-Y', $month)] = $budget_data->amount;
                        
                $month = strtotime("+1 month", $month);
            }

            $child_account[] = ['name' => $name, 'amount' => $row, 'child_account' => $this->get_data_budget_overview_recursive([], $val['id'], $from_date, $to_date, $budget_id, $acc_show_account_numbers)];
                
        }

        return $child_account;
    }

    /**
     * get html profit and loss
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_budget_overview($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {
            $data_return['row_index']++;
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
            <td>
            '.$val['name'].'
            </td>';
            $total = 0;
            foreach($val['amount'] as $amount){
                $data_return['html'] .= '
                <td class="total_amount">
                '.to_currency($amount, $currency->name).'
                </td>';
                $total += $amount;

            }
            $total_amount = $total;
            $data_return['html'] .= '
            <td class="total_amount">
            '.to_currency($total_amount, $currency->name).'
            </td>';
            $data_return['html'] .= '</tr>';
            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_budget_overview($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                <td>
                '.app_lang('total_for', $val['name']).'
                </td>';
                foreach($val['amount'] as $amount){
                    $data_return['html'] .= '
                    <td class="total_amount"></td>';

                }
                $data_return['html'] .= '<td class="total_amount">
                '.to_currency($total_amount, $currency->name).'
                </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $total;
        }
        return $data_return; 
    }

    /**
     * get data profit and loss
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss_budget_vs_actual($data_filter){
        
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');
        $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));
        $date_financial_year_2 = date('Y-m-t', strtotime($date_financial_year . '  - 1 month + 1 year '));

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $year = date('Y');
        $accounting_method = 'accrual';
        $display_columns = 'total_only';
        $budget_id = 0;
      
        if(isset($data_filter['budget'])){
            $budget_id = $data_filter['budget'];
        }

        if($budget_id == 0){
            return ['data' => []];
        }

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        $budget = $this->get_budgets($budget_id);
        $year = $budget->year;
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-t', strtotime($from_date . '  - 1 month + 1 year '));

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_profit_and_loss_budget_vs_actual_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $budget_id, $acc_show_account_numbers);

                    $budget_amount = $this->get_budget_by_account($budget_id, $val['id'], $from_date, $to_date);

                    
                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $amount = $credits - $debits;
                    }else{
                        $amount = $debits - $credits;
                    }

                    $data_report[$data_key][] = ['name' => $name, 'amount' => $amount, 'budget_amount' => $budget_amount, 'child_account' => $child_account];
                }
            }
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date];
        
    }

    /**
     * get data profit and loss
     * @param  array $data_filter 
     * @return array              
     */
    public function get_data_profit_and_loss_budget_performance($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $date_financial_year = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.date('Y')));
        $date_financial_year_2 = date('Y-m-t', strtotime($date_financial_year . '  - 1 month + 1 year '));

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $year = date('Y');


        $accounting_method = 'accrual';
        $budget_id = 0;
      
        if(isset($data_filter['budget'])){
            $budget_id = $data_filter['budget'];
        }

        if($budget_id == 0){
            return ['data' => []];
        }

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        $budget = $this->get_budgets($budget_id);

        $year = $budget->year;
        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-t', strtotime($from_date . '  - 1 month + 1 year '));

        $last_from_date = date('Y-m-01');
        $last_to_date = date('Y-m-t');
        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }
            
            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }

            if($value['account_type_id'] == 23){
                $data_accounts['cash_flow_data'][] = $value;
            }                
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('(date >= "' . $last_from_date . '" and date <= "' . $last_to_date . '")');
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $last_amount = $credits - $debits;
                    }else{
                        $last_amount = $debits - $credits;
                    }
                    $last_budget_amount = $this->get_budget_by_account($budget_id, $val['id'],  $last_from_date, $last_to_date);

                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get()->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                        $amount = $credits - $debits;
                    }else{
                        $amount = $debits - $credits;
                    }
                    $budget_amount = $this->get_budget_by_account($budget_id, $val['id'], $from_date, $to_date);

                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }


                    $child_account = $this->get_data_profit_and_loss_budget_performance_recursive([], $val['id'], $value['account_type_id'], $from_date, $to_date, $accounting_method, $budget_id, $acc_show_account_numbers);

                    $data_report[$data_key][] = ['name' => $name, 'last_amount' => $last_amount, 'last_budget_amount' => $last_budget_amount, 'amount' => $amount, 'budget_amount' => $budget_amount, 'child_account' => $child_account];
                }
            }
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'last_from_date' => $last_from_date, 'last_to_date' => $last_to_date];
        
    }

    /**
     * get html budget variance
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss_budget_vs_actual($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        $data_return['total_budget_amount'] = 0;
        foreach ($child_account as $val) {
            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $total_budget_amount = $val['budget_amount'];

            $percent = 0;
            if($val['amount'] != 0){
                if($val['budget_amount'] != 0){
                    $percent = round(($val['amount'] / $val['budget_amount']) * 100, 2);
                }else{
                    $percent = 100;
                }
            }
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['budget_amount'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency(($val['amount'] - $val['budget_amount']), $currency).'
              </td>
              <td class="total_amount">
              '.$percent.'%
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $t_2 = $data_return['total_budget_amount'];
                $data_return = $this->get_html_profit_and_loss_budget_vs_actual($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                $total_budget_amount += $data_return['total_budget_amount'];
                
                $data_return['row_index']++;
                $percent = 0;
                if($total_amount != 0){
                    if($total_budget_amount != 0){
                        $percent = round(($total_amount / $total_budget_amount) * 100, 2);
                    }else{
                        $percent = 100;
                    }
                }
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_budget_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency(($total_amount - $total_budget_amount), $currency).'
                  </td>
                  <td class="total_amount">
                  '.$percent.'%
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
                $data_return['total_budget_amount'] += $t_2;
            }

            $data_return['total_amount'] += $val['amount'];
            $data_return['total_budget_amount'] += $val['budget_amount'];
        }
        return $data_return; 
    }


    /**
     * get html budget comparison
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_profit_and_loss_budget_performance($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_last_amount'] = 0;
        $data_return['total_last_budget_amount'] = 0;
        $data_return['total_amount'] = 0;
        $data_return['total_budget_amount'] = 0;

        foreach ($child_account as $val) {
            $data_return['row_index']++;
            $total_amount = $val['amount'];
            $total_budget_amount = $val['budget_amount'];
            $total_last_amount = $val['last_amount'];
            $total_last_budget_amount = $val['last_budget_amount'];

            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>
              <td class="total_amount">
              '.to_currency($val['last_amount'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['last_budget_amount'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['budget_amount'], $currency).'
              </td>
              <td class="total_amount">
              '.to_currency($val['amount'] - $val['budget_amount'], $currency).'
              </td>
            </tr>';

            if(count($val['child_account']) > 0){
                $t = $data_return['total_last_amount'];
                $t_2 = $data_return['total_last_budget_amount'];
                $t_3 = $data_return['total_amount'];
                $t_4 = $data_return['total_budget_amount'];
                $data_return = $this->get_html_profit_and_loss_budget_performance($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_last_amount += $data_return['total_last_amount'];
                $total_last_budget_amount += $data_return['total_last_budget_amount'];
                $total_amount += $data_return['total_amount'];
                $total_budget_amount += $data_return['total_budget_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_last_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_last_budget_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_budget_amount, $currency).'
                  </td>
                  <td class="total_amount">
                  '.to_currency($total_amount - $total_budget_amount, $currency).'
                  </td>
                </tr>';
                $data_return['total_last_amount'] += $t;
                $data_return['total_last_budget_amount'] += $t_2;
                $data_return['total_amount'] += $t_3;
                $data_return['total_budget_amount'] += $t_4;
            }

            $data_return['total_last_amount'] += $val['last_amount'];
            $data_return['total_last_budget_amount'] += $val['last_budget_amount'];
            $data_return['total_amount'] += $val['amount'];
            $data_return['total_budget_amount'] += $val['budget_amount'];
        }
        return $data_return; 
    }

    /**
     * get budget by account
     * @param  integer $company    
     * @param  integer $account_id 
     * @param  integer $year       
     * @return integer            
     */
    public function get_budget_by_account($budget_id, $account_id, $from_date, $to_date){
        $month = date('m', strtotime($from_date));
        $year = date('Y', strtotime($from_date));
        $month_2 = date('m', strtotime($to_date));
        $year_2 = date('Y', strtotime($to_date));
        
        $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
        $db_builder->select('sum(amount) as amount');
        $db_builder->where('account', $account_id);
        $db_builder->where('budget_id', $budget_id);
        
        if($year == $year_2){
            $db_builder->where('((month >= '.$month.' or month <= '.$month_2.') and year = '.$year.')');
        }else{
            $db_builder->where('((month >= '.$month.' and year >= '.$year.' and year < '.$year_2.') or (month <= '.$month_2.' and year > '.$year.' and year <= '.$year_2.'))');
        }

        $data = $db_builder->get()->getRow();

        if($data->amount){
            return $data->amount;
        }else{
            return 0;
        }
    }

    /**
     * get data balance sheet summary recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $accounting_method         
     * @param  integer $acc_report_show_non_zero         
     * @return array                 
     */
    public function get_data_profit_and_loss_budget_performance_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $budget_id, $acc_show_account_numbers){
        $year = date('Y', strtotime($to_date));
        $last_from_date = date('Y-m-01');
        $last_to_date = date('Y-m-t');

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('(date >= "' . $last_from_date . '" and date <= "' . $last_to_date . '")');
            $account_history = $db_builder->get()->getRow();
            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($account_type_id == 11 || $account_type_id == 12){
                $last_amount = $credits - $debits;
            }else{
                $last_amount = $debits - $credits;
            }
            $last_budget_amount = $this->get_budget_by_account($budget_id, $val['id'], $last_from_date, $last_to_date);

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();

            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            $budget_amount = $this->get_budget_by_account($budget_id, $val['id'], $from_date, $to_date);
            if($account_type_id == 11 || $account_type_id == 12){
                $amount = $credits - $debits;
            }else{
                $amount = $debits - $credits;
            }

            $child_account[] = ['name' => $name, 'last_amount' => $last_amount, 'last_budget_amount' => $last_budget_amount, 'amount' => $amount, 'budget_amount' => $budget_amount, 'child_account' => $this->get_data_profit_and_loss_budget_performance_recursive([], $val['id'],$account_type_id, $from_date, $to_date, $accounting_method, $budget_id, $acc_show_account_numbers)];

            
        }

        return $child_account;
    }

    /**
     * get data balance sheet summary recursive
     * @param  array $child_account         
     * @param  integer $account_id      
     * @param  integer $account_type_id 
     * @param  string $from_date       
     * @param  string $to_date         
     * @param  string $accounting_method         
     * @param  integer $acc_report_show_non_zero         
     * @return array                 
     */
    public function get_data_profit_and_loss_budget_vs_actual_recursive($child_account, $account_id, $account_type_id, $from_date, $to_date, $accounting_method, $budget_id, $acc_show_account_numbers){
        $year = date('Y', strtotime($to_date));
        $last_from_date = date('Y-m-01');
        $last_to_date = date('Y-m-t');

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
        foreach ($accounts as $val) {
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('account', $val['id']);
            $db_builder->where('account', $val['id']);
            if($accounting_method == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
            $account_history = $db_builder->get()->getRow();

            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }


            $budget_amount = $this->get_budget_by_account($budget_id, $val['id'], $from_date, $to_date);
            if($account_type_id == 11 || $account_type_id == 12){
                $amount = $credits - $debits;
            }else{
                $amount = $debits - $credits;
            }

            $child_account[] = ['name' => $name, 'amount' => $amount, 'budget_amount' => $budget_amount, 'child_account' => $this->get_data_profit_and_loss_budget_vs_actual_recursive([], $val['id'],$account_type_id, $from_date, $to_date, $accounting_method, $budget_id, $acc_show_account_numbers)];

            
        }

        return $child_account;
    }

     /**
     * delete budget
     * @param integer $id
     * @return boolean
     */

    public function delete_budget($id)
    {
        $db_builder = $this->db->table(get_db_prefix() . 'acc_budgets');
        $db_builder->where('id', $id);
        $db_builder->delete();
        if ($this->db->affectedRows() > 0) {
            $db_builder = $this->db->table(get_db_prefix() . 'acc_budget_details');
            $db_builder->where('budget_id', $id);
            $db_builder->delete();

            return true;
        }
        return false;
    }

    /**
     * { insert batch account }
     *
     * @param        $data   The data
     */
    public function insert_batch_account($data){

        $row_update = 0;
        $row_add = 0;
        $data_sub_account = [];
        $data_update_account = [];
        foreach($data as $key => $val){

            if( get_account_by_name($val['name']) != false){
                $data_update_account[] = $data[$key];
                unset($data[$key]);
            }

            if($val['parent_account'] != '' && get_account_by_name($val['name']) == false){
                $data_sub_account[] = $data[$key];
                unset($data[$key]);
            }
        }

        if(count($data) > 0){
            $row_add = $this->db->insert_batch(get_db_prefix().'acc_accounts',  $data);
        }

        if(count($data_update_account) > 0){
            foreach($data_update_account as $acc){
                $acc_id = get_account_by_name($acc['name']);

                if($acc['parent_account'] != ''){
                    $acc['parent_account'] = $acc['parent_account'];
                }

                $db_builder->where('id', $acc_id);
                $db_builder->update(get_db_prefix().'acc_accounts', $acc);
                if($this->db->affectedRows() > 0){
                    $row_update++;
                }
            }
        }

        foreach($data_sub_account as $sub_acc){
            $acc_id = $sub_acc['parent_account'];
            if($acc_id){
                $db_builder->where('id', $acc_id);
                $account = $db_builder->get(get_db_prefix().'acc_accounts')->getRow();

                $db_builder->insert(get_db_prefix().'acc_accounts',[
                    'account_type_id' => $account->account_type_id,
                    'account_detail_type_id' => $account->account_detail_type_id,
                    'name' => $sub_acc['name'],
                    'parent_account' => $acc_id,
                ]);
                $insert_id = $this->db->insertID();
                if($insert_id){
                    $row_add ++;
                }
            }
        }

        return ['row_updated' => $row_update, 'row_added' => $row_add];
    }

    /**
     * { insert batch budget }
     *
     * @param        $data   The data
     */

    public function insert_batch_budget($data, $budget_id, $import_type){
        $data_insert = [];

        $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
        $db_builder->where('budget_id', $budget_id);
        $db_builder->delete();

        $db_builder = $this->db->table(get_db_prefix().'acc_budgets');
        $db_builder->where('id', $budget_id);
        $budget = $db_builder->get()->getRow();

        $year = $budget->year;

        $acc_first_month_of_financial_year = get_setting('acc_first_month_of_financial_year');

        $from_date = date('Y-m-d', strtotime($acc_first_month_of_financial_year . ' 01 '.$year));
        $to_date = date('Y-m-t', strtotime($from_date . '  - 1 month + 1 year '));

        $month_columns = [];
        $_from_date = $from_date;
        while (strtotime($_from_date) < strtotime($to_date)) {
            $month = date('m', strtotime($_from_date));
            $year = date('Y', strtotime($_from_date));
                
            array_push($month_columns, ['month' => $month, 'year' => $year]);

            $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));

            if(strtotime($_from_date) > strtotime($to_date)){
                $month_2 = date('m', strtotime($to_date));
                $year_2 = date('Y', strtotime($to_date));

                if($month != $month_2){
                    array_push($month_columns, ['month' => $month_2, 'year' => $year_2]);
                }
            }
        }

        $quarter_columns = [];
        $_from_date = $from_date;
        while (strtotime($_from_date) <= strtotime($to_date)) {
            $month = date('m', strtotime($_from_date));
            $year = date('Y', strtotime($_from_date));

            if($month>=1 && $month<=3)
            {
                $t = 'quarter_1';
            }
            else  if($month>=4 && $month<=6)
            {
                $t = 'quarter_2';
            }
            else  if($month>=7 && $month<=9)
            {
                $t = 'quarter_3';
            }
            else  if($month>=10 && $month<=12)
            {
                $t = 'quarter_4';
            }

            if(!in_array($t, $quarter_columns)){
                array_push($quarter_columns, $t);
            }

            $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
        }

        foreach($data as $value){
            $account = $value['account'];

            if($import_type == 'month'){


                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_1'], 'year' => $month_columns[0]['year'], 'account' => $account, 'month' => $month_columns[0]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_2'], 'year' => $month_columns[1]['year'], 'account' => $account, 'month' => $month_columns[1]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_3'], 'year' => $month_columns[2]['year'], 'account' => $account, 'month' => $month_columns[2]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_4'], 'year' => $month_columns[3]['year'], 'account' => $account, 'month' => $month_columns[3]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_5'], 'year' => $month_columns[4]['year'], 'account' => $account, 'month' => $month_columns[4]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_6'], 'year' => $month_columns[5]['year'], 'account' => $account, 'month' => $month_columns[5]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_7'], 'year' => $month_columns[6]['year'], 'account' => $account, 'month' => $month_columns[6]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_8'], 'year' => $month_columns[7]['year'], 'account' => $account, 'month' => $month_columns[7]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_9'], 'year' => $month_columns[8]['year'], 'account' => $account, 'month' => $month_columns[8]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_10'], 'year' => $month_columns[9]['year'], 'account' => $account, 'month' => $month_columns[9]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_11'], 'year' => $month_columns[10]['year'], 'account' => $account, 'month' => $month_columns[10]['month']];
                $data_insert[] = ['budget_id' => $budget_id, 'amount' => $value['month_12'], 'year' => $month_columns[11]['year'], 'account' => $account, 'month' => $month_columns[11]['month']];

            }elseif($import_type == 'quarter'){

                $_value = $value;
                $value['quarter_1'] = $_value['quarter_1'];
                $value['quarter_2'] = $_value['quarter_2'];
                $value['quarter_3'] = $_value['quarter_3'];
                $value['quarter_4'] = $_value['quarter_4'];

                if($value['quarter_1'] > 0)
                {
                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    $total_month = 0;
                    $end_month = 0;

                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));

                        if($_month>=1 && $_month<=3)
                        {
                            $total_month += 1;
                            $end_month = $_month;
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }

                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));
                        $key = $_month-1;
                        if($_month>=1 && $_month<=3)
                        {
                            $value_1 = round($value['quarter_1']/$total_month);
                            if($total_month > 1){
                                $value_2 = $value['quarter_1'] - ($value_1*($total_month - 1));
                            }else{
                                $value_2 = $value['quarter_1'];
                            }

                            if($end_month == $_month){
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_2];
                            }else{
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_1];
                            }
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }
                }
                if($value['quarter_2'] > 0)
                {
                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    $total_month = 0;
                    $end_month = 0;

                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));

                        if($_month>=4 && $_month<=6)
                        {
                            $total_month += 1;
                            $end_month = $_month;
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }

                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));
                        $key = $_month-1;

                        if($_month>=4 && $_month<=6)
                        {
                            $value_1 = round($value['quarter_2']/$total_month);
                            if($total_month > 1){
                                $value_2 = $value['quarter_2'] - ($value_1*($total_month - 1));
                            }else{
                                $value_2 = $value_1;
                            }

                            if($end_month == $_month){
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_2];
                            }else{
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_1];
                            }
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }
                }
                if($value['quarter_3'] > 0)
                {
                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    $total_month = 0;
                    $end_month = 0;

                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));

                        if($_month>=7 && $_month<=9)
                        {
                            $total_month += 1;
                            $end_month = $_month;
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }

                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));
                        $key = $_month-1;

                        if($_month>=7 && $_month<=9)
                        {
                            $value_1 = round($value['quarter_3']/$total_month);
                            if($total_month > 1){
                                $value_2 = $value['quarter_3'] - ($value_1*($total_month - 1));
                            }else{
                                $value_2 = $value_1;
                            }

                            if($end_month == $_month){
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_2];
                            }else{
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_1];
                            }
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }
                }
                if($value['quarter_4'] > 0)
                {
                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    $total_month = 0;
                    $end_month = 0;

                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));

                        if($_month>=10 && $_month<=12)
                        {
                            $total_month += 1;
                            $end_month = $_month;
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }

                    $_from_date = $from_date;
                    $_to_date = $to_date;
                    while (strtotime($_from_date) <= strtotime($_to_date)) {
                        $_month = date('m', strtotime($_from_date));
                        $_year = date('Y', strtotime($_from_date));
                        $key = $_month-1;

                        if($_month>=10 && $_month<=12)
                        {
                            $value_1 = round($value['quarter_4']/$total_month);
                            if($total_month > 1){
                                $value_2 = $value['quarter_4'] - ($value_1*($total_month - 1));
                            }else{
                                $value_2 = $value_1;
                            }

                            if($end_month == $_month){
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_2];
                            }else{
                                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[$key]['month'], 'year' => $month_columns[$key]['year'], 'account' => $account, 'amount' => $value_1];
                            }
                        }

                        $_from_date = date('Y-m-d', strtotime('+1 month', strtotime($_from_date)));
                    }
                }

            }elseif($import_type == 'year'){
                $value_1 = round($value['amount']/12);
                $value_2 = $value['amount'] - ($value_1*11);

                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[0]['month'], 'year' =>$month_columns[0]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[1]['month'], 'year' =>$month_columns[1]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[2]['month'], 'year' =>$month_columns[2]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[3]['month'], 'year' =>$month_columns[3]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[4]['month'], 'year' =>$month_columns[4]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[5]['month'], 'year' =>$month_columns[5]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[6]['month'], 'year' =>$month_columns[6]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[7]['month'], 'year' =>$month_columns[7]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[8]['month'], 'year' =>$month_columns[8]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[9]['month'], 'year' =>$month_columns[9]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[10]['month'], 'year' =>$month_columns[10]['year'], 'account' => $account, 'amount' => $value_1];
                $data_insert[] = ['budget_id' => $budget_id, 'month' => $month_columns[11]['month'], 'year' =>$month_columns[11]['year'], 'account' => $account, 'amount' => $value_2];
            }
        }

        if(count($data_insert) > 0){
            $db_builder = $this->db->table(get_db_prefix().'acc_budget_details');
            $affectedRows = $db_builder->insertBatch($data_insert);
        }

        return true;
    }

    /**
     * get html profit and loss
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_custom_summary_report($child_account, $data_return, $parent_index, $currency){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {
            $data_return['row_index']++;
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
            <td>
            '.$val['name'].'
            </td>';
            $total = 0;
            foreach($val['amount'] as $amount){
                $data_return['html'] .= '
                <td class="total_amount">
                '.to_currency($amount, $currency->name).'
                </td>';
                $total += $amount;

            }
            $total_amount = $total;
            $data_return['html'] .= '
            <td class="total_amount">
            '.to_currency($total_amount, $currency->name).'
            </td>';
            $data_return['html'] .= '</tr>';
            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_custom_summary_report($val['child_account'], $data_return, $data_return['row_index'], $currency);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                <td>
                '.app_lang('total_for', $val['name']).'
                </td>';
                foreach($val['amount'] as $amount){
                    $data_return['html'] .= '
                    <td class="total_amount"></td>';

                }
                $data_return['html'] .= '<td class="total_amount">
                '.to_currency($total_amount, $currency->name).'
                </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $total;
        }
        return $data_return; 
    }

    /**
     * get data custom summary report
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_custom_summary_report_by_customer($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $display_rows_by = 'income_statement';
        $display_columns_by = 'total_only';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['display_rows_by'])){
            $display_rows_by = $data_filter['display_rows_by'];
        }

        if(isset($data_filter['display_columns_by'])){
            $display_columns_by = $data_filter['display_columns_by'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];

        $clients = $this->clients_model->get();
        $headers = [];

        foreach ($clients as $key => $value) {
            $columns = [];
            switch ($display_columns_by) {
                case 'total_only':
                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('customer', $value['userid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('customer', $value['userid']);
                    
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'months':
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('customer', $value['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('customer', $value['userid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                        $month = strtotime("+1 month", $month);
                    }
                  break;

                case 'quarters':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $month = date('m', $start);
                        $year = date('Y', $start);
                        if($month>=1 && $month<=3)
                        {
                            $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                        }
                        else  if($month>=4 && $month<=6)
                        {
                            $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                        }
                        else  if($month>=7 && $month<=9)
                        {
                            $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                        }
                        else  if($month>=10 && $month<=12)
                        {
                            $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                        }

                        $custom_date_select = '(date BETWEEN "' .
                        $start_date .
                        '" AND "' .
                        $end_date . '")';

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('customer', $value['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('customer', $value['userid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                       

                        $start = strtotime('+3 month', $start);

                        if($start > $end){
                            $month_2 = date('m', $start);
                            $year_2 = date('Y', $start);
                            
                            if($month_2>=1 && $month_2<=3)
                            {
                                $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                            }
                            else  if($month_2>=4 && $month_2<=6)
                            {
                                $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                            }
                            else  if($month_2>=7 && $month_2<=9)
                            {
                                $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                            }
                            else  if($month_2>=10 && $month_2<=12)
                            {
                                $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                            }

                            if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('customer', $value['userid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('customer', $value['userid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'years':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $year = date('Y', $start);

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('customer', $value['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('customer', $value['userid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;

                        $start = strtotime('+1 year', $start);

                        if($start > $end){
                            $year_2 = date('Y', $end);
                      
                            if($year != $year_2){
                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('customer', $value['userid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('customer', $value['userid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'vendors':
                    $this->load->model('purchase/purchase_model');
                    $vendors = $this->purchase_model->get_vendor();
                    foreach ($vendors as $key => $vendor) {
                        $columns[] = 0;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('customer', $value['userid']);
                    $db_builder->where('(vendor = 0 or vendor is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('customer', $value['userid']);
                    $db_builder->where('(vendor = 0 or vendor is null)');
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'employees':
                  $this->load->model('staff_model');
                  $staffs = $this->staff_model->get();
                  foreach ($staffs as $key => $staff) {
                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('customer', $value['userid']);
                    $db_builder->where('addedfrom', $staff['staffid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('customer', $value['userid']);
                    $db_builder->where('addedfrom', $staff['staffid']);
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  }
                  break;

                case 'product_service':
                    $this->load->model('invoice_items_model');
                    $items = $this->invoice_items_model->get();
                    foreach ($items as $key => $item) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('customer', $value['userid']);
                        $db_builder->where('item', $item['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('customer', $value['userid']);
                        $db_builder->where('item', $item['itemid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('customer', $value['userid']);
                    $db_builder->where('(item = 0 or item is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('customer', $value['userid']);
                    $db_builder->where('(item = 0 or item is null)');
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                    break;
                default:
                  // code...
                  break;
            }

            $data_report[] = ['name' => $value['company'], 'columns' => $columns];
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'display_rows_by' => $display_rows_by, 'display_columns_by' => $display_columns_by];
    }

    /**
     * get data custom summary report
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_custom_summary_report_by_income_statement($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $display_rows_by = 'income_statement';
        $display_columns_by = 'total_only';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['display_rows_by'])){
            $display_rows_by = $data_filter['display_rows_by'];
        }

        if(isset($data_filter['display_columns_by'])){
            $display_columns_by = $data_filter['display_columns_by'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];

        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    $columns = [];
                    switch ($display_columns_by) {
                        case 'total_only':
                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;

                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          break;

                        case 'months':
                            $start = $month = strtotime($from_date);
                            $end = strtotime($to_date);

                            while($month < $end)
                            {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;

                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }

                                $month = strtotime("+1 month", $month);
                            }
                          break;

                        case 'quarters':
                            $start = strtotime($from_date);
                            $end = strtotime($to_date);

                            while ($start < $end) {
                                $month = date('m', $start);
                                $year = date('Y', $start);
                                if($month>=1 && $month<=3)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                                }
                                else  if($month>=4 && $month<=6)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                                }
                                else  if($month>=7 && $month<=9)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                                }
                                else  if($month>=10 && $month<=12)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                                }

                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }

                                $start = strtotime('+3 month', $start);

                                if($start > $end){
                                    $month_2 = date('m', $start);
                                    $year_2 = date('Y', $start);
                                    
                                    if($month_2>=1 && $month_2<=3)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                                    }
                                    else  if($month_2>=4 && $month_2<=6)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                                    }
                                    else  if($month_2>=7 && $month_2<=9)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                                    }
                                    else  if($month_2>=10 && $month_2<=12)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                                    }

                                    if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                        $custom_date_select = '(date BETWEEN "' .
                                        $start_date .
                                        '" AND "' .
                                        $end_date . '")';

                                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                        $db_builder->where('account', $val['id']);
                                        if($accounting_method == 'cash'){
                                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                        }
                                        $db_builder->where($custom_date_select);
                                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                        $debits = $account_history->debit != '' ? $account_history->debit : 0;

                                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                            $columns[] = $credits - $debits;
                                        }else{
                                            $columns[] = $debits - $credits;
                                        }
                                    }
                                }
                            }
                            break;

                        case 'years':
                            $start = strtotime($from_date);
                            $end = strtotime($to_date);

                            while ($start < $end) {
                                $year = date('Y', $start);

                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('year(date) = "' . $year . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }

                                $start = strtotime('+1 year', $start);

                                if($start > $end){
                                    $year_2 = date('Y', $end);
                              
                                    if($year != $year_2){
                                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                        $db_builder->where('account', $val['id']);
                                        if($accounting_method == 'cash'){
                                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                        }
                                        $db_builder->where('year(date) = "' . $year_2 . '"');
                                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                        
                                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                            $columns[] = $credits - $debits;
                                        }else{
                                            $columns[] = $debits - $credits;
                                        }
                                    }
                                }
                            }
                            break;
                        case 'customers':
                            $this->load->model('clients_model');
                            $clients = $this->clients_model->get();
                            foreach ($clients as $key => $client) {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('customer', $client['userid']);
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }

                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('(customer = 0 or customer is null)');
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          break;

                        case 'vendors':
                            $this->load->model('purchase/purchase_model');
                            $vendors = $this->purchase_model->get_vendor();
                            foreach ($vendors as $key => $vendor) {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                $db_builder->where('vendor', $vendor['userid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }

                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('(vendor = 0 or vendor is null)');
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          break;

                        case 'employees':
                          $this->load->model('staff_model');
                          $staffs = $this->staff_model->get();
                          foreach ($staffs as $key => $staff) {
                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('addedfrom', $staff['staffid']);
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          }
                          break;

                        case 'product_service':
                            $this->load->model('invoice_items_model');
                            $items = $this->invoice_items_model->get();
                            foreach ($items as $key => $item) {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                $db_builder->where('item', $item['itemid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }
                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('(item = 0 or item is null)');
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                            
                            break;
                        default:
                          // code...
                          break;
                    }

                    $child_account = $this->get_data_custom_summary_report_by_income_statement_recursive([
                        'child_account' => [],
                        'account_id' => $val['id'],
                        'account_type_id' => $value['account_type_id'],
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'accounting_method' => $accounting_method,
                        'acc_show_account_numbers' => $acc_show_account_numbers,
                        'display_rows_by' => $display_rows_by,
                        'display_columns_by' => $display_columns_by,
                    ]);

                    $data_report[$data_key][] = ['name' => $name, 'columns' => $columns, 'child_account' => $child_account];
                }
            }
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'display_rows_by' => $display_rows_by, 'display_columns_by' => $display_columns_by];
    }

    /**
     * get data custom summary report
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_custom_summary_report_by_employees($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $display_rows_by = 'income_statement';
        $display_columns_by = 'total_only';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['display_rows_by'])){
            $display_rows_by = $data_filter['display_rows_by'];
        }

        if(isset($data_filter['display_columns_by'])){
            $display_columns_by = $data_filter['display_columns_by'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];

        $staffs = $this->staff_model->get();
        $headers = [];

        foreach ($staffs as $key => $value) {
            $columns = [];
            switch ($display_columns_by) {
                case 'total_only':
                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'months':
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                        $month = strtotime("+1 month", $month);
                    }
                  break;

                case 'quarters':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $month = date('m', $start);
                        $year = date('Y', $start);
                        if($month>=1 && $month<=3)
                        {
                            $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                        }
                        else  if($month>=4 && $month<=6)
                        {
                            $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                        }
                        else  if($month>=7 && $month<=9)
                        {
                            $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                        }
                        else  if($month>=10 && $month<=12)
                        {
                            $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                        }

                        $custom_date_select = '(date BETWEEN "' .
                        $start_date .
                        '" AND "' .
                        $end_date . '")';

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                       

                        $start = strtotime('+3 month', $start);

                        if($start > $end){
                            $month_2 = date('m', $start);
                            $year_2 = date('Y', $start);
                            
                            if($month_2>=1 && $month_2<=3)
                            {
                                $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                            }
                            else  if($month_2>=4 && $month_2<=6)
                            {
                                $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                            }
                            else  if($month_2>=7 && $month_2<=9)
                            {
                                $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                            }
                            else  if($month_2>=10 && $month_2<=12)
                            {
                                $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                            }

                            if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('addedfrom', $value['staffid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('addedfrom', $value['staffid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'years':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $year = date('Y', $start);

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;

                        $start = strtotime('+1 year', $start);

                        if($start > $end){
                            $year_2 = date('Y', $end);
                      
                            if($year != $year_2){
                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('addedfrom', $value['staffid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('addedfrom', $value['staffid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'vendors':
                    $this->load->model('purchase/purchase_model');
                    $vendors = $this->purchase_model->get_vendor();
                    foreach ($vendors as $key => $vendor) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        $db_builder->where('vendor', $vendor['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        $db_builder->where('vendor', $vendor['userid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'customers':
                    $this->load->model('clients_model');
                    $clients = $this->clients_model->get();
                    foreach ($clients as $key => $client) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        $db_builder->where('customer', $client['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        $db_builder->where('customer', $client['userid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    $db_builder->where('(customer = 0 or customer is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    $db_builder->where('(customer = 0 or customer is null)');
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;

                  break;

                case 'product_service':
                    $this->load->model('invoice_items_model');
                    $items = $this->invoice_items_model->get();
                    foreach ($items as $key => $item) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        $db_builder->where('item', $item['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('addedfrom', $value['staffid']);
                        $db_builder->where('item', $item['itemid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    $db_builder->where('(item = 0 or item is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('addedfrom', $value['staffid']);
                    $db_builder->where('(item = 0 or item is null)');
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                    break;
                default:
                  // code...
                  break;
            }

            $data_report[] = ['name' => $value['full_name'], 'columns' => $columns];
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'display_rows_by' => $display_rows_by, 'display_columns_by' => $display_columns_by];
    }

    /**
     * get data custom summary report
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_custom_summary_report_by_vendors($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $display_rows_by = 'income_statement';
        $display_columns_by = 'total_only';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['display_rows_by'])){
            $display_rows_by = $data_filter['display_rows_by'];
        }

        if(isset($data_filter['display_columns_by'])){
            $display_columns_by = $data_filter['display_columns_by'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];

        $this->load->model('purchase/purchase_model');
        $vendors = $this->purchase_model->get_vendor();

        $headers = [];

        foreach ($vendors as $key => $value) {
            $columns = [];
            switch ($display_columns_by) {
                case 'total_only':
                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('vendor', $value['userid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('vendor', $value['userid']);
                    
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'months':
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('vendor', $value['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('vendor', $value['userid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                        $month = strtotime("+1 month", $month);
                    }
                  break;

                case 'quarters':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $month = date('m', $start);
                        $year = date('Y', $start);
                        if($month>=1 && $month<=3)
                        {
                            $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                        }
                        else  if($month>=4 && $month<=6)
                        {
                            $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                        }
                        else  if($month>=7 && $month<=9)
                        {
                            $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                        }
                        else  if($month>=10 && $month<=12)
                        {
                            $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                        }

                        $custom_date_select = '(date BETWEEN "' .
                        $start_date .
                        '" AND "' .
                        $end_date . '")';

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('vendor', $value['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('vendor', $value['userid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                       

                        $start = strtotime('+3 month', $start);

                        if($start > $end){
                            $month_2 = date('m', $start);
                            $year_2 = date('Y', $start);
                            
                            if($month_2>=1 && $month_2<=3)
                            {
                                $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                            }
                            else  if($month_2>=4 && $month_2<=6)
                            {
                                $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                            }
                            else  if($month_2>=7 && $month_2<=9)
                            {
                                $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                            }
                            else  if($month_2>=10 && $month_2<=12)
                            {
                                $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                            }

                            if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('vendor', $value['userid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('vendor', $value['userid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'years':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $year = date('Y', $start);

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('vendor', $value['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('vendor', $value['userid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;

                        $start = strtotime('+1 year', $start);

                        if($start > $end){
                            $year_2 = date('Y', $end);
                      
                            if($year != $year_2){
                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('vendor', $value['userid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('vendor', $value['userid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'customers':
                    $this->load->model('clients_model');
                    $clients = $this->clients_model->get();
                    foreach ($clients as $key => $client) {
                        $columns[] = 0;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('vendor', $value['userid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('vendor', $value['userid']);
                    
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'employees':
                  $this->load->model('staff_model');
                  $staffs = $this->staff_model->get();
                  foreach ($staffs as $key => $staff) {
                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('vendor', $value['userid']);
                    $db_builder->where('addedfrom', $staff['staffid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('vendor', $value['userid']);
                    $db_builder->where('addedfrom', $staff['staffid']);
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  }
                  break;

                case 'product_service':
                    $this->load->model('invoice_items_model');
                    $items = $this->invoice_items_model->get();
                    foreach ($items as $key => $item) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('vendor', $value['userid']);
                        $db_builder->where('item', $item['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('vendor', $value['userid']);
                        $db_builder->where('item', $item['itemid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('vendor', $value['userid']);
                    $db_builder->where('(item = 0 or item is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('vendor', $value['userid']);
                    $db_builder->where('(item = 0 or item is null)');
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                    break;
                default:
                  // code...
                  break;
            }

            $data_report[] = ['name' => $value['company'], 'columns' => $columns];
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'display_rows_by' => $display_rows_by, 'display_columns_by' => $display_columns_by];
    }

    /**
     * get data custom summary report
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_custom_summary_report_by_product_service($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $display_rows_by = 'income_statement';
        $display_columns_by = 'total_only';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['display_rows_by'])){
            $display_rows_by = $data_filter['display_rows_by'];
        }

        if(isset($data_filter['display_columns_by'])){
            $display_columns_by = $data_filter['display_columns_by'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];

        $this->load->model('invoice_items_model');
        $items = $this->invoice_items_model->get();

        $headers = [];

        foreach ($items as $key => $value) {
            $columns = [];
            switch ($display_columns_by) {
                case 'total_only':
                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('item', $value['itemid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('item', $value['itemid']);
                    
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'months':
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('item', $value['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('item', $value['itemid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                        $month = strtotime("+1 month", $month);
                    }
                  break;

                case 'quarters':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $month = date('m', $start);
                        $year = date('Y', $start);
                        if($month>=1 && $month<=3)
                        {
                            $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                        }
                        else  if($month>=4 && $month<=6)
                        {
                            $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                        }
                        else  if($month>=7 && $month<=9)
                        {
                            $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                        }
                        else  if($month>=10 && $month<=12)
                        {
                            $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                        }

                        $custom_date_select = '(date BETWEEN "' .
                        $start_date .
                        '" AND "' .
                        $end_date . '")';

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('item', $value['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('item', $value['itemid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where($custom_date_select);
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                       

                        $start = strtotime('+3 month', $start);

                        if($start > $end){
                            $month_2 = date('m', $start);
                            $year_2 = date('Y', $start);
                            
                            if($month_2>=1 && $month_2<=3)
                            {
                                $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                            }
                            else  if($month_2>=4 && $month_2<=6)
                            {
                                $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                            }
                            else  if($month_2>=7 && $month_2<=9)
                            {
                                $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                            }
                            else  if($month_2>=10 && $month_2<=12)
                            {
                                $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                            }

                            if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('item', $value['itemid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('item', $value['itemid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where($custom_date_select);
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'years':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $year = date('Y', $start);

                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('item', $value['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('item', $value['itemid']);
                        
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;

                        $start = strtotime('+1 year', $start);

                        if($start > $end){
                            $year_2 = date('Y', $end);
                      
                            if($year != $year_2){
                                $db_builder->select('sum(credit) as credit');
                                $db_builder->where('item', $value['itemid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('rel_type != "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $db_builder->select('sum(debit) as debit');
                                $db_builder->where('item', $value['itemid']);
                                
                                $db_builder->where('rel_type = "expense"');
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                                $columns[] = $credits - $debits;
                            }
                        }
                    }
                    break;

                case 'vendors':
                    $this->load->model('purchase/purchase_model');
                    $vendors = $this->purchase_model->get_vendor();
                    foreach ($vendors as $key => $vendor) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('item', $value['itemid']);
                        $db_builder->where('vendor', $vendor['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('item', $value['itemid']);
                        $db_builder->where('vendor', $vendor['userid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('item', $value['itemid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('rel_type != "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('item', $value['itemid']);
                    
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;
                  break;

                case 'customers':
                    $this->load->model('clients_model');
                    $clients = $this->clients_model->get();
                    foreach ($clients as $key => $client) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('item', $value['itemid']);
                        $db_builder->where('customer', $client['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('item', $value['itemid']);
                        $db_builder->where('customer', $client['userid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }

                    $db_builder->select('sum(credit) as credit');
                    $db_builder->where('item', $value['itemid']);
                    $db_builder->where('(customer = 0 or customer is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $db_builder->where('rel_type != "expense"');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $db_builder->select('sum(debit) as debit');
                    $db_builder->where('item', $value['itemid']);
                    $db_builder->where('(customer = 0 or customer is null)');
                    $db_builder->where('rel_type = "expense"');
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                    $columns[] = $credits - $debits;

                  break;

                case 'employees':
                    $this->load->model('staff_model');
                    $staffs = $this->staff_model->get();
                    foreach ($staffs as $key => $staff) {
                        $db_builder->select('sum(credit) as credit');
                        $db_builder->where('item', $value['itemid']);
                        $db_builder->where('addedfrom', $staff['staffid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('rel_type != "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $db_builder->select('sum(debit) as debit');
                        $db_builder->where('item', $value['itemid']);
                        $db_builder->where('addedfrom', $staff['staffid']);
                        $db_builder->where('rel_type = "expense"');
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history_2 = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history_2->debit != '' ? $account_history_2->debit : 0;
                        $columns[] = $credits - $debits;
                    }
                  break;
                default:
                  // code...
                  break;
            }

            $data_report[] = ['name' => $value['description'], 'columns' => $columns];
        }

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'display_rows_by' => $display_rows_by, 'display_columns_by' => $display_columns_by];
    }

    /**
     * get html custom summary
     * @param  array $child_account 
     * @param  array $data_return   
     * @param  integer $parent_index  
     * @param  object $currency      
     * @return array               
     */
    public function get_html_custom_summary_by_income_statement($child_account, $data_return, $parent_index, $currency, $display_columns_by){
        $total_amount = 0;
        $data_return['total_amount'] = 0;
        foreach ($child_account as $val) {

            $data_return['row_index']++;
            $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' expanded">
              <td>
              '.$val['name'].'
              </td>';
            $amount = 0;
            $total_amount = $amount;
            $html_column = '';

            foreach($val['columns'] as $column){
                $amount += $column;
                $html_column .= '<td></td>';
                $data_return['html'] .= '<td class="total_amount">'.to_currency($column, $currency->name).'</td>';
            }
            if ($display_columns_by != 'total_only') {
                $data_return['html'] .= '<td class="total_amount">
                  '.to_currency($amount, $currency->name).'
                  </td>
                </tr>';
            }

            if(count($val['child_account']) > 0){
                $t = $data_return['total_amount'];
                $data_return = $this->get_html_custom_summary_by_income_statement($val['child_account'], $data_return, $data_return['row_index'], $currency, $display_columns_by);

                $total_amount += $data_return['total_amount'];
                
                $data_return['row_index']++;
                $data_return['html'] .= '<tr class="treegrid-'.$data_return['row_index'].' '.($parent_index != 0 ? 'treegrid-parent-'.$parent_index : '').' tr_total">
                  <td>
                  '.app_lang('total_for', $val['name']).'
                  </td>';
                    if ($display_columns_by != 'total_only') {
                        $data_return['html'] .= $html_column;
                    }
                $data_return['html'] .= '<td class="total_amount">
                  '.to_currency($total_amount, $currency->name).'
                  </td>
                </tr>';
                $data_return['total_amount'] += $t;
            }

            $data_return['total_amount'] += $amount;
        }
        return $data_return; 
    }

    /**
     * get data custom summary recursive
     * @param  array $data         
     * @return array                 
     */
    public function get_data_custom_summary_report_by_income_statement_recursive($data){
        $child_account = $data['child_account'];
        $account_id = $data['account_id'];
        $account_type_id = $data['account_type_id'];
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $accounting_method = $data['accounting_method'];
        $acc_show_account_numbers = $data['acc_show_account_numbers'];
        $display_rows_by = $data['display_rows_by'];
        $display_columns_by = $data['display_columns_by'];

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
       
        foreach ($accounts as $val) {
            $columns = [];
            switch ($display_columns_by) {
                case 'total_only':
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    if($account_type_id == 11 || $account_type_id == 12){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  break;

                case 'months':
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;

                        if($account_type_id == 11 || $account_type_id == 12){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }

                        $month = strtotime("+1 month", $month);
                    }
                  break;

                case 'quarters':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $month = date('m', $start);
                        $year = date('Y', $start);
                        if($month>=1 && $month<=3)
                        {
                            $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                        }
                        else  if($month>=4 && $month<=6)
                        {
                            $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                        }
                        else  if($month>=7 && $month<=9)
                        {
                            $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                        }
                        else  if($month>=10 && $month<=12)
                        {
                            $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                        }

                        $custom_date_select = '(date BETWEEN "' .
                        $start_date .
                        '" AND "' .
                        $end_date . '")';

                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where($custom_date_select);
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }

                        $start = strtotime('+3 month', $start);

                        if($start > $end){
                            $month_2 = date('m', $start);
                            $year_2 = date('Y', $start);
                            
                            if($month_2>=1 && $month_2<=3)
                            {
                                $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                            }
                            else  if($month_2>=4 && $month_2<=6)
                            {
                                $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                            }
                            else  if($month_2>=7 && $month_2<=9)
                            {
                                $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                            }
                            else  if($month_2>=10 && $month_2<=12)
                            {
                                $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                            }

                            if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;

                                if($account_type_id == 11 || $account_type_id == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }
                        }
                    }
                    break;

                case 'years':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $year = date('Y', $start);

                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }

                        $start = strtotime('+1 year', $start);

                        if($start > $end){
                            $year_2 = date('Y', $end);
                      
                            if($year != $year_2){
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($account_type_id == 11 || $account_type_id == 12){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }
                        }
                    }
                    break;
                case 'customers':
                    $this->load->model('clients_model');
                    $clients = $this->clients_model->get();
                    foreach ($clients as $key => $client) {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('customer', $client['userid']);
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }
                    }

                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('(customer = 0 or customer is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  break;

                case 'vendors':
                    $this->load->model('purchase/purchase_model');
                    $vendors = $this->purchase_model->get_vendor();
                    foreach ($vendors as $key => $vendor) {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        $db_builder->where('vendor', $vendor['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }
                    }

                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('(vendor = 0 or vendor is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  break;

                case 'employees':
                  $this->load->model('staff_model');
                  $staffs = $this->staff_model->get();
                  foreach ($staffs as $key => $staff) {
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('addedfrom', $staff['staffid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  }
                  break;

                case 'product_service':
                    $this->load->model('invoice_items_model');
                    $items = $this->invoice_items_model->get();
                    foreach ($items as $key => $item) {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        $db_builder->where('item', $item['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }
                    }
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('(item = 0 or item is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                    
                    break;
                default:
                  // code...
                  break;
            }
            
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            $child_account[] = ['name' => $name, 'columns' => $columns, 'child_account' => $this->get_data_custom_summary_report_by_income_statement_recursive([
                        'child_account' => [],
                        'account_id' => $val['id'],
                        'account_type_id' => $account_type_id,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'accounting_method' => $accounting_method,
                        'acc_show_account_numbers' => $acc_show_account_numbers,
                        'display_rows_by' => $display_rows_by,
                        'display_columns_by' => $display_columns_by,
                    ])];
            
        }

        return $child_account;
    }

    /**
     * get data custom summary report
     * @param  array $data_filter 
     * @return array           
     */
    public function get_data_custom_summary_report_by_balance_sheet($data_filter){
        
        $acc_show_account_numbers = get_setting('acc_show_account_numbers');

        $from_date = date('Y-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'cash';
        $display_rows_by = 'income_statement';
        $display_columns_by = 'total_only';

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date'])){
            $from_date = $data_filter['from_date'];
        }

        if(isset($data_filter['to_date'])){
            $to_date = $data_filter['to_date'];
        }

        if(isset($data_filter['display_rows_by'])){
            $display_rows_by = $data_filter['display_rows_by'];
        }

        if(isset($data_filter['display_columns_by'])){
            $display_columns_by = $data_filter['display_columns_by'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];

        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 1){
                $data_accounts['accounts_receivable'][] = $value;
            }
            if($value['account_type_id'] == 2){
                $data_accounts['current_assets'][] = $value;
            }
            if($value['account_type_id'] == 3){
                $data_accounts['cash_and_cash_equivalents'][] = $value;
            }
            if($value['account_type_id'] == 4){
                $data_accounts['fixed_assets'][] = $value;
            }
            if($value['account_type_id'] == 5){
                $data_accounts['non_current_assets'][] = $value;
            }
            if($value['account_type_id'] == 6){
                $data_accounts['accounts_payable'][] = $value;
            }
            if($value['account_type_id'] == 7){
                $data_accounts['credit_card'][] = $value;
            }
            if($value['account_type_id'] == 8){
                $data_accounts['current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 9){
                $data_accounts['non_current_liabilities'][] = $value;
            }
            if($value['account_type_id'] == 10){
                $data_accounts['owner_equity'][] = $value;
            }

            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 12){
                $data_accounts['other_income'][] = $value;
            }

            if($value['account_type_id'] == 13){
                $data_accounts['cost_of_sales'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }

            if($value['account_type_id'] == 15){
                $data_accounts['other_expenses'][] = $value;
            }
        }

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = [];
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                        $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                    }else{
                        $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                    }

                    $columns = [];
                    switch ($display_columns_by) {
                        case 'total_only':
                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;

                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          break;

                        case 'months':
                            $start = $month = strtotime($from_date);
                            $end = strtotime($to_date);

                            while($month < $end)
                            {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;

                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }

                                $month = strtotime("+1 month", $month);
                            }
                          break;

                        case 'quarters':
                            $start = strtotime($from_date);
                            $end = strtotime($to_date);

                            while ($start < $end) {
                                $month = date('m', $start);
                                $year = date('Y', $start);
                                if($month>=1 && $month<=3)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                                }
                                else  if($month>=4 && $month<=6)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                                }
                                else  if($month>=7 && $month<=9)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                                }
                                else  if($month>=10 && $month<=12)
                                {
                                    $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                                    $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                                }

                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }

                                $start = strtotime('+3 month', $start);

                                if($start > $end){
                                    $month_2 = date('m', $start);
                                    $year_2 = date('Y', $start);
                                    
                                    if($month_2>=1 && $month_2<=3)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                                    }
                                    else  if($month_2>=4 && $month_2<=6)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                                    }
                                    else  if($month_2>=7 && $month_2<=9)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                                    }
                                    else  if($month_2>=10 && $month_2<=12)
                                    {
                                        $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                        $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                                    }

                                    if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                        $custom_date_select = '(date BETWEEN "' .
                                        $start_date .
                                        '" AND "' .
                                        $end_date . '")';

                                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                        $db_builder->where('account', $val['id']);
                                        if($accounting_method == 'cash'){
                                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                        }
                                        $db_builder->where($custom_date_select);
                                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                        $debits = $account_history->debit != '' ? $account_history->debit : 0;

                                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                            $columns[] = $credits - $debits;
                                        }else{
                                            $columns[] = $debits - $credits;
                                        }
                                    }
                                }
                            }
                            break;

                        case 'years':
                            $start = strtotime($from_date);
                            $end = strtotime($to_date);

                            while ($start < $end) {
                                $year = date('Y', $start);

                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('year(date) = "' . $year . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }

                                $start = strtotime('+1 year', $start);

                                if($start > $end){
                                    $year_2 = date('Y', $end);
                              
                                    if($year != $year_2){
                                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                        $db_builder->where('account', $val['id']);
                                        if($accounting_method == 'cash'){
                                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                        }
                                        $db_builder->where('year(date) = "' . $year_2 . '"');
                                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                        
                                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                            $columns[] = $credits - $debits;
                                        }else{
                                            $columns[] = $debits - $credits;
                                        }
                                    }
                                }
                            }
                            break;
                        case 'customers':
                            $this->load->model('clients_model');
                            $clients = $this->clients_model->get();
                            foreach ($clients as $key => $client) {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('customer', $client['userid']);
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }

                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('(customer = 0 or customer is null)');
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          break;

                        case 'vendors':
                            $this->load->model('purchase/purchase_model');
                            $vendors = $this->purchase_model->get_vendor();
                            foreach ($vendors as $key => $vendor) {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                $db_builder->where('vendor', $vendor['userid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }

                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('(vendor = 0 or vendor is null)');
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          break;

                        case 'employees':
                          $this->load->model('staff_model');
                          $staffs = $this->staff_model->get();
                          foreach ($staffs as $key => $staff) {
                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('addedfrom', $staff['staffid']);
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                          }
                          break;

                        case 'product_service':
                            $this->load->model('invoice_items_model');
                            $items = $this->invoice_items_model->get();
                            foreach ($items as $key => $item) {
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                $db_builder->where('item', $item['itemid']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }
                            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                            $db_builder->where('account', $val['id']);
                            $db_builder->where('(item = 0 or item is null)');
                            if($accounting_method == 'cash'){
                                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                            }
                            $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                            $credits = $account_history->credit != '' ? $account_history->credit : 0;
                            $debits = $account_history->debit != '' ? $account_history->debit : 0;
                            
                            if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7 || $value['account_type_id'] == 6){
                                $columns[] = $credits - $debits;
                            }else{
                                $columns[] = $debits - $credits;
                            }
                            
                            break;
                        default:
                          // code...
                          break;
                    }

                    $child_account = $this->get_data_custom_summary_report_by_balance_sheet_recursive([
                        'child_account' => [],
                        'account_id' => $val['id'],
                        'account_type_id' => $value['account_type_id'],
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'accounting_method' => $accounting_method,
                        'acc_show_account_numbers' => $acc_show_account_numbers,
                        'display_rows_by' => $display_rows_by,
                        'display_columns_by' => $display_columns_by,
                    ]);

                    $data_report[$data_key][] = ['name' => $name, 'columns' => $columns, 'child_account' => $child_account];
                }
            }
        }

        $data_total_2 = [];
        foreach ($data_accounts as $data_key => $data_account) {
            if($data_key != 'income' && $data_key != 'other_income' && $data_key != 'cost_of_sales' && $data_key != 'expenses' && $data_key != 'other_expenses'){
                continue;
            }
            $total = 0;
            foreach ($data_account as $key => $value) {
                $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
                $db_builder->where('active', 1);
                $db_builder->where('account_detail_type_id', $value['id']);
                $accounts = $db_builder->get()->getResultArray();
                foreach ($accounts as $val) {
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    if($acc_show_account_numbers == 1 && $val['number'] != ''){
                            $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
                        }else{
                            $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
                        }


                    if($value['account_type_id'] == 11 || $value['account_type_id'] == 12 || $value['account_type_id'] == 8 || $value['account_type_id'] == 9 || $value['account_type_id'] == 10 || $value['account_type_id'] == 7){
                        $total += $credits - $debits;
                    }else{
                        $total += $debits - $credits;
                    }

                }
            }
            $data_total_2[$data_key] = $total;
        }

        $income = $data_total_2['income'] + $data_total_2['other_income'];
        $expenses = $data_total_2['expenses'] + $data_total_2['other_expenses'] + $data_total_2['cost_of_sales'];
        $net_income = $income - $expenses;

        return ['data' => $data_report, 'from_date' => $from_date, 'to_date' => $to_date, 'display_rows_by' => $display_rows_by, 'display_columns_by' => $display_columns_by, 'net_income' => $net_income];
    }

    /**
     * get data custom summary recursive
     * @param  array $data         
     * @return array                 
     */
    public function get_data_custom_summary_report_by_balance_sheet_recursive($data){
        $child_account = $data['child_account'];
        $account_id = $data['account_id'];
        $account_type_id = $data['account_type_id'];
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $accounting_method = $data['accounting_method'];
        $acc_show_account_numbers = $data['acc_show_account_numbers'];
        $display_rows_by = $data['display_rows_by'];
        $display_columns_by = $data['display_columns_by'];

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get()->getResultArray();
        $data_return = [];
       
        foreach ($accounts as $val) {
            $columns = [];
            switch ($display_columns_by) {
                case 'total_only':
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;

                    if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  break;

                case 'months':
                    $start = $month = strtotime($from_date);
                    $end = strtotime($to_date);

                    while($month < $end)
                    {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(month(date) = "' . date('m',$month) . '" and year(date) = "' . date('Y',$month) . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;

                        if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }

                        $month = strtotime("+1 month", $month);
                    }
                  break;

                case 'quarters':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $month = date('m', $start);
                        $year = date('Y', $start);
                        if($month>=1 && $month<=3)
                        {
                            $start_date = date('Y-m-d', strtotime('1-January-'.$year));  // timestamp or 1-Januray 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                        }
                        else  if($month>=4 && $month<=6)
                        {
                            $start_date = date('Y-m-d', strtotime('1-April-'.$year));  // timestamp or 1-April 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                        }
                        else  if($month>=7 && $month<=9)
                        {
                            $start_date = date('Y-m-d', strtotime('1-July-'.$year));  // timestamp or 1-July 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                        }
                        else  if($month>=10 && $month<=12)
                        {
                            $start_date = date('Y-m-d', strtotime('1-October-'.$year));  // timestamp or 1-October 12:00:00 AM
                            $end_date = date('Y-m-d', strtotime('1-January-'.($year+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                        }

                        $custom_date_select = '(date BETWEEN "' .
                        $start_date .
                        '" AND "' .
                        $end_date . '")';

                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where($custom_date_select);
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }

                        $start = strtotime('+3 month', $start);

                        if($start > $end){
                            $month_2 = date('m', $start);
                            $year_2 = date('Y', $start);
                            
                            if($month_2>=1 && $month_2<=3)
                            {
                                $start_date = date('Y-m-d', strtotime('1-January-'.$year_2));  // timestamp or 1-Januray 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM means end of 31 March
                            }
                            else  if($month_2>=4 && $month_2<=6)
                            {
                                $start_date = date('Y-m-d', strtotime('1-April-'.$year_2));  // timestamp or 1-April 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM means end of 30 June
                            }
                            else  if($month_2>=7 && $month_2<=9)
                            {
                                $start_date = date('Y-m-d', strtotime('1-July-'.$year_2));  // timestamp or 1-July 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM means end of 30 September
                            }
                            else  if($month_2>=10 && $month_2<=12)
                            {
                                $start_date = date('Y-m-d', strtotime('1-October-'.$year_2));  // timestamp or 1-October 12:00:00 AM
                                $end_date = date('Y-m-d', strtotime('1-January-'.($year_2+1)));  // timestamp or 1-January Next year 12:00:00 AM means end of 31 December this year
                            }

                            if($month . ' - ' . $year != $month_2 . ' - ' . $year_2){
                                $custom_date_select = '(date BETWEEN "' .
                                $start_date .
                                '" AND "' .
                                $end_date . '")';

                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where($custom_date_select);
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;

                                if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }
                        }
                    }
                    break;

                case 'years':
                    $start = strtotime($from_date);
                    $end = strtotime($to_date);

                    while ($start < $end) {
                        $year = date('Y', $start);

                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('year(date) = "' . $year . '"');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }

                        $start = strtotime('+1 year', $start);

                        if($start > $end){
                            $year_2 = date('Y', $end);
                      
                            if($year != $year_2){
                                $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                                $db_builder->where('account', $val['id']);
                                if($accounting_method == 'cash'){
                                    $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                                }
                                $db_builder->where('year(date) = "' . $year_2 . '"');
                                $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                                $credits = $account_history->credit != '' ? $account_history->credit : 0;
                                $debits = $account_history->debit != '' ? $account_history->debit : 0;
                                
                                if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                                    $columns[] = $credits - $debits;
                                }else{
                                    $columns[] = $debits - $credits;
                                }
                            }
                        }
                    }
                    break;
                case 'customers':
                    $this->load->model('clients_model');
                    $clients = $this->clients_model->get();
                    foreach ($clients as $key => $client) {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('customer', $client['userid']);
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }
                    }

                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('(customer = 0 or customer is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  break;

                case 'vendors':
                    $this->load->model('purchase/purchase_model');
                    $vendors = $this->purchase_model->get_vendor();
                    foreach ($vendors as $key => $vendor) {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        $db_builder->where('vendor', $vendor['userid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }
                    }

                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('(vendor = 0 or vendor is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  break;

                case 'employees':
                  $this->load->model('staff_model');
                  $staffs = $this->staff_model->get();
                  foreach ($staffs as $key => $staff) {
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('addedfrom', $staff['staffid']);
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                  }
                  break;

                case 'product_service':
                    $this->load->model('invoice_items_model');
                    $items = $this->invoice_items_model->get();
                    foreach ($items as $key => $item) {
                        $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                        $db_builder->where('account', $val['id']);
                        $db_builder->where('item', $item['itemid']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                        $credits = $account_history->credit != '' ? $account_history->credit : 0;
                        $debits = $account_history->debit != '' ? $account_history->debit : 0;
                        
                        if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                            $columns[] = $credits - $debits;
                        }else{
                            $columns[] = $debits - $credits;
                        }
                    }
                    $db_builder->select('sum(credit) as credit, sum(debit) as debit');
                    $db_builder->where('account', $val['id']);
                    $db_builder->where('(item = 0 or item is null)');
                    if($accounting_method == 'cash'){
                        $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
                    }
                    $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                    $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();
                    $credits = $account_history->credit != '' ? $account_history->credit : 0;
                    $debits = $account_history->debit != '' ? $account_history->debit : 0;
                    
                    if($account_type_id == 11 || $account_type_id == 12 || $account_type_id == 8 || $account_type_id == 9 || $account_type_id == 10 || $account_type_id == 7 || $account_type_id == 6){
                        $columns[] = $credits - $debits;
                    }else{
                        $columns[] = $debits - $credits;
                    }
                    
                    break;
                default:
                  // code...
                  break;
            }
            
            if($acc_show_account_numbers == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '.app_lang($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : app_lang($val['key_name']);
            }

            $child_account[] = ['name' => $name, 'columns' => $columns, 'child_account' => $this->get_data_custom_summary_report_by_balance_sheet_recursive([
                        'child_account' => [],
                        'account_id' => $val['id'],
                        'account_type_id' => $account_type_id,
                        'from_date' => $from_date,
                        'to_date' => $to_date,
                        'accounting_method' => $accounting_method,
                        'acc_show_account_numbers' => $acc_show_account_numbers,
                        'display_rows_by' => $display_rows_by,
                        'display_columns_by' => $display_columns_by,
                    ])];
            
        }

        return $child_account;
    }

    /**
     * delete all data the account detail types table
     *
     * @param      int   $id     The identifier
     *
     * @return     boolean
     */
    public function reset_account_detail_types()
    {
        $affectedRows = 0;

        if ($this->db->tableExists(get_db_prefix() . 'acc_account_type_details')) {
            $this->db->query('DROP TABLE `'.get_db_prefix() .'acc_account_type_details`;');
            $this->db->query('CREATE TABLE ' . get_db_prefix() . "acc_account_type_details (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
              `account_type_id` INT(11) NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              `note` TEXT NULL,
              `statement_of_cash_flows` VARCHAR(255) NULL,
              PRIMARY KEY (`id`)
            ) AUTO_INCREMENT=200, ENGINE=InnoDB DEFAULT CHARSET=" . $this->db->charset . ';');
            $affectedRows++;
        }

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Automatic credit note conversion
     * @param  integer $payment_id 
     * @return boolean
     */
    public function automatic_credit_note_conversion($data){
        $this->delete_convert($data['credit_id'], 'credit_note');

        $payment_account = get_setting('acc_credit_note_payment_account');
        $deposit_to = get_setting('acc_credit_note_deposit_to');
        $affectedRows = 0;

        if(get_setting('acc_close_the_books') == 1){
            if(strtotime(date('Y-m-d')) <= strtotime(get_setting('acc_closing_date')) && strtotime(date('Y-m-d')) > strtotime(get_setting('acc_closing_date'))){
                return false;
            }
        }

        $this->load->model('invoices_model');
        $invoice = $this->invoices_model->get($data['data']['invoice_id']);

        

        $payment_total = $data['data']['amount'];
        if($invoice->currency_name != $currency->name){
            $payment_total = round($this->currency_converter($invoice->currency_name, $currency->name, $data['data']['amount']), 2);
        }

        if(get_setting('acc_credit_note_automatic_conversion') == 1){
            $node = [];
            $node['split'] = $payment_account;
            $node['account'] = $deposit_to;
            $node['customer'] = $invoice->clientid;
            $node['debit'] = $payment_total;
            $node['credit'] = 0;
            $node['date'] = date('Y-m-d');
            $node['description'] = '';
            $node['rel_id'] = $data['credit_id'];
            $node['rel_type'] = 'credit_note';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = get_staff_user_id();
            $data_insert[] = $node;

            $node = [];
            $node['split'] = $deposit_to;
            $node['customer'] = $invoice->clientid;
            $node['account'] = $payment_account;
            $node['date'] = date('Y-m-d');
            $node['debit'] = 0;
            $node['credit'] = $payment_total;
            $node['description'] = '';
            $node['rel_id'] = $data['credit_id'];
            $node['rel_type'] = 'credit_note';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = get_staff_user_id();
            $data_insert[] = $node;
        }

        if($data_insert != []){
            $affectedRows = $this->db->insert_batch(get_db_prefix().'acc_account_history', $data_insert);
        }
            
        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }

    function acc_get_invoice_value_calculation_query(){
        $invoices_table = $this->db->prefixTable('invoices');

        return $this->_get_invoice_value_calculation_query($invoices_table);
    }

    public function get_net_income($data_filter){
        
        $acc_report_hide_zero_accounts = acc_get_setting('acc_report_hide_zero_accounts');
        $acc_show_account_numbers = acc_get_setting('acc_show_account_numbers');

        $from_date = date('1970-01-01');
        $to_date = date('Y-m-d');
        $accounting_method = 'accrual';
        $display_columns = 'total_only';

        $company = 0;
        if(isset($data_filter['company'])){
            if(is_array($data_filter['company'])){
                $company = implode(', ',  $data_filter['company']);
            }else{
                $company = $data_filter['company'];
            }
        }

        $where_state = '';

        if(isset($data_filter['state'])){
            $_state = '';
            foreach($data_filter['state'] as $state){
                if($state != ''){
                    if($_state != ''){
                        $_state .= ', "'.$state.'"';
                    }else{
                        $_state .= '"'.$state.'"';
                    }
                }
            }

            if($_state != ''){
                $where_state = db_prefix().'acc_company.state IN ('.$_state.')';
            }
        }

        $where_region = '';

        if(isset($data_filter['region'])){
            $_region = '';
            foreach($data_filter['region'] as $region){
                $list_state = $this->get_state_by_region($region);
                foreach($list_state as $state){
                    if($state != ''){
                        if($_region != ''){
                            $_region .= ', "'.$state.'"';
                        }else{
                            $_region .= '"'.$state.'"';
                        }
                    }
                }
            }

            if($_region != ''){
                $where_region = db_prefix().'acc_company.state IN ('.$_region.')';
            }
        }

        $where_type = '';

        if(isset($data_filter['company_type'])){
            $_type = '';
            foreach($data_filter['company_type'] as $type){
                if($type != ''){
                    if($_type != ''){
                        $_type .= ', "'.$type.'"';
                    }else{
                        $_type .= '"'.$type.'"';
                    }
                }
            }

            if($_type != ''){
                $where_type = db_prefix().'acc_company.type IN ('.$_type.')';
            }
        }

        if(isset($data_filter['accounting_method'])){
            $accounting_method = $data_filter['accounting_method'];
        }

        if(isset($data_filter['from_date']) && $data_filter['type'] != 'balance_sheet' && $data_filter['type'] != 'balance_sheet_summary' && $data_filter['type'] != 'balance_sheet_detail' && $data_filter['type'] != 'balance_sheet_comparison'){
            $from_date = to_sql_date($data_filter['from_date']);
        }


        if(isset($data_filter['to_date'])){
            $to_date = to_sql_date($data_filter['to_date']);
        }


        if(isset($data_filter['display_columns'])){
            $display_columns = $data_filter['display_columns'];
        }

        $account_type_details = $this->get_account_type_details();
        $data_report = [];
        $data_accounts = [];
        
        foreach ($account_type_details as $key => $value) {
            if($value['account_type_id'] == 11){
                $data_accounts['income'][] = $value;
            }

            if($value['account_type_id'] == 14){
                $data_accounts['expenses'][] = $value;
            }
        }

        $data = [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'accounting_method' => $accounting_method,
            'display_columns' => $display_columns,
            'company' => $company,
            'acc_show_account_numbers' => $acc_show_account_numbers,
            'acc_report_hide_zero_accounts' => $acc_report_hide_zero_accounts,
        ];

        foreach ($data_accounts as $data_key => $data_account) {
            $data_report[$data_key] = 0;
            foreach ($data_account as $key => $value) {
                $db_builder->select('*, '.get_db_prefix().'acc_accounts.id as id,'.get_db_prefix().'acc_accounts.name as name');
                $db_builder->where('active', 1);
                $db_builder->where('(parent_account is null or parent_account = 0)');
                $db_builder->where('account_detail_type_id', $value['id']);
                if($where_state != '' || $where_region != '' || $where_type != ''){
                    if($company != 0){
                        if(is_numeric($company)){
                            $db_builder->where(get_db_prefix().'acc_accounts.company = "'.$company.'"');
                        }else{
                            $db_builder->where(get_db_prefix().'acc_accounts.company in ('.$company.')');
                        }
                    }

                    if($where_state != ''){
                        $db_builder->where($where_state);
                    }

                    if($where_region != ''){
                        $db_builder->where($where_region);
                    }

                    if($where_type != ''){
                        $db_builder->where($where_type);
                    }
                }else{
                    if(is_numeric($company)){
                        $db_builder->where(get_db_prefix().'acc_accounts.company = "'.$company.'"');
                    }else{
                        $db_builder->where(get_db_prefix().'acc_accounts.company in ('.$company.')');
                    }
                }


                $db_builder->orderBy('number', 'asc');
                $this->db->join( get_db_prefix().'acc_company', get_db_prefix().'acc_accounts.company = '.get_db_prefix().'acc_company.id', 'left');
                $accounts = $db_builder->get(get_db_prefix().'acc_accounts')->getResultArray();
                foreach ($accounts as $val) {
                        $db_builder->select('*, (select sum(amount) from '.get_db_prefix().'acc_matched_transactions where account_history_id = '.get_db_prefix().'acc_account_history.id) as total_matched_amount');
                        $db_builder->where('account', $val['id']);
                        if($accounting_method == 'cash'){
                            $db_builder->where('(((rel_type = "invoice" and paid = 1) or rel_type != "invoice") or rel_type = "subsidy")');
                        }
                        $db_builder->where('(date >= "' . $from_date . '" and date <= "' . $to_date . '")');
                        $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getResultArray();

                        $credits = 0;
                        $debits = 0;

                        foreach($account_history as $v){
                            if($accounting_method == 'cash' && $v['rel_type'] == 'bill' && $v['debit'] > 0 && $v['paid'] == 0 && $v['paid'] == 0){
                                $debits += $this->get_total_bill_item_paid($v['bill_item']);
                            }elseif($v['total_matched_amount'] != '' && $accounting_method == 'cash'){
                                if($v['credit'] > $v['total_matched_amount']){
                                    $credits += $v['total_matched_amount'];
                                }else{
                                    $credits += $v['credit'];
                                }
                            }else{
                                $credits += $v['credit'];
                                $debits += $v['debit'];
                            }
                        }

                        if($value['account_type_id'] == 11 || $value['account_type_id'] == 12){
                            $amount = $credits - $debits;
                        }else{
                            $amount = $debits - $credits;
                        }

                        $data_report[$data_key] += $amount;

                        $child_amount = $this->get_data_net_income_recursive(0, $val['id'], $value['account_type_id'], $data);
                        $data_report[$data_key] += $child_amount;
                }
            }
        }

        $net_income = round(($data_report['income'] - $data_report['expenses']), 2);

        return $net_income;
    }

    public function get_data_net_income_recursive($child_amount, $account_id, $account_type_id, $data){
        $db_builder->where('active', 1);
        $db_builder->where('parent_account', $account_id);
        $accounts = $db_builder->get(get_db_prefix().'acc_accounts')->getResultArray();
        foreach ($accounts as $val) {
            $db_builder->select('sum(credit) as credit, sum(debit) as debit');
            $db_builder->where('account', $val['id']);
            if($data['accounting_method'] == 'cash'){
                $db_builder->where('((rel_type = "invoice" and paid = 1) or rel_type != "invoice")');
            }
            $db_builder->where('(date >= "' . $data['from_date'] . '" and date <= "' . $data['to_date'] . '")');
            $account_history = $db_builder->get(get_db_prefix().'acc_account_history')->getRow();

            $credits = $account_history->credit != '' ? $account_history->credit : 0;
            $debits = $account_history->debit != '' ? $account_history->debit : 0;
            if($data['acc_show_account_numbers'] == 1 && $val['number'] != ''){
                $name = $val['name'] != '' ? $val['number'].' - '.$val['name'] : $val['number'].' - '._l($val['key_name']);
            }else{
                $name = $val['name'] != '' ? $val['name'] : _l($val['key_name']);
            }

            if($account_type_id == 11 || $account_type_id == 12){
                $amount = $credits - $debits;
            }else{
                $amount = $debits - $credits;
            }

            $child_amount += $amount; 


            $_child_account = $this->get_data_profit_and_loss_recursive(0, $val['id'], $account_type_id, $data);

            $child_amount += $_child_account; 
        }

        return $child_amount;
    }

    public function get_plaid_transaction($bank_id){
        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        $db_builder->where('bank_id', $bank_id);
        $db_builder->orderBy('date', 'desc');

        $transactions = $db_builder->get()->getResultArray();
      
        $account_type_name = [];
        $detail_type_name = [];

        $rResult = [];
        foreach ($transactions as $key => $value) {
            $rResult[$key]['withdrawals'] = $value['withdrawals'] != 0 ? $value['withdrawals'] : '';
            $rResult[$key]['deposits'] = $value['deposits'] != 0 ? $value['deposits'] : '';
            $rResult[$key]['date'] = $value['date'];
            $rResult[$key]['payee'] = $value['description'];
            $rResult[$key]['datecreated'] = $value['datecreated'];
        }
         
        return $rResult;
    }

    public function get_last_refresh_data($bank_id){
        $db_builder = $this->db->table(get_db_prefix().'acc_plaid_transaction_logs');
        $db_builder->where('bank_id', $bank_id);
        $db_builder->orderBy('id', 'desc');
        $db_builder->limit(1);
        $refresh_date = $db_builder->get()->getResultArray();

        $rResult = [];
        foreach ($refresh_date as $key => $value) {
            $rResult[$key]['refresh_date'] = $value['last_updated'];
            
            $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
            $db_builder->where('bank_id', $bank_id);
            $db_builder->where('date', $value['last_updated']);
            $count = $db_builder->get()->getResultArray();
            $count = count($count);
            
            $rResult[$key]['count'] = $count;
        }
         
        return $rResult;
    }

    public function get_date_last_updated($bank_id){
        $db_builder = $this->db->table(get_db_prefix().'acc_plaid_transaction_logs');
        $db_builder->where('bank_id', $bank_id);
        $db_builder->orderBy('last_updated', 'desc');
        $db_builder->limit(1);

        $plaid_transaction_log = $db_builder->get()->getRow();

        if($plaid_transaction_log)
        {
            return $plaid_transaction_log->last_updated;
        }

        return '';
    }


    public function get_plaid_link_token(){
        $data = $this->get_plaid_params(); 
        $data['products'] = ["auth"];
        $data['client_name'] = 'Plaid Test App';
        $data['country_codes'] = ["US"];
        $data['language'] = 'en';
        $data['user'] = ['client_user_id' => 'testUser'];

        $data_string = json_encode($data);

        $plaid_environment = $this->get_plaid_environment();

        $url = $plaid_environment.'link/token/create';

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        
        $result = curl_exec($curl);

        $result = json_decode($result);

        return isset($result->link_token) ? $result->link_token : '';
    }

    public function get_plaid_params(){
        $plaid_environment = get_setting('acc_plaid_environment');

        switch ($plaid_environment) {
            case 'production':
                $secret = get_setting('acc_live_secret');
                break;
            case 'sandbox':
                $secret = get_setting('acc_sandbox_secret');
                break;
            default:
                $secret = get_setting('acc_live_secret');
                break;
        }

        $data = array(
            "client_id" => get_setting('acc_plaid_client_id'), 
            "secret" => $secret, 
        );
        return $data;
    }

    public function get_plaid_environment(){
        $plaid_environment = get_setting('acc_plaid_environment');
        
        switch ($plaid_environment) {
            case 'production':
                return 'https://production.plaid.com/';
                break;
            case 'sandbox':
                return 'https://sandbox.plaid.com/';
                break;
            default:
                return 'https://production.plaid.com/';
                break;
        }
    }

    /**
     * update general setting
     *
     * @param      array   $data   The data
     *
     * @return     boolean 
     */
    public function update_plaid_environment($data){
        $db_builder = $this->db->table(get_db_prefix().'settings');
        $affectedRows = 0;
        foreach ($data as $key => $value) {
            $db_builder->where('setting_name', $key);
            if ($db_builder->update(['setting_value' => $value])) {
                $affectedRows++;
            }
        }
        
        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    public function plaid_get_account($access_token){
        $data = $this->get_plaid_params(); 
        $data['access_token'] = $access_token;

        $data_string = json_encode($data);

        $plaid_environment = $this->get_plaid_environment();

        $url = $plaid_environment.'accounts/get';

        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        
        $result = curl_exec($curl);

        $result = json_decode($result);

        return $result->accounts;
    }


    public function get_access_token($public_token){
        $data = $this->get_plaid_params(); 
        $data['public_token'] = $public_token;

        $data_string = json_encode($data);

        $plaid_environment = $this->get_plaid_environment();

        $url = $plaid_environment.'item/public_token/exchange';

        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        
        $result = curl_exec($curl);

        $result = json_decode($result);

        return $result->access_token;
    }


    public function plaid_get_transactions($data_filter, $retry = 1){
        $data = $this->get_plaid_params(); 
        $data['access_token'] = $data_filter['access_token'];
        $data['start_date'] = $data_filter['start_date'];
        $data['end_date'] = $data_filter['end_date'];
        $data['options'] = ['include_original_description' => true];
        
        $data_string = json_encode($data);

        $plaid_environment = $this->get_plaid_environment();

        $url = $plaid_environment.'transactions/get';

        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        
        $result = curl_exec($curl);

        $result = json_decode($result);
        if(isset($result->transactions)){
            return $result->transactions;
        }else{
            if($retry < 3){
                return $this->plaid_get_transactions($data_filter, $retry++);
            }else{
                return false;
            }
        }
    }

    public function get_account_bank_data($bank_id){
        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('id', $bank_id);
        $db_builder->orderBy('id', 'asc');

        $transactions = $db_builder->get()->getResultArray();

        $rResult = [];
        foreach ($transactions as $key => $value) {
            $rResult[$key]['plaid_status'] = $value['plaid_status'];
            $rResult[$key]['account_name'] = $value['plaid_account_name'];
        }
         
        return $rResult;
    }

    /**
     * add bank reconcile
     * @param array $data 
     * @return  integer or boolean
     */
    public function add_bank_reconcile($data){
        if(isset($data['reconcile_id'])){
            unset($data['reconcile_id']);
        }

        if($data['ending_date'] != ''){
            $data['ending_date'] = $data['ending_date'];
        }

        if($data['income_date'] != ''){
            $data['income_date'] = $data['income_date'];
        }

        if($data['expense_date'] != ''){
            $data['expense_date'] = $data['expense_date'];
        }

        $data['service_charge'] = str_replace(',', '', $data['service_charge']);
        $data['interest_earned'] = str_replace(',', '', $data['interest_earned']);
        $data['ending_balance'] = str_replace(',', '', $data['ending_balance']);
        $data['debits_for_period'] = str_replace(',', '', $data['debits_for_period']);
        $data['credits_for_period'] = str_replace(',', '', $data['credits_for_period']);
        $data['beginning_balance'] = str_replace(',', '', $data['beginning_balance']);
        
        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->insert($data);
        $insert_id = $this->db->insertID();
        
        if($insert_id){
            $users_model = model("App\Models\Users_model", false);
            $created_by = $users_model->login_user_id();

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            if($data['service_charge'] > 0){
                $node = [];
                $node['split'] = $data['account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['expense_account'];
                $node['debit'] = $data['service_charge'];
                $node['credit'] = 0;
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['description'] = _l('service_charge');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;
                $node['company'] = $data['company'];

                $db_builder->insert($node);

                $node = [];
                $node['split'] = $data['expense_account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['account'];
                
                $node['debit'] = 0;
                $node['credit'] = $data['service_charge'];
                $node['rel_id'] = 0;
                $node['rel_type'] = 'cheque_expense';
                $node['description'] = _l('service_charge');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;
                $node['company'] = $data['company'];


                $db_builder->insert($node);
            }
            if($data['interest_earned'] > 0){
                $node = [];
                $node['split'] = $data['account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['income_account'];
                $node['debit'] = 0;
                $node['credit'] = $data['interest_earned'];
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['description'] = _l('interest_earned');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;
                $node['company'] = $data['company'];

                $db_builder->insert($node);

                $node = [];
                $node['split'] = $data['income_account'];
                $node['reconcile'] = $insert_id;
                $node['account'] = $data['account'];
                $node['debit'] = $data['interest_earned'];
                $node['credit'] = 0;
                $node['rel_id'] = 0;
                $node['rel_type'] = 'deposit';
                $node['description'] = _l('interest_earned');
                $node['datecreated'] = date('Y-m-d H:i:s');
                $node['addedfrom'] = $created_by;
                $node['company'] = $data['company'];


                $db_builder->insert($node);
            }

            return $insert_id;
        }

        return false;
    }

    public function get_reconcile_difference_info($reconcile_id){
        $rs = 0;
        $from_date = '';
        $to_date = '';

        $reconcile = $this->get_reconcile($reconcile_id);
        if($reconcile){
            $to_date = $reconcile->ending_date;
        }

        $recently_reconcile = $this->get_recently_reconcile_by_account($reconcile->account, $reconcile_id);
        if($recently_reconcile){
            $from_date = $recently_reconcile->ending_date;
        }



        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('account', $reconcile->account);

        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
            
        $db_builder->where('('.get_db_prefix() . 'acc_account_history.reconcile ='. $reconcile->id.' or '.get_db_prefix() . 'acc_account_history.reconcile = 0)');
       
        $transactions = $db_builder->get()->getResultArray();

        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        $db_builder->where('bank_id', $reconcile->account);
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
        $bankings = $db_builder->get()->getResultArray();

        $banking_matched = [];

        $data_return = [];
        $data_return['banking_register_withdrawals'] = 0;
        $data_return['banking_register_deposits'] = 0;
        $data_return['posted_bank_withdrawals'] = 0;
        $data_return['posted_bank_deposits'] = 0;

        foreach($transactions as $tran){
            $data_return['banking_register_withdrawals'] +=  $tran['credit'];
            $data_return['banking_register_deposits'] +=  $tran['debit'];
        }

        foreach($bankings as $bank){
            $data_return['posted_bank_withdrawals'] +=  $bank['withdrawals'];
            $data_return['posted_bank_deposits'] +=  $bank['deposits'];
        }
            
        return $data_return;
    }

    /**
     * get reconcile
     * @param  string $id
     * @param  array  $where
     * @return array or object
     */
    public function get_reconcile($id = '', $where = [])
    {
        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        if (is_numeric($id)) {
            $db_builder->where('id', $id);
            return $db_builder->get()->getRow();
        }

        $db_builder->where($where);
        $db_builder->orderBy('id', 'desc');
        return $db_builder->get()->getResultArray();
    }

    /**
     * Gets the recently reconcile by account.
     *
     * @param        $bank_account  The bank account
     * @param        $reconcile_id  The reconcile identifier
     */
    public function get_recently_reconcile_by_account($bank_account, $reconcile_id){
        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->where('account', $bank_account);
        $db_builder->where('opening_balance', 0);
        
        $db_builder->where('id != '.$reconcile_id);
        $db_builder->orderBy('id', 'desc');
        
        $reconcile = $db_builder->get()->getRow();

        if($reconcile){
            return $reconcile;
        }
        return false;
    }

    /**
     * Get account_id by number
     *
     * @param      string  $number  The account number
     * @param      string  $company_id
     *
     * @return     array  The date range report period.
     */
    public function get_account_id_by_number($number = ''){

        $db_builder = $this->db->table(get_db_prefix().'acc_accounts');
        $db_builder->where('number', $number);
        $account = $db_builder->get()->getRow();

        if($account){
            return $account->id;
        }

        return false;
    }

    public function match_transactions($reconcile_id, $account_id){
        $rs = 0;
        $from_date = '';
        $to_date = '';

        $reconcile = $this->get_reconcile($reconcile_id);
        if($reconcile){
            $to_date = $reconcile->ending_date;
        }

        if($account_id != ''){
            $recently_reconcile = $this->get_recently_reconcile_by_account($account_id, $reconcile_id);
            if($recently_reconcile){
                $from_date = $recently_reconcile->ending_date;
            }
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('account', $account_id);
        $db_builder->where('(cleared != 1 or reconcile = 0)');
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
        $transactions = $db_builder->get()->getResultArray();

        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        $db_builder->where('bank_id', $account_id);
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
        $db_builder->where('(matched != 1 or reconcile = 0)');
        $bankings = $db_builder->get()->getResultArray();

        $banking_matched = [];

        $data_return = [];
        
        foreach($transactions as $tran){
            
            foreach($bankings as $bank){
                if(in_array($bank['id'], $banking_matched)){
                    continue;
                }
                $check = 1;
                if($tran['date'] != $bank['date']){
                    $check = 0;
                }
                
                if($tran['credit'] != $bank['withdrawals']){
                    $check = 0;
                }

                if($tran['debit'] != $bank['deposits']){
                    $check = 0;
                }
                
                if($check == 1){
                    $banking_matched[] = $bank['id'];

                    $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
                    $db_builder->where('id', $bank['id']);
                    $db_builder->update([
                        'reconcile' => $reconcile_id,
                        'matched' => 1,
                    ]);
                    if($this->db->affectedRows() > 0){
                        $rs++;
                    }

                    $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                    $db_builder->where('id', $tran['id']);
                    $db_builder->update([
                        'reconcile' => $reconcile_id,
                        'cleared' => 1,
                    ]);
                    if($this->db->affectedRows() > 0){
                        $rs++;
                    }

                    $db_builder = $this->db->table(get_db_prefix().'acc_matched_transactions');
                    $db_builder->insert([
                        'account_history_id' => $tran['id'],
                        'history_amount' => 0,
                        'rel_id' => $bank['id'],
                        'rel_type' => 'banking',
                        'amount' => 0,
                        'reconcile' => $reconcile_id,
                    ]);
                    break;
                }
            }
        }


        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('account', $account_id);
        $db_builder->where('(cleared != 1 or reconcile = 0)');
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
        $new_transactions = $db_builder->get()->getResultArray();

        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        $db_builder->where('bank_id', $account_id);
        $db_builder->where('(matched != 1 or reconcile = 0)');
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
        $new_bankings = $db_builder->get()->getResultArray();

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        foreach($new_transactions as $tran){
            $db_builder->where('id', $tran['id']);
            $db_builder->update([
                'cleared' => -1,
            ]);
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        foreach($new_bankings as $bank){
            $db_builder->where('id', $bank['id']);
            $db_builder->update([
                'matched' => -1,
            ]);
        }

        if($rs > 0){
            return 1;
        }
        return 0;
    }


    public function unmatch_transactions($reconcile_id, $account_id){
        $affected_rows = 0;

        $from_date = '';
        $to_date = '';

        $reconcile = $this->get_reconcile($reconcile_id);
        if($reconcile){
            $to_date = $reconcile->ending_date;
        }

        if($account_id != ''){
            $recently_reconcile = $this->get_recently_reconcile_by_account($account_id, $reconcile_id);
            if($recently_reconcile){
                $from_date = $recently_reconcile->ending_date;
            }
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('(reconcile = 0 or reconcile = '.$reconcile_id.')');
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
        $db_builder->update(['reconcile' => 0, 'cleared' => 0]);
        if ($this->db->affectedRows() > 0) {
            $affected_rows++;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }
        $db_builder->where('(reconcile = 0 or reconcile = '.$reconcile_id.')');
        $db_builder->update([
                    'adjusted' => 0,
                    'reconcile' => 0,
                    'matched' => 0,
                ]);

        if ($this->db->affectedRows() > 0) {
            $affected_rows++;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_matched_transactions');
        $db_builder->where('rel_type', 'banking');
        $db_builder->where('reconcile', $reconcile_id);
        $db_builder->delete();
        
        if ($this->db->affectedRows() > 0) {
            $affected_rows++;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->where('id', $reconcile->id);
        $db_builder->update(['finish' => 0]);

        if ($this->db->affectedRows() > 0) {
            $affected_rows++;
        }

        if($affected_rows > 0){
            return true;
        }
        return false;
    }

    public function get_transaction_uncleared($reconcile_id){
        $from_date = '';
        $to_date = '';

        $reconcile = $this->get_reconcile($reconcile_id);
        if($reconcile){
            $to_date = $reconcile->ending_date;
        }

        $recently_reconcile = $this->get_recently_reconcile_by_account($reconcile->account, $reconcile_id);
        if($recently_reconcile){
            $from_date = $recently_reconcile->ending_date;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        $db_builder->where('bank_id', $reconcile->account);
        $db_builder->where('((matched != 1 and matched != -2) or adjusted = 1)');
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }

        $transaction_bankings = $db_builder->get()->getResultArray();

        return $transaction_bankings;
    }

    public function make_adjusting_entry_save($data){
        if($data['type'] == 'add_transaction'){
            $users_model = model("App\Models\Users_model", false);
            $created_by = $users_model->login_user_id();

            $transaction_banking = $this->get_transaction_banking($data['transaction_bank_id']);

            $node = [];
            $node['split'] = $transaction_banking->bank_id;
            $node['account'] = $data['account'];
            $node['customer'] = 0;
            $node['debit'] = $transaction_banking->withdrawals;
            $node['date'] = $transaction_banking->date;
            $node['credit'] = $transaction_banking->deposits;
            $node['reconcile'] = $data['reconcile'];
            $node['tax'] = 0;
            $node['cleared'] = 1;
            $node['description'] = '';
            $node['rel_id'] = $data['transaction_bank_id'];
            $node['rel_type'] = 'banking';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = $created_by;

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->insert($node);

            $node = [];
            $node['split'] = $data['account'];
            $node['account'] = $transaction_banking->bank_id;
            $node['customer'] = 0;
            $node['debit'] = $transaction_banking->deposits;
            $node['date'] = $transaction_banking->date;
            $node['credit'] = $transaction_banking->withdrawals;
            $node['reconcile'] = $data['reconcile'];
            $node['tax'] = 0;
            $node['cleared'] = 1;
            $node['description'] = '';
            $node['rel_id'] = $data['transaction_bank_id'];
            $node['rel_type'] = 'banking';
            $node['datecreated'] = date('Y-m-d H:i:s');
            $node['addedfrom'] = $created_by;

            $db_builder->insert($node);

            $insert_id = $this->db->insertID();

            if ($insert_id) {
                $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
                $db_builder->where('id', $data['transaction_bank_id']);
                $db_builder->update([
                    'adjusted' => 1,
                    'matched' => 1,
                ]);

                return true;
            }
        }else{

            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('id', $data['transaction']);
            $account_history = $db_builder->get()->getRow();
            $withdrawal = str_replace(',', '', $data['withdrawal']);
            $deposit = str_replace(',', '', $data['deposit']);
            if($withdrawal > 0){
                $amount = $withdrawal;
            }else{
                $amount = $deposit;
            }

            if ($account_history) {
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                $db_builder->where('id', $data['transaction']);
                $db_builder->update([
                    'reconcile' => $data['reconcile'],
                    'cleared' => 1,
                    'date' => to_sql_date($data['date']),
                    'credit' => $withdrawal,
                    'debit' => $deposit,
                ]);
               
                if($this->db->affectedRows() > 0){

                    $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
                    $db_builder->where('id', $data['transaction_bank_id']);
                    $db_builder->update([
                        'adjusted' => 1,
                        'matched' => 1,
                    ]);

                    return true;
                }
            }
        }

        return false;
    }

    public function leave_it_uncleared($transaction_bank_id){
        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        $db_builder->where('id', $transaction_bank_id);
        $db_builder->update([
            'matched' => -2,
            'adjusted' => 1,
        ]);

        if($this->db->affectedRows() > 0){
            return true;
        }

        return false;

    }

    public function get_transaction_leave_uncleared($reconcile_id){

        $from_date = '';
        $to_date = '';

        $reconcile = $this->get_reconcile($reconcile_id);
        if($reconcile){
            $to_date = $reconcile->ending_date;
        }

        $recently_reconcile = $this->get_recently_reconcile_by_account($reconcile->account, $reconcile_id);
        if($recently_reconcile){
            $from_date = $recently_reconcile->ending_date;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
        $db_builder->where('bank_id', $reconcile->account);
        $db_builder->where('matched = -2');
        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }

        $transaction_bankings = $db_builder->get()->getResultArray();

        return $transaction_bankings;
    }

    public function get_bank_transaction_uncleared($reconcile_id){

        $from_date = '';
        $to_date = '';
        $bank_account = '';

        $reconcile = $this->get_reconcile($reconcile_id);
        if($reconcile){
            $to_date = $reconcile->ending_date;
            $bank_account = $reconcile->account;
        }

        $recently_reconcile = $this->get_recently_reconcile_by_account($reconcile->account, $reconcile_id);
        if($recently_reconcile){
            $from_date = $recently_reconcile->ending_date;
        }

        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');

        $db_builder->where('account', $bank_account);
        $db_builder->where('reconcile', 0);

        if ($from_date != '' && $to_date != '') {
            $db_builder->where('(date > "' . $from_date . '" and date <= "' . $to_date . '")');
        } elseif ($to_date != '' && $from_date == '') {
            $db_builder->where('(date <= "' . $to_date . '")');
        }

        $account_histories = $db_builder->get()->getResultArray();

        return $account_histories;
    }

    /**
     * finish reconcile bank account
     * @param  array $data 
     * @return boolean       
     */
    public function finish_reconcile_bank_account($data){
        $affectedRows = 0;
        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->where('id', $data['reconcile']);
        $db_builder->update(['finish' => 1]);

        if ($this->db->affectedRows() > 0) {
            $affectedRows++;
        }

        if ($affectedRows > 0) {
            return true;
        }

        return true;
    }


    /**
     * reconcile restored
     * @param  [type] $account 
     * @param  [type] $company 
     * @return [type]          
     */
    public function reconcile_bank_account_restored($account)
    {
        $affected_rows=0;
        
        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->where('account', $account);
        $db_builder->where('finish', 0);
        $db_builder->where('opening_balance', 0);
        $db_builder->orderBy('ending_date', 'desc');

        $reconcile = $db_builder->get()->getRow();

        if($reconcile){
            $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
            $db_builder->where('reconcile', $reconcile->id);
            $db_builder->update(['reconcile' => 0, 'cleared' => 0]);
    
            $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
            $db_builder->where('reconcile', $reconcile->id);
            $db_builder->update([
                        'reconcile' => 0,
                        'matched' => 0,
                    ]);

            if ($this->db->affectedRows() > 0) {
                $affected_rows++;
            }

            $db_builder = $this->db->table(get_db_prefix().'acc_matched_transactions');
            $db_builder->where('rel_type', 'banking');
            $db_builder->where('reconcile', $reconcile->id);
            $db_builder->delete();
            
            $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
            $db_builder->where('id', $reconcile->id);
            $db_builder->delete();

            if ($this->db->affectedRows() > 0) {
                $affected_rows++;
            }
        }else{
            //get reconcile
            $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
            $db_builder->where('account', $account);
            $db_builder->where('finish', 1);
            $db_builder->where('opening_balance', 0);
            $db_builder->orderBy('ending_date', 'desc');

            $reconcile = $db_builder->get()->getRow();

            if($reconcile){
                $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
                $db_builder->where('reconcile', $reconcile->id);
                $db_builder->update(['reconcile' => 0, 'cleared' => 0]);

                $db_builder = $this->db->table(get_db_prefix().'acc_transaction_bankings');
                $db_builder->where('reconcile', $reconcile->id);
                $db_builder->update([
                            'reconcile' => 0,
                            'matched' => 0,
                        ]);

                if ($this->db->affectedRows() > 0) {
                    $affected_rows++;
                }

                $db_builder = $this->db->table(get_db_prefix().'acc_matched_transactions');
                $db_builder->where('rel_type', 'banking');
                $db_builder->where('reconcile', $reconcile->id);
                $db_builder->delete();
                
                $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
                $db_builder->where('id', $reconcile->id);
                $db_builder->delete();

                if ($this->db->affectedRows() > 0) {
                    $affected_rows++;
                }
            }
        }

        if($affected_rows > 0){
            return true;
        }
        return false;
    }

    /**
     * ajax update reconcile
     * @param  [type] $data 
     * @param  [type] $id   
     * @return [type]       
     */
    public function ajax_update_reconcile($data, $id){
        if(isset($data['company_id'])){
            unset($data['company_id']);
        }

        if(isset($data['rise_csrf_token'])){
            unset($data['rise_csrf_token']);
        }

        if(isset($data['_'])){
            unset($data['_']);
        }

        if($data['ending_date'] != ''){
            $data['ending_date'] = to_sql_date($data['ending_date']);
        }

        $data['ending_balance'] = str_replace(',', '', $data['ending_balance']);
        $data['debits_for_period'] = str_replace(',', '', $data['debits_for_period']);
        $data['credits_for_period'] = str_replace(',', '', $data['credits_for_period']);
        $data['beginning_balance'] = str_replace(',', '', $data['beginning_balance']);

        $db_builder = $this->db->table(get_db_prefix().'acc_reconciles');
        $db_builder->where('id', $id);
        $affectedRows = $db_builder->update($data);

        if ($this->db->affectedRows() > 0) {
            return true;
        }
        return false;
    }

    public function convert_excel_date($date_number){
        $UNIX_DATE = (44625 - 25569) * 86400;
        $d = gmdate("d/m/Y", $UNIX_DATE);

        return $d;
    }

    /**
     * get account history
     * @param  integer $id 
     * @return object    
     */
    public function get_account_history($id){
        $db_builder = $this->db->table(get_db_prefix().'acc_account_history');
        $db_builder->where('id', $id);
        return $db_builder->get()->getRow();
    }
}
