<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TitleExtension extends AbstractExtension
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'title',
                fn (?string $pageName = null): string => $this->getTitle($pageName)
            ),
        ];
    }

    public function getTitle(string $pageName = null): string
    {
        $title = $this->translator->trans('app.brand.name');
        if ($pageName) {
            $title = $pageName . ' | ' . $title;
        }
        return $title;
    }
}
