<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Customer;
use App\Form\CustomerWithUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/*
* @Security("is_granted('ROLE_CUSTOMER_ADMIN')", 
* statusCode=403, 
* message="Vous n'avez pas les droits suffisant pour accéder à cette interface !")
*/
class CustomerController extends AbstractController
{


    /**
     * @Route("/customer", name="customer")
    */
    public function index(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $customer = new Customer();
        $form = $this->createForm(CustomerWithUserType::class, ['customer' => $customer, 'user' => $user]);
 
        $form->handleRequest($request);
        
        // prise en compte du formulaire
        if($form->isSubmitted() && $form->isValid()) {
 
            $user->setPassword($encoder->encodePassword($user, \uniqid('password_bidon')));
            $user->setRoles(['ROLE_USER','ROLE_CUSTOMER_ADMIN', 'ROLE_CUSTOMER']);
            $user->setCreatedAt(new \DateTime());
            $customer->setCreatedAt(new \DateTime());
            $customer->addUser($user);
 
            $manager->persist($customer); 
            $manager->flush(); 
            $this->addFlash('success', 'Le compte client a bien été créé !');
            return $this->redirectToRoute('home');
        }
 
        return $this->render('customer/index.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
