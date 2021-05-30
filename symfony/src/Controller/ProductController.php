<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("product", name="product_list")
     */
    public function index(Request $request)
    {
        $title = $request->get('title', 'fallbackName');
        $this->logger->info("This is a test");
        $response = new JsonResponse();
        $response->setData(
            [
                'success' => true,
                'data' => [
                    'id' => 1,
                    'name' => $title
                ]
            ]
        );
        return $response;
    }
}