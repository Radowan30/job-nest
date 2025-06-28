<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Allow name, email, password, role
    protected $fillable = ['name','email','password','role'];
    protected $hidden   = ['password','remember_token'];

    // Casts
    protected $casts = ['email_verified_at' => 'datetime'];

    // Role check helpers
    public function isApplicant() { return $this->role === 'applicant'; }
    public function isCompany()   { return $this->role === 'company'; }

    // Relationships
    public function jobs()    { return $this->hasMany(Job::class, 'company_id'); }
    public function applications() { return $this->hasMany(Application::class); }
    public function resume()  { return $this->hasOne(Resume::class); }
}

