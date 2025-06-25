<?php

declare(strict_types=1);

namespace Amar\Framework\Http;

class Response
{
  const HTTP_INTERNAL_SERVER_ERROR = 500;
  public function __construct(
    private ?string $content = '',
    private int $statuscode = 200,
    private array $headers = []
  ) {
    // Must be set before sending content
    // So best to create on instantiation like here
    http_response_code($this->statuscode);
  }

  public function send(): void
  {
    echo $this->content;
  }

  public function setContent(string $content): void
  {
    $this->content = $content;
  }

  public function statuscode(): int
  {
    return $this->statuscode;
  }

  public function getHeader(string $header): mixed
  {
    return $this->headers[$header];
  }
}
