<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Service;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){ 

            //$ticket->addService($this->getDoctrine()->getRepository(Service::class)->findOneById(1));
            $ticket->setCreatedDate(new \DateTime());
            $ticket->setStatut('not_read');
            $ticket->setCustomer($this->getUser()->getCustomer());
            $ticket->setAuteur($this->getUser());

            $manager->persist($ticket);
            $manager->flush();

            $this->addflash("succes", "Le ticket a bien été créé !");
            return $this->redirectToRoute('ticket');
        }

        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
            'form' => $form->createView(),
        ]);
    }
     /**
     * @Route("/ticket_list", name="ticket_list")
     */
    public function list(TicketRepository $repo)
    {
        return $this->render('ticket/list.html.twig', [
            'tickets' => $repo->findAll(),
        ]);
    }
}
