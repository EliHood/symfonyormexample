<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index()
    {
        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/signup", name="signup")
     */

    public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder )
    {
    	$user = new User();

    	$entityManager = $this->getDoctrine()->getManager();

    	$user->setEmail($request->get('email'));
    	$user->setPlainPassword($request->get('password'));
        $user->setUsername($request->get('username'));
    	$password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('login');



    }


    /**
     * @Route("/login", name="login")
     */

    public function login(AuthenticationUtils $authenticationUtils):Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);

    }


}

