<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;   // <<< IMPORTANT
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BookController extends AbstractController
{
    #[Route('/books', name: 'app_book_list')]
public function index(BookRepository $repo): Response
{
    $books = $repo->findBy([], ['publicationDate' => 'DESC']);
    return $this->render('book/index.html.twig', ['books' => $books]);
}



#[Route('/books/new', name: 'app_book_new')]
public function new(Request $req, EntityManagerInterface $em): Response
{
    $book = new Book();
    $book->setEnabled(true);

    $form = $this->createForm(BookType::class, $book)->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {
        // auteur choisi dans le form (champ author1)
        $a = $book->getAuthor1();

        

        $em->persist($book);
        $em->flush();

        $this->addFlash('success', 'Livre ajouté ');
        return $this->redirectToRoute('app_book_list');
    }

    return $this->render('book/new.html.twig', [
        'form' => $form->createView(),
    ]);
}


#[Route('/books/{id}/edit', name: 'app_book_edit')]
public function edit(Request $req, EntityManagerInterface $em, Book $book): Response {
    $form = $this->createForm(BookType::class, $book)->handleRequest($req);
    if ($form->isSubmitted() && $form->isValid()) { $em->flush(); $this->addFlash('success','Modifié ✅'); return $this->redirectToRoute('app_book_list'); }
    return $this->render('book/edit.html.twig', ['form' => $form->createView(), 'book'=>$book]);
}

#[Route('/books/{id}/delete', name: 'app_book_delete', methods: ['POST'])]
public function delete(Request $req, EntityManagerInterface $em, Book $book): Response {
    if (!$this->isCsrfTokenValid('delete'.$book->getId(), $req->request->get('_token'))) {
        throw $this->createAccessDeniedException();
    }
    
    $em->remove($book); $em->flush();
    $this->addFlash('danger','Livre supprimé ❌');
    return $this->redirectToRoute('app_book_list');
}

}
