<?php

namespace App\Controller;

use App\Form\FeedbackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    )
    {
    }

    #[Route('/feedback', name: 'app_feedback')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(FeedbackType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedback = $form->getData();
            $this->em->persist($feedback);
            $this->em->flush();

            $this->addFlash('success', 'Сообщение успешно отправлено.');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
