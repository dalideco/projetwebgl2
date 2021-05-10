<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;



class LoginController extends AbstractController
{

    private $session ;

    public function __construct()
    {
         $this->session= new Session();
    }

    #[Route('/login', name: 'login')]
    public function index(Request $request): Response
    {
        if($this -> session->get('id')!==-1 && $this->session->get('id')!==null){
            return $this->redirectToRoute('home');
        }

        $errorMessage= $request->query->get('error');
        $successMessage = $request->query->get('success');
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'errorMessage'=> $errorMessage,
            'successMessage'=> $successMessage ,
            'sessionid' => $this->session->get('id')
        ]);
    }

   #[Route('/process/login', name: 'process_login',methods:['POST'])]
    public function processL(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('pwd');

        $repo = $this->getDoctrine()->getRepository(User::class);
        $search = $repo->findOneBy(['email'=>$email]);
        if( $search != null && $password == $search->getPassword()){
            $this->session->set('id',$search->getEmail());
            return $this->redirect('/home');
        }
        else{
            return $this->redirectToRoute('login',['error' => 'please verify you credentials']);
        }
    }

    #[Route("/signup",name:"signup")]
    public function signup(Request $request): Response 
    {
        $errorMessage = $request->query->get('error');
        return $this->render('login/signup.html.twig',[
            'errorMessage' => $errorMessage
        ]);
    }

    #[Route('/process/signup', name: 'process_signup',methods:['POST'])]
    public function processS(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('pwd');
        $repeat = $request->request->get('repeat');

        $repo = $this ->getDoctrine()->getRepository(User::class);
        if($repo->findOneBy(['email'=>$email])){
            return $this->redirectToRoute('signup',['error'=>'email already used']);
        }

        if($password != $repeat)
            return $this->redirectToRoute('signup',['error'=>'passwords do not correspond']);

        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('login',['success'=>'you have signed.']);

    }

    #[Route("/logout",name:"name")]
    public function logout(): Response
    {
        $this->session->set('id',-1);
        return $this->redirectToRoute('login');
    }

}
