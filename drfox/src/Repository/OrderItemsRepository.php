<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\OrderItems;
use App\Entity\Reviews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderItems>
 *
 * @method OrderItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderItems[]    findAll()
 * @method OrderItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItems::class);
    }

    /**
     * @param int $id
     * @param array $data
     * @return OrderItems
     */
    public function addReview(int $id, array $data): OrderItems
    {
        $review = new Reviews();
        $review->setReviewText($data['text']);
        $review->setRating($data['rate']);
        $review->setCreated(new \DateTimeImmutable());
        $review->setUpdated(new \DateTimeImmutable());

        $orderItem = $this->find($id);
        $orderItem->setReviews($review);

        $this->getEntityManager()->persist($orderItem);
        $this->getEntityManager()->flush();

        return $orderItem;
    }
}
