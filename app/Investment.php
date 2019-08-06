<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'goal_amount', 'minimum_accepted_amount', 'maximum_accepted_amount', 'total_projected_costs','total_debt', 'total_equity','projected_returns','hold_period','annual_cash_yield','investment_type','proposer','summary','security_long','rationale','current_status','exit_d','developer_equity','security','expected_returns_long','returns_paid_as', 'taxation','marketability','residents','plans_permit_url','construction_contract_url','consultancy_agency_agreement_url','debt_details_url','master_pds_url','caveats_url','land_ownership_url','valuation_report_url','consent_url','spv_url','investments_structure_image_url','investments_structure_video_url','risk','how_to_invest','bank','bank_account_name','bsb','bank_account_number','bank_reference','embedded_offer_doc_link','PDS_part_1_link','PDS_part_2_link','fund_raising_start_date','fund_raising_close_date', 'bitcoin_wallet_address','swift_code'];

    /**
     * this is a many to many relationship between user and their roles
     * @return project instance
     */
    protected $dates = ['fund_raising_start_date','fund_raising_close_date'];

    /**
     * @return int
     */
    public function getInvoiceDaysRemainingAttribute()
    {
        $from = \Carbon\Carbon::now();
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $this->fund_raising_close_date);
        $diff_in_days = $to->diffInDays($from);

        return $diff_in_days;
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
