<?php

namespace App\Controller;

use App\Database\ConnectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    public function __construct(
        private readonly ConnectionInterface $connection
    ) {
    }

    #[Route('/{_locale}/', name: 'app_homepage', requirements: [
        '_locale' => '%app.supported_locales%',
    ])]
    public function index(string $_locale): Response
    {
        return $this->render('/Home/index.html.twig', [
            'products' => $this->connection->getProducts($_locale),
        ]);
    }
}
