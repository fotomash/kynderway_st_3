# Background Check Data Flow

The `KYCController` exposes an endpoint `/api/kyc/background-check` that accepts a
user's SSN and consent flag. The SSN is validated, encrypted and stored on the
`User` model. When the `KYCService` initiates a background check the encrypted
value is passed to `CheckrService` which decrypts the SSN before submitting it
to Checkr.
