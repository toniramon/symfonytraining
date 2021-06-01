<?php


namespace App\Tests\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CategoryControllerTest
 * @package App\Tests\Controller\Api
 *
 * Should get a TOP LEVEL delete action with previous
 * inserted category to avoid doing hardcoded IDs
 */
class CategoryControllerTest extends WebTestCase
{
    public function testItWorks()
    {
        $this->assertTrue(true);
    }

    // This should be in testing database
    public function testAssertCategoryIsCreated()
    {
        $client = static::createClient();

        $category = [
            "name" => "Testing Category",
            "description" => "Description of the category"
        ];

        // the required HTTP_X_REQUESTED_WITH header is added automatically
        $client->xmlHttpRequest('POST', '/api/category', $category);

        $response = $client->getResponse()->getContent();

        $responseCategory = json_decode($response);

        // Validate a successful response and some content
        $this->assertEquals('Testing Category', $responseCategory->name);
    }

    // This should be in testing database, DANGER!
    public function testAssertCategoryIsDeleted()
    {
        $client = static::createClient();

        $client->request('DELETE', 'api/category/6');

        $response = $client->getResponse()->getContent();

        $responseCategory = json_decode($response);

        // Validate a successful response and some content
        $this->assertEquals(null, $responseCategory->id);
    }

    // This should be in testing database, DANGER!
    public function testAssertCategoryDeleteNotFound()
    {
        $client = static::createClient();

        // the required HTTP_X_REQUESTED_WITH header is added automatically
        $client->request('DELETE', 'api/category/1232132');

        // Validate a successful response and some content
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }


}