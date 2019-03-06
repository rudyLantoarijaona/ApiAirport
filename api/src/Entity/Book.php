<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"book_read"}},
 *     denormalizationContext={"groups"={"book_write"}},
 *     collectionOperations={
 *      "get"={
 *              "normalization_context"={"groups"={"author_get_read"}}
 *              },
 *      "post"
 *      },
 *      itemOperations={
 *          "get",
 *          "put",
 *          "delete"
 *      }
 * 
 * 
 * )
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"book_read","book_write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"book_read","book_write","author_get_read"})
     */
    private $Reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"book_read","book_write"})
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"book_read","book_write"})
     */
    private $Description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"book_read","book_write"})
     */
    private $PublicationDate;

    /**
     * @Groups({"book_read","book_write"})
     * @var string Author's foreign key
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     * @ApiSubresource()
     */
    private $Author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Copybook", mappedBy="Book")
     */
    private $copybooks;

    public function __construct()
    {
        $this->copybooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?int
    {
        return $this->Reference;
    }

    public function setReference(int $Reference): self
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->PublicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $PublicationDate): self
    {
        $this->PublicationDate = $PublicationDate;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->Author;
    }

    public function setAuthor(?Author $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    /**
     * @return Collection|Copybook[]
     */
    public function getCopybooks(): Collection
    {
        return $this->copybooks;
    }

    public function addCopybook(Copybook $copybook): self
    {
        if (!$this->copybooks->contains($copybook)) {
            $this->copybooks[] = $copybook;
            $copybook->setBook($this);
        }

        return $this;
    }

    public function removeCopybook(Copybook $copybook): self
    {
        if ($this->copybooks->contains($copybook)) {
            $this->copybooks->removeElement($copybook);
            // set the owning side to null (unless already changed)
            if ($copybook->getBook() === $this) {
                $copybook->setBook(null);
            }
        }

        return $this;
    }
}
