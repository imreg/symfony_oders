<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Abstracts\AbstractFixture;
use App\Entity\OrderItems;
use App\Entity\Orders;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrdersFixtures extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($index = 0; $index <= 10; $index++) {
            $orders = new Orders();
            $orders->setStatus(
                $this->faker->randomElement([Orders::STATUS_PENDING, Orders::STATUS_PAID, Orders::STATUS_APPROVED])
            );
            $orders->setProductName(ucfirst($this->faker->word()) . ' - Order');
            $orders->setCreated(new \DateTimeImmutable());
            $orders->setUpdated(new \DateTimeImmutable());

            $this->addOrderItems($orders);

            $manager->persist($orders);
        }
        $manager->flush();
    }

    /**
     * @param Orders $orders
     * @return void
     */
    public function addOrderItems(Orders $orders): void
    {
        for ($index = 0; $index <= $this->faker->randomNumber(1); $index++) {
            $orderItems = new OrderItems();
            $orderItems->setName($this->faker->words(2, true));
            $orderItems->setCreated(new \DateTimeImmutable());
            $orderItems->setUpdated(new \DateTimeImmutable());
            $orders->addOrderItem($orderItems);
        }
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
