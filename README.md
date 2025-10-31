# PHP Mail Project

A clean and well-structured PHP project demonstrating email functionality using PHPMailer, environment variables, and proper project organization.

## Features

- **Contact Form**: Fully functional contact form with validation
- **Email System**: Send emails using PHPMailer with Gmail SMTP
- **Auto-Responder**: Automatic confirmation emails to form submitters
- **Environment Configuration**: Secure configuration using .env files
- **Clean Architecture**: Separation of public and internal files
- **Composer Integration**: Dependency management and autoloading

## Project Structure

```
project/
├── public/           # Publicly accessible files
│   ├── index.php     # Application entry point
│   ├── kontakt.php   # Contact form
│   ├── assets/       # Static assets (CSS, JS, images)
│   │   └── css/      # CSS stylesheets
├── src/              # Application source code
│   ├── Config/       # Configuration classes
│   └── Mail/         # Mail service classes
├── vendor/           # Composer dependencies
├── .env              # Environment variables (not in repository)
├── .env.example      # Example environment variables
├── .htaccess         # URL routing configuration
└── composer.json     # Composer configuration
```

## Requirements

- PHP 7.4 or higher
- Composer
- Web server with mod_rewrite enabled (Apache recommended)
- SMTP access (Gmail account configured)

## Installation

1. Clone the repository
2. Run `composer install` to install dependencies
3. Copy `.env.example` to `.env` and configure your environment variables
4. Make sure your web server is configured to allow .htaccess files
5. Access the application through your web server

## Environment Configuration

The application uses environment variables for configuration. Create a `.env` file with the following structure:

```
# SMTP Configuration for Gmail
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your.email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your.email@gmail.com
MAIL_FROM_NAME="PHP Mail Project"

# Application settings
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost/your-project-path

# Test mail settings
TEST_MAIL_RECIPIENT=recipient@example.com
```

## Usage

1. Navigate to the contact form page
2. Fill out the form with your name, email, subject, and message
3. Submit the form
4. The system will send an email to the configured recipient and a confirmation email to the submitter

## License

This project is open-source and available under the MIT License.

## Acknowledgements

- [PHPMailer](https://github.com/PHPMailer/PHPMailer) for email functionality
- [phpdotenv](https://github.com/vlucas/phpdotenv) for environment variable management