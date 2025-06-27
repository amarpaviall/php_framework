# php-framework-pro

A lightweight, modular PHP web framework for rapid application development and learning modern PHP practices.

## Features

- Custom HTTP kernel and routing system
- Middleware support (including CSRF protection)
- Event dispatcher and listeners
- MVC architecture
- Doctrine DBAL integration for database access
- Session management
- Simple authentication system

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
