<?php

namespace App\Controller;

use App\Form\ServiceType;
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
    public function index(Request $request)
    {
        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);

        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
            'form' => $form->createView(),
        ]);
    }
}
