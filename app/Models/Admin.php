<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Admin extends Model
{
    use HasFactory;

    public function user(): MorphOne {
        return $this->morphOne(User::class, 'userable');
    }

    public function grades(): MorphMany
    {
        return $this->morphMany(Grade::class, 'creator');
    }
}
