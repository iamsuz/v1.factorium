<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            if (!Schema::hasColumn('site_configurations', 'homepg_btn1_text')) {
                $table->string('homepg_btn1_text')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'title_text')) {
                $table->string('title_text')->default('estatebaron.com - Equity Crowdfunding | Flexible Crowd Sourced Equity Funding Solutions');
            }
            if (!Schema::hasColumn('site_configurations', 'facebook_link')) {
                $table->string('facebook_link')->default('https://whitelabel.estatebaron.com');
            }
            if (!Schema::hasColumn('site_configurations', 'twitter_link')) {
                $table->string('twitter_link')->default('https://whitelabel.estatebaron.com');
            }
            if (!Schema::hasColumn('site_configurations', 'youtube_link')) {
                $table->string('youtube_link')->default('https://whitelabel.estatebaron.com');
            }
            if (!Schema::hasColumn('site_configurations', 'linkedin_link')) {
                $table->string('linkedin_link')->default('https://whitelabel.estatebaron.com');
            }
            if (!Schema::hasColumn('site_configurations', 'google_link')) {
                $table->string('google_link')->default('https://whitelabel.estatebaron.com');
            }
            if (!Schema::hasColumn('site_configurations', 'instagram_link')) {
                $table->string('instagram_link')->default('https://whitelabel.estatebaron.com');
            }
            if (!Schema::hasColumn('site_configurations', 'blog_link')) {
                $table->string('blog_link')->default('https://whitelabel.estatebaron.com/blog_link');
            }
            if (!Schema::hasColumn('site_configurations', 'funding_link')) {
                $table->string('funding_link')->default('https://whitelabel.estatebaron.com/funding_link');
            }
            if (!Schema::hasColumn('site_configurations', 'terms_conditions_link')) {
                $table->string('terms_conditions_link')->default('https://whitelabel.estatebaron.com/terms_conditions_link');
            }
            if (!Schema::hasColumn('site_configurations', 'privacy_link')) {
                $table->string('privacy_link')->default('https://whitelabel.estatebaron.com/privacy_link');
            }
            if (!Schema::hasColumn('site_configurations', 'financial_service_guide_link')) {
                $table->string('financial_service_guide_link')->default('https://whitelabel.estatebaron.com/financial_service_guide_link');
            }
            if (!Schema::hasColumn('site_configurations', 'media_kit_link')) {
                $table->string('media_kit_link')->default('https://whitelabel.estatebaron.com/media_kit_link');
            }
            if (!Schema::hasColumn('site_configurations', 'investment_title_text1')) {
                $table->string('investment_title_text1')->default('Investment Structure and Security');
            }
            if (!Schema::hasColumn('site_configurations', 'investment_title1_description')) {
                $table->string('investment_title1_description')->default('We are a Corporate Authorised Representative of Guardian Securities Limited AFSL 7405661. The Vestabyte Investment Platform operates as a sub­trust within the Guardian Investment Fund (ARSN 168 048 057), a registered managed investment scheme.');
            }
            if (!Schema::hasColumn('site_configurations', 'homepg_btn1_gotoid')) {
                $table->string('homepg_btn1_gotoid')->default('projects');
            }
            if (!Schema::hasColumn('site_configurations', 'show_funding_options')) {
                $table->string('show_funding_options')->default('on');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title1')) {
                $table->string('how_it_works_title1')->default('Risky Markets');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc1')) {
                $table->string('how_it_works_desc1')->default('We live in an era of high stock market volatility, sharp crashes and ongoing risk of recession');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title2')) {
                $table->string('how_it_works_title2')->default('Safe Property');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc2')) {
                $table->string('how_it_works_desc2')->default('Real Estate and Property Development offer high, predictable returns but require large amounts of capital, which can make it hard to get started');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title3')) {
                $table->string('how_it_works_title3')->default('Property Crowdfunding');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc3')) {
                $table->string('how_it_works_desc3')->default('Property Crowdfunding is a way for many people to come together online and invest small amounts in projects of your choice');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title4')) {
                $table->string('how_it_works_title4')->default('Pick your Project');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc4')) {
                $table->string('how_it_works_desc4')->default('Sign up for free and invest with a click of a button in the projects that you like among the various opportunities listed');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title5')) {
                $table->string('how_it_works_title5')->default('Arm chair Developer');
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc5')) {
                $table->string('how_it_works_desc5')->default('Monitor your projects progress online and receive payments as specified in the offer, all from the comfort of your home!');
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_title1')) {
                $table->string('funding_section_title1')->default('Developer or Business looking for funding?');
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_title2')) {
                $table->string('funding_section_title2')->default('Are you an investor looking for investment opportunities?');
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_btn1_text')) {
                $table->string('funding_section_btn1_text')->default('Submit Venture');
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_btn2_text')) {
                $table->string('funding_section_btn2_text')->default('View Venture');
            }
            if (!Schema::hasColumn('site_configurations', 'website_name')) {
                $table->string('website_name')->default('Estate Baron');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            if (Schema::hasColumn('site_configurations', 'homepg_btn1_text')) {
                $table->dropColumn('homepg_btn1_text');
            }
            if (Schema::hasColumn('site_configurations', 'title_text')) {
                $table->dropColumn('title_text');
            }
            if (Schema::hasColumn('site_configurations', 'facebook_link')) {
                $table->dropColumn('facebook_link');
            }
            if (Schema::hasColumn('site_configurations', 'twitter_link')) {
                $table->dropColumn('twitter_link');
            }
            if (Schema::hasColumn('site_configurations', 'youtube_link')) {
                $table->dropColumn('youtube_link');
            }
            if (Schema::hasColumn('site_configurations', 'linkedin_link')) {
                $table->dropColumn('linkedin_link');
            }
            if (Schema::hasColumn('site_configurations', 'google_link')) {
                $table->dropColumn('google_link');
            }
            if (Schema::hasColumn('site_configurations', 'instagram_link')) {
                $table->dropColumn('instagram_link');
            }
            if (Schema::hasColumn('site_configurations', 'blog_link')) {
                $table->dropColumn('blog_link');
            }
            if (Schema::hasColumn('site_configurations', 'funding_link')) {
                $table->dropColumn('funding_link');
            }
            if (Schema::hasColumn('site_configurations', 'terms_conditions_link')) {
                $table->dropColumn('terms_conditions_link');
            }
            if (Schema::hasColumn('site_configurations', 'privacy_link')) {
                $table->dropColumn('privacy_link');
            }
            if (Schema::hasColumn('site_configurations', 'financial_service_guide_link')) {
                $table->dropColumn('financial_service_guide_link');
            }
            if (Schema::hasColumn('site_configurations', 'media_kit_link')) {
                $table->dropColumn('media_kit_link');
            }
            if (Schema::hasColumn('site_configurations', 'investment_title_text1')) {
                $table->dropColumn('investment_title_text1');
            }
            if (Schema::hasColumn('site_configurations', 'investment_title1_description')) {
                $table->dropColumn('investment_title1_description');
            }
            if (Schema::hasColumn('site_configurations', 'homepg_btn1_gotoid')) {
                $table->dropColumn('homepg_btn1_gotoid');
            }
            if (Schema::hasColumn('site_configurations', 'show_funding_options')) {
                $table->dropColumn('show_funding_options');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_title1')) {
                $table->dropColumn('how_it_works_title1');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_desc1')) {
                $table->dropColumn('how_it_works_desc1');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_title2')) {
                $table->dropColumn('how_it_works_title2');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_desc2')) {
                $table->dropColumn('how_it_works_desc2');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_title3')) {
                $table->dropColumn('how_it_works_title3');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_desc3')) {
                $table->dropColumn('how_it_works_desc3');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_title4')) {
                $table->dropColumn('how_it_works_title4');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_desc4')) {
                $table->dropColumn('how_it_works_desc4');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_title5')) {
                $table->dropColumn('how_it_works_title5');
            }
            if (Schema::hasColumn('site_configurations', 'how_it_works_desc5')) {
                $table->dropColumn('how_it_works_desc5');
            }
            if (Schema::hasColumn('site_configurations', 'funding_section_title1')) {
                $table->dropColumn('funding_section_title1');
            }
            if (Schema::hasColumn('site_configurations', 'funding_section_title2')) {
                $table->dropColumn('funding_section_title2');
            }
            if (Schema::hasColumn('site_configurations', 'funding_section_btn1_text')) {
                $table->dropColumn('funding_section_btn1_text');
            }
            if (Schema::hasColumn('site_configurations', 'funding_section_btn2_text')) {
                $table->dropColumn('funding_section_btn2_text');
            }
            if (Schema::hasColumn('site_configurations', 'website_name')) {
                $table->dropColumn('website_name');
            }
        });
    }
}
