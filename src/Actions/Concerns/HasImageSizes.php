<?php

namespace Rasasak\PexelsPicker\Actions\Concerns;

use Rasasak\PexelsPicker\Enums\ImageSize;

trait HasImageSizes
{
    protected ImageSize $imageSize = ImageSize::Large;

    public function original(): static
    {
        $this->imageSize = ImageSize::Original;

        return $this;
    }

    public function large2x(): static
    {
        $this->imageSize = ImageSize::Large2x;

        return $this;
    }

    public function large(): static
    {
        $this->imageSize = ImageSize::Large;

        return $this;
    }

    public function medium(): static
    {
        $this->imageSize = ImageSize::Medium;

        return $this;
    }

    public function small(): static
    {
        $this->imageSize = ImageSize::Small;

        return $this;
    }

    public function portrait(): static
    {
        $this->imageSize = ImageSize::Portrait;

        return $this;
    }

    public function landscape(): static
    {
        $this->imageSize = ImageSize::Landscape;

        return $this;
    }

    public function tiny(): static
    {
        $this->imageSize = ImageSize::Tiny;

        return $this;
    }

    public function imageSize(ImageSize $imageSize): static
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getImageSize(): ImageSize
    {
        return $this->imageSize;
    }
}
