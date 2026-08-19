<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Depreciation extends Model
{
    protected $fillable = [
        'asset_id',
        'period',
        'year',
        'month',
        'expense_amount',
        'accumulated_after',
        'book_value_after',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'expense_amount' => 'decimal:2',
            'accumulated_after' => 'decimal:2',
            'book_value_after' => 'decimal:2',
        ];
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function journals(): MorphMany
    {
        return $this->morphMany(Journal::class, 'journalable');
    }
}
