<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Post;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostService implements PostServiceInterface
{
    /**
     * PostService constructor.
     * @param Client $httpClient
     * @param string $url
     */
    public function __construct(
        private Client $httpClient,
        private string $url
    ) {}

    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {
        $data = [];
        $raw = $this->performRequest('GET', $this->url);
        $raw = $this->parseJson($raw);

        foreach ($raw as $state) {
            $data[] = Post::fromState((array) $state);
        }

        return $data;
    }

    /**
     * @param int $postId
     * @return Post
     */
    public function getPost(int $postId): Post
    {
        $url = sprintf('%s/%u', $this->url, $postId);
        $raw = $this->performRequest('GET', $url);
        $state = $this->parseJson($raw);
        return Post::fromState((array) $state);
    }

    /**
     * @param mixed ...$args
     * @return string
     */
    private function performRequest(...$args): string
    {
        try {
            $data = $this->httpClient
                ->request(...$args)
                ->getBody()
                ->getContents();
        } catch (ClientException $e) {
            if (Response::HTTP_NOT_FOUND === $e->getResponse()->getStatusCode()) {
                throw new NotFoundHttpException();
            }
        } catch (GuzzleException) {
            throw new \RuntimeException('Can\'t get data from the posts source API.');
        }

        return $data;
    }

    /**
     * @param $encoded
     * @return mixed
     */
    private function parseJson($encoded)
    {
        try {
            return json_decode($encoded, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException("Can't parse external data: {$e->getMessage()}");
        }
    }
}
