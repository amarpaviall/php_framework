<?php

namespace Amar\Framework\Authentication;

use Amar\Framework\Session\SessionInterface;

class SessionAuthentication implements SessionAuthInterface
{
  private AuthUserInterface $user;
  public const AUTH_KEY = 'auth_id';

  public function __construct(
    private AuthRepositoryInterface $authRepository,
    private SessionInterface $session
  ) {}
  public function authenticate(string $username, string $password): bool
  { // query db for user using username
    $user = $this->authRepository->findByUsername($username);

    if (!$user) {
      return false;
    }

    // Does the hashed user pw match the hash of the attempted password
    if (!password_verify($password, $user->getPassword())) {

      return false;
    }

    $this->login($user);

    return true;
  }

  public function login(AuthUserInterface $user)
  {
    // Start a session
    $this->session->start();

    // Log the user in
    $this->session->set(self::AUTH_KEY, $user->getAuthId());

    // Set the user
    $this->user = $user;
  }

  public function logout()
  {
    $this->session->remove(self::AUTH_KEY);
  }

  public function getUser(): AuthUserInterface
  {
    return $this->user;
  }
}
