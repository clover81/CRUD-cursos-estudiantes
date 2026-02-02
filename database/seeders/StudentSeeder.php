<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::truncate();

        $daw1 = Course::where('name', 'DAW 1')->first();
        $daw2 = Course::where('name', 'DAW 2')->first();

        if ($daw1) {
            Student::create(['name' => 'Ana', 'email' => 'ana@example.com', 'course_id' => $daw1->id]);
            Student::create(['name' => 'Luis', 'email' => 'luis@example.com', 'course_id' => $daw1->id]);
        }

        if ($daw2) {
            Student::create(['name' => 'Marta', 'email' => 'marta@example.com', 'course_id' => $daw2->id]);
        }
    }
}
