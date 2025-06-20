<?php

namespace Amar\Framework\Console\Command;

interface CommandInterface
{
  public function execute(array $params = []): int; //e.g command --up=1
}
