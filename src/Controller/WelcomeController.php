<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\returnArgument;

final class WelcomeController extends AbstractController
{
    #[Route('/welcomecontroller', name: 'app_welcomecontroller')]
    public function index(): Response
    {
        return $this->render('welcomecontroller/index.html.twig', [
            'controller_name' => 'Welcome_Controller', 'classe' =>'3A25'
        ]);
    }

    #[Route('/hello/{id}', name: 'hello')]

    public function show($id): Response
    {
        return $this->render('welcomecontroller/index.html.twig', ['ident' => $id]) ;
    }

}
