<?php

namespace Amar\Framework\Console\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Throwable;

class MigrateDatabase implements CommandInterface
{
  public string $name = "database:migrations:migrate";

  public function __construct(
    private Connection $connection,
    private string $migrationPath
  ) {}
  public function execute(array $params = []): int
  {
    try {
      // Create a migrations table SQL if table not already in existence
      $this->createMigrationsTable();

      $this->connection->beginTransaction();
      // Get $appliedMigrations which are already in the database.migrations table

      $appliedMigrations = $this->getAppliedMigrations();

      //dd($appliedMigrations);

      // Get the $migrationFiles from the migrations folder
      $migrationFiles = $this->getMigrationFile();
      // Get the migrations to apply. i.e. they are in $migrationFiles but not in $appliedMigrations

      $migrationsToApply = array_diff($migrationFiles, $appliedMigrations);
      //dd($migrationsToApply);
      // Create SQL for any migrations which have not been run ..i.e. which are not in the database
      $schema = new Schema();

      foreach ($migrationsToApply as $migration) {

        // require the object
        $migrationObject = require $this->migrationPath . '/' . $migration;

        // call up method
        $migrationObject->up($schema);
        // Add migration to database
        $this->insertMigration($migration);
      }

      // Execute the SQL query
      $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

      foreach ($sqlArray as $sql) {
        $this->connection->executeQuery($sql);
      }
      $this->connection->commit();

      return 0;
    } catch (Throwable $throwable) {
      $this->connection->rollBack();
      throw $throwable;
    }
  }

  private function insertMigration(string $migration): void
  {
    $sql = "INSERT INTO migrations(migration) values (?)";
    $stml = $this->connection->prepare($sql);
    $stml->bindValue(1, $migration);
    $stml->executeStatement();
  }
  private function getMigrationFile(): array
  {
    $migrationFiles = scandir($this->migrationPath);
    // $getPath = array_slice($migrationFiles, 2);
    // return $getPath;
    //dd($getPath);

    $filteredFiles = array_filter($migrationFiles, function ($file) {
      return !in_array($file, ['.', '..']);
    });

    return $filteredFiles;
  }
  private function getAppliedMigrations(): array
  {
    $sql = "SELECT migration FROM migrations";

    $appliedMigrations = $this->connection->executeQuery($sql)->fetchFirstColumn();

    return $appliedMigrations;
  }


  private function createMigrationsTable(): void
  {
    $schemaManger = $this->connection->createSchemaManager();
    if (!$schemaManger->tablesExist(['migrations'])) {
      $schema = new Schema();
      $table = $schema->createTable('migrations');
      $table->addColumn('id', Types::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
      $table->addColumn('migration', Types::STRING);
      $table->addColumn('created_at', Types::DATETIME_IMMUTABLE, ['default' => 'CURRENT_TIMESTAMP']);
      $table->setPrimaryKey(['id']);

      $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());

      $this->connection->executeQuery($sqlArray[0]);

      echo 'migrations table created' . PHP_EOL;
    }
  }
}
