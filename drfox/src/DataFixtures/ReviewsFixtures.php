<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\DataFixtures\Abstracts\AbstractFixture;
use App\Entity\OrderItems;
use App\Entity\Reviews;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReviewsFixtures extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $orderItems = $manager->getRepository(OrderItems::class)->findAll();

        foreach ($orderItems as $key => $orderItem) {
            if ($this->faker->boolean() === true) {
                continue;
            }
            $review = new Reviews();
            $review->setOrderItem($orderItem);
            $review->setRating($this->faker->numberBetween(1, 5));
            $review->setReviewText($this->faker->realText());
            $review->setCreated(new \DateTimeImmutable());
            $review->setUpdated(new \DateTimeImmutable());
            $manager->persist($review);
        }

        $manager->flush();
    }

    /**
     * @return \class-string[]
     */
    public function getDependencies(): array
    {
        return [OrdersFixtures::class];
    }
}
