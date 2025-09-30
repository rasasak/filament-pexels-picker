<?php

namespace Rasasak\PexelsPicker\Enums;

enum ImageSize
{
    case Original;
    case Large2x;
    case Large;
    case Medium;
    case Small;
    case Portrait;
    case Landscape;
    case Tiny;

    public function getPath(): string
    {
        return match ($this) {
            self::Original => 'src.original',
            self::Large2x => 'src.large2x',
            self::Large => 'src.large',
            self::Medium => 'src.medium',
            self::Small => 'src.smal',
            self::Portrait => 'src.portrait',
            self::Landscape => 'src.landscape',
            self::Tiny => 'src.tiny',
        };
    }
}
