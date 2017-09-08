<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteConfiguration extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site_configurations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['site_logo', 'homepg_text1','homepg_btn1_text', 'title_text','facebook_link','twitter_link','youtube_link','linkedin_link','google_link','instagram_link', 'blog_link', 'terms_conditions_link', 'privacy_link', 'financial_service_guide_link', 'media_kit_link','investment_title_text1', 'investment_title1_description', 'homepg_btn1_gotoid', 'show_funding_options','how_it_works_title1','how_it_works_desc1','how_it_works_title2','how_it_works_desc2','how_it_works_title3','how_it_works_desc3','how_it_works_title4','how_it_works_desc4','how_it_works_title5','how_it_works_desc5','funding_section_title1','funding_section_title2','funding_section_btn1_text','funding_section_btn2_text','website_name', 'client_name', 'overlay_opacity','mailer_email', 'show_splash_message','show_splash_page','embedded_offer_doc_link','tag_manager_header','tag_manager_body', 'conversion_pixel', 'font_family', 'show_social_icons'];

    /**
     * Has many media
     * @return [type] [description]
     */ 
    public function siteconfigmedia()
    {
        return $this->hasMany('App\SiteConfigMedia');
    }
    /**
     * Has one field for one Configuration
     * @return [type] [description]
     */
    public function mailSetting()
    {
        return $this->hasOne('App\MailSetting');
    }
}
