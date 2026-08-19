<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Journal extends Model
{
    protected $fillable = [
        'reference',
        'transaction_date',
        'description',
        'journalable_type',
        'journalable_id',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
        ];
    }

    public function journalable(): MorphTo
    {
        return $this->morphTo();
    }

    public function relatedLabel(): ?string
    {
        $related = $this->journalable;

        if ($related instanceof Asset) {
            return 'Aset: '.$related->name;
        }

        if ($related instanceof Depreciation) {
            return 'Penyusutan: '.($related->asset?->name ?? '-');
        }

        if ($related instanceof AssetDisposal) {
            return 'Pelepasan: '.($related->asset?->name ?? '-');
        }

        return $related ? class_basename($related) : null;
    }

    public function details(): HasMany
    {
        return $this->hasMany(JournalDetail::class);
    }
}
