<?php

declare(strict_types=1);

namespace App\Imports;

use App\Models\Row as RowModel;
use App\Services\CacheService;
use App\Validations\RowsValidation;
use Maatwebsite\Excel\Concerns\ToModel;

class RowsImport implements ToModel
{
    public function __construct(private CacheService $cacheService, private string $key)
    {
    }

    public function model(array $row): RowModel|null
    {
        $this->cacheService->client()->increment($this->key);
        if (RowsValidation::skip($row)) {
            return null;
        }

        $date = RowsValidation::getDate($row[2]);

        return new RowModel([
            'name' => $row[1],
            'date' => $date,
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
