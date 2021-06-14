<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Recipes;
use App\Entity\Vote;


class LoginController extends AbstractController
{

    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    #[Route('/login', name: 'login')]
    public function index(Request $request): Response
    {
        if ($this->session->get('id') !== -1 && $this->session->get('id') !== null) {
            return $this->redirectToRoute('home');
        }

        $errorMessage = $request->query->get('error');
        $successMessage = $request->query->get('success');
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'errorMessage' => $errorMessage,
            'successMessage' => $successMessage,
            'sessionid' => $this->session->get('id')
        ]);
    }

    #[Route('/process/login', name: 'process_login', methods: ['POST'])]
    public function processL(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('pwd');

        $repo = $this->getDoctrine()->getRepository(User::class);
        $search = $repo->findOneBy(['email' => $email]);
        if ($search != null && $password == $search->getPassword()) {

            $this->session->set('id', $search->getId());
            $this->session->set('email',$search->getEmail());
            return $this->redirect('/home');
        } else {
            return $this->redirectToRoute('login', ['error' => 'please verify you credentials']);
        }
    }

    #[Route("/signup", name: "signup")]
    public function signup(Request $request): Response
    {
        $errorMessage = $request->query->get('error');
        return $this->render('login/signup.html.twig', [
            'errorMessage' => $errorMessage
        ]);
    }

    #[Route('/process/signup', name: 'process_signup', methods: ['POST'])]
    public function processS(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('pwd');
        $repeat = $request->request->get('repeat');

        $repo = $this->getDoctrine()->getRepository(User::class);
        if ($repo->findOneBy(['email' => $email])) {
            return $this->redirectToRoute('signup', ['error' => 'email already used']);
        }

        if ($password != $repeat)
            return $this->redirectToRoute('signup', ['error' => 'passwords do not correspond']);

        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('login', ['success' => 'you have signed.']);
    }

    #[Route("/logout", name: "name")]
    public function logout(): Response
    {
        $this->session->set('id', -1);
        return $this->redirectToRoute('login');
    }


    #[Route('/home', name: 'home')]
    public function home(): Response
    {

        $logged = ($this->session->get('id') !== -1 && $this->session->get('id') !== null);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'logged' => $logged,
            'mail' => $this->session->get('email')
        ]);
    }


    #[Route('/', name: '')]
    public function no_route(): Response
    {
        return $this->redirectToRoute('home');
    }





    #[Route('/recipe/{id}', name: 'recipe')]
    public function recipe($id): Response
    {
        
        $userId = $this->session->get('id');

        $recipeRepo = $this->getDoctrine()->getRepository(Recipes::class);
        $userRepo = $this->getDoctrine()->getRepository(User::class);

        $recipe = $recipeRepo->find($id);
        $votes = $this->getDoctrine()->getRepository(Vote::class)->findBy(['receipt'=>$id]);

        if($userId == -1 || $userId == null){
            $isFavorite = false;
        }else{
            $user = $userRepo->find($userId);
            $isFavorite= $user->getFavorites()->contains($recipe);
        }
        return $this->render('recipe/recipe.html.twig', [
            'food' => $recipe,
            'votes' =>$votes,
            'isFavorite'=>$isFavorite
        ]);
    }


    #[Route('/handlecheck', name: 'hanldecheck',methods:['POST'])]
    public function handlecheck(Request $request): Response
    {
        $checked = $request->request->get('checked');


        $userId = $this->session->get('id');
        $recipeId = $request->request->get('id');

        if($userId == -1 || $userId == null)
            return $this->redirectToRoute('login',['error'=>'login required']);
        

        $manager = $this->getDoctrine()->getManager();
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $recipeRepo = $this->getDoctrine()->getRepository(Recipes::class);

        $user = $userRepo->find($userId);
        $recipe = $recipeRepo->find($recipeId);  
        

        if($checked)
            $user->addFavorite($recipe);
        else
            $user->removeFavorite($recipe);


        $manager->flush();
        

        return $this->redirect('recipe/'.$recipeId);
    }






    #[Route('/postcomment', name: 'postcomment', methods: ['POST'])]
    public function commenting(Request $request): Response
    {
        $recipeId = $request->request->get('id');
        $userId = $this->session->get('id');

        if($userId == -1 || $userId == null){
            return $this->redirectToRoute('login',['error'=>'login required']);
        }
        
        $recipeRepo = $this->getDoctrine()->getRepository(Recipes::class);
        $userRepo = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepo->find(intval($userId));
        $recipe=$recipeRepo->find($recipeId);



        $manager = $this->getDoctrine()->getManager();
        $newcomment= new Vote();
        $newcomment->setGrade($request->request->get('grade'));
        $newcomment->setComment($request->request->get('comment'));
        $newcomment->setReceipt($recipe);
        $newcomment->setUserId($user);
        $manager->persist($newcomment);
        $manager->flush();
        


        return $this->redirect('/recipe/'.$recipeId);
    }


    #[Route('/favorites', name: 'favorites')]
    public function favorites() : Response
    {
        $userId = $this->session->get('id');
        $userRepo = $this->getDoctrine()->getRepository(User::class); 
        $user = $userRepo->find($userId);

        $favorites = $user->getFavorites();
        
        

        return $this->render('favorite/favorites.html.twig',[
            'favorites'=>$favorites
        ]);
    }
}
