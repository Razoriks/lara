<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 *
 * @property int $id
 * @property int $user_id
 * @property TransactionType $type
 * @property int $amount
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'type' => TransactionType::class,
        ];
    }
}
