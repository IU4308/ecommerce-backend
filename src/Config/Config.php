<?php

namespace App\Config;

use Dotenv\Dotenv;

class Config
{
    public function __construct(string $baseDir)
    {
        $envPath = $baseDir . '/.env';

        if (file_exists($envPath)) {
            $dotenv = Dotenv::createImmutable($baseDir);
            $dotenv->load();
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}
