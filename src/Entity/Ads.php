<?php

namespace App\Entity;

use App\Repository\AdsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource]
#[ORM\Entity(repositoryClass: AdsRepository::class)]
class Ads
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adsname;

    #[ORM\Column(type: 'string', length: 255)]
    private $adscontent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdsname(): ?string
    {
        return $this->adsname;
    }

    public function setAdsname(?string $adsname): self
    {
        $this->adsname = $adsname;

        return $this;
    }

    public function getAdscontent(): ?string
    {
        return $this->adscontent;
    }

    public function setAdscontent(string $adscontent): self
    {
        $this->adscontent = $adscontent;

        return $this;
    }
}
