<?php

declare(strict_types=1);

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RowTest extends TestCase
{
    public function test_upload_excel(): void
    {
        $file = Storage::disk('local')->get('_input/test.xlsx');
        $uFile = UploadedFile::fake()->createWithContent('excel.xlsx', $file);
        $response = $this->post('api/v1/rows', ['excel' => $uFile]);
        $response->assertStatus(200);
    }

    /**
     * @depends test_upload_excel
     */
    public function test_show_rows(): void
    {
        $response = $this->get('api/v1/rows');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    '*' => [
                        'id',
                        'name',
                        'date',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }
}
