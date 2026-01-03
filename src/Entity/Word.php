<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'word')]
final class Word
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $latvian;

    #[ORM\Column(length: 255)]
    private string $russian;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Level $level;

    #[ORM\Column(enumType: PartOfSpeech::class)]
    private PartOfSpeech $partOfSpeech;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column]
    private DateTimeImmutable $updatedAt;

    public function __construct(
        string $latvian,
        string $russian,
        Level $level,
        PartOfSpeech $partOfSpeech,
        ?string $imageUrl = null,
    ) {
        $this->latvian = $latvian;
        $this->russian = $russian;
        $this->level = $level;
        $this->partOfSpeech = $partOfSpeech;
        $this->imageUrl = $imageUrl;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getLatvian(): string
    {
        return $this->latvian;
    }

    public function getRussian(): string
    {
        return $this->russian;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getLevel(): Level
    {
        return $this->level;
    }

    public function getPartOfSpeech(): PartOfSpeech
    {
        return $this->partOfSpeech;
    }
}
