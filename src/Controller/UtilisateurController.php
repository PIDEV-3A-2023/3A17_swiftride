<?php

namespace App\Controller;
use App\Controller\SessionController;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\LoginType;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
class UtilisateurController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    #[Route('/login', name: 'loginspace')]
    public function index(Request $request,ManagerRegistry $doctrine): Response
    { $user = new Utilisateur();
        
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $formData = $form->getData();
            $user=$doctrine->getRepository(Utilisateur::class)->findOneBy(['login' => $formData->getLogin()]);
            if($user && password_verify($formData->getMdp(), $user->getMdp())){
               //    $session=new SessionController($this->session);
               $this->session->start();
               $this->session->set('user_id', $user->getId());
                return $this->redirectToRoute('signup');
            };
        }
        return $this->render('utilisateur/login.html.twig', [
            'controller_name' => 'UtilisateurController', 'form' => $form->createView(),
        ]);
    }
    #[Route('/profile', name: 'profile_page')]
    public function profile(Request $request,ManagerRegistry $doctrine): Response
    {$user = new Utilisateur();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        return $this->render('utilisateur/profile.html.twig', [
            'controller_name' => 'UtilisateurController', 'form' => $form->createView(),
        ]);
    }
   

    #[Route('/signup', name: 'signup')]
    public function signup(Request $request,SluggerInterface $slugger,ManagerRegistry $doctrine): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user,[
            'method' => 'POST',
        ]);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $user = $form->getData();
           /* $nom=$request->query->get("nom"); 
            $prenom=$request->query->get("prenom");
            $cin=$request->query->get("cin");
            $tel=$request->query->get("numTel");
            $permisnum=$request->query->get("numPermis");
            $ville=$request->query->get("ville");
            $age=$request->query->get("age");
            $login=$request->query->get("login");
            $mdp=$request->query->get("mdp");
            $date=$request->query->get("dateNaiss");
          
            $photoPersonel=$request->query->get("photoPersonel");
            $photoPermis=$request->query->get("photoPermis");


*/

            $photopersonnel = $form->get('photoPersonel')->getData();
            $photopermis = $form->get('photoPermis')->getData();
           if($photopersonnel && $photopermis){
                $photopersonnelname = pathinfo($photopersonnel->getClientOriginalName(), PATHINFO_FILENAME);
                $photopermisname =pathinfo($photopermis->getClientOriginalName(), PATHINFO_FILENAME);
                $safePersonnelname = $slugger->slug($photopersonnelname);
                $safePermisname = $slugger->slug($photopermisname);
                $newpersonnelname = $safePersonnelname.'-'.uniqid().'.'.$photopersonnel->guessExtension();
                $newpermisname = $safePermisname.'-'.uniqid().'.'.$photopermis->guessExtension();
                try {
                    $photopersonnel->move(
                        $this->getParameter('photopersonnel'),
                        $newpersonnelname
                    );
                    $photopermis->move(
                        $this->getParameter('photopermis'),
                        $newpermisname
                    );
                } catch (FileException $e) {
                    echo $e;
                }
            }
            $user->setPhotoPersonel($newpersonnelname);
            $user->setPhotoPermis($newpermisname);
          /*  $user->setNom($nom);
$user->setPrenom($prenom);
$user->setCin($cin);
$user->setNumTel($tel);
$user->setNumPermis($permisnum);
$user->setVille($ville);
$user->setAge($age);
$user->setLogin($login);
$user->setMdp($mdp);
$user->setDateNaiss($date);
dump($user);*/
            $user->setIdrole(2);
            $em=$doctrine->getManager();
            $em->persist($user);
            $em->flush();
           
            return $this->redirectToRoute('loginspace');
           
        }
       return $this->render('utilisateur/signup.html.twig', [      
           'form' => $form->createView(),
         
       ]);
     

    }
}
