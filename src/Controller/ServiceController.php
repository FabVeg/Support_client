<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/*
* @Security("is_granted('ROLE_ADMIN')", 
* statusCode=403, 
* message="Vous n'avez pas les droits suffisant pour accéder à cette interface !")
*/
class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
    */    
    public function index(Request $request, EntityManagerInterface $manager){
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
 
            $service->setCreatedAt(new \DateTime);
 
            $manager->persist($service); 
            $manager->flush(); 

            $this->addFlash('success', 'Le service a bien été créé !');
            return $this->redirectToRoute('service_list');
        }

        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/service_list", name="service_list")
    */   
    public function list(ServiceRepository $repo){

        return $this->render('service/service_list.html.twig', [
            'services' => $repo->findAll(),
        ]);
    }
}
