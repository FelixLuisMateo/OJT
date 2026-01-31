<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::create(['name' => 'Information Technology']);
        Department::create(['name' => 'Computer Science']);
        Department::create(['name' => 'Humanities']);
    }
}