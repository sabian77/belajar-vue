<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $table = 'employee_jobs';
    protected $fillable = ['name', 'deskripsi', 'employe_id'];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
