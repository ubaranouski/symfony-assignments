<?php
declare(strict_types=1);

namespace App\Entity;

use OpenApi\Annotations as SWG;

class Post
{
    /**
     * Post constructor.
     */
    public function __construct(
        /**
         * @SWG\Property(type="integer")
         */
        private int $id,
        /**
         * @SWG\Property(type="string", maxLength=255)
         */
        private string $title,
        /**
         * @SWG\Property(type="string")
         */
        private string $body,
        /**
         * @SWG\Property(type="integer")
         */
        private int $userId,
    ) {}

    /**
     * @param array $data
     * @return self
     */
    public static function fromState(array $data): self
    {
        return new self($data['id'], $data['title'], $data['body'], $data['userId']);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return self
     */
    public function setBody(string $body): Post
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return self
     */
    public function setUserId(int $userId): Post
    {
        $this->userId = $userId;
        return $this;
    }
}
