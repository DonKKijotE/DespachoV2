<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iddocument;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone_one;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone_two;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $additional_info;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Expedient", mappedBy="client")
     */
    private $expedients;

    public function __construct()
    {
        $this->setCreated(new \DateTime('now'));
        $this->expedients = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIddocument(): ?string
    {
        return $this->iddocument;
    }

    public function setIddocument(string $iddocument): self
    {
        $this->iddocument = $iddocument;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneOne(): ?string
    {
        return $this->phone_one;
    }

    public function setPhoneOne(?string $phone_one): self
    {
        $this->phone_one = $phone_one;

        return $this;
    }

    public function getPhoneTwo(): ?string
    {
        return $this->phone_two;
    }

    public function setPhoneTwo(?string $phone_two): self
    {
        $this->phone_two = $phone_two;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additional_info;
    }

    public function setAdditionalInfo(?string $additional_info): self
    {
        $this->additional_info = $additional_info;

        return $this;
    }

    /**
     * @return Collection|Expedient[]
     */
    public function getExpedients(): Collection
    {
        return $this->expedients;
    }

    public function addExpedient(Expedient $expedient): self
    {
        if (!$this->expedients->contains($expedient)) {
            $this->expedients[] = $expedient;
            $expedient->setClient($this);
        }

        return $this;
    }

    public function removeExpedient(Expedient $expedient): self
    {
        if ($this->expedients->contains($expedient)) {
            $this->expedients->removeElement($expedient);
            // set the owning side to null (unless already changed)
            if ($expedient->getClient() === $this) {
                $expedient->setClient(null);
            }
        }

        return $this;
    }
}
