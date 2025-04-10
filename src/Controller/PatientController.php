<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Patient;
use App\Entity\Ticket;
use App\Service\TicketGenerator;
use App\Form\PatientType;
use App\Repository\TicketRepository;

final class PatientController extends AbstractController
{
    private $ticketGenerator;

    // Injection du service TicketGenerator dans le contrôleur
    public function __construct(TicketGenerator $ticketGenerator)
    {
        $this->ticketGenerator = $ticketGenerator;
    }
    #[Route('/', name: 'app_patient')]
    public function index(Request $request, EntityManagerInterface $manager)
    {
        $patient = new Patient();
        // Créer un nouveau ticket
        $ticket = new Ticket();


        $formPatient = $this->createForm(PatientType::class, $patient);

        $formPatient->handleRequest($request);

        if ($formPatient->isSubmitted() && $formPatient->isValid()) {
            // Enregistrer le ticket en base de données

            $ticket->setPatient($patient);
            $ticket->setStatut("en attente");
            $ticket->setNumero($this->ticketGenerator->generateTicketNumber());
            $heureArrivee = new \DateTime();

            $ticket->setHeureArrivee($heureArrivee);
            $manager->persist($patient);
            $manager->flush();
            $manager->persist($ticket);
            $manager->flush();
            return $this->redirectToRoute('ticket_page', ['id' => $ticket->getId()]);
        }

        return $this->render(
            'formulairePatient/formulairepatient.html.twig',
            [
                'formulairepatient' => $formPatient->createView(),
            ]
        );
    }


    #[Route('/ticket/{id}', name: 'ticket_page')]
    public function ticket(Ticket $ticket, TicketRepository $ticketRepository, EntityManagerInterface $manager)
    {

        $nbplaceinfront = $ticketRepository->getTicketCount($manager, $ticket->getHeureArrivee());
        $minuteperperson = 2;
        $waitingTime = $nbplaceinfront * $minuteperperson;

        return $this->render("ticket/ticketpage.html.twig", [
            'ticket' => $ticket,
            'waitingTime' =>  $waitingTime,

        ]);
    }
}
