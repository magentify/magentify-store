<?php

namespace App\Controller;

use App\Database\ConnectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    private ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
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
