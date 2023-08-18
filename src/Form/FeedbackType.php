<?php

namespace App\Form;

use App\Entity\Feedback;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Почта',
                'required' => true,
            ])
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'required' => false,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Сообщение',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10, 'max' => 512]),
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'Телефон'
            ])
            ->add('captcha', CaptchaType::class, [
                'label' => 'Капча'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
