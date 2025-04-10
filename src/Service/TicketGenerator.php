<?php

namespace App\Service;

use App\Repository\TicketRepository;

class TicketGenerator
{
  private $ticketRepository;

  public function __construct(TicketRepository $ticketRepository)
  {
    $this->ticketRepository = $ticketRepository;
  }

  public function generateTicketNumber(): string
  {
    $lastTicket = $this->ticketRepository->findLastTicket();

    // Logique pour générer un numéro de ticket unique
    if ($lastTicket == null) {
      return 'A01';
    }

    $lastNumero = substr($lastTicket->getNumero(), 1); // ex: 1, 2, ...
    $lastLettre = substr($lastTicket->getNumero(), 0, 1); // ex: A, B, ...

    if ($lastNumero === '99') {
      $nextNumero = '01';
      $nextLettre = chr(ord($lastLettre) + 1); // Passe à la lettre suivante
    } else {
      $nextNumero = str_pad((int)$lastNumero + 1, 2, '0', STR_PAD_LEFT); // Incrémente le numéro
      $nextLettre = $lastLettre;
    }

    return $nextLettre . $nextNumero;
  }
}
