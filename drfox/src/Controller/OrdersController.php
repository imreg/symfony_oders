<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\OrderItems;
use App\Repository\OrderItemsRepository;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class OrdersController extends AbstractController
{
    private OrdersRepository $ordersRepository;
    private OrderItemsRepository $orderItemsRepository;

    public function __construct(
        OrdersRepository     $ordersRepository,
        OrderItemsRepository $orderItemsRepository,
    )
    {
        $this->ordersRepository = $ordersRepository;
        $this->orderItemsRepository = $orderItemsRepository;
    }

    #[Route('/orders', name: 'app_orders')]
    public function index(): Response
    {
        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
            'orders' => $this->ordersRepository->findAll()
        ]);
    }

    #[Route('/items/{id}', name: 'order_item')]
    public function show(int $id): Response
    {
        $order = $this->ordersRepository->find($id);

        $items = $order->getOrderItems()->map(function ($items) use ($id) {
            /**
             * @var OrderItems $items
             */
            return [
                'id' => $items->getId(),
                'name' => $items->getName(),
                'orderId' => $id,
                'reviewText' => $items->getReviews()?->getReviewText() ?? null,
                'reviewRate' => $items->getReviews()?->getRating() ?? null,
            ];
        })->getValues();

        return $this->render('items/index.html.twig', [
            'order' => $order,
            'items' => $items,
        ]);
    }

    #[Route('/add-review/{itemId}', name: 'add_review', methods: ['POST'])]
    public function addReview(int $itemId, Request $request): Response
    {
        $orderItem = $this->orderItemsRepository->addReview(
            $itemId,
            [
                'text' => $request->request->get('review_text'),
                'rate' => intval($request->request->get('review_rate')),
            ]
        );

        return $this->redirectToRoute('order_item', ['id' => $orderItem->getOrders()->getId()]);
    }
}
