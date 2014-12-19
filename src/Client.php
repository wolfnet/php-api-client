<?php

namespace \Wolfnet\API;

use \GuzzleHttp\Client as HttpClient;

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

        $this->httpClient = new HttpClient([
            'base_url' => 'https://' . $this->host . ($this->port !== 80 ? ':' . $this->port : ''),
            'default' => [
                'query' => [
                    'v' => $this->version
                ],
            ],
        ]);

    }


    /* PUBLIC METHODS *************************************************************************** */

    public function send($key, $resource, $method='GET', Array $data=[], Array $headers=[], $noAuth=false)
    {
        $requestOptions = [
            'headers' => $headers,
        ];

        if (array_search($method, ['POST', 'PUT', 'PATCH']) != -1) {
            $requestOptions['json'] = $data;
        } else {
            $requestOptions['query'] = $data;
        }

        $requestOptions['query']['v'] = $this->version;
        // $requestOptions['query']['key'] = $this->version;

        $request = $client->createRequest($method, $resource, $requestOptions);
    }


    /* PRIVATE METHODS ************************************************************************** */



}
