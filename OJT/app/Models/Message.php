<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['from_user_id','to_user_id','subject','body','related_internship_id','read_at'];

    public function from() { return $this->belongsTo(User::class,'from_user_id'); }
    public function to() { return $this->belongsTo(User::class,'to_user_id'); }
    public function internship() { return $this->belongsTo(Internship::class,'related_internship_id'); }
}