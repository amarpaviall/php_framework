<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\DBAL\Connection;

class PostMapper
{
  public function __construct(
    private Connection $connection
  ) {}

  public function save(Post $post): void
  {

    $stml = $this->connection->prepare("
    INSERT INTO posts (title, body, created_at) 
    VALUES (:title, :body, :created_at)");

    $stml->bindValue(':title', $post->getTitle());
    $stml->bindValue(':body', $post->getBody());
    $stml->bindValue(':created_at', $post->getCreatedAt()->format("Y-m-d h:i:s"));

    $stml->executeStatement();

    $id = $this->connection->lastInsertId();

    $post->setId($id);
  }
}
