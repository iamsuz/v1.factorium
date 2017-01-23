<?php

namespace App\Helpers;
use App\SiteConfiguration;

class SiteConfigurationHelper
{
    public static function getConfigurationAttr()
    {
    	$siteConfiguration = SiteConfiguration::first();
        return $siteConfiguration;
    }
}

?>