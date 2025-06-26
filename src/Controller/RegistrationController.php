<?php

namespace App\Controller;

use Amar\Framework\Controller\AbstractController;
use Amar\Framework\Http\RedirectResponse;
use Amar\Framework\Http\Response;
use App\Form\User\RegistrationForm;
use App\Repository\UserMapper;

class RegistrationController extends AbstractController
{

  public function __construct(
    private UserMapper $userMapper,
  ) {}

  public function index()
  {
    return $this->render('register.html.twig');
  }
  public function register(): Response
  {
    //dd($this->request);

    // $username = $this->request->postParams['username'];
    // $password = $this->request->postParams['password'];

    // $user = User::create($username, $password);
    //dd($user);
    //-------------------------------------------//

    // Create a form model which will:
    // - validate fields
    // - map the fields to User object properties
    // - ultimately save the new User to the DB
    $form = new RegistrationForm($this->userMapper);
    $form->setFields(
      $this->request->input('username'),
      $this->request->input('password')
    );

    // Validate
    // If validation errors,
    if ($form->hasValidationErrors()) {
      // add to session, redirect to form
      foreach ($form->getValidationErrors() as $error) {
        $this->request->getSession()->setFlash('error', $error);
      }
      return new RedirectResponse('/register');
    }

    // register the user by calling $form->save()
    $user = $form->save();

    // Add a session success message
    $this->request->getSession()->setFlash(
      'success',
      sprintf('User %s created', $user->getUsername())
    );
    // Log the user in

    // Redirect to somewhere useful
    return new RedirectResponse('/');
  }
}
