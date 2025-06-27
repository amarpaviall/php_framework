# php-framework

A lightweight, modular PHP web framework for rapid application development and learning modern PHP practices.

## Features

Features

- **Custom HTTP Kernel & Routing:** Flexible request handling and route management.
- **Middleware Support:** Easily add features like CSRF protection and authentication.
- **Event Dispatcher & Listeners:** Decoupled event-driven architecture.
- **MVC Structure:** Clean separation of concerns for controllers, models, and views.
- **Twig Templating:** Use `base.html.twig` for consistent, extendable layouts.
- **Bootstrap 5 Integration:** Responsive and modern UI out of the box.
- **Session Management:** Secure user sessions and flash messaging.
- **CSRF Protection:** Secure forms with built-in CSRF middleware.
- **Doctrine DBAL Integration:** Powerful and flexible database access.
- **SOLID Principles:** Adherence to SOLID principles.

## Getting Started

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/php-framework-pro.git
   cd php-framework-pro
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Set up environment:**
   - Copy `.env.example` to `.env` and adjust settings as needed.

4. **Run the built-in PHP server:**
   ```bash
   php -S localhost:8000 -t public/index.php
   ```

5. **Access the app:**
   - Open [http://localhost:8000](http://localhost:8000) in your browser.

## Folder Structure

- `public/` — Entry point for web requests
- `src/` — Application code (controllers, models, listeners, etc.)
- `framework/` — Core framework code
- `config/` — Configuration files
- `templates/` — Twig templates

## Security

- CSRF protection via middleware
- Session-based authentication

## SOLID Principle

The project shows several signs of following the SOLID principles, but let’s review each one based on files and structure:

**1. Single Responsibility Principle (SRP)**

UserRepository only handles user data access.
ContentLengthListener only sets the Content-Length header.
Middleware like VerifyCsrfToken only checks CSRF tokens.
Result: Your classes generally have one responsibility.

**2. Open/Closed Principle (OCP)**
Event listeners and middleware can be extended or replaced without modifying core logic.
Dependency injection (via the container) allows you to swap implementations.
Result: Your code is open for extension, closed for modification.

**3. Liskov Substitution Principle (LSP)**
Interfaces like AuthRepositoryInterface and MiddlewareInterface are used, so implementations can be swapped without breaking code.
Result: Subtypes can replace base types.

**4. Interface Segregation Principle (ISP)**
Interfaces are focused (AuthRepositoryInterface, MiddlewareInterface), not forcing classes to implement unused methods.
Result: No evidence of "fat" interfaces.

**5. Dependency Inversion Principle (DIP)**
Services and dependencies are injected via the container, not hard-coded.
High-level modules depend on abstractions (interfaces), not concrete classes.
Result: Your architecture supports DIP.

Use of interfaces, dependency injection, focused classes, and extensible architecture all reflect SOLID design.

---
