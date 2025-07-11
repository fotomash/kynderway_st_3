<?php

return [
    'enabled' => env('2FA_ENABLED', true),
    'lifetime' => env('2FA_LIFETIME', 0),
    'keep_alive' => true,
    'auth' => 'auth',
    'error_messages' => [
        'wrong_otp' => "The 'One Time Password' typed was wrong.",
        'cannot_be_empty' => 'One Time Password cannot be empty.',
        'unknown' => 'An unknown error has occurred. Please try again.',
    ],
];
