<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/authorName/{name}', name: 'ShowAuthor')]
    public function ShowAuthor($name){
        return $this->render('author/show.html.twig' , ['Nom' => $name] );
    }

    #[Route('/afficher',name:'afficher')]
    public function Afficher(){
        return new Response ('Hello');

    }


    


    private function getAuthors(): array
    {
        return [
            1 => ['id' => 1, 'picture' => 'assets/images/symfony2.png','username' => 'Victor Hugo','email' => 'victor.hugo@gmail.com','nb_books'=>100],
            2 => ['id' => 2, 'picture' => 'assets/images/symfony3.png','username' => 'William Shakespeare','email' => 'william.shakespeare@gmail.com','nb_books'=>200],
            3 => ['id' => 3, 'picture' => 'assets/images/symfony4.png','username' => 'Taha Hussein','email' => 'taha.hussein@gmail.com','nb_books'=>300],
        ];
    }

    #[Route('/list', name: 'list')]
    public function listAuthors(): Response
    {
        $authors = $this->getAuthors();   
        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/{id}', name: 'author_details')]
    public function authorDetails($id): Response
    {
        $authors = $this->getAuthors();   
        $author = $authors[$id] ?? null;

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }


}
