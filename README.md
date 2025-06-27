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
- **SOLID Principles:** Designed with maintainability and extensibility in mind.

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

## License

MIT

---
