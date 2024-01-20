<?php

declare(strict_types = 1);

namespace App\Services;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    const KEY_PREFIX_ROWS = 'rows';

    private Repository $clientSimple;

    public function __construct()
    {
        $this->clientSimple = Cache::store('redis');
    }

    public function client(): Repository
    {
        return $this->clientSimple;
    }

    public function makeKey(string $key, string $prefix): string
    {
        return 'cache_' . $prefix . sha1($key);
    }
}
