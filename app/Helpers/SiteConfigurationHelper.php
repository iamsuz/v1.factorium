<?php

namespace App\Helpers;
use App\SiteConfiguration;
use App\User;
use App\Color;
use Auth;

class SiteConfigurationHelper
{
    public static function getConfigurationAttr($url = null)
    {
        $siteUrl = $url ? $url : url();
    	$siteConfiguration =  SiteConfiguration::where('project_site', $siteUrl)->first();
        return $siteConfiguration;
    }

    public static function getEbConfigurationAttr()
    {
        $ebConfiguration = SiteConfiguration::where('project_site', 'https://estatebaron.com')->first();
        return $ebConfiguration;
    }

    public static function isSiteAdmin()
    {
        if(Auth::user()->roles->contains('role','admin') && Auth::user()->registration_site==url()){
            return 1;
        }
    	if(Auth::user()->roles->contains('role','master')){
            return 1;
        }
    	return 0;
    }

    public static function getSiteThemeColors($url = null)
    {
        $siteUrl = $url ? $url : url();
        $color = Color::where('project_site', $siteUrl)->first();
        return $color;
    }
}

?>