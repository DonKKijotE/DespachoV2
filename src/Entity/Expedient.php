<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpedientRepository")
 */
class Expedient
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
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $opponent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jurisdiction;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="expedients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invoice", mappedBy="expedient")
     */
    private $invoices;

    public function __construct()
    {
        $this->setCreated(new \DateTime('now'));
        $this->invoices = new ArrayCollection();
      
    }

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getOpponent(): ?string
    {
        return $this->opponent;
    }

    public function setOpponent(string $opponent): self
    {
        $this->opponent = $opponent;

        return $this;
    }

    public function getMatter(): ?string
    {
        return $this->matter;
    }

    public function setMatter(string $matter): self
    {
        $this->matter = $matter;

        return $this;
    }

    public function getJurisdiction(): ?string
    {
        return $this->jurisdiction;
    }

    public function setJurisdiction(string $jurisdiction): self
    {
        $this->jurisdiction = $jurisdiction;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setExpedient($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->contains($invoice)) {
            $this->invoices->removeElement($invoice);
            // set the owning side to null (unless already changed)
            if ($invoice->getExpedient() === $this) {
                $invoice->setExpedient(null);
            }
        }

        return $this;
    }
}
