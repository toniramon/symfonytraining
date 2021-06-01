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
use App\Service\ExchangeAPI\GetExchangeCurrencies;
use App\Service\Utils\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;


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
    public function getFeaturedAction(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {

        
        $exchangeCurrenciesWithValues = $this->getExchangecurrencies();

        $products = $productRepository->findBy(['featured' => true]);

        $currencyFilter = $request->query->get('currency');

       if ($currencyFilter) {
            // Get from api the exchange.
            foreach($products as $product) {
                $newPrice = $this->calculateExchangePrice($exchangeCurrenciesWithValues, $product->getCurrency(), $currencyFilter, $product->getPrice()); 
                $product->setPrice($newPrice);
                $product->setCurrency($currencyFilter);
           }
        }

        return $products;
    }

    private function getExchangecurrencies(){
        $api_key = $_ENV["EXCHANGE_API_KEY"];
        $exchange_api_url = $_ENV["EXCHANGE_API_URL"];
        
        $client = HttpClient::create();
        $response = $client->request('GET', $exchange_api_url . '/latest?symbols=EUR,USD&access_key=' . $api_key);

        // Get content
        $content = $response->getContent();

        // Return list of rates
        $data = json_decode($content);
        return $data->rates;
    }

    private function calculateExchangePrice($exchangeCurrenciesWithValues, $fromCurrency, $toCurrency, $price){

        if ($fromCurrency === $toCurrency){
            return $price;
        } 

        if($exchangeCurrenciesWithValues->$fromCurrency > $exchangeCurrenciesWithValues->$toCurrency) {
            return round($price / $exchangeCurrenciesWithValues->$fromCurrency, 2);
        } else {
            return round($price * $exchangeCurrenciesWithValues->$toCurrency, 2);
        }
    }
}
