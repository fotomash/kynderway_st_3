# Kynderway Mobile SDK Documentation

## Authentication

### Login
```http
POST /api/v1/mobile/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password",
    "device_name": "iPhone 12"
}
```

Using Authentication Token
```http
GET /api/v1/user
Authorization: Bearer {token}
```

### Error Handling

All API errors follow this format:
```json
{
    "message": "Error message",
    "errors": {
        "field": ["Error detail"]
    }
}
```
