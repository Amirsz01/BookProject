<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationService
{
    public function __construct(
        private readonly EntityManagerInterface      $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handleForm(FormInterface $form): void
    {
        $user = $form->getData();
        $plaintextPassword = $form->get('password')->getData();

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $this->em->persist($user);
        $this->em->flush();
    }
}
