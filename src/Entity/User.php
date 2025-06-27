<?php

namespace App\Entity;

use Amar\Framework\Authentication\AuthUserInterface;
use Amar\Framework\Dbal\Entity;
use DateTimeImmutable;

class User extends Entity implements AuthUserInterface
{

  public function __construct(
    private ?int $id,
    private string $username,
    private string $password,
    private DateTimeImmutable $createdAt
  ) {}

  public static function create(string $username, string $password): self
  {
    return new self(
      null,
      $username,
      password_hash($password, PASSWORD_DEFAULT),
      new DateTimeImmutable
    );
  }


  public function setId(?int $id): void
  {
    $this->id = $id;
  }
  public function getAuthId(): int
  {
    return $this->id;
  }
  public function getUsername(): string
  {
    return $this->username;
  }


  public function getPassword(): string
  {
    return $this->password;
  }

  public function getCreatedAt(): \DateTimeImmutable
  {
    return $this->createdAt;
  }
}
