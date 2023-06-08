<?php

namespace App\Observers;

use App\Models\Grade;

class GradeObserver
{

    /**
     * Handle the Grade "updated" event.
     */
    public function updated(Grade $grade): void
    {
        $grade->history()->create([
            'from' => $grade->getOriginal('grade'),
            'creator_id' => $grade->getOriginal('creator_id'),
            'creator_type' => $grade->getOriginal('creator_type')
        ]);
    }
}
