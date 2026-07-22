<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'name',
        'email',
        'phone',
        'address',
        'joined_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'joined_date' => 'date',
        ];
    }
}
