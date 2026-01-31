<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','internal_required_hours','external_required_hours'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}