<?php

declare(strict_types=1);

namespace Setono\SyliusQuickOrderPlugin\Controller\Command;

use Sylius\Component\Core\Model\ProductVariantInterface;

final class QuickOrderItem
{
    private ?int $quantity = null;

    private ?ProductVariantInterface $variant = null;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getVariant(): ?ProductVariantInterface
    {
        return $this->variant;
    }

    public function setVariant(?ProductVariantInterface $variant): void
    {
        $this->variant = $variant;
    }
}
