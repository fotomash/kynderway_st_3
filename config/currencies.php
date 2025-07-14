<?php

return [
    'supported' => ['USD', 'EUR', 'GBP', 'AUD', 'CAD'],
    'default' => 'USD',
    'rates_api' => env('CURRENCY_RATES_API_KEY'),
];
