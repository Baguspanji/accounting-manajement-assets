<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Financing extends Model
{
    protected $fillable = [
        'code',
        'member_id',
        'contract_id',
        'amount',
        'margin',
        'tenor',
        'transaction_date',
        'remaining',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }
}
