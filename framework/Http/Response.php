<?php declare(strict_types=1);

namespace Amar\Framework\Http;

class Response 
{
  public function __construct(private ?string $content = '',
  private int $statuscode = 200,
  private array $headers = []) 
  {}

  public function send() : void
  {
    echo $this->content;
  }
}
