# Dating App Backend

Laravel-based backend for a Tinder-like dating application with PlanetScale MySQL database.

## Features

- Recommended people list with pagination
- Like/Dislike functionality
- Liked people list
- Email notifications when a person gets 50+ likes
- Swagger API documentation
- PlanetScale MySQL integration

## Requirements

- PHP 8.1 or higher
- Composer
- Aiven (free tier)

## Setup Instructions

### 1. Install Dependencies

```bash
cd be
composer install
```

### 2. Configure Environment

```bash
cp .env.example .env
```

Edit `.env` file and update these values:

```env
DB_HOST=your-project-name.aivencloud.com
DB_PORT=12345
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=your_aiven_password
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=false

ADMIN_EMAIL=admin@mailinator.com
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Seed Database

```bash
php artisan db:seed
```

### 6. Generate Swagger Documentation

```bash
php artisan l5-swagger:generate
```

### 7. Start Development Server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## Aiven MySQL Setup

1. Create a free account at [console.aiven.io](https://console.aiven.io)
2. Create a new MySQL service (select the free tier)
3. Wait for the service to start (takes 2-3 minutes)
4. Get connection details from the "Overview" tab
5. Update your `.env` file with the credentials

Note: Aiven provides SSL certificates. You can download them or use the system CA bundle.

## API Endpoints

### Get Recommended People
```
GET /api/people/recommended?page=1
Header: X-Device-ID: your-device-id
```

### Like a Person
```
POST /api/people/{id}/like
Header: X-Device-ID: your-device-id
```

### Dislike a Person
```
POST /api/people/{id}/dislike
Header: X-Device-ID: your-device-id
```

### Get Liked People
```
GET /api/people/liked?page=1
Header: X-Device-ID: your-device-id
```

## Swagger Documentation

Access the Swagger UI at:
```
http://localhost:8000/api/documentation
```

## Scheduled Tasks

Run the likes threshold checker:
```bash
php artisan likes:check-threshold
```

For production, add to cron:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Vercel Deployment

### Deploy API

1. Install Vercel CLI:
```bash
npm i -g vercel
```

2. Deploy:
```bash
vercel
```

### Deploy Swagger

The Swagger documentation will be available at `/api/documentation` once deployed.

## Database Schema

### people
- id
- name
- age
- pictures (JSON array)
- location
- timestamps

### likes
- id
- person_id
- liker_device_id
- timestamps

### dislikes
- id
- person_id
- disliker_device_id
- timestamps

### email_notifications
- id
- person_id
- like_count
- sent_at
- timestamps

## Testing with Mailinator

Emails are sent to `admin@mailinator.com` by default. Check them at:
```
https://www.mailinator.com/v4/public/inboxes.jsp?to=admin
```
