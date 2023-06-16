<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MovieHasPeopleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\OpenApi\Model\Operation;

#[ORM\Entity(repositoryClass: MovieHasPeopleRepository::class)]
#[ApiResource]
// TODO : maybe embed movie data
#[GetCollection(
    uriTemplate: '/people/{id}/movies',
    //provider: PeopleInMovieProvider::class,
    uriVariables: [
        'id' => new Link(
            fromClass: People::class,
            fromProperty: 'movieHasPeople'
        ),
    ],
    openapi: new Operation(
        description: "Retrieves a collection of Movies in which a people has a role",
        summary: "Retrieves a collection of Movies in which a people has a role",
        requestBody: null,
    )
)]
// TODO : maybe embed people data
#[GetCollection(
    uriTemplate: '/movies/{id}/people',
    //provider: PeopleInMovieProvider::class,
    uriVariables: [
        'id' => new Link(
            fromClass: Movie::class,
            fromProperty: 'movieHasPeople'
        ),
    ],
    openapi: new Operation(
        description: "Retrieves a collection of People having a role in a movie",
        summary: "Retrieves a collection of People having a role in a movie",
        requestBody: null,
    )
)]
#[Get(
    uriTemplate: '/movies/{movie}/people/{people}',
    openapi: new Operation(
        description: "Retrieves information about a person in a movie",
        summary: "Retrieves information about a person in a movie",
        requestBody: null,
    )
)]
#[Delete(
    uriTemplate: '/movies/{movie}/people/{people}',
    openapi: new Operation(
        description: "Removes a people from a movie",
        summary: "Removes a people from a movie",
        requestBody: null,
    )
)]
#[Patch(
    uriTemplate: '/movies/{movie}/people/{people}',
    openapi: new Operation(
        description: "Updates the role of a people in a movie",
        summary: "Updates the role of a people in a movie",
        requestBody: null,
    )
)]
#[Put(
    uriTemplate: '/movies/{movie}/people/{people}',
    openapi: new Operation(
        description: "Replaces the role of a people in a movie",
        summary: "Replaces the role of a people in a movie",
        requestBody: null,
    )
)]
// TODO : maybe a special operation to add people to a movie cast and inversely
#[Post(
    openapi: new Operation(
        description: "Add a people in a movie",
        summary: "Add a people in a movie",
        requestBody: null,
    ))]
class MovieHasPeople
{
    public const SIGNIFICANCES = [null, 'principal', 'secondaire'];

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'movieHasPeople')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $movie = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'movieHasPeople')]
    #[ORM\JoinColumn(nullable: false)]
    private ?People $people = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Choice(choices: MovieHasPeople::SIGNIFICANCES, message: 'Choose a valid significance.')]
    private ?string $significance = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    public function getId(): string 
    {
        return $this->movie . "|" . $this->people;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getPeople(): ?People
    {
        return $this->people;
    }

    public function setPeople(?People $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getSignificance(): ?string
    {
        return $this->significance;
    }

    public function setSignificance(?string $significance): self
    {
        $this->significance = $significance;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
