<?php

namespace App\Controller;

use App\Form\FeedbackType;
use App\Service\FeedbackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{

    public function __construct(
        private readonly FeedbackService $feedbackService,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/feedback', name: 'app_feedback', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(FeedbackType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->feedbackService->handleForm($form);

            $this->addFlash('success', 'Сообщение успешно отправлено.');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
