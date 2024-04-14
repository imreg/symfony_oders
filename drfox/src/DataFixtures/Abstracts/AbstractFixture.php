<?php
declare(strict_types=1);

namespace App\DataFixtures\Abstracts;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

abstract class AbstractFixture extends Fixture
{
    /**
     * @var Generator
     */
    protected Generator|null $faker = null;

    public function __construct()
    {
        if ($this->faker === null) {
            $this->faker = Factory::create();
            $this->faker->addProvider('en_GB');
        }
    }
}