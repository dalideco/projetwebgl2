<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;



class ProcessLoginController extends AbstractController
{
    #[Route('/process/login', name: 'process_login',methods:['POST'])]
    public function index(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('pwd');

        $repo = $this->getDoctrine()->getRepository(User::class);
        $search = $repo->findOneBy(['email'=>$email]);
        if( $search != null && $password == $search->getPassword()){
            return $this->redirect('/home');
        }
        else{
            return new Response("<h1>false credentials</h1>");
        }


        // $entityManager = $this->getDoctrine()->getManager();
        // $user = new User();
        // $user->setEmail($email);
        // $user->setPassword($password);
        // $entityManager->persist($user);
        // $entityManager->flush();
        // return new Response("<h1>".$search->getPassword()."</h1>");
    }
}
