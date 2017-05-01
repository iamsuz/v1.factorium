<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectConfiguration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'project_summary_label', 'summary_label', 'security_label', 'investor_distribution_label', 'suburb_profile_label', 'marketability_label', 'residents_label', 'investment_profile_label', 'investment_type_label', 'investment_security_label', 'expected_returns_label', 'return_paid_as_label', 'taxation_label', 'project_profile_label', 'developer_label', 'venture_label', 'duration_label', 'current_status_label', 'rationale_label', 'investment_risk_label', 'show_suburb_profile_map', 'overlay_opacity', 'show_summary_section', 'show_project_security_section', 'show_investor_distribution_section', 'show_marketability_section', 'show_residents_section', 'show_investment_type_section', 'show_investment_security_section', 'show_expected_return_section', 'show_return_paid_as_section', 'show_taxation_section', 'show_developer_section', 'show_duration_section', 'show_current_status_section', 'show_rationale_section', 'show_risk_section', 'show_prospectus_text', 'show_project_progress', 'show_project_progress_circle', 'show_project_thumbnail_on_home', 'expected_return_label_text', 'show_project_summary_whole_section', 'show_suburb_whole_section', 'show_investment_whole_section', 'show_project_profile_whole_section', 'show_how_to_invest_whole_section', 'show_project_faqs_whole_section'];

    public function project()
    {
        return $this->hasOne('App\Project');
    }
}
