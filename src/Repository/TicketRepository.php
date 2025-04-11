<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function getTicketCount(EntityManagerInterface $entityManager, \DateTimeInterface $heure)
    {
        $qb = $entityManager->createQueryBuilder();

        $qb->select('COUNT(t.id)')
            ->from(Ticket::class, 't')
            ->where('t.heure_arrivee < :heure')
            ->andWhere('t.statut = :statut')
            ->setParameter('heure', $heure)
            ->setParameter('statut', 'en attente');

        $count = $qb->getQuery()->getSingleScalarResult();

        return $count; // Exemple de retour JSON
    }

    public function findLastTicket(): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.numero', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByStatutEnAttente()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.statut = :status')
            ->setParameter('status', 'en attente')
            ->orderBy('t.heure_arrivee', 'ASC') // tri par heure d'arrivée décroissante
            ->getQuery()
            ->getResult();
    }
}
