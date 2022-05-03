<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['book'=>'read']],
    denormalizationContext: ['groups' => ['book'=>'write']],
)]

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[Groups(["read", "write"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $name;
     #[Groups("write")]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $autor;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $pagenumbers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(?string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getPagenumbers(): ?int
    {
        return $this->pagenumbers;
    }

    public function setPagenumbers(?int $pagenumbers): self
    {
        $this->pagenumbers = $pagenumbers;

        return $this;
    }
}
