<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'emergency_contact'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime'];

    public function tenant() { return $this->hasOne(Tenant::class); }
    public function isAdmin() { return $this->role === 'admin'; }
    public function isTenant() { return $this->role === 'tenant'; }
}