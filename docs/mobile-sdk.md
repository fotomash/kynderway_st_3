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
All other `/api/v1/mobile` routes require the same `Authorization` header.

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
Unauthenticated requests will receive a `401` response using this format.

## Bookings

### Create Booking
`POST /api/v1/mobile/bookings`

Headers:
```
Authorization: Bearer {token}
Content-Type: application/json
```

Body:
```json
{
    "parent_id": 1,
    "nanny_id": 2,
    "agency_id": 3,
    "start_time": "2024-07-01T10:00:00Z",
    "end_time": "2024-07-01T12:00:00Z",
    "hours": 2,
    "hourly_rate": 20
}
```

Response `201 Created`:
```json
{
    "id": 10,
    "parent_id": 1,
    "nanny_id": 2,
    "agency_id": 3,
    "start_time": "2024-07-01T10:00:00Z",
    "end_time": "2024-07-01T12:00:00Z",
    "hours": 2,
    "hourly_rate": "20.00",
    "status": "requested",
    "created_at": "2024-07-01T09:30:00Z",
    "updated_at": "2024-07-01T09:30:00Z"
}
```

### Complete Booking
`POST /api/v1/mobile/bookings/{id}/complete`

Headers:
```
Authorization: Bearer {token}
```

Response `200 OK`:
```json
{
    "id": 10,
    "status": "completed",
    "parent_id": 1,
    "nanny_id": 2,
    "agency_id": 3,
    "start_time": "2024-07-01T10:00:00Z",
    "end_time": "2024-07-01T12:00:00Z",
    "hours": 2,
    "hourly_rate": "20.00",
    "created_at": "2024-07-01T09:30:00Z",
    "updated_at": "2024-07-01T12:05:00Z"
}
```

### Escrow and Auto-Reject
- A payment intent is created and held in escrow when a booking is made. Funds are not released until the nanny completes the booking.
- Bookings that remain in the `requested` status are automatically rejected by a background job, notifying the parent.

