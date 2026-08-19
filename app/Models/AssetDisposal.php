<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AssetDisposal extends Model
{
    protected $fillable = [
        'asset_id',
        'disposal_date',
        'disposal_type',
        'sale_price',
        'accumulated_depreciation',
        'book_value',
        'gain_loss',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'disposal_date' => 'date',
            'sale_price' => 'decimal:2',
            'accumulated_depreciation' => 'decimal:2',
            'book_value' => 'decimal:2',
            'gain_loss' => 'decimal:2',
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
