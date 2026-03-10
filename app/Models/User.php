<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Admin / Staff
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class); // One user can have many audit logs
    }

    // JWT Methods
    public function getJWTIdentifier()
    {        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
