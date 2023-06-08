<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GradeHistory extends Model
{
    use HasFactory;

    protected $fillable = ['grade_id', 'from', 'creator_type', 'creator_id'];

    public function creator(): MorphTo {
        return $this->morphTo('creator');
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}
