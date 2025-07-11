<?php

namespace App\Http;

use App\Config\Config;

class Cors
{
    public static function setHeaders(Config $config): void
    {
        $frontendUrl = $config->get('FRONTEND_URL');
        header("Access-Control-Allow-Origin: $frontendUrl");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");
    }
}
