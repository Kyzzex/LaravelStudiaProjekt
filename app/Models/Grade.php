<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['grade', 'student_id', 'subject_id', 'creator_type', 'creator_id'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function creator(): MorphTo {
        return $this->morphTo('creator');
    }

    public function history(): hasMany {
        return $this->hasMany(GradeHistory::class);
    }
}
