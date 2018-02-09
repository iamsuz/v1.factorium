<?php 

namespace App\Services;

use Laravelista\Bard\Laravel\Sitemap as Bard;
use App\Project;

class Sitemap extends Bard {
    /**
     * Use $this->addUrl() to add named route to sitemap.
     * You can also add translations and other properties
     * with the object returned from addUrl() method.
     * You will probably want to add translations also.
     *
     * @param $routeName
     * @return mixed
     */
    public function addNamedRoute($routeName)
    {
        $url = $this->addUrl(route($routeName));
        $url->setTranslations($this->getNamedRouteTranslations($routeName));
    }

    /**
     * Implement your own way for getting localized route url.
     *
     * @param $routeName
     * @param $locale
     * @return mixed
     */
    public function getLocalizedUrlForRouteName($routeName, $locale)
    {
        return LaravelLocalization::getLocalizedURL(
            $locale, parse_url(route($routeName) . '/', PHP_URL_PATH)
        );
    }
   
    public function addProjects()
    {
        $projects = Project::all();
        foreach($projects as $project)
        {
            $this->addProject($project);
        }
    }
    private function addProject(Project $project)
    {
        $url = $this->addUrl(route('projects.show', $project->id));
    }
}