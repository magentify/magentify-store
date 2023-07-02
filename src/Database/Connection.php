<?php

namespace App\Database;

use App\ValueObject\Product;
use App\ValueObject\ProductInterface;
use JsonException;

class Connection implements ConnectionInterface
{
    private array $data;

    /**
     * @throws JsonException
     */
    public function __construct(string $databaseFullPath)
    {
        $this->data = json_decode(file_get_contents($databaseFullPath), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getProducts(string $locale): array
    {
        return array_map(static fn ($product) => new Product([
            'name' => $product['name'][$locale],
            'slug' => $product['slug'],
            'shortDescription' => $product['shortDescription'][$locale],
            'image' => $product['image'],
            'gallery' => $product['gallery'],
            'price' => $product['price'],
            'stripeLink' => $product['stripeLink'],
            'userGuideLink' => $product['userGuideLink'][$locale],
            'description' => $product['description'][$locale],
        ]), $this->data);
    }

    public function getProductBySlug(string $slug, string $locale): ?ProductInterface
    {
        foreach ($this->getProducts($locale) as $product) {
            if ($product->getSlug() === $slug) {
                return $product;
            }
        }

        return null;
    }
}
