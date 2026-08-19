<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_number',
        'name',
        'category_id',
        'serial_number',
        'location',
        'responsible_person',
        'supplier',
        'acquisition_date',
        'acquisition_cost',
        'residual_value',
        'useful_life',
        'depreciation_method_id',
        'production_capacity',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'acquisition_date' => 'date',
            'acquisition_cost' => 'decimal:2',
            'residual_value' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

    public function depreciationMethod(): BelongsTo
    {
        return $this->belongsTo(DepreciationMethod::class);
    }

    public function depreciations(): HasMany
    {
        return $this->hasMany(Depreciation::class);
    }

    public function disposals(): HasMany
    {
        return $this->hasMany(AssetDisposal::class);
    }

    public function journals(): MorphMany
    {
        return $this->morphMany(Journal::class, 'journalable');
    }

    public function isDepreciable(): bool
    {
        return strtolower($this->category?->name ?? '') !== 'tanah';
    }

    public function depreciableAmount(): float
    {
        return (float) $this->acquisition_cost - (float) $this->residual_value;
    }

    public function annualDepreciation(): float
    {
        if (! $this->isDepreciable() || $this->useful_life <= 0) {
            return 0;
        }

        return $this->depreciableAmount() / $this->useful_life;
    }
}
