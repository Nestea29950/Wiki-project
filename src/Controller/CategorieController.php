<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/categorie/create", name="categorie_create")
     * @Route("/admin/categorie/{id}/edit", name="categorie_edit")
     */
    public function form(Categorie $categorie = null, Request $request, EntityManagerInterface $manager)
    {

        //Voir si la categorie  n'existe pas il en créé une
        if (!$categorie) {
            $categorie = new Categorie();
        }

        $form = $this->createForm(CategorieType::class, $categorie);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Préparation de l'objet et insertion dans la base de données
            $manager->persist($categorie);
            $manager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('categorie/create.html.twig', [
            'form_create_categorie' => $form->createView(),
            'editMode' => $categorie->getId() !== null,
        ]);
    }

    /**
     * @Route("/admin/categorie/{id}/delete", name="categorie_delete")
     */

    //Suppression d'une catégorie
    public function delete(Categorie $categorie, ManagerRegistry $doctrine)
    {
        $manager = $doctrine->getManager();
        $manager->remove($categorie);
        $manager->flush();

        return $this->redirectToRoute('app_home');
    }
}
