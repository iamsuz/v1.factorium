<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WholesaleInvestment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wholesale_investments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id','investment_investor_id', 'wholesale_investing_as','accountant_name_and_firm','accountant_professional_body_designation','accountant_email','accountant_phone','equity_investment_experience_text','experience_period','unlisted_investment_experience_text','understand_risk_text'];


    public function investmentInvestors()
    {
        return $this->belongsTo('App\InvestmentInvestor');
    }
}
