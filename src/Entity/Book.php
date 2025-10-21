<?php
namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]  
#[ORM\Column]
private ?int $id = null;


    #[ORM\Column(length: 150)]
    private ?string $title = null;

    #[ORM\Column(length: 150)]
    private ?string $category = null;

    


    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(type: 'boolean')]
    private bool $enabled = true;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Author $author1 = null;

    public function getId(): ?int { return $this->id; }
    public function setID(string $id): static { $this->id = $id; return $this; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $title): static { $this->title = $title; return $this; }

    public function getCategory(): ?string { return $this->category; }
    public function setCategory(string $category): static { $this->category = $category; return $this; }

    public function getPublicationDate(): ?\DateTimeInterface { return $this->publicationDate; }
    public function setPublicationDate(\DateTimeInterface $d): static { $this->publicationDate = $d; return $this; }

    public function isEnabled(): bool { return $this->enabled; }
    public function setEnabled(bool $enabled): static { $this->enabled = $enabled; return $this; }

    public function getAuthor1(): ?Author { return $this->author1; }
    public function setAuthor1(?Author $a): static { $this->author1 = $a; return $this; }
}
