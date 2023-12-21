<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenFoodFacts\Api;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        // Utilisez la même logique pour obtenir un produit fictif ou un produit par défaut
        $api = new Api('food', 'fr');
        $product = $api->getProduct('737628064502');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'product' => $product,  // Ajoutez cette ligne pour définir la variable 'product'
        ]);
    }

    #[Route('/product/{code}', name: 'product_show')]
    public function productDetails($code): Response
    {
        $api = new Api('food', 'fr');

        $product = $api->getProduct($code);

        dump($product);

        $productImageUrl = $product->getImageFrontThumbUrl();

        return $this->render('home/product_details.html.twig', [
            'product' => $product,
            'product_image_url' => $productImageUrl,
        ]);
    }
}
