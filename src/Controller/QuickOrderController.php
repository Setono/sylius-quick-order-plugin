<?php

declare(strict_types=1);

namespace Setono\SyliusQuickOrderPlugin\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Setono\Doctrine\ORMTrait;
use Setono\SyliusQuickOrderPlugin\Controller\Command\QuickOrder;
use Setono\SyliusQuickOrderPlugin\Controller\Command\QuickOrderItem;
use Setono\SyliusQuickOrderPlugin\Form\Type\QuickOrderType;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class QuickOrderController extends AbstractController
{
    use ORMTrait;

    public function __construct(
        private readonly CartContextInterface $cartContext,
        private readonly CartItemFactoryInterface $cartItemFactory,
        private readonly OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        private readonly OrderModifierInterface $orderModifier,
        ManagerRegistry $managerRegistry,
    ) {
        $this->managerRegistry = $managerRegistry;
    }

    public function index(Request $request): Response
    {
        $quickOrder = new QuickOrder();
        $quickOrder->addItem(new QuickOrderItem());

        $form = $this->createForm(QuickOrderType::class, $quickOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart = $this->cartContext->getCart();

            foreach ($quickOrder->getItems() as $item) {
                $cartItem = $this->createCartItem($item->getVariant());

                $this->orderItemQuantityModifier->modify($cartItem, $item->getQuantity());
                $this->orderModifier->addToOrder($cart, $cartItem);
            }

            $this->getManager($cart)->persist($cart);
            $this->getManager($cart)->flush();

            $this->addFlash('success', 'setono_sylius_quick_order.products_added_to_cart');

            return $this->redirectToRoute('setono_sylius_quick_order_shop_quick_order_index');
        }

        return $this->render('@SetonoSyliusQuickOrderPlugin/shop/quick_order/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createCartItem(?ProductVariantInterface $productVariant): OrderItemInterface
    {
        Assert::notNull($productVariant);

        $cartItem = $this->cartItemFactory->createNew();
        Assert::isInstanceOf($cartItem, OrderItemInterface::class);

        $cartItem->setVariant($productVariant);

        return $cartItem;
    }
}
