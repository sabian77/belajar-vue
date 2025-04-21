<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';
    protected $fillable = ['name', 'deskripsi'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
