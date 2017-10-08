<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FacebookControllerTest extends WebTestCase
{
    public function testConnect()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'login');
    }

    public function testConnectcheck()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'facebook_check');
    }

}
