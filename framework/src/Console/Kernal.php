<?php

namespace Amar\Framework\Console;

use Amar\Framework\Console\Command\CommandInterface;
use DirectoryIterator;
use Psr\Container\ContainerInterface;
use ReflectionClass;

final class Kernal
{
  public function __construct(private ContainerInterface $container) {}
  public function handle(): int
  {
    //dd("got here");

    // Register commands with the container
    $this->registerCommands();
    // Run the console application, returning a status code

    // return the status code
    return 0;
  }

  private function registerCommands(): void
  {
    // === Register All Built In Commands ===
    // Get all files in the Commands dir
    $commandFiles = new DirectoryIterator(__DIR__ . '/Command');
    //dd($commandFiles);

    $namespace = $this->container->get('base-commands-namespace');
    //dd($namespace);
    //loop over all the files
    foreach ($commandFiles as $commandFile) {
      if (!$commandFile->isFile()) {
        continue;
      }
      // Get the Command class name..using psr4 this will be same as filename
      $command = $namespace . pathinfo($commandFile, PATHINFO_FILENAME);

      //dd($command);

      if (is_subclass_of($command, CommandInterface::class)) {

        // Add to the container, using the name as the ID e.g. $container->add('database:migrations:migrate', MigrateDatabase::class)
        $commandName = (new ReflectionClass($command))
          ->getProperty('name')->getDefaultValue();

        //dd($commandName);
        $this->container->add($commandName, $command);
      }
    }

    dd($this->container);
  }
}
