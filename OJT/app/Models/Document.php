<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['internship_id','type','file_path','generated_by','generated_at'];

    protected $dates = ['generated_at'];

    public function internship() { return $this->belongsTo(Internship::class); }
    public function generator() { return $this->belongsTo(User::class,'generated_by'); }
}