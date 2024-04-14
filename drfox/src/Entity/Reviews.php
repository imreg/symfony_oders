<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reviewText = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\OneToOne(inversedBy: 'reviews', cascade: ['persist', 'remove'])]
    private ?OrderItems $orderItem = null;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime_immutable")
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(name: 'created', type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $created;

    /**
     * @ORM\Column(name="updated", type="datetime_immutable")
     * @Gedmo\Timestampable(on="update")
     */
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(name: 'updated', type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $updated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReviewText(): ?string
    {
        return $this->reviewText;
    }

    public function setReviewText(?string $reviewText): static
    {
        $this->reviewText = $reviewText;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        // Validate that the rating is between 1 and 5
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException("Invalid rating: $rating. Rating must be between 1 and 5.");
        }

        $this->rating = $rating;

        return $this;
    }

    public function getOrderItem(): ?OrderItems
    {
        return $this->orderItem;
    }

    public function setOrderItem(?OrderItems $orderItem): static
    {
        $this->orderItem = $orderItem;

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getCreated(): ?DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(?DateTimeImmutable $created): void
    {
        $this->created = $created;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getUpdated(): ?DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(?DateTimeImmutable $updated): void
    {
        $this->updated = $updated;
    }

}
