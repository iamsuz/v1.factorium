<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['user_id','title', 'slug', 'description', 'invoice_issued_from', 'type', 'additional_info', 'button_label', 'active', 'activated_on', 'start_date', 'completion_date', 'invite_only', 'developer_id','property_type', 'is_coming_soon', 'show_invest_now_button', 'show_download_pdf_page','project_site', 'project_rank', 'eb_project_rank', 'project_prospectus_text', 'share_vs_unit', 'md_vs_trustee', 'add_additional_form_content', 'project_thumbnail_text', 'additional_disclaimer', 'retail_vs_wholesale', 'eoi_button', 'custom_project_page_link', 'show_interested_to_buy_checkbox','wallet_address', 'contract_address','use_tokens','invoice_issue_from_email','confirmation','transaction_hash'];

     /**
     * boolean fields
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * dates fields
     */
    protected $dates = ['start_date','completion_date', 'activated_on'];

    /**
     * this is a many to many relationship between user and their roles
     * @return user instance
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function location()
    {
        return $this->hasOne('App\Location');
    }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function media()
    {
        return $this->hasMany('App\Media');
    }

    /**
     * this is a many to many relationship between user and their roles
     * @return collection
     */
    public function investment()
    {
        return $this->hasOne('App\Investment');
    }

    /**
     * may to may relationship between projects and documents
     * @return collection
     */
    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function investmentDocuments()
    {
        return $this->hasMany('App\UserInvestmentDocument');
    }
    /**
     * this is a mutator to encrypt the password
     * @param raw password $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value.' '.rand(1, 999));
    }

    /**
     * this is a mutator to encrypt the password
     * @param raw password $value
     */
    public function setActiveAttribute($value)
    {
        if($value != 0) {
            $this->attributes['active'] = $value;
            $this->attributes['activated_on'] = Carbon::now();
        } else {
            $this->attributes['active'] = $value;
        }
    }

    /**
     * this is a many to many relationship between user and their investors
     * @return collection
     */
    public function investors()
    {
        return $this->belongsToMany('App\User', 'investment_investor')->withPivot(['amount','transaction_hash','accepted','money_received','is_repurchased'])->withTimestamps();
    }

    /**
     * may to may relationship between projects and projects faqs
     * @return collection
     */
    public function projectFAQs()
    {
        return $this->hasMany('App\ProjectFAQ');
    }

    /**
     * may to may relationship between projects and comments
     * @return collection
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function developer()
    {
        return $this->belongsTo('App\User', 'developer_id');
    }

    public function invited_users()
    {
        return $this->belongsToMany('App\User', 'project_user')->withTimestamps();;
    }

    public function project_progs()
    {
        return $this->hasMany('App\ProjectProg');
    }

    public function projectspvdetail()
    {
        return $this->hasOne('App\ProjectSpvDetail');
    }
    public function projectconfiguration()
    {
        return $this->hasOne('App\ProjectConfiguration')->join('project_configuration_partials', 'project_configurations.project_id', '=', 'project_configuration_partials.project_id');
        // ->join('project_configuration_partials', function ($join) {
        //     $join->on('project_configurations.project_id', '=', 'contacts.user_id')
        //          ->where('contacts.user_id', '>', 5);
        // })
        // ->get();
    }

    public function projectconfigurationpartial()
    {
        return $this->hasOne('App\ProjectConfigurationPartial');
    }

    public function investing_joint()
    {
        return $this->hasMany('App\InvestingJoint');
    }
    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }
    public function position()
    {
        return $this->hasMany('App\Position');
    }
    public function investment_request()
    {
        return $this->hasMany('App\InvestmentRequest');
    }
    public function projectEoi()
    {
        return $this->hasMany('App\ProjectEOI');
    }
    public function prospectus_download()
    {
        return $this->hasMany('App\ProspectusDownload');
    }

    public function market()
    {
        return $this->hasMany('App\Market');
    }

    public function investor_project_token()
    {
        return $this->hasMany('App\InvestorProjectToken');
    }

    public function third_party_listing()
    {
        return $this->hasOne('App\ThirdPartyListing');
    }

    public function issueTokens()
    {
        return $this->hasMany('App\IssueingToken');
    }

    public function repurchased()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['accepted' => '1', 'is_repurchased' => '1']);
    }

    public function repurchased_by_partial_pay()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['accepted' => '1', 'partial_repay_percentage' => '100']);
    }

    public function moneyReceived()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['money_received' => '1']);
    }

    public function soldInvoice()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['accepted' => '1', 'money_received' => 1, 'is_repurchased' => '0']);
    }

    public function applicationReceived()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['accepted' => '0', 'money_received' => '0']);
    }

    public function applicationApproval()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['accepted' => '1', 'money_received' => '1']);
    }

    public function fundsReceived()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['accepted' => '0', 'money_received' => '1']);
    }

    public function receivableNotIssued()
    {
        return $this->hasMany('App\InvestmentInvestor')->where(['accepted' => '0', 'money_received' => '1', 'share_certificate_issued_at' => null]);
    }
}
