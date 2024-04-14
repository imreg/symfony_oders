<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderItemsRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: OrderItemsRepository::class)]
class OrderItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orders = null;

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

    #[ORM\OneToOne(mappedBy: 'orderItem', cascade: ['persist', 'remove'])]
    private ?Reviews $reviews = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): static
    {
        $this->orders = $orders;

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

    public function getReviews(): ?Reviews
    {
        return $this->reviews;
    }

    public function setReviews(?Reviews $reviews): static
    {
        // unset the owning side of the relation if necessary
        if ($reviews === null && $this->reviews !== null) {
            $this->reviews->setOrderItem(null);
        }

        // set the owning side of the relation if necessary
        if ($reviews !== null && $reviews->getOrderItem() !== $this) {
            $reviews->setOrderItem($this);
        }

        $this->reviews = $reviews;

        return $this;
    }
}
