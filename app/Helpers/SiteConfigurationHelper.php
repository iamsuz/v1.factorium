<?php

namespace App\Helpers;
use App\SiteConfiguration;
use App\User;
use App\Color;
use Auth;

class SiteConfigurationHelper
{
    public static function getConfigurationAttr()
    {
    	$siteConfiguration = SiteConfiguration::where('project_site', url())->first();
        return $siteConfiguration;
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
}

?>