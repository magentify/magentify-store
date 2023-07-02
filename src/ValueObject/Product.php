<?php

namespace App\ValueObject;

class Product implements ProductInterface
{
    private string $name;

    private string $slug;

    private string $shortDescription;

    private string $image;

    private array $gallery;

    private int $price;

    private string $stripeLink;

    private string $userGuideLink;

    private string $description;

    public function __construct(array $product)
    {
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
