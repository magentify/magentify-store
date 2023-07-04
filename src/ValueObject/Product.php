<?php

namespace App\ValueObject;

class Product implements ProductInterface
{
    private readonly string $sku;

    private readonly string $name;

    private readonly string $slug;

    private readonly string $shortDescription;

    private readonly string $image;

    private readonly array $gallery;

    private readonly int $price;

    private readonly string $stripeLink;

    private readonly string $userGuideLink;

    private readonly string $description;

    public function __construct(array $product)
    {
        $this->sku = $product['sku'];
        $this->name = $product['name'];
        $this->slug = $product['slug'];
        $this->shortDescription = $product['shortDescription'];
        $this->image = $product['image'];
        $this->gallery = $product['gallery'];
        $this->price = $product['price'];
        $this->stripeLink = $product['stripeLink'];
        $this->userGuideLink = $product['userGuideLink'];
        $this->description = $product['description'];
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getGallery(): array
    {
        return $this->gallery;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getStripeLink(): string
    {
        return $this->stripeLink;
    }

    public function getUserGuideLink(): string
    {
        return $this->userGuideLink;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}