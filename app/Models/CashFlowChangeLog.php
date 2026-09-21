<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashFlowChangeLog extends Model
{
    protected $fillable = [
        'cash_flow_id',
        'changed_by',
        'action',
        'description',
        'snapshot',
    ];

    public function cashFlow()
    {
        return $this->belongsTo(
            CashFlow::class,
            'cash_flow_id'
        );
    }

    public function changedBy()
    {
        return $this->belongsTo(
            User::class,
            'changed_by'
        );
    }

    protected $casts = [
        'snapshot' => 'array',
    ];
}