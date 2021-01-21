<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Service\PostServiceInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsApiController extends AbstractFOSRestController
{
    /**
     * PostsApiController constructor.
     * @param PostServiceInterface $service
     */
    public function __construct(
        public PostServiceInterface $service
    ) {}

    /**
     * @Route(
     *     "/api/posts",
     *     methods={"GET"},
     *     name="api_posts_list",
     *     condition="request.headers.get('Accept') matches '#application/json#'"
     * )
     * @OA\Get(
     *     path="/api/posts",
     *     description="Get an array  with all available posts",
     *     summary="Get all posts"
     * )
     * @OA\Tag(name="Posts", description="Posts management")
     * @OA\Response(
     *     response="200",
     *     description="OK",
     *     @OA\JsonContent(
     *         type = "array",
     *         @OA\Items(type="object", ref = @Model(type=Post::class)),
     *         example={
     *             {
     *                 "userId": 1,
     *                 "id": 1,
     *                 "title": "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
     *                 "body": "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto"
     *             },
     *             {
     *                 "userId": 1,
     *                 "id": 2,
     *                 "title": "qui est esse",
     *                 "body": "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla"
     *             }
     *         }
     *     ),
     * ),
     * @OA\Response(
     *     response="500",
     *     description="Something went wrong, please contact our technical staff"
     * )
     * @return Response
     */
    public function list(): Response
    {
        $data = $this->service->getAllPosts();
        $view = View::create()->setData($data);
        return $this->getViewHandler()->handle($view);
    }

    /**
     * @Route(
     *     "/api/posts/{id}",
     *     methods={"GET"},
     *     name="api_posts_single",
     *     condition="request.headers.get('Accept') matches '#application/json#'",
     *     requirements={"page"="\d+"}
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Post ID",
     *     required=true,
     *     @OA\Schema(
     *       type="integer",
     *     ),
     *     style="form"
     * ),
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     description="Get post by ID",
     *     summary="Get post by ID"
     * )
     * @OA\Tag(name="Posts", description="Posts management")
     * @OA\Response(
     *     response="200",
     *     description="OK",
     *     @Model(type=Post::class),
     *     @OA\JsonContent(
     *         example={
     *             "userId": 1,
     *             "id": 1,
     *             "title": "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
     *             "body": "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto"
     *         }
     *     ),
     * ),
     * @OA\Response(
     *     response="404",
     *     description="No posts found",
     *     @OA\JsonContent(
     *         example={
     *             "type": "https://tools.ietf.org/html/rfc2616#section-10",
     *             "title": "An error occurred",
     *             "status": 404,
     *             "detail": "Not Found"
     *         }
     *     )
     * )
     * @OA\Response(
     *     response="500",
     *     description="Something went wrong, please contact our technical staff"
     * )
     * @param int $id
     * @return Response
     */
    public function single(int $id): Response
    {
        $data = $this->service->getPost($id);
        $view = View::create()->setData($data);
        return $this->getViewHandler()->handle($view);
    }
}
