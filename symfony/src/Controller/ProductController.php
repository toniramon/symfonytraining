<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends AbstractController
{

    /**
     * @Route("product", name="product_list")
     */
    public function list()
    {
        $response = new JsonResponse();
        $response->setData(
            [
                'success' => true,
                'data' => [
                    'id' => 1,
                    'name' => 'tomeu'
                ]
            ]
        );
        return $response;
    }
}