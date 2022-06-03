<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/trick', name: 'trick_')]
class TrickController extends AbstractController
{
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, string $uploadDir): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick)->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $trick->setCreatedAt(new DateTime());
            $trick->setFeaturedImage(sprintf('%s.%s', Uuid::v4(), $trick->getImageFile()->getClientOriginalExtension()));
            $trick->getImageFile()->move($uploadDir, $trick->getFeaturedImage());
            $entityManager->persist($trick);

            $entityManager->flush();

            return $this->redirectToRoute('trick_read', ['slug' => $trick->getSlug()]);
        }

        return $this->renderForm('trick/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/read/{slug}', name: 'read', methods: ['GET'])]
    public function read(Trick $trick): Response
    {
        return $this->render('trick/read.html.twig', [
            'trick' => $trick,
        ]);
    }

    #[Route('/edit/{slug}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trickRepository->add($trick, true);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, TrickRepository $trickRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $trickRepository->remove($trick, true);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
