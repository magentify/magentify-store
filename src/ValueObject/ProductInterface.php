<?php

namespace App\ValueObject;

interface ProductInterface
{
    public function getSku(): string;

    public function getName(): string;

    public function getSlug(): string;

    public function getShortDescription(): string;

    public function getImage(): string;

    /**
     * @return string[]
     */
    public function getGallery(): array;

    public function getPrice(): int;

    public function getStripeLink(): string;

    public function getUserGuideLink(): string;

    public function getDescription(): string;
}
