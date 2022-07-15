<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $plateform = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: 'integer')]
    private ?int $plateformId;

    #[ORM\ManyToOne(targetEntity: Trick::class, inversedBy: 'videos')]
    private $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlateform(): ?string
    {
        return $this->plateform;
    }

    public function setPlateform(string $plateform): self
    {
        $this->plateform = $plateform;

        return $this;
    }

    public function getPlateformId(): ?int
    {
        return $this->plateformId;
    }

    public function setPlateformId(int $plateformId): self
    {
        $this->plateformId = $plateformId;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function getTrick()
    {
        return $this->trick;
    }

    public function setTrick($trick): void
    {
        $this->trick = $trick;
    }


}
