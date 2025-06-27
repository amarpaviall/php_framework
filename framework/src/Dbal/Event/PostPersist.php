<?php

namespace Amar\Framework\Dbal\Event;

use Amar\Framework\Dbal\Entity;
use Amar\Framework\EventDispatcher\Event;

class PostPersist extends Event
{
  public function __construct(private Entity $subject) {}
}
