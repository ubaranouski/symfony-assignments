<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'default', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientRegistrationType::class, $client, ['csrf_protection' => false]);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'form' => $form->createView()
        ]);
    }
}
