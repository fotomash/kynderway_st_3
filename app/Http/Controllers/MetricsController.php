<?php

namespace App\Http\Controllers;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

class MetricsController extends Controller
{
    private CollectorRegistry $registry;

    public function __construct(CollectorRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function __invoke()
    {
        $renderer = new RenderTextFormat();
        $metrics = $this->registry->getMetricFamilySamples();
        $result = $renderer->render($metrics);

        return response($result, 200)->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
