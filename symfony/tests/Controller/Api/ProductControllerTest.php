<?php


namespace App\Tests\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testItWorks()
    {
        $this->assertTrue(true);
    }

    public function testAssertGetAllProductsWorks(): void
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', 'api/products');

        // Validate a successful response and some content
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRouteDoesNotExist()
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', 'api/this-route-does-not-exists');

        // Validate a successful response and some content
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testProductHaveName()
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', 'api/products');
        $response = $client->getResponse();
        $firstProduct = json_decode($response->getContent());
        $firstProduct = $firstProduct[0];

        $this->assertObjectHasAttribute('name', $firstProduct);
    }

    public function testProductNameIsNotNull()
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', 'api/products');
        $response = $client->getResponse();
        $firstProduct = json_decode($response->getContent());
        $firstProduct = $firstProduct[0];

        $this->assertNotNull($firstProduct->name);
    }

    public function testProductCurrencyIsUSD()
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', 'api/products/featured?currency=USD');
        $response = $client->getResponse();
        $firstProduct = json_decode($response->getContent());
        $firstProduct = $firstProduct[0];

        $this->assertEquals('USD', $firstProduct->currency);
    }

    public function testProductCurrencyIsEUR()
    {
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', 'api/products/featured?currency=EUR');
        $response = $client->getResponse();
        $firstProduct = json_decode($response->getContent());
        $firstProduct = $firstProduct[0];

        $this->assertEquals('EUR', $firstProduct->currency);
    }

}