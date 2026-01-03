<?php

namespace App\Entity;

enum PartOfSpeech: string
{
    case Noun = 'noun';
    case Verb = 'verb';
    case Adjective = 'adjective';
    case Adverb = 'adverb';

    public static function toArray(): array
    {
        return array_map(static fn(self $p) => $p->value, self::cases());
    }
}
