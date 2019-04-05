<?php

namespace App\Helpers;
use App\SiteConfiguration;
use App\User;
use App\Color;
use Auth;
use Config;

class SiteConfigurationHelper
{
    public static function getConfigurationAttr()
    {
    	$siteConfiguration = SiteConfiguration::where('project_site', url())->first();
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

    public static function getSiteThemeColors()
    {
        $color = Color::where('project_site', url())->first();
        return $color;
    }

    public static function isMasterRole()
    {
        if(Auth::user()->roles->contains('role', Config::get('constants.roles.MASTER'))){
            return 1;
        }
        return 0;
    }
}

?>