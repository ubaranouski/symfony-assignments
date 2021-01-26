<?php

namespace App\Controller;

use App\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * AdminController constructor.
     * @param ClientService $clientService
     */
    public function __construct(
        private ClientService $clientService,
    ) {}

    /**
     * @return Response
     */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $data = $this->clientService->getAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'data' => $data
        ]);
    }
}
