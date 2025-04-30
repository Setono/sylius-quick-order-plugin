<?php

declare(strict_types=1);

namespace Setono\SyliusQuickOrderPlugin\Controller\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class QuickOrder
{
    /** @var Collection<array-key, QuickOrderItem> */
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function hasItem(QuickOrderItem $quickOrderItem): bool
    {
        return $this->items->contains($quickOrderItem);
    }

    public function addItem(QuickOrderItem $quickOrderItem): void
    {
        if (!$this->hasItem($quickOrderItem)) {
            $this->items->add($quickOrderItem);
        }
    }

    public function removeItem(QuickOrderItem $quickOrderItem): void
    {
        if ($this->hasItem($quickOrderItem)) {
            $this->items->removeElement($quickOrderItem);
        }
    }

    /**
     * @return Collection<array-key, QuickOrderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
}
