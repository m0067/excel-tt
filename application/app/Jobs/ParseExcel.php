<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Imports\RowsImport;
use App\Services\CacheService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ParseExcel implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 1800 = 30 min
     */
    public int $timeout = 1800;

    public function __construct(private string $path)
    {
        $this->onQueue('parse_excel');
    }

    public function handle(CacheService $cacheService)
    {
        $key = $cacheService->makeKey($this->path, CacheService::KEY_PREFIX_ROWS);
        Excel::import(new RowsImport($cacheService, $key), $this->path);
    }

    public function uniqueId(): string
    {
        return $this->path;
    }
}
