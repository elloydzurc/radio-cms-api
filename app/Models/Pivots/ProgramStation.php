<?php
declare(strict_types=1);

namespace App\Models\Pivots;

use App\Models\Content;
use App\Models\Program;
use App\Models\Station;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProgramStation extends Pivot
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function contents(): HasManyThrough
    {
        return $this->hasManyThrough(Content::class, Program::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }
}