<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 150)]
    private ?string $email = null;

     #[ORM\Column(type: 'integer')]
private ?int $nbr = 0;


    

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }
public function getNbr(): ?int
{
    return $this->nbr;
}

public function setNbr(int $nbr): self
{
    $this->nbr = $nbr;
    return $this;
}
   
   
    #[ORM\OneToMany(mappedBy: 'author1', targetEntity: Book::class, orphanRemoval: true)]
private Collection $books;

// helpers:
public function addBook(Book $book): static {
    if (!$this->books->contains($book)) { $this->books->add($book); $book->setAuthor1($this); }
    return $this;
}
public function removeBook(Book $book): static {
    if ($this->books->removeElement($book)) {
        if ($book->getAuthor1() === $this) { $book->setAuthor1(null); }
    }
    return $this;
}


}
