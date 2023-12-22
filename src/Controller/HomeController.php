<?php

namespace App\Controller;

use App\Form\ProductSearchType;
use OpenFoodFacts\Document\FoodDocument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenFoodFacts\Api;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(Request $request, Api $api): Response
    {
        $form = $this->createForm(ProductSearchType::class);
        $form->handleRequest($request);

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

        return $this->render('home/product_details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(Request $request, Api $api): Response
    {
        $form = $this->createForm(ProductSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productName = $form->get('product_name')->getData();

            // Utilisez le nom de la route pour la redirection
            return $this->redirectToRoute('search_results', ['query' => $productName]);
        }

        return $this->render('home/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/search-results/{query}', name: 'search_results')]
    public function searchResults($query, Api $api): Response
    {
        try {
            // Utiliser la méthode search de l'API avec le critère de recherche sur le nom du produit
            $results = $api->search($query);

            // Ajouter un var_dump pour déboguer les résultats
            dump($results);

            return $this->render('home/search_results.html.twig', [
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            // Ajouter un var_dump pour déboguer l'exception
            var_dump('Error:', $e->getMessage());

            return $this->render('home/error.html.twig', [
                'error' => $e,
            ]);
        }
    }


}
