<?php

namespace App\DataFixtures;

use App\Entity\Level;
use App\Entity\PartOfSpeech;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WordFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $level = $manager->getRepository(Level::class)->findOneBy(['code' => 'A1']);

        $word = new Word(
            latvian: 'vards',
            russian: 'слово',
            level: $level,
            partOfSpeech: PartOfSpeech::Noun,
        );

        $manager->persist($word);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LevelFixtures::class,
        ];
    }
}
