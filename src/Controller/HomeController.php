<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Article;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //Recupération de toutes les catégories de maniere aleatoire
        $categories = $doctrine->getRepository(Categorie::class)->findAll();
        shuffle($categories);

        //Recupération de tous les articles de maniere aleatoire

        $articles = $doctrine->getRepository(Article::class)->findAll();
        shuffle($articles);



        // Récuperer que 2 catégories
        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'articles' => $articles

        ]);
    }
}
