<?php

namespace App\Repository;

use Amar\Framework\Http\NotFoundException;
use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class PostRepository
{
  public function __construct(
    private Connection $connection
  ) {}

  public function getById(int $id): ?Post
  {

    $queryBuilder = $this->connection->createQueryBuilder();

    $queryBuilder
      ->select('id', 'title', 'body', 'created_at')
      ->from("posts")
      ->where("id = :id")
      ->setParameter("id", $id);

    $result = $queryBuilder->executeQuery();

    $row = $result->fetchAssociative();
    if (!$row) {
      return null;
    }

    $post = Post::create(
      id: $row['id'],
      title: $row['title'],
      body: $row['body'],
      createdAt: new DateTimeImmutable($row['created_at'])
    );
    return $post;
  }

  public function findOrFail(int $id): Post
  {

    $post = $this->getById($id);
    if (!$post) {

      throw new NotFoundException(sprintf("Post id %d is not found", $id));
    }
    return $post;
  }
}
