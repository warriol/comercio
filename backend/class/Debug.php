<?php

final class Debug
{
    private const LOG_FILE = __DIR__ . '/../../tmp.log';
    private const SENSITIVE_KEYS = [
        'password',
        'token',
        'authorization',
        'secret',
        'secretkey',
        'api_key',
        'apikey'
    ];

    public static function log(string $event, mixed $data = null): void
    {
        $entry = [
            'timestamp' => date('c'),
            'process' => 'php',
            'event' => $event
        ];

        if ($data !== null) {
            $entry['data'] = self::sanitize($data);
        }

        $line = json_encode(
            $entry,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
        );

        if ($line === false || file_put_contents(self::LOG_FILE, $line . PHP_EOL, FILE_APPEND | LOCK_EX) === false) {
            error_log('No se pudo escribir en ' . self::LOG_FILE);
        }
    }

    public static function info(string $event, mixed $data = null): void
    {
        self::log($event, $data);
    }

    public static function exception(string $event, \Throwable $exception): void
    {
        self::log($event, [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]);
    }

    private static function sanitize(mixed $value, ?string $key = null): mixed
    {
        if ($key !== null && in_array(strtolower($key), self::SENSITIVE_KEYS, true)) {
            return '[REDACTED]';
        }

        if (is_array($value)) {
            $sanitized = [];
            foreach ($value as $itemKey => $itemValue) {
                $sanitized[$itemKey] = self::sanitize($itemValue, (string) $itemKey);
            }
            return $sanitized;
        }

        if (is_object($value)) {
            return self::sanitize(get_object_vars($value), $key);
        }

        if (is_resource($value)) {
            return '[RESOURCE]';
        }

        return $value;
    }
}
