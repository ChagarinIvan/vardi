<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LevelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $level = new Level(
            code: 'A1',
            orderIndex: 1,
        );

        $manager->persist($level);
        $manager->flush();
    }
}
