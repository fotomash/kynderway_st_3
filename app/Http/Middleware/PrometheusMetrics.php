<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Prometheus\CollectorRegistry;

class PrometheusMetrics
{
    private $registry;

    public function __construct(CollectorRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;

        $counter = $this->registry->getOrRegisterCounter(
            'kynderway',
            'app_requests_total',
            'Total requests',
            ['method', 'endpoint', 'status']
        );
        $counter->incBy(1, [
            $request->method(),
            $request->path(),
            $response->status()
        ]);

        $histogram = $this->registry->getOrRegisterHistogram(
            'kynderway',
            'app_response_time_seconds',
            'Response time',
            ['method', 'endpoint'],
            [0.1, 0.25, 0.5, 1.0, 2.5, 5.0, 10.0]
        );
        $histogram->observe($duration, [
            $request->method(),
            $request->path()
        ]);

        $gauge = $this->registry->getOrRegisterGauge(
            'kynderway',
            'app_memory_usage_bytes',
            'Memory usage in bytes'
        );
        $gauge->set(memory_get_usage(true));

        return $response;
    }
}
