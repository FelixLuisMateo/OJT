<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run()
    {
        Course::create([
            'code' => 'BSIT',
            'name' => 'Bachelor of Science in Information Technology',
            'internal_required_hours' => 240,
            'external_required_hours' => 240,
        ]);

        Course::create([
            'code' => 'BSCS',
            'name' => 'Bachelor of Science in Computer Science',
            'internal_required_hours' => 240,
            'external_required_hours' => 240,
        ]);
    }
}