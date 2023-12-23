<?php

namespace App\Controller;

use App\Form\ProductSearchType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenFoodFacts\Api;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(Api $api): Response
    {

        $defaultProductCode = '737628064502';
        $product = $api->getProduct($defaultProductCode);

        // Informations du produit
        dump($product->product_name);
        dump($product->code);
        dump($product->image_url);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'product' => $product,
        ]);
    }

    #[Route('/product/{code}', name: 'product_show')]
    public function productDetails($code, Api $api): Response
    {
        
        $product = $api->getProduct($code);
        dump($product);

        return $this->render('home/product_details.html.twig', [
            'product' => $product,
        ]);
    }
}
