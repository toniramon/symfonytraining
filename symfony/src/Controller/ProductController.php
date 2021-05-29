<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{

    /**
     * @Route("product", name="product_list")
     */
    public function list(): Response
    {
        $response = new Response();
        $response->setContent('<div>Hola sdfdsf</div>');
        return $response;
    }
}