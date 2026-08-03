<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClaimCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class, 'category_id');
    }
}