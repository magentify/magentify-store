<?php

namespace App\Database;

use App\ValueObject\ProductInterface;

interface ConnectionInterface
{
    /**
     * @return ProductInterface[]
     */
    public function getProducts(string $locale): array;

    public function getProductBySlug(string $slug, string $locale): ?ProductInterface;

    public function getProductBySku(string $sku, string $locale): ?ProductInterface;
}
