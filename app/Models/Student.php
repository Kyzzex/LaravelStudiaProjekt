<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id'
    ];

    public function user(): MorphOne {
        return $this->morphOne(User::class, 'userable');
    }

    public function group(): BelongsTo {
        return $this->belongsTo(Group::class);
    }

    public function grades(): HasMany {
        return $this->hasMany(Grade::class);
    }
}
