<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['internship_id','evaluator_id','rating','comments'];

    public function internship() { return $this->belongsTo(Internship::class); }
    public function evaluator() { return $this->belongsTo(User::class,'evaluator_id'); }
}