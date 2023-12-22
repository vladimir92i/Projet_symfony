<?php

namespace App\Controller;

use Exception;
use GuzzleHttp\Psr7\Request;
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

        ]);
    }
}
