<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use BroadcastsEvents, HasFactory;

    protected $fillable = ['name', 'date'];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function broadcastOn(string $event): array
    {
        return match ($event) {
            'creating' => ['model' => $this],
            default => [],
        };
    }
}
