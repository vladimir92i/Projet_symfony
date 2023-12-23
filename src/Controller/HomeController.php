<?php
// src/Controller/HomeController.php

namespace App\Controller;

use Exception;
use GuzzleHttp\Psr7\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {

        dump($api);

        dump($product);

        return $this->render('home/index.html.twig', [
            'product' => $product,
        ]);
    }
    #[Route('/product', name: 'product')]
    public function ShowProduct(): Response
    {
        $api = new Api('food', 'fr');
        $categories = $api->getCategories('Pastas');
        dump($categories);

        // $product_categorie = $api->getByFacets($categories);

        return $this->render('home/product_show.html.twig', []);
    }



    #[Route('/product/{code}', name: 'product_show')]
    public function productDetails($code): Response
    {
        $api = new Api('food', 'fr');

        $product = $api->getProduct($code);

        dump($product);

        return $this->render('home/product_details.html.twig', [
            'product' => $product,

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
?>