<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\DBAL\Connection;

class UserMapper
{
  public function __construct(
    private Connection $connection
  ) {}

  public function save(User $user): void
  {

    $stml = $this->connection->prepare("
    INSERT INTO users (username, password, created_at) 
    VALUES (:username, :password, :created_at)");

    $stml->bindValue(':username', $user->getUsername());
    $stml->bindValue(':password', $user->getPassword());
    $stml->bindValue(':created_at', $user->getCreatedAt()->format("Y-m-d h:i:s"));

    $stml->executeStatement();

    $id = $this->connection->lastInsertId();

    $user->setId($id);
  }
}
