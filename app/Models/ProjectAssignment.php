<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Pivot;

class ProjectAssignment extends Pivot
{
    protected $table = 'project_assignments';

    public $incrementing = false;
    
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'project_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
