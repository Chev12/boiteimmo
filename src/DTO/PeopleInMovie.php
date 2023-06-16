<?php

namespace App\DTO;

use App\Entity\People;

class PeopleInMovie extends People 
{    
    private ?string $significanceInMovie = null;

    public function getSignificanceInMovie(): ?string
    {
        return $this->significanceInMovie;
    }

    public function setSignificanceInMovie(string $significanceInMovie): self
    {
        $this->significanceInMovie = $significanceInMovie;

        return $this;
    }

}