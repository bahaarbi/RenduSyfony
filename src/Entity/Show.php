<?php

namespace App\Entity;

use App\Repository\ShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShowRepository::class)]
#[ORM\Table(name: '`show`')]
class Show
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $NumShow = null;

    #[ORM\Column(length: 255)]
    private ?string $Nbrseat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Dateshow = null;

    /**
     * @var Collection<int, TheatrePlay>
     */
    #[ORM\OneToMany(targetEntity: TheatrePlay::class, mappedBy: 'Shows')]
    private Collection $theatrePlays;

    public function __construct()
    {
        $this->theatrePlays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumShow(): ?int
    {
        return $this->NumShow;
    }

    public function setNumShow(int $NumShow): static
    {
        $this->NumShow = $NumShow;

        return $this;
    }

    public function getNbrseat(): ?string
    {
        return $this->Nbrseat;
    }

    public function setNbrseat(string $Nbrseat): static
    {
        $this->Nbrseat = $Nbrseat;

        return $this;
    }

    public function getDateshow(): ?\DateTimeInterface
    {
        return $this->Dateshow;
    }

    public function setDateshow(\DateTimeInterface $Dateshow): static
    {
        $this->Dateshow = $Dateshow;

        return $this;
    }

    /**
     * @return Collection<int, TheatrePlay>
     */
    public function getTheatrePlays(): Collection
    {
        return $this->theatrePlays;
    }

    public function addTheatrePlay(TheatrePlay $theatrePlay): static
    {
        if (!$this->theatrePlays->contains($theatrePlay)) {
            $this->theatrePlays->add($theatrePlay);
            $theatrePlay->setShows($this);
        }

        return $this;
    }

    public function removeTheatrePlay(TheatrePlay $theatrePlay): static
    {
        if ($this->theatrePlays->removeElement($theatrePlay)) {
            // set the owning side to null (unless already changed)
            if ($theatrePlay->getShows() === $this) {
                $theatrePlay->setShows(null);
            }
        }

        return $this;
    }
}
