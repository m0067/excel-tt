<?php

declare(strict_types=1);

namespace App\Validations;

use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RowsValidation implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $item = $row->toArray();

            if (self::skip($item)) {
                continue;
            }

            $item[2] = self::getDate($item[2]);
            Validator::make($item, [
                '0' => 'required',
                '1' => 'string',
                '2' => 'date',
            ])->validate();
        }
    }

    public static function skip(array $row): bool
    {
        if ($row[2] === 'date' || is_null($row[2])) {
            return true;
        }

        return false;
    }

    public static function getDate(mixed $date): DateTime
    {
        $timestamp = strtotime((string)$date);

        if ($timestamp !== false) {
            return new DateTime($date);
        }

        return Date::excelToDateTimeObject($date);
    }
}
