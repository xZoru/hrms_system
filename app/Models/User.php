<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ ALWAYS USE THE MAIN DATABASE
    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
        'allowed_companies',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'allowed_companies' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function getAccessibleCompanies()
    {
        if ($this->isSuperAdmin()) {
            return Company::all();
        }

        $companyIds = [];

        if ($this->company_id) {
            $companyIds[] = $this->company_id;
        }

        if ($this->allowed_companies) {
            $companyIds = array_merge($companyIds, $this->allowed_companies);
        }

        if (empty($companyIds)) {
            return collect([]);
        }

        return Company::whereIn('id', array_filter($companyIds))->get();
    }

    public function canAccessCompany($companyId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->company_id == $companyId) {
            return true;
        }

        if ($this->allowed_companies && in_array($companyId, $this->allowed_companies)) {
            return true;
        }

        return false;
    }
}