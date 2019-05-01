<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $workgroup;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $kind;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $concept;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Expedient", inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $expedient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkgroup(): ?string
    {
        return $this->workgroup;
    }

    public function setWorkgroup(string $workgroup): self
    {
        $this->workgroup = $workgroup;

        return $this;
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function setKind(string $kind): self
    {
        $this->kind = $kind;

        return $this;
    }

    public function getConcept(): ?string
    {
        return $this->concept;
    }

    public function setConcept(string $concept): self
    {
        $this->concept = $concept;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getExpedient(): ?Expedient
    {
        return $this->expedient;
    }

    public function setExpedient(?Expedient $expedient): self
    {
        $this->expedient = $expedient;

        return $this;
    }
}
