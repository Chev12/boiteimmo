<?php

namespace App\State;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Movie;
use App\Service\ImdbService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;


class MovieProvider implements ProviderInterface
{
    private ?ImdbService $imdb = null;
    private ?ProviderInterface $itemProvider = null;
    private ?ProviderInterface $collectionProvider = null;
    private ?EntityManagerInterface $em = null;
    private ?LoggerInterface $logger = null;

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if($operation instanceof GetCollection){
            $item = $this->collectionProvider->provide($operation, $uriVariables, $context);
            if(count($item) <= 5) { // Too slow for more than that
                foreach($item as $movie) {
                    $this->setMovieImageUrl($movie);
                }
            }
        }
        else {
            $item = $this->itemProvider->provide($operation, $uriVariables, $context);
            $this->setMovieImageUrl($item);
        }

        $this->em->flush();
        return $item;
    }

    private function setMovieImageUrl(Movie $movie): void 
    {
        if(!$movie->getImageUrl()){
            $this->logger->info("Have to fetch image url for {$movie->getId()}-{$movie->getTitle()}.");
            $url = $this->imdb->getMoviePoster($movie->getTitle());
            if($url){
                $movie->setImageUrl($url);
            }
        }
    }

    public function __construct(ImdbService $imdb, ProviderInterface $itemProvider, ProviderInterface $collectionProvider, EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->imdb = $imdb;
        $this->itemProvider = $itemProvider;
        $this->collectionProvider = $collectionProvider;
        $this->em = $em;
        $this->logger = $logger;
    }
}
