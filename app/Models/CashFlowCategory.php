<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashFlowCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'cash_flow_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function cashFlows(): HasMany
    {
        return $this->hasMany(CashFlow::class, 'flowcategory_id');
    }
}