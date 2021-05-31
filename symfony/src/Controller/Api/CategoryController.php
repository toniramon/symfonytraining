<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Form\Model\CategoryDto;
use App\Form\Type\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @Rest\Put(path="/category/{id}")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function putAction(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository)
    {
        // Get Category
        $category = $categoryRepository->find($request->get('id'));
        $categoryName = $request->get('name');
        $categoryDescription = $request->get('description');

        if ($category) {
            $category->setName($categoryName);
            $category->setDescription($categoryDescription);

            $em->persist($category);
            $em->flush();

            return $category;
            }

        return new JsonResponse(['errors' => true, 'message' => 'Category not found'], 404, ['application/json']);

    }

    /**
     * @Rest\Delete(path="/category/{id}")
     * @Rest\View(serializerGroups={"category"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteAction(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository)
    {
        // Get Category
        $category = $categoryRepository->find($request->get('id'));

        if ($category) {
            $em->remove($category);
            $em->flush();

            return $category;
        }

        return new JsonResponse(['errors' => true, 'message' => 'Category not found'], 404, ['application/json']);

    }
}
