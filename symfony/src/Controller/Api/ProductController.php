<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Form\Model\ProductDto;
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
     * @Rest\Post(path = "/product")
     * @Rest\View(serializerGroups = {"product"}, serializerEnableMaxDepthChecks = true)
     */
    public function postAction(Request $request, EntityManagerInterface $em)
    {
        $productDto = new ProductDto();
        $form = $this->createForm(ProductFormType::class, $productDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $product = new Product();
            $product->setTitle($productDto->title);
            $em->persist($product);
            $em->flush();

            return $product;
        }

        return $form;
    }
}
