<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\Model\ProductDto;
use App\Form\Type\ProductFormType;
use App\Repository\CategoryRepository;
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
    public function getAction(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $products = $productRepository->findAll();

        // Set relationship. // Not working. Need to be setted on Serializer
        foreach($products as $product) {
            if ($product->getCategory() !== null) {
                $product->category = $categoryRepository->find($product->getCategory());
            }
        }
        return $products;

    }

    /**
     * @Rest\Post(path = "/product")
     * @Rest\View(serializerGroups = {"product"}, serializerEnableMaxDepthChecks = true)
     */
    public function postAction(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository)
    {
        $productDto = new ProductDto();
        $form = $this->createForm(ProductFormType::class, $productDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $product = new Product();
            $product->setName($productDto->name);
            $product->setPrice($productDto->price);
            $product->setCurrency($productDto->currency);
            $product->setFeatured($productDto->featured);

            // If there is a category, create it.
            $category = $categoryRepository->find($productDto->category);

            // relates this product to the category
            if ($category){
                $product->setCategory($category);
            }

            $em->persist($product);
            $em->flush();

            return $product;
        }

        return $form;
    }

    /**
     * @Rest\Get(path="/products/featured")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */
    public function getFeaturedAction(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $products = $productRepository->findBy(['featured' => true]);
        return $products;

    }
}
