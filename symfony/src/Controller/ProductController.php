<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends AbstractController
{
    /**
     * @Route("product", name="products_get")
     */
    public function index(Request $request, ProductRepository $productRepository)
    {
        $title = $request->get('title', 'fallbackName');
        $products = $productRepository->findAll();
        $productsArray = [];
        foreach($products as $product) {
            $productsArray[] = [
              'id' => $product->getId(),
              'title' => $product->getTitle()
            ];
        }
        $response = new JsonResponse();
        $response->setData(
            [
                'success' => true,
                'data' => $productsArray
            ]
        );
        return $response;
    }

    /**
     * @Route("product/create", name="product_create")
     */
    public function create(Request $request, EntityManagerInterface $em) {
        $product = new Product();
        $product->setTitle('Producto de prueba');
        $product->setDescription('desc de prueba');

        $em->persist($product);
        $em->flush();

        $response = new JsonResponse();
        $response->setData(
            [
                'success' => true,
                'data' => [
                    'id' => $product->getId(),
                    'title' => $product->getTitle()
                ]
            ]
        );

        return $response;
    }
}