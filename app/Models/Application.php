<?php
// app/Models/Application.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['user_id','job_id','status'];

    // Default status 'pending' on creation
    protected $attributes = ['status' => 'pending'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
