<?php

namespace App\Controller;
use App\Entity\Utilisateur;
use App\Form\ForgetPassType;
use App\Form\UtilisateurType;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\UtilisateurRepository;
use App\Repository\RoleRepository;
use App\Service\MailerService;
use App\Service\QrCodeGenerator;
use InvalidArgumentException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UtilisateurController extends AbstractController
{
    private $filesystem;
    private $roleRepository;
    private $utilisateurRepository;
    private $mailer;
    private $generetaQr;
    public function __construct(RoleRepository $roleRepository,UtilisateurRepository $utilisateurRepository,MailerService $mailer,QrCodeGenerator $generetaQr,Filesystem $filesystem )
    {  $this->filesystem=$filesystem;
         $this->generetaQr=$generetaQr;
        $this->mailer = $mailer;
        $this->utilisateurRepository = $utilisateurRepository;
        $this->roleRepository = $roleRepository;
    }

    #[Route('/', name: 'firstpage' , methods: ['GET', 'POST'])]
    public function toLogin(AuthenticationUtils $authenticationUtils,Request $request): Response
    {
        return $this->redirect('login');
         
    }
    #[Route('/login', name: 'loginspace' , methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils,Request $request): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(ProfileType::class);
        $form->handleRequest($request);
        return $this->render('utilisateur/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'form' =>$form->createView()
        ]);
    }
    #[Route('/profile', name: 'profile_page' ,methods: ['GET', 'POST'])]
    public function profile(Request $request,UtilisateurRepository $utilisateurRepository ,UserPasswordHasherInterface $userPasswordHasher,UserInterface $userInterface): Response
    {
        try{
            $message='';
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->getClickedButton() && 'submit' === $form->getClickedButton()->getName()) {
         if($form->get('newmdp')->getData()==null){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('mdp')->getData()
                )
            );
            $utilisateurRepository->save($user, true);
            return $this->redirectToRoute('profile_page');
         }
         else {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('newmdp')->getData()
                )
            );
            $utilisateurRepository->save($user, true);
            return $this->redirectToRoute('profile_page');
         }

           // if ($userPasswordHasher->isPasswordValid($userInterface, $form->get('mdp')->getData())) {
            } 
        
      //  }
      
    }
    if($form->getClickedButton() && 'delete' === $form->getClickedButton()->getName()) {  
        $this->deleteFile($user->getPhotoPersonel());
        $this->deleteFile($user->getPhotoPermis());
        $utilisateurRepository->remove($this->getUser(), true);
        $this->container->get('security.token_storage')->setToken(null);  
        
        return $this->redirectToRoute('loginspace');
    }
        }
        catch(AccessDeniedHttpException $ex){
        }

        catch(InvalidArgumentException $ex){
            $message='il y a des champs vides';
        }
      
        return $this->render('utilisateur/profile.html.twig', [
            'controller_name' => 'UtilisateurController', 'form' => $form->createView(),'user'=>$user,'message'=>$message,
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
     

    }  


    #[Route('/delete/{id}', name: 'user_delete', methods: ['GET','POST'])]
    public function delete(UtilisateurRepository $utilisateurRepository,$id,Request $request): Response
    {
       // if ($this->isCsrfTokenValid('delete'.$utilisateurRepository->find($id)->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateurRepository->find($id), true);
       //}

        return $this->redirectToRoute('liste_admin',[
            'm'=>$utilisateurRepository->find($id)
        ]);
    }
    #[Route('/forgetPass', name: 'forgetPass', methods: ['POST'])]
    public function forget(Request $request): Response
{
    $email1='skan.nasri@gmail.com';
    $email = $request->request->get('email');
    //if($this->utilisateurRepository->findByemail($email1))
          $this->mailer->sendEmail($email1);
          return $this->render('utilisateur/forgetPassword.html.twig', [
            'controller_name' => 'UtilisateurController'
        ]);
            
    }

    #[Route('/changePass', name: 'changePass', methods: ['GET','POST'])]
    public function change(Request $request,UserPasswordHasherInterface $userPasswordHasher,UtilisateurRepository $utilisateurRepository): Response
    {       //$user = $doctrine->getRepository(Utilisateur::class)->find($this->session->get('user_id'));
        $user = new Utilisateur();
            /*  $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                )
            );
                $utilisateurRepository->save($user, true);
                return $this->redirectToRoute('loginspace');
    */
            
        
        return $this->render('utilisateur/forgetPassword.html.twig', [
            'controller_name' => 'UtilisateurController'
        ]);
    }

  /*  #[Route('/listeUser', name: 'user_liste', methods: ['GET'])]
    public function liste(UtilisateurRepository $utilisateurRepository,RoleRepository $roleRepository): Response
    {

        return $this->render('admin/datatable.html.twig', [
            'utilisateurs' => $utilisateurRepository->findByRoleId($roleRepository->find(2))
        ]);
    }
*/
public function deleteFile(string $path)
{

     $this->filesystem->remove($path);

}
}
