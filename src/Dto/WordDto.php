<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\PartOfSpeech;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class WordDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $latvian,

        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        public string $russian,

        #[Assert\NotBlank]
        #[Assert\Length(max: 2)]
        public string $level,

        #[Assert\NotBlank]
        #[Assert\Choice(callback: [PartOfSpeech::class, 'toArray'])]
        public string $partOfSpeech,

        #[Assert\Url]
        public ?string $imageUrl = null,
    ) {}
}
