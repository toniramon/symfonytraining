<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Form\Type\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

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
    public function postAction(Request $request, EntityManagerInterface $em)
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($product);
            $em->flush();

            return $product;
        }

    }
}
