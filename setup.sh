#!/bin/bash

echo "======================================"
echo "Dating App Backend Setup"
echo "======================================"
echo ""

if ! command -v composer &> /dev/null; then
    echo "Error: Composer is not installed. Please install Composer first."
    exit 1
fi

if ! command -v php &> /dev/null; then
    echo "Error: PHP is not installed. Please install PHP 8.1 or higher first."
    exit 1
fi

echo "Installing dependencies..."
composer install

if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
    echo ".env file created. Please update database credentials."
else
    echo ".env file already exists."
fi

echo ""
echo "Generating application key..."
php artisan key:generate

echo ""
echo "======================================"
echo "Setup Complete!"
echo "======================================"
echo ""
echo "Next steps:"
echo "1. Update .env file with your Aiven credentials."
echo "2. Run: php artisan migrate"
echo "3. Run: php artisan db:seed"
echo "4. Run: php artisan l5-swagger:generate"
echo "5. Run: php artisan serve"
echo ""
echo "Then visit: http://localhost:8000/api/documentation"
