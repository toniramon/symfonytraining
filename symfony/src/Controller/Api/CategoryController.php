<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Form\Model\CategoryDto;
use App\Form\Type\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractFOSRestController
{

    /**
     * @Rest\Get(path="/categories")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAction(CategoryRepository $categoryRepository)
    {
        return $categoryRepository->findAll();
    }

    /**
     * @Rest\Post(path="/category")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(Request $request, EntityManagerInterface $em)
    {
        $categoryDto = new CategoryDto();
        $form = $this->createForm(CategoryFormType::class, $categoryDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $category = new Category();
            $category->setName($categoryDto->name);
            $category->setDescription($categoryDto->description);
            $em->persist($category);
            $em->flush();

            return $category;
        }

        return $form;
    }
}
