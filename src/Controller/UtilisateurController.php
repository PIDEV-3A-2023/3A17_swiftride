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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UtilisateurRepository;
use App\Repository\RoleRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Point;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    #[Route('/login', name: 'loginspace' , methods: ['GET', 'POST'])]
    public function index(Request $request,UtilisateurRepository $doctrine): Response
    { 
        $user = new Utilisateur();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $usertest=$doctrine->findOneBy(['login' => $user->getLogin()]);
            if($usertest && password_verify($user->getMdp(), $usertest->getMdp())){
               $this->session->start();
               $this->session->set('user_id', $user->getId());
                return $this->redirectToRoute('profile_page');
            };
        }
        return $this->render('utilisateur/login.html.twig', [
            'controller_name' => 'UtilisateurController', 'form' => $form->createView(),
        ]);
    }
    #[Route('/profile', name: 'profile_page' ,methods: ['GET', 'POST'])]
    public function profile(Request $request,UtilisateurRepository $utilisateurRepository): Response
    {$user=$utilisateurRepository->find(7);

        //$user = $doctrine->getRepository(Utilisateur::class)->find($this->session->get('user_id'));
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
       if($form->isSubmitted()&&$form->isValid()){
       if($user->getMdp()==$form->get('mdp')->getData()){
        $user=$utilisateurRepository->find(7);
        $user->setMdp($form->get('newmdp')->getData());
            $utilisateurRepository->save($user, true);
            return $this->redirectToRoute('profile_page');
        
        }
        else{
            return $this->redirectToRoute('profile_page');
        }
        }
        return $this->render('utilisateur/profile.html.twig', [
            'controller_name' => 'UtilisateurController', 'form' => $form->createView()
        ]);
    }
   
   

    #[Route('/signup', name: 'signup', methods: ['GET', 'POST'])]
    public function signup(Request $request,SluggerInterface $slugger,UtilisateurRepository $utilisateurRepository,RoleRepository $roleRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           $today = new \DateTime();
        $diff = $today->diff($user->getDateNaiss());
        $user->setAge($diff->format('%y'));
$personnel_directory = $this->getParameter('personnel_directory');
$permis_directory = $this->getParameter('permis_directory');

          $photopersonnel = $form->get('photo_personel')->getData();
            $photopermis = $form->get('photo_permis')->getData();
            
           if($photopersonnel && $photopermis){
            try {
                if ((!file_exists($personnel_directory))){
                    mkdir($personnel_directory, 0777, true);
                }
                if ((!file_exists($permis_directory))){
                    mkdir($permis_directory, 0777, true);
                }
                $photopersonnelname = pathinfo($photopersonnel->getClientOriginalName(), PATHINFO_FILENAME);
                $photopermisname =pathinfo($photopermis->getClientOriginalName(), PATHINFO_FILENAME);
                $safePersonnelname = $slugger->slug($photopersonnelname);
                $safePermisname = $slugger->slug($photopermisname);
                $newpersonnelname = 'personnel_directory'.'/'.$safePersonnelname.'-'.uniqid().'.'.$photopersonnel->guessExtension();
                $newpermisname = 'permis_directory'.'/'.$safePermisname.'-'.uniqid().'.'.$photopermis->guessExtension();
                    $photopersonnel->move(
                        $this->getParameter('personnel_directory'),
                        $newpersonnelname
                    );
                    $photopermis->move(
                        $this->getParameter('permis_directory'),
                        $newpermisname
                    );
                } catch (FileException $e) {
                    echo $e;
                }
            }
            $user->setPhotoPersonel($newpersonnelname);
            $user->setPhotoPermis($newpermisname);
            $user->setIdrole($roleRepository->find(2));
            $utilisateurRepository->save($user, true);
            return $this->redirectToRoute('loginspace');
           
        }
       return $this->render('utilisateur/signup.html.twig', [      
           'form' => $form->createView(),'roleid'=>$roleRepository->find(2),'user'=>$user->setIdrole($roleRepository->find(2))
         
       ]);
     

    }
    #[Route('/listeUser', name: 'user_liste', methods: ['GET'])]
    public function liste(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('admin/tables.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll()
        ]);
    }
    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur,UtilisateurRepository $utilisateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('user_liste', [], Response::HTTP_SEE_OTHER);
    }
}
