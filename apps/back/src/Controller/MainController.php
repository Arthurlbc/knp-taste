<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route(path: '/', name: 'app')]
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('base.html.twig');
    }
}