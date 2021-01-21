# Zadanie

Proszę napisać aplikację webową w dowolnym frameworku PHP która będzie
udostępniać REST API do pobierania postów na bloga.
W odpowiedzi API powinno zwracać JSONa.

Rozwiązane zadanie proszę wrzucić na github.com

### Endpoints:
1) GET posts

```json
[
  {
    "userId": 1,
    "id": 1,
    "title": "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
    "body": "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto"
  },
  {
    "userId": 1,
    "id": 2,
    "title": "qui est esse",
    "body": "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla"
  },
  ...
]
```

2) GET posts/:id

```json
{
  "userId": 1,
  "id": 1,
  "title": "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
  "body": "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto"
}
```

Controller powinnien mieć <u>wstrzyknięty</u> serwis do pobierania postów.
Serwis powinnien mieć <u>wstrzyknięty</u> HandlerInterface:

```php
interface HandlerInterface
{
    /**
    * @param int $postId
    *
    * @return Post
    */
    public function getPost(int $postId): Post;

    /**
    * @return Post[]
    */
    public function getAllPosts(): array;
}
```

### HandlerInterface:

Przy pomocy biblioteki Guzzle - https://github.com/guzzle/guzzle
posty powinny być pobrane z:
getAllPosts >> https://jsonplaceholder.typicode.com/posts
getPost >> https://jsonplaceholder.typicode.com/posts/:id
