<?php // src/EventListener/ContentLengthListener.php

namespace App\EventListener;

use Amar\Framework\Http\Event\ResponseEvent;

class InternalErrorListener
{
  private const INTERNAL_ERROR_MIN_VALUE = 499;
  public function __invoke(ResponseEvent $event): void
  {
    $status = $event->getResponse()->statuscode();
    if ($status > self::INTERNAL_ERROR_MIN_VALUE) {
      $event->stopPropagation();
    }
  }
}
