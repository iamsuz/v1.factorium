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

    public static function isSiteSuperadmin()
    {
    	$isSuperadmin = 0;
    	if(Auth::user()->roles->contains('role','superadmin') && Auth::user()->registration_site==url()){
    		$isSuperadmin = 1;
    	}
    	return $isSuperadmin;
    }

    public static function isSiteAdmin()
    {
    	$isAdmin = 0;
    	if(Auth::user()->roles->contains('role','admin') && Auth::user()->registration_site==url()){
    		$isAdmin = 1;
    	}
    	return $isAdmin;
    }

    public static function getSiteThemeColors()
    {
        $color = Color::where('project_site', url())->first();
        return $color;
    }
}

?>