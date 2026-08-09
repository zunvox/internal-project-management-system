<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'role',
        'status',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createdProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function assignedProjects(): BelongsToMany
    {
        return $this->belongsToMany
        (
        Project::class,
        'project_user',
        'user_id',
        'project_id'
        );
    }
        public function invoices(): HasMany
        {
            return $this->hasMany(Invoice::class, 'user_id');
        }

        public function claims(): HasMany
        {
            return $this->hasMany(Claim::class, 'user_id');
        }

        public function reviewedInvoices(): HasMany
        {
            return $this->hasMany(Invoice::class, 'reviewed_by');
        }

        public function reviewedClaims(): HasMany
        {
            return $this->hasMany(Claim::class, 'reviewed_by');
        }

        public function reviewedPaymentVouchers(): HasMany
        {
            return $this->hasMany(PaymentVoucher::class, 'reviewed_by');
        }

        public function loggedCashFlows(): HasMany
        {
            return $this->hasMany(CashFlow::class, 'logged_by');
        }

        public function isAdmin(): bool
        {
            return $this->role === 'Admin';
        }

        public function isDeveloper(): bool
        {
            return $this->role === 'Developer';
        }

        public function isActive(): bool
        {
            return $this->status === 'Active';
        }

        public function isInactive(): bool
        {
            return $this->status === 'Inactive';
        }
}
