<?php

namespace Wolfnet\API;

use \Guzzle\Http\Client as HttpClient;

class Client {


    /* PROPERTIES ******************************************************************************* */

    private $host;
    private $port;
    private $version;
    private $timeout;


    /* CONSTRUCTOR ****************************************************************************** */

    public function __construct($host='api.wolfnet.com', $port=80, $version=1, $timeout=500)
    {
        $this->host = $host;
        $this->port = $port;
        $this->version = $version;
        $this->timeout = $timeout;

        $this->httpClient = new HttpClient('https://' . $this->host . ($this->port !== 80 ? ':' . $this->port : ''), [
            'default' => [
                'query' => [
                    'v' => $this->version
                ],
            ],
        ]);

    }


    /* PUBLIC METHODS *************************************************************************** */

    public function send($token, $resource, $method='GET', Array $data=[], Array $headers=[], $noAuth=false)
    {
        $headers['api_token'] = $token;

        $request = $this->httpClient->createRequest($method, $resource, $headers);

        $response = $this->httpClient->send($request);

        return json_decode($response->getBody());

    }


    public function authenticate($key)
    {
        $request = $this->httpClient->post('/core/auth');

        $query = $request->getQuery();
        $query->set('v', $this->version);
        $query->set('key', $key);

        $response = $this->httpClient->send($request);

        $responseData = json_decode($response->getBody());

        return $responseData->data->api_token;

    }


    /* PRIVATE METHODS ************************************************************************** */



}
