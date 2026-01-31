<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name','email','password','role','course_id','department_id','student_number','biometric_registered'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isCoordinator()
    {
        return $this->role === 'coordinator';
    }

    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}