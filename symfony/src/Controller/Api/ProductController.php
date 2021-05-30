<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ProductController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/products")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(ProductRepository $productRepository)
    {
        return $productRepository->findAll();
    }

    /**
     * @Rest\Post(path = "/products")
     * @Rest\View(serializerGroups = {"product"}, serializerEnableMaxDepthChecks = true)
     */
    public function postAction(EntityManager $em)
    {
        $product = new Product();
        $product->setTitle('Fos rest bundle');
        $product->setDescription('desc de prueba');

        $em->persist($product);
        $em->flush();

        return $product;
    }
}
