<?php

return [
    'namespace' => 'kynderway',
    'metrics' => [
        'app_requests_total' => [
            'type' => 'counter',
            'description' => 'Total number of requests',
            'labels' => ['method', 'endpoint', 'status'],
        ],
        'app_response_time_seconds' => [
            'type' => 'histogram',
            'description' => 'Response time in seconds',
            'labels' => ['method', 'endpoint'],
            'buckets' => [0.1, 0.25, 0.5, 1.0, 2.5, 5.0, 10.0],
        ],
        'app_memory_usage_bytes' => [
            'type' => 'gauge',
            'description' => 'Memory usage in bytes',
        ],
    ],
];
