<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodingStyle\Rector\FuncCall\StrictArraySearchRector;
use Rector\CodingStyle\Rector\Property\InlineSimplePropertyAnnotationRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
    ]);

    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        LevelSetList::UP_TO_PHP_82
    ]);

    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon');

    $rectorConfig->rules([
        InlineSimplePropertyAnnotationRector::class,
        StrictArraySearchRector::class,
        InlineConstructorDefaultToPropertyRector::class,
    ]);
};
