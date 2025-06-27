<?php

namespace App\Repository;

use Amar\Framework\Dbal\DataMapper;
use App\Entity\Post;

class PostMapper
{
  public function __construct(
    private DataMapper $dataMapper
  ) {}

  public function save(Post $post): void
  {

    $stml = $this->dataMapper->getConnection()->prepare("
    INSERT INTO posts (title, body, created_at) 
    VALUES (:title, :body, :created_at)");

    $stml->bindValue(':title', $post->getTitle());
    $stml->bindValue(':body', $post->getBody());
    $stml->bindValue(':created_at', $post->getCreatedAt()->format("Y-m-d h:i:s"));

    $stml->executeStatement();

    $id = $this->dataMapper->save($post);
    //dd($id);

    $post->setId($id);
  }
}
