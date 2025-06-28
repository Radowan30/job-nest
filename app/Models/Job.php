<?php
// app/Models/Job.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title','description','company_id'];

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
