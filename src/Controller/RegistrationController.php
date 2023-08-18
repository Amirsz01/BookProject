<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly RegistrationService $registrationService,
    )
    {
    }

    #[Route('/register', name: 'app_registration', methods: ["GET", "POST"])]
    public function index(Request $request): Response
    {
        $form = $this->createForm(RegistrationFormType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->registrationService->handleForm($form);

            $this->addFlash('success', 'Регистрация успешно пройдена.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
