<?php

namespace App\Provider;

use App\EventListener\ContentLengthListener;
use App\EventListener\InternalErrorListener;
use Amar\Framework\Dbal\Event\PostPersist;
use Amar\Framework\EventDispatcher\EventDispatcher;
use Amar\Framework\Http\Event\ResponseEvent;
use Amar\Framework\ServiceProvider\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
  private array $listen = [
    ResponseEvent::class => [
      InternalErrorListener::class,
      ContentLengthListener::class
    ],
    PostPersist::class => []
  ];

  public function __construct(private EventDispatcher $eventDispatcher) {}

  public function register(): void
  {
    // loop over each event in the listen array
    foreach ($this->listen as $eventName => $listeners) {
      // loop over each listener
      foreach (array_unique($listeners) as $listener) {
        // call eventDispatcher->addListener
        $this->eventDispatcher->addListener($eventName, new $listener());
      }
    }
  }
}
