<?php

namespace Wolfnet;

use \Wolfnet\API\Client;

class BasicTest extends \PHPUnit_Framework_TestCase
{


    public function testCreateClient()
    {
        $client = new Client();

        $this->assertInstanceOf('\Wolfnet\API\Client', $client);

        return $client;

    }


    /**
     * @depends testCreateClient
     */
    public function testAuthenticate(\Wolfnet\API\Client $client)
    {
        $token = $client->authenticate(CLIENT_KEY);

        $this->assertRegExp('/[A-Z0-9]{8}\-[A-Z0-9]{4}\-[A-Z0-9]{4}\-[A-Z0-9]{4}\-[A-Z0-9]{12}/', $token);

        return $token;

    }


    /**
     * @depends testCreateClient
     * @depends testAuthenticate
     */
    public function testBasicRequest(\Wolfnet\API\Client $client, $token)
    {
        $client->send($token, '/listing');
    }


}
