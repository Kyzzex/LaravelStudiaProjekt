<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::factory(10)->create()->each(function (Subject $subject) {
            $subject->groups()->saveMany(Group::all()->random(random_int(2, 5)));
        });
    }
}
