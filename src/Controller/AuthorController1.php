<?php

namespace App\Controller;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController1 extends AbstractController
{
    #[Route('/authors', name: 'app_author_list')]
public function index(AuthorRepository $repo): Response
{
    return $this->render('author1/index.html.twig', [
        'authors' => $repo->findAll(),
    ]);
}


    #[Route('/authors/new', name: 'app_author_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($author);
            $em->flush();
            $this->addFlash('success', 'Auteur ajouté ');
            return $this->redirectToRoute('app_author_list');
        }

        return $this->render('author1/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/authors/{id}', name: 'app_author_show', requirements: ['id' => '\d+'])]
    public function show(AuthorRepository $repo, int $id): Response
    {
        $author = $repo->find($id);
        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        return $this->render('author1/show.html.twig', [
            'author' => $author,
        ]);
    }
    #[Route('/authors/{id}/edit', name: 'app_author_edit')]
    public function edit(Request $request, EntityManagerInterface $em, Author $author): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Auteur modifié avec succès ');
            return $this->redirectToRoute('app_author_list');
        }

        return $this->render('author1/edit.html.twig', [
            'form' => $form->createView(),
            'author' => $author,
        ]);
    }

#[Route('/authors/{id}/delete', name: 'app_author_delete', methods: ['POST'])]
public function delete(Request $request, EntityManagerInterface $em, Author $author): Response
{
    // sécurité CSRF
    if (!$this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
        throw $this->createAccessDeniedException('Jeton CSRF invalide');
    }

    $em->remove($author);
    $em->flush();

    $this->addFlash('danger', 'Auteur supprimé ');
    return $this->redirectToRoute('app_author_list');
}


}

