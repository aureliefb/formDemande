<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $objet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $detail_demande = null;

    #[ORM\Column(length: 100)]
    private ?string $email_demandeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getDetailDemande(): ?string
    {
        return $this->detail_demande;
    }

    public function setDetailDemande(string $detail_demande): static
    {
        $this->detail_demande = $detail_demande;

        return $this;
    }

    public function getEmailDemandeur(): ?string
    {
        return $this->email_demandeur;
    }

    public function setEmailDemandeur(string $email_demandeur): static
    {
        $this->email_demandeur = $email_demandeur;

        return $this;
    }
}
