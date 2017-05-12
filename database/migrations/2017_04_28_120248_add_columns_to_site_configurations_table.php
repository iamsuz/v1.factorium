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
                $table->string('title_text')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'facebook_link')) {
                $table->string('facebook_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'twitter_link')) {
                $table->string('twitter_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'youtube_link')) {
                $table->string('youtube_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'linkedin_link')) {
                $table->string('linkedin_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'google_link')) {
                $table->string('google_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'instagram_link')) {
                $table->string('instagram_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'blog_link')) {
                $table->string('blog_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'funding_link')) {
                $table->string('funding_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'terms_conditions_link')) {
                $table->string('terms_conditions_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'privacy_link')) {
                $table->string('privacy_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'financial_service_guide_link')) {
                $table->string('financial_service_guide_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'media_kit_link')) {
                $table->string('media_kit_link')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'investment_title_text1')) {
                $table->string('investment_title_text1')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'investment_title1_description')) {
                $table->string('investment_title1_description')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'homepg_btn1_gotoid')) {
                $table->string('homepg_btn1_gotoid')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'show_funding_options')) {
                $table->string('show_funding_options')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title1')) {
                $table->string('how_it_works_title1')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc1')) {
                $table->longText('how_it_works_desc1')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title2')) {
                $table->string('how_it_works_title2')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc2')) {
                $table->longText('how_it_works_desc2')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title3')) {
                $table->string('how_it_works_title3')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc3')) {
                $table->longText('how_it_works_desc3')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title4')) {
                $table->string('how_it_works_title4')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc4')) {
                $table->longText('how_it_works_desc4')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_title5')) {
                $table->string('how_it_works_title5')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'how_it_works_desc5')) {
                $table->longText('how_it_works_desc5')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_title1')) {
                $table->string('funding_section_title1')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_title2')) {
                $table->string('funding_section_title2')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_btn1_text')) {
                $table->string('funding_section_btn1_text')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'funding_section_btn2_text')) {
                $table->string('funding_section_btn2_text')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'website_name')) {
                $table->string('website_name')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'client_name')) {
                $table->string('client_name')->nullable();
            }
            if (!Schema::hasColumn('site_configurations', 'overlay_opacity')) {
                $table->decimal('overlay_opacity', 1, 1)->default(0.7);
            }
            if (!Schema::hasColumn('site_configurations', 'show_splash_message')) {
                $table->boolean('show_splash_message')->default(1);
            }
            if (!Schema::hasColumn('site_configurations', 'show_splash_page')) {
                $table->boolean('show_splash_page')->default(1);
            }
            if (!Schema::hasColumn('site_configurations', 'embedded_offer_doc_link')) {
                $table->string('embedded_offer_doc_link')->nullable();
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
            if (Schema::hasColumn('site_configurations', 'client_name')) {
                $table->dropColumn('client_name');
            }
            if (Schema::hasColumn('site_configurations', 'overlay_opacity')) {
                $table->dropColumn('overlay_opacity');
            }
            if (Schema::hasColumn('site_configurations', 'show_splash_message')) {
                $table->dropColumn('show_splash_message');
            }
            if (Schema::hasColumn('site_configurations', 'show_splash_page')) {
                $table->dropColumn('show_splash_page');
            }
            if (Schema::hasColumn('site_configurations', 'embedded_offer_doc_link')) {
                $table->dropColumn('embedded_offer_doc_link');
            }
        });
    }
}
