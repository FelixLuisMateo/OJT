<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;

class UserSeeder extends Seeder
{
    public function run()
    {
        // create a course to assign to coordinator/student
        $course = Course::first() ?? Course::create([
            'code' => 'BSIT',
            'name' => 'Bachelor of Science in Information Technology',
            'internal_required_hours' => 240,
            'external_required_hours' => 240,
        ]);

        // Admin
        User::create([
            'name' => 'CCST Admin',
            'email' => 'admin@ccst.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Coordinator assigned to BSIT
        User::create([
            'name' => 'BSIT Coordinator',
            'email' => 'coordinator@ccst.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'coordinator',
            'course_id' => $course->id,
        ]);

        // Example supervisor
        User::create([
            'name' => 'Jane Supervisor',
            'email' => 'supervisor@ccst.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
        ]);

        // Example student
        User::create([
            'name' => 'Sample Student',
            'email' => 'student@ccst.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
            'course_id' => $course->id,
            'student_number' => '2026-0001-CCST',
        ]);
    }
}