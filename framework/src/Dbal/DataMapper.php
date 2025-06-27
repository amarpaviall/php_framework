<?php

namespace Amar\Framework\Dbal;

use Amar\Framework\Dbal\Event\PostPersist;
use Amar\Framework\EventDispatcher\EventDispatcher;
use Doctrine\DBAL\Connection;

class DataMapper
{
  public function __construct(
    private Connection $connection,
    private EventDispatcher $eventDispatcher
  ) {}

  public function getConnection()
  {
    return $this->connection;
  }
  public function save(Entity $subject): int|string|null
  {
    $this->eventDispatcher->dispatch(new PostPersist($subject));

    return $this->connection->lastInsertId();
  }
}
