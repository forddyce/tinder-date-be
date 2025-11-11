# Quick Start Guide

## Aiven MySQL Setup (5 minutes)

1. Go to https://console.aiven.io and sign up (free)
2. Click "Create service"
3. Select "MySQL"
4. Choose the **free tier** (Hobbyist plan)
5. Select region closest to you
6. Click "Create service"
7. Wait 2-3 minutes for service to start
8. Click on your service and go to "Overview" tab
9. Copy the connection details

## Backend Setup

```bash
cd be

composer install

cp .env.example .env
```

Edit `.env` and paste your Aiven credentials:
```
DB_HOST=your-project-name.aivencloud.com
DB_PORT=12345
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=<your-password-from-aiven>
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=false
```

Then run:
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan l5-swagger:generate
php artisan serve
```

Visit: http://localhost:8000/api/documentation

## Test the API

Get recommended people:
```bash
curl -H "X-Device-ID: test-device-1" http://localhost:8000/api/people/recommended
```

Like a person (replace {id} with actual person ID from previous response):
```bash
curl -X POST -H "X-Device-ID: test-device-1" http://localhost:8000/api/people/{id}/like
```

## Run Cron Job Manually

```bash
php artisan likes:check-threshold
```

Check emails at: https://www.mailinator.com/v4/public/inboxes.jsp?to=admin
