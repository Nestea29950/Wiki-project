<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/admin/article/create", name="article_create")
     * @Route("/admin/article/{id}/edit", name="article_edit")
     */
    public function form(Article $article = null, Request $request, EntityManagerInterface $manager)
    {

        //Voir si l'article  n'existe pas il en créé une
        if (!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Préparation de l'objet et insertion dans la base de données
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('article/create.html.twig', [
            'form_create_article' => $form->createView(),
            'editMode' => $article->getId() !== null,
        ]);
    }

    /**
     * @Route("/admin/article/{id}/delete", name="article_delete")
     */

    //Suppression d'un article
    public function delete(Article $article, ManagerRegistry $doctrine)
    {
        $manager = $doctrine->getManager();
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('app_home');
    }




    /**
     * @Route("/articles/{categorie_id}", name="articles_categ", requirements={"categorie_id"="\d+"})
     */
    public function categ(int $categorie_id, ManagerRegistry $doctrine): Response
    {
        $articles = $doctrine->getRepository(Article::class)->findBy(
            ['categorie' => $categorie_id]
        );


        if (!$articles) {
            return new Response(
                '<html><body>Aucun article pour cette catégorie</body></html>'
            );
        }


        return $this->render('article/article_categ.html.twig', [
            'controller_name' => 'ArticleController',
            'current_menu' => 'articles',
            'articles' => $articles,

        ]);
    }
    /**
     * @Route("/article/{article_id}", name="article_detail", requirements={"article_id"="\d+"})
     */
    public function detail(int $article_id, ManagerRegistry $doctrine): Response
    {
        $article = $doctrine->getRepository(Article::class)->find(
            $article_id
        );

        return $this->render('article/article_detail.html.twig', [
            'controller_name' => 'ArticleController',
            'current_menu' => 'articles',
            'article' => $article,

        ]);
    }
}
