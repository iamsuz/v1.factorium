<?php 

namespace App\Services;

use Config;
use GuzzleHttp\Client;
use App\SiteConfiguration;

class Sendgrid {

	protected $uri;
    protected $client;
    protected $appKey;
    
	/**
	 * Sendgrid constructor
	 */
	public function __construct()
    {
        $this->uri = "https://api.sendgrid.com/v3";
        $this->setAppKey(Config::get('services.sendgrid_key'));
        $this->setClient(new Client());
    }

    /**
     * @param string     $method
     * @param string     $path
     * @param array      $headers
     * @param array|NULL $data
     * @return mixed
     */
    public function curlSendgrid(string $method, string $path, Array $headers = [], Array $data = null, Array $options = [])
    {
    	$endPoint = $this->getUri() . $path;

        $sendgridAppKey = $this->getAppKey();
        $headers['Authorization'] = 'Bearer ' . $sendgridAppKey;

        if (!empty($headers)) {
            $options['headers'] = $headers;
        }

        if ($method == 'GET' && $data) {
            $endPoint .= http_build_query($data);
        }
        if ($method == 'POST') {
            $options['json'] = $data;
        }
        try {
            $response = $this->getClient()->request(
                $method,
                $endPoint,
                $options
            );
        } catch (\Exception $ex) {
        	return ['statusCode'=>$ex->getCode(), 'errorMsg' => $ex->getMessage()];
        }

        return json_decode($response->getBody()) ? (string)$response->getBody() : null;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }


    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getAppKey()
    {
        return $this->appKey;
    }

    /**
     * @param mixed $appKey
     */
    public function setAppKey($appKey)
    {
    	$siteConfiguration = SiteConfiguration::where('project_site', url())->first();
    	if($siteConfiguration)
    		$this->appKey = $siteConfiguration->sendgrid_api_key ? $siteConfiguration->sendgrid_api_key : $appKey;
    	else
    		$this->appKey = $appKey;
    }

}