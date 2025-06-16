<?php declare(strict_types=1);

namespace Amar\Framework\Http;

class Response 
{
  public function __construct(private ?string $content = '',
  private int $statuscode = 200,
  private array $headers = []) 
  {
    // Must be set before sending content
    // So best to create on instantiation like here
    http_response_code($this->statuscode);
  }

  public function send() : void
  {
    echo $this->content;
  }
}
