<?php

namespace App\Http\Controllers;

use App\Services\Sitemap;
use App\Http\Controllers\Controller;

class SitemapController extends Controller {

    protected $sitemap;

    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }
    /**
     * Generates a sitemap.
     *
     * @return Response
     */
    public function generate()
    {
        $this->sitemap->addNamedRoutes(['home', 'news.crowdfundinsider', 'news.financialreview', 'news.realestatebusiness','news.startup88', 'news.startupdaily', 'news.startupsmart', 'notes.index', 'notes.create', 'pages.faq', 'pages.financial', 'pages.privacy', 'pages.subdivide.store', 'pages.subdivide', 'pages.team', 'pages.terms', 'projects.create']);
        $this->sitemap->addProjects();
        return $this->sitemap->render();
    }
}