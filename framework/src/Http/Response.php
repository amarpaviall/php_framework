<?php

declare(strict_types=1);

namespace Amar\Framework\Http;

class Response
{
  const HTTP_INTERNAL_SERVER_ERROR = 500;
  const HTTP_FORBIDDEN = 403;
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
    // start output buffering
    ob_start();

    // send headers
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
    }

    // This will actually add the content to the buffer
    echo $this->content;

    // Flush the buffer, sending the content to the client
    ob_end_flush();
  }

  public function setContent(string $content): void
  {
    $this->content = $content;
  }

  public function statuscode(): int
  {
    return $this->statuscode;
  }

  public function setStatus(int $statuscode): void
  {
    $this->statuscode = $statuscode;
  }
  public function getHeader(string $header): mixed
  {
    return $this->headers[$header];
  }
  public function getHeaders(): array
  {
    return $this->headers;
  }

  public function setHeader($key, $value): void
  {
    $this->headers[$key] = $value;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }
}
