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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UtilisateurController extends AbstractController
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    #[Route('/login', name: 'loginspace' , methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
    
        return $this->render('utilisateur/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    #[Route('/profile', name: 'profile_page' ,methods: ['GET', 'POST'])]
    public function profile(Request $request,UtilisateurRepository $utilisateurRepository ,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();        //$user = $doctrine->getRepository(Utilisateur::class)->find($this->session->get('user_id'));
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getPassword() == $form->get('mdp')->getData()) {
    
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('newmdp')->getData()
                    )
                );
    
                $utilisateurRepository->save($user, true);
                return $this->redirectToRoute('profile_page');
    
            } else {
                return $this->redirectToRoute('profile_page');
            }
        }
        return $this->render('utilisateur/profile.html.twig', [
            'controller_name' => 'UtilisateurController', 'form' => $form->createView(),
        ]);
    }
   
   

    #[Route('/signup', name: 'signup', methods: ['GET', 'POST'])]
    public function signup(Request $request,SluggerInterface $slugger,UtilisateurRepository $utilisateurRepository,UserPasswordHasherInterface $userPasswordHasher ): Response
    {
        $message='';
        $message1='';
        $message2='';
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('mdp')->getData()
                )
            );
    
            $today = new \DateTime();
            $diff = $today->diff($user->getDateNaiss());
            $user->setAge($diff->format('%y'));
    
            $personelDirectory = $this->getParameter('personnel_directory');
            $permisDirectory = $this->getParameter('permis_directory');
    
            $photopersonnel = $form->get('photo_personel')->getData();
            $photopermis = $form->get('photo_permis')->getData();
    
            if ($photopersonnel && $photopermis) {
    
                try {
                    if ((!file_exists($personelDirectory))) {
                        mkdir($personelDirectory, 0777, true);
                    }
    
                    if ((!file_exists($permisDirectory))) {
                        mkdir($permisDirectory, 0777, true);
                    }
    
                    $photopersonnelname = pathinfo($photopersonnel->getClientOriginalName(), PATHINFO_FILENAME);
                    $photopermisname = pathinfo($photopermis->getClientOriginalName(), PATHINFO_FILENAME);
                    $slugger = new AsciiSlugger();
                    $safePersonnelname = $slugger->slug($photopersonnelname);
                    $safePermisname = $slugger->slug($photopermisname);
                    $newpersonnelname = 'personnel_directory' . '/' . $safePersonnelname . '-' . uniqid() . '.' . $photopersonnel->guessExtension();
                    $newpermisname = 'permis_directory' . '/' . $safePermisname . '-' . uniqid() . '.' . $photopermis->guessExtension();
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
            $user->setPhotoPersonel($newpersonnelname ?? "");
            $user->setPhotoPermis($newpermisname ?? "");
            $user->setRole($this->roleRepository->find(2));
            if($utilisateurRepository->findByemail($user->getLogin())){
                $message='email déja utilisé';
            }
            else if($utilisateurRepository->findBycin($user->getCin())){
                $message1='cin déja utilisé';
            }
            else if($utilisateurRepository->findBynumpermis($user->getNumPermis())){
                $message2='numéro de permis déja utilisé';
            }
            else {
            $utilisateurRepository->save($user, true);
            return $this->redirectToRoute('loginspace');
            }
        }
       return $this->render('utilisateur/signup.html.twig', [      
           'form' => $form->createView(),'message'=>$message,'message1'=>$message1,'message2'=>$message2
         
       ]);
     

    }   #[Route('/delete/{id}', name: 'user_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Utilisateur $utilisateur,UtilisateurRepository $utilisateurRepository,$id): Response
    {
        //if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateurRepository->find($id), true);
      //  }

        return $this->redirectToRoute('user_liste');
    }
    #[Route('/listeUser', name: 'user_liste', methods: ['GET'])]
    public function liste(UtilisateurRepository $utilisateurRepository,RoleRepository $roleRepository): Response
    {

        return $this->render('admin/datatable.html.twig', [
            'utilisateurs' => $utilisateurRepository->findByRoleId($roleRepository->find(2))
        ]);
    }
 
    
}
