<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\State\MovieProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MovieRepository;
use App\Entity\Type;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial', 'types' => 'exact'])]
#[ApiResource(provider: MovieProvider::class)]
#[ApiResource(provider: MovieProvider::class)]
#[GetCollection(
    uriTemplate: "/types/{id}/movies",
    uriVariables: [
        "id" => new Link(
            fromClass: Type::class,
            fromProperty: 'movies',
            toProperty: 'types'
    )]
)]
class Movie implements \Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: MovieHasPeople::class, orphanRemoval: true, fetch: "LAZY")]
    private Collection $movieHasPeople;

    #[ORM\ManyToMany(targetEntity: Type::class, inversedBy: 'movies', fetch: "LAZY")]
    #[ORM\JoinTable(name: 'movie_has_type')]
    #[ORM\JoinColumn(name: 'movie_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'type_id', referencedColumnName: 'id')]
    private Collection $types;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    public function __toString(): string 
    {
        return (string) $this->getId();
    }

    public function __construct()
    {
        $this->movieHasPeople = new ArrayCollection();
        $this->types = new ArrayCollection();
        $this->peoples = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, MovieHasPeople>
     */
    public function getMovieHasPeople(): Collection
    {
        return $this->movieHasPeople;
    }

    public function addMovieHasPerson(MovieHasPeople $movieHasPerson): self
    {
        if (!$this->movieHasPeople->contains($movieHasPerson)) {
            $this->movieHasPeople->add($movieHasPerson);
            $movieHasPerson->setMovie($this);
        }

        return $this;
    }

    public function removeMovieHasPerson(MovieHasPeople $movieHasPerson): self
    {
        if ($this->movieHasPeople->removeElement($movieHasPerson)) {
            // set the owning side to null (unless already changed)
            if ($movieHasPerson->getMovie() === $this) {
                $movieHasPerson->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        $this->types->removeElement($type);

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
