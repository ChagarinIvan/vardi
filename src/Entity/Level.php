<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'level')]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'smallint')]
    private int $id;

    #[ORM\Column(length: 2, unique: true)]
    private string $code;

    #[ORM\Column]
    private int $orderIndex;

    public function __construct(string $code, int $orderIndex)
    {
        $this->code = $code;
        $this->orderIndex = $orderIndex;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
