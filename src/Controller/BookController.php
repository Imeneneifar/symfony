<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
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

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // Auteur sélectionné dans le formulaire
            $author = $book->getAuthor1();
            if ($author) {
                $author->setNbr($author->getNbr() + 1);
            }

            $em->persist($book);
            // $author est déjà "managed" via la relation, pas obligatoire mais OK :
            // $em->persist($author);
            $em->flush();

            $this->addFlash('success', 'Livre ajouté avec succès !');
            return $this->redirectToRoute('app_book_list');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/books/{id}/edit', name: 'app_book_edit')]
    public function edit(Request $req, EntityManagerInterface $em, Book $book): Response
    {
        // On garde l’auteur AVANT modification
        $oldAuthor = $book->getAuthor1();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // Auteur APRÈS modification
            $newAuthor = $book->getAuthor1();

            // Si l’auteur a changé → décrément ancien, incrément nouveau
            if ($oldAuthor && $oldAuthor !== $newAuthor) {
                $oldAuthor->setNbr(max(0, $oldAuthor->getNbr() - 1));
            }
            if ($newAuthor && $oldAuthor !== $newAuthor) {
                $newAuthor->setNbr($newAuthor->getNbr() + 1);
            }

            $em->flush();

            $this->addFlash('success', 'Livre modifié avec succès !');
            return $this->redirectToRoute('app_book_list');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }

    #[Route('/books/{id}/delete', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $req, EntityManagerInterface $em, Book $book): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$book->getId(), $req->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        // Décrémenter avant de supprimer
        $author = $book->getAuthor1();
        if ($author) {
            $author->setNbr(max(0, $author->getNbr() - 1));
        }

        $em->remove($book);
        $em->flush();

        $this->addFlash('danger', 'Livre supprimé');
        return $this->redirectToRoute('app_book_list');
    }
}
