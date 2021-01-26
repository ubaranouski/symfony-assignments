<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Client;
use App\Form\ClientRegistrationType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractFOSRestController
{
    /**
     * @param Request $request
     * @return Response|FormInterface
     * @OA\Post(
     *     path="/api/clients",
     *     description="Create new client",
     *     summary="Create new client"
     * ),
     * @OA\Tag(name="Clients", description="Client management")
     * @OA\RequestBody(
     *       description="Client's data",
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object",
     *               required={"firstName","lastName","file"},
     *               @OA\Property(
     *                   property="firstName",
     *                   type="string",
     *                   description="First Name"
     *               ),
     *               @OA\Property(
     *                   property="lastName",
     *                   type="string",
     *                   description="Last Name"
     *               ),
     *               @OA\Property(
     *                   property="file",
     *                   type="file",
     *                   description="Image (.jpg, .jpeg or .png)"
     *               )
     *           )
     *       )
     * )
     * @OA\Response(
     *     response="201",
     *     description="Created",
     * )
     * @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *         type = "object",
     *         example={
     *             "code": 400,
     *             "message": "Validation Failed",
     *             "errors": {
     *                 "children": {
     *                     "firstName": {
     *                         "errors": {
     *                             "Your first name must be at least 2 characters long"
     *                         }
     *                     },
     *                     "lastName": {},
     *                     "file": {}
     *                 }
     *             }
     *         }
     *     ),
     * )
     * @OA\Response(
     *     response="500",
     *     description="Something went wrong, please contact our technical staff"
     * )
     */
    #[Route("/api/clients", name: 'api_clients_create', methods: ['POST'])]
    public function create(Request $request)
    {
        $client = new Client();
        $form = $this->createForm(ClientRegistrationType::class, $client, [
            'csrf_protection' => false,
        ]);
        $form->submit(array_replace_recursive($request->request->all(), $request->files->all()));
        $view = View::create();

        if (!$form->isSubmitted()) {
            $view->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $this->getViewHandler()->handle($view);
        }

        if (!$form->isValid()) {
            $view->setData($form);
            return $this->getViewHandler()->handle($view);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();

        $view->setStatusCode(Response::HTTP_CREATED);
        return $this->getViewHandler()->handle($view);
    }
}
