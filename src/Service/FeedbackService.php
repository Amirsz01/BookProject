<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class FeedbackService {
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MailerInterface $mailer,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handleForm(FormInterface $form): void
    {
        $email = (new Email())
            ->from($form->get('email')->getData())
            ->to(new Address($_ENV['FEEDBACK_EMAIL'], 'Feedback'))
            ->subject('Обратная связь')
            ->text($form->get('message')->getData());

        $this->mailer->send($email);

        $feedback = $form->getData();
        $this->em->persist($feedback);
        $this->em->flush();
    }
}
