<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Guid\Guid;
use Ramsey\Uuid\Guid\GuidInterface;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private string $id;

    #[ORM\OneToOne(inversedBy: 'ticket', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patient $patient = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;


    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_arrivee = null;

    public function __construct()
    {
        // Générer un UUID v4 (Random)
        $this->id = Guid::uuid4()->toString();
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }



    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }


    public function getHeureArrivee(): ?\DateTimeInterface
    {
        return $this->heure_arrivee;
    }

    public function setHeureArrivee(\DateTimeInterface $heure_arrivee): static
    {
        $this->heure_arrivee = $heure_arrivee;

        return $this;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
