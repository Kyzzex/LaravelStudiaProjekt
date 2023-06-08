<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->create()->user()->create([
            ...User::factory()->definition(),
            'name' => 'Admin User',
            'email' => 'admin@example.com'
        ]);
        Teacher::factory()->create()->user()->create([
            ...User::factory()->definition(),
            'name' => 'Teacher User',
            'email' => 'teacher@example.com'
        ]);
        Student::factory()->create()->user()->create([
            ...User::factory()->definition(),
            'name' => 'Student User',
            'email' => 'student@example.com'
        ]);

        Teacher::factory(4)->create()->each(function (Teacher $teacher) {
            $teacher->user()->create(User::factory()->definition());
        });
        Student::factory(49)->create()->each(function (Student $student) {
            $student->user()->create(User::factory()->definition());
        });
    }
}
