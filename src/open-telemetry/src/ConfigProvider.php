<?php

declare(strict_types=1);

namespace HyperfContrib\OpenTelemetry;

use OpenTelemetry\API\Instrumentation\CachedInstrumentation;

class ConfigProvider
{
    /**
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        defined('BASE_PATH') || define('BASE_PATH', '');

        return [
            'dependencies' => [
                Exporter\ExporterInterface::class => Exporter\OtlpExporter::class,
                CachedInstrumentation::class      => Factory\CachedInstrumentationFactory::class,
            ],
            'listeners' => [
                Listeners\DbQueryExecutedListener::class,
                Listeners\ClientRequestListener::class,
                Listeners\CommandListener::class,
                Listeners\CrontabListener::class,
            ],
            'publish' => [
                [
                    'id'          => 'config',
                    'description' => 'The config for OpenTelemetry.',
                    'source'      => __DIR__ . '/../publish/open-telemetry.php',
                    'destination' => BASE_PATH . '/config/autoload/open-telemetry.php',
                ],
            ],
        ];
    }
}
