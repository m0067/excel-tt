<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Jobs\ParseExcel;
use App\Services\Domain\RowDomainService;
use App\Validations\RowsValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RowController extends Controller
{
    public function index(RowDomainService $rowDomainService): JsonResponse
    {
        return response()->json($rowDomainService->allGroupByDate());
    }

    public function store(Request $request): JsonResponse
    {
        $excel = $request->file('excel');

        if ($excel->isValid()) {
            Excel::import(new RowsValidation(), $excel);
            $path = $excel->store('excel');
            ParseExcel::dispatch($path);
        }

        return response()->json();
    }
}
