<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biometric extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','template_data','device_id','registered_at'];

    protected $dates = ['registered_at'];

    public function user() { return $this->belongsTo(User::class); }
}