# API Testing Guide

## Setup
Make sure your server is running:
```bash
php artisan serve
```

Base URL: `http://localhost:8000`

## API Endpoints

### 1. Get Recommended People
Returns a paginated list of people excluding those already liked/disliked by this device.

**Endpoint:** `GET /api/people/recommended`

**Headers:**
- `X-Device-ID: your-unique-device-id` (optional, defaults to "default")

**Query Parameters:**
- `page` (optional): Page number for pagination

**Example:**
```bash
curl -H "X-Device-ID: device-123" \
  "http://localhost:8000/api/people/recommended?page=1"
```

**Response:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "age": 28,
      "pictures": [
        "https://via.placeholder.com/640x480.png/001155?text=people+Faker+labore",
        "https://via.placeholder.com/640x480.png/009911?text=people+Faker+et"
      ],
      "location": "New York",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "per_page": 10,
  "total": 100
}
```

### 2. Like a Person
Records a like for a specific person from a device.

**Endpoint:** `POST /api/people/{person_id}/like`

**Headers:**
- `X-Device-ID: your-unique-device-id` (optional)

**Example:**
```bash
curl -X POST \
  -H "X-Device-ID: device-123" \
  "http://localhost:8000/api/people/1/like"
```

**Response:**
```json
{
  "message": "Person liked successfully",
  "like": {
    "person_id": 1,
    "liker_device_id": "device-123",
    "updated_at": "2024-01-01T12:00:00.000000Z",
    "created_at": "2024-01-01T12:00:00.000000Z",
    "id": 1
  }
}
```

### 3. Dislike a Person
Records a dislike for a specific person from a device.

**Endpoint:** `POST /api/people/{person_id}/dislike`

**Headers:**
- `X-Device-ID: your-unique-device-id` (optional)

**Example:**
```bash
curl -X POST \
  -H "X-Device-ID: device-123" \
  "http://localhost:8000/api/people/2/dislike"
```

**Response:**
```json
{
  "message": "Person disliked successfully",
  "dislike": {
    "person_id": 2,
    "disliker_device_id": "device-123",
    "updated_at": "2024-01-01T12:00:00.000000Z",
    "created_at": "2024-01-01T12:00:00.000000Z",
    "id": 1
  }
}
```

### 4. Get Liked People
Returns a paginated list of people that have been liked by this device.

**Endpoint:** `GET /api/people/liked`

**Headers:**
- `X-Device-ID: your-unique-device-id` (optional)

**Query Parameters:**
- `page` (optional): Page number for pagination

**Example:**
```bash
curl -H "X-Device-ID: device-123" \
  "http://localhost:8000/api/people/liked?page=1"
```

**Response:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "age": 28,
      "pictures": [...],
      "location": "New York",
      "likes": [
        {
          "id": 1,
          "person_id": 1,
          "liker_device_id": "device-123",
          "created_at": "2024-01-01T12:00:00.000000Z"
        }
      ]
    }
  ],
  "per_page": 10,
  "total": 5
}
```

## Testing Flow

1. Get recommended people
2. Like person with ID 1
3. Dislike person with ID 2
4. Get recommended people again (IDs 1 and 2 should not appear)
5. Get liked people (should include person ID 1)

## Testing Email Notification

Manually trigger the cron job:
```bash
php artisan likes:check-threshold
```

To test with 50+ likes, you can create them programmatically:
```bash
php artisan tinker
```

Then in the tinker console:
```php
$person = App\Models\Person::first();
for ($i = 0; $i < 51; $i++) {
    App\Models\Like::create([
        'person_id' => $person->id,
        'liker_device_id' => 'test-device-' . $i
    ]);
}
exit
```

Run the command again:
```bash
php artisan likes:check-threshold
```

Check email at: https://www.mailinator.com/v4/public/inboxes.jsp?to=admin

## Swagger Documentation

Access interactive API documentation:
```
http://localhost:8000/api/documentation
```
