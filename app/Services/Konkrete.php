<?php

namespace App\Services;

use Config;
use GuzzleHttp\Client;
use App\SiteConfiguration;

class Konkrete {

	protected $uri;
    protected $client;

	/**
	 * konkrete constructor
	 */
	public function __construct()
    {
        $this->uri = env('KONKRETE_API_URL', 'http://52.62.205.188:8082');
        $this->setClient(new Client());
    }

    /**
     * @param string     $method
     * @param string     $path
     * @param array      $headers
     * @param array|NULL $data
     * @return mixed
     */
    public function curlKonkrete($method, $path, $headers = [], $data = null, $options = [])
    {
    	$endPoint = $this->getUri() . $path;

        if (!empty($headers)) {
            $options['headers'] = $headers;
        }

        if ((strtoupper($method) == 'GET') && $data) {
            $endPoint .= http_build_query($data);
        }
        if (strtoupper($method) == 'POST') {
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

}
