<?php

declare(strict_types=1);

namespace Setono\SyliusQuickOrderPlugin\Form\Type;

use Setono\SyliusQuickOrderPlugin\Controller\Command\QuickOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PasteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('data', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'setono_sylius_quick_order.ui.paste_placeholder',
                    'rows' => 20,
                ]
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_quick_order__paste';
    }
}
