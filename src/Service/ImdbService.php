<?php

namespace App\Service;

use App\Entity\Movie;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImdbService {

    private ?HttpClientInterface $http = null;
    private ?LoggerInterface $logger = null;

    private ?string $apiKey = null;
    
    private ?string $apiHost = null;


    public function getMoviePoster(string $title) {
        $r = $this->http->request('GET', '/auto-complete', [
            'query' => ['q' => $title]
        ]);
        try {
            $data = $r->toArray();
            if(count($data) > 0) {
                return $data['d'][0]['i']['imageUrl'];
            }
        }
        catch(\Exception $e) {
            echo($e);
            $this->logger->error("Invalid response from IMDB.", ['exception' =>$e]);
        }
        return null;
    }

    public function getRequestHeaders(): array 
    {
        return [
            'X-RapidAPI-Key'    => $this->apiKey,
            'X-RapidAPI-Host'   => $this->apiHost,
            'Accept'            => 'application/json'
        ];
    }

    public function __construct(string $apiHost, string $apiKey, HttpClientInterface $http, LoggerInterface $logger)
    {
        $this->apiHost = $apiHost;
        $this->apiKey = $apiKey;
        $this->logger = $logger;
        $this->http = $http->withOptions([
            'base_uri' => 'https://imdb8.p.rapidapi.com',
            'headers' => $this->getRequestHeaders()
        ]);
    }

}