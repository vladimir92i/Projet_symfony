<?php

namespace App\Controller;

use App\Form\ProductSearchType;
use OpenFoodFacts\Api;
use OpenFoodFacts\Document\FoodDocument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function search(Request $request, Api $api): Response
    {
        $form = $this->createForm(ProductSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productName = $form->get('product_name')->getData();
            if (!empty($productName)) {
                return $this->redirectToRoute('search_results', ['query' => $productName]);
            } else {

                return $this->render('home/error.html.twig', [
                    'error' => 'barre de recherche vide',
                ]);
            }
            // Utilisez le nom de la route pour la redirection

        }

        return $this->render('search/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search-results/{query}', name: 'search_results')]
    public function searchResults($query, Api $api): Response
    {
        try {
            // Utiliser la méthode search de l'API avec le critère de recherche sur le nom du produit
            $results = $api->search($query);

            dump($results);

            return $this->render('search/search_results.html.twig', [
                'results' => $results
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
