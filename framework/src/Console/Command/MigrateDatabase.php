<?php

namespace Amar\Framework\Console\Command;

class MigrateDatabase implements CommandInterface
{
  public string $name = "database:migrations:migrate";
  public function execute(array $params = []): int
  {
    echo "Executing MigrateDatabase Commad" . PHP_EOL;
    return 0;
  }
}
