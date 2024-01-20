<?php

declare(strict_types = 1);

namespace App\Services\Domain;

use App\Models\Row;

class RowDomainService
{
    public function allGroupByDate(): array
    {
        $rows = Row::all();

        return $rows->groupBy('date')->toArray();
    }
}
