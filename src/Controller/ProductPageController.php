<?php

namespace App\Controller;

use App\Database\ConnectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPageController extends AbstractController
{
    private ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    #[Route(
        path: '/{_locale}/product/{slug}',
        name: 'app_product_page',
        requirements: [
            '_locale' => '%app.supported_locales%',
        ]
    )
    ]
    public function index(string $_locale, string $slug): Response
    {
        $product = $this->connection->getProductBySlug($slug, $_locale);
        if ($product === null) {
            throw $this->createNotFoundException();
        }

        return $this->render('/Product/index.html.twig', [
            'product' => $product,
        ]);
    }
}
