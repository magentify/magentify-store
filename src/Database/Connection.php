<?php

namespace App\Database;

use App\Database\Exception\DatabaseParsingException;
use App\ValueObject\Product;
use App\ValueObject\ProductInterface;
use JsonException;

readonly class Connection implements ConnectionInterface
{
    private array $data;

    /**
     * @throws DatabaseParsingException
     */
    public function __construct(string $databaseFullPath)
    {
        $content = file_get_contents($databaseFullPath);
        if (! is_string($content)) {
            throw new DatabaseParsingException();
        }
        try {
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new DatabaseParsingException($e->getMessage());
        }
        if (! is_array($data)) {
            throw new DatabaseParsingException();
        }
        $this->data = $data;
    }

    public function getProducts(string $locale): array
    {
        return array_map(static fn ($product) => new Product([
            'sku' => $product['sku'],
            'version' => $product['version'],
            'name' => $product['name'][$locale],
            'slug' => $product['slug'],
            'shortDescription' => $product['shortDescription'][$locale],
            'image' => $product['image'],
            'gallery' => $product['gallery'],
            'price' => $product['price'],
            'stripeLink' => $product['stripeLink'],
            'userGuideLink' => $product['userGuideLink'],
            'description' => $product['description'][$locale],
            'downloadLink' => $product['downloadLink'],
        ]), $this->data);
    }

    public function getProductBySlug(string $slug, string $locale): ?ProductInterface
    {
        return $this->getProductByField($slug, 'slug', $locale);
    }

    public function getProductBySku(string $sku, string $locale): ?ProductInterface
    {
        return $this->getProductByField($sku, 'sku', $locale);
    }

    private function getProductByField(string $value, string $field, string $locale): ?ProductInterface
    {
        foreach ($this->getProducts($locale) as $product) {
            if ($this->getFieldValue($product, $field) === $value) {
                return $product;
            }
        }

        return null;
    }

    private function getFieldValue(ProductInterface $product, string $field): ?string
    {
        return match ($field) {
            'slug' => $product->getSlug(),
            'sku' => $product->getSku(),
            default => null,
        };
    }
}
