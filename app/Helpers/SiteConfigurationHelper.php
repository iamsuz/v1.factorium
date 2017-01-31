<?php

namespace App\Helpers;
use App\SiteConfiguration;

class SiteConfigurationHelper
{
    public static function getConfigurationAttr()
    {
    	$siteConfiguration = SiteConfiguration::where('project_site', url())->first();
        return $siteConfiguration;
    }
}

?>