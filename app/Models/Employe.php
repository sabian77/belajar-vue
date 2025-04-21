<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;          

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employes';
    protected $fillable = ['name', 'nik', 'email','status', 'phone', 'address', 'division_id', 'job_id', 'foto'];

    public function job()
    {
        return $this->hasMany(Job::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}