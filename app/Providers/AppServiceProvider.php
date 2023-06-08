<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Observers\GradeObserver;
use Blade;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'student' => Student::class,
            'teacher' => Teacher::class,
            'admin' => Admin::class
        ]);

        Blade::if('role', function (string ...$roles) {
            return collect($roles)->contains(auth()->user()->userable_type);
        });

        Grade::observe(GradeObserver::class);
    }
}
