<?php

namespace Amar\Framework\Authentication;

interface AuthRepositoryInterface
{
  public function findByUsername(string $username): ?AuthUserInterface;
}
