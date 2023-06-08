<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Grade;
use App\Models\GradeHistory;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creators = collect(Admin::all())->concat(Teacher::all());
        Student::all()->each(function ($student) use ($creators) {
            Grade::factory(10)->create(function () use ($student, $creators) {
                $creator = $creators->random();
                return [
                    'subject_id' => Subject::all()->random(),
                    'student_id' => $student->id,
                    'creator_id' => $creator->id,
                    'creator_type' => $creator::class
                ];
            })->each(function ($grade) {
                GradeHistory::factory(rand(0, 3))->create([
                    'grade_id' => $grade->id,
                    'creator_id' => $grade->creator_id,
                    'creator_type' => $grade->creator_type
                ]);
            });
        });
    }
}
