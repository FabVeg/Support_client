<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\UserRegisterController;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/*
* @Security("is_granted('ROLE_ADMIN')",
* statusCode=403, 
* message="Vous n'avez pas les droits suffisant pour accéder à cette interface !")
*/
class UserRegisterController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
    */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager)
    {
        $user = new User();
        $form = $this->createForm(UserRegisterType::class, $user, ['type_register' => 'sub_account']);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){   
            $password = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);
            $user->setCreatedAt(new \DateTime());

            $manager->persist($user);
            $manager->flush();

            $this->addflash("succes", "Le compte utilisateur a bien été créé !");
            return $this->redirectToRoute('home');
        }
    

    return $this->render('user_register/index.html.twig', [
      
        'form' => $form->createView(),
    ]);


    }

    /*
    *   @Route("/list", name="list")
    */
    public function list(UserRepository $repo)
    {
        $reposi = $repo->findAll();

        return $this->render('user_register/list.html.twig',[
            'user' => $reposi,
            'controller_name' => 'UserRegisterController',
        ]);
    }
}
