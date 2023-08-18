<?php

namespace App\Controller;

use App\Form\FeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    #[Route('/feedback', name: 'app_feedback')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(FeedbackType::class)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            dd($form);
        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
