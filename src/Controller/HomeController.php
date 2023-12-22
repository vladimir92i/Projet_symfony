<?php
// src/Controller/HomeController.php

namespace App\Controller;

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
        // Appel de l'API Open Food Facts pour obtenir une liste de produits
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://world.openfoodfacts.org/cgi/search.pl?json=1&action=process&page_size=5');

        // Traitement de la réponse JSON
        $data = $response->toArray();
        $products = $data['products'] ?? [];

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
?>