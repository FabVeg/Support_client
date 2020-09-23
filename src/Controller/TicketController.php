<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Entity\Ticket;
use App\Form\FileType;
use App\Entity\Message;
use App\Entity\Service;
use App\Form\TicketType;
use App\Form\MessageType;
use App\Repository\TicketRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function index(Request $request, EntityManagerInterface $manager)
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){ 

            $ticket->addService($this->getDoctrine()->getRepository(Service::class)->findOneByName("Support Client"));
            $ticket->setCreatedDate(new \DateTime());
            $ticket->setStatut('not_read');
            $ticket->setCustomer($this->getUser()->getCustomer());
            $ticket->setAuteur($this->getUser());

            $manager->persist($ticket);
            $manager->flush();

            $this->addflash("succes", "Le ticket a bien été créé !");
            return $this->redirectToRoute('ticket_list');
        }

        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
            'form' => $form->createView(),
        ]);
    }
     /**
     * @Route("/ticket_list", name="ticket_list")
     */
    public function list(TicketRepository $repo){
        return $this->render('ticket/list.html.twig', [
            'tickets' => $repo->findAll(),
        ]);
    }

    /**
    * @Route("/ticket_message/{id\d+}", name="ticket_message")
    */
    public function message(Ticket $ticket, Request $request, EntityManagerInterface $manager)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){ 

            $message->setTicket($ticket);
            $message->setAuteur($this->getUser());
            $message->setCreatedAt(new \DateTime);


            $manager->persist($message);
            $manager->flush();

            //$this->addflash("succes", "Le message a bien été créé !");
            //return $this->redirectToRoute('ticket_list');
           
        }
        return $this->render('ticket/message.html.twig', [
            'form' => $form->createView(),
            'ticket' => $ticket
        ]);
    }

    
}
