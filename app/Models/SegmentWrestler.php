<?php

namespace Efed\Models;

use Illuminate\Database\Eloquent\Model;

class SegmentWrestler extends Model
{
    /**
     * Table name.
     */
    protected $table = 'eventSegmentWrestler';

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = ['segment_id', 'wrestler_id', 'team_id'];
    
    /**
     * One to one relationship with wrestler.
     */
    public function wrestler()
    {
        return $this->hasOne('Efed\Models\Wrestler', 'id', 'wrestler_id');
    }
}
