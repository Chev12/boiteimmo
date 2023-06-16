<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeopleInMovieController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('poeple_in_movie/index.html.twig', [
            'controller_name' => 'PoepleInMovieController',
        ]);
    }
}
