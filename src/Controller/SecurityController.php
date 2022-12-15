<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
use App\Form\UserType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // Route inscription
    #[Route('/inscription', name: 'app_inscription')]
    public function index(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $manager): Response
    {
        // ... e.g. get the user data from a registration form
        $user = new User();
        // Création d'un formulaire 
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $plaintextPassword = $user->getPassword();

            // hash the password (based on the security.yaml config for the $user class)
            // Permet de hasher le password en bdd
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            //Modifie le mot de passe pas hashé en hashé
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_inscription');
        }
        return $this->render('security/creation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    // Route login
    #[Route('/login', name: 'app_login')]

    public function indexlogin(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Render sur security/login.html.twig
        return $this->render('security/login.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    // Route qui permet de se déconnecter 
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    // Route qui permet de voir le privé 
    #[Route('/admin/prive', name: 'app_prive')]
    public function prive(ManagerRegistry $doctrine)
    {

        $articles = $doctrine->getRepository(Article::class)->findAll();

        return $this->render('security/prive.html.twig', [
            'articles' => $articles

        ]);
    }
}
