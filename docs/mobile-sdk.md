# Kynderway Mobile API Documentation

## Base URL

All endpoints are available under the `/api/mobile/v1` prefix.

## Authentication

### Login

`POST /api/mobile/v1/login`

```
{
    "email": "user@example.com",
    "password": "password",
    "device_name": "iPhone 12"
}
```

Response:
```
{
    "token": "<access_token>",
    "user": { /* User object */ }
}
```

### Logout

`POST /api/mobile/v1/logout`

Headers:
```
Authorization: Bearer <token>
```

Response:
```
{
    "message": "Logged out successfully"
}
```

### Current User

`GET /api/mobile/v1/user`

Headers:
```
Authorization: Bearer <token>
```

Response is the authenticated user resource.

### Update Profile

`PUT /api/mobile/v1/user`

Headers:
```
Authorization: Bearer <token>
Content-Type: application/json
```

Body:
```
{
    "name": "New Name",
    "avatar": "<url>"
}
```

Response is the updated user resource.

## Home

### Home Screen

`GET /api/mobile/v1/home`

Headers:
```
Authorization: Bearer <token>
```

Response:
```
{
    "message": "Welcome to the mobile API",
    "user": { /* User object */ }
}
```

## Devices

### Register Device

`POST /api/mobile/v1/device/register`

Headers:
```
Authorization: Bearer <token>
Content-Type: application/json
```

Body:
```
{
    "token": "<push_token>"
}
```

Response:
```
{ "success": true }
```

Clients should call this endpoint whenever a new Firebase Cloud Messaging (FCM) token is issued. Sending the latest token ensures the server can deliver push notifications to the correct device.

### Unregister Device

`POST /api/mobile/v1/device/unregister`

Headers:
```
Authorization: Bearer <token>
Content-Type: application/json
```

Body:
```
{
    "token": "<push_token>"
}
```

Response:
```
{ "success": true }
```

## Nannies

### Nearby Search

`GET /api/mobile/v1/nannies/nearby?lat={lat}&lng={lng}&radius={km}`

Headers:
```
Authorization: Bearer <token>
```

Returns an array of provider profiles near the supplied coordinates.

## Bookings

### Active Bookings

`GET /api/mobile/v1/bookings/active`

Headers:
```
Authorization: Bearer <token>
```

Response is a list of current bookings with a status of `requested` or `accepted`.

### Create Booking

`POST /api/mobile/v1/bookings`

Headers:
```
Authorization: Bearer <token>
Content-Type: application/json
```

Body:
```
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
```
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

`POST /api/mobile/v1/bookings/{id}/complete`

Headers:
```
Authorization: Bearer <token>
```

Response `200 OK`:
```
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

### Error Handling

All API errors follow this format:
```
{
    "message": "Error message",
    "errors": {
        "field": ["Error detail"]
    }
}
```
Unauthenticated requests receive a `401` response using this format.

### Escrow and Auto-Reject
- A payment intent is created and held in escrow when a booking is made. Funds are not released until the nanny completes the booking.
- Bookings that remain in the `requested` status are automatically rejected by a background job, notifying the parent.

### Push Notifications
When a booking is confirmed a push notification is sent with this payload:
```json
{
    "type": "booking_confirmed",
    "booking_id": 42
}
```
Include `push` in your notification's `via()` method and implement `toPush()` to return the token, data and FCM notification instance.
