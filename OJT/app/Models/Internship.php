<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id','course_id','assignment_type','supervisor_id','department_id',
        'company_name','start_date','end_date','location','status','rendered_hours','required_hours'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function student() { return $this->belongsTo(User::class,'student_id'); }
    public function supervisor() { return $this->belongsTo(User::class,'supervisor_id'); }
    public function dtrs() { return $this->hasMany(Dtr::class); }
    public function evaluations() { return $this->hasMany(Evaluation::class); }
    public function documents() { return $this->hasMany(Document::class); }
    public function course() { return $this->belongsTo(Course::class); }
}