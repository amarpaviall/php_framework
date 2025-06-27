<?php

namespace App\Repository;

use Amar\Framework\Dbal\DataMapper;
use App\Entity\User;

class UserMapper
{
  public function __construct(
    private DataMapper $dataMapper
  ) {}

  public function save(User $user): void
  {

    $stml = $this->dataMapper->getConnection()->prepare("
    INSERT INTO users (username, password, created_at) 
    VALUES (:username, :password, :created_at)");

    $stml->bindValue(':username', $user->getUsername());
    $stml->bindValue(':password', $user->getPassword());
    $stml->bindValue(':created_at', $user->getCreatedAt()->format("Y-m-d h:i:s"));

    $stml->executeStatement();

    $id = $this->dataMapper->save($user);

    $user->setId($id);
  }
}
