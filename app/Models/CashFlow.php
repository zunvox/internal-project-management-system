<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'logged_by',
        'flowcategory_id',
        'transaction_code',
        'type',
        'subject',
        'transaction_date',
        'amount',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function loggedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'logged_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CashFlowCategory::class, 'flowcategory_id');
    }
}