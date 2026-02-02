<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create(['name' => 'DAW 1', 'description' => 'Primero de DAW']);
        Course::create(['name' => 'DAW 2', 'description' => 'Segundo de DAW']);
        Course::create(['name' => 'ASIR 1', 'description' => 'Primero de ASIR']);
    }
}
