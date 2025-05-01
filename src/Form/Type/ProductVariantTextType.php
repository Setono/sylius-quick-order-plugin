<?php

declare(strict_types=1);

namespace Setono\SyliusQuickOrderPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductVariantTextType extends AbstractType
{
    public function __construct(private readonly ProductVariantRepositoryInterface $productVariantRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @psalm-suppress InvalidArgument */
        $builder->addModelTransformer(new ResourceToIdentifierTransformer($this->productVariantRepository, 'code'));
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
