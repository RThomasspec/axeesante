<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\TicketRepository;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;

class TicketAdminController extends AbstractController
{
  #[Route(path: '/admin/tickets', name: 'admin_tickets')]
  #[IsGranted('ROLE_EMPLOYE', message: 'You are not allowed to access the admin dashboard.')]
  public function adminPage(TicketRepository $ticketrepo)

  {
    $tickets = $ticketrepo->findByStatutEnAttente();

    // Logique pour l'administration des tickets
    return $this->render('admin/dashboard.html.twig', [
      'tickets' => $tickets
    ]);
  }



  #[Route(path: '/admin/ticketdelete/{id}', name: 'admin_ticketdelete')]
  #[IsGranted('ROLE_EMPLOYE', message: 'You are not allowed to access the admin dashboard.')]
  public function ticketDelete(Ticket $ticket, EntityManagerInterface $entityManager)

  {

    if (!$ticket) {
      throw $this->createNotFoundException(
        'No ticket found'
      );
    }


    $entityManager->remove($ticket);
    $entityManager->flush();



    return $this->redirectToRoute('admin_tickets');
  }
}
